<?
	if($GVSaveBtn)
	{
		include("gv_header.php");
		GVmasterAuth();
	
		if($GVSTEP == "DELETE")
		{
			$MySelectQry = "select expense_date,expense_type,expense_amount from expenses_info where";
			$MySelectQry .= " company_id=?";MYSQL_BuildArray("company_id",$company_id,"s");
			$MySelectQry .= " and expenses_info_id=?";MYSQL_BuildArray("expenses_info_id",$GVID,"s");
			$MyDbResult =  MyDbQuery($MySelectQry,$_GVParamArray);	
			if($MyRowData = mysqli_fetch_array($MyDbResult, MYSQLI_ASSOC)) 
			{
				$txtExpenseDate = GVGetUserDateformat(GVStringFormat($MyRowData['expense_date']))	;
				$cboExpenseType = GVStringFormat($MyRowData['expense_type']);
				$txtExpenseAmt = GVCurrecyFormat(GVformatAmount(GVStringFormat($MyRowData['expense_amount'])));
				
				$MyDeleteQry = "delete from expenses_info where ";
				$MyDeleteQry .= " company_id=?";MYSQL_BuildArray("company_id",$company_id,"s");
				$MyDeleteQry .= " and expenses_info_id=?";MYSQL_BuildArray("expenses_info_id",$GVID,"s");
				MyDbQuery($MyDeleteQry, $_GVParamArray);
				
				$gv_action = "$cboExpenseType ($txtExpenseDate - $txtExpenseAmt) - Expense Information Deleted";
				include("gv_action_history.php");
			}
			MyDbFreeResult($MyDbResult);
		}	
		
		GVPopSaveLoad();
		
		include("gv_footer.php");
	}
?>