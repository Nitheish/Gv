<?
	 date_default_timezone_set('Asia/Kolkata');
   	 $todayDate =  date('d-m-Y');
   	 $todayTime =  date('h:i:s A');
   	 
   	 $timestamp = "<div class='row' style='padding-top:5px;'>";
   	 $timestamp .= "<div class='col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center'><span class='badge badge-success' style='font-family: sans-serif;font-size:14px;'>$todayDate</span></div>";
   	 $timestamp .= "<div class='col-lg-12 col-md-12 col-sm-12 col-xs-12text-center'><span class='badge badge-warning' style='font-family: sans-serif;font-size:14px;'>$todayTime</span></div>";
   	 $timestamp .="</div>";
   	 
   	 echo $timestamp;
?>