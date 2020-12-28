<html>
  <head>
    
    <script type="text/javascript">
      var Sup30 = document.getElementById("Sup30").value;
      var Dessous15 = document.getElementById("Dessous15").value;
      var Entre15_30 = document.getElementById("Entre15_30").value;

      alert(Sup30);
      alert(Dessous15);
      alert(Entre15_30);

      google.charts.setOnLoadCallback(drawChart);
      
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Supérieur à 30 min',Sup30],
          ['Moins de 30 min',Dessous15],
          ['Entre 15min et 30min',Entre15_30]
        ]);

        var options = {
          title: 'SLA MAILS',
          pieHole: 0.5,
        };

        var chart = new google.visualization.PieChart(document.getElementById('donutchart'));
        chart.draw(data, options);
      }
    </script>
  </head>
  <body>
    <div id="donutchart" style="width: 900px; height: 500px;"></div>
  </body>
</html>