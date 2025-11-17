<h2>Welcome to GV finance management system<h2><br>
					<h4>We provide simple, scalable and flexible solutions that meet the efficient financial management of day to day activities.<h4>				
					
					
					<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" >
			 <a class="navbar-brand"><img src='<? echo "../gvtech/images/gvlogo1.png";?>' style="width:35px;height:35px;"></a>
			 <ul class="navbar-nav">
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
	    	</nav>
	    	
	    	
	    	
	    	
	    	<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
		  <a class="navbar-brand" href="#">Navbar</a>
		  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
		    <span class="navbar-toggler-icon"></span>
		  </button>
		
		  <div class="collapse navbar-collapse" id="navbarSupportedContent">
		    <ul class="navbar-nav mr-auto">
		      <li class="nav-item active">
		        <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
		      </li>
		      <li class="nav-item">
		        <a class="nav-link" href="#">Link</a>
		      </li>
		      <li class="nav-item dropdown">
		        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		          Dropdown
		        </a>
		        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
		          <a class="dropdown-item" href="#">Action</a>
		          <a class="dropdown-item" href="#">Another action</a>
		          <div class="dropdown-divider"></div>
		          <a class="dropdown-item" href="#">Something else here</a>
		        </div>
		      </li>
		      <li class="nav-item">
		        <a class="nav-link disabled" href="#">Disabled</a>
		      </li>
		    </ul>
		    <form class="form-inline my-2 my-lg-0">
		      <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
		      <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
		    </form>
		  </div>
		</nav>
		
		<script>
    $(document).ready(function(){
        swal("Success", "Something wenrt wrong,try later :)", "success");
    });
    
</script>


-if (!$dbLink = mysql_connect($dbHost, $dbUser, $dbPass))
+if (!$dbLink = mysqli_connect($dbHost, $dbUser, $dbPass))

-if (!mysql_select_db($dbName, $dbLink))
+if (!mysqli_select_db($dbLink, $dbName))

-if (!$result = mysql_query($query, $dbLink)) {
+if (!$result = mysqli_query($dbLink, $query)) {

-if (mysql_num_rows($result) > 0) {
+if (mysqli_num_rows($result) > 0) {

-while ($row = mysql_fetch_array( $result, MYSQL_ASSOC )) {
+while ($row = mysqli_fetch_array( $result, MYSQLI_ASSOC )) {

-mysql_close($dbLink);
+mysqli_close($dbLink);


$meta = $stmt->result_metadata();

			while ($field = $meta->fetch_field()) 
			{
			  $parameters[] = &$row[$field->name];
			}

			call_user_func_array(array($stmt, 'bind_result'), $MyValueArr);

			while ($stmt->fetch()) 
			{
			  foreach($row as $key => $val) 
			  {
			    $x[$key] = $val;
			  }
			  
			  $results[] = $x;
  			}
  			
  			
  			$MyQryStmt = mysqli_query($GLOBALS['conn'], $MyQry);
				
				if($MyQryStmt === false) 
				{
					die( print_r(mysqli_error(), true));
				}
				else
				{
					return $MyQryStmt;
				}
				
				
				if($MyQryStmt = mysqli_prepare($GLOBALS['conn'], $MyQry))
			{
				bindQueryParams($MyQryStmt, $MyParamType, $MyParamValue);
				mysqli_stmt_execute($MyQryStmt);
				mysqli_stmt_close($MyQryStmt);
			}
			
			
			
				<?
		include($_SERVER['DOCUMENT_ROOT']."/gvfinance/gv_path.php");
		include($GVTECHPATH."/gvfunction/gv_function.php");
		include($GVTECHPATH."/gvfunction/gv_dbconnect.php");
	
		// phpinfo();
		MyDbConnect();
		//echo GVgenerateKEY();
		//echo $conn;
		
		/*$_GVParamArray[] = array("KEY"=>"customer_code", "VAL"=>"test", "TYPE"=>"s");
		$_GVParamArray[] = array("KEY"=>"customer_key", "VAL"=>GVgenerateKEY(), "TYPE"=>"s");
		
		$outParamArr = GVgetQueryString($_GVParamArray);
		
		$MyInsertQry = "insert into customer (".$outParamArr['_INSERT_SQLQRY_FIELDS'].") values(".$outParamArr['_INSERT_SQLQRY_VAL'].")";
		MyDbQuery($MyInsertQry, $_GVParamArray);
		
		$MyDeleteQry = "delete from customer where ";
		$MyDeleteQry .= "customer_key=?";MYSQL_BuildArray("customer_key","60CD0794EAFC282F8C3399EE92376F0E1C5CF8C4","s");
		MyDbQuery($MyDeleteQry, $_GVParamArray);
		
		
		$_GVParamArray[] = array("KEY"=>"customer_code", "VAL"=>"AAAA", "TYPE"=>"s");
		
		$outParamArr = GVgetQueryString($_GVParamArray);
		
		$MyUpdateQry = "update customer set ".$outParamArr['_UPDATE_SQLQRY_VAL']." where ";
		$MyUpdateQry .= "customer_key=?";MYSQL_BuildArray("customer_key","5F820CF2ECF43031FB9D8DD32605398D75E14E7A","s");
		MyDbQuery($MyUpdateQry, $_GVParamArray);
		*/
		$MySelectQry = "select * from customer where";
		$MySelectQry .= " customer_key=?";MYSQL_BuildArray("customer_key","5F820CF2ECF43031FB9D8DD32605398D75E14E7A","s");
		$MyDbResult =  MyDbQuery($MySelectQry,$_GVParamArray);	
		while($MyRowData = mysqli_fetch_array($MyDbResult, MYSQLI_ASSOC)) 
		{
			echo $MyRowData['customer_id'].",".$MyRowData['customer_code']."<br/>";
			
			unset($_GVParamArray);
			$MySelectQry = "select customer_key from customer where";
			$MySelectQry .= " customer_id=?";MYSQL_BuildArray("customer_id",$MyRowData['customer_id'],"s");
			$MyDbResult1 =  MyDbQuery($MySelectQry,$_GVParamArray);	
			while($MyRowData1 = mysqli_fetch_array($MyDbResult1, MYSQLI_ASSOC))
			{
				echo $MyRowData1['customer_key']."<br/>";
			}
		}
		MyDbFreeResult($MyDbResult);
		
		MyDbClose();
	
	?>
	
	E_ALL & ~E_DEPRECATED & ~E_STRICT & ~E_NOTICE
	
	//include($LOGINPATH."/gv_login.php");
		//$strLocation = $_SERVER['DOCUMENT_ROOT']."/gvfinance/login/gv_login.php";
		//header("Location: /../../gvfinance/login/gv_login.php?");
		


$TimeDiffer = $currentTime - $lasttime;
			
	if($TimeDiffer > 1)
	{
		include("gv_footer.php");
		chdir($LOGINPATH);
		include("gv_session_expired.php");
		exit;
	}
	else if()
	{
	}
			
	
	
<? GVimageButton("Login","GVloginBtn","GVloginBtn",GVimage("image","image","/gvtech/images/user.png","","","width='18'"),"Submit","PRIMARY","","");  ?>		 

   <a id="show-sidebar" class="navbar-brand" href="#">
				            Menus
				        </a>
				        
				        
				        <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
		      <div class="container">
			        
			        <div class="MyTextAlignLeft">
				        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
						<span class="navbar-toggler-icon"></span>
					</button>
					
					<div class="collapse navbar-collapse" id="navbarSupportedContent">
						<ul class="navbar-nav mr-auto" id='Loginnav'>
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
			        </div>
			        
			        <div class="MyTextAlignRight">
			        	<a class="navbar-brand" href="#">GV Tech</a>
			        </div>
		      </div>
	    	</nav>
	    	
	    	
	    	 <nav id="sidebar" class="sidebar-wrapper">
		            <div class="sidebar-content">
		                <div class="sidebar-menu">
		                    <ul>
		                    	 <? $pageLoadURL = "../backend/gv_page_redirect.php?gvky=$gvky&LoadHtmlPage=gv_dashboard"; ?>
				         <li><a href="javascript:void(0);" onclick="GVloadDirect('<? echo $pageLoadURL; ?>');"><i class="fa fa-bar-chart-o"></i><span>Dashboard</span></a></li>
		                        
		                        <? $pageLoadURL = "../backend/gv_page_redirect.php?gvky=$gvky&LoadHtmlPage=gv_dashboard"; ?>
				         <li><a href="javascript:void(0);" onclick="GVloadDirect('<? echo $pageLoadURL; ?>');"><i class="fa fa-money"></i><span>Active Fund</span></a></li>
		                        
		                          <? $pageLoadURL = "../backend/gv_page_redirect.php?gvky=$gvky&LoadHtmlPage=gv_finance_info"; ?>
					  <li class="active"><a href="javascript:void(0);" onclick="GVloadDirect('<? echo $pageLoadURL; ?>');">Finance Info</a></li>
		                    </ul>
		                </div>
		                <!-- sidebar-menu  -->
		            </div>
		            <!-- sidebar-content  -->
		        </nav>
		        
		        
		        
		        <div style='margin-left:-40px;width:30px;background-color:#222425;'>
	<a id="show-sidebar" href="#"><span style='color:#fff;padding-left:8px;'><i class="fa fa-navicon"></i></span></a>
</div>
fa fa-navicon
<? echo GVimage("image","image","/gvtech/images/user.png","","","width='22'"); ?>

	<script type='text/javascript'>
		//var width = screen.width;
		//document.getElementById("mainFrame").style.width =width;
	</script>
	
	<? echo GVimage("image","image","/gvtech/images/animatedCircle.gif","","","width='50'");  ?>
	
----------------------------------------

	<div id="GVPOPOUT" style="cursor:none;background: rgba(0, 0, 0, 0.6);overflow:hidden;display:none;">
		<div id="GVPOPIN">
			<? GViframe("GVpopFrame","GVpopFrame","","","",""); ?>
		</div>
	</div>
	
	function GVPopUp(_href,_popWidth,_popHeight)
{
	var OutDiv =  parent.document.getElementById("GVPOPOUT");
		
	if(OutDiv)
	{
		if(_popWidth == 0 && _popHeight == 0)
		{
			_popWidth = window.innerWidth;
			_popWidth = window.innerHight;
		}
		
		var _body = parent.document.body;
		var _html = parent.document.documentElement;

		var _width = Math.min(_body.scrollWidth,_html.scrollWidth,_body.offsetWidth,_html.offsetWidth);
		var _height = Math.min(_body.scrollHeight,_html.scrollHeight,_body.offsetHeight,_html.offsetHeight,_html.clientHeight);
		
		OutDiv.style.width = _width;
		OutDiv.style.height = _height;
		
		OutDiv.style.left =  "0px";
		OutDiv.style.top =  "0px";
		OutDiv.style.overflow = "hidden";
		OutDiv.style.display = "block";
		OutDiv.style.position = "absolute";
		
		var InDiv =  parent.document.getElementById("GVPOPIN");
		
		var _left = (screen.width/2) - ( _popWidth/2);
		var _top = (screen.height/2) - (_popHeight/2);
		
		InDiv.style.width = _popWidth + "px";
		InDiv.style.height = _popHeight + "px";
		InDiv.style.left = _left + "px";
		InDiv.style.top = _top + "px";
		InDiv.style.position = "relative";
		
		parent.document.getElementById("GVpopFrame").src = _href;
		return false;
	}
}


<?$total_pages = 10; $num_results_on_page = 2; $page = 4;?>
<ul class="pagination">
	<? if ($page > 1){ ?>
	<li class="prev"><a href="pagination.?page=<? echo $page-1 ?>">Prev</a></li>
	<? } ?>

	<? if ($page > 3){ ?>
	<li class="start"><a href="pagination.?page=1">1</a></li>
	<li class="dots">...</li>
	<? } ?>

	<? if ($page-2 > 0){ ?><li class="page"><a href="pagination.?page=<? echo $page-2 ?>"><? echo $page-2 ?></a></li><? } ?>
	<? if ($page-1 > 0){ ?><li class="page"><a href="pagination.?page=<? echo $page-1 ?>"><? echo $page-1 ?></a></li><? } ?>

	<li class="currentpage"><a href="pagination.?page=<? echo $page ?>"><? echo $page ?></a></li>

	<? if ($page+ 1 < ceil($total_pages / $num_results_on_page)+1){ ?><li class="page"><a href="pagination.?page=<? echo $page+1 ?>"><? echo $page+1 ?></a></li><? } ?>
	<? if ($page+ 2 < ceil($total_pages / $num_results_on_page)+1){ ?><li class="page"><a href="pagination.?page=<? echo $page+2 ?>"><? echo $page+2 ?></a></li><? } ?>

	<? if ($page < ceil($total_pages / $num_results_on_page)-2){ ?>
	<li class="dots">...</li>
	<li class="end"><a href="pagination.?page=<? echo ceil($total_pages / $num_results_on_page) ?>"><? echo ceil($total_pages / $num_results_on_page) ?></a></li>
	<? } ?>

	<? if ($page < ceil($total_pages / $num_results_on_page)) { ?>
	<li class="next"><a href="pagination.?page=<? echo $page + 1 ?>">Next</a></li>
	<? } ?>
</ul>



<script type='text/javascript'>
var _height = screen.height;
	document.getElementById("main").style.height = (_height - 115) + "px";
</script>

	//$MySelectQry = "select count(*) from customer where";
	//$MySelectQry .= " finance_id=?";MYSQL_BuildArray("finance_id",$finance_id,"s");
	//$MyDbResult =  MyDbQuery($MySelectQry,$_GVParamArray);
	//$MyNumRows = MyDbNumRows($MyDbResult);
	
	//$totalNumPages = ceil($MyNumRows / $numRecordPerPage);
	//,count(*) OVER () totCnt
	
	
	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6" style='border:1px solid red;'>
					<label class="MyLabelText" style='display:inline-block;position:inline;'>Entries show per Page</label>
					<? GVComboBox("INPUT","numRecordPerPage","numRecordPerPage",$pagePerRecordArr,"","width:auto;align:right;",""); ?>
						
				</div>
			</div>
			
	
	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
				<div class="container" style='display:inline;'>
					<label class="MyLabelText text-left">Entries show per Page</label>&nbsp;&nbsp;
					<? GVComboBox("INPUT","numRecordPerPage","numRecordPerPage",$pagePerRecordArr,"","",""); ?>
				</div>
			</div>
	
	<!--<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
				<div class="row">
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
						<? GVComboBox("INPUT","numRecordPerPage","numRecordPerPage",$pagePerRecordArr,"","",""); ?>
					</div>
					
					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6" style='padding-top:4px;'>
						<label class="MyLabelText text-left">Entries show per Page</label>
					</div>
				</div>
			</div>-->
			
	<!--<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
				<div class="row">
					<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
						<? GVComboBox("INPUT","numRecordPerPage","numRecordPerPage",$pagePerRecordArr,"","",""); ?>
					</div>
					
					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6" style='padding-top:4px;'>
						<label class="MyLabelText text-left">Entries show per Page</label>
					</div>
				</div>
			</div>-->
			
			<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3" style='display:flex;'>
				<label class="MyLabelText text-left">Show</label>&nbsp;&nbsp;
				<? GVComboBox("INPUT","numRecordPerPage","numRecordPerPage",$pagePerRecordArr,"","",""); ?>
				<label class="MyLabelText text-left">entries</label>
			</div>
	
	
	<div class="row" style='background-color:#e9ecef;padding-top:12px;'>
			<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
				<label class="MyLabelText text-left" style='padding-top:10px;'>Search</label>
			</div>
			
			<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
				<? GVComboBox("INPUT","cboCustSearchOpt","cboCustSearchOpt",$custSerachOptArr,"","",""); ?>
			</div>
			
			<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
				<? GVTextBox("INPUT","txtCustomerName","txtCustomerName","","","maxlength='35' placeholder='Customer Name'"); ?> 
			</div>
			
			<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
				<? echo GVimage("edit","edit","/gvtech/images/Refresh.png","","","width='22' title='Edit'");  ?>
				<? echo GVimage("edit","edit","/gvtech/images/edit.png","","","width='22' title='Edit'");  ?>
			</div>
			
			<div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
				<? GVComboBox("INPUT","numRecordPerPage","numRecordPerPage",$pagePerRecordArr,"","","onchange='GVformPost();'"); ?>
			</div>
			
			<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
				<label class="MyLabelText text-left" style='padding-top:10px;'>Record Per Page </label>
			</div>
			
			<div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
				<?
				$AddURL = "../backend/gv_page_redirect.php?gvky=$gvky".GVqueryString("LoadHtmlPage=gv_customer_details&GVmenu=$GVmenu&GVsubMenu=$GVsubMenu&GVSTEP=ADD");
				GVimageButton("ADD NEW","GVloginBtn","GVloginBtn",GVimage("image","image","/gvtech/images/add.png","","","width='15'"),"button","SECONDARY","","onclick=GVcallLoader();GViframeDirect('$AddURL');");  
				?>
			</div>
		</div>
		
		GVanchor("GVSearch","GVSearch","javascript:void(0);","",GVimage("edit","edit","/gvtech/images/search.png","","padding-top:5px;","width='25' title='Search'"),"","onclick=GVcallLoader();GVformPost();");
					GVanchor("GVRefresh","GVRefresh","javascript:void(0);","",GVimage("edit","edit","/gvtech/images/Refresh.png","","padding-top:5px;","width='25' title='Refresh'"),"","onclick=GVRefresh_onClick();");
					
					
		function GVRefresh_onClick()
		{
			document.getElementById("cboCustSearchOpt").value = "ALL";
			GVcallLoader();
			GVformPost();
		}
		
		$interest_amount = 0;
		$MySelectQry = "select * from monthly_int_loan where";
		$MySelectQry .= " finance_id=?";MYSQL_BuildArray("finance_id",$finance_id,"s");
		$MySelectQry .= " and monthly_int_loan_id=?";MYSQL_BuildArray("monthly_int_loan_id",$GVID,"s");
		$MyDbResult =  MyDbQuery($MySelectQry,$_GVParamArray);	
		if($MyRowData = mysqli_fetch_array($MyDbResult, MYSQLI_ASSOC)) 
		{
			$interest_amount = GVformatAmount(trim($MyRowData['interest_amount']));
		}
		MyDbFreeResult($MyDbResult);
		
		$timestamp = "<div class='row' style='padding-top:5px;'>";
   	 $timestamp .= "<div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'><span class='badge badge-Success' style='font-size:16px;'>$todayDate</span></div>";
   	 $timestamp .= "<div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'><span class='badge badge-warning' style='font-size:16px;'>$todayTime</span></div>";
   	 $timestamp .="</div>";
   	 
   	 
   	 $.ajax({
				url: DelURL,
				type: "POST",
				cache:false,
				data:{},
				success: function (response) 
				{
					response = response.trim();
					var position = response.indexOf("[GVC]");
					response = response.substr(position + 5);
					var responseArr = JSON.parse(response);
					
					if(responseArr['STATUS'] == 'DELETE')
					{
						GVcallLoader();
						var URLsrc = parent.document.getElementById("GVmainFrame").src;
						parent.document.getElementById("GVmainFrame").src = URLsrc;
					}
				}
			});
			
			$jsonData = json_encode($responseArr);
	echo "[GVC]";
	echo $jsonData;
	
	
	<div class="card">
				<div class="card-header bg-info" style='padding:6px;font-family: sans-serif;font-size: 13px;color:#fff;font-weight: bold;background-color:#666666;'>Product Details</div>
				<div class="card-body" style='padding:6px;'>
					<div class="row">
						<div class="col-lg-5 col-md-12 col-sm-12 col-xs-12">
							<label class="MyLabelText">Product Name</label>
						</div>
						
						<div class="col-lg-7 col-md-12 col-sm-12 col-xs-12">
							<label class="MyLabelText" style="text-align:left;color:#428bca;"><? echo $loanStatus." ".$loanPreCloseStatus; ?></label>
						</div>
					</div>
					
					<div class="row">
						<div class="col-lg-5 col-md-12 col-sm-12 col-xs-12">
							<label class="MyLabelText">Product Code</label>
						</div>
						
						<div class="col-lg-7 col-md-12 col-sm-12 col-xs-12">
							<label class="MyLabelText" style="text-align:left;color:#428bca;"><span class="badge badge-primary" style='font-size:12px;'><? echo $txtLoanCode;?></span></label>
						</div>
					</div>
					
					<div class="row">
						<div class="col-lg-5 col-md-12 col-sm-12 col-xs-12">
							<label class="MyLabelText">Initial Quantity</label>
						</div>
						
						<div class="col-lg-7 col-md-12 col-sm-12 col-xs-12">
							<label class="MyLabelText" style="text-align:left;color:#428bca;"><? echo $loanStatus." ".$loanPreCloseStatus; ?></label>
						</div>
					</div>
					
					<div class="row">
						<div class="col-lg-5 col-md-12 col-sm-12 col-xs-12">
							<label class="MyLabelText">Initial Quantity Unit Price</label>
						</div>
						
						<div class="col-lg-7 col-md-12 col-sm-12 col-xs-12">
							<label class="MyLabelText" style="text-align:left;color:#428bca;"><? echo $loanStatus." ".$loanPreCloseStatus; ?></label>
						</div>
					</div>
					
					<div class="row">
						<div class="col-lg-5 col-md-12 col-sm-12 col-xs-12">
							<label class="MyLabelText">Initial Quantity Total Price</label>
						</div>
						
						<div class="col-lg-7 col-md-12 col-sm-12 col-xs-12">
							<label class="MyLabelText" style="text-align:left;color:#428bca;"><? echo $loanStatus." ".$loanPreCloseStatus; ?></label>
						</div>
					</div>
					
					<div class="row">
						<div class="col-lg-5 col-md-12 col-sm-12 col-xs-12">
							<label class="MyLabelText">Selling Price</label>
						</div>
						
						<div class="col-lg-7 col-md-12 col-sm-12 col-xs-12">
							<label class="MyLabelText" style="text-align:left;color:#428bca;"><? echo $loanStatus." ".$loanPreCloseStatus; ?></label>
						</div>
					</div>
					
					<div class="row">
						<div class="col-lg-5 col-md-12 col-sm-12 col-xs-12">
							<label class="MyLabelText">Total Product</label>
						</div>
						
						<div class="col-lg-7 col-md-12 col-sm-12 col-xs-12">
							<label class="MyLabelText" style="text-align:left;color:#428bca;"><? echo $loanStatus." ".$loanPreCloseStatus; ?></label>
						</div>
					</div>
					
					<div class="row">
						<div class="col-lg-5 col-md-12 col-sm-12 col-xs-12">
							<label class="MyLabelText">Sold Product</label>
						</div>
						
						<div class="col-lg-7 col-md-12 col-sm-12 col-xs-12">
							<label class="MyLabelText" style="text-align:left;color:#428bca;"><? echo $loanStatus." ".$loanPreCloseStatus; ?></label>
						</div>
					</div>
					
					<div class="row">
						<div class="col-lg-5 col-md-12 col-sm-12 col-xs-12">
							<label class="MyLabelText">Remaining Product</label>
						</div>
						
						<div class="col-lg-7 col-md-12 col-sm-12 col-xs-12">
							<label class="MyLabelText" style="text-align:left;color:#428bca;"><? echo $loanStatus." ".$loanPreCloseStatus; ?></label>
						</div>
					</div>
				</div>
				</div>
				</div>
				
				
				$MySelectQry = "select product_id from sales_product where";
					$MySelectQry .= " company_id=?";MYSQL_BuildArray("company_id",$company_id,"s");
					$MySelectQry .= " and sales_id=?";MYSQL_BuildArray("sales_id",$GVID,"s");
					$MySelectQry .= " and product_id=?";MYSQL_BuildArray("product_id",$productID,"s");
					$MyDbResult =  MyDbQuery($MySelectQry,$_GVParamArray);
					$MyNumRows = MyDbNumRows($MyDbResult);	
					MyDbFreeResult($MyDbResult);
					
		$incr = 0;
			
			while($txtQuantity != 0)
			{
				$stock_info_id = $stockInfoIDArr[$productID][$incr];
				$stockVal = $stockInfoDetailsArr[$productID][]
				
				
				$_GVParamArray[] = array("KEY"=>"company_id", "VAL"=>$company_id, "TYPE"=>"s");
				$_GVParamArray[] = array("KEY"=>"sales_id", "VAL"=>$GVID, "TYPE"=>"s");
				$_GVParamArray[] = array("KEY"=>"product_id", "VAL"=>$productID, "TYPE"=>"s");
				$_GVParamArray[] = array("KEY"=>"quantity", "VAL"=>$txtQuantity, "TYPE"=>"s");
				$_GVParamArray[] = array("KEY"=>"price", "VAL"=>$txtRate, "TYPE"=>"s");
				$_GVParamArray[] = array("KEY"=>"total_amt", "VAL"=>$txtAmount, "TYPE"=>"s");
				$_GVParamArray[] = array("KEY"=>"stock_type", "VAL"=>"S", "TYPE"=>"s");
				$outParamArr = GVgetQueryString($_GVParamArray);
				
				$MyInsertQry = "insert into stock_track (".$outParamArr['_INSERT_SQLQRY_FIELDS'].") values(".$outParamArr['_INSERT_SQLQRY_VAL'].")";
				MyDbQuery($MyInsertQry, $_GVParamArray);
				
				$txtQuantity = $txtQuantity - $stockVal;
			}
			
			
			foreach($stockInfoDetailsArr as $stock_info_id=>$stockVal)
			{
				if($txtQuantity > $stockVal)
				{
					$txtQuantity = $stockVal;
				}
			}
			
			
			
			/*$prodTotQtyArr = array();
	
	$MySelectQry = "select product_id,total_qty from product_info where";
	$MySelectQry .= " company_id=?";MYSQL_BuildArray("company_id",$company_id,"s");
	$MySelectQry .= " and delete_ind=?";MYSQL_BuildArray("delete_ind",'0',"s");
	$MySelectQry .= " and product_id in (".MYSQL_ArrayBuild_String($prodCalArr).")";MYSQL_BuildArray("product_id",$prodCalArr,"s");
	$MyDbResult =  MyDbQuery($MySelectQry,$_GVParamArray);	
	while($MyRowData = mysqli_fetch_array($MyDbResult, MYSQLI_ASSOC)) 
	{
		$prodTotQtyArr[trim($MyRowData['product_id'])] = trim($MyRowData['total_qty']);
	}
	MyDbFreeResult($MyDbResult);
	
	$prodSoldArr = array();
	
	$MySelectQry = "select sum(product_quantity) as totSalesQty,product_id from sales_product where";
	$MySelectQry .= " company_id=?";MYSQL_BuildArray("company_id",$company_id,"s");
	$MySelectQry .= " and delete_ind=?";MYSQL_BuildArray("delete_ind",'0',"s");
	$MySelectQry .= " and product_id in (".MYSQL_ArrayBuild_String($prodCalArr).")";MYSQL_BuildArray("product_id",$prodCalArr,"s");
	$MySelectQry .= " group by product_id";
	$MyDbResult =  MyDbQuery($MySelectQry,$_GVParamArray);	
	while($MyRowData = mysqli_fetch_array($MyDbResult, MYSQLI_ASSOC)) 
	{
		$prodSoldArr[trim($MyRowData['product_id'])] =trim($MyRowData['totSalesQty']);
	}
	MyDbFreeResult($MyDbResult);
	
	foreach($prodCalArr as $key=>$product_id)
	{
		$totProdQty = $prodTotQtyArr[$product_id];
		$soldProdQty = $prodSoldArr[$product_id];
		
		$remainingProdQty = $totProdQty - $soldProdQty;
		
		$_GVParamArray[] = array("KEY"=>"remaining_qty", "VAL"=>$remainingProdQty, "TYPE"=>"s");
		$_GVParamArray[] = array("KEY"=>"sold_qty", "VAL"=>$soldProdQty, "TYPE"=>"s");
		$_GVParamArray[] = array("KEY"=>"modified_datetime", "VAL"=>"CURRENT_TIMESTAMP()", "TYPE"=>"SKIP");
		
		$outParamArr = GVgetQueryString($_GVParamArray);
		
		$MyUpdateQry = "update product_info set ".$outParamArr['_UPDATE_SQLQRY_VAL']." where ";
		$MyUpdateQry .= " company_id=?";MYSQL_BuildArray("company_id",$company_id,"s");
		$MyUpdateQry .= " and product_id=?";MYSQL_BuildArray("product_id",$product_id,"s");
		MyDbQuery($MyUpdateQry, $_GVParamArray);
	}*/
	
	//stock Track
	/*$_GVParamArray[] = array("KEY"=>"company_id", "VAL"=>$company_id, "TYPE"=>"s");
	$_GVParamArray[] = array("KEY"=>"sales_id", "VAL"=>$GVID, "TYPE"=>"s");
	$_GVParamArray[] = array("KEY"=>"product_id", "VAL"=>$productID, "TYPE"=>"s");
	$_GVParamArray[] = array("KEY"=>"quantity", "VAL"=>$txtQuantity, "TYPE"=>"s");
	$_GVParamArray[] = array("KEY"=>"price", "VAL"=>$txtRate, "TYPE"=>"s");
	$_GVParamArray[] = array("KEY"=>"total_amt", "VAL"=>$txtAmount, "TYPE"=>"s");
	$_GVParamArray[] = array("KEY"=>"status", "VAL"=>"SALES", "TYPE"=>"s");
	$outParamArr = GVgetQueryString($_GVParamArray);
	
	$MyInsertQry = "insert into stock_track (".$outParamArr['_INSERT_SQLQRY_FIELDS'].") values(".$outParamArr['_INSERT_SQLQRY_VAL'].")";
	MyDbQuery($MyInsertQry, $_GVParamArray);*/
	
	/*$MyDeleteQry = "delete from stock_track where ";
	$MyDeleteQry .= " company_id=?";MYSQL_BuildArray("company_id",$company_id,"s");
	$MyDeleteQry .= " and sales_id=?";MYSQL_BuildArray("sales_id",$GVID,"s");
	$MyDeleteQry .= " and product_id in (".MYSQL_ArrayBuild_String($delProdDetailsArr).")";MYSQL_BuildArray("product_id",$delProdDetailsArr,"s");
	MyDbQuery($MyDeleteQry, $_GVParamArray);*/
	
	
	/*$_GVParamArray[] = array("KEY"=>"quantity", "VAL"=>$txtQuantity, "TYPE"=>"s");
	$_GVParamArray[] = array("KEY"=>"price", "VAL"=>$txtRate, "TYPE"=>"s");
	$_GVParamArray[] = array("KEY"=>"total_amt", "VAL"=>$txtAmount, "TYPE"=>"s");
	$_GVParamArray[] = array("KEY"=>"status", "VAL"=>"SALES", "TYPE"=>"s");
	$_GVParamArray[] = array("KEY"=>"modified_datetime", "VAL"=>"CURRENT_TIMESTAMP()", "TYPE"=>"SKIP");
	
	$outParamArr = GVgetQueryString($_GVParamArray);
	
	$MyUpdateQry = "update stock_track set ".$outParamArr['_UPDATE_SQLQRY_VAL']." where ";
	$MyUpdateQry .= " company_id=?";MYSQL_BuildArray("company_id",$company_id,"s");
	$MyUpdateQry .= " and sales_id=?";MYSQL_BuildArray("sales_id",$GVID,"s");
	$MyUpdateQry .= " and product_id=?";MYSQL_BuildArray("product_id",$productID,"s");
	MyDbQuery($MyUpdateQry, $_GVParamArray);*/
	
	GVInputButton("Search","GVSaveBtn","GVSearchBtn","submit","SECONDARY","margin-left: 5px;height:27px;font-size:11px;","");
			GVInputButton("Reset","GVSaveBtn","GVResetBtn","button","SECONDARY","margin-left: 5px;height:27px;font-size:11px;","onclick='reset_btnClick();'");
			
	if($cboSearchOpt == "CODE" && strlen($txtSearchStr) > 0)
		{
			$searchStr = str_replace("SL","",$txtSearchStr);
			$MySelectQry .= " and sales_id=?";MYSQL_BuildArray("sales_id",$searchStr,"s");
		} 
		
		
		<?
				$print = "../backend/gv_print.php";
				$pdf = "../backend/gv_pdf.php";
				echo "<a href='$pdf'>PDF</a>";
				echo "<br><a href='$print'>PRINT</a>";
				?>
				
	box-shadow: rgb(0 0 0 / 24%) 0px 3px 8px
	
	GVanchor("GVPrintBtn","GVPrintBtn",$pdfLink,"",GVimage("image","image","/gvtech/images/printer.png","","","width='20'"),"","");  
	#28a745
	#dc3545	
	
	select count(customer_id) as totCnt over(PARTITION BY 1), *
from (select sum(tot_qty),sum(overall_amount),sum(paid_amt),sum(balance_due),sum(sales_profit), customer_id from sales_info GROUP by customer_id) as temp 				

WITH CTE as (select sum(tot_qty),sum(overall_amount),sum(paid_amt),sum(balance_due),sum(sales_profit), customer_id from sales_info GROUP by customer_id) , totCnt as (select count(customer_id) from CTE)
SELECT * from CTE,totCnt

select count(customer_id)
from (select sum(tot_qty),sum(overall_amount),sum(paid_amt),sum(balance_due),sum(sales_profit), customer_id from sales_info GROUP by customer_id) as temp 

select temp.*, (select count(customer_id) from temp) as totCnt
from (select sum(tot_qty),sum(overall_amount),sum(paid_amt),sum(balance_due),sum(sales_profit), customer_id from sales_info GROUP by customer_id) temp

select temp.*
from (select sum(tot_qty),sum(overall_amount),sum(paid_amt),sum(balance_due),sum(sales_profit), customer_id from sales_info GROUP by customer_id) temp,


select temp.*,(select count(DISTINCT(customer_id)) from sales_info) from (select sum(tot_qty),sum(overall_amount),sum(paid_amt),sum(balance_due),sum(sales_profit),customer_id from sales_info si GROUP by customer_id) as temp

select temp.*,(select count(DISTINCT(customer_id)) from sales_info) as totCnt from (select sum(tot_qty) as tot_qty,sum(overall_amount) as overall_amount,sum(paid_amt) as paid_amt,sum(balance_due) as balance_due,sum(sales_profit) as sales_profit,customer_id from sales_info si GROUP by customer_id) as temp

select temp.*,(select count(DISTINCT(customer_id)) from sales_info where company_id='1' and delete_ind='0' ) as totCnt from (select sum(tot_qty) as tot_qty,sum(overall_amount) as overall_amount,sum(paid_amt) as paid_amt, sum(balance_due) as balance_due,sum(sales_profit) as sales_profit,customer_id,company_id,delete_ind from sales_info si GROUP by company_id,customer_id,delete_ind) as temp where company_id='1' and delete_ind='0' order by company_id desc LIMIT 10 offset 0


select temp.*,(select count(DISTINCT(customer_id)) from sales_info where company_id='1' and delete_ind='0' ) as totCnt from (select sum(tot_qty) as tot_qty,sum(overall_amount) as overall_amount,sum(paid_amt) as paid_amt, sum(balance_due) as balance_due,sum(sales_profit) as sales_profit,customer_id,company_id,delete_ind from sales_info si GROUP by company_id,customer_id,delete_ind) as temp where company_id='1' and delete_ind='0' order by company_id desc LIMIT 10 offset 0

SELECT SI.customer_id,SI.sales_id,PI.pay_date,PI.pay_amount,PI.payment_type FROM payment_info PI INNER JOIN sales_info SI ON PI.company_id=si.company_id AND PI.sales_id=SI.sales_id 



///

SL695
SL728