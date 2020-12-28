<?php
	session_start();
	$path = $_SERVER['PHP_SELF']; // $path = /home/httpd/html/index.php
	$file = basename ($path);
	//echo"$file";
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml"  xml:lang="en" lang="en">
	<head>
		<title>Easytech.mg</title>
		<meta http-equiv="Content-Type" content="text/html; Charset=utf-8" />
		<meta name="easytech" content="easytech" />
		<meta content="" name="Keywords" />
		
		<!-- RESPONSIVE -->
		<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
		
		<!-- BOOTSTRAP -->
		
        <link rel="stylesheet" href="css/hover-min.css" />
		<link rel="stylesheet" href="css/bootstrap.min.css" />
		<link rel="stylesheet" href="css/bootstrap-responsive.min.css" />
		<link rel="stylesheet" href="css/font-awesome-4.5.0/css/font-awesome.min.css" />
		
			<!-- new -->
		<link href="css/app.css" rel="stylesheet">
		<link href="css/fonts.css" rel="stylesheet">
		<link href="css/3-col-portfolio.css" rel="stylesheet">
		
		
		<!-- Start WOWSlider.com HEAD section -->
		<link rel="stylesheet" type="text/css" href="engine1/style.css" />
		<script type="text/javascript" src="engine1/jquery.js"></script>
		<!-- End WOWSlider.com HEAD section -->
		
		
		
			<!-- /new -->
		
		
		<script src="js/jquery.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
		
		<!-- /BOOTSTRAP -->
		 
		 
		 	<?php if($file=='ri.php') : ?>
		<style type="text/css">@import url(css/ri.css);</style>
		<?php elseif($file=='almerys.cq.php' || $file=='interial.cq.php' || $file=='Almerys.user.php' || $file=='Dossier.php' || $file=='nf.php' )   : ?>
		<style type="text/css">@import url(css/almerys.cq.css);</style>
		<script src="js/angular.min.js"></script>
		
		<link rel="stylesheet" href="demos.css" type="text/css" media="screen" />

    
		<script src="js/RGraph.common.core.js" ></script>
		<script src="js/RGraph.common.tooltips.js" ></script>
		<script src="js/RGraph.common.dynamic.js" ></script>
		<script src="js/RGraph.common.effects.js" ></script>
		<script src="js/RGraph.pie.js" ></script>
		
		  
	
		<?php else :?>	
		<style type="text/css">@import url(css/rami_css.css);</style>		
		<?php endif; ?>
		
		<?php if($file=='rapp.php') : ?>
			<link rel="stylesheet" href="css/rGraph.css" type="text/css" media="screen" />    
			<script src="js/RGraph.common.core.js" ></script>
			<script src="js/RGraph.common.dynamic.js" ></script>
			<script src="js/RGraph.common.tooltips.js" ></script>
			<script src="js/RGraph.common.effects.js" ></script>
			<script src="js/RGraph.line.js" ></script>
			<script src="js/RGraph.bar.js" ></script>
			<script src="js/jquery.js" ></script>
		<?php endif; ?>

		<script type="text/javascript" src="js/dom-drag.js"></script>
		<script type="text/javascript" src="js/func.js" ></script>
        <script type="text/javascript" src="js/dropzone.js" ></script>

        <link rel="stylesheet" href="css/download_form.css" />
		
	</head>
	<body>