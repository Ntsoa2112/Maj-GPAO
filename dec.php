<?php
session_start();
$url="index.php";
session_destroy();
header("location:$url");
?>
