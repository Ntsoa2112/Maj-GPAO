<?php
	session_start() ;
	
// AUT Mirah RATAHIRY
// DES lien ajax
// DAT 2012 03 06

	include_once '../php/common.php' ;
	$action = $_REQUEST['action'] ;
	$c = new Cnx();
	
	switch($action){

		case "md5":
			echo md5($_REQUEST['val']);
		break;
		case "goOP":
			$deb = $_REQUEST['deb'] ;
			$fin = $_REQUEST['fin'] ;
			$dossier = $_REQUEST['dossier'] ;
			$departement = $_REQUEST['departement'] ;
			
			$filtreDate = $deb;
			if ($fin != "") $filtreDate = $deb.','.$fin;
			$filtreDate = str_replace("/", "", $filtreDate);
			echo $c->suiviHeureOP($filtreDate, $dossier, $departement);
			
		break;
		case "GetStats":
			$idIntervenant = $_REQUEST['idIntervenant'] ;
			$idTicket = $_REQUEST['idTicket'] ;
			$jour = $_REQUEST['jour'] ;
			$sujet = $_REQUEST['sujet'] ;			
			$statut = $_REQUEST['statut'] ;	
			$dateFin = $_REQUEST['dateFin'] ;
			$dossier = $_REQUEST['dossier'] ;
			$beneficiaire = $_REQUEST['beneficiaire'] ;
			$demandeur = $_REQUEST['demandeur'] ;			
			$resolution_en_ligne = $_REQUEST['resolution_en_ligne'] ;	
			
			echo $c->GetStats($idIntervenant,$idTicket,$jour,$sujet,$statut,$dateFin,$dossier,$beneficiaire,$demandeur,$resolution_en_ligne,"");			
		break;
		
		case "GetNbTycketByActionType":
			$idIntervenant = $_REQUEST['idIntervenant'] ;
			$jour = $_REQUEST['jour'] ;
			echo $c->GetNbTycketByActionType($idIntervenant,$jour);
		break;
		case "updateCqLot":
			$qt = $_REQUEST['qt'] ;
			$err = $_REQUEST['err'] ;
			$stat = $_REQUEST['stat'] ;
			$id = $_REQUEST['id'] ;
			$lib = $_REQUEST['lib'] ;
			$ldg = $_REQUEST['ldg'] ;
			$doss = $_REQUEST['doss'] ;
			$id_pers = $_REQUEST['idpers'] ;
			$idNuo = $_REQUEST['idNuo'] ;
			$idPs = $_REQUEST['idPs'] ;
			$com = "";
			
			echo $c->UpdateCqLot($qt, $err, $stat, $id, $lib, $com, $ldg, $doss, $id_pers, $idNuo, $idPs);
		break;
		case "saveMac":
			$id = $_REQUEST['id'] ;
			
			echo $c->updateMac($id);
			
		break;
		case "getStatut":
			$ip = $_REQUEST['ip'] ;
			echo $c->getStatutIP($ip);
			
		break;
		case "getInfoIP":
		$ip = $_REQUEST['ip'] ;
		
			echo $c->getStatutIP($ip);
			
		break;
		case "pointage":
			$idpers = $_REQUEST['idpers'] ;
			$pt = $_REQUEST['pt'] ;
			$heurePt = $_REQUEST['heurePt'] ;
			echo $c->pointage($idpers, $pt, $heurePt);			
		break;
		
		case "goPeriod":
			$deb = $_REQUEST['deb'] ;
			$fin = $_REQUEST['fin'] ;
			
			$filtre = $deb;
			if ($fin != "") $filtre = $deb.','.$fin;
			$filtre = str_replace("/", "", $filtre);
			echo $c->suiviDossierPeriode($filtre);
			
		break;
		case "delLdt":
			$id = $_REQUEST['id'] ;
			echo $c->deleteLdt($id);
		break;
		case "getListConnected":
			$dep = $_REQUEST['dep'] ;
			$doss = $_REQUEST['doss'] ;
			echo $c->getListConnected($doss, $dep);
		break;
		case "deleteReport":
			$id = $_REQUEST['id'] ;
			echo $c->deleteReport($id);
		break;
		case "delLot":
			$id = $_REQUEST['id'] ;
			echo $c->deleteLot($id);
		break;
		case "delConsigne":
			$id = $_REQUEST['id'] ;
			echo $c->delConsigne($id);
		break;
		case "insertCons":
			$doss = $_REQUEST['doss'] ;
			$etape = $_REQUEST['etape'] ;
			$url = $_REQUEST['url'] ;
			echo $c->insertConsigne($doss, $etape, "$url");
		break;
		case "loadConsignes":
			$doss = $_REQUEST['doss'] ;
			$etape = $_REQUEST['etape'] ;
			echo $c->getLstConsigne($doss, $etape);
		break;
		case "noNullFinLdt":
			echo $c->noNullFinLdt();
			break;
		case "goEtape":
			$deb = $_REQUEST['deb'] ;
			$fin = $_REQUEST['fin'] ;
			$dossier = $_REQUEST['doss'] ;
			
			$filtre = $deb;
			if ($fin != "") $filtre = $deb.','.$fin;
			$filtre = str_replace("/", "", $filtre);
			echo $c->suiviDossierEtape($filtre, $dossier);
		break;
		case "getLdt":
			$id = $_REQUEST['id'] ;
			echo $c->getOneLdt($id);
		break;
		case "getIdLotAlmerys":
			$id = $_REQUEST['id'] ;
			echo $c->getIdLotAlmerys($id);
		break;
		case "nextLotDispo":
			$dossier = $_REQUEST['doss'] ;
			$etape = $_REQUEST['etape'] ;
			echo $c->nextLotDispo($dossier, $etape);
		break;
		case "getLstLdt":
			$deb = $_REQUEST['deb'] ;
			$fin = $_REQUEST['fin'] ;
			$dossier = $_REQUEST['doss'] ;
			$mat = $_REQUEST['mat'] ;
			$stat = $_REQUEST['stat'] ;
			$orderby = $_REQUEST['orderby'] ;
			$etape = $_REQUEST['etape'] ;
			
			$filtre = $deb;
			if ($fin != "") $filtre = $deb.','.$fin;
			$filtre = str_replace("/", "", $filtre);
			echo $c->getLdt($dossier, $etape, $filtre, $mat, $stat, $orderby);
		break;
		case "updateLdt":
			$dDeb = $_REQUEST['ddeb'] ;
			$dFin = $_REQUEST['dfin'] ;
			$deb = $_REQUEST['deb'] ;
			$fin = $_REQUEST['fin'] ;
			$qt = $_REQUEST['qt'] ;
			$err = $_REQUEST['err'] ;
			$stat = $_REQUEST['stat'] ;
			$id = $_REQUEST['id'] ;
			$com = $_REQUEST['com'] ;
			
			$filtre = $deb;
			if ($fin != "") $filtre = $deb.','.$fin;
			$filtre = str_replace("/", "", $filtre);
			echo $c->updateLdt($deb, $fin, $qt, $err, $stat, $id, $dDeb, $dFin, $com);
		break;
		case "getLstLot":
			$ldg = $_REQUEST['ldg'] ;
			$dossier = $_REQUEST['doss'] ;
			$mat = $_REQUEST['mat'] ;
			$stat = $_REQUEST['stat'] ;
			$etape = $_REQUEST['etape'] ;
			$prio = $_REQUEST['prio'] ;
			$name = $_REQUEST['name'] ;
			$orderby = $_REQUEST['ordre'] ;

			echo $c->getLot($dossier, $ldg, $mat, $stat, $etape, $prio, $name,$orderby);
		break;
		case "getLstLotAlmerys":
			$ldg = $_REQUEST['ldg'] ;
			$dossier = $_REQUEST['doss'] ;
			$mat = $_REQUEST['mat'] ;
			$stat = $_REQUEST['stat'] ;
			$etape = $_REQUEST['etape'] ;
			$prio = $_REQUEST['prio'] ;
			$name = $_REQUEST['name'] ;
			$orderby = $_REQUEST['ordre'] ;

			echo $c->getLotAlmerys($dossier, $ldg, $mat, $stat, $etape, $prio, $name,$orderby);
		break;
		
		case "updateLot":
			$lstId = $_REQUEST['lstId'] ;
			$etat = $_REQUEST['etat'] ;
			$prio = $_REQUEST['prio'] ;
			$mat = $_REQUEST['mat'] ;

			echo $c->updateLot($lstId, $etat, $prio, $mat);
		break;
		case "getLotClient":
			$dossier = $_REQUEST['doss'] ;
			echo $c->getLotClient($dossier);
		break;
		case "getLstEtape":
			$dossier = $_REQUEST['doss'] ;
			echo $c->getLstEtape($dossier);
		break;
		
		case "goDate":
			$deb = $_REQUEST['deb'] ;
			$filtre = str_replace("/", "", $deb);
			echo $c->suiviParMois($filtre);
		break;
		case "insertLDT":
			
			$P = $_REQUEST['PRJ'] ;
			$O = $_REQUEST['OPR'] ;
			$S = $_REQUEST['STAT'] ;
			$c = $_REQUEST['cm'] ;
			$q = $_REQUEST['qt'] ;
			$e = $_REQUEST['er'] ;
			$c->insertLDT($P, $O, $S, $c, $q, $e);
		break;
		case "identification":
			$log = $_REQUEST['log'] ;
			$mdp = $_REQUEST['mdp'] ;
			echo $c->identification($log, $mdp);
			
		break;
		case "initMat":
			$mat = $_REQUEST['mat'] ;
			echo $c->initialisation($mat);			
		break;
		case "getLDW":
			$idDoss = $_REQUEST['idDoss'] ;
			$O = $_REQUEST['OPR'] ;
			echo $c->getLDW($idDoss, $O);
		break;
		case "getLstPt":
			$date = $_REQUEST['dt'] ;
			$typeT = $_REQUEST['tp'] ;
			$matricule = $_REQUEST['mt'] ;
			$dep = $_REQUEST['dep'] ;
			echo $c->lstPointage($date, $matricule,$typeT, $dep);
		break;
		case "getLstPtPlat":
			$date = $_REQUEST['dt'] ;
			$typeT = $_REQUEST['tp'] ;
			$matricule = $_REQUEST['mt'] ;
			$dep = $_REQUEST['dep'] ;
			echo $c->lstPointagePlat($date, $matricule,$typeT, $dep);
		break;
		// MODIF TOJO
		case "getLate":
			$date = $_REQUEST['rt'] ;
			$dpt = $_REQUEST['dpt'];
			echo $c->getLate($date,$dpt);
		break;  
		case "GETLot":
		  $pj = $_REQUEST['pjt'];
		  $op = $_REQUEST['opt'];
		  echo $c->lstLot($pj,$op);
		break;
		case "showLot":
		  $pj = $_REQUEST['pj'];
		  $op = $_REQUEST['op'];
		  $lot = $_REQUEST['lot'];
		  $id = $_REQUEST['id'];
		  echo $c->showLot($pj,$lot,$id);
		break;

	// MODIF TANTELY
		case "getLstAbs":
		  $dateAbs = $_REQUEST['dAbs'] ;
		  echo $c->getListAbsence($dateAbs);
		break;
		
}
$c = null;
// AUT Mirah RATAHIRY
// DES lien ajax
// DAT 2012 03 06
?>
