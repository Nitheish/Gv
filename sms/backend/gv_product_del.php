<?
	if($GVSaveBtn)
	{
		include("gv_header.php");
		GVmasterAuth();
	
		if($GVSTEP == "DELETE")
		{
			$MySelectQry = "select product_code,product_name from product_info where";
			$MySelectQry .= " company_id=?";MYSQL_BuildArray("company_id",$company_id,"s");
			$MySelectQry .= " and product_id=?";MYSQL_BuildArray("product_id",$GVID,"s");
			$MyDbResult =  MyDbQuery($MySelectQry,$_GVParamArray);	
			if($MyRowData = mysqli_fetch_array($MyDbResult, MYSQLI_ASSOC)) 
			{
				$txtProductCode = GVStringFormat($MyRowData['product_code']);
				$txtProductName = GVStringFormat($MyRowData['product_name']);
				
				$MyDeleteQry = "delete from product_info where ";
				$MyDeleteQry .= " company_id=?";MYSQL_BuildArray("company_id",$company_id,"s");
				$MyDeleteQry .= " and product_id=?";MYSQL_BuildArray("product_id",$GVID,"s");
				MyDbQuery($MyDeleteQry, $_GVParamArray);
				
				$gv_action = "$txtProductName ($txtProductCode) - Product Information Deleted";
				include("gv_action_history.php");
			}
			MyDbFreeResult($MyDbResult);
		}	
		
		GVPopSaveLoad();
		
		include("gv_footer.php");
	}
?>