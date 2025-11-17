<?
	include_once("gv_header.php");
	GVmasterAuth();
	
	if($GVSTEP == "DELETE" || $GVSTEP1 == "DELETE")
		include("../html/gv_delete_dialog.html");
	else
		include("../html/".$LoadHtmlPage.".html");
	
	include_once("gv_footer.php");
?>