<?
	if($GVSaveBtn)
	{
		include("gv_header.php");
		GVmasterAuth();
	
		$LoadHtmlPage = "gv_expense_info";
		$ErrorInd = 0;
		
		$txtExpenseDate = GVfixedInputText($txtExpenseDate);
		$cboExpenseType = GVfixedInputText($cboExpenseType);
		$cboPayType = GVfixedInputText($cboPayType);
		$txtExpenseAmt = GVfixedInputText($txtExpenseAmt);
		$txtRemarks = GVfixedInputText($txtRemarks);
		
		if(!GVcheckDate($txtExpenseDate))
			GVSetErrorCodes("txtExpenseDate","Please select valid date");
			
		if(!GVisNumeric($txtExpenseAmt))
		{
			GVSetErrorCodes("txtExpenseAmt","Please enter Amount value");
		}
		else if(round($txtExpenseAmt) == 0)
		{
			GVSetErrorCodes("txtExpenseAmt","Please enter Amount value greater than zero");
		}
		
		if($ErrorInd == 0)
		{
			$txtExpenseAmt = (float)$txtExpenseAmt;
			$txtExpenseDate = GVGetDateDBformat($txtExpenseDate);
			
			if($GVSTEP == "ADD")
			{
				$_GVParamArray[] = array("KEY"=>"company_id", "VAL"=>$company_id, "TYPE"=>"s");
				$_GVParamArray[] = array("KEY"=>"expense_type", "VAL"=>$cboExpenseType, "TYPE"=>"s");
				$_GVParamArray[] = array("KEY"=>"expense_date", "VAL"=>$txtExpenseDate, "TYPE"=>"s");
				$_GVParamArray[] = array("KEY"=>"payment_type", "VAL"=>$cboPayType, "TYPE"=>"s");
				$_GVParamArray[] = array("KEY"=>"expense_amount", "VAL"=>$txtExpenseAmt, "TYPE"=>"s");
				$_GVParamArray[] = array("KEY"=>"expense_remarks", "VAL"=>$txtRemarks, "TYPE"=>"s");
					
				$outParamArr = GVgetQueryString($_GVParamArray);
				
				$MyInsertQry = "insert into expenses_info (".$outParamArr['_INSERT_SQLQRY_FIELDS'].") values(".$outParamArr['_INSERT_SQLQRY_VAL'].")";
				MyDbQuery($MyInsertQry, $_GVParamArray);
			}
			else
			{
				$_GVParamArray[] = array("KEY"=>"expense_date", "VAL"=>$txtExpenseDate, "TYPE"=>"s");
				$_GVParamArray[] = array("KEY"=>"expense_type", "VAL"=>$cboExpenseType, "TYPE"=>"s");
				$_GVParamArray[] = array("KEY"=>"payment_type", "VAL"=>$cboPayType, "TYPE"=>"s");
				$_GVParamArray[] = array("KEY"=>"expense_amount", "VAL"=>$txtExpenseAmt, "TYPE"=>"s");
				$_GVParamArray[] = array("KEY"=>"expense_remarks", "VAL"=>$txtRemarks, "TYPE"=>"s");
				
				$outParamArr = GVgetQueryString($_GVParamArray);
				
				$MyUpdateQry = "update expenses_info set ".$outParamArr['_UPDATE_SQLQRY_VAL']." where ";
				$MyUpdateQry .= " company_id=?";MYSQL_BuildArray("company_id",$company_id,"s");
				$MyUpdateQry .= " and expenses_info_id=?";MYSQL_BuildArray("expenses_info_id",$GVID,"s");
				MyDbQuery($MyUpdateQry, $_GVParamArray);
			}
			
			GVPopSaveLoad();
		}
		else
		{
			include("../html/".$LoadHtmlPage.".html");
		}
		
		include("gv_footer.php");
	}
?>