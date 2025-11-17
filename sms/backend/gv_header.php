<?
	session_start();
	if (isset($_SESSION['gvky']))
	{
		$GLOBALS["gvky"] = $_SESSION['gvky'];	
	}
	
	if (isset($_SESSION['gvid']))
	{
		if($SkipSSDataInd != 1)
			$GLOBALS["gvid"] = $_SESSION['gvid'];	
	}
	require_once(GVGETSERVER('DOCUMENT_ROOT')."/gv_path.php");
	include_once($GVTECHPATH."/gvfunction/gv_design_function.php");
	include_once($GVTECHPATH."/gvfunction/gv_function.php");
	include_once($GVTECHPATH."/gvfunction/gv_dbconnect.php");
	include_once($GVTECHPATH."/gvfunction/gv_constants.php");
	
	$DB_NAME = "gvcollection"; //sms gvcollection
	MyDbConnect();
	GVqueryStringData();
	GVHiddenStringData();
	
	if($AJAXcallInd != 1)
	{
	?>
	<link rel="stylesheet" type="text/css" href='<? echo "/gvtech/css/bootstrap.min.css";?>'>
	<link rel="stylesheet" type="text/css" href='<? echo "/gvtech/css/font-awesome.min.css";?>'>
	<link rel="stylesheet" type="text/css" href='<? echo "/gvtech/css/MyStyle.css?gvversion=".filemtime("../../gvtech/css/MyStyle.css");?>'>
	<link rel="stylesheet" type="text/css" href='<? echo "/gvtech/css/daterangepicker.css";?>'>
	<link rel="stylesheet" type="text/css" href='<? echo "/gvtech/sweetalert/dist/sweetalert.css";?>'>
	
	<script type="text/javascript" src='<? echo "/gvtech/jquery/jquery.min.js"; ?>'></script> 
	<script type="text/javascript" src='<? echo "/gvtech/js/bootstrap.bundle.min.js"; ?>'></script>
	<script type="text/javascript" src='<? echo "/gvtech/sweetalert/dist/sweetalert.min.js"; ?>'></script>
	<script type="text/javascript" src='<? echo "/gvtech/js/GVScript.js?gvversion=".filemtime("../../gvtech/js/GVScript.js");?>'></script>
	<script type="text/javascript" src='<? echo "/gvtech/js/moment.min.js"; ?>'></script>
	<script type="text/javascript" src='<? echo "/gvtech/js/daterangepicker.js"; ?>'></script>
	<?
	}
	//SMS Related Function
	include("gv_sms_func.php");
?>
	