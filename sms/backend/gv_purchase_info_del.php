<?
	if($GVSaveBtn)
	{
		include("gv_header.php");
		GVmasterAuth();
	
		if($GVSTEP == "DELETE")
		{
			$purchase_code = "";
			
			$MySelectQry = "select purchase_code from purchase_info where";
			$MySelectQry .= " company_id=?";MYSQL_BuildArray("company_id",$company_id,"s");
			$MySelectQry .= " and purchase_id=?";MYSQL_BuildArray("purchase_id",$GVID,"s");
			$MyDbResult =  MyDbQuery($MySelectQry,$_GVParamArray);	
			if($MyRowData = mysqli_fetch_array($MyDbResult, MYSQLI_ASSOC)) 
			{
				$purchase_code = GVStringFormat($MyRowData['purchase_code']);
			}
			MyDbFreeResult($MyDbResult);
			
			if($purchase_code != "")
			{
				$delProdIDArr = array();
				$MySelectQry = "select product_id from purchase_product where";
				$MySelectQry .= " company_id=?";MYSQL_BuildArray("company_id",$company_id,"s");
				$MySelectQry .= " and purchase_id=?";MYSQL_BuildArray("purchase_id",$GVID,"s");
				$MyDbResult =  MyDbQuery($MySelectQry,$_GVParamArray);
				while($MyRowData = mysqli_fetch_array($MyDbResult, MYSQLI_ASSOC)) 
				{
					$delProdIDArr[] = GVStringFormat($MyRowData['product_id']);
				}
				MyDbFreeResult($MyDbResult);
				
				if(count($delProdIDArr) > 0)
				{
					$MySelectQry = "select stock_info_id,product_id from stock_track where";
					$MySelectQry .= " company_id=?";MYSQL_BuildArray("company_id",$company_id,"s");
					$MySelectQry .= " and purchase_id=?";MYSQL_BuildArray("purchase_id",$GVID,"s");
					$MySelectQry .= " and product_id in (".MYSQL_ArrayBuild_String($delProdIDArr).")";MYSQL_BuildArray("product_id",$delProdIDArr,"s");
					$MySelectQry .= " and stock_type=?";MYSQL_BuildArray("stock_type","P","s");
					$MySelectQry .= " and delete_ind=?";MYSQL_BuildArray("delete_ind",'0',"s");
					$MyDbResultDel =  MyDbQuery($MySelectQry,$_GVParamArray);	
					while($MyRowDataDel = mysqli_fetch_array($MyDbResultDel, MYSQLI_ASSOC)) 
					{
						$stock_info_id = GVStringFormat($MyRowDataDel['stock_info_id']);
						$product_id = GVStringFormat($MyRowDataDel['product_id']);
						
						$MyDeleteQry = "delete from stock_track where ";
						$MyDeleteQry .= " company_id=?";MYSQL_BuildArray("company_id",$company_id,"s");
						$MyDeleteQry .= " and purchase_id=?";MYSQL_BuildArray("purchase_id",$GVID,"s");
						$MyDeleteQry .= " and product_id=?";MYSQL_BuildArray("product_id",$product_id,"s");
						$MyDeleteQry .= " and stock_info_id=?";MYSQL_BuildArray("stock_info_id",$stock_info_id,"s");
						MyDbQuery($MyDeleteQry, $_GVParamArray);
						
						$MyDeleteQry = "delete from stock_info where ";
						$MyDeleteQry .= " company_id=?";MYSQL_BuildArray("company_id",$company_id,"s");
						$MyDeleteQry .= " and purchase_id=?";MYSQL_BuildArray("purchase_id",$GVID,"s");
						$MyDeleteQry .= " and product_id=?";MYSQL_BuildArray("product_id",$product_id,"s");
						$MyDeleteQry .= " and stock_info_id=?";MYSQL_BuildArray("stock_info_id",$stock_info_id,"s");
						MyDbQuery($MyDeleteQry, $_GVParamArray);
						
						include("gv_product_track.php");
					}
					MyDbFreeResult($MyDbResultDel);
					
					$MyDeleteQry = "delete from purchase_product where ";
					$MyDeleteQry .= " company_id=?";MYSQL_BuildArray("company_id",$company_id,"s");
					$MyDeleteQry .= " and purchase_id=?";MYSQL_BuildArray("purchase_id",$GVID,"s");
					$MyDeleteQry .= " and product_id in (".MYSQL_ArrayBuild_String($delProdIDArr).")";MYSQL_BuildArray("product_id",$delProdIDArr,"s");
					MyDbQuery($MyDeleteQry, $_GVParamArray);
				}	
				
				$MyDeleteQry = "delete from purchase_info where ";
				$MyDeleteQry .= " company_id=?";MYSQL_BuildArray("company_id",$company_id,"s");
				$MyDeleteQry .= " and purchase_id=?";MYSQL_BuildArray("purchase_id",$GVID,"s");
				MyDbQuery($MyDeleteQry, $_GVParamArray);
				
				$gv_action = "$purchase_code - Purchase Information Deleted";
				include("gv_action_history.php");
			}
		}	
		
		GVPopSaveLoad();
		
		include("gv_footer.php");
	}
?>