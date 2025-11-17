<?
	include("gv_header.php");
	GVmasterAuth();

	$LoadHtmlPage = "gv_monthly_report";
	$ErrorInd = 0;
	
	$cboFromYr = GVfixedInputText($cboFromYr);
	$cboFromMon = GVfixedInputText($cboFromMon);
	$cboToYr = GVfixedInputText($cboToYr);
	$cboToMon = GVfixedInputText($cboToMon);
	
	if($GVSaveBtn == "SEARCH")
	{
		if($cboFromYr > $cboToYr)
			GVSetErrorCodes("cboYearErr","From Year should not greater than To Year");
		else if($cboToYr == $cboFromYr)
		{
			if($cboFromMon > $cboToMon)
				GVSetErrorCodes("cboMonthErr","From Month should not greater than To Month");
		}	
	}

	include("../html/".$LoadHtmlPage.".html");
	
	include("gv_footer.php");
?>