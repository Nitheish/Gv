<?
	if($GVSaveBtn)
	{
		include("gv_header.php");
		GVmasterAuth();
	
		if($GVSTEP == "DELETE")
		{
			$MySelectQry = "select vendor_code,vendor_name from vendor_info where";
			$MySelectQry .= " company_id=?";MYSQL_BuildArray("company_id",$company_id,"s");
			$MySelectQry .= " and vendor_id=?";MYSQL_BuildArray("vendor_id",$GVID,"s");
			$MyDbResult =  MyDbQuery($MySelectQry,$_GVParamArray);	
			if($MyRowData = mysqli_fetch_array($MyDbResult, MYSQLI_ASSOC)) 
			{
				$vendor_code = GVStringFormat($MyRowData['vendor_code']);
				$vendor_name = GVStringFormat($MyRowData['vendor_name']);
				
				$MyDeleteQry = "delete from vendor_info where ";
				$MyDeleteQry .= " company_id=?";MYSQL_BuildArray("company_id",$company_id,"s");
				$MyDeleteQry .= " and vendor_id=?";MYSQL_BuildArray("vendor_id",$GVID,"s");
				MyDbQuery($MyDeleteQry, $_GVParamArray);
				
				$gv_action = "$vendor_name ($vendor_code) - Vendor Information Deleted";
				include("gv_action_history.php");
			}
			MyDbFreeResult($MyDbResult);
		}	
		
		GVPopSaveLoad();
		
		include("gv_footer.php");
	}
?>