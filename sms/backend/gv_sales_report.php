<?
	include("gv_header.php");
	GVmasterAuth();

	$LoadHtmlPage = "gv_sales_report";
	$ErrorInd = 0;
	
	$cboFromYr = GVfixedInputText($cboFromYr);
	$cboFromMon = GVfixedInputText($cboFromMon);
	
	include("../html/".$LoadHtmlPage.".html");
	
	include("gv_footer.php");
?>