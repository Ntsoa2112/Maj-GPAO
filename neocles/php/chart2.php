<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="php/graph/RGraph.common.core.js"></script>
    <script src="php/graph/RGraph.common.dynamic.js"></script>
    <script src="php/graph/RGraph.common.tooltips.js"></script>
    <script src="php/graph/RGraph.pie.js"></script>
</head>
<body>
<canvas id="cvs" width="600" height="350" style="border: 1px solid #eee">

</canvas>

<script>
    labels = ['Mavis','Kevin','Luis'];

    // Create the Pie chart, set the donut variant and the rest of the
    // configuration. The variant property is what sets the chart to
    // be a Donut chart instead of a regular Pie chart.
    new RGraph.Pie({
        id: 'cvs',
        data: [4,8,6],
        options: {
            shadow: true,
            shadowOffsetx: 0,
            shadowOffsety: 5,
            shadowColor: '#aaa',
            variant: 'donut3d',
            labels: labels,
            labelsSticksLength: 15,
            labelsSticksLinewidth: 2,
            textAccessible: false,
            colorsStroke: 'transparent'
        }
    }).draw().responsive([
        {maxWidth: 900,width:400,height:250,options:{radius: 90,labels: null,title: '(Click for labels)',tooltips:labels}},
        {maxWidth: null,width:600,height:350,options:{radius: 100,labelsList: true, labels:labels,title:'',tooltips:null}}
    ]);
</script>
</body>
</html>