<?
	$existingStockDetArr = array();
	
	if($GVSTEP == "EDIT")
	{
		$MySelectQry = "select product_id,stock_info_id from stock_track where";
		$MySelectQry .= " company_id=?";MYSQL_BuildArray("company_id",$company_id,"s");
		$MySelectQry .= " and purchase_id=?";MYSQL_BuildArray("purchase_id",$GVID,"s");
		$MySelectQry .= " and stock_type=?";MYSQL_BuildArray("stock_type","P","s");
		$MySelectQry .= " and delete_ind=?";MYSQL_BuildArray("delete_ind",'0',"s");
		$MyDbResult =  MyDbQuery($MySelectQry,$_GVParamArray);	
		while($MyRowData = mysqli_fetch_array($MyDbResult, MYSQLI_ASSOC)) 
		{
			$existingStockDetArr[GVStringFormat($MyRowData['product_id'])] = GVStringFormat($MyRowData['stock_info_id']);
		}
		MyDbFreeResult($MyDbResult);
	}
	
	foreach($productDetailsArr as $product_id=>$prodDetArr)
	{
		$txtQuantity = $prodDetArr["QTY"];
		$txtAmount = $prodDetArr["AMT"];
		$productName = $prodDetArr["NAME"];
		
		if($GVSTEP == "EDIT" && array_key_exists($product_id,$existingProdDetArr))
		{
			$existingProdQty = $existingProdDetArr[$product_id]; 
			$existingProdAmt = $existingProdAmtArr[$product_id]; 
			
			if($existingProdQty != $txtQuantity || $existingProdAmt != $txtAmount)
			{
				$purchase_price = GVformatAmount($txtAmount / $txtQuantity);
				
				$stock_info_id = $existingStockDetArr[$product_id];
				
				$_GVParamArray[] = array("KEY"=>"stock_qty", "VAL"=>$txtQuantity, "TYPE"=>"s");
				$_GVParamArray[] = array("KEY"=>"stock_count", "VAL"=>$txtQuantity, "TYPE"=>"s");
				$_GVParamArray[] = array("KEY"=>"purchase_price", "VAL"=>$purchase_price, "TYPE"=>"s");
				
				$outParamArr = GVgetQueryString($_GVParamArray);
			
				$MyUpdateQry = "update stock_info set ".$outParamArr['_UPDATE_SQLQRY_VAL']." where ";
				$MyUpdateQry .= " company_id=?";MYSQL_BuildArray("company_id",$company_id,"s");
				$MyUpdateQry .= " and purchase_id=?";MYSQL_BuildArray("purchase_id",$GVID,"s");
				$MyUpdateQry .= " and product_id=?";MYSQL_BuildArray("product_id",$product_id,"s");
				$MyUpdateQry .= " and stock_info_id=?";MYSQL_BuildArray("stock_info_id",$stock_info_id,"s");
				MyDbQuery($MyUpdateQry, $_GVParamArray);
				
				$_GVParamArray[] = array("KEY"=>"quantity", "VAL"=>$txtQuantity, "TYPE"=>"s");
				$_GVParamArray[] = array("KEY"=>"price", "VAL"=>$purchase_price, "TYPE"=>"s");
				$_GVParamArray[] = array("KEY"=>"total_amt", "VAL"=>$txtAmount, "TYPE"=>"s");
				$_GVParamArray[] = array("KEY"=>"prod_price", "VAL"=>$purchase_price, "TYPE"=>"s");
				$_GVParamArray[] = array("KEY"=>"tot_price", "VAL"=>$txtAmount, "TYPE"=>"s");
				
				$outParamArr = GVgetQueryString($_GVParamArray);
			
				$MyUpdateQry = "update stock_track set ".$outParamArr['_UPDATE_SQLQRY_VAL']." where ";
				$MyUpdateQry .= " company_id=?";MYSQL_BuildArray("company_id",$company_id,"s");
				$MyUpdateQry .= " and purchase_id=?";MYSQL_BuildArray("purchase_id",$GVID,"s");
				$MyUpdateQry .= " and product_id=?";MYSQL_BuildArray("product_id",$product_id,"s");
				$MyUpdateQry .= " and stock_info_id=?";MYSQL_BuildArray("stock_info_id",$stock_info_id,"s");
				MyDbQuery($MyUpdateQry, $_GVParamArray);
				
				include("gv_product_track.php");
			}
		}
		else
		{
			$purchase_price = GVformatAmount($txtAmount / $txtQuantity);
			
			$_GVParamArray[] = array("KEY"=>"company_id", "VAL"=>$company_id, "TYPE"=>"s");
			$_GVParamArray[] = array("KEY"=>"purchase_id", "VAL"=>$GVID, "TYPE"=>"s");
			$_GVParamArray[] = array("KEY"=>"product_id", "VAL"=>$product_id, "TYPE"=>"s");
			$_GVParamArray[] = array("KEY"=>"stock_qty", "VAL"=>$txtQuantity, "TYPE"=>"s");
			$_GVParamArray[] = array("KEY"=>"stock_count", "VAL"=>$txtQuantity, "TYPE"=>"s");
			$_GVParamArray[] = array("KEY"=>"purchase_price", "VAL"=>$purchase_price, "TYPE"=>"s");
			$outParamArr = GVgetQueryString($_GVParamArray);
			
			$MyInsertQry = "insert into stock_info (".$outParamArr['_INSERT_SQLQRY_FIELDS'].") values(".$outParamArr['_INSERT_SQLQRY_VAL'].")";
			MyDbQuery($MyInsertQry, $_GVParamArray);
			
			$stock_info_id = 0;
			$MySelectQry = "select max(stock_info_id) as stock_info_id from stock_info where";
			$MySelectQry .= " company_id=?";MYSQL_BuildArray("company_id",$company_id,"s");
			$MySelectQry .= " and purchase_id=?";MYSQL_BuildArray("product_id",$GVID,"s");
			$MySelectQry .= " and product_id=?";MYSQL_BuildArray("product_id",$product_id,"s");
			$MyDbResult =  MyDbQuery($MySelectQry,$_GVParamArray);	
			if($MyRowData = mysqli_fetch_array($MyDbResult, MYSQLI_ASSOC)) 
			{
				$stock_info_id = GVStringFormat($MyRowData['stock_info_id']);
			}
			MyDbFreeResult($MyDbResult);
			
			$_GVParamArray[] = array("KEY"=>"company_id", "VAL"=>$company_id, "TYPE"=>"s");
			$_GVParamArray[] = array("KEY"=>"purchase_id", "VAL"=>$GVID, "TYPE"=>"s");
			$_GVParamArray[] = array("KEY"=>"product_id", "VAL"=>$product_id, "TYPE"=>"s");
			$_GVParamArray[] = array("KEY"=>"quantity", "VAL"=>$txtQuantity, "TYPE"=>"s");
			$_GVParamArray[] = array("KEY"=>"price", "VAL"=>$purchase_price, "TYPE"=>"s");
			$_GVParamArray[] = array("KEY"=>"total_amt", "VAL"=>$txtAmount, "TYPE"=>"s");
			$_GVParamArray[] = array("KEY"=>"stock_type", "VAL"=>"P", "TYPE"=>"s");
			$_GVParamArray[] = array("KEY"=>"stock_info_id", "VAL"=>$stock_info_id, "TYPE"=>"s");
			$_GVParamArray[] = array("KEY"=>"prod_price", "VAL"=>$purchase_price, "TYPE"=>"s");
			$_GVParamArray[] = array("KEY"=>"tot_price", "VAL"=>$txtAmount, "TYPE"=>"s");
			$outParamArr = GVgetQueryString($_GVParamArray);
			
			$MyInsertQry = "insert into stock_track (".$outParamArr['_INSERT_SQLQRY_FIELDS'].") values(".$outParamArr['_INSERT_SQLQRY_VAL'].")";
			MyDbQuery($MyInsertQry, $_GVParamArray);
			
			include("gv_product_track.php");
		}
	}
	
	if(count($delProdIDArr) > 0)
	{
		$MySelectQry = "select stock_info_id,product_id from stock_track where";
		$MySelectQry .= " company_id=?";MYSQL_BuildArray("company_id",$company_id,"s");
		$MySelectQry .= " and purchase_id=?";MYSQL_BuildArray("purchase_id",$GVID,"s");
		$MySelectQry .= " and product_id in (".MYSQL_ArrayBuild_String($delProdIDArr).")";MYSQL_BuildArray("product_id",$delProdIDArr,"s");
		$MySelectQry .= " and stock_type=?";MYSQL_BuildArray("stock_type","P","s");
		$MySelectQry .= " and delete_ind=?";MYSQL_BuildArray("delete_ind",'0',"s");
		$MyDbResultDEL =  MyDbQuery($MySelectQry,$_GVParamArray);	
		while($MyRowDataDEL = mysqli_fetch_array($MyDbResultDEL, MYSQLI_ASSOC)) 
		{
			$stock_info_id = GVStringFormat($MyRowDataDEL['stock_info_id']);
			$product_id = GVStringFormat($MyRowDataDEL['product_id']);
			
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
		MyDbFreeResult($MyDbResultDEL);
	}	
?>