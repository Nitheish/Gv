<?
	if($GVSaveBtn)
	{
		include("gv_header.php");
		GVmasterAuth();
	
		$LoadHtmlPage = "gv_sales_overall_pay";
		$ErrorInd = 0;
		
		$txtPayDate = GVfixedInputText($txtPayDate);
		$cboPayType = GVfixedInputText($cboPayType);
		$txtPayAmt = GVfixedInputText($txtPayAmt);
		
		if(!GVcheckDate($txtPayDate))
			GVSetErrorCodes("txtPayDate","Please select valid date");
			
		if(!GVisNumeric($txtPayAmt))
		{
			GVSetErrorCodes("txtPayAmt","Please enter Amount value");
		}
		else if(round($txtPayAmt) == 0)
		{
			GVSetErrorCodes("txtPayAmt","Please enter Amount value greater than zero");
		}
		
		$txtBalanceDue = 0;
		$MySelectQry = "select sum(balance_due) as balance_due from sales_info where ";
		$MySelectQry .= " company_id=?";MYSQL_BuildArray("company_id",$company_id,"s");
		$MySelectQry .= " and customer_id=?";MYSQL_BuildArray("customer_id",$GVID1,"s");
		$MySelectQry .= " and delete_ind=?";MYSQL_BuildArray("delete_ind","0","s");
		$MyDbResult =  MyDbQuery($MySelectQry,$_GVParamArray);
		while($MyRowData = mysqli_fetch_array($MyDbResult, MYSQLI_ASSOC)) 
		{
			$txtBalanceDue = GVformatAmount(GVStringFormat($MyRowData['balance_due']));
		}
		MyDbFreeResult($MyDbResult);
		
		$SalesIdArr = array();
		$MySelectQry = "select sales_id,balance_due from sales_info where ";
		$MySelectQry .= " company_id=?";MYSQL_BuildArray("company_id",$company_id,"s");
		$MySelectQry .= " and customer_id=?";MYSQL_BuildArray("customer_id",$GVID1,"s");
		$MySelectQry .= " and delete_ind=?";MYSQL_BuildArray("delete_ind","0","s");
		$MySelectQry .= " and balance_due>?";MYSQL_BuildArray("balance_due","0","s");
		$MySelectQry .= " order by sales_id asc"; 
		$MyDbResult =  MyDbQuery($MySelectQry,$_GVParamArray);
		while($MyRowData = mysqli_fetch_array($MyDbResult, MYSQLI_ASSOC)) 
		{
			$SalesIdArr[GVStringFormat($MyRowData['sales_id'])] = GVformatAmount(GVStringFormat($MyRowData['balance_due']));
		}
		MyDbFreeResult($MyDbResult);
		
		if($ErrorInd == 0)
		{
			if($txtPayAmt > $txtBalanceDue)
			{
				GVSetErrorCodes("txtPayAmt","Customer have to pay Rs ".$txtBalanceDue." only");
			}
		}
			
		if($ErrorInd == 0)
		{
			$txtPayAmt = (float)$txtPayAmt;
			$txtPayDate = GVGetDateDBformat($txtPayDate);
			$pay_key = GVgenerateRandomKEY();
			$multiplePaidAmt = $txtPayAmt;
			
			foreach($SalesIdArr as $GVID=>$sales_due)
			{
				if($multiplePaidAmt > 0)
				{
					$nowPaidAmt = 0;
					if($sales_due >= $multiplePaidAmt)
					{
						$nowPaidAmt = $multiplePaidAmt;
					}
					else
					{
						$nowPaidAmt = $sales_due;
					}
					
					$nowPaidAmt = (float)$nowPaidAmt;
					
					$_GVParamArray[] = array("KEY"=>"company_id", "VAL"=>$company_id, "TYPE"=>"s");
					$_GVParamArray[] = array("KEY"=>"sales_id", "VAL"=>$GVID, "TYPE"=>"s");
					$_GVParamArray[] = array("KEY"=>"pay_date", "VAL"=>$txtPayDate, "TYPE"=>"s");
					$_GVParamArray[] = array("KEY"=>"payment_type", "VAL"=>$cboPayType, "TYPE"=>"s");
					$_GVParamArray[] = array("KEY"=>"pay_amount", "VAL"=>$nowPaidAmt, "TYPE"=>"s");
					$_GVParamArray[] = array("KEY"=>"overall_amount", "VAL"=>$txtPayAmt, "TYPE"=>"s");
					$_GVParamArray[] = array("KEY"=>"pay_key", "VAL"=>$pay_key, "TYPE"=>"s");
					
					if($cboPayType != "CASH")
						$_GVParamArray[] = array("KEY"=>"payment_refrence", "VAL"=>$txtPayReference, "TYPE"=>"s");
					else
						$_GVParamArray[] = array("KEY"=>"payment_refrence", "VAL"=>'', "TYPE"=>"s");
						
					$outParamArr = GVgetQueryString($_GVParamArray);
					
					$MyInsertQry = "insert into payment_info (".$outParamArr['_INSERT_SQLQRY_FIELDS'].") values(".$outParamArr['_INSERT_SQLQRY_VAL'].")";
					MyDbQuery($MyInsertQry, $_GVParamArray);
					
					$txtOverallAmount = 0;
					
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
					
					$multiplePaidAmt = GVformatAmount($multiplePaidAmt - $nowPaidAmt);
				}
			}
			
			GVPopSaveLoadURL("../backend/gv_page_redirect",GVstringEncrption("LoadHtmlPage=gv_customer_report&GVmenu=$GVmenu&GVsubMenu=$GVsubMenu"));
		}
		else
		{
			include("../html/".$LoadHtmlPage.".html");
		}
		
		include("gv_footer.php");
	}
?>