<?
	if($GVSaveBtn)
	{
		include("gv_header.php");
		GVmasterAuth();
	
		if($GVSTEP == "DELETE")
		{
			$MySelectQry = "select department_code,department_name from department_info where";
			$MySelectQry .= " company_id=?";MYSQL_BuildArray("company_id",$company_id,"s");
			$MySelectQry .= " and department_id =?";MYSQL_BuildArray("department_id ",$GVID,"s");
			$MyDbResult =  MyDbQuery($MySelectQry,$_GVParamArray);	
			if($MyRowData = mysqli_fetch_array($MyDbResult, MYSQLI_ASSOC)) 
			{
				$department_code = GVStringFormat($MyRowData['department_code']);
				$department_name = GVStringFormat($MyRowData['department_name']);
				
				$MyDeleteQry = "delete from department_info where ";
				$MyDeleteQry .= " company_id=?";MYSQL_BuildArray("company_id",$company_id,"s");
				$MyDeleteQry .= " and department_id =?";MYSQL_BuildArray("department_id ",$GVID,"s");
				MyDbQuery($MyDeleteQry, $_GVParamArray);
				
				$gv_action = "$department_name ($department_code) - Customer Information Deleted";
				include("gv_action_history.php");
			}
			MyDbFreeResult($MyDbResult);
		}	
		
		GVPopSaveLoad();
		
		include("gv_footer.php");
	}
?>