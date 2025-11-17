<?
	$totCustomer = 0;
	$totVendor = 0;
	$totSales = 0;
	$totPurchase = 0;
	
	$MySelectQry = "select count(customer_id) as cnt from customer_info where";
	$MySelectQry .= " company_id=?";MYSQL_BuildArray("company_id",$company_id,"s");
	$MyDbResult =  MyDbQuery($MySelectQry,$_GVParamArray);
	if($MyRowData = mysqli_fetch_array($MyDbResult, MYSQLI_ASSOC)) 
	{
		$totCustomer = GVStringFormat($MyRowData['cnt']);
	}
	MyDbFreeResult($MyDbResult);
	
	$MySelectQry = "select count(vendor_id) as cnt from vendor_info where";
	$MySelectQry .= " company_id=?";MYSQL_BuildArray("company_id",$company_id,"s");
	$MyDbResult =  MyDbQuery($MySelectQry,$_GVParamArray);
	if($MyRowData = mysqli_fetch_array($MyDbResult, MYSQLI_ASSOC)) 
	{
		$totVendor = GVStringFormat($MyRowData['cnt']);
	}
	MyDbFreeResult($MyDbResult);
	
	$MySelectQry = "select count(sales_id) as cnt from sales_info where";
	$MySelectQry .= " company_id=?";MYSQL_BuildArray("company_id",$company_id,"s");
	$MyDbResult =  MyDbQuery($MySelectQry,$_GVParamArray);
	if($MyRowData = mysqli_fetch_array($MyDbResult, MYSQLI_ASSOC)) 
	{
		$totSales = GVStringFormat($MyRowData['cnt']);
	}
	MyDbFreeResult($MyDbResult);
	
	$MySelectQry = "select count(purchase_id) as cnt from purchase_info where";
	$MySelectQry .= " company_id=?";MYSQL_BuildArray("company_id",$company_id,"s");
	$MyDbResult =  MyDbQuery($MySelectQry,$_GVParamArray);
	if($MyRowData = mysqli_fetch_array($MyDbResult, MYSQLI_ASSOC)) 
	{
		$totPurchase = GVStringFormat($MyRowData['cnt']);
	}
	MyDbFreeResult($MyDbResult);	
	
	$purchaseURL = GVstringEncrption("LoadHtmlPage=gv_purchase_list&GVmenu=PURCHASE");
	$salesURL = GVstringEncrption("LoadHtmlPage=gv_sales_list&GVmenu=SALES");
	$CustomerURL = GVstringEncrption("LoadHtmlPage=gv_customer_list&GVmenu=SETTINGS&GVsubMenu=CUSTOMERS");
	$vendorURL = GVstringEncrption("LoadHtmlPage=gv_vendor_list&GVmenu=SETTINGS&GVsubMenu=VENDORS");
	
	$total_qty = 0;
	$sold_qty = 0;
	$remaining_qty = 0;
	$tot_purchase_amt = 0;
	$tot_sales_amt = 0;
	$remaining_stock_amt = 0;
	$totProduct = 0;
	
	$MySelectQry = "select count(product_id) as prodCount,sum(total_qty) as total_qty,sum(sold_qty) as sold_qty,sum(remaining_qty) as remaining_qty,";
	$MySelectQry .= " sum(tot_purchase_amt) as tot_purchase_amt,sum(tot_sales_amt) as tot_sales_amt,sum(remaining_stock_amt) as remaining_stock_amt ";
	$MySelectQry .= " from product_info where";
	$MySelectQry .= " company_id=?";MYSQL_BuildArray("company_id",$company_id,"s");
	$MyDbResult =  MyDbQuery($MySelectQry,$_GVParamArray);	
	if($MyRowData = mysqli_fetch_array($MyDbResult, MYSQLI_ASSOC)) 
	{
		$totProduct 		= (int) GVStringFormat($MyRowData['prodCount']);
		$total_qty 		= (int) GVStringFormat($MyRowData['total_qty']);
		$sold_qty 		= (int) GVStringFormat($MyRowData['sold_qty']);
		$remaining_qty 		= (int) GVStringFormat($MyRowData['remaining_qty']);
		$tot_purchase_amt 	= GVformatAmount(GVStringFormat($MyRowData['tot_purchase_amt']));
		$tot_sales_amt 		= GVformatAmount(GVStringFormat($MyRowData['tot_sales_amt']));
		$remaining_stock_amt 	= GVformatAmount(GVStringFormat($MyRowData['remaining_stock_amt']));
	}
	MyDbFreeResult($MyDbResult);
	
	$overallSalesAmt = 0;
	$overallBalanceAmt = 0;
	$overallDiscountAmt = 0;
	$overallSalesProfit = 0;
	
	$MySelectQry = "select sum(overall_amount) as overall_amount,sum(balance_due) as balance_due,sum(discount_amount) as discount_amount,";
	$MySelectQry .= " sum(sales_profit) as overallSalesProfit";
	$MySelectQry .= " from sales_info where";
	$MySelectQry .= " company_id=?";MYSQL_BuildArray("company_id",$company_id,"s");
	$MyDbResult =  MyDbQuery($MySelectQry,$_GVParamArray);	
	if($MyRowData = mysqli_fetch_array($MyDbResult, MYSQLI_ASSOC)) 
	{
		$overallSalesAmt 	= GVformatAmount(GVStringFormat($MyRowData['overall_amount']));
		$overallBalanceAmt	= GVformatAmount(GVStringFormat($MyRowData['balance_due']));
		$overallDiscountAmt 	= GVformatAmount(GVStringFormat($MyRowData['discount_amount']));
		$overallSalesProfit 	= GVformatAmount(GVStringFormat($MyRowData['overallSalesProfit']));
	}
	MyDbFreeResult($MyDbResult);
	
	$overallPurchasedAmt = 0;
	$MySelectQry = "select sum(overall_amount) as overall_amount";
	$MySelectQry .= " from purchase_info where";
	$MySelectQry .= " company_id=?";MYSQL_BuildArray("company_id",$company_id,"s");
	$MyDbResult =  MyDbQuery($MySelectQry,$_GVParamArray);	
	if($MyRowData = mysqli_fetch_array($MyDbResult, MYSQLI_ASSOC)) 
	{
		$overallPurchasedAmt = GVformatAmount(GVStringFormat($MyRowData['overall_amount']));
	}
	MyDbFreeResult($MyDbResult);
	
	
	$totAvailableProduct = 0;
	$totSoldProduct = 0;
	$totLowStockProduct = 0;
	$totOutofStockProduct = 0;
	
	$MySelectQry = "select count(product_id) as totAvailableProduct from product_info where";
	$MySelectQry .= " company_id=?";MYSQL_BuildArray("company_id",$company_id,"s");
	$MySelectQry .= " and remaining_qty>?";MYSQL_BuildArray("remaining_qty",0,"s");
	$MyDbResult =  MyDbQuery($MySelectQry,$_GVParamArray);	
	if($MyRowData = mysqli_fetch_array($MyDbResult, MYSQLI_ASSOC)) 
	{
		$totAvailableProduct = GVStringFormat($MyRowData['totAvailableProduct']);
	}
	MyDbFreeResult($MyDbResult);
	
	$MySelectQry = "select count(product_id) as totSoldProduct from product_info where";
	$MySelectQry .= " company_id=?";MYSQL_BuildArray("company_id",$company_id,"s");
	$MySelectQry .= " and sold_qty>?";MYSQL_BuildArray("sold_qty",0,"s");
	$MyDbResult =  MyDbQuery($MySelectQry,$_GVParamArray);	
	if($MyRowData = mysqli_fetch_array($MyDbResult, MYSQLI_ASSOC)) 
	{
		$totSoldProduct = GVStringFormat($MyRowData['totSoldProduct']);
	}
	MyDbFreeResult($MyDbResult);
	
	$MySelectQry = "select count(product_id) as totLowStockProduct from product_info where";
	$MySelectQry .= " company_id=?";MYSQL_BuildArray("company_id",$company_id,"s");
	$MySelectQry .= " and alert_ind=?";MYSQL_BuildArray("alert_ind",1,"s");
	$MySelectQry .= " and remaining_qty<=qty_count_alert";
	$MyDbResult =  MyDbQuery($MySelectQry,$_GVParamArray);	
	if($MyRowData = mysqli_fetch_array($MyDbResult, MYSQLI_ASSOC)) 
	{
		$totLowStockProduct = GVStringFormat($MyRowData['totLowStockProduct']);
	}
	MyDbFreeResult($MyDbResult);
	
	$MySelectQry = "select count(product_id) as totOutofStockProduct from product_info where";
	$MySelectQry .= " company_id=?";MYSQL_BuildArray("company_id",$company_id,"s");
	$MySelectQry .= " and remaining_qty=?";MYSQL_BuildArray("remaining_qty",0,"s");
	$MyDbResult =  MyDbQuery($MySelectQry,$_GVParamArray);	
	if($MyRowData = mysqli_fetch_array($MyDbResult, MYSQLI_ASSOC)) 
	{
		$totOutofStockProduct = GVStringFormat($MyRowData['totOutofStockProduct']);
	}
	MyDbFreeResult($MyDbResult);
	
	$MySelectQry = "select sum(total_amt) as initialStockAmount from stock_track where";
	$MySelectQry .= " company_id=?";MYSQL_BuildArray("company_id",$company_id,"s");
	$MySelectQry .= " and stock_type=?";MYSQL_BuildArray("stock_type","I","s");
	$MySelectQry .= " and delete_ind=?";MYSQL_BuildArray("delete_ind",'0',"s");
	$MyDbResult =  MyDbQuery($MySelectQry,$_GVParamArray);	
	if($MyRowData = mysqli_fetch_array($MyDbResult, MYSQLI_ASSOC)) 
	{
		$initialStockAmount = GVformatAmount(GVStringFormat($MyRowData['initialStockAmount']));
	}
	MyDbFreeResult($MyDbResult);
	
	$overallReportArr = array();
	$overallReportArr[] = GVformatAmount($initialStockAmount + $overallPurchasedAmt);
	$overallReportArr[] = GVformatAmount($initialStockAmount);
	$overallReportArr[] = GVformatAmount($overallPurchasedAmt);
	$overallReportArr[] = GVformatAmount($overallSalesAmt); 
	$overallReportArr[] = GVformatAmount($overallDiscountAmt);
	$overallReportArr[] = GVformatAmount($overallBalanceAmt); 
	$overallReportArr[] = GVformatAmount($overallSalesProfit); 
	
	$productAmtReportArr = array();
	$productAmtReportArr[] = GVformatAmount($tot_purchase_amt);
	$productAmtReportArr[] = GVformatAmount($tot_sales_amt);
	$productAmtReportArr[] = GVformatAmount($remaining_stock_amt);
?>