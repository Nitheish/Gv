<?
	if($GVSaveBtn)
	{
		include("gv_header.php");
		GVmasterAuth();
	
		$LoadHtmlPage = "gv_purchase_pay";
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
		
		$txtOverallAmount = 0;
		
		if($ErrorInd == 0)
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
			
			$paidAmt = 0;
			$MySelectQry = "select sum(pay_amount) as paid_amt from purchase_pay_info where";
			$MySelectQry .= " company_id=?";MYSQL_BuildArray("company_id",$company_id,"s");
			$MySelectQry .= " and purchase_id=?";MYSQL_BuildArray("purchase_id",$GVID,"s");
			
			if($GVSTEP == "EDIT")
			{
				$MySelectQry .= " and purchase_pay_info_id!=?";MYSQL_BuildArray("purchase_pay_info_id",$GVID1,"s");
			}
			
			$MyDbResult =  MyDbQuery($MySelectQry,$_GVParamArray);	
			if($MyRowData = mysqli_fetch_array($MyDbResult, MYSQLI_ASSOC)) 
			{
				$paid_amt = GVformatAmount(GVStringFormat($MyRowData['paid_amt']));
			}
			MyDbFreeResult($MyDbResult);
			
			$balanceAmt = GVformatAmount($txtOverallAmount - $paid_amt);
			
			if($txtPayAmt > $balanceAmt)
			{
				GVSetErrorCodes("txtPayAmt","Customer have to pay Rs ".$balanceAmt." only");
			}
		}
			
		if($ErrorInd == 0)
		{
			$txtPayAmt = (float)$txtPayAmt;
			$txtPayDate = GVGetDateDBformat($txtPayDate);
			
			if($GVSTEP == "ADD")
			{
				$_GVParamArray[] = array("KEY"=>"company_id", "VAL"=>$company_id, "TYPE"=>"s");
				$_GVParamArray[] = array("KEY"=>"purchase_id", "VAL"=>$GVID, "TYPE"=>"s");
				$_GVParamArray[] = array("KEY"=>"pay_date", "VAL"=>$txtPayDate, "TYPE"=>"s");
				$_GVParamArray[] = array("KEY"=>"payment_type", "VAL"=>$cboPayType, "TYPE"=>"s");
				$_GVParamArray[] = array("KEY"=>"pay_amount", "VAL"=>$txtPayAmt, "TYPE"=>"s");
				
				if($cboPayType != "CASH")
					$_GVParamArray[] = array("KEY"=>"payment_refrence", "VAL"=>$txtPayReference, "TYPE"=>"s");
				else
					$_GVParamArray[] = array("KEY"=>"payment_refrence", "VAL"=>'', "TYPE"=>"s");
					
				$outParamArr = GVgetQueryString($_GVParamArray);
				
				$MyInsertQry = "insert into purchase_pay_info (".$outParamArr['_INSERT_SQLQRY_FIELDS'].") values(".$outParamArr['_INSERT_SQLQRY_VAL'].")";
				MyDbQuery($MyInsertQry, $_GVParamArray);
			}
			else
			{
				$_GVParamArray[] = array("KEY"=>"pay_date", "VAL"=>$txtPayDate, "TYPE"=>"s");
				$_GVParamArray[] = array("KEY"=>"payment_type", "VAL"=>$cboPayType, "TYPE"=>"s");
				$_GVParamArray[] = array("KEY"=>"pay_amount", "VAL"=>$txtPayAmt, "TYPE"=>"s");
				
				if($cboPayType != "CASH")
					$_GVParamArray[] = array("KEY"=>"payment_refrence", "VAL"=>$txtPayReference, "TYPE"=>"s");
				else
					$_GVParamArray[] = array("KEY"=>"payment_refrence", "VAL"=>'', "TYPE"=>"s");
				
				$outParamArr = GVgetQueryString($_GVParamArray);
				
				$MyUpdateQry = "update purchase_pay_info set ".$outParamArr['_UPDATE_SQLQRY_VAL']." where ";
				$MyUpdateQry .= " company_id=?";MYSQL_BuildArray("company_id",$company_id,"s");
				$MyUpdateQry .= " and purchase_id=?";MYSQL_BuildArray("purchase_id",$GVID,"s");
				$MyUpdateQry .= " and purchase_pay_info_id=?";MYSQL_BuildArray("purchase_pay_info_id",$GVID1,"s");
				MyDbQuery($MyUpdateQry, $_GVParamArray);
			}
			
			include("gv_purchase_pay_cal.php");
			
			GVPopSaveLoadURL("../backend/gv_page_redirect",GVstringEncrption("LoadHtmlPage=gv_purchase_info_view&GVmenu=$GVmenu&GVsubMenu=$GVsubMenu&GVSTEP=EDIT&GVID=$GVID"));
		}
		else
		{
			include("../html/".$LoadHtmlPage.".html");
		}
		
		include("gv_footer.php");
	}
?>