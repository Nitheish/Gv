<?	
	$AJAXcallInd = 1;
	$sessionAjaxInd = 1;
	
	include("gv_header.php");
	GVmasterAuth();
	
	$jsonResultArr = array();
	
	if($SessionDATAStatus != "EXPIRED")
	{
		$GVAjaxAction = GVstringDecrption($GVAjaxAction);
		
		if($GVAjaxAction == "RECORD_SDPAGE")
		{
			session_start();
			$_SESSION['gvid'] = $recordSSData;
			$jsonResultArr["STATUS"] = "SUCCESS";
		}
		else if($GVAjaxAction == "RECORD_SDPOPUP")
		{
			session_start();
			$_SESSION['page_gvid'] = $_SESSION['gvid'];
			$_SESSION['gvid'] = $recordSSData;
			$jsonResultArr["STATUS"] = "SUCCESS";
		}
		else if($GVAjaxAction == "POPUP_CLOSE")
		{
			GVPopToPageSession();
			$jsonResultArr["STATUS"] = "SUCCESS";
		}
		else
		{
			$jsonResultArr["STATUS"] = "FAILURE";
		}
	}
	else
	{
		$jsonResultArr["STATUS"] = $SessionDATAStatus;
	}
	
	$jsonData = json_encode($jsonResultArr);
	
	ob_clean();
	echo "[GVT]";
	echo $jsonData;
	MyDbClose();
?>