<?
	include("gv_header.php");
	GVmasterAuth();

	$LoadHtmlPage = "gv_emp_ass_list";
	$ErrorInd = 0;
	
	$cboSearchOpt = GVfixedInputText($cboSearchOpt);
	$txtSearchStr = GVfixedInputText($txtSearchStr);

	include("../html/".$LoadHtmlPage.".html");
	
	include("gv_footer.php");
?>