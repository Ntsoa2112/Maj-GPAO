<?php

	include_once('php/common.php');	
	$c = new Cnx();
	

		$arr = array();
		$sqlDoss = "SELECT p_dossier.id_dossier, p_dossier.num_dossier, p_dossier.atelier, p_dossier.corresp, p_dossier.demarrage, p_dossier.delai, p_dossier.date_livr, p_dossier.vitesse_estime, p_dossier.vitesse_reelle, p_dossier.volume_prevue, p_dossier.resource_op, p_dossier.resource_cp, p_dossier.id_pers_cp, p_dossier.id_equipe, p_dossier.id_cl, p_client.nom as client,p_etat.libelle as etat,  p_dossier.id_etat, p_dossier.id_atelier FROM p_dossier
		LEFT JOIN p_client ON  p_dossier.id_cl = p_client.id_cl
        LEFT JOIN p_etat ON p_dossier.id_etat= p_etat.id_etat
		order by num_dossier";
		 
		$rsDoss=$c->cnx->query($sqlDoss);
		$ii=0;
		while($arrDoss = $rsDoss->fetch())
		{
			if ($ii == 3) $ii = 0;
			$arr[] = array("client"=>$arrDoss['client'], "etat"=>$arrDoss['etat'], "class"=>"classe$ii","id_dossier"=>$arrDoss['id_dossier'],"num_dossier"=>$arrDoss['num_dossier'],"atelier"=>$arrDoss['atelier'],"corresp"=>$arrDoss['corresp'],"demarrage"=>$arrDoss['demarrage'],"delai"=>$arrDoss['delai'],"date_livr"=>$arrDoss['date_livr'],"vitesse_estime"=>$arrDoss['vitesse_estime'],"vitesse_reelle"=>$arrDoss['vitesse_reelle'],"volume_prevue"=>$arrDoss['volume_prevue'],"resource_op"=>$arrDoss['resource_op'],"resource_cp"=>$arrDoss['resource_cp'],"id_pers_cp"=>$arrDoss['id_pers_cp'],"id_equipe"=>$arrDoss['id_equipe'],"id_cl"=>$arrDoss['id_cl'],"id_etat"=>$arrDoss['id_etat'],"id_atelier"=>$arrDoss['id_atelier']);
			$ii++;
		}
		echo $json_response = json_encode($arr);
		
	
	
?>