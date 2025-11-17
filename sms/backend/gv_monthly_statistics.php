<?
	include("gv_header.php");
	GVmasterAuth();

	$LoadHtmlPage = "gv_monthly_statistics";
	$ErrorInd = 0;
	
	$cboYear = GVfixedInputText($cboYear);
	$cboProduct = GVfixedInputText($cboProduct);

	include("../html/".$LoadHtmlPage.".html");
	
	include("gv_footer.php");
?>