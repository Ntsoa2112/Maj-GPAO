<head>
  <style>
    .taille{
      display: block;
      width: 700px;
      height: 450px;
    };
  </style>
</head>
<body>
        <div class="taille"><canvas  id="doughnut-chart" width="60" height="40"></canvas></div>

        
        <input id="Sup30" type="hidden" value="<?=$pourc_mailsSup30?>">
        <input id="Dessous15" type="hidden" value="<?=$pourc_dessous15?>">
        <input id="Entre15_30" type="hidden" value="<?=$pourc_mails15_30?>">
</body>

<script>

      
    var Sup30 = document.getElementById("Sup30").value;
    var Dessous15 = document.getElementById("Dessous15").value;
    var Entre15_30 = document.getElementById("Entre15_30").value;
    // $ajax.get(http//dsfqqdsf");
    // var ArrayValueByDate = getInfoFromBdd();
    console.log(Sup30 +" " + Dessous15 +" "+ Entre15_30);
console.log("teste");
new Chart(document.getElementById("doughnut-chart"), {
    type: 'doughnut',
    data: {
      labels: ["Supérieur à 30 min ", "En desssous de 15 min ", "Entre 15 min  à 30 min"],
      datasets: [
        {
          label: "Population (millions)",
          backgroundColor: ["#B61C7E", "#039103","#396ADB"],
          data: [Sup30 ,Dessous15,Entre15_30]
        }
      ]
    },
    options: {
      title: {
        display: true,
        <?php
        if(isset($sup) && $sup){
            ?>
            text: 'SLA DES SUPERVISIONS'
            <?php
        }
        else{
            ?>
            text: 'SLA DES MAILS'
            <?php
        }
        ?>
        
      }
    }
    // chart.data = ArrayValueByDate;
    // chart.refresh();
});

function chart(){
  new Chart(document.getElementById("doughnut-chart"), {
    type: 'doughnut',
    data: {
      labels: ["Supérieur à 30 min ", "En desssous de 15 min ", "Entre 15 min  à 30 min"],
      datasets: [
        {
          label: "Population (millions)",
          backgroundColor: ["red", "green","blue"],
          data: [Sup30 ,Dessous15,Entre15_30]
        }
      ]
    },
    options: {
      title: {
        display: true,
        text: 'SLA DES MAILS'
      }
    }
    // chart.data = ArrayValueByDate;
    // chart.refresh();
});
}
console.log("teste");
</script>
