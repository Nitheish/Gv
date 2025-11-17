<?
	$vendorArr = array();
	$vendorArr[-1] = "Add New Vendor";
	$vendorArr[0] = "Non Vendor";
	$MySelectQry = "select vendor_name,vendor_phone,vendor_id from vendor_info where";
	$MySelectQry .= " company_id=?";MYSQL_BuildArray("company_id",$company_id,"s");
	$MySelectQry .= " and delete_ind=?";MYSQL_BuildArray("delete_ind",'0',"s");
	$MyDbResult =  MyDbQuery($MySelectQry,$_GVParamArray);	
	while($MyRowData = mysqli_fetch_array($MyDbResult, MYSQLI_ASSOC)) 
	{
		$vendorArr[GVStringFormat($MyRowData['vendor_id'])] = GVStringFormat($MyRowData['vendor_name'])." ( ".GVStringFormat($MyRowData['vendor_phone'])." )";
	}
	MyDbFreeResult($MyDbResult);
	
	$ProductArr = array();
	$ProductRateArr = array();
	$ProductCodeArr = array();
	$ProductQtyArr = array();
	$ProductCodeListArr = array();
	
	$ProductArr[""] = "---Select Item---";
	$MySelectQry = "select product_id,product_name,product_code,remaining_qty,sell_amount from product_info where";
	$MySelectQry .= " company_id=?";MYSQL_BuildArray("company_id",$company_id,"s");
	$MySelectQry .= " and delete_ind=?";MYSQL_BuildArray("delete_ind",'0',"s");
	$MyDbResult =  MyDbQuery($MySelectQry,$_GVParamArray);	
	while($MyRowData = mysqli_fetch_array($MyDbResult, MYSQLI_ASSOC)) 
	{
		$ProductArr[GVStringFormat($MyRowData['product_id'])] = GVStringFormat($MyRowData['product_name']);
		$ProductRateArr[GVStringFormat($MyRowData['product_id'])] = GVStringFormat($MyRowData['sell_amount']);
		$ProductCodeArr[GVStringFormat($MyRowData['product_id'])] = GVStringFormat($MyRowData['product_code']);
		$ProductQtyArr[GVStringFormat($MyRowData['product_id'])] = GVStringFormat($MyRowData['remaining_qty']);
		$ProductCodeListArr[GVStringFormat($MyRowData['product_code'])] = GVStringFormat($MyRowData['product_name']);
	}
	MyDbFreeResult($MyDbResult);
?>