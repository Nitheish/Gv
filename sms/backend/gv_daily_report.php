<?
	include("gv_header.php");
	GVmasterAuth();

	$LoadHtmlPage = "gv_daily_report";
	$ErrorInd = 0;
	
	$cboSearchOpt = GVfixedInputText($cboSearchOpt);
	$txtSearchStr = GVfixedInputText($txtSearchStr);
	$txtRangeDate = GVfixedInputText($txtRangeDate);

	include("../html/".$LoadHtmlPage.".html");
	
	include("gv_footer.php");
?>