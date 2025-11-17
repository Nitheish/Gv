<?
	require_once(GVGETSERVER('DOCUMENT_ROOT')."/gv_path.php");
	include_once($GVTECHPATH."/gvfunction/gv_design_function.php");
	include_once($GVTECHPATH."/gvfunction/gv_function.php");
	$CaptchaVal = GVgetRandom();
?>
	<!DOCTYPE html>
	<html lang="en">
	
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta name="description" content="">
		<meta name="author" content="">
  
		<title>GV Finance Management</title>
		<link rel="stylesheet" type="text/css" href='<? echo "/gvtech/css/bootstrap.min.css";?>'>
		<link rel="stylesheet" type="text/css" href='<? echo "/gvtech/css/MyStyle.css";?>'>
		
		<script type="text/javascript" src='<? echo "/gvtech/jquery/jquery.min.js"; ?>'></script> 
		<script type="text/javascript" src='<? echo "/gvtech/js/bootstrap.min.js"; ?>'></script>
	<head>

	
	<body style="background-image:url('/gvtech/images/1.jpg');  background-position: center; background-repeat: no-repeat;background-size: cover;">
	<form action="<?echo '/gvfinance/backend/gv_finance_login.php'; ?>" method="post">
		
		<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="GvNav">
			<a class="navbar-brand"><img src='<? echo "/gvtech/images/gvlogo1.png";?>' style="width:40px;height:35px;"></a>
			
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			
			<div class="collapse navbar-collapse" id="navbarSupportedContent">
				<ul class="navbar-nav mr-auto" id='GvNav'>
					<li class="nav-item active">
						<a class="nav-link" href="#">LOGIN</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="#">ABOUT</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="#">CONTACT US</a>
					</li>
				</ul>
			</div>
		</nav>
		
		<div class="container-fluid" style="margin-top:50px;">
			<div class="row">
				<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 text-center GVLoginHeading">
					<h2>Welcome to GV finance management system<h2><br>
					<h4>We provide simple, scalable and flexible solutions that meet the efficient financial management of day to day activities.<h4>
				</div>
				
				<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12" style="padding:20px;">
					<div class="container-fluid" style="margin-top:15px;margin-bottom:10px;margin-right:10px;border:1px solid #343a40;background-color:white;padding:25px;">
						<div class="row">	
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
								<label class="MyTextHeading"><i class='fa fa-id-card-o'></i> LOGIN INFORMATION</label><hr>
							</div>
						</div>	
						
						<div class="row" style="padding-top:5px;">	
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
								<? GVUserNameBox("User Name","txtUserName","txtUserName","","",""); ?>
							</div>
						</div>
						
						<div class="row">
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
								<? GVPassWordBox("Password","txtPassWord","txtPassWord","","",""); ?>
							</div>
						</div>
						
						<div class="row">	
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
								<? GVCaptchaBox("INPUT","$CaptchaVal","GVCaptcha","",""); ?>
								<? GVHiddenInput("CaptchaVal","$CaptchaVal",""); ?>
							</div>
						</div>
						
						<div class="row">	
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
								<? GVTextBox("Enter the Captcha","txtCaptcha","txtCaptcha","","",""); ?>
							</div>
						</div>
						
						<div class="row">	
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center" style="margin-bottom:5px;">
								<? 
									GVInputButton("LOGIN","GVloginBtn","GVloginBtn","Submit","PRIMARY","",""); 
									echo "&nbsp;&nbsp;&nbsp;&nbsp;";
									GVInputButton("CLEAR","GVloginBtn","GVloginBtn","button","SUCCESS","","onclick='ClearTextBoxes()'");
								?>
							</div>														
						</div>
					</div>
				</div>
			</div>	
		</div>
		
		<footer style="background-color:#343a40;color:white;height:40px;" class='fixed-bottom'>
			<div class="container">
				<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 text-right" style='margin-top:7px;'>
					<small>Copyright GV finance management system @ 2020</small>
				</div>
			</div>
		</footer>
	</form>
	</body>
	</html>
	
	<script type='text/javascript'>
		function ClearTextBoxes()
		{
			document.getElementById("txtUserName").value = "";
			document.getElementById("txtPassWord").value = "";
			document.getElementById("txtCaptcha").value = "";
		}
	</script>