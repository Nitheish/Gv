<?
	$firstSalesDate = date("Y-m-d");
	$MySelectQry = "select sales_date from sales_info where";
	$MySelectQry .= " company_id=?";MYSQL_BuildArray("company_id",$company_id,"s");
	$MySelectQry .= " and delete_ind=?";MYSQL_BuildArray("delete_ind",'0',"s");
	$MySelectQry .= " order by sales_date asc";
	$MyDbResult =  MyDbQuery($MySelectQry,$_GVParamArray);	
	if($MyRowData = mysqli_fetch_array($MyDbResult, MYSQLI_ASSOC)) 
	{
		$sales_date = GVStringFormat($MyRowData['sales_date']);
	}
	MyDbFreeResult($MyDbResult);
	
	$year = (int) substr($sales_date,0,4);
	$currYr = date('Y');
	
	$yearArr = array();
	for($incr = $year; $incr <= $currYr; $incr++)
	{
		$yearArr[$incr] = $incr;
	}
	
	if($cboYear == "")
		$cboYear = $currYr;
	
	$monArr = array();
	$monProdArr = array();
	$monOverallSalesArr = array();
	$monProfitArr = array();
	$monSalesProfitArr = array();
		
	for($incr = 1; $incr <= 12; $incr++)
	{
		$month = sprintf("%02d", $incr);
		$dateOfMonth = $year."-".$month."-01";
		$monArr[$incr - 1] = date('F',strtotime($dateOfMonth));
		$monProdArr[$incr - 1] = 0;
		$monOverallSalesArr[$incr - 1] = 0;
		$monProfitArr[$incr - 1] = 0;
		$monSalesProfitArr[$incr - 1] = array(0,0);
	}
	
	$yoyTotProduct = 0;
	$MySelectQry = "select sum(sp.product_quantity) as tot_qty,month(si.sales_date) as month from sales_info si,sales_product sp where ";
	$MySelectQry .= " si.company_id=?";MYSQL_BuildArray("company_id",$company_id,"s");
	$MySelectQry .= " and sp.company_id=?";MYSQL_BuildArray("company_id",$company_id,"s");
	$MySelectQry .= " and si.sales_id=sp.sales_id";
	$MySelectQry .= " and si.delete_ind=?";MYSQL_BuildArray("delete_ind","0","s");
	$MySelectQry .= " and year(si.sales_date)=$cboYear";
	$MySelectQry .= " GROUP by month(si.sales_date)";
	$MyDbResult =  MyDbQuery($MySelectQry,$_GVParamArray);
	while($MyRowData = mysqli_fetch_array($MyDbResult, MYSQLI_ASSOC)) 
	{
		$prod_qty_mon = GVStringFormat($MyRowData['month']);
		$tot_qty = GVStringFormat($MyRowData['tot_qty']);
		
		$monProdArr[$prod_qty_mon - 1] = $tot_qty;
		$yoyTotProduct += (int) $tot_qty;
	}
	MyDbFreeResult($MyDbResult);
	
	$yoyTotSalesAmt = 0;
	$yoyTotSalesProfitAmt = 0;
	$MySelectQry = "select sum(si.sales_profit) as sales_profit,sum(si.overall_amount) as overall_amount,month(si.sales_date) as month from sales_info si where ";
	$MySelectQry .= " si.company_id=?";MYSQL_BuildArray("company_id",$company_id,"s");
	$MySelectQry .= " and si.delete_ind=?";MYSQL_BuildArray("delete_ind","0","s");
	$MySelectQry .= " and year(si.sales_date)=$cboYear";
	$MySelectQry .= " GROUP by month(si.sales_date)";
	$MyDbResult =  MyDbQuery($MySelectQry,$_GVParamArray);
	while($MyRowData = mysqli_fetch_array($MyDbResult, MYSQLI_ASSOC)) 
	{
		$overall_amount = GVStringFormat($MyRowData['overall_amount']);
		$sales_profit = GVStringFormat($MyRowData['sales_profit']);
		$prod_qty_mon = GVStringFormat($MyRowData['month']);
		
		$monOverallSalesArr[$prod_qty_mon - 1] = GVformatAmount($overall_amount);
		$monProfitArr[$prod_qty_mon - 1] = GVformatAmount($sales_profit);
		$monSalesProfitArr[$prod_qty_mon - 1] = array(GVformatAmount($overall_amount),GVformatAmount($sales_profit));
		
		$yoyTotSalesAmt += $overall_amount;
		$yoyTotSalesProfitAmt += $sales_profit;
	}
	MyDbFreeResult($MyDbResult);
		
	
?>