<?
	$_GVParamArray[] = array("KEY"=>"company_id", "VAL"=>$company_id, "TYPE"=>"s");
	$_GVParamArray[] = array("KEY"=>"gv_login_id", "VAL"=>$gv_login_id, "TYPE"=>"s");
	$_GVParamArray[] = array("KEY"=>"action", "VAL"=>$gv_action, "TYPE"=>"s");
	
	$outParamArr = GVgetQueryString($_GVParamArray);
	
	$MyInsertQry = "insert into gv_action_history (".$outParamArr['_INSERT_SQLQRY_FIELDS'].") values(".$outParamArr['_INSERT_SQLQRY_VAL'].")";
	MyDbQuery($MyInsertQry, $_GVParamArray);
?>