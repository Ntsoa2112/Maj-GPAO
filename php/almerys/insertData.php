<?php

	include_once('dbConn.php');	
	
	if(isset($_POST['sat']) && isset($_POST['panier']) && isset($_POST['nbImg']))
	{	
		recurseDelete($_POST['sat'], date("Y-m-d"), 0);

		DBConn::getInstance()->query('INSERT INTO almerys_tri_comptage (sat, panier, nb_img, date) VALUES (\''.$_POST['sat'].'\','.$_POST['panier'].','.$_POST['nbImg'].', cast(\''.date("Y-m-d H:i:s").'\' as timestamp))');
    }
	
	function recurseDelete($sat, $date, $ignore)
	{
		$stat = DBConn::getInstance()->query('SELECT id, date FROM almerys_tri_comptage WHERE id > '.$ignore.' and sat = \''.$sat.'\' and cast(almerys_tri_comptage.date as date) = cast(\''.$date.'\' as date) ORDER by id limit 1');
		
		if($stat->rowCount() > 0)
		{
			$result = $stat->fetch();
			
			DBConn::getInstance()->query('DELETE FROM almerys_tri_comptage WHERE id <> '.$result[0].' and sat = \''.$sat.'\' and abs(extract(epoch from age(almerys_tri_comptage.date, cast(\''.$result[1].'\' as timestamp)))) <= 5');
			
			recurseDelete($sat, $date, $result[0]);
		}
	}

?>