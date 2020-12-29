<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.min.js"></script>
</head>
<body>
    <?php
    if(isset($sup) && $sup){
        ?>
        <canvas id="createCurrYearHccGapChart" width="1000" height="400"></canvas>
        <?php
    }
    else{
        ?>
        <canvas id="createCurrYearHccGapChart" width="1500" height="600"></canvas>
        <?php
    }
    ?>
    
</body>
<script>
    var chartData = {
      type: 'horizontalBar',
      data: {
         labels: [
             <?php
             for($i=0; $i<count($intervenant);$i++){
                 echo "'".$intervenant[$i]["intervenant"]."',";
             }
             ?>
         ],
        
         datasets: [{
            label: "En desssous de 15 min",
            backgroundColor: '#039103',
            data: [
                <?php
                for($i=0; $i<count($intervenant);$i++){
                    $inf_15 = (isset($intervenant[$i]['nbr_Inf15'])) ? $intervenant[$i]['nbr_Inf15'] : 0;
                    echo $inf_15.",";
                }
                ?>
            ]
         }, {
            label: "Entre 15 min à 30 min",
            backgroundColor: '#396ADB',
            data: [
                <?php
                for($i=0; $i<count($intervenant);$i++){
                    $nbr_Entre15_30 = (isset($intervenant[$i]['nbr_Entre15_30'])) ? $intervenant[$i]['nbr_Entre15_30'] : 0;
                    echo $nbr_Entre15_30.",";
                }
                ?>
            ]
         }, {
            label: "Supérieur à 30 min",
            backgroundColor: '#B61C7E',
            data: [
                <?php
                for($i=0; $i<count($intervenant);$i++){
                    $resulat_sup30 = (isset($intervenant[$i]['resulat_sup30'])) ? $intervenant[$i]['resulat_sup30'] : 0;
                    echo $resulat_sup30.",";
                }
                ?>
            ]
         }]
      },
      options: {
         responsive: false,
         legend: {
            display: false
         },
         scales: {
            yAxes: [{
               stacked: true
            }],
            xAxes: [{
               stacked: true
            }]
         },

      }
}

var canvas = document.getElementById('createCurrYearHccGapChart');
var myChart = new Chart(canvas, chartData);

canvas.onclick = function(evt) {
      var activePoint = myChart.getElementAtEvent(evt)[0];
      var data = activePoint._chart.data;
      var datasetIndex = activePoint._datasetIndex;
      var label = data.datasets[datasetIndex].label;
      var value = data.datasets[datasetIndex].data[activePoint._index];
      console.log(label, value);
};
</script>
</html>