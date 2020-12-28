<?php

	include_once('php/common.php');	
	$c = new Cnx();
	

		$arr = array();
		$sqlDoss = "SELECT almerys_user.id, almerys_user.matricule, almerys_user.sat, almerys_user.id_pole, almerys_user.id_cq, p_lot_client.libelle from almerys_user
		Left join p_lot_client ON p_lot_client.id_lotclient = almerys_user.id_pole		order by sat";
		 
		$rsDoss=$c->cnx->query($sqlDoss);
		$ii=0;
		while($arrDoss = $rsDoss->fetch())
		{
			if ($ii == 3) $ii = 0;
			$arr[] = array("showCq"=>false,"showPole"=>false,"class"=>"classe$ii","id"=>$arrDoss['id'],"matricule"=>$arrDoss['matricule'], "sat"=>$arrDoss['sat'], "id_cq"=>$arrDoss['id_cq'], "pole"=>$arrDoss['libelle'], "id_pole"=>$arrDoss['id_pole']);
			$ii++;
		}
		echo $json_response = json_encode($arr);
?>