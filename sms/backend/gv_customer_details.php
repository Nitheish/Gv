<?
	if($GVSaveBtn)
	{
		include("gv_header.php");
		GVmasterAuth();
	
		$LoadHtmlPage = "gv_customer_details";
		$ErrorInd = 0;
		
		$txtCustomerName = GVfixedInputText($txtCustomerName);
		$txtCustomerAddr1 = GVfixedInputText($txtCustomerAddr1);
		$txtCustomerAddr2 = GVfixedInputText($txtCustomerAddr2);
		$txtCustomerCity = GVfixedInputText($txtCustomerCity);
		$txtCustomerState = GVfixedInputText($txtCustomerState);
		$txtCustomerZip = GVfixedInputText($txtCustomerZip);
		$txtCustomerPhone = GVfixedInputText($txtCustomerPhone);
		$txtCustomerEmail = GVfixedInputText($txtCustomerEmail);
		
		if(strlen($txtCustomerName) == 0)
			GVSetErrorCodes("txtCustomerName","Please enter the Customer Name");
		
		/*if(strlen($txtCustomerAddr1) == 0)
			GVSetErrorCodes("txtCustomerAddr1","Please enter the Address line 1");
		
		if(strlen($txtCustomerCity) == 0)
			GVSetErrorCodes("txtCustomerCity","Please enter the City");
		
		if(strlen($txtCustomerState) == 0)
			GVSetErrorCodes("txtCustomerState","Please enter the State");
		
		if(strlen($txtCustomerZip) == 0)
			GVSetErrorCodes("txtCustomerZip","Please enter the postal Code");
			
		if(strlen($txtCustomerEmail) == 0)
			GVSetErrorCodes("txtCustomerEmail","Please enter the valid E-mail Address");
		
		if(strlen($txtCustomerRef) == 0)
			GVSetErrorCodes("txtCustomerRef","Please enter the Customer Reference Name");
		*/	
		
		if(strlen($txtCustomerPhone) != 10)
			GVSetErrorCodes("txtCustomerPhone","Please enter the valid Phone Number");
		
		$MySelectQry = "select * from customer_info where";
		$MySelectQry .= " company_id=?";MYSQL_BuildArray("company_id",$company_id,"s");
		
		if($GVSTEP == "EDIT")
		{
			$MySelectQry .= " and customer_id!=?";MYSQL_BuildArray("customer_id",$GVID,"s");
		}
		
		$MySelectQry .= " and customer_name=?";MYSQL_BuildArray("customer_name",$txtCustomerName,"s");
		$MySelectQry .= " and customer_phone=?";MYSQL_BuildArray("customer_phone",$txtCustomerPhone,"s");
		$MyDbResult =  MyDbQuery($MySelectQry,$_GVParamArray);
		$MyNumRows = MyDbNumRows($MyDbResult);	
		MyDbFreeResult($MyDbResult);
		
		if($MyNumRows > 0)
		{
			GVSetErrorCodes("txtCustomerName","Customer details already exists");
		}
		
		if($ErrorInd == 0)
		{
			if($GVSTEP == "ADD")
			{
				$_GVParamArray[] = array("KEY"=>"company_id", "VAL"=>$company_id, "TYPE"=>"s");
				$_GVParamArray[] = array("KEY"=>"customer_name", "VAL"=>$txtCustomerName, "TYPE"=>"s");
				$_GVParamArray[] = array("KEY"=>"customer_addr1", "VAL"=>$txtCustomerAddr1, "TYPE"=>"s");
				$_GVParamArray[] = array("KEY"=>"customer_addr2", "VAL"=>$txtCustomerAddr2, "TYPE"=>"s");
				$_GVParamArray[] = array("KEY"=>"customer_city", "VAL"=>$txtCustomerCity, "TYPE"=>"s");
				$_GVParamArray[] = array("KEY"=>"customer_state", "VAL"=>$txtCustomerState, "TYPE"=>"s");
				$_GVParamArray[] = array("KEY"=>"customer_zip", "VAL"=>$txtCustomerZip, "TYPE"=>"s");
				$_GVParamArray[] = array("KEY"=>"customer_phone", "VAL"=>$txtCustomerPhone, "TYPE"=>"s");
				$_GVParamArray[] = array("KEY"=>"customer_email", "VAL"=>$txtCustomerEmail, "TYPE"=>"s");
				$_GVParamArray[] = array("KEY"=>"customer_reference", "VAL"=>$txtCustomerRef, "TYPE"=>"s");
				
				$outParamArr = GVgetQueryString($_GVParamArray);
				
				$MyInsertQry = "insert into customer_info (".$outParamArr['_INSERT_SQLQRY_FIELDS'].") values(".$outParamArr['_INSERT_SQLQRY_VAL'].")";
				MyDbQuery($MyInsertQry, $_GVParamArray);
				
				$MySelectQry = "select max(customer_id) as MaxId from customer_info where";
				$MySelectQry .= " company_id=?";MYSQL_BuildArray("company_id",$company_id,"s");
				$MyDbResult =  MyDbQuery($MySelectQry,$_GVParamArray);	
				if($MyRowData = mysqli_fetch_array($MyDbResult, MYSQLI_ASSOC)) 
				{
					$GVID = GVStringFormat($MyRowData['MaxId']);
				}
				MyDbFreeResult($MyDbResult);
				
				$GVSTEP = "EDIT";
				
				$custCode = "CR".$GVID;
				
				$_GVParamArray[] = array("KEY"=>"customer_code", "VAL"=>$custCode, "TYPE"=>"s");
			
				$outParamArr = GVgetQueryString($_GVParamArray);
				
				$MyUpdateQry = "update customer_info set ".$outParamArr['_UPDATE_SQLQRY_VAL']." where ";
				$MyUpdateQry .= " company_id=?";MYSQL_BuildArray("company_id",$company_id,"s");
				$MyUpdateQry .= " and customer_id=?";MYSQL_BuildArray("customer_id",$GVID,"s");
				MyDbQuery($MyUpdateQry, $_GVParamArray);
			}
			else
			{
				$_GVParamArray[] = array("KEY"=>"customer_name", "VAL"=>$txtCustomerName, "TYPE"=>"s");
				$_GVParamArray[] = array("KEY"=>"customer_addr1", "VAL"=>$txtCustomerAddr1, "TYPE"=>"s");
				$_GVParamArray[] = array("KEY"=>"customer_addr2", "VAL"=>$txtCustomerAddr2, "TYPE"=>"s");
				$_GVParamArray[] = array("KEY"=>"customer_city", "VAL"=>$txtCustomerCity, "TYPE"=>"s");
				$_GVParamArray[] = array("KEY"=>"customer_state", "VAL"=>$txtCustomerState, "TYPE"=>"s");
				$_GVParamArray[] = array("KEY"=>"customer_zip", "VAL"=>$txtCustomerZip, "TYPE"=>"s");
				$_GVParamArray[] = array("KEY"=>"customer_phone", "VAL"=>$txtCustomerPhone, "TYPE"=>"s");
				$_GVParamArray[] = array("KEY"=>"customer_email", "VAL"=>$txtCustomerEmail, "TYPE"=>"s");
				$_GVParamArray[] = array("KEY"=>"customer_reference", "VAL"=>$txtCustomerRef, "TYPE"=>"s");
				
				$outParamArr = GVgetQueryString($_GVParamArray);
				
				$MyUpdateQry = "update customer_info set ".$outParamArr['_UPDATE_SQLQRY_VAL']." where ";
				$MyUpdateQry .= " company_id=?";MYSQL_BuildArray("company_id",$company_id,"s");
				$MyUpdateQry .= " and customer_id=?";MYSQL_BuildArray("customer_id",$GVID,"s");
				MyDbQuery($MyUpdateQry, $_GVParamArray);
			}
			
			if($GVsubMenu == "FRMSALES")
			{
				$comboValue = $txtCustomerName." ( ".$txtCustomerPhone." )";
				
				?>
				<script type='text/javascript'>
				var _text = '<? echo $comboValue; ?>';
				var _value = '<? echo $GVID; ?>';
				var _iFrame = parent.document.getElementById('GVmainFrame');
				var _controlContent = _iFrame.contentWindow.document;
				var _control = _controlContent.getElementById('cboCustomer');
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
	}
?>