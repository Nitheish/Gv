<?
	include("gv_header.php");
	
	$ErrorInd = 0;
	$GVErrorSummary = array();
	$old_session_key = "";
	$gv_account_key = "";
	$company_id = "";
	$lasttime = 0;
	$txtUserName = GVfixedInputText($txtUserName);
	$txtPassWord = GVfixedInputText($txtPassWord);
	
	if(strlen($txtUserName) == 0)
	{
		GVSetErrorCodes("txtUserName","Please enter valid user name");
	}
	
	if(strlen($txtPassWord) == 0)
	{
		GVSetErrorCodes("txtPassWord","Please enter valid password");
	}
	
	if($ErrorInd == 0)
	{
		$MySelectQry = "select gv_login_id,gv_account_key,gv_session_key,lasttime,company_id,gv_username,gv_password,'".GVgenerateStringKEY($txtUserName,$txtPassWord)."' as gvPwdCrt from gv_login where";
		$MySelectQry .= " gv_username=?";MYSQL_BuildArray("gv_username",$txtUserName,"s");
		$MyDbResult =  MyDbQuery($MySelectQry,$_GVParamArray);
		$MyNumRows = MyDbNumRows($MyDbResult);
		if($MyNumRows > 0)
		{
			$MyRowData = mysqli_fetch_array($MyDbResult, MYSQLI_ASSOC);
			$gv_username = GVStringFormat($MyRowData['gv_username']);
			$gv_password = GVStringFormat($MyRowData['gv_password']);
			$gv_login_id = GVStringFormat($MyRowData['gv_login_id']);
			$gvPwdCrt = GVStringFormat($MyRowData['gvPwdCrt']);
			$old_session_key = GVStringFormat($MyRowData['gv_session_key']);
			$gv_account_key = GVStringFormat($MyRowData['gv_account_key']);
			$company_id = GVStringFormat($MyRowData['company_id']);
			$lasttime = GVStringFormat($MyRowData['lasttime']);
			
			$company_code = "";
			$MySelectQry = "select company_code from gv_company_info where";
			$MySelectQry .= " company_id=?";MYSQL_BuildArray("company_id",$company_id,"s");
			$MyDbSubResult =  MyDbQuery($MySelectQry,$_GVParamArray);	
			if($MyRowSubData = mysqli_fetch_array($MyDbSubResult, MYSQLI_ASSOC))
			{
				$company_code = strtoupper(GVStringFormat($MyRowSubData['company_code']));
			}
			MyDbFreeResult($MyDbSubResult);
			
			if($gv_password != GVStringFormat(GVgenerateStringKEY($gv_username,$txtPassWord)))
			{
				GVSetErrorCodes("txtPassWord","password Incorrect");
			}
			
			if($ErrorInd == 0 && strtoupper($txtCompanyCode) != $company_code)
			{
				//GVSetErrorCodes("txtCompanyCode","Please enter the valid Company Code");
			}
			
			if($ErrorInd == 0 && strtoupper($txtCaptcha) != $CaptchaVal)
			{
				GVSetErrorCodes("txtCaptcha","Please enter the valid Captcha");
			}
		}
		else
		{
			GVSetErrorCodes("txtUserName","Invalid login");
		}
	}
	
	if($ErrorInd == 0)
	{
		$currentTime = strtotime("now");
		$last_logon = GVGetCurrentDateTime();
		$gv_session_key = GVgenerateRandomKEY();
		
		$_GVParamArray[] = array("KEY"=>"last_logon", "VAL"=>$last_logon, "TYPE"=>"s");
		$_GVParamArray[] = array("KEY"=>"lasttime", "VAL"=>$currentTime, "TYPE"=>"s");
		$_GVParamArray[] = array("KEY"=>"gv_session_key", "VAL"=>$gv_session_key, "TYPE"=>"s");
		
		$outParamArr = GVgetQueryString($_GVParamArray);
		
		$MyUpdateQry = "update gv_login set ".$outParamArr['_UPDATE_SQLQRY_VAL']." where ";
		$MyUpdateQry .= "gv_session_key=?";MYSQL_BuildArray("gv_session_key",$old_session_key,"s");
		$MyUpdateQry .= " and gv_account_key=?";MYSQL_BuildArray("gv_account_key",$gv_account_key,"s");
		$MyUpdateQry .= " and company_id=?";MYSQL_BuildArray("company_id",$company_id,"s");
		MyDbQuery($MyUpdateQry, $_GVParamArray);
		
		$gv_action = "Logged in successfully";
		include("gv_action_history.php");
				
		$gvky = GVstringEncrption($gv_session_key.$gv_account_key);
		
		session_start();
		$_SESSION['gvky'] = $gvky;
		$_SESSION['gvid'] = GVstringEncrption("LoadHtmlPage=gv_dashboard");
		
		GVLoadPageDirect("../backend/gv_redirect");
		exit;
	}
	else
	{
		include("gv_footer.php");
		chdir($LOGINPATH);
		include("gv_sms.php");
		exit;
	}
?>