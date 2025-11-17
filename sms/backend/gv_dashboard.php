<?
	include("gv_header.php");
	GVmasterAuth();

	$LoadHtmlPage = "gv_dashboard";
	$ErrorInd = 0;
	
	$cboAlertOption = GVfixedInputText($cboAlertOption);

	include("../html/".$LoadHtmlPage.".html");
	
	include("gv_footer.php");
?>