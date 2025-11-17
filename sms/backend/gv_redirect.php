<? 

	include_once("gv_header.php");

	GVmasterAuth();

	include("../info/gv_menu_info.php");
	
?>
	<!DOCTYPE html>
	<html lang="en">
	
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta name="description" content="">
		<meta name="author" content="">
		<title>GV Techno Sys</title>
		<link rel="icon" type="image/png" href='<? echo "/gvtech/images/gvlogo1.png";?>'>
	</head>
	
	<body>
	<div class="page-wrapper toggled">
		<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="GvNav" style='z-index:0;background:#f2f2f2 !important;box-shadow: 0 2px 5px 0 rgba(0,0,0,0.16),0 2px 10px 0 rgba(0,0,0,0.75);'>
			<a class="navbar-brand"><img src='<? echo "/gvtech/images/gvlogo1.png";?>' style="width:40px;height:35px;"></a>
			
			
			<div class="collapse navbar-collapse" id="navbarSupportedContent">
				<ul class="navbar-nav" id='GvNav'>
					<? 
					for($GVmenuCount = 0;$GVmenuCount < count($GVmenuArr); $GVmenuCount++) 
					{
						$linkDesc = $GVmenuArr[$GVmenuCount]["DESC"];
						$linkImage = $GVmenuArr[$GVmenuCount]["IMG"];
						$linkTag = $GVmenuArr[$GVmenuCount]["TAG"];
						$linkURL = $GVmenuArr[$GVmenuCount]["LINK"];
	
						$linkClass = ""; 
						$spanStyle = "display:none;";
						$spanClass = "NavRoundTab";
						if($GVmenu == $linkTag)
						{
							$linkClass = "active";
							$spanStyle = "display:inline;";
							$spanClass = "";
						}
						
						echo "<li class='nav-item $linkClass' title='$linkDesc' onclick='setGVPageSession(\"$linkURL\",\"$GV_PageSSDATA\");GVcallLoader();'><span class='$spanClass'>$linkImage<span style='$spanStyle'>$linkDesc</span></span></li>";	
					}
					?>
				</ul>
			</div>
			
			<?
				$gvLogOutSrc = "../backend/gv_logout.php";
				$activityURL = GVstringEncrption("LoadHtmlPage=gv_activity");
			
			?>
			<div style='margin-right:15px;'>
				<div class="dropdown">
				  <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" style='background:#00ABFF;border:none;font-weight:600;letter-spacing:0.9;'>
				   <? echo $gv_username; ?>
				  </button>
				  <div class="dropdown-menu dropdown-menu-right">
				    <a class="dropdown-item" href="#" onclick="setGVPopupSession('<? echo $activityURL; ?>','<? echo $GV_PopupSSDATA; ?>',1000,550);">Activity History</a>
				    <a class="dropdown-item" href="javascript:void(0);" onclick="GVtopDirect('<? echo $gvLogOutSrc; ?>');">Logout</a>
				  </div>
				</div>
			</div>
		</nav>
		
	        <div class="page-content">
			<div id='main-content'>
				<?
					$MainIframeSrc = "../backend/gv_page_redirect.php";
					GViframe("GVmainFrame","GVmainFrame",$MainIframeSrc,"","border:0;width:100%;height:100%;","");
				?>
			</div>
		</div>
		
		<div id="GVLOADEROUT" style="cursor:none;background: rgba(0, 0, 0, 0.3);overflow:hidden;display:none;">
			<div id="GVLOADERIN">
				<div class="loader"></div>
			</div>
		</div>
		
		<div id="GVPOPOUT" style="cursor:default;background: rgba(0, 0, 0, 0.3);overflow:hidden;display:none;">
			<div id="GVPOPIN">
				<? GViframe("GVPopFrame","GVPopFrame","","","border:0;width:100%;height:100%;overflow: hidden;","scrolling='no'"); ?>
			</div>
		</div>
	</div>
	</body>
	</html>
	<?
		$pageReloadInd = 0;
		if (isset($_SESSION['page_gvid']) && $_SESSION['page_gvid'] != "")
		{
			GVPageSessionChange($_SESSION['page_gvid']);
			GVPrevPageSessionClear();
			$pageReloadInd = 1;
		}
	?>
<script>
	var _height = window.innerHeight;
  	document.getElementById("main-content").style.height = (_height - 45) + "px"; 
  	var _pageReloadInd = '<? echo $pageReloadInd; ?>';
  	
  	if(_pageReloadInd == 1)
  		GVtopDirect("../backend/gv_redirect");
</script>
<?
include_once("gv_footer.php"); 
?>