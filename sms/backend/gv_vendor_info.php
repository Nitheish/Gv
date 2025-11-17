<?
	if($GVSaveBtn)
	{
		include("gv_header.php");
		GVmasterAuth();
	
		$LoadHtmlPage = "gv_vendor_info";
		$ErrorInd = 0;
		
		$txtVendorName = GVfixedInputText($txtVendorName);
		$txtVendorAddr1 = GVfixedInputText($txtVendorAddr1);
		$txtVendorAddr2 = GVfixedInputText($txtVendorAddr2);
		$txtVendorCity = GVfixedInputText($txtVendorCity);
		$txtVendorState = GVfixedInputText($txtVendorState);
		$txtVendorZip = GVfixedInputText($txtVendorZip);
		$txtVendorPhone = GVfixedInputText($txtVendorPhone);
		$txtVendorEmail = GVfixedInputText($txtVendorEmail);
		
		if(strlen($txtVendorName) == 0)
			GVSetErrorCodes("txtVendorName","Please enter the Vendor Name");
		
		if(strlen($txtVendorAddr1) == 0)
			GVSetErrorCodes("txtVendorAddr1","Please enter the Address line 1");
		
		if(strlen($txtVendorCity) == 0)
			GVSetErrorCodes("txtVendorCity","Please enter the City");
		
		if(strlen($txtVendorState) == 0)
			GVSetErrorCodes("txtVendorState","Please enter the State");
		
		if(strlen($txtVendorZip) == 0)
			GVSetErrorCodes("txtVendorZip","Please enter the postal Code");
			
		/*
		if(strlen($txtVendorEmail) == 0)
			GVSetErrorCodes("txtVendorEmail","Please enter the valid E-mail Address");
		
		if(strlen($txtVendorRef) == 0)
			GVSetErrorCodes("txtVendorRef","Please enter the Vendor Reference Name");
		*/	
		
		if(strlen($txtVendorPhone) != 10)
			GVSetErrorCodes("txtVendorPhone","Please enter the valid Phone Number");
		
		
		if($ErrorInd == 0)
		{
			if($GVSTEP == "ADD")
			{
				$_GVParamArray[] = array("KEY"=>"company_id", "VAL"=>$company_id, "TYPE"=>"s");
				$_GVParamArray[] = array("KEY"=>"vendor_name", "VAL"=>$txtVendorName, "TYPE"=>"s");
				$_GVParamArray[] = array("KEY"=>"vendor_addr1", "VAL"=>$txtVendorAddr1, "TYPE"=>"s");
				$_GVParamArray[] = array("KEY"=>"vendor_addr2", "VAL"=>$txtVendorAddr2, "TYPE"=>"s");
				$_GVParamArray[] = array("KEY"=>"vendor_city", "VAL"=>$txtVendorCity, "TYPE"=>"s");
				$_GVParamArray[] = array("KEY"=>"vendor_state", "VAL"=>$txtVendorState, "TYPE"=>"s");
				$_GVParamArray[] = array("KEY"=>"vendor_zip", "VAL"=>$txtVendorZip, "TYPE"=>"s");
				$_GVParamArray[] = array("KEY"=>"vendor_phone", "VAL"=>$txtVendorPhone, "TYPE"=>"s");
				$_GVParamArray[] = array("KEY"=>"vendor_email", "VAL"=>$txtVendorEmail, "TYPE"=>"s");
				$_GVParamArray[] = array("KEY"=>"vendor_reference", "VAL"=>$txtVendorRef, "TYPE"=>"s");
				
				$outParamArr = GVgetQueryString($_GVParamArray);
				
				$MyInsertQry = "insert into vendor_info (".$outParamArr['_INSERT_SQLQRY_FIELDS'].") values(".$outParamArr['_INSERT_SQLQRY_VAL'].")";
				MyDbQuery($MyInsertQry, $_GVParamArray);
				
				$MySelectQry = "select max(vendor_id) as MaxId from vendor_info where";
				$MySelectQry .= " company_id=?";MYSQL_BuildArray("company_id",$company_id,"s");
				$MyDbResult =  MyDbQuery($MySelectQry,$_GVParamArray);	
				if($MyRowData = mysqli_fetch_array($MyDbResult, MYSQLI_ASSOC)) 
				{
					$GVID = GVStringFormat($MyRowData['MaxId']);
				}
				MyDbFreeResult($MyDbResult);
				
				$GVSTEP = "EDIT";
				
				$vendorCode = "VD".$GVID;
				
				$_GVParamArray[] = array("KEY"=>"vendor_code", "VAL"=>$vendorCode, "TYPE"=>"s");
			
				$outParamArr = GVgetQueryString($_GVParamArray);
				
				$MyUpdateQry = "update vendor_info set ".$outParamArr['_UPDATE_SQLQRY_VAL']." where ";
				$MyUpdateQry .= " company_id=?";MYSQL_BuildArray("company_id",$company_id,"s");
				$MyUpdateQry .= " and vendor_id=?";MYSQL_BuildArray("vendor_id",$GVID,"s");
				MyDbQuery($MyUpdateQry, $_GVParamArray);
			}
			else
			{
				$_GVParamArray[] = array("KEY"=>"vendor_name", "VAL"=>$txtVendorName, "TYPE"=>"s");
				$_GVParamArray[] = array("KEY"=>"vendor_addr1", "VAL"=>$txtVendorAddr1, "TYPE"=>"s");
				$_GVParamArray[] = array("KEY"=>"vendor_addr2", "VAL"=>$txtVendorAddr2, "TYPE"=>"s");
				$_GVParamArray[] = array("KEY"=>"vendor_city", "VAL"=>$txtVendorCity, "TYPE"=>"s");
				$_GVParamArray[] = array("KEY"=>"vendor_state", "VAL"=>$txtVendorState, "TYPE"=>"s");
				$_GVParamArray[] = array("KEY"=>"vendor_zip", "VAL"=>$txtVendorZip, "TYPE"=>"s");
				$_GVParamArray[] = array("KEY"=>"vendor_phone", "VAL"=>$txtVendorPhone, "TYPE"=>"s");
				$_GVParamArray[] = array("KEY"=>"vendor_email", "VAL"=>$txtVendorEmail, "TYPE"=>"s");
				$_GVParamArray[] = array("KEY"=>"vendor_reference", "VAL"=>$txtVendorRef, "TYPE"=>"s");
				
				$outParamArr = GVgetQueryString($_GVParamArray);
				
				$MyUpdateQry = "update vendor_info set ".$outParamArr['_UPDATE_SQLQRY_VAL']." where ";
				$MyUpdateQry .= " company_id=?";MYSQL_BuildArray("company_id",$company_id,"s");
				$MyUpdateQry .= " and vendor_id=?";MYSQL_BuildArray("vendor_id",$GVID,"s");
				MyDbQuery($MyUpdateQry, $_GVParamArray);
			}
			
			if($GVsubMenu == "FRMPURCHASE")
			{
				$comboValue = $txtVendorName." ( ".$txtVendorPhone." )";
				
				?>
				<script type='text/javascript'>
				var _text = '<? echo $comboValue; ?>';
				var _value = '<? echo $GVID; ?>';
				var _iFrame = parent.document.getElementById('GVmainFrame');
				var _controlContent = _iFrame.contentWindow.document;
				var _control = _controlContent.getElementById('cboVendor');
				_control.append(new Option(_text, _value)); 
				_control.value = _value;
				</script>
				<?
				
				GVPopClose();
			}
			else
			{
				GVPopSaveLoad();
			}
		}
		else
		{
			include("../html/".$LoadHtmlPage.".html");
		}
		
		include("gv_footer.php");
	}
?>