<?
	if($GVSaveBtn)
	{
		include("gv_header.php");
		GVmasterAuth();
	
		if($GVSTEP == "DELETE")
		{
			$MySelectQry = "select customer_code,customer_name from customer_info where";
			$MySelectQry .= " company_id=?";MYSQL_BuildArray("company_id",$company_id,"s");
			$MySelectQry .= " and customer_id=?";MYSQL_BuildArray("customer_id",$GVID,"s");
			$MyDbResult =  MyDbQuery($MySelectQry,$_GVParamArray);	
			if($MyRowData = mysqli_fetch_array($MyDbResult, MYSQLI_ASSOC)) 
			{
				$customer_code = GVStringFormat($MyRowData['customer_code']);
				$customer_name = GVStringFormat($MyRowData['customer_name']);
				
				$MyDeleteQry = "delete from customer_info where ";
				$MyDeleteQry .= " company_id=?";MYSQL_BuildArray("company_id",$company_id,"s");
				$MyDeleteQry .= " and customer_id=?";MYSQL_BuildArray("customer_id",$GVID,"s");
				MyDbQuery($MyDeleteQry, $_GVParamArray);
				
				$gv_action = "$customer_name ($customer_code) - Customer Information Deleted";
				include("gv_action_history.php");
			}
			MyDbFreeResult($MyDbResult);
		}	
		
		GVPopSaveLoad();
		
		include("gv_footer.php");
	}
?>