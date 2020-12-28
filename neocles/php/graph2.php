
	            <input id="Sup30" type="hidden" value="<?=$pourc_mailsSup30?>">
				 <input id="Dessous15" type="hidden" value="<?=$pourc_dessous15?>">
                 <input id="Entre15_30" type="hidden" value="<?=$pourc_mails15_30?>">
                 <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
    var Sup30 = document.getElementById("Sup30").value;
    var Dessous15 = document.getElementById("Dessous15").value;
    var Entre15_30 = document.getElementById("Entre15_30").value;

    alert(Sup30);
    alert(Dessous15);
    alert(Entre15_30);

    google.load("visualization", "1", {packages:["corechart"]});
    google.setOnLoadCallback(drawChart);

    function drawChart() {
        // Chart 1
        var data = google.visualization.arrayToDataTable([["Sup 30min",Sup30 ],["Moins 15min",Dessous15],["Entre 15min et 30min",Entre15_30]]);
        var options = {
        title: 'SLA MAILS'
        };
        var chart = new google.visualization.PieChart(document.getElementById('piechart'));
        chart.draw(data, options);
    }
    </script>

    <div id="piechart" style="width: 100%; height: 500px;">&nbsp;</div>