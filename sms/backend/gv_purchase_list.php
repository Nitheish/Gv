<?
	include("gv_header.php");
	GVmasterAuth();

	$LoadHtmlPage = "gv_purchase_list";
	$ErrorInd = 0;
	
	$cboSearchOpt = GVfixedInputText($cboSearchOpt);
	$txtSearchStr = GVfixedInputText($txtSearchStr);

	include("../html/".$LoadHtmlPage.".html");
	
	include("gv_footer.php");
?>