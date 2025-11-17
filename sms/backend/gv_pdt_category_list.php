<?
	include("gv_header.php");
	GVmasterAuth();

	$LoadHtmlPage = "gv_pdt_category_list";
	$ErrorInd = 0;
	
	$txtSearchStr = GVfixedInputText($txtSearchStr);

	include("../html/".$LoadHtmlPage.".html");
	
	include("gv_footer.php");
?>