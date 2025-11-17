<?
	if($GVSaveBtn)
	{
		include("gv_header.php");
		GVmasterAuth();
	
		$LoadHtmlPage = "gv_company_info";
		$ErrorInd = 0;
		
		$txtCompanyName = GVfixedInputText($txtCompanyName);
		$txtCompanyAddr1 = GVfixedInputText($txtCompanyAddr1);
		$txtCompanyAddr2 = GVfixedInputText($txtCompanyAddr2);
		$txtCompanyCity = GVfixedInputText($txtCompanyCity);
		$txtCompanyState = GVfixedInputText($txtCompanyState);
		$txtCompanyZip = GVfixedInputText($txtCompanyZip);
		$txtCompanyPhone = GVfixedInputText($txtCompanyPhone);
		$txtCompanyEmail = GVfixedInputText($txtCompanyEmail);
		
		if(strlen($txtCompanyName) == 0)
			GVSetErrorCodes("txtCompanyName","Please enter the Company Name");
		
		if(strlen($txtCompanyAddr1) == 0)
			GVSetErrorCodes("txtCompanyAddr1","Please enter the Address line 1");
		
		if(strlen($txtCompanyCity) == 0)
			GVSetErrorCodes("txtCompanyCity","Please enter the City");
		
		if(strlen($txtCompanyState) == 0)
			GVSetErrorCodes("txtCompanyState","Please enter the State");
		
		if(strlen($txtCompanyZip) == 0)
			GVSetErrorCodes("txtCompanyZip","Please enter the postal Code");
		
		if(strlen($txtCompanyPhone) == 0)
			GVSetErrorCodes("txtCompanyPhone","Please enter the valid Phone Number");
		
		if(strlen($txtCompanyEmail) == 0)
			GVSetErrorCodes("txtCompanyEmail","Please enter the valid E-mail Address");
		
		if($ErrorInd == 0)
		{
			$existCompanyCode = "";
			$existCompanyName = "";
			$existCompanyAddr1 = "";
			$existCompanyAddr2 = "";
			$existCompanyCity = "";
			$existCompanyState = "";
			$existCompanyZip = "";
			$existCompanyPhone = "";
			$existCompanyEmail = "";
				
			$MySelectQry = "select * from gv_company_info where";
			$MySelectQry .= " company_id=?";MYSQL_BuildArray("company_id",$company_id,"s");
			$MyDbResult =  MyDbQuery($MySelectQry,$_GVParamArray);	
			$MyNumRows = MyDbNumRows($MyDbResult);
			if($MyRowData = mysqli_fetch_array($MyDbResult, MYSQLI_ASSOC))
			{
				$existCompanyName = GVStringFormat($MyRowData['company_name']);
				$existCompanyAddr1 = GVStringFormat($MyRowData['company_addr1']);
				$existCompanyAddr2 = GVStringFormat($MyRowData['company_addr2']);
				$existCompanyCity = GVStringFormat($MyRowData['company_city']);
				$existCompanyState = GVStringFormat($MyRowData['company_state']);
				$existCompanyZip = GVStringFormat($MyRowData['company_zip']);
				$existCompanyPhone = GVStringFormat($MyRowData['company_phone']);
				$existCompanyEmail = GVStringFormat($MyRowData['company_email']);
			}
			MyDbFreeResult($MyDbResult);
			
			if($existCompanyName != $txtCompanyName || $existCompanyAddr1 != $txtCompanyAddr1 || $existCompanyAddr2 != $txtCompanyAddr2 || $existCompanyCity != $txtCompanyCity
			|| $existCompanyState != $txtCompanyState || $existCompanyZip != $txtCompanyZip || $existCompanyPhone != $txtCompanyPhone || $existCompanyEmail != $txtCompanyEmail)
			{
				if($existCompanyName != $txtCompanyName)
				$_GVParamArray[] = array("KEY"=>"company_name", "VAL"=>$txtCompanyName, "TYPE"=>"s");
				
				if($existCompanyAddr1 != $txtCompanyAddr1)
				$_GVParamArray[] = array("KEY"=>"company_addr1", "VAL"=>$txtCompanyAddr1, "TYPE"=>"s");
				
				if($existCompanyAddr2 != $txtCompanyAddr2)
				$_GVParamArray[] = array("KEY"=>"company_addr2", "VAL"=>$txtCompanyAddr2, "TYPE"=>"s");
				
				if($existCompanyCity != $txtCompanyCity)
				$_GVParamArray[] = array("KEY"=>"company_city", "VAL"=>$txtCompanyCity, "TYPE"=>"s");
				
				if($existCompanyState != $txtCompanyState)
				$_GVParamArray[] = array("KEY"=>"company_state", "VAL"=>$txtCompanyState, "TYPE"=>"s");
				
				if($existCompanyZip != $txtCompanyZip)
				$_GVParamArray[] = array("KEY"=>"company_zip", "VAL"=>$txtCompanyZip, "TYPE"=>"s");
				
				if($existCompanyPhone != $txtCompanyPhone)
				$_GVParamArray[] = array("KEY"=>"company_phone", "VAL"=>$txtCompanyPhone, "TYPE"=>"s");
				
				if($existCompanyEmail != $txtCompanyEmail)
				$_GVParamArray[] = array("KEY"=>"company_email", "VAL"=>$txtCompanyEmail, "TYPE"=>"s");
				
				$outParamArr = GVgetQueryString($_GVParamArray);
				
				$MyUpdateQry = "update gv_company_info set ".$outParamArr['_UPDATE_SQLQRY_VAL']." where ";
				$MyUpdateQry .= " company_id=?";MYSQL_BuildArray("company_id",$company_id,"s");
				MyDbQuery($MyUpdateQry, $_GVParamArray);
				
				$gv_action = "Company Information Updated";
				include("gv_action_history.php");
				
				GVAlertMessage("Company Information Updated","SUCCESS");
			}
		}
		
		include("../html/".$LoadHtmlPage.".html");
		
		include("gv_footer.php");
	}
?>