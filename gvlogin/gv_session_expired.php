	<? 
		require_once(GVGETSERVER('DOCUMENT_ROOT')."/gv_path.php");
		include_once($GVTECHPATH."/gvfunction/gv_general_function.php");
		include_once($GVTECHPATH."/gvfunction/gv_design_function.php");
		include_once($GVTECHPATH."/gvfunction/gv_function.php");
		
		session_start();
		if (isset($_SESSION['frmProductLogin']))
		{
			$frmProductLogin = $_SESSION['frmProductLogin'];	
		}
		session_destroy();

		if($frmProductLogin == "DXN")
		{
			$titleDesc = "<h1>GV Techno Sys</h1><br><h3>DXN - Stock Management System</h3><br>";
			$pathRelogin = "/gvlogin/gv_dxn";
		}
		else if($frmProductLogin == "SMS")
		{
			$titleDesc = "<h1>GV Techno Sys</h1><br><h3>Stock Management System</h3><br>";
			$pathRelogin = "/gvlogin/gv_sms";
		}
		else
		{
			$titleDesc = "GV Finance Management";
			$pathRelogin = "/gvlogin/gv_finance";
		}
	?>
	
	<!DOCTYPE html>
		<html lang="en">
			<head>
			<meta charset="utf-8">
			<meta http-equiv="X-UA-Compatible" content="IE=edge">
			<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
			<meta name="description" content="">
			<meta name="author" content="">
	  		<link rel="icon" type="image/png" href='<? echo "/gvtech/images/gvlogo1.png";?>'>
			<title>GV Techno Sys</title>
			<link rel="stylesheet" type="text/css" href='<? echo "/gvtech/css/bootstrap.min.css";?>'>
			<link rel="stylesheet" type="text/css" href='<? echo "/gvtech/css/MyStyle.css";?>'>
			
			<script type="text/javascript" src='<? echo "/gvtech/jquery/jquery.min.js"; ?>'></script> 
			<script type="text/javascript" src='<? echo "/gvtech/js/bootstrap.min.js"; ?>'></script>
		<head>

		
		<body style="background-image:-webkit-gradient(linear,left top,right top ,from(#006699),to(#33bbff)) !important;">
			<form action="<?echo $pathRelogin; ?>" method="post">
				<div class="container-fluid" style="margin-top:0px;">
					<div class="row">
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center GVLoginHeading">
							<h2><? echo $titleDesc; ?><h2><br>
						</div>
					</div>
					
					<div class="row">
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center" style='color:#fff;'>
							<h1>! Session Time Out</h1>
						</div>
					</div>
					
					<div class="row" style="margin-top:20px;">	
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
							<? GVButton("CLICK HERE TO LOGIN","GVloginBtn","GVloginBtn","Submit","SECONDARY","",""); ?>
						</div>														
					</div>
				</div>
			</form>
		</body>
	</html>