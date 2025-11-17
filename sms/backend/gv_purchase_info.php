<?
	if($GVSaveBtn)
	{
		include("gv_header.php");
		GVmasterAuth();
		include("../info/gv_purchase_info.php");
		
		$LoadHtmlPage = "gv_purchase_info";
		$ErrorInd = 0;
		
		$cboVendor = GVfixedInputText($cboVendor);
		$txtPurchaseDate = GVfixedInputText($txtPurchaseDate);
		$rdoPurchaseTypeInd = GVfixedInputText($rdoPurchaseTypeInd);
		$txtRemarks = GVfixedInputText($txtRemarks);
		$rdoDiscountInd = GVfixedInputText($rdoDiscountInd);
		$txtPercent = GVfixedInputText($txtPercent);
		$txtDiscountAmount = GVfixedInputText($txtDiscountAmount);
		$txtTransportAmount = GVfixedInputText($txtTransportAmount);
		$totItem = GVfixedInputText($totItem);
		$txtTotalGSTAmount = GVfixedInputText($txtTotalGSTAmount);

		if($cboVendor < 0)
			GVSetErrorCodes("cboVendor","Please select the vendor");
		
		if(!GVcheckDate($txtPurchaseDate))
			GVSetErrorCodes("txtPurchaseDate","Please select valid date");
		
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
		$existingProdAmtArr = array();
		
		if($GVSTEP == "EDIT")
		{
			$MySelectQry = "select product_id,product_quantity,product_tot_amount from purchase_product where";
			$MySelectQry .= " company_id=?";MYSQL_BuildArray("company_id",$company_id,"s");
			$MySelectQry .= " and purchase_id=?";MYSQL_BuildArray("purchase_id",$GVID,"s");
			$MyDbResult =  MyDbQuery($MySelectQry,$_GVParamArray);
			while($MyRowData = mysqli_fetch_array($MyDbResult, MYSQLI_ASSOC)) 
			{
				$existingProdDetArr[GVStringFormat($MyRowData['product_id'])] = GVStringFormat($MyRowData['product_quantity']);
				$existingProdAmtArr[GVStringFormat($MyRowData['product_id'])] = GVformatAmount(GVStringFormat($MyRowData['product_tot_amount']));
			}
			MyDbFreeResult($MyDbResult);
		}
		
		$purchaseProdChkArr = array();
		$productSelectedInd = 0;
		
		for($incr = 1;$incr <= $totItem; $incr++)
		{
			$cboProductName = "cboProductName".$incr;
			$txtQuantity = "txtQuantity".$incr;
			$txtRate = "txtRate".$incr;
			$txtGSTPercent = "txtGSTPercent".$incr;
			
			${$cboProductName} = GVfixedInputText(${$cboProductName});
			${$txtQuantity} = GVfixedInputText(${$txtQuantity});
			${$txtRate} = GVfixedInputText(${$txtRate});
			${$txtGSTPercent} = GVfixedInputText(${$txtGSTPercent});
			
			if(${$cboProductName} != "")
			{
				if(!GVisNumeric(${$cboProductName}) || !array_key_exists(${$cboProductName}, $ProductArr))
				{
					GVSetErrorCodes("$cboProductName","Please select the valid product");
				}
				
				if(in_array(${$cboProductName},$purchaseProdChkArr))
				{
					GVSetErrorCodes("$cboProductName","This product already entered.");
				}
				else
				{
					$purchaseProdChkArr[] = ${$cboProductName};
				}
				
				if(!GVisNumeric(${$txtQuantity}))
				{
					GVSetErrorCodes("$txtQuantity","Please enter numeric value");
				}
				else if(${$txtQuantity} == 0)
				{
					GVSetErrorCodes("$txtQuantity","Please enter the number of quantity");
				}
				
				if(!GVisNumeric(${$txtRate}))
				{
					GVSetErrorCodes("$txtRate","Please enter Amount value");
				}
				else if(${$txtRate} == 0)
				{
					GVSetErrorCodes("$txtRate","Please enter the product rate");
				}
				
				if(!GVisNumeric(${$txtGSTPercent}))
				{
					GVSetErrorCodes("$txtGSTPercent","Please enter the valid percentage");
				}
				else if(${$txtGSTPercent} > 100)
				{
					GVSetErrorCodes("$txtGSTPercent","Please enter percentage value less than or equal to 100%");
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
			$rdoPurchaseTypeInd 	= (int) $rdoPurchaseTypeInd;
			$txtPurchaseDate 	= GVGetDateDBformat($txtPurchaseDate);
			$rdoDiscountInd		= (int) $rdoDiscountInd;
			
			$txtTotalQty 		= 0;
			$txtTotalAmount 	= 0;
			$txtTotalGSTAmount 	= 0;
			$txtOverallAmount 	= 0;
			
			$productDetailsArr = array();
			$currentProdIDArr = array();
			
			for($incr = 1;$incr <= $totItem; $incr++)
			{
				$cboProductName = "cboProductName".$incr;
				$txtQuantity = "txtQuantity".$incr;
				$txtRate = "txtRate".$incr;
				$txtAmount = "txtAmount".$incr;
				$txtGSTPercent = "txtGSTPercent".$incr;
				
				if(${$cboProductName} != "")
				{
					$productID = ${$cboProductName};
					
					$gstAmt = GVformatAmount((${$txtQuantity} * ${$txtRate} * ${$txtGSTPercent}) / 100);
					
					${$txtAmount} = GVformatAmount((${$txtQuantity} * ${$txtRate}) + $gstAmt);
					
					$productDetailsArr[$productID]["QTY"] = ${$txtQuantity};
					$productDetailsArr[$productID]["RATE"] = GVformatAmount(${$txtRate});
					$productDetailsArr[$productID]["GSTPECENT"] = GVformatAmount(${$txtGSTPercent});
					$productDetailsArr[$productID]["GSTAMT"] = GVformatAmount($gstAmt);
					$productDetailsArr[$productID]["AMT"] = GVformatAmount(${$txtAmount});
					$productDetailsArr[$productID]["NAME"] = $ProductArr[$productID];
					
					$txtTotalQty += ${$txtQuantity};
					$txtTotalAmount += ${$txtAmount};
					$txtTotalGSTAmount += ${$gstAmt};
					
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
			$purchaseCode = "";
			
			if($GVSTEP == "ADD")
			{
				$_GVParamArray[] = array("KEY"=>"company_id", "VAL"=>$company_id, "TYPE"=>"s");
				$outParamArr = GVgetQueryString($_GVParamArray);
				
				$MyInsertQry = "insert into purchase_info (".$outParamArr['_INSERT_SQLQRY_FIELDS'].") values(".$outParamArr['_INSERT_SQLQRY_VAL'].")";
				MyDbQuery($MyInsertQry, $_GVParamArray);
				
				$MySelectQry = "select max(purchase_id) as MaxId from purchase_info where";
				$MySelectQry .= " company_id=?";MYSQL_BuildArray("company_id",$company_id,"s");
				$MyDbResult =  MyDbQuery($MySelectQry,$_GVParamArray);	
				if($MyRowData = mysqli_fetch_array($MyDbResult, MYSQLI_ASSOC)) 
				{
					$GVID = GVStringFormat($MyRowData['MaxId']);
				}
				MyDbFreeResult($MyDbResult);
				
				$purchaseCode = "PC".$GVID;
			}
			else
			{
				$MySelectQry = "select product_id from purchase_product where";
				$MySelectQry .= " company_id=?";MYSQL_BuildArray("company_id",$company_id,"s");
				$MySelectQry .= " and purchase_id=?";MYSQL_BuildArray("purchase_id",$GVID,"s");
				$MyDbResult =  MyDbQuery($MySelectQry,$_GVParamArray);	
				while($MyRowData = mysqli_fetch_array($MyDbResult, MYSQLI_ASSOC)) 
				{	
					$existingProdIDArr[GVStringFormat($MyRowData['product_id'])] = GVStringFormat($MyRowData['product_id']);
				}
				MyDbFreeResult($MyDbResult);
				
				$MySelectQry = "select product_id from stock_track where";
				$MySelectQry .= " company_id=?";MYSQL_BuildArray("company_id",$company_id,"s");
				$MySelectQry .= " and purchase_id=?";MYSQL_BuildArray("purchase_id",$GVID,"s");
				$MyDbResult =  MyDbQuery($MySelectQry,$_GVParamArray);	
				while($MyRowData = mysqli_fetch_array($MyDbResult, MYSQLI_ASSOC)) 
				{	
					$existingProdIDArr[GVStringFormat($MyRowData['product_id'])] = GVStringFormat($MyRowData['product_id']);
				}
				MyDbFreeResult($MyDbResult);
			}
			
			if($GVSTEP == "ADD")
			{
				$_GVParamArray[] = array("KEY"=>"purchase_code", "VAL"=>$purchaseCode, "TYPE"=>"s");
			}
			
			$_GVParamArray[] = array("KEY"=>"vendor_id", "VAL"=>$cboVendor, "TYPE"=>"s");
			$_GVParamArray[] = array("KEY"=>"purchase_date", "VAL"=>$txtPurchaseDate, "TYPE"=>"s");
			$_GVParamArray[] = array("KEY"=>"purchase_type", "VAL"=>$rdoPurchaseTypeInd, "TYPE"=>"s");
			$_GVParamArray[] = array("KEY"=>"remarks", "VAL"=>$txtRemarks, "TYPE"=>"s");
			$_GVParamArray[] = array("KEY"=>"tot_qty", "VAL"=>$txtTotalQty, "TYPE"=>"s");
			$_GVParamArray[] = array("KEY"=>"discount_type", "VAL"=>$rdoDiscountInd, "TYPE"=>"s");
			$_GVParamArray[] = array("KEY"=>"discount_percent", "VAL"=>$txtPercent, "TYPE"=>"s");
			$_GVParamArray[] = array("KEY"=>"discount_amount", "VAL"=>$txtDiscountAmount, "TYPE"=>"s");
			$_GVParamArray[] = array("KEY"=>"ship_hand_amt", "VAL"=>$txtTransportAmount, "TYPE"=>"s");
			$_GVParamArray[] = array("KEY"=>"tot_amount", "VAL"=>$txtTotalAmount, "TYPE"=>"s");
			$_GVParamArray[] = array("KEY"=>"overall_amount", "VAL"=>$txtOverallAmount, "TYPE"=>"s");
			$_GVParamArray[] = array("KEY"=>"gst_tot_amt", "VAL"=>$txtTotalGSTAmount, "TYPE"=>"s");
			
			$outParamArr = GVgetQueryString($_GVParamArray);
			
			$MyUpdateQry = "update purchase_info set ".$outParamArr['_UPDATE_SQLQRY_VAL']." where ";
			$MyUpdateQry .= " company_id=?";MYSQL_BuildArray("company_id",$company_id,"s");
			$MyUpdateQry .= " and purchase_id=?";MYSQL_BuildArray("purchase_id",$GVID,"s");
			MyDbQuery($MyUpdateQry, $_GVParamArray);
			
			foreach($productDetailsArr as $productID=>$prodDetArr)
			{
				$txtQuantity = $prodDetArr["QTY"];
				$txtRate = $prodDetArr["RATE"];
				$txtGSTPercent = $prodDetArr["GSTPECENT"];
				$txtGSTAmount = $prodDetArr["GSTAMT"];
				$txtAmount = $prodDetArr["AMT"];
				$productName = $prodDetArr["NAME"];
				
				if($GVSTEP == "ADD")
				{
					$_GVParamArray[] = array("KEY"=>"company_id", "VAL"=>$company_id, "TYPE"=>"s");
					$_GVParamArray[] = array("KEY"=>"purchase_id", "VAL"=>$GVID, "TYPE"=>"s");
					$_GVParamArray[] = array("KEY"=>"product_id", "VAL"=>$productID, "TYPE"=>"s");
					$_GVParamArray[] = array("KEY"=>"product_name", "VAL"=>$productName, "TYPE"=>"s");
					
					$_GVParamArray[] = array("KEY"=>"product_quantity", "VAL"=>$txtQuantity, "TYPE"=>"s");
					$_GVParamArray[] = array("KEY"=>"product_price", "VAL"=>$txtRate, "TYPE"=>"s");
					$_GVParamArray[] = array("KEY"=>"gst_percent", "VAL"=>$txtGSTPercent, "TYPE"=>"s");
					$_GVParamArray[] = array("KEY"=>"gst_amt", "VAL"=>$txtGSTAmount, "TYPE"=>"s");
					$_GVParamArray[] = array("KEY"=>"product_tot_amount", "VAL"=>$txtAmount, "TYPE"=>"s");
					
					$outParamArr = GVgetQueryString($_GVParamArray);
					
					$MyInsertQry = "insert into purchase_product (".$outParamArr['_INSERT_SQLQRY_FIELDS'].") values(".$outParamArr['_INSERT_SQLQRY_VAL'].")";
					MyDbQuery($MyInsertQry, $_GVParamArray);
				}
				else
				{
					if(array_key_exists($productID, $existingProdIDArr))
					{
						$_GVParamArray[] = array("KEY"=>"product_quantity", "VAL"=>$txtQuantity, "TYPE"=>"s");
						$_GVParamArray[] = array("KEY"=>"product_price", "VAL"=>$txtRate, "TYPE"=>"s");
						$_GVParamArray[] = array("KEY"=>"product_tot_amount", "VAL"=>$txtAmount, "TYPE"=>"s");
						$_GVParamArray[] = array("KEY"=>"gst_percent", "VAL"=>$txtGSTPercent, "TYPE"=>"s");
						$_GVParamArray[] = array("KEY"=>"gst_amt", "VAL"=>$txtGSTAmount, "TYPE"=>"s");
						$_GVParamArray[] = array("KEY"=>"modified_datetime", "VAL"=>"CURRENT_TIMESTAMP()", "TYPE"=>"SKIP");
						
						$outParamArr = GVgetQueryString($_GVParamArray);
						
						$MyUpdateQry = "update purchase_product set ".$outParamArr['_UPDATE_SQLQRY_VAL']." where ";
						$MyUpdateQry .= " company_id=?";MYSQL_BuildArray("company_id",$company_id,"s");
						$MyUpdateQry .= " and purchase_id=?";MYSQL_BuildArray("purchase_id",$GVID,"s");
						$MyUpdateQry .= " and product_id=?";MYSQL_BuildArray("product_id",$productID,"s");
						MyDbQuery($MyUpdateQry, $_GVParamArray);
					}
					else
					{
						$_GVParamArray[] = array("KEY"=>"company_id", "VAL"=>$company_id, "TYPE"=>"s");
						$_GVParamArray[] = array("KEY"=>"purchase_id", "VAL"=>$GVID, "TYPE"=>"s");
						$_GVParamArray[] = array("KEY"=>"product_id", "VAL"=>$productID, "TYPE"=>"s");
						$_GVParamArray[] = array("KEY"=>"product_name", "VAL"=>$productName, "TYPE"=>"s");
						$_GVParamArray[] = array("KEY"=>"product_quantity", "VAL"=>$txtQuantity, "TYPE"=>"s");
						$_GVParamArray[] = array("KEY"=>"product_price", "VAL"=>$txtRate, "TYPE"=>"s");
						$_GVParamArray[] = array("KEY"=>"gst_percent", "VAL"=>$txtGSTPercent, "TYPE"=>"s");
						$_GVParamArray[] = array("KEY"=>"gst_amt", "VAL"=>$txtGSTAmount, "TYPE"=>"s");
						$_GVParamArray[] = array("KEY"=>"product_tot_amount", "VAL"=>$txtAmount, "TYPE"=>"s");
						
						$outParamArr = GVgetQueryString($_GVParamArray);
						
						$MyInsertQry = "insert into purchase_product (".$outParamArr['_INSERT_SQLQRY_FIELDS'].") values(".$outParamArr['_INSERT_SQLQRY_VAL'].")";
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
					$MyDeleteQry = "delete from purchase_product where ";
					$MyDeleteQry .= " company_id=?";MYSQL_BuildArray("company_id",$company_id,"s");
					$MyDeleteQry .= " and purchase_id=?";MYSQL_BuildArray("purchase_id",$GVID,"s");
					$MyDeleteQry .= " and product_id in (".MYSQL_ArrayBuild_String($delProdIDArr).")";MYSQL_BuildArray("product_id",$delProdIDArr,"s");
					MyDbQuery($MyDeleteQry, $_GVParamArray);
				}
			}
			
			include("gv_purchase_pay_cal.php");
			
			$prodCalArr = array(); 
			$prodCalArr = $currentProdIDArr;
			
			foreach($existingProdIDArr as $key=>$val)
			{
				if(!in_array($val,$prodCalArr))
				  $prodCalArr[$val] = $val; 
			}
			
			include("gv_product_purchase_cal.php");
			
			$GVSTEP = "EDIT";
			
			$LoadHtmlPage = "gv_purchase_info_view";
		}
		
		include("../html/".$LoadHtmlPage.".html");
		
		include("gv_footer.php");
	}
?>