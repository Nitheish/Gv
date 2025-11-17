<?
	include("gv_header.php");
	$txtRate = "0.00";
	$txtGSTPercent = "5.00";
	$txtAmount = "0.00";
	$txtCalPercent = "40.00";
	
?>
	<form action='<? echo "../backend/gv_product_percent.php"; ?>' method="post" id='GVform' autocomplete="off">
	<div class="container">
	<div class="row" style='padding: 12px 7px 0px 0px;'>
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">
			<label class="MyTextHeading"><i class='fa fa-cart-arrow-down'></i><span>Product rate calculation</span></label>
		</div>
	</div>
	
	<div class="row" style='margin-top:55px;'>
		<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-right">
			<label class="MyLabelText">Product Amount</label>
		</div>
		
		<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
			<? GVAmountBox("INPUT","txtRate","txtRate","txtRate","","placeholder='Rate'"); ?> 
		</div>
	</div>
	
	<div class="row" style='margin-top:5px;'>
		<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-right">
			<label class="MyLabelText">GST Percentage</label>
		</div>
		
		<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
			<? GVPercentBox("INPUT","txtGSTPercent","txtGSTPercent","txtGSTPercent","","maxlength='6' placeholder='Percentage' onkeypress='return isMoneyKey(this, this.value);'"); ?> 
		</div>
	</div>
	
	<div class="row" style='margin-top:5px;'>
		<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-right">
			<label class="MyLabelText">Calculate Percentage</label>
		</div>
		
		<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
			<? GVPercentBox("INPUT","txtCalPercent","txtCalPercent","txtCalPercent","","maxlength='6' placeholder='Percentage' onkeypress='return isMoneyKey(this, this.value);'"); ?> 
		</div>
	</div>
	
	<div class="row" style='margin-top:55px;'>
		<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 text-right">
			<label class="MyLabelText">Calculated Amount</label>
		</div>
		
		<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
			<? GVAmountBox("INPUT","txtAmount","txtAmount","txtAmount","","placeholder='Calculated Amount'"); ?> 
		</div>
	</div>
	</div>
	
	<script type='text/javascript'>
	
	$("#txtRate").on("blur", function() {
	   salesCalculation();
	});
	
	$("#txtGSTPercent").on("blur", function() {
	   salesCalculation();
	});
	
	function salesCalculation()
	{
		var _prodRate = parseFloat($("#txtRate").val());
		var _gstPercent = $("#txtGSTPercent").val();
		var _calPercent = $("#txtCalPercent").val();
		
		var _gstAmt =  parseFloat(((_prodRate * _gstPercent) / 100) + _prodRate);
		var _prodAmt = parseFloat(((_calPercent * _gstAmt) / 100) + _gstAmt);
		$("#txtAmount").val(_prodAmt.toFixed(2));
	}
	</script>
	</form>
<?	
	include("gv_footer.php");
?>