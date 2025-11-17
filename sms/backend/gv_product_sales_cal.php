<?
	$stockInfoIDArr = array();
	$stockInfoArr = array();
	
	$MySelectQry = "select stock_info_id,product_id,stock_count,purchase_price from stock_info where";
	$MySelectQry .= " company_id=?";MYSQL_BuildArray("company_id",$company_id,"s");
	$MySelectQry .= " and delete_ind=?";MYSQL_BuildArray("delete_ind",'0',"s");
	$MySelectQry .= " and product_id in (".MYSQL_ArrayBuild_String($currentProdIDArr).")";MYSQL_BuildArray("product_id",$currentProdIDArr,"s");
	$MySelectQry .= " and stock_count > ?";MYSQL_BuildArray("stock_count",'0',"s");
	$MySelectQry .= " order by create_datetime";
	$MyDbResult =  MyDbQuery($MySelectQry,$_GVParamArray);	
	while($MyRowData = mysqli_fetch_array($MyDbResult, MYSQLI_ASSOC)) 
	{
		$stockInfoArr[GVStringFormat($MyRowData['stock_info_id'])]["CNT"] = GVStringFormat($MyRowData['stock_count']);
		$stockInfoArr[GVStringFormat($MyRowData['stock_info_id'])]["PURCHASE"] =GVStringFormat($MyRowData['purchase_price']);
		$stockInfoIDArr[GVStringFormat($MyRowData['product_id'])][] = GVStringFormat($MyRowData['stock_info_id']); 
	}
	MyDbFreeResult($MyDbResult);
	
	$existingStockDetArr = array();
	
	if($GVSTEP == "EDIT")
	{
		$MySelectQry = "select stock_info_id,product_id,quantity,prod_price from stock_track where";
		$MySelectQry .= " company_id=?";MYSQL_BuildArray("company_id",$company_id,"s");
		$MySelectQry .= " and sales_id=?";MYSQL_BuildArray("sales_id",$GVID,"s");
		$MySelectQry .= " and stock_type=?";MYSQL_BuildArray("stock_type","S","s");
		$MySelectQry .= " and delete_ind=?";MYSQL_BuildArray("delete_ind",'0',"s");
		$MyDbResult =  MyDbQuery($MySelectQry,$_GVParamArray);	
		while($MyRowData = mysqli_fetch_array($MyDbResult, MYSQLI_ASSOC)) 
		{
			$existingStockDetArr[GVStringFormat($MyRowData['product_id'])]["INFOID"] = GVStringFormat($MyRowData['stock_info_id']);
			$existingStockDetArr[GVStringFormat($MyRowData['product_id'])]["QTY"] = GVStringFormat($MyRowData['quantity']);
			$existingStockDetArr[GVStringFormat($MyRowData['product_id'])]["PRODPRICE"] = GVformatAmount(GVStringFormat($MyRowData['prod_price']));
		}
		MyDbFreeResult($MyDbResult);
	}
	
	foreach($productDetailsArr as $product_id=>$prodDetArr)
	{
		$txtQuantity = $prodDetArr["QTY"];
		$txtRate = $prodDetArr["RATE"];
		
		if($GVSTEP == "EDIT" && array_key_exists($product_id,$existingProdDetArr))
		{
			$existingProdQty = $existingProdDetArr[$product_id]; 
			
			if($existingProdQty != $txtQuantity)
			{
				if($txtQuantity < $existingQty)
				{
					foreach($existingStockDetArr as $key=>$valProdArr)
					{
						$existingQty = $valProdArr["QTY"];
						$stock_info_id = $valProdArr["INFOID"];
						$prodPrice = $valProdArr["PRODPRICE"];
						
						if($txtQuantity > $existingQty)
							$updateQuantity = $existingQty;
						else
							$updateQuantity = $txtQuantity;
						
						if($txtQuantity == 0)
						{
							$MyDeleteQry = "delete from stock_track where ";
							$MyDeleteQry .= " company_id=?";MYSQL_BuildArray("company_id",$company_id,"s");
							$MyDeleteQry .= " and sales_id=?";MYSQL_BuildArray("sales_id",$GVID,"s");
							$MyDeleteQry .= " and product_id=?";MYSQL_BuildArray("product_id",$product_id,"s");
							$MyDeleteQry .= " and stock_info_id=?";MYSQL_BuildArray("stock_info_id",$stock_info_id,"s");
							MyDbQuery($MyDeleteQry, $_GVParamArray);
						}
						else
						{
							$totPrice = GVformatAmount($updateQuantity * $prodPrice);
							$totalAmt = GVformatAmount($updateQuantity * $txtRate);
							
							$_GVParamArray[] = array("KEY"=>"quantity", "VAL"=>$updateQuantity, "TYPE"=>"s");
							$_GVParamArray[] = array("KEY"=>"price", "VAL"=>$txtRate, "TYPE"=>"s");
							$_GVParamArray[] = array("KEY"=>"total_amt", "VAL"=>$totalAmt, "TYPE"=>"s");
							$_GVParamArray[] = array("KEY"=>"prod_price", "VAL"=>$prodPrice, "TYPE"=>"s");
							$_GVParamArray[] = array("KEY"=>"tot_price", "VAL"=>$totPrice, "TYPE"=>"s");
							$_GVParamArray[] = array("KEY"=>"modified_datetime", "VAL"=>"CURRENT_TIMESTAMP()", "TYPE"=>"SKIP");
							
							$outParamArr = GVgetQueryString($_GVParamArray);
							
							$MyUpdateQry = "update stock_track set ".$outParamArr['_UPDATE_SQLQRY_VAL']." where ";
							$MyUpdateQry .= " company_id=?";MYSQL_BuildArray("company_id",$company_id,"s");
							$MyUpdateQry .= " and sales_id=?";MYSQL_BuildArray("sales_id",$GVID,"s");
							$MyUpdateQry .= " and product_id=?";MYSQL_BuildArray("product_id",$product_id,"s");
							$MyUpdateQry .= " and stock_info_id=?";MYSQL_BuildArray("stock_info_id",$stock_info_id,"s");
							MyDbQuery($MyUpdateQry, $_GVParamArray);
							
							$txtQuantity = $txtQuantity - $updateQuantity;
						}
						
						include("gv_product_track.php");
					}
				}
				else
				{
					foreach($existingStockDetArr as $key=>$valProdArr)
					{
						$existingQty = $valProdArr["QTY"];
						$stock_info_id = $valProdArr["INFOID"];
						
						$totalAmt = GVformatAmount($existingQty * $txtRate);
							
						$_GVParamArray[] = array("KEY"=>"quantity", "VAL"=>$existingQty, "TYPE"=>"s");
						$_GVParamArray[] = array("KEY"=>"price", "VAL"=>$txtRate, "TYPE"=>"s");
						$_GVParamArray[] = array("KEY"=>"total_amt", "VAL"=>$totalAmt, "TYPE"=>"s");
						$_GVParamArray[] = array("KEY"=>"stock_type", "VAL"=>"S", "TYPE"=>"s");
						$_GVParamArray[] = array("KEY"=>"modified_datetime", "VAL"=>"CURRENT_TIMESTAMP()", "TYPE"=>"SKIP");
						
						$outParamArr = GVgetQueryString($_GVParamArray);
						
						$MyUpdateQry = "update stock_track set ".$outParamArr['_UPDATE_SQLQRY_VAL']." where ";
						$MyUpdateQry .= " company_id=?";MYSQL_BuildArray("company_id",$company_id,"s");
						$MyUpdateQry .= " and sales_id=?";MYSQL_BuildArray("sales_id",$GVID,"s");
						$MyUpdateQry .= " and product_id=?";MYSQL_BuildArray("product_id",$product_id,"s");
						$MyUpdateQry .= " and stock_info_id=?";MYSQL_BuildArray("stock_info_id",$stock_info_id,"s");
						MyDbQuery($MyUpdateQry, $_GVParamArray);
						
						include("gv_product_track.php");
					}
					
					$txtQuantity = $txtQuantity - $existingProdQty;
					
					$incr = 0;
			
					while($txtQuantity != 0)
					{
						$stock_info_id = $stockInfoIDArr[$product_id][$incr];
						$stockVal = $stockInfoArr[$stock_info_id]["CNT"];
						$prodPrice = $stockInfoArr[$stock_info_id]["PURCHASE"];
						
						if($stockVal > 0)
						{
							if($txtQuantity > $stockVal)
								$updateQuantity = $stockVal;
							else
								$updateQuantity = $txtQuantity;
							
							$totPrice = GVformatAmount($updateQuantity * $prodPrice);
							$totalAmt = GVformatAmount($updateQuantity * $txtRate);
							
							$_GVParamArray[] = array("KEY"=>"company_id", "VAL"=>$company_id, "TYPE"=>"s");
							$_GVParamArray[] = array("KEY"=>"sales_id", "VAL"=>$GVID, "TYPE"=>"s");
							$_GVParamArray[] = array("KEY"=>"product_id", "VAL"=>$product_id, "TYPE"=>"s");
							$_GVParamArray[] = array("KEY"=>"quantity", "VAL"=>$updateQuantity, "TYPE"=>"s");
							$_GVParamArray[] = array("KEY"=>"price", "VAL"=>$txtRate, "TYPE"=>"s");
							$_GVParamArray[] = array("KEY"=>"total_amt", "VAL"=>$totalAmt, "TYPE"=>"s");
							$_GVParamArray[] = array("KEY"=>"stock_type", "VAL"=>"S", "TYPE"=>"s");
							$_GVParamArray[] = array("KEY"=>"stock_info_id", "VAL"=>$stock_info_id, "TYPE"=>"s");
							$_GVParamArray[] = array("KEY"=>"prod_price", "VAL"=>$prodPrice, "TYPE"=>"s");
							$_GVParamArray[] = array("KEY"=>"tot_price", "VAL"=>$totPrice, "TYPE"=>"s");
							$outParamArr = GVgetQueryString($_GVParamArray);
							
							$MyInsertQry = "insert into stock_track (".$outParamArr['_INSERT_SQLQRY_FIELDS'].") values(".$outParamArr['_INSERT_SQLQRY_VAL'].")";
							MyDbQuery($MyInsertQry, $_GVParamArray);
							
							$txtQuantity = $txtQuantity - $updateQuantity;
						}
						
						$incr++;
						
						include("gv_product_track.php");
					}
				}
			}
		}
		else
		{
			$incr = 0;
			
			while($txtQuantity != 0)
			{
				$stock_info_id = $stockInfoIDArr[$product_id][$incr];
				$stockVal = $stockInfoArr[$stock_info_id]["CNT"];
				$prodPrice = $stockInfoArr[$stock_info_id]["PURCHASE"];
				
				if($stockVal > 0)
				{
					if($txtQuantity > $stockVal)
						$updateQuantity = $stockVal;
					else
						$updateQuantity = $txtQuantity;
					
					$totPrice = GVformatAmount($updateQuantity * $prodPrice);
					$totalAmt = GVformatAmount($updateQuantity * $txtRate);
					
					$_GVParamArray[] = array("KEY"=>"company_id", "VAL"=>$company_id, "TYPE"=>"s");
					$_GVParamArray[] = array("KEY"=>"sales_id", "VAL"=>$GVID, "TYPE"=>"s");
					$_GVParamArray[] = array("KEY"=>"product_id", "VAL"=>$product_id, "TYPE"=>"s");
					$_GVParamArray[] = array("KEY"=>"quantity", "VAL"=>$updateQuantity, "TYPE"=>"s");
					$_GVParamArray[] = array("KEY"=>"price", "VAL"=>$txtRate, "TYPE"=>"s");
					$_GVParamArray[] = array("KEY"=>"total_amt", "VAL"=>$totalAmt, "TYPE"=>"s");
					$_GVParamArray[] = array("KEY"=>"stock_type", "VAL"=>"S", "TYPE"=>"s");
					$_GVParamArray[] = array("KEY"=>"stock_info_id", "VAL"=>$stock_info_id, "TYPE"=>"s");
					$_GVParamArray[] = array("KEY"=>"prod_price", "VAL"=>$prodPrice, "TYPE"=>"s");
					$_GVParamArray[] = array("KEY"=>"tot_price", "VAL"=>$totPrice, "TYPE"=>"s");
					$outParamArr = GVgetQueryString($_GVParamArray);
					
					$MyInsertQry = "insert into stock_track (".$outParamArr['_INSERT_SQLQRY_FIELDS'].") values(".$outParamArr['_INSERT_SQLQRY_VAL'].")";
					MyDbQuery($MyInsertQry, $_GVParamArray);
					
					$txtQuantity = $txtQuantity - $updateQuantity;
				}
				
				$incr++;
				
				include("gv_product_track.php");
			}
		}
	}
	
	if(count($delProdIDArr) > 0)
	{
		$MySelectQry = "select stock_info_id,product_id from stock_track where";
		$MySelectQry .= " company_id=?";MYSQL_BuildArray("company_id",$company_id,"s");
		$MySelectQry .= " and sales_id=?";MYSQL_BuildArray("sales_id",$GVID,"s");
		$MySelectQry .= " and product_id in (".MYSQL_ArrayBuild_String($delProdIDArr).")";MYSQL_BuildArray("product_id",$delProdIDArr,"s");
		$MySelectQry .= " and stock_type=?";MYSQL_BuildArray("stock_type","S","s");
		$MySelectQry .= " and delete_ind=?";MYSQL_BuildArray("delete_ind",'0',"s");
		$MyDbResultDEL =  MyDbQuery($MySelectQry,$_GVParamArray);	
		while($MyRowDataDEL = mysqli_fetch_array($MyDbResultDEL, MYSQLI_ASSOC)) 
		{
			$stock_info_id = GVStringFormat($MyRowDataDEL['stock_info_id']);
			$product_id = GVStringFormat($MyRowDataDEL['product_id']);
			
			$MyDeleteQry = "delete from stock_track where ";
			$MyDeleteQry .= " company_id=?";MYSQL_BuildArray("company_id",$company_id,"s");
			$MyDeleteQry .= " and sales_id=?";MYSQL_BuildArray("sales_id",$GVID,"s");
			$MyDeleteQry .= " and product_id=?";MYSQL_BuildArray("product_id",$product_id,"s");
			$MyDeleteQry .= " and stock_info_id=?";MYSQL_BuildArray("stock_info_id",$stock_info_id,"s");
			MyDbQuery($MyDeleteQry, $_GVParamArray);
			
			include("gv_product_track.php");
		}
		MyDbFreeResult($MyDbResultDEL);
	}	
?>