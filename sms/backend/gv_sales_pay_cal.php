<?
	$paid_amt = 0;
	$balance_due = 0;
	
	$MySelectQry = "select sum(pay_amount) as paid_amt from payment_info where";
	$MySelectQry .= " company_id=?";MYSQL_BuildArray("company_id",$company_id,"s");
	$MySelectQry .= " and sales_id=?";MYSQL_BuildArray("sales_id",$GVID,"s");
	$MyDbResult =  MyDbQuery($MySelectQry,$_GVParamArray);	
	if($MyRowData = mysqli_fetch_array($MyDbResult, MYSQLI_ASSOC)) 
	{
		$paid_amt = GVformatAmount(GVStringFormat($MyRowData['paid_amt']));
	}
	MyDbFreeResult($MyDbResult);
	
	$balance_due = GVformatAmount($txtOverallAmount - $paid_amt);
	
	if($frmSalesInfoInd == 1)
	{
		$_GVParamArray[] = array("KEY"=>"sales_profit", "VAL"=>$sales_profit, "TYPE"=>"s");
	}
	
	$_GVParamArray[] = array("KEY"=>"paid_amt", "VAL"=>$paid_amt, "TYPE"=>"s");
	$_GVParamArray[] = array("KEY"=>"balance_due", "VAL"=>$balance_due, "TYPE"=>"s");
	
	if($paid_amt > $txtOverallAmount)
	{
		$_GVParamArray[] = array("KEY"=>"status", "VAL"=>"OVERPAID", "TYPE"=>"s");
	}
	else if($txtOverallAmount == $paid_amt && $balance_due == 0)
	{
		$_GVParamArray[] = array("KEY"=>"status", "VAL"=>"PAID", "TYPE"=>"s");
	}
	else if($paid_amt > 0)
	{
		$_GVParamArray[] = array("KEY"=>"status", "VAL"=>"PARTIAL PAID", "TYPE"=>"s");
	}
	else
	{
		$_GVParamArray[] = array("KEY"=>"status", "VAL"=>"NOT PAID", "TYPE"=>"s");
	}
	
	$outParamArr = GVgetQueryString($_GVParamArray);
	
	$MyUpdateQry = "update sales_info set ".$outParamArr['_UPDATE_SQLQRY_VAL']." where ";
	$MyUpdateQry .= " company_id=?";MYSQL_BuildArray("company_id",$company_id,"s");
	$MyUpdateQry .= " and sales_id=?";MYSQL_BuildArray("sales_id",$GVID,"s");
	MyDbQuery($MyUpdateQry, $_GVParamArray);
?>
	
	