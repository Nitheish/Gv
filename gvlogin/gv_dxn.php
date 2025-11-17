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
  		<link rel="icon" type="image/png" href='<? echo "/gvtech/images/gvlogo1.png";?>'>
		<title>GV Techno Sys</title>
		<link rel="stylesheet" type="text/css" href='<? echo "/gvtech/css/bootstrap.min.css";?>'>
		<link rel="stylesheet" type="text/css" href='<? echo "/gvtech/css/MyStyle.css";?>'>
		
		<script type="text/javascript" src='<? echo "/gvtech/jquery/jquery.min.js"; ?>'></script> 
		<script type="text/javascript" src='<? echo "/gvtech/js/bootstrap.min.js"; ?>'></script>
	</head>
	
	<body style="background-image:-webkit-gradient(linear,left top,right top ,from(#006699),to(#33bbff)) !important;">
	<form action="<?echo '/dxn/backend/gv_dxn_login.php'; ?>" method="post" autocomplete="off">
		
		<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="GvNav" style='z-index:0;background:#f2f2f2 !important;box-shadow: 0 2px 5px 0 rgba(0,0,0,0.16),0 2px 10px 0 rgba(0,0,0,0.75);'>
			<a class="navbar-brand"><img src='<? echo "/gvtech/images/gvlogo1.png";?>' style="width:40px;height:35px;"></a>
			
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			
			<div class="collapse navbar-collapse" id="navbarSupportedContent">
				<ul class="navbar-nav mr-auto" id='GvNav'>
					<li class="nav-item active" style='height:32px;'>
						<span>LOGIN</span>
					</li>
					<? 
					/*
					<li class="nav-item">
						<span>ABOUT</span>
					</li>
					<li class="nav-item">
						<span>CONTACT US</span>
					</li>
					*/
					?>
				</ul>
			</div>
		</nav>
		
		<div class="container-fluid" style="margin-top:40px;">
			<div class="row">
				<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 text-center GVLoginHeading">
					<h1>Welcome to GV Techno Sys</h1><br>
					<h3>DXN - Stock Management System</h3><br>
					<h4>We deliver simple, scalable, and flexible solutions designed to streamline daily stock management operations.<h4>
				</div>
				
				<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12" style="padding:20px;">
					<div class="container-fluid" style="box-shadow:0 10px 10px 15px rgba(0,0,0,0.2);margin-top:15px;margin-bottom:10px;margin-right:10px;border-radius:10px;background-color:white;padding:25px;">
						<div class="row">	
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
								<label class="MyTextHeading"><i class='fa fa-id-card-o'></i> LOGIN INFORMATION</label><hr>
							</div>
						</div>	
						
						<div class="row" style="padding-top:5px;">	
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
								<? GVUserNameBox("User Name","txtUserName","txtUserName","","","autocomplete='off'"); ?>
							</div>
						</div>
						
						<div class="row">
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
								<? GVPassWordBox("Password","txtPassWord","txtPassWord","","","autocomplete='off'"); ?>
							</div>
						</div>
						<?/*?>
						<div class="row">	
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
								<? GVTextBox("Company Code","txtCompanyCode","txtCompanyCode","","",""); ?>
							</div>
						</div>
						<? */?>
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
									GVInputButton("LOGIN","GVloginBtn","GVloginBtn","Submit","THEME","",""); 
									echo "&nbsp;&nbsp;&nbsp;&nbsp;";
									GVInputButton("CLEAR","GVloginBtn","GVloginBtn","button","SECONDARY","","onclick='ClearTextBoxes()'");
								?>
							</div>														
						</div>
					</div>
				</div>
			</div>	
		</div>
		
		<footer style="background-color:#f2f2f2;color:#000;height:40px;" class='fixed-bottom'>
			<div class="container">
				<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 text-right" style='margin-top:7px;'>
					<small>Copyright GV Techno Sys - Stock Management System @ 2022</small>
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