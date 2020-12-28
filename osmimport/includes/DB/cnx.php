<?php
//$con = mysqli_connect(AB_DB_HOST,AB_DB_USER,AB_DB_PWD,AB_DB_DATABASE);
$db_connection = pg_connect("host=".AB_DB_HOST." dbname=".AB_DB_DATABASE." user=".AB_DB_USER." password=".AB_DB_PWD);

// Check connection
/*if (mysqli_connect_errno())
{
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
}*/