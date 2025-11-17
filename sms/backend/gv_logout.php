<?
	include("gv_header.php");
	GVmasterAuth();
	
	$new_session_key = GVgenerateRandomKEY();
			
	$_GVParamArray[] = array("KEY"=>"gv_session_key", "VAL"=>$new_session_key, "TYPE"=>"s");
	
	$outParamArr = GVgetQueryString($_GVParamArray);
	
	$MyUpdateQry = "update gv_login set ".$outParamArr['_UPDATE_SQLQRY_VAL']." where ";
	$MyUpdateQry .= " gv_session_key=?";MYSQL_BuildArray("gv_session_key",$gv_session_key,"s");
	$MyUpdateQry .= " and gv_account_key=?";MYSQL_BuildArray("gv_account_key",$gv_account_key,"s");
	$MyUpdateQry .= " and company_id=?";MYSQL_BuildArray("company_id",$company_id,"s");
	MyDbQuery($MyUpdateQry, $_GVParamArray);
	
	$gv_action = "Logged out successfully";
	include("gv_action_history.php");
	
	session_destroy();
	
	$LOGINPATH = $GLOBALS["LOGINPATH"];
	include("gv_footer.php");
	GVLoadPageDirect("../../gvlogin/gv_logout.php?".GVqueryString("frmProductLogin=SMS"));
	exit;
?>