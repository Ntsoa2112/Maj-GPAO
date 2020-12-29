<html>
  <head>

    <script type="text/javascript">
      google.charts.load('current', {'packages':['bar']});
      google.charts.setOnLoadCallback(drawChart);
      
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
        ['', 'En desssous de 15 min ', 'Entre 15 min  à 30 min', 'Supérieur à 30 min ', { role: 'annotation' } ],
        
        
        <?php
       // print_r($tab);

        for($i=0;$i<COUNT($tab);$i++){
         //echo "['".$tab[$i]['date_arrivee']."',".$tab[$i]['nbr_Inf15']." , ".$tab[$i]['nbr_Entre15_30'].", ".$tab[$i]['resulat_sup30'].", ''],";
         //echo $tab[$i]['nbr_Inf15'];
         $dat = substr($tab[$i]['date_arrivee'], 0, 5);
         $inf_15 = (isset($tab[$i]['nbr_Inf15'])) ? $tab[$i]['nbr_Inf15'] : 0;
         $entre_15_30 = (isset($tab[$i]['nbr_Entre15_30'])) ? $tab[$i]['nbr_Entre15_30'] : 0;
         $sup_30 = (isset($tab[$i]['resulat_sup30'])) ? $tab[$i]['resulat_sup30'] : 0;
         ?>
         ['<?=$dat?>',<?= $inf_15 ?>,<?= $entre_15_30 ?>, <?= $sup_30 ?>,''],
         <?php
        }
        ?>

      ]);
      
      var options = {
        colors: ['#039103','#396ADB','#B61C7E'],
        <?php
        if(isset($sup) && $sup){
            ?>
            width: 1000,
            height: 400,
            <?php
        }
        else{
            ?>
            width: 1300,
          height: 600,
            <?php
        }
        ?>
        
        legend: { position: 'top', maxLines: 3 },
        bar: { groupWidth: '75%' },
        is3D:true
      };

        var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

        chart.draw(data, google.charts.Bar.convertOptions(options));
      }
    </script>
  </head>
  <body>
 
    <?php
    if(isset($sup) && $sup){
        ?>
          <div id="columnchart_material" style="width: 1300px; height: 550px;"></div>
        <?php
    }
    else{
        ?>
           <div id="columnchart_material" style="width: 1300px; height: 650px;"></div>
        <?php
    }
    ?>
  </body>
</html>

