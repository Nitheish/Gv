<?
	$AJAXcallInd = 1;
	$company_id = 1;
	include_once("gv_header.php");
	
	if($action == "SALESFIXCHK")
	{
		$MySelectQryMain = "select sales_id from sales_info where";
		$MySelectQryMain .= " company_id=?";MYSQL_BuildArray("company_id",$company_id,"s");
		$MySelectQryMain .= " order by sales_id asc";
		$MyDbResultMain =  MyDbQuery($MySelectQryMain,$_GVParamArray);	
		while($MyRowDataMain = mysqli_fetch_array($MyDbResultMain, MYSQLI_ASSOC)) 
		{
			$sales_id = GVStringFormat($MyRowDataMain['sales_id']);
			
			$MySelectQry = " select product_id from stock_track as st where";
			$MySelectQry .= " company_id=?";MYSQL_BuildArray("company_id",$company_id,"s");
			$MySelectQry .= " and sales_id=?";MYSQL_BuildArray("sales_id",$sales_id,"s");
			$MySelectQry .= " and not exists(select product_id from sales_product as sp where";
			$MySelectQry .= " company_id=?";MYSQL_BuildArray("company_id",$company_id,"s");
			$MySelectQry .= " and sales_id=?";MYSQL_BuildArray("sales_id",$sales_id,"s");
			$MySelectQry .= " and sp.product_id=st.product_id)";
			$MyDbResult =  MyDbQuery($MySelectQry,$_GVParamArray);	
			$MyNumRows = MyDbNumRows($MyDbResult);
			
			if($MyNumRows > 0)
			{
				echo "<br>Sales Id : ".$sales_id;
				
				echo "<br>Product Id List :";
				
				while($MyRowData = mysqli_fetch_array($MyDbResult, MYSQLI_ASSOC)) 
				{	
					echo "<br>".GVStringFormat($MyRowData['product_id']);
				}
				MyDbFreeResult($MyDbResult);
			}
		}
		MyDbFreeResult($MyDbResultMain);
	}
	if($action == "PURCHASEFIXCHK")
	{
		$MySelectQryMain = "select purchase_id from purchase_info where";
		$MySelectQryMain .= " company_id=?";MYSQL_BuildArray("company_id",$company_id,"s");
		$MySelectQryMain .= " order by purchase_id asc";
		$MyDbResultMain =  MyDbQuery($MySelectQryMain,$_GVParamArray);	
		while($MyRowDataMain = mysqli_fetch_array($MyDbResultMain, MYSQLI_ASSOC)) 
		{
			$purchase_id = GVStringFormat($MyRowDataMain['purchase_id']);
			
			$MySelectQry = " select product_id from stock_track as st where";
			$MySelectQry .= " company_id=?";MYSQL_BuildArray("company_id",$company_id,"s");
			$MySelectQry .= " and purchase_id=?";MYSQL_BuildArray("purchase_id",$purchase_id,"s");
			$MySelectQry .= " and not exists(select product_id from purchase_product as sp where";
			$MySelectQry .= " company_id=?";MYSQL_BuildArray("company_id",$company_id,"s");
			$MySelectQry .= " and purchase_id=?";MYSQL_BuildArray("purchase_id",$purchase_id,"s");
			$MySelectQry .= " and sp.product_id=st.product_id)";
			$MyDbResult =  MyDbQuery($MySelectQry,$_GVParamArray);	
			$MyNumRows = MyDbNumRows($MyDbResult);
			
			if($MyNumRows > 0)
			{
				echo "<br>Purchase Id : ".$sales_id;
				
				echo "<br>Product Id List :";
				
				while($MyRowData = mysqli_fetch_array($MyDbResult, MYSQLI_ASSOC)) 
				{	
					echo "<br>".GVStringFormat($MyRowData['product_id']);
				}
				MyDbFreeResult($MyDbResult);
			}
		}
		MyDbFreeResult($MyDbResultMain);
	}
	else if($action == "PROFITFIX")
	{
		$MySelectQryMain = "select sales_id,discount_amount from sales_info where";
		$MySelectQryMain .= " company_id=?";MYSQL_BuildArray("company_id",$company_id,"s");
		$MySelectQryMain .= " order by sales_id asc";
		$MyDbResultMain =  MyDbQuery($MySelectQryMain,$_GVParamArray);	
		while($MyRowDataMain = mysqli_fetch_array($MyDbResultMain, MYSQLI_ASSOC)) 
		{
			$sales_id = GVStringFormat($MyRowDataMain['sales_id']);
			$discount_amount = GVformatAmount(GVStringFormat($MyRowDataMain['discount_amount']));
			
			$totSalesPdtCost = 0;
			$totPurchasePdtCost = 0;
			$sales_profit = 0;
			
			$MySelectQry = "select sum(total_amt) as totSalesCost,sum(tot_price) as totProductCost from stock_track where";
			$MySelectQry .= " company_id=?";MYSQL_BuildArray("company_id",$company_id,"s");
			$MySelectQry .= " and sales_id=?";MYSQL_BuildArray("sales_id",$sales_id,"s");
			$MySelectQry .= " and stock_type=?";MYSQL_BuildArray("stock_type","S","s");
			$MySelectQry .= " and delete_ind=?";MYSQL_BuildArray("delete_ind",'0',"s");
			$MyDbResult =  MyDbQuery($MySelectQry,$_GVParamArray);	
			if($MyRowData = mysqli_fetch_array($MyDbResult, MYSQLI_ASSOC)) 
			{
				$totSalesPdtCost = GVformatAmount(GVStringFormat($MyRowData['totSalesCost']));
				$totPurchasePdtCost = GVformatAmount(GVStringFormat($MyRowData['totProductCost']));
			}
			MyDbFreeResult($MyDbResult);
			
			$sales_profit = GVformatAmount($totSalesPdtCost - $totPurchasePdtCost - $discount_amount);
			
			$_GVParamArray[] = array("KEY"=>"sales_profit", "VAL"=>$sales_profit, "TYPE"=>"s");
			
			$outParamArr = GVgetQueryString($_GVParamArray);
	
			$MyUpdateQry = "update sales_info set ".$outParamArr['_UPDATE_SQLQRY_VAL']." where ";
			$MyUpdateQry .= " company_id=?";MYSQL_BuildArray("company_id",$company_id,"s");
			$MyUpdateQry .= " and sales_id=?";MYSQL_BuildArray("sales_id",$sales_id,"s");
			MyDbQuery($MyUpdateQry, $_GVParamArray);
			
			echo "<br>".$sales_id." - ".$sales_profit;
		}
		MyDbFreeResult($MyDbResultMain);
	}
	else if($action == "PDTPROFITFIX")
	{
		$MySelectQryMain = "select product_id from product_info where";
		$MySelectQryMain .= " company_id=?";MYSQL_BuildArray("company_id",$company_id,"s");
		$MySelectQryMain .= " order by product_id asc";
		$MyDbResultMain =  MyDbQuery($MySelectQryMain,$_GVParamArray);	
		while($MyRowDataMain = mysqli_fetch_array($MyDbResultMain, MYSQLI_ASSOC)) 
		{
			$product_id = GVStringFormat($MyRowDataMain['product_id']);
			
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
			
			$_GVParamArray[] = array("KEY"=>"product_profit", "VAL"=>$totPdtProfit, "TYPE"=>"s");
			
			$outParamArr = GVgetQueryString($_GVParamArray);
			
			$MyUpdateQry = "update product_info set ".$outParamArr['_UPDATE_SQLQRY_VAL']." where ";
			$MyUpdateQry .= " company_id=?";MYSQL_BuildArray("company_id",$company_id,"s");
			$MyUpdateQry .= " and product_id=?";MYSQL_BuildArray("product_id",$product_id,"s");
			$MyUpdateQry .= " and delete_ind=?";MYSQL_BuildArray("delete_ind","0","s");
			MyDbQuery($MyUpdateQry, $_GVParamArray);
			
			echo "<br>".$product_id." - ".$totPdtProfit;
		}
		MyDbFreeResult($MyDbResultMain);
	}
	
	include_once("gv_footer.php"); 
?>