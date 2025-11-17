<?
	if($GVSaveBtn)
	{
		include("gv_header.php");
		GVmasterAuth();
	
		if($GVSTEP == "DELETE")
		{
			$salesPayDelInd = 0;
			$MySelectQry = "select pay_amount,pay_date,payment_type from payment_info where";
			$MySelectQry .= " company_id=?";MYSQL_BuildArray("company_id",$company_id,"s");
			$MySelectQry .= " and sales_id=?";MYSQL_BuildArray("sales_id",$GVID,"s");
			$MySelectQry .= " and payment_info_id=?";MYSQL_BuildArray("payment_info_id",$GVID1,"s");
			$MyDbResult =  MyDbQuery($MySelectQry,$_GVParamArray);	
			if($MyRowData = mysqli_fetch_array($MyDbResult, MYSQLI_ASSOC)) 
			{
				$pay_date = GVGetUserDateformat(GVStringFormat($MyRowData['pay_date']));
				$payment_type = GVStringFormat($MyRowData['payment_type']);
				$pay_amount = GVformatAmount(GVStringFormat($MyRowData['pay_amount']));
				
				$MyDeleteQry = "delete from payment_info where ";
				$MyDeleteQry .= " company_id=?";MYSQL_BuildArray("company_id",$company_id,"s");
				$MyDeleteQry .= " and sales_id=?";MYSQL_BuildArray("sales_id",$GVID,"s");
				$MyDeleteQry .= " and payment_info_id=?";MYSQL_BuildArray("payment_info_id",$GVID1,"s");
				MyDbQuery($MyDeleteQry, $_GVParamArray);
			
				$saleCode = "SL".$GVID;
				
				$gv_action = "$saleCode ($pay_date  - $payment_type - Rs.$pay_amount) Sales Payment Information Deleted";
				include("gv_action_history.php");
				
				$salesPayDelInd = 1;
			}
			MyDbFreeResult($MyDbResult);
			
			if($salesPayDelInd == 1)
			{
				$MySelectQry = "select overall_amount from sales_info where";
				$MySelectQry .= " company_id=?";MYSQL_BuildArray("company_id",$company_id,"s");
				$MySelectQry .= " and sales_id=?";MYSQL_BuildArray("sales_id",$GVID,"s");
				$MyDbResult =  MyDbQuery($MySelectQry,$_GVParamArray);	
				if($MyRowData = mysqli_fetch_array($MyDbResult, MYSQLI_ASSOC)) 
				{	
					$txtOverallAmount = GVformatAmount(GVStringFormat($MyRowData['overall_amount']));
				}
				MyDbFreeResult($MyDbResult);
			
				include("gv_sales_pay_cal.php");
			}
		}	
		
		GVPopSaveLoad();
		
		include("gv_footer.php");
	}
?>