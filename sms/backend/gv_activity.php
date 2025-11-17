<?
	include("gv_header.php");
	GVmasterAuth();

	$LoadHtmlPage = "gv_activity";
	$ErrorInd = 0;
	
	$txtRangeDate = GVfixedInputText($txtRangeDate);
	$txtSearchStr = GVfixedInputText($txtSearchStr);
	$numRecordPerPage = GVfixedInputText($numRecordPerPage);

	include("../html/".$LoadHtmlPage.".html");
	
	include("gv_footer.php");
?>