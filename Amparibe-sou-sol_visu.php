<?php
	include_once('php/common.php');	
	 $c = new Cnx();
	 //return;
?>
<html xmlns="http//www.w3.org/1999/xhtml" xmllang="en" lang="en"   ng-app="LoadMap">
<head>
  <title>Easytech.mg</title>
  <script src="js/angular.min.js"></script>
  <meta http-equiv="Content-Type" content="text/html; Charset=utf-8" />
  <meta name="easytech" content="easytech" />
  <meta content="" name="Keywords" />
  <style type="text/css">
    @import url(css/css.css);
  </style>
</head>
<body> <div id="legende"> 

<div class='normal'>Normal</div><br/>
<div class='anomalie'>A verifier</div><br/>
<div class='wrapup'>Sans Lot</div><hr/>

<div class='s1 carre'>OP</div><br/>
<div class='s0 carre'>CADRE</div><br/>



</div>
<div class="titrei">AMPARIBE - REZ DU JARDIN</div>
<div id="afficheur"><img src="img/cl.png" style="float: right; margin-right: 5px;clear: none; position: relative;" onclick="document.getElementById('afficheur').style.display = 'none' ;"><div id="info_details"></div></div>   <center><h1 class='titre'><a href="visu.php">ARO | </a><a href="ARO1.php">ARO 1 | </a><a href="ARO2.php">ARO 2 | </a><a href="AlmerysAmparibe_visu.php">AMPARIBE | </a><a href="Amparibe-sou-sol_visu.php">RDJ </a></h1>
<div data-ng-controller="simpleController">      
<table class='plan_site'>
<tr class='range'><td class='wall_'></td><td class='wall_'></td><td class='wall_'></td><td class='wall_'><td class='wall_'><td class='wall_'></td><td class='wall_'></td><td class='wall_'></td><td class='wall_'><td class='wall_'></td><td class='wall_'></td><td class='wall_'><td class='wall_'></td><td class='wall_'></td></td><td class='wall_'></td><td class='wall_'></td><td class='wall_'></td><td class='wall_'></td><td class='wall_'></td></tr>
<tr class='range'><td class='wall_'></td><td class='allee'></td><td class='allee'></td><td class='allee'><td class='allee'><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'><td class='allee'></td><td class='allee'></td><td class='allee'><td class='allee'></td><td class='allee'></td></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='wall_'></td></tr>
<tr class='range'><td class='wall_'></td><td class='allee'></td><td class='allee'></td><td class='table' id='347'><?php echo $c->echoS('s347s'); ?></td><td class='allee'><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='table' id='348'><td class='allee'></td><td class='allee'></td><td class='table' id='349'><?php echo $c->echoS('s349'); ?></td><td class='table' id='350'><?php echo $c->echoS('s350s'); ?></td><td class='allee'></td><td class='allee'></td><td class='table' id='351'><?php echo $c->echoS('s351s'); ?></td><td class='table' id='352'><?php echo $c->echoS('s352s'); ?></td><td class='allee'></td><td class='wall_'></td></tr>
<tr class='range'><td class='wall_'></td><td class='allee'></td><td class='table' id='353'><?php echo $c->echoS('s353s'); ?></td><td class='allee'><td class='allee'><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'><td class='allee'></td><td class='allee'></td><td class='table' id='354'><?php echo $c->echoS('s354s'); ?></td><td class='table' id='355'><?php echo $c->echoS('s355s'); ?></td><td class='allee'></td><td class='allee'></td><td class='table' id='356'><?php echo $c->echoS('s356s'); ?></td><td class='table' id='357'><?php echo $c->echoS('s357s'); ?></td><td class='allee'></td><td class='wall_'></td></tr>
<tr class='range'><td class='wall_'></td><td class='allee'></td><td class='table' id='358'><?php echo $c->echoS('s358s'); ?></td><td class='allee'><td class='allee'><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'><td class='allee'></td><td class='allee'></td><td class='table' id='359'><?php echo $c->echoS('s359s'); ?></td><td class='table' id='360'><?php echo $c->echoS('s360s'); ?></td><td class='allee'></td><td class='allee'></td><td class='table' id='361'><?php echo $c->echoS('s361s'); ?></td><td class='table' id='362'><?php echo $c->echoS('s362s'); ?></td><td class='allee'></td><td class='wall_'></td></tr>
<tr class='range'><td class='wall_'></td><td class='allee'></td><td class='allee'></td><td class='table' id='363'><?php echo $c->echoS('s363s'); ?></td><td class='allee'><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'><td class='allee'></td><td class='allee'></td><td class='allee'><td class='allee'></td><td class='allee'></td></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='wall_'></td></tr>
<tr class='range'><td class='wall_'></td><td class='allee'></td><td class='allee'></td><td class='allee'><td class='allee'><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'><td class='allee'></td><td class='allee'></td><td class='allee'><td class='allee'></td><td class='allee'></td></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='wall_'></td></tr>
<tr class='range'><td class='wall_'></td><td class='wall_'></td><td class='wall_'></td><td class='wall_'><td class='wall_'><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'><td class='allee'></td><td class='allee'></td><td class='allee'><td class='allee'></td><td class='allee'></td></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td></tr>
<tr class='range'><td class='wall_'></td><td class='allee'></td><td class='allee'></td><td class='allee'><td class='wall_'><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'><td class='allee'></td><td class='allee'></td><td class='allee'><td class='allee'></td><td class='allee'></td></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td></tr>
<tr class='range'><td class='wall_'></td><td class='allee'></td><td class='allee'></td><td class='allee'><td class='wall_'><td class='allee'></td><td class='table' id='364'><?php echo $c->echoS('s364s'); ?></td><td class='table' id='365'><?php echo $c->echoS('s365s'); ?></td><td class='table' id='366'><?php echo $c->echoS('s366s'); ?><td class='allee'></td><td class='table' id='367'><?php echo $c->echoS('s367s'); ?></td><td class='table' id='368'><?php echo $c->echoS('s368s'); ?></td><td class='table' id='369'><?php echo $c->echoS('s369s'); ?></td><td class='allee'></td><td class='wall_'></td><td class='wall_'></td><td class='wall_'></td><td class='wall_'></td><td class='wall_'></td></tr>
<tr class='range'><td class='wall_'></td><td class='allee'></td><td class='allee'></td><td class='allee'><td class='wall_'><td class='allee'></td><td class='table' id='370'><?php echo $c->echoS('s370s'); ?></td><td class='table' id='371'><?php echo $c->echoS('s371s'); ?></td><td class='table' id='372'><?php echo $c->echoS('s372s'); ?><td class='allee'></td><td class='table' id='373'><?php echo $c->echoS('s373s'); ?></td><td class='table' id='374'><?php echo $c->echoS('s374s'); ?></td><td class='table' id='375'><?php echo $c->echoS('s375s'); ?></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='wall_'></td></tr>
<tr class='range'><td class='wall_'></td><td class='allee'></td><td class='allee'></td><td class='allee'><td class='wall_'><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'><td class='allee'></td><td class='allee'></td><td class='allee'><td class='allee'></td><td class='allee'></td></td><td class='wall_'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='wall_'></td></tr>
<tr class='range'><td class='wall_'></td><td class='allee'></td><td class='allee'></td><td class='allee'><td class='wall_'><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'><td class='allee'></td><td class='allee'></td><td class='allee'><td class='allee'></td><td class='allee'></td></td><td class='wall_'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='wall_'></td></tr>
<tr class='range'><td class='wall_'></td><td class='allee'></td><td class='allee'></td><td class='allee'><td class='wall_'><td class='allee'></td><td class='table' id='416'><?php echo $c->echoS('s416s'); ?></td><td class='table' id='417'><?php echo $c->echoS('s417s'); ?></td><td class='table' id='418'><?php echo $c->echoS('s418s'); ?></td><td class='allee'></td><td class='table' id='376'><?php echo $c->echoS('s376s'); ?></td><td class='table' id='377'><?php echo $c->echoS('s377s'); ?></td><td class='table' id='378'><?php echo $c->echoS('s378s'); ?></td><td class='allee'></td><td class='wall_'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='wall_'></td></tr>
<tr class='range'><td class='wall_'></td><td class='allee'></td><td class='allee'></td><td class='allee'><td class='wall_'><td class='allee'></td><td class='table' id='379'><?php echo $c->echoS('s379s'); ?></td><td class='table' id='380'><?php echo $c->echoS('s380s'); ?></td><td class='table' id='381'><?php echo $c->echoS('s381s'); ?></td><td class='allee'></td><td class='table' id='382'><?php echo $c->echoS('s382s'); ?></td><td class='table' id='383'><?php echo $c->echoS('s383s'); ?></td><td class='table' id='384'><?php echo $c->echoS('s384s'); ?></td><td class='allee'></td><td class='wall_'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='wall_'></td></tr>
<tr class='range'><td class='wall_'></td><td class='allee'></td><td class='allee'></td><td class='allee'><td class='wall_'><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'><td class='allee'></td><td class='allee'></td><td class='allee'><td class='allee'></td><td class='allee'></td></td><td class='wall_'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='wall_'></td></tr>
<tr class='range'><td class='wall_'></td><td class='wall_'></td><td class='wall_'></td><td class='wall_'><td class='wall_'><td class='wall_'></td><td class='wall_'></td><td class='wall_'></td><td class='wall_'><td class='wall_'></td><td class='wall_'></td><td class='wall_'><td class='wall_'></td><td class='wall_'></td></td><td class='wall_'></td><td class='wall_'></td><td class='wall_'></td><td class='wall_'></td><td class='wall_'></td></tr>
</table>   
</center> 

</div>
<script type="text/javascript">

var app = angular.module('LoadMap', []);

app.controller('simpleController', function($scope, $http) {
	getTask(); // Load all available tasks 
var timer = setInterval(function getTask(){  
	$http.post("getTask.php").success(function(data){
		$scope.gpao = data;
	   });
	}, 60000);  
	
	function getTask(){  
	$http.post("getTask.php").success(function(data){
		$scope.gpao = data;
	   });
	};
	
  });
</script>

</body>
</html>

