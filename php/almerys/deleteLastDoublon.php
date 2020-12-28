<?php

	include_once('dbConn.php');	
	
	if(isset($_POST['sat']))
	{	
		$stat = DBConn::getInstance()->query('SELECT id, date FROM almerys_tri_comptage WHERE sat = \''.$_POST['sat'].'\' and cast(almerys_tri_comptage.date as date) = cast(\''.date("Y-m-d").'\' as date) ORDER by id DESC limit 1');
		
		if($stat->rowCount() > 0)
		{
			$result = $stat->fetch();
			
			DBConn::getInstance()->query('DELETE FROM almerys_tri_comptage WHERE id <> '.$result[0].' and sat = \''.$_POST['sat'].'\' and abs(extract(epoch from age(almerys_tri_comptage.date, cast(\''.$result[1].'\' as timestamp)))) <= 5');
			
		}			
    }

?>