<?
	if($GVSaveBtn)
	{
		include("gv_header.php");
		GVmasterAuth();
		include("../info/gv_sales_info.php");
		
		$LoadHtmlPage = "gv_sales_info";
		$ErrorInd = 0;
		
		$cboCustomer = GVfixedInputText($cboCustomer);
		$txtSalesDate = GVfixedInputText($txtSalesDate);
		$rdoSalesTypeInd = GVfixedInputText($rdoSalesTypeInd);
		$txtRemarks = GVfixedInputText($txtRemarks);
		$rdoDiscountInd = GVfixedInputText($rdoDiscountInd);
		$txtPercent = GVfixedInputText($txtPercent);
		$txtDiscountAmount = GVfixedInputText($txtDiscountAmount);
		$txtTransportAmount = GVfixedInputText($txtTransportAmount);
		$totItem = GVfixedInputText($totItem);

		if($cboCustomer < 0)
			GVSetErrorCodes("cboCustomer","Please select the customer");
		
		if(!GVcheckDate($txtSalesDate))
			GVSetErrorCodes("txtSalesDate","Please select valid date");
		
		if($rdoDiscountInd == 1)
		{	
			if(!GVisNumeric($txtPercent))
			{
				GVSetErrorCodes("txtPercent","Please enter the valid percentage");
			}
			else if($txtPercent > 100)
			{
				GVSetErrorCodes("txtPercent","Please enter percentage value less than or equal to 100%");
			}
		}
		else
		{
			if(!GVisNumeric($txtDiscountAmount))
			{
				GVSetErrorCodes("txtDiscountAmount","Please enter Amount value");
			}
		}
		
		if(!GVisNumeric($txtTransportAmount))
		{
			GVSetErrorCodes("txtTransportAmount","Please enter Amount value");
		}
		
		$existingProdDetArr = array();
		
		if($GVSTEP == "EDIT")
		{
			$MySelectQry = "select product_id,product_quantity from sales_product where";
			$MySelectQry .= " company_id=?";MYSQL_BuildArray("company_id",$company_id,"s");
			$MySelectQry .= " and sales_id=?";MYSQL_BuildArray("sales_id",$GVID,"s");
			$MyDbResult =  MyDbQuery($MySelectQry,$_GVParamArray);
			while($MyRowData = mysqli_fetch_array($MyDbResult, MYSQLI_ASSOC)) 
			{
				$existingProdDetArr[GVStringFormat($MyRowData['product_id'])] = GVStringFormat($MyRowData['product_quantity']);
			}
			MyDbFreeResult($MyDbResult);
		}
		
		$salesProdChkArr = array();
		$productSelectedInd = 0;
		
		for($incr = 1;$incr <= $totItem; $incr++)
		{
			$cboProductName = "cboProductName".$incr;
			$txtQuantity = "txtQuantity".$incr;
			$txtRate = "txtRate".$incr;
			$txtAmount = "txtAmount".$incr;
			
			${$cboProductName} = GVfixedInputText(${$cboProductName});
			${$txtQuantity} = GVfixedInputText(${$txtQuantity});
			${$txtRate} = GVfixedInputText(${$txtRate});
			
			if(${$cboProductName} != "")
			{
				if(!GVisNumeric(${$cboProductName}) || !array_key_exists(${$cboProductName}, $ProductArr))
				{
					GVSetErrorCodes("$cboProductName","Please select the valid product");
				}
				
				if($GVSTEP == "EDIT" && array_key_exists(${$cboProductName}, $existingProdDetArr))
				{
					$stockCnt =(int) ($ProductQtyArr[${$cboProductName}] + $existingProdDetArr[${$cboProductName}]);
				}
				else
				{
					$stockCnt =(int) $ProductQtyArr[${$cboProductName}];
				}
				
				if(in_array(${$cboProductName},$salesProdChkArr))
				{
					GVSetErrorCodes("$cboProductName","This product already entered.");
				}
				else
				{
					$salesProdChkArr[] = ${$cboProductName};
				}
				
				if(!GVisNumeric(${$txtQuantity}))
				{
					GVSetErrorCodes("$txtQuantity","Please enter numeric value");
				}
				else if(${$txtQuantity} == 0)
				{
					GVSetErrorCodes("$txtQuantity","Please enter the number of quantity");
				}
				else if(${$txtQuantity} > $stockCnt)
				{
					GVSetErrorCodes("$txtQuantity","Availble only $stockCnt qunatity");
				}
				
				if(!GVisNumeric(${$txtRate}))
				{
					GVSetErrorCodes("$txtRate","Please enter Amount value");
				}
				else if(${$txtRate} == 0)
				{
					GVSetErrorCodes("$txtRate","Please enter the product rate");
				}
				
				$productSelectedInd = 1;
			}
		}
		
		if($totItem == 1)
		{
			$cboProductName = "cboProductName".$totItem;
			
			if(!GVisNumeric(${$cboProductName}) || !array_key_exists(${$cboProductName}, $ProductArr))
				GVSetErrorCodes("$cboProductName","Please select the valid product");
		}
		
		if($totItem == 0 || $productSelectedInd == 0)
		{
			GVSetErrorCodes("productListErr","Please enter atleast one product");
		}
		
		if($ErrorInd == 0)
		{
			$txtTransportAmount 	= (float) $txtTransportAmount;
			$txtPercent 		= (float) $txtPercent;
			$txtDiscountAmount 	= (float) $txtDiscountAmount;
			$rdoSalesTypeInd 	= (int) $rdoSalesTypeInd;
			$txtSalesDate 		= GVGetDateDBformat($txtSalesDate);
			$rdoDiscountInd		= (int) $rdoDiscountInd;
			
			$txtTotalQty 		= 0;
			$txtTotalAmount 	= 0;
			$txtOverallAmount 	= 0;
			
			$productDetailsArr = array();
			$currentProdIDArr = array();
			
			for($incr = 1;$incr <= $totItem; $incr++)
			{
				$cboProductName = "cboProductName".$incr;
				$txtQuantity = "txtQuantity".$incr;
				$txtRate = "txtRate".$incr;
				$txtAmount = "txtAmount".$incr;
				
				if(${$cboProductName} != "")
				{
					$productID = ${$cboProductName};
					${$txtAmount} = ${$txtQuantity} * ${$txtRate};
					
					$productDetailsArr[$productID]["QTY"] += ${$txtQuantity};
					$productDetailsArr[$productID]["RATE"] = GVformatAmount(${$txtRate});
					$productDetailsArr[$productID]["AMT"] += GVformatAmount(${$txtAmount});
					$productDetailsArr[$productID]["NAME"] = $ProductArr[$productID];
					
					$txtTotalQty += ${$txtQuantity};
					$txtTotalAmount += ${$txtAmount};
					
					$currentProdIDArr[$productID] = $productID;
				}
			}
			
			$txtTotalAmount = GVformatAmount($txtTotalAmount);
			
			if($rdoDiscountInd == 1)
				$txtDiscountAmount = GVformatAmount(($txtTotalAmount * $txtPercent) / 100);
			else
				$txtPercent = "0.00";
			
			$txtOverallAmount = GVformatAmount($txtTotalAmount + $txtTransportAmount - $txtDiscountAmount);
			
			$existingProdIDArr = array();
			$saleCode = "";
			
			if($GVSTEP == "ADD")
			{
				$_GVParamArray[] = array("KEY"=>"company_id", "VAL"=>$company_id, "TYPE"=>"s");
				$outParamArr = GVgetQueryString($_GVParamArray);
				
				$MyInsertQry = "insert into sales_info (".$outParamArr['_INSERT_SQLQRY_FIELDS'].") values(".$outParamArr['_INSERT_SQLQRY_VAL'].")";
				MyDbQuery($MyInsertQry, $_GVParamArray);
				
				$MySelectQry = "select max(sales_id) as MaxId from sales_info where";
				$MySelectQry .= " company_id=?";MYSQL_BuildArray("company_id",$company_id,"s");
				$MyDbResult =  MyDbQuery($MySelectQry,$_GVParamArray);	
				if($MyRowData = mysqli_fetch_array($MyDbResult, MYSQLI_ASSOC)) 
				{
					$GVID = GVStringFormat($MyRowData['MaxId']);
				}
				MyDbFreeResult($MyDbResult);
				
				$saleCode = "SL".$GVID;
			}
			else
			{
				$MySelectQry = "select product_id from sales_product where";
				$MySelectQry .= " company_id=?";MYSQL_BuildArray("company_id",$company_id,"s");
				$MySelectQry .= " and sales_id=?";MYSQL_BuildArray("sales_id",$GVID,"s");
				$MyDbResult =  MyDbQuery($MySelectQry,$_GVParamArray);	
				while($MyRowData = mysqli_fetch_array($MyDbResult, MYSQLI_ASSOC)) 
				{	
					$existingProdIDArr[GVStringFormat($MyRowData['product_id'])] = GVStringFormat($MyRowData['product_id']);
				}
				MyDbFreeResult($MyDbResult);
				
				$MySelectQry = "select product_id from stock_track where";
				$MySelectQry .= " company_id=?";MYSQL_BuildArray("company_id",$company_id,"s");
				$MySelectQry .= " and sales_id=?";MYSQL_BuildArray("sales_id",$GVID,"s");
				$MyDbResult =  MyDbQuery($MySelectQry,$_GVParamArray);	
				while($MyRowData = mysqli_fetch_array($MyDbResult, MYSQLI_ASSOC)) 
				{	
					$existingProdIDArr[GVStringFormat($MyRowData['product_id'])] = GVStringFormat($MyRowData['product_id']);
				}
				MyDbFreeResult($MyDbResult);
			}
			
			if($GVSTEP == "ADD")
			{
				$_GVParamArray[] = array("KEY"=>"sales_code", "VAL"=>$saleCode, "TYPE"=>"s");
			}
			
			$_GVParamArray[] = array("KEY"=>"customer_id", "VAL"=>$cboCustomer, "TYPE"=>"s");
			$_GVParamArray[] = array("KEY"=>"sales_date", "VAL"=>$txtSalesDate, "TYPE"=>"s");
			$_GVParamArray[] = array("KEY"=>"sales_type", "VAL"=>$rdoSalesTypeInd, "TYPE"=>"s");
			$_GVParamArray[] = array("KEY"=>"remarks", "VAL"=>$txtRemarks, "TYPE"=>"s");
			$_GVParamArray[] = array("KEY"=>"tot_qty", "VAL"=>$txtTotalQty, "TYPE"=>"s");
			$_GVParamArray[] = array("KEY"=>"discount_type", "VAL"=>$rdoDiscountInd, "TYPE"=>"s");
			$_GVParamArray[] = array("KEY"=>"discount_percent", "VAL"=>$txtPercent, "TYPE"=>"s");
			$_GVParamArray[] = array("KEY"=>"discount_amount", "VAL"=>$txtDiscountAmount, "TYPE"=>"s");
			$_GVParamArray[] = array("KEY"=>"ship_hand_amt", "VAL"=>$txtTransportAmount, "TYPE"=>"s");
			$_GVParamArray[] = array("KEY"=>"tot_amount", "VAL"=>$txtTotalAmount, "TYPE"=>"s");
			$_GVParamArray[] = array("KEY"=>"overall_amount", "VAL"=>$txtOverallAmount, "TYPE"=>"s");
			
			$outParamArr = GVgetQueryString($_GVParamArray);
			
			$MyUpdateQry = "update sales_info set ".$outParamArr['_UPDATE_SQLQRY_VAL']." where ";
			$MyUpdateQry .= " company_id=?";MYSQL_BuildArray("company_id",$company_id,"s");
			$MyUpdateQry .= " and sales_id=?";MYSQL_BuildArray("sales_id",$GVID,"s");
			MyDbQuery($MyUpdateQry, $_GVParamArray);
			
			foreach($productDetailsArr as $productID=>$prodDetArr)
			{
				$txtQuantity = $prodDetArr["QTY"];
				$txtRate = $prodDetArr["RATE"];
				$txtAmount = $prodDetArr["AMT"];
				$productName = $prodDetArr["NAME"];
				
				if($GVSTEP == "ADD")
				{
					$_GVParamArray[] = array("KEY"=>"company_id", "VAL"=>$company_id, "TYPE"=>"s");
					$_GVParamArray[] = array("KEY"=>"sales_id", "VAL"=>$GVID, "TYPE"=>"s");
					$_GVParamArray[] = array("KEY"=>"product_id", "VAL"=>$productID, "TYPE"=>"s");
					$_GVParamArray[] = array("KEY"=>"product_name", "VAL"=>$productName, "TYPE"=>"s");
					
					$_GVParamArray[] = array("KEY"=>"product_quantity", "VAL"=>$txtQuantity, "TYPE"=>"s");
					$_GVParamArray[] = array("KEY"=>"product_price", "VAL"=>$txtRate, "TYPE"=>"s");
					$_GVParamArray[] = array("KEY"=>"product_tot_amount", "VAL"=>$txtAmount, "TYPE"=>"s");
					
					$outParamArr = GVgetQueryString($_GVParamArray);
					
					$MyInsertQry = "insert into sales_product (".$outParamArr['_INSERT_SQLQRY_FIELDS'].") values(".$outParamArr['_INSERT_SQLQRY_VAL'].")";
					MyDbQuery($MyInsertQry, $_GVParamArray);
				}
				else
				{
					if(array_key_exists($productID, $existingProdIDArr))
					{
						$_GVParamArray[] = array("KEY"=>"product_quantity", "VAL"=>$txtQuantity, "TYPE"=>"s");
						$_GVParamArray[] = array("KEY"=>"product_price", "VAL"=>$txtRate, "TYPE"=>"s");
						$_GVParamArray[] = array("KEY"=>"product_tot_amount", "VAL"=>$txtAmount, "TYPE"=>"s");
						$_GVParamArray[] = array("KEY"=>"modified_datetime", "VAL"=>"CURRENT_TIMESTAMP()", "TYPE"=>"SKIP");
						
						$outParamArr = GVgetQueryString($_GVParamArray);
						
						$MyUpdateQry = "update sales_product set ".$outParamArr['_UPDATE_SQLQRY_VAL']." where ";
						$MyUpdateQry .= " company_id=?";MYSQL_BuildArray("company_id",$company_id,"s");
						$MyUpdateQry .= " and sales_id=?";MYSQL_BuildArray("sales_id",$GVID,"s");
						$MyUpdateQry .= " and product_id=?";MYSQL_BuildArray("product_id",$productID,"s");
						MyDbQuery($MyUpdateQry, $_GVParamArray);
					}
					else
					{
						$_GVParamArray[] = array("KEY"=>"company_id", "VAL"=>$company_id, "TYPE"=>"s");
						$_GVParamArray[] = array("KEY"=>"sales_id", "VAL"=>$GVID, "TYPE"=>"s");
						$_GVParamArray[] = array("KEY"=>"product_id", "VAL"=>$productID, "TYPE"=>"s");
						$_GVParamArray[] = array("KEY"=>"product_name", "VAL"=>$productName, "TYPE"=>"s");
						$_GVParamArray[] = array("KEY"=>"product_quantity", "VAL"=>$txtQuantity, "TYPE"=>"s");
						$_GVParamArray[] = array("KEY"=>"product_price", "VAL"=>$txtRate, "TYPE"=>"s");
						$_GVParamArray[] = array("KEY"=>"product_tot_amount", "VAL"=>$txtAmount, "TYPE"=>"s");
						
						$outParamArr = GVgetQueryString($_GVParamArray);
						
						$MyInsertQry = "insert into sales_product (".$outParamArr['_INSERT_SQLQRY_FIELDS'].") values(".$outParamArr['_INSERT_SQLQRY_VAL'].")";
						MyDbQuery($MyInsertQry, $_GVParamArray);
					}
				}
			}
			
			$delProdIDArr = array();
				
			if($GVSTEP == "EDIT")
			{
				$delProdIDArr = array_diff($existingProdIDArr,$currentProdIDArr);
				
				if(count($delProdIDArr) > 0)
				{
					$MyDeleteQry = "delete from sales_product where ";
					$MyDeleteQry .= " company_id=?";MYSQL_BuildArray("company_id",$company_id,"s");
					$MyDeleteQry .= " and sales_id=?";MYSQL_BuildArray("sales_id",$GVID,"s");
					$MyDeleteQry .= " and product_id in (".MYSQL_ArrayBuild_String($delProdIDArr).")";MYSQL_BuildArray("product_id",$delProdIDArr,"s");
					MyDbQuery($MyDeleteQry, $_GVParamArray);
				}
			}
			
			$prodCalArr = array(); 
			$prodCalArr = $currentProdIDArr;
			
			foreach($existingProdIDArr as $key=>$val)
			{
				if(!in_array($val,$prodCalArr))
				  $prodCalArr[$val] = $val; 
			}
			
			include("gv_product_sales_cal.php");
			
			$totSalesPdtCost = 0;
			$totPurchasePdtCost = 0;
			$sales_profit = 0;
			
			$MySelectQry = "select sum(total_amt) as totSalesCost,sum(tot_price) as totProductCost from stock_track where";
			$MySelectQry .= " company_id=?";MYSQL_BuildArray("company_id",$company_id,"s");
			$MySelectQry .= " and sales_id=?";MYSQL_BuildArray("sales_id",$GVID,"s");
			$MySelectQry .= " and stock_type=?";MYSQL_BuildArray("stock_type","S","s");
			$MySelectQry .= " and delete_ind=?";MYSQL_BuildArray("delete_ind",'0',"s");
			$MyDbResult =  MyDbQuery($MySelectQry,$_GVParamArray);	
			if($MyRowData = mysqli_fetch_array($MyDbResult, MYSQLI_ASSOC)) 
			{
				$totSalesPdtCost = GVformatAmount(GVStringFormat($MyRowData['totSalesCost']));
				$totPurchasePdtCost = GVformatAmount(GVStringFormat($MyRowData['totProductCost']));
			}
			MyDbFreeResult($MyDbResult);
			
			$sales_profit = GVformatAmount($totSalesPdtCost - $totPurchasePdtCost - $txtDiscountAmount);
			
			$frmSalesInfoInd = 1;
			include("gv_sales_pay_cal.php");
			
			$GVSTEP = "EDIT";
			
			$LoadHtmlPage = "gv_sales_info_view";
		}
		
		include("../html/".$LoadHtmlPage.".html");
		
		include("gv_footer.php");
	}
?>