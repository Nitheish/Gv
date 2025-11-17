<?
	if($GVSaveBtn)
	{
		include("gv_header.php");
		GVmasterAuth();
	
		$LoadHtmlPage = "gv_passwrd_change";
		$ErrorInd = 0;
		
		$checkGVkey = $gvky;
		$checkGVkey = GVStringFormat(GVstringDecrption($checkGVkey));
		
		$gv_session_key = GVStringFormat(substr($checkGVkey,0,40));
		$gv_account_key = GVStringFormat(substr($checkGVkey,40));
		
		$gv_password = "";
				
		$MySelectQry = "select gv_password from gv_login where ";
		$MySelectQry .= " gv_session_key=?";MYSQL_BuildArray("gv_session_key",$gv_session_key,"s");
		$MySelectQry .= " and gv_account_key=?";MYSQL_BuildArray("gv_account_key",$gv_account_key,"s");
		$MySelectQry .= " and company_id=?";MYSQL_BuildArray("company_id",$company_id,"s");
		$MyDbResult =  MyDbQuery($MySelectQry,$_GVParamArray);
		$MyNumRows = MyDbNumRows($MyDbResult);
		if($MyNumRows > 0)
		{
			$MyRowData = mysqli_fetch_array($MyDbResult, MYSQLI_ASSOC);
			$gv_password = GVStringFormat($MyRowData['gv_password']);
		}
		MyDbFreeResult($MyDbResult);
				
		$txtNewPassword = GVfixedInputText($txtNewPassword);
		$txtConfirmPassword = GVfixedInputText($txtConfirmPassword);
		$txtOldPassword = GVfixedInputText($txtOldPassword);
		
		if(strlen($txtNewPassword) == 0)
			GVSetErrorCodes("txtNewPassword","New Password can't be empty");
		
		if(strlen($txtConfirmPassword) == 0)
			GVSetErrorCodes("txtConfirmPassword","Confirm Password can't be empty");
		
		if(strlen($txtOldPassword) == 0)
			GVSetErrorCodes("txtOldPassword","Old Password can't be empty");
		else if(GVStringFormat($gv_password) != GVStringFormat(GVgenerateStringKEY($gv_username,$txtOldPassword)))
			GVSetErrorCodes("txtOldPassword","Old Password Incorrect");
					
		if(strlen($txtOldPassword) > 0 && strlen($txtNewPassword) > 0 && $txtNewPassword == $txtOldPassword)
		{
			GVSetErrorCodes("txtNewPassword","New Password same as old password");
		}
		else if(strlen($txtNewPassword) > 0 && strlen($txtConfirmPassword) > 0 && $txtNewPassword != $txtConfirmPassword)
		{
			GVSetErrorCodes("txtNewPassword","New Password and Confirm Password does not match");
			GVSetErrorCodes("txtConfirmPassword","New Password and Confirm Password does not match");
		}
	
		if($ErrorInd == 0)
		{
			$NewPassword = GVStringFormat(GVgenerateStringKEY($gv_username,$txtNewPassword));
			
			$new_session_key = GVgenerateRandomKEY();
			
			$_GVParamArray[] = array("KEY"=>"gv_session_key", "VAL"=>$new_session_key, "TYPE"=>"s");
			$_GVParamArray[] = array("KEY"=>"gv_password", "VAL"=>$NewPassword, "TYPE"=>"s");
			
			$outParamArr = GVgetQueryString($_GVParamArray);
			
			$MyUpdateQry = "update gv_login set ".$outParamArr['_UPDATE_SQLQRY_VAL']." where ";
			$MyUpdateQry .= " gv_session_key=?";MYSQL_BuildArray("gv_session_key",$gv_session_key,"s");
			$MyUpdateQry .= " and gv_account_key=?";MYSQL_BuildArray("gv_account_key",$gv_account_key,"s");
			$MyUpdateQry .= " and company_id=?";MYSQL_BuildArray("company_id",$company_id,"s");
			MyDbQuery($MyUpdateQry, $_GVParamArray);
			
			$gv_action = "Login password updated";
			include("gv_action_history.php");
			
			$loginPwdReloginInd = 1;
		}
		
		include("../html/".$LoadHtmlPage.".html");
		
		include("gv_footer.php");
	}
?>