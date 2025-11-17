<?
	$totSalesProdCount = 0;
	$totPurchaseProdCount = 0;
	$tot_sales_amt = 0;
	$tot_purchase_amt = 0;
	$lastPurchaseRate = 0;
	
	$MySelectQry = "select prod_price from stock_track where";
	$MySelectQry .= " company_id=?";MYSQL_BuildArray("company_id",$company_id,"s");
	$MySelectQry .= " and product_id=?";MYSQL_BuildArray("product_id",$product_id,"s");
	$MySelectQry .= " and stock_type!=?";MYSQL_BuildArray("stock_type","S","s");
	$MySelectQry .= " and delete_ind=?";MYSQL_BuildArray("delete_ind",'0',"s");
	$MySelectQry .= " order by stock_track_id desc";
	$MyDbResult =  MyDbQuery($MySelectQry,$_GVParamArray);	
	if($MyRowData = mysqli_fetch_array($MyDbResult, MYSQLI_ASSOC)) 
	{
		$lastPurchaseRate = GVformatAmount(GVStringFormat($MyRowData['prod_price']));
	}
	MyDbFreeResult($MyDbResult);
	
	$MySelectQry = "select sum(quantity) as totQty,sum(tot_price) as totProdCost,stock_type from stock_track where";
	$MySelectQry .= " company_id=?";MYSQL_BuildArray("company_id",$company_id,"s");
	$MySelectQry .= " and product_id=?";MYSQL_BuildArray("product_id",$product_id,"s");
	$MySelectQry .= " and stock_info_id=?";MYSQL_BuildArray("stock_info_id",$stock_info_id,"s");
	$MySelectQry .= " and delete_ind=?";MYSQL_BuildArray("delete_ind",'0',"s");
	$MySelectQry .= " group by stock_type";
	$MyDbResult =  MyDbQuery($MySelectQry,$_GVParamArray);	
	while($MyRowData = mysqli_fetch_array($MyDbResult, MYSQLI_ASSOC)) 
	{
		if(GVStringFormat($MyRowData['stock_type']) == "S")
		{
			$totSalesProdCount += (int) GVStringFormat($MyRowData['totQty']);
			$tot_sales_amt += GVformatAmount(GVStringFormat($MyRowData['totProdCost']));
		}
		else
		{
			$totPurchaseProdCount += (int) GVStringFormat($MyRowData['totQty']);
			$tot_purchase_amt += GVformatAmount(GVStringFormat($MyRowData['totProdCost']));
		}
	}
	MyDbFreeResult($MyDbResult);
	
	$remainingQty = $totPurchaseProdCount - $totSalesProdCount;
	$remainingQtyAmt = GVformatAmount($tot_purchase_amt - $tot_sales_amt);
	
	$_GVParamArray[] = array("KEY"=>"stock_count", "VAL"=>$remainingQty, "TYPE"=>"s");
	$_GVParamArray[] = array("KEY"=>"remaining_stock_amt", "VAL"=>$remainingQtyAmt, "TYPE"=>"s");
	$_GVParamArray[] = array("KEY"=>"tot_sales_amt", "VAL"=>$tot_sales_amt, "TYPE"=>"s");
	$_GVParamArray[] = array("KEY"=>"tot_purchase_amt", "VAL"=>$tot_purchase_amt, "TYPE"=>"s");
	$_GVParamArray[] = array("KEY"=>"modified_datetime", "VAL"=>"CURRENT_TIMESTAMP()", "TYPE"=>"SKIP");
	
	$outParamArr = GVgetQueryString($_GVParamArray);
	
	$MyUpdateQry = "update stock_info set ".$outParamArr['_UPDATE_SQLQRY_VAL']." where ";
	$MyUpdateQry .= " company_id=?";MYSQL_BuildArray("company_id",$company_id,"s");
	$MyUpdateQry .= " and product_id=?";MYSQL_BuildArray("product_id",$product_id,"s");
	$MyUpdateQry .= " and stock_info_id=?";MYSQL_BuildArray("stock_info_id",$stock_info_id,"s");
	$MyUpdateQry .= " and delete_ind=?";MYSQL_BuildArray("delete_ind","0","s");
	MyDbQuery($MyUpdateQry, $_GVParamArray);
	
	$remaining_qty = 0;
	$tot_purchase_amt = 0;
	$tot_sales_amt = 0;
	$remaining_stock_amt = 0;
	$totalStockQty = 0;
	$soldStockQty = 0;
	
	$MySelectQry = "select sum(stock_qty) as totalStockQty,sum(stock_count) as remaining_qty,sum(tot_purchase_amt) as tot_purchase_amt,sum(tot_sales_amt) as tot_sales_amt,sum(remaining_stock_amt) as remaining_stock_amt from stock_info where";
	$MySelectQry .= " company_id=?";MYSQL_BuildArray("company_id",$company_id,"s");
	$MySelectQry .= " and product_id=?";MYSQL_BuildArray("product_id",$product_id,"s");
	$MySelectQry .= " and delete_ind=?";MYSQL_BuildArray("delete_ind",'0',"s");
	$MySelectQry .= " group by product_id";
	$MyDbResult =  MyDbQuery($MySelectQry,$_GVParamArray);	
	if($MyRowData = mysqli_fetch_array($MyDbResult, MYSQLI_ASSOC)) 
	{
		$remaining_qty = GVStringFormat($MyRowData['remaining_qty']);
		$totalStockQty = GVStringFormat($MyRowData['totalStockQty']);
		$tot_purchase_amt = GVformatAmount(GVStringFormat($MyRowData['tot_purchase_amt']));
		$tot_sales_amt = GVformatAmount(GVStringFormat($MyRowData['tot_sales_amt']));
		$remaining_stock_amt = GVformatAmount(GVStringFormat($MyRowData['remaining_stock_amt']));
	}
	MyDbFreeResult($MyDbResult);
	
	$soldStockQty = $totalStockQty - $remaining_qty;
	
	$totSalesPdtCost = 0;
	$totPurchasePdtCost = 0;
	
	$MySelectQry = "select sum(total_amt) as totSalesCost,sum(tot_price) as totProductCost from stock_track where";
	$MySelectQry .= " company_id=?";MYSQL_BuildArray("company_id",$company_id,"s");
	$MySelectQry .= " and product_id=?";MYSQL_BuildArray("product_id",$product_id,"s");
	$MySelectQry .= " and stock_type=?";MYSQL_BuildArray("stock_type","S","s");
	$MySelectQry .= " and delete_ind=?";MYSQL_BuildArray("delete_ind",'0',"s");
	$MyDbResult =  MyDbQuery($MySelectQry,$_GVParamArray);	
	if($MyRowData = mysqli_fetch_array($MyDbResult, MYSQLI_ASSOC)) 
	{
		$totSalesPdtCost = GVformatAmount(GVStringFormat($MyRowData['totSalesCost']));
		$totPurchasePdtCost = GVformatAmount(GVStringFormat($MyRowData['totProductCost']));
	}
	MyDbFreeResult($MyDbResult);
	
	$totPdtProfit = GVformatAmount($totSalesPdtCost - $totPurchasePdtCost);
	
	$_GVParamArray[] = array("KEY"=>"total_qty", "VAL"=>$totalStockQty, "TYPE"=>"s");
	$_GVParamArray[] = array("KEY"=>"sold_qty", "VAL"=>$soldStockQty, "TYPE"=>"s");
	$_GVParamArray[] = array("KEY"=>"remaining_qty", "VAL"=>$remaining_qty, "TYPE"=>"s");
	$_GVParamArray[] = array("KEY"=>"tot_purchase_amt", "VAL"=>$tot_purchase_amt, "TYPE"=>"s");
	$_GVParamArray[] = array("KEY"=>"tot_sales_amt", "VAL"=>$tot_sales_amt, "TYPE"=>"s");
	$_GVParamArray[] = array("KEY"=>"remaining_stock_amt", "VAL"=>$remaining_stock_amt, "TYPE"=>"s");
	$_GVParamArray[] = array("KEY"=>"buying_amount", "VAL"=>$lastPurchaseRate, "TYPE"=>"s");
	$_GVParamArray[] = array("KEY"=>"product_profit", "VAL"=>$totPdtProfit, "TYPE"=>"s");
	$_GVParamArray[] = array("KEY"=>"modified_datetime", "VAL"=>"CURRENT_TIMESTAMP()", "TYPE"=>"SKIP");
	
	$outParamArr = GVgetQueryString($_GVParamArray);
	
	$MyUpdateQry = "update product_info set ".$outParamArr['_UPDATE_SQLQRY_VAL']." where ";
	$MyUpdateQry .= " company_id=?";MYSQL_BuildArray("company_id",$company_id,"s");
	$MyUpdateQry .= " and product_id=?";MYSQL_BuildArray("product_id",$product_id,"s");
	$MyUpdateQry .= " and delete_ind=?";MYSQL_BuildArray("delete_ind","0","s");
	MyDbQuery($MyUpdateQry, $_GVParamArray);
?>