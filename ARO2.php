<?php

	include_once('php/common.php');	
	 $c = new Cnx();

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
<body>  <div id="legende"> 

<div class='normal'>Normal</div><br/>
<div class='anomalie'>A verifier</div><br/>
<div class='wrapup'>Sans Lot</div><hr/>

<div class='s1 carre'>OP</div><br/>
<div class='s0 carre'>CADRE</div><br/>
</div>

<div class="titrei">ARO AILE GAUCHE</div>

<div id="afficheur"><img src="img/cl.png" style="float: right; margin-right: 5px;clear: none; position: relative;" onclick="document.getElementById('afficheur').style.display = 'none' ;"><div id="info_details"></div></div>   <center><h1 class='titre'><a href="visu.php">ARO | </a><a href="ARO1.php">ARO 1 | </a><a href="ARO2.php">ARO 2 | </a><a href="AlmerysAmparibe_visu.php">AMPARIBE | </a><a href="Amparibe-sou-sol_visu.php">RDJ </a></h1>
<div data-ng-controller="simpleController">      
<table class='plan_site'>

<tr class='range'><td class='wall_'></td><td class='wall_'></td><td class='wall_'></td><td class='wall_'></td><td class='wall_'></td><td class='wall_'></td><td class='wall_'></td><td class='wall_'></td><td class='wall_'></td><td class='wall_'></td><td class='wall_'></td><td class='wall_'></td><td class='wall_'></td><td class='wall_'></td><td class='wall_'></td><td class='wall_'></td><td class='wall_'></td><td class='wall_'></td><td class='wall_'></td><td class='wall_'></td><td class='wall_'></td><td class='wall_'></td><td class='wall_'></td><td class='wall_'></td><td class='wall_'></td><td class='wall_'></td><td class='wall_'></td><td class='wall_'></td><td class='wall_'></td><td class='wall_'></td><td class='wall_'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='wall_'></td><td class='wall_'></td><td class='wall_'></td><td class='wall_'></td><td class='wall_'></td><td class='wall_'></td><td class='wall_'></td><td class='wall_'></td><td class='wall_'></td><td class='wall_'></td><td class='wall_'></td><td class='wall_'></td><td class='wall_'></td></tr>
<tr class='range'><td class='wall_'></td><td class='wall_'></td><td class='wall_'></td><td class='wall_'></td><td class='wall_'></td><td class='wall_'></td><td class='wall_'></td><td class='wall_'></td><td class='wall_'></td><td class='wall_'></td><td class='wall_'></td><td class='wall_'></td><td class='wall_'></td><td class='wall_'></td><td class='wall_'></td><td class='wall_'></td><td class='wall_'></td><td class='wall_'></td><td class='wall_'></td><td class='wall_'></td><td class='wall_'></td><td class='wall_'></td><td class='wall_'></td><td class='wall_'></td><td class='wall_'></td><td class='wall_'></td><td class='wall_'></td><td class='wall_'></td><td class='wall_'></td><td class='wall_'></td><td class='wall_'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='wall_'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='wall_'></td></tr>

	
<tr class='range'><td class='wall_'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='table' id='247'><?php echo $c->echoS('s247s'); ?></td><td class='table' id='110'><?php echo $c->echoS('s110s'); ?></td><td class='allee'></td><td class='table' id='185'><?php echo $c->echoS('s185s'); ?></td><td class='table' id='419'><?php echo $c->echoS('s419s'); ?></td><td class='allee'></td><td class='wall_'></td><td class='allee'></td><td class='allee'></td><td class='table' id='111'><?php echo $c->echoS('s111s'); ?></td><td class='allee'></td><td class='allee'></td><td class='table' id='112'><?php echo $c->echoS('s112s'); ?></td><td class='table' id='113'><?php echo $c->echoS('s113s'); ?></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='table' id='114'><?php echo $c->echoS('s114s'); ?></td><td class='table' id='115'><?php echo $c->echoS('s115s'); ?></td><td class='allee'></td><td class='allee'></td><td class='table' id='116'><?php echo $c->echoS('s116s'); ?></td><td class='table' id='117'><?php echo $c->echoS('s117s'); ?></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='wall_'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='wall_'></td></tr>
<tr class='range'><td class='wall_'></td><td class='allee'></td><td class='allee'></td><td class='table' id='118'><?php echo $c->echoS('s118s'); ?></td><td class='allee'></td><td class='table' id='245'><?php echo $c->echoS('s245s'); ?></td><td class='table' id='119'><?php echo $c->echoS('s119s'); ?></td><td class='allee'></td><td class='table'></td><td class='table' id='421'><?php echo $c->echoS('s421s'); ?></td><td class='allee'></td><td class='wall_'></td><td class='allee'></td><td class='allee'></td><td class='table' id='120'><?php echo $c->echoS('s120s'); ?></td><td class='allee'></td><td class='allee'></td><td class='table' id='121'><?php echo $c->echoS('s121s'); ?></td><td class='table' id='122'><?php echo $c->echoS('s122s'); ?></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='table' id='123'><?php echo $c->echoS('s123s'); ?></td><td class='table' id='124'><?php echo $c->echoS('s124s'); ?></td><td class='allee'></td><td class='allee'></td><td class='table' id='125'><?php echo $c->echoS('s125s'); ?></td><td class='table' id='126'><?php echo $c->echoS('s126s'); ?></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='wall_'></td><td class='wall_'></td><td class='wall_'></td><td class='wall_'></td><td class='wall_'></td><td class='wall_'></td><td class='wall_'></td><td class='wall_'></td><td class='wall_'></td><td class='wall_'></td><td class='wall_'></td><td class='wall_'></td><td class='wall_'></td></tr>
<tr class='range'><td class='wall_'></td><td class='allee'></td><td class='allee'></td><td class='table' id='127'><?php echo $c->echoS('s127s'); ?></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='wall_'></td><td class='allee'></td><td class='allee'></td><td class='table' id='129'><?php echo $c->echoS('s129s'); ?></td><td class='allee'></td><td class='allee'></td><td class='table' id='130'><?php echo $c->echoS('s130s'); ?></td><td class='table' id='131'><?php echo $c->echoS('s131s'); ?></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='table' id='132'><?php echo $c->echoS('s132s'); ?></td><td class='table' id='133'><?php echo $c->echoS('s133s'); ?></td><td class='allee'></td><td class='allee'></td><td class='table' id='134'><?php echo $c->echoS('s134s'); ?></td><td class='table' id='135'><?php echo $c->echoS('s135s'); ?></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td></tr>


<tr class='range'><td class='wall_'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='table' id='136'><?php echo $c->echoS('s136s'); ?></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td></tr>
<tr class='range'><td class='wall_'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='table' id='422'><?php echo $c->echoS('s422s'); ?></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='wall_'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='wall_'></td><td class='wall_'></td><td class='wall_'></td><td class='wall_'></td><td class='wall_'></td><td class='wall_'></td><td class='wall_'></td><td class='wall_'></td><td class='wall_'></td><td class='wall_'></td><td class='allee'></td><td class='allee'></td><td class='wall_'></td></tr>   
<tr class='range'><td class='wall_'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='wall_'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee' id='136'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='wall_'></td></tr>

<tr class='range'><td class='wall_'></td><td class='allee'></td><td class='allee'></td><td class='table' id='137'><?php echo $c->echoS('s137s'); ?></td><td class='table' id='138'><?php echo $c->echoS('s138s'); ?></td><td class='allee'></td><td class='allee'></td><td class='table' id='139'><?php echo $c->echoS('s139s'); ?></td><td class='table' id='140'><?php echo $c->echoS('s140s'); ?></td><td class='allee'></td><td class='allee'></td><td class='wall_'></td><td class='allee'></td><td class='allee'></td><td class='table' id='141'><?php echo $c->echoS('s141s'); ?></td><td class='allee'></td><td class='allee'></td><td class='table' id='142'><?php echo $c->echoS('s142s'); ?></td><td class='table' id='143'><?php echo $c->echoS('s143s'); ?></td><td class='allee'></td><td class='allee'></td><td class='table' id='144'><?php echo $c->echoS('s144s'); ?></td><td class='table' id='145'><?php echo $c->echoS('s145s'); ?></td><td class='allee'></td><td class='allee'></td><td class='table' id='146'><?php echo $c->echoS('s146s'); ?></td><td class='table' id='147'><?php echo $c->echoS('s147s'); ?></td><td class='allee'></td><td class='allee'></td><td class='table' id='148'><?php echo $c->echoS('s148s'); ?></td><td class='table' id='149'><?php echo $c->echoS('s149s'); ?></td><td class='allee'></td><td class='allee'></td><td class='table' id='150'><?php echo $c->echoS('s150s'); ?></td><td class='table' id='151'><?php echo $c->echoS('s151s'); ?></td><td class='allee'></td><td class='wall_'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='wall_'></td></tr>
<tr class='range'><td class='wall_'></td><td class='allee'></td><td class='allee'></td><td class='table' id='152'><?php echo $c->echoS('s152s'); ?></td><td class='table' id='153'><?php echo $c->echoS('s153s'); ?></td><td class='allee'></td><td class='allee'></td><td class='table' id='154'><?php echo $c->echoS('s154s'); ?></td><td class='table' id='155'><?php echo $c->echoS('s155s'); ?></td><td class='allee'></td><td class='allee'></td><td class='wall_'></td><td class='allee'></td><td class='allee'></td><td class='table' id='156'><?php echo $c->echoS('s156s'); ?></td><td class='allee'></td><td class='allee'></td><td class='table' id='157'><?php echo $c->echoS('s157s'); ?></td><td class='table' id='158'><?php echo $c->echoS('s158s'); ?></td><td class='allee'></td><td class='allee'></td><td class='table' id='159'><?php echo $c->echoS('s159s'); ?></td><td class='table' id='160'><?php echo $c->echoS('s160s'); ?></td><td class='allee'></td><td class='allee'></td><td class='table' id='161'><?php echo $c->echoS('s161s'); ?></td><td class='table' id='162'><?php echo $c->echoS('s162s'); ?></td><td class='allee'></td><td class='allee'></td><td class='table' id='163'><?php echo $c->echoS('s163s'); ?></td><td class='table' id='164'><?php echo $c->echoS('s164s'); ?></td><td class='allee'></td><td class='allee'></td><td class='table' id='165'><?php echo $c->echoS('s165s'); ?></td><td class='table' id='166'><?php echo $c->echoS('s166s'); ?></td><td class='allee'></td><td class='wall_'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='wall_'></td></tr>
<tr class='range'><td class='wall_'></td><td class='allee'></td><td class='allee'></td><td class='table' id='167'><?php echo $c->echoS('s167s'); ?></td><td class='table' id='168'><?php echo $c->echoS('s168s'); ?></td><td class='allee'></td><td class='allee'></td><td class='table' id='169'><?php echo $c->echoS('s169s'); ?></td><td class='table' id='170'><?php echo $c->echoS('s170s'); ?></td><td class='allee'></td><td class='allee'></td><td class='wall_'></td><td class='allee'></td><td class='allee'></td><td class='table' id='171'><?php echo $c->echoS('s171s'); ?></td><td class='allee'></td><td class='allee'></td><td class='table' id='172'><?php echo $c->echoS('s172s'); ?></td><td class='table' id='173'><?php echo $c->echoS('s173s'); ?></td><td class='allee'></td><td class='allee'></td><td class='table' id='174'><?php echo $c->echoS('s174s'); ?></td><td class='table' id='175'><?php echo $c->echoS('s175s'); ?></td><td class='allee'></td><td class='allee'></td><td class='table' id='176'><?php echo $c->echoS('s176s'); ?></td><td class='table' id='177'><?php echo $c->echoS('s177s'); ?></td><td class='allee'></td><td class='allee'></td><td class='table' id='178'><?php echo $c->echoS('s178s'); ?></td><td class='table' id='179'><?php echo $c->echoS('s179s'); ?></td><td class='allee'></td><td class='allee'></td><td class='table' id='180'><?php echo $c->echoS('s180s'); ?></td><td class='table' id='181'><?php echo $c->echoS('s181s'); ?></td><td class='allee'></td><td class='wall_'></td><td class='allee'></td><td class='table' id='182'><?php echo $c->echoS('s182s'); ?></td><td class='table' id='183'><?php echo $c->echoS('s183s'); ?></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='table' id='184'><?php echo $c->echoS('s184s'); ?></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='wall_'></td></tr>     
<tr class='range'><td class='wall_'></td><td class='allee'></td><td class='allee'></td><td class='table' id='420'><?php echo $c->echoS('s420s'); ?></td><td class='table' id='186'><?php echo $c->echoS('s186s'); ?></td><td class='allee'></td><td class='allee'></td><td class='table' id='187'><?php echo $c->echoS('s187s'); ?></td><td class='table' id='188'><?php echo $c->echoS('s188s'); ?></td><td class='allee'></td><td class='allee'></td><td class='wall_'></td><td class='allee'></td><td class='allee'></td><td class='table' id='189'><?php echo $c->echoS('s189s'); ?></td><td class='allee'></td><td class='allee'></td><td class='table' id='190'><?php echo $c->echoS('s190s'); ?></td><td class='table' id='191'><?php echo $c->echoS('s191s'); ?></td><td class='allee'></td><td class='allee'></td><td class='table' id='192'><?php echo $c->echoS('s192s'); ?></td><td class='table' id='193'><?php echo $c->echoS('s193s'); ?></td><td class='allee'></td><td class='allee'></td><td class='table' id='194'><?php echo $c->echoS('s194s'); ?></td><td class='table' id='195'><?php echo $c->echoS('s195s'); ?></td><td class='allee'></td><td class='allee'></td><td class='table' id='196'><?php echo $c->echoS('s196s'); ?></td><td class='table' id='197'><?php echo $c->echoS('s197s'); ?></td><td class='allee'></td><td class='allee'></td><td class='table' id='198'><?php echo $c->echoS('s198s'); ?></td><td class='table' id='199'><?php echo $c->echoS('s199s'); ?></td><td class='allee'></td><td class='wall_'></td><td class='allee'></td><td class='table' id='200'><?php echo $c->echoS('s200s'); ?></td><td class='table' id='201'><?php echo $c->echoS('s201s'); ?></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='table' id='202'><?php echo $c->echoS('s202s'); ?></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='wall_'></td></tr>     
<tr class='range'><td class='wall_'></td><td class='allee'></td><td class='allee'></td><td class='table' id='203'><?php echo $c->echoS('s203s'); ?></td><td class='table' id='204'><?php echo $c->echoS('s204s'); ?></td><td class='allee'></td><td class='allee'></td><td class='table' id='205'><?php echo $c->echoS('s205s'); ?></td><td class='table' id='206'><?php echo $c->echoS('s206s'); ?></td><td class='allee'></td><td class='allee'></td><td class='wall_'></td><td class='allee'></td><td class='allee'></td><td class='table' id='207'><?php echo $c->echoS('s207s'); ?></td><td class='allee'></td><td class='allee'></td><td class='table' id='208'><?php echo $c->echoS('s208s'); ?></td><td class='table' id='209'><?php echo $c->echoS('s209s'); ?></td><td class='allee'></td><td class='allee'></td><td class='table' id='210'><?php echo $c->echoS('s210s'); ?></td><td class='table' id='211'><?php echo $c->echoS('s211s'); ?></td><td class='allee'></td><td class='allee'></td><td class='table' id='212'><?php echo $c->echoS('s212s'); ?></td><td class='table' id='213'><?php echo $c->echoS('s213s'); ?></td><td class='allee'></td><td class='allee'></td><td class='table' id='214'><?php echo $c->echoS('s214s'); ?></td><td class='table' id='215'><?php echo $c->echoS('s215s'); ?></td><td class='allee'></td><td class='allee'></td><td class='table' id='216'><?php echo $c->echoS('s216s'); ?></td><td class='table' id='217'><?php echo $c->echoS('s217s'); ?></td><td class='allee'></td><td class='wall_'></td><td class='allee'></td><td class='table' id='218'><?php echo $c->echoS('s218s'); ?></td><td class='table' id='219'><?php echo $c->echoS('s219s'); ?></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='table' id='220'><?php echo $c->echoS('s220s'); ?></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='wall_'></td></tr>     

<tr class='range'><td class='wall_'></td><td class='allee'> </td><td class='allee'> </td><td class='allee'></td><td class='allee' id='402'></td><td class='allee'> </td><td class='allee'> </td><td class='allee' id='403'></td><td class='allee' id='404'></td><td class='allee'> </td><td class='allee'> </td><td class='wall_'></td><td class='allee'> </td><td class='allee'> </td><td class='table' id='405'><?php echo $c->echoS('s405s'); ?></td><td class='allee'> </td><td class='allee'> </td><td class='table' id='406'><?php echo $c->echoS('s406s'); ?></td><td class='table' id='407'><?php echo $c->echoS('s407s'); ?></td><td class='allee'> </td><td class='allee'> </td><td class='table' id='408'><?php echo $c->echoS('s408s'); ?></td><td class='table' id='409'><?php echo $c->echoS('s409s'); ?></td><td class='allee'> </td><td class='allee'> </td><td class='table' id='410'><?php echo $c->echoS('s410s'); ?></td><td class='table' id='411'><?php echo $c->echoS('s411s'); ?></td><td class='allee'> </td><td class='allee'> </td><td class='table' id='412'><?php echo $c->echoS('s412s'); ?></td><td class='table' id='413'><?php echo $c->echoS('s413s'); ?></td><td class='allee'> </td><td class='allee'> </td><td class='table' id='414'><?php echo $c->echoS('s414s'); ?></td><td class='table' id='415'><?php echo $c->echoS('s415s'); ?></td><td class='allee'> </td><td class='wall_'></td><td class='allee'> </td><td class='table' id='416'><?php echo $c->echoS('s416s'); ?></td><td class='table' id='417'><?php echo $c->echoS('s417s'); ?></td><td class='allee'> </td><td class='allee'> </td><td class='allee'> </td><td class='table' id='418'><?php echo $c->echoS('s418s'); ?></td><td class='allee'> </td><td class='allee'> </td><td class='allee'> </td><td class='allee'> </td><td class='wall_'></td></tr>     

<tr class='range'><td class='wall_'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='wall_'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='wall_'></td><td class='allee'></td><td class='table' id='221'><?php echo $c->echoS('s221s'); ?></td><td class='table' id='222'><?php echo $c->echoS('s222s'); ?></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='table' id='223'><?php echo $c->echoS('s223s'); ?></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='allee'></td><td class='wall_'></td></tr>     
<tr class='range'><td class='wall_'></td><td class='wall_'></td><td class='wall_'></td><td class='wall_'></td><td class='wall_'></td><td class='wall_'></td><td class='wall_'></td><td class='wall_'></td><td class='wall_'></td><td class='wall_'></td><td class='wall_'></td><td class='wall_'></td><td class='wall_'></td><td class='wall_'></td><td class='wall_'></td><td class='wall_'></td><td class='wall_'></td><td class='wall_'></td><td class='wall_'></td><td class='wall_'></td><td class='wall_'></td><td class='wall_'></td><td class='wall_'></td><td class='wall_'></td><td class='wall_'></td><td class='wall_'></td><td class='wall_'></td><td class='wall_'></td><td class='wall_'></td><td class='wall_'></td><td class='wall_'></td><td class='wall_'></td><td class='wall_'></td><td class='wall_'></td><td class='wall_'></td><td class='wall_'></td><td class='wall_'></td><td class='wall_'></td><td class='wall_'></td><td class='wall_'></td><td class='wall_'></td><td class='wall_'></td><td class='wall_'></td><td class='wall_'></td><td class='wall_'></td><td class='wall_'></td><td class='wall_'></td><td class='wall_'></td><td class='wall_'></td></tr>

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