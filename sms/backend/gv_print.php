
<div id="printableArea">
      <h1>Print me</h1>
</div>

<?

?>

<script>
function printDiv(divName) {
     var printContents = document.getElementById(divName).innerHTML;
     var originalContents = document.body.innerHTML;

     document.body.innerHTML = printContents;

     window.print();

     document.body.innerHTML = originalContents;
     
     w=window.open();
w.document.write(document.getElementById(divName).innerHTML);
w.print();
w.close();
}

printDiv("printableArea");
</script>

