<?php
session_start();
include_once('php/common.php');
$c = new Cnx();
$url="index.php";
if($c->Deconnect())
{	
	session_destroy();	
}
header("location:$url");
?>
