<?
	include("gv_header.php");
	GVmasterAuth();

	$LoadHtmlPage = "gv_expenses_list";
	$ErrorInd = 0;
	
	$cboExpenseType = GVfixedInputText($cboExpenseType);
	$txtRangeDate = GVfixedInputText($txtRangeDate);

	include("../html/".$LoadHtmlPage.".html");
	
	include("gv_footer.php");
?>