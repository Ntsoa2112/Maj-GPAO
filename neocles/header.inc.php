<?php
	session_start();
	$path = $_SERVER['PHP_SELF']; // $path = /home/httpd/html/index.php
	$file = basename ($path);
	//echo"$file";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"  xml:lang="en" lang="en">
	<head>
		<title>Easytech.mg</title>
		<meta http-equiv="Content-Type" content="text/html; Charset=utf-8" />
		<meta name="easytech" content="easytech" />
		<meta content="" name="Keywords" />
		

		<?php if($file=='ri.php') : ?>
		<style type="text/css">@import url(css/ri.css);</style>
		<?php elseif($file=='almerys.cq.php' || $file=='Almerys.user.php' || $file=='Dossier.php' || $file=='plan.php')   : ?>
		<style type="text/css">@import url(css/almerys.cq.css);</style>
		<style type="text/css">@import url(css/bootstrap.min.css);</style>
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
			<script src="js/jquery.min.js" ></script>
		<?php endif; ?>

		<script type="text/javascript" src="js/dom-drag.js"></script>
		<script type="text/javascript" src="js/func.js" ></script>
		<link rel="stylesheet" href="css/style.css" type="text/css" media="screen" />    	
	</head>
	<body>