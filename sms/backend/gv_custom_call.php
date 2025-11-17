<?	
	$AJAXcallInd = 1;
	include("gv_header.php");
	GVmasterAuth();
	
	if($GVSTEP == "SALESITEM")
	{
		$ProductArr = array();
		$ProductCodeListArr = array();
		$ProductArr[""] = "---Select Item---";
		$MySelectQry = "select product_id,product_name,product_code from product_info where";
		$MySelectQry .= " company_id=?";MYSQL_BuildArray("company_id",$company_id,"s");
		$MySelectQry .= " and delete_ind=?";MYSQL_BuildArray("delete_ind",'0',"s");
		$MyDbResult =  MyDbQuery($MySelectQry,$_GVParamArray);	
		while($MyRowData = mysqli_fetch_array($MyDbResult, MYSQLI_ASSOC)) 
		{
			$ProductArr[GVStringFormat($MyRowData['product_id'])] = GVStringFormat($MyRowData['product_name']);
			$ProductCodeListArr[GVStringFormat($MyRowData['product_code'])] = GVStringFormat($MyRowData['product_name']);
		}
		MyDbFreeResult($MyDbResult);
	
		$recStart = GVfixedInputText($recStart);
		$recStart = (int) $recStart;
		
		$recStart = $recStart + 1;
		$recEnd = $recStart + $GVID;
		
		for($rowCount = $recStart;$rowCount < $recEnd; $rowCount++)
		{
			$tableRowID = "itemRec".$rowCount;
			$txtProductCode = "txtProductCode".$rowCount;
			$cboProductName = "cboProductName".$rowCount;
			$txtQuantity = "txtQuantity".$rowCount;
			$txtRate = "txtRate".$rowCount;
			$txtAmount = "txtAmount".$rowCount;
			
			${$txtQuantity} = "0";
			${$txtRate} = "0.00";
			${$txtAmount} = "0.00";
			
			echo "<tr id='$tableRowID' style='line-height: 1.5;'>";
				echo "<td>";
				GVTextBoxWithList("INPUT","$txtProductCode","$txtProductCode","txtProductCode","text-transform:uppercase;border-radius: 5px !important;","placeholder='Product Code'",$ProductCodeListArr);
				echo "</td>";
				
				echo "<td>";
				GVComboBox("INPUT","$cboProductName","$cboProductName",$ProductArr,"","width:150px;margin-left: 5px;","onchange='cboProductName_onchanged(this.id,this.value);'");
				echo "</td>";
				
				echo "<td>";
				GVTextBox("INPUT","$txtQuantity","$txtQuantity","txtQuantity","text-align:right;","maxlength='3' placeholder='Quantity' onkeypress='return isNumberKey(this)'");
				echo "</td>";
				
				echo "<td>";
				GVAmountBox("INPUT","$txtRate","$txtRate","inputDisabled","","placeholder='Rate'");
				echo "</td>";
				
				echo "<td>";
				GVAmountBox("INPUT","$txtAmount","$txtAmount","inputDisabled","","placeholder='Amount' disabled");
				echo "</td>";
				
				echo "<td>";
				echo GVimage("delete","delete","/gvtech/images/delete.png","","cursor:pointer;padding-top: 7px;","width='15' title='Delete' onclick=itemDelete('$tableRowID');");
				echo "</td>";
			echo "</tr>";
			
			echo "<input type='hidden' name='ItemList[$rowCount]' id='ItemList_$rowCount' value=''>";
		}
	}
	else if($GVSTEP == "PURCHASEITEM")
	{
		$ProductArr = array();
		$ProductCodeListArr = array();
		
		$ProductArr[""] = "---Select Item---";
		$MySelectQry = "select product_id,product_name,product_code from product_info where";
		$MySelectQry .= " company_id=?";MYSQL_BuildArray("company_id",$company_id,"s");
		$MySelectQry .= " and delete_ind=?";MYSQL_BuildArray("delete_ind",'0',"s");
		$MyDbResult =  MyDbQuery($MySelectQry,$_GVParamArray);	
		while($MyRowData = mysqli_fetch_array($MyDbResult, MYSQLI_ASSOC)) 
		{
			$ProductArr[GVStringFormat($MyRowData['product_id'])] = GVStringFormat($MyRowData['product_name']);
			$ProductCodeListArr[GVStringFormat($MyRowData['product_code'])] = GVStringFormat($MyRowData['product_name']);
		}
		MyDbFreeResult($MyDbResult);
		
		$recStart = GVfixedInputText($recStart);
		$recStart = (int) $recStart;
		
		$recStart = $recStart + 1;
		$recEnd = $recStart + $GVID;
		
		for($rowCount = $recStart;$rowCount < $recEnd; $rowCount++)
		{
			$tableRowID = "itemRec".$rowCount;
			$txtProductCode = "txtProductCode".$rowCount;
			$cboProductName = "cboProductName".$rowCount;
			$txtQuantity = "txtQuantity".$rowCount;
			$txtRate = "txtRate".$rowCount;
			$txtAmount = "txtAmount".$rowCount;
			$txtGSTPercent = "txtGSTPercent".$rowCount;
			$txtGSTAmount = "txtGSTAmount".$rowCount;
			
			${$txtQuantity} = 0;
			${$txtRate} = "0.00";
			${$txtAmount} = "0.00";
			${$txtGSTPercent} = "0.00";
			${$txtGSTAmount} = "0.00";
			
			echo "<tr id='$tableRowID' style='line-height: 1.5;'>";
				echo "<td>";
				GVTextBoxWithList("INPUT","$txtProductCode","$txtProductCode","txtProductCode","text-transform:uppercase;border-radius: 5px !important;","placeholder='Product Code'",$ProductCodeListArr);
				echo "</td>";
				
				echo "<td>";
				GVComboBox("INPUT","$cboProductName","$cboProductName",$ProductArr,"","width:150px;margin-left: 5px;","onchange='cboProductName_onchanged(this.id,this.value);'");
				echo "</td>";
				
				echo "<td>";
				GVTextBox("INPUT","$txtQuantity","$txtQuantity","txtQuantity","text-align:right;","maxlength='3' placeholder='Quantity' onkeypress='return isNumberKey(this)'");
				echo "</td>";
				
				echo "<td>";
				GVAmountBox("INPUT","$txtRate","$txtRate","txtRate","","placeholder='Rate'");
				echo "</td>";
				
				echo "<td>";
				GVPercentBox("INPUT","$txtGSTPercent","$txtGSTPercent","txtGSTPercent","","maxlength='6' placeholder='Percentage' onkeypress='return isMoneyKey(this, this.value);'");
				echo "</td>";
				
				echo "<td>";
				GVAmountBox("INPUT","$txtGSTAmount","$txtGSTAmount","","","placeholder='Amount' disabled");
				echo "</td>";
				
				echo "<td>";
				GVAmountBox("INPUT","$txtAmount","$txtAmount","","","placeholder='Amount' disabled");
				echo "</td>";
				
				echo "<td>";
				
				if($rowCount != 1)
				{
					echo GVimage("delete","delete","/gvtech/images/delete.png","","cursor:pointer;padding-top: 7px;","width='15' title='Delete' onclick=itemDelete('$tableRowID');");
				}
				echo "</td>";
			echo "</tr>";
			
			echo "<input type='hidden' name='ItemList[$rowCount]' id='ItemList_$rowCount' value='".$ItemList[$rowCount]."'>";
		}
		
	}	
?>