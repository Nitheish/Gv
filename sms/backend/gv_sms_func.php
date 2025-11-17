<?
	if(!function_exists('GVmasterAuth'))
	{
		function GVmasterAuth()
		{
			$checkGVkey = GVStringFormat($GLOBALS["gvky"]);
			$checkGVkey = GVStringFormat(GVstringDecrption($checkGVkey));
			
			$gv_session_key = GVStringFormat(substr($checkGVkey,0,40));
			$gv_account_key = GVStringFormat(substr($checkGVkey,40));
			
			$MySelectQry = "select * from gv_login where ";
			$MySelectQry .= " gv_session_key=?";MYSQL_BuildArray("gv_session_key",$gv_session_key,"s");
			$MySelectQry .= " and gv_account_key=?";MYSQL_BuildArray("gv_account_key",$gv_account_key,"s");
			$MyDbResult =  MyDbQuery($MySelectQry,$GLOBALS["_GVParamArray"]);
			$MyNumRows = MyDbNumRows($MyDbResult);
			if($MyNumRows > 0)
			{
				$MyRowData = mysqli_fetch_array($MyDbResult, MYSQLI_ASSOC);
				$gv_username = GVStringFormat($MyRowData['gv_username']);
				$gv_login_id = GVStringFormat($MyRowData['gv_login_id']);
				$company_id = GVStringFormat($MyRowData['company_id']);
				$lasttime = GVStringFormat($MyRowData['lasttime']);
				$emp_name = GVStringFormat($MyRowData['emp_name']);
			}
			MyDbFreeResult($MyDbResult);
			
			$currentTime = strtotime("now");
			$TimeDiffer = $currentTime - $lasttime;
			
			if($TimeDiffer > 1800)
			{
				$new_session_key = GVgenerateRandomKEY();
				
				$GLOBALS["_GVParamArray"][] = array("KEY"=>"gv_session_key", "VAL"=>$new_session_key, "TYPE"=>"s");
				
				$outParamArr = GVgetQueryString($GLOBALS["_GVParamArray"]);
				
				$MyUpdateQry = "update gv_login set ".$outParamArr['_UPDATE_SQLQRY_VAL']." where ";
				$MyUpdateQry .= "gv_session_key=?";MYSQL_BuildArray("gv_session_key",$gv_session_key,"s");
				$MyUpdateQry .= " and gv_account_key=?";MYSQL_BuildArray("gv_account_key",$gv_account_key,"s");
				$MyUpdateQry .= " and company_id=?";MYSQL_BuildArray("company_id",$company_id,"s");
				MyDbQuery($MyUpdateQry, $GLOBALS["_GVParamArray"]);
			}
			
			if(strlen($checkGVkey) != 80 || $MyNumRows == 0 || $TimeDiffer > 1800)
			{
				session_destroy();
				global $sessionAjaxInd;
				
				if($sessionAjaxInd == 1)
				{
					$GLOBALS["SessionDATAStatus"] = "EXPIRED";
				}
				else
				{
					$LOGINPATH = $GLOBALS["LOGINPATH"];
					include("gv_footer.php");

					session_start();
					$_SESSION['frmProductLogin'] = "SMS";

					GVLoadPageDirect("../../gvlogin/gv_session_expired");
					exit;
				}
			}
			else
			{
				$GLOBALS["_GVParamArray"][] = array("KEY"=>"lasttime", "VAL"=>$currentTime, "TYPE"=>"s");
				
				$outParamArr = GVgetQueryString($GLOBALS["_GVParamArray"]);
				
				$MyUpdateQry = "update gv_login set ".$outParamArr['_UPDATE_SQLQRY_VAL']." where ";
				$MyUpdateQry .= " gv_session_key=?";MYSQL_BuildArray("gv_session_key",$gv_session_key,"s");
				$MyUpdateQry .= " and gv_account_key=?";MYSQL_BuildArray("gv_account_key",$gv_account_key,"s");
				$MyUpdateQry .= " and company_id=?";MYSQL_BuildArray("company_id",$company_id,"s");
				MyDbQuery($MyUpdateQry, $GLOBALS["_GVParamArray"]);
				
				$GLOBALS["company_id"] = $company_id;
				$GLOBALS["gv_username"] = $gv_username;
				$GLOBALS["gv_empname"] = $emp_name;
				$GLOBALS["gv_login_id"] = $gv_login_id;
			}
		}
	}
?>