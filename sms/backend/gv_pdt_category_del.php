<?
	if($GVSaveBtn)
	{
		include("gv_header.php");
		GVmasterAuth();
	
		if($GVSTEP == "DELETE")
		{
			$MySelectQry = "select category_name from pdt_category_info where";
			$MySelectQry .= " company_id=?";MYSQL_BuildArray("company_id",$company_id,"s");
			$MySelectQry .= " and pdt_category_id=?";MYSQL_BuildArray("pdt_category_id",$GVID,"s");
			$MyDbResult =  MyDbQuery($MySelectQry,$_GVParamArray);	
			if($MyRowData = mysqli_fetch_array($MyDbResult, MYSQLI_ASSOC)) 
			{
				$txtCategoryName = GVStringFormat($MyRowData['category_name']);
				
				$MyDeleteQry = "delete from pdt_category_info where ";
				$MyDeleteQry .= " company_id=?";MYSQL_BuildArray("company_id",$company_id,"s");
				$MyDeleteQry .= " and pdt_category_id=?";MYSQL_BuildArray("pdt_category_id",$GVID,"s");
				MyDbQuery($MyDeleteQry, $_GVParamArray);
				
				$gv_action = "$txtCategoryName - Product Category Information Deleted";
				include("gv_action_history.php");
			}
			MyDbFreeResult($MyDbResult);
		}
		
		GVPopSaveLoad();
		
		include("gv_footer.php");
	}
?>