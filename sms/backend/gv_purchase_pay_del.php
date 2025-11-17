<?
	if($GVSaveBtn)
	{
		include("gv_header.php");
		GVmasterAuth();
	
		if($GVSTEP == "DELETE")
		{
			$purchasePayDelInd = 0;
			$MySelectQry = "select pay_amount,pay_date,payment_type from purchase_pay_info where";
			$MySelectQry .= " company_id=?";MYSQL_BuildArray("company_id",$company_id,"s");
			$MySelectQry .= " and purchase_id=?";MYSQL_BuildArray("purchase_id",$GVID,"s");
			$MySelectQry .= " and purchase_pay_info_id=?";MYSQL_BuildArray("purchase_pay_info_id",$GVID1,"s");
			$MyDbResult =  MyDbQuery($MySelectQry,$_GVParamArray);	
			if($MyRowData = mysqli_fetch_array($MyDbResult, MYSQLI_ASSOC)) 
			{
				$pay_date = GVGetUserDateformat(GVStringFormat($MyRowData['pay_date']));
				$payment_type = GVStringFormat($MyRowData['payment_type']);
				$pay_amount = GVformatAmount(GVStringFormat($MyRowData['pay_amount']));
				
				$MyDeleteQry = "delete from purchase_pay_info where ";
				$MyDeleteQry .= " company_id=?";MYSQL_BuildArray("company_id",$company_id,"s");
				$MyDeleteQry .= " and purchase_id=?";MYSQL_BuildArray("purchase_id",$GVID,"s");
				$MyDeleteQry .= " and purchase_pay_info_id=?";MYSQL_BuildArray("purchase_pay_info_id",$GVID1,"s");
				MyDbQuery($MyDeleteQry, $_GVParamArray);
			
				$purchaseCode = "PC".$GVID;
				
				$gv_action = "$purchaseCode ($pay_date  - $payment_type - Rs.$pay_amount) Purchase Payment Information Deleted";
				include("gv_action_history.php");
				
				$purchasePayDelInd = 1;
			}
			MyDbFreeResult($MyDbResult);
			
			if($purchasePayDelInd == 1)
			{
				$MySelectQry = "select overall_amount from purchase_info where";
				$MySelectQry .= " company_id=?";MYSQL_BuildArray("company_id",$company_id,"s");
				$MySelectQry .= " and purchase_id=?";MYSQL_BuildArray("purchase_id",$GVID,"s");
				$MyDbResult =  MyDbQuery($MySelectQry,$_GVParamArray);	
				if($MyRowData = mysqli_fetch_array($MyDbResult, MYSQLI_ASSOC)) 
				{	
					$txtOverallAmount = GVformatAmount(GVStringFormat($MyRowData['overall_amount']));
				}
				MyDbFreeResult($MyDbResult);
				
				include("gv_purchase_pay_cal.php");
			}
		}	
		
		GVPopSaveLoad();
		
		include("gv_footer.php");
	}
?>