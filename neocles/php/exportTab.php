
<script>
function exportTab(){
	//var htmlTableau = "<?php echo $str;?>";
	//console.log(htmlTableau);
    myWindow = window.open("", "");
	
	myWindow.document.write('<html>');	
	myWindow.document.write('<head>');	
	//$(myWindow.document.body).append('<script src="test.js"><\/script>');	
	myWindow.document.write('<script type="text/javascript" src="js/export_csv.js"><\/script>');
	myWindow.document.write('<script type="text/javascript" src="http://jqueryjs.googlecode.com/files/jquery-1.3.1.min.js" > <\/script> ');	
	myWindow.document.write('<script type="text/javascript" src="http://www.kunalbabre.com/projects/table2CSV.js" > <\/script>');		 
	myWindow.document.write('<\/head>');		
	myWindow.document.write('<body>');	
	myWindow.document.write('<center>');
	//myWindow.document.write(htmlTableau);
	myWindow.document.write('<br/><br/><input style="text-align:center;width:800px;"  type="button" id="btnExport1" value="Export CSV" onclick="exp()"/><center>');	
	myWindow.document.write('<\/center>');	
	myWindow.document.write('<\/body>');	
	myWindow.document.write('<\/html>');		
}
</script>
<input type="button" value="Exporter le tableau" onclick="exportTab()"/>