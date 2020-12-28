<?php
$con = mysqli_connect(AB_DB_HOST,AB_DB_USER,AB_DB_PWD,AB_DB_DATABASE);
// Check connection
if (mysqli_connect_errno())
{
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
}