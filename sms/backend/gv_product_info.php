<?
	if($GVSaveBtn)
	{
		include("gv_header.php");
		GVmasterAuth();
	
		$LoadHtmlPage = "gv_product_info";
		$ErrorInd = 0;
		
		$txtProductName = GVfixedInputText($txtProductName);
		$txtsellingAmt = GVfixedInputText($txtsellingAmt);
		$txtIntialQtyAmt = GVfixedInputText($txtIntialQtyAmt);
		$txtIntialQty = GVfixedInputText($txtIntialQty);
		$chkAlertInd = GVfixedInputText($chkAlertInd);
		$txtAlertQtyLevel = GVfixedInputText($txtAlertQtyLevel);
		$txtProductCode = GVfixedInputText($txtProductCode);
		$cboPdtCategory = (int) GVfixedInputText($cboPdtCategory);
		
		if($cboPdtCategory == 0)
			GVSetErrorCodes("cboPdtCategory","Please select the Product Category");
		
		if(strlen($txtProductName) == 0)
			GVSetErrorCodes("txtProductName","Please enter the Product Name");
		
		if(strlen($txtProductCode) == 0)
			GVSetErrorCodes("txtProductCode","Please enter the Product code");
		
		if(!GVisNumeric($txtsellingAmt))
		{
			GVSetErrorCodes("txtsellingAmt","Please enter Amount value");
		}
		else if(round($txtsellingAmt) == 0)
		{
			GVSetErrorCodes("txtsellingAmt","Please enter Amount value greater than zero");
		}
		
		if($GVSTEP == "ADD")
		{
			if(!GVisNumeric($txtIntialQtyAmt))
			{
				GVSetErrorCodes("txtIntialQtyAmt","Please enter Amount value");
			}
			
			if(!GVisNumeric($txtIntialQty))
			{
				GVSetErrorCodes("txtIntialQty","Please enter numeric value");
			}
		}
			
		$MySelectQry = "select product_id from product_info where";
		$MySelectQry .= " company_id=?";MYSQL_BuildArray("company_id",$company_id,"s");
		
		if($GVSTEP == "EDIT")
		{
			$MySelectQry .= " and product_id!=?";MYSQL_BuildArray("product_id",$GVID,"s");
		}
		
		$MySelectQry .= " and product_name=?";MYSQL_BuildArray("product_id",$txtProductName,"s");
		$MyDbResult =  MyDbQuery($MySelectQry,$_GVParamArray);	
		$MyNumRows = MyDbNumRows($MyDbResult);
		MyDbFreeResult($MyDbResult);
		
		if($MyNumRows > 0)
		{
			GVSetErrorCodes("txtProductName","Product name already exists.Please try different one");
		}
		
		$MySelectQry = "select product_id from product_info where";
		$MySelectQry .= " company_id=?";MYSQL_BuildArray("company_id",$company_id,"s");
		
		if($GVSTEP == "EDIT")
		{
			$MySelectQry .= " and product_id!=?";MYSQL_BuildArray("product_id",$GVID,"s");
		}
		
		$MySelectQry .= " and product_code=?";MYSQL_BuildArray("product_code",$txtProductCode,"s");
		$MyDbResult =  MyDbQuery($MySelectQry,$_GVParamArray);	
		$MyNumRows = MyDbNumRows($MyDbResult);
		MyDbFreeResult($MyDbResult);
		
		if($MyNumRows > 0)
		{
			GVSetErrorCodes("txtProductCode","Product code already exists.Please try different one");
		}
			
		if($ErrorInd == 0)
		{
			$txtsellingAmt 		= (float)$txtsellingAmt;
			$txtIntialQtyAmt 	= (float)$txtIntialQtyAmt;
			$txtSoldQty 		= (int)$txtSoldQty;
			$txtIntialQty 		= (int)$txtIntialQty;
			$chkAlertInd 		= (int)$chkAlertInd;
			$txtAlertQtyLevel 	= (int)$txtAlertQtyLevel;
      $txtProductCode 	= strtoupper($txtProductCode);
			
			if($GVSTEP == "ADD")
			{
				$total_qty = $txtIntialQty;
				$remaining_qty = $txtIntialQty;
				$buying_amount = $txtIntialQtyAmt;
				
				$_GVParamArray[] = array("KEY"=>"company_id", "VAL"=>$company_id, "TYPE"=>"s");
				$_GVParamArray[] = array("KEY"=>"product_name", "VAL"=>$txtProductName, "TYPE"=>"s");
				$_GVParamArray[] = array("KEY"=>"initial_qty", "VAL"=>$txtIntialQty, "TYPE"=>"s");
				$_GVParamArray[] = array("KEY"=>"sell_amount", "VAL"=>$txtsellingAmt, "TYPE"=>"s");
				$_GVParamArray[] = array("KEY"=>"initial_qty_amt", "VAL"=>$txtIntialQtyAmt, "TYPE"=>"s");
				$_GVParamArray[] = array("KEY"=>"total_qty", "VAL"=>$total_qty, "TYPE"=>"s");
				$_GVParamArray[] = array("KEY"=>"remaining_qty", "VAL"=>$remaining_qty, "TYPE"=>"s");
				$_GVParamArray[] = array("KEY"=>"buying_amount", "VAL"=>$buying_amount, "TYPE"=>"s");
				$_GVParamArray[] = array("KEY"=>"alert_ind", "VAL"=>$chkAlertInd, "TYPE"=>"s");
				$_GVParamArray[] = array("KEY"=>"qty_count_alert", "VAL"=>$txtAlertQtyLevel, "TYPE"=>"s");
				$_GVParamArray[] = array("KEY"=>"product_code", "VAL"=>$txtProductCode, "TYPE"=>"s");
				$_GVParamArray[] = array("KEY"=>"pdt_category_id", "VAL"=>$cboPdtCategory, "TYPE"=>"s");
			
				$outParamArr = GVgetQueryString($_GVParamArray);
				
				$MyInsertQry = "insert into product_info (".$outParamArr['_INSERT_SQLQRY_FIELDS'].") values(".$outParamArr['_INSERT_SQLQRY_VAL'].")";
				MyDbQuery($MyInsertQry, $_GVParamArray);
				
				$MySelectQry = "select max(product_id) as MaxId from product_info where";
				$MySelectQry .= " company_id=?";MYSQL_BuildArray("company_id",$company_id,"s");
				$MyDbResult =  MyDbQuery($MySelectQry,$_GVParamArray);	
				if($MyRowData = mysqli_fetch_array($MyDbResult, MYSQLI_ASSOC)) 
				{
					$GVID = GVStringFormat($MyRowData['MaxId']);
				}
				MyDbFreeResult($MyDbResult);
				
				$GVSTEP = "EDIT";
				
				$txtAmount = GVformatAmount($txtIntialQty * $txtIntialQtyAmt);
				
				$_GVParamArray[] = array("KEY"=>"company_id", "VAL"=>$company_id, "TYPE"=>"s");
				$_GVParamArray[] = array("KEY"=>"product_id", "VAL"=>$GVID, "TYPE"=>"s");
				$_GVParamArray[] = array("KEY"=>"stock_qty", "VAL"=>$txtIntialQty, "TYPE"=>"s");
				$_GVParamArray[] = array("KEY"=>"stock_count", "VAL"=>$txtIntialQty, "TYPE"=>"s");
				$_GVParamArray[] = array("KEY"=>"purchase_price", "VAL"=>$txtIntialQtyAmt, "TYPE"=>"s");
				$_GVParamArray[] = array("KEY"=>"tot_purchase_amt", "VAL"=>$txtAmount, "TYPE"=>"s");
				$_GVParamArray[] = array("KEY"=>"tot_sales_amt", "VAL"=>"0", "TYPE"=>"s");
				$_GVParamArray[] = array("KEY"=>"remaining_stock_amt", "VAL"=>$txtAmount, "TYPE"=>"s");
				
				$outParamArr = GVgetQueryString($_GVParamArray);
				
				$MyInsertQry = "insert into stock_info (".$outParamArr['_INSERT_SQLQRY_FIELDS'].") values(".$outParamArr['_INSERT_SQLQRY_VAL'].")";
				MyDbQuery($MyInsertQry, $_GVParamArray);
				
				$stock_info_id = 0;
				$MySelectQry = "select max(stock_info_id) as stock_info_id from stock_info where";
				$MySelectQry .= " company_id=?";MYSQL_BuildArray("company_id",$company_id,"s");
				$MySelectQry .= " and product_id=?";MYSQL_BuildArray("product_id",$GVID,"s");
				$MyDbResult =  MyDbQuery($MySelectQry,$_GVParamArray);	
				if($MyRowData = mysqli_fetch_array($MyDbResult, MYSQLI_ASSOC)) 
				{
					$stock_info_id = GVStringFormat($MyRowData['stock_info_id']);
				}
				MyDbFreeResult($MyDbResult);
				
				$_GVParamArray[] = array("KEY"=>"company_id", "VAL"=>$company_id, "TYPE"=>"s");
				$_GVParamArray[] = array("KEY"=>"product_id", "VAL"=>$GVID, "TYPE"=>"s");
				$_GVParamArray[] = array("KEY"=>"quantity", "VAL"=>$txtIntialQty, "TYPE"=>"s");
				$_GVParamArray[] = array("KEY"=>"price", "VAL"=>$txtIntialQtyAmt, "TYPE"=>"s");
				$_GVParamArray[] = array("KEY"=>"total_amt", "VAL"=>$txtAmount, "TYPE"=>"s");
				$_GVParamArray[] = array("KEY"=>"prod_price", "VAL"=>$txtIntialQtyAmt, "TYPE"=>"s");
				$_GVParamArray[] = array("KEY"=>"tot_price", "VAL"=>$txtAmount, "TYPE"=>"s");
				$_GVParamArray[] = array("KEY"=>"stock_type", "VAL"=>"I", "TYPE"=>"s");
				$_GVParamArray[] = array("KEY"=>"stock_info_id", "VAL"=>$stock_info_id, "TYPE"=>"s");
				
				$outParamArr = GVgetQueryString($_GVParamArray);
				
				$MyInsertQry = "insert into stock_track (".$outParamArr['_INSERT_SQLQRY_FIELDS'].") values(".$outParamArr['_INSERT_SQLQRY_VAL'].")";
				MyDbQuery($MyInsertQry, $_GVParamArray);
				
				$product_id = $GVID;
				include("gv_product_track.php");
			}
			else
			{
				$MySelectQry = "select stock_info_id from stock_track where";
				$MySelectQry .= " company_id=?";MYSQL_BuildArray("company_id",$company_id,"s");
				$MySelectQry .= " and product_id=?";MYSQL_BuildArray("product_id",$GVID,"s");
				$MySelectQry .= " and delete_ind=?";MYSQL_BuildArray("delete_ind",'0',"s");
				$MyDbResult =  MyDbQuery($MySelectQry,$_GVParamArray);	
				$MyNumRows = MyDbNumRows($MyDbResult);
				MyDbFreeResult($MyDbResult);
				
				if($MyNumRows == 1 && $txtSoldQty == 0)
				{
					$_GVParamArray[] = array("KEY"=>"buying_amount", "VAL"=>$txtIntialQtyAmt, "TYPE"=>"s");
				}
						
				$_GVParamArray[] = array("KEY"=>"initial_qty", "VAL"=>$txtIntialQty, "TYPE"=>"s");
				$_GVParamArray[] = array("KEY"=>"initial_qty_amt", "VAL"=>$txtIntialQtyAmt, "TYPE"=>"s");
				$_GVParamArray[] = array("KEY"=>"product_name", "VAL"=>$txtProductName, "TYPE"=>"s");
				$_GVParamArray[] = array("KEY"=>"sell_amount", "VAL"=>$txtsellingAmt, "TYPE"=>"s");
				$_GVParamArray[] = array("KEY"=>"alert_ind", "VAL"=>$chkAlertInd, "TYPE"=>"s");
				$_GVParamArray[] = array("KEY"=>"qty_count_alert", "VAL"=>$txtAlertQtyLevel, "TYPE"=>"s");
				$_GVParamArray[] = array("KEY"=>"product_code", "VAL"=>$txtProductCode, "TYPE"=>"s");
				$_GVParamArray[] = array("KEY"=>"pdt_category_id", "VAL"=>$cboPdtCategory, "TYPE"=>"s");
			
				$outParamArr = GVgetQueryString($_GVParamArray);
				
				$MyUpdateQry = "update product_info set ".$outParamArr['_UPDATE_SQLQRY_VAL']." where ";
				$MyUpdateQry .= " company_id=?";MYSQL_BuildArray("company_id",$company_id,"s");
				$MyUpdateQry .= " and product_id=?";MYSQL_BuildArray("product_id",$GVID,"s");
				MyDbQuery($MyUpdateQry, $_GVParamArray);
				
				if($txtSoldQty == 0)
				{
					$stock_info_id = 0;
					$MySelectQry = "select stock_info_id from stock_track where";
					$MySelectQry .= " company_id=?";MYSQL_BuildArray("company_id",$company_id,"s");
					$MySelectQry .= " and product_id=?";MYSQL_BuildArray("product_id",$GVID,"s");
					$MySelectQry .= " and stock_type=?";MYSQL_BuildArray("stock_type","I","s");
					$MySelectQry .= " and delete_ind=?";MYSQL_BuildArray("delete_ind",'0',"s");
					$MyDbResult =  MyDbQuery($MySelectQry,$_GVParamArray);	
					if($MyRowData = mysqli_fetch_array($MyDbResult, MYSQLI_ASSOC)) 
					{
						$stock_info_id = GVStringFormat($MyRowData['stock_info_id']);
					}
					MyDbFreeResult($MyDbResult);
					
					$txtAmount = GVformatAmount($txtIntialQty * $txtIntialQtyAmt);
					
					if($stock_info_id > 0)
					{
						$_GVParamArray[] = array("KEY"=>"quantity", "VAL"=>$txtIntialQty, "TYPE"=>"s");
						$_GVParamArray[] = array("KEY"=>"price", "VAL"=>$txtIntialQtyAmt, "TYPE"=>"s");
						$_GVParamArray[] = array("KEY"=>"total_amt", "VAL"=>$txtAmount, "TYPE"=>"s");
						$_GVParamArray[] = array("KEY"=>"prod_price", "VAL"=>$txtIntialQtyAmt, "TYPE"=>"s");
						$_GVParamArray[] = array("KEY"=>"tot_price", "VAL"=>$txtAmount, "TYPE"=>"s");
				
						$outParamArr = GVgetQueryString($_GVParamArray);
						$MyUpdateQry = "update stock_track set ".$outParamArr['_UPDATE_SQLQRY_VAL']." where ";
						$MyUpdateQry .= " company_id=?";MYSQL_BuildArray("company_id",$company_id,"s");
						$MyUpdateQry .= " and product_id=?";MYSQL_BuildArray("product_id",$GVID,"s");
						$MyUpdateQry .= " and stock_info_id=?";MYSQL_BuildArray("stock_info_id",$stock_info_id,"s");
						$MyUpdateQry .= " and stock_type=?";MYSQL_BuildArray("stock_type","I","s");
						$MyUpdateQry .= " and delete_ind=?";MYSQL_BuildArray("delete_ind",'0',"s");
						MyDbQuery($MyUpdateQry, $_GVParamArray);
						
						$_GVParamArray[] = array("KEY"=>"stock_qty", "VAL"=>$txtIntialQty, "TYPE"=>"s");
						$_GVParamArray[] = array("KEY"=>"purchase_price", "VAL"=>$txtIntialQtyAmt, "TYPE"=>"s");
						
						$outParamArr = GVgetQueryString($_GVParamArray);
						$MyUpdateQry = "update stock_info set ".$outParamArr['_UPDATE_SQLQRY_VAL']." where ";
						$MyUpdateQry .= " company_id=?";MYSQL_BuildArray("company_id",$company_id,"s");
						$MyUpdateQry .= " and product_id=?";MYSQL_BuildArray("product_id",$GVID,"s");
						$MyUpdateQry .= " and stock_info_id=?";MYSQL_BuildArray("stock_info_id",$stock_info_id,"s");
						MyDbQuery($MyUpdateQry, $_GVParamArray);
						
						$product_id = $GVID;
						include("gv_product_track.php");
					}
				}
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