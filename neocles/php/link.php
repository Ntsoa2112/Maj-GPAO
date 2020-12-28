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
			$type_action = $_REQUEST['type_action'] ;	
			
			echo $c->GetStats($idIntervenant,$idTicket,$jour,$sujet,$statut,$dateFin,$dossier,$beneficiaire,$demandeur,$resolution_en_ligne,$type_action,"");			
		break;

		case "GetAnalyseParHeure":
			$jour = $_REQUEST['jourDbt'] ;
			$dateFin = $_REQUEST['jourFin'] ;
			
			echo $c->GetAnalyseParHeure($jour,$dateFin);			
		break;		

		
		case "GetStatutsTickets":
			$jour = $_REQUEST['jour'] ;
			$dateFin = $_REQUEST['dateFin'] ;
			
			echo $c->GetStatutsTickets($jour,$dateFin);	
			//echo 'test';		
		break;		

		case "GetIntervenantTickets":
			$jour = $_REQUEST['jour'] ;
			$dateFin = $_REQUEST['dateFin'] ;
			$choix = $_REQUEST['choix'] ;
			
			echo $c->GetIntervenantTickets($jour,$dateFin,$choix);			
		break;		
		
		
		case "GetActionTickets":
			$jour = $_REQUEST['jour'] ;
			$dateFin = $_REQUEST['dateFin'] ;
			
			echo $c->GetActionTickets($jour,$dateFin);			
		break;		
		
		case "GetSujetsTickets":
			$jour = $_REQUEST['jour'] ;
			$dateFin = $_REQUEST['dateFin'] ;
			
			echo $c->GetSujetsTickets($jour,$dateFin);			
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
	//MODIF MAHASETRA BEJAZZ
		case "rechercheMaha":
	
			$dateSelect = $_REQUEST['dateSelect'] ;
			$poleSelect = $_REQUEST['poleSelect'] ;
			$clientSelect = $_REQUEST['clientSelect'] ;			
			$intervenantSelect = $_REQUEST['intervenantSelect'] ;	
			$ticketSelect = $_REQUEST['ticketSelect'] ;
			
			/* ?>
			// <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
     		// <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.1.3/Chart.bundle.js"></script>
			<?php*/
			?>
			<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
			
			<?php
			
		
			if(!empty($_REQUEST['moisSelect'])){
				$moisSelect = $_REQUEST['moisSelect'];
				$donne = $c->RechercheMois($moisSelect , $poleSelect , $clientSelect , $intervenantSelect , $ticketSelect);
								
				$nbr_mails = intval($donne["2"]);
				$mailsSup30 = intval($donne["3"]);
				$dessous15  = intval($donne["4"]);
				$mails15_30  = intval($donne["5"]);
			
				$pourc_mailsSup30 = round( ( (100 * $mailsSup30) / $nbr_mails) , 0);
				$pourc_dessous15 = round( ( (100 * $dessous15) / $nbr_mails), 0);
				$pourc_mails15_30 = round( ( (100 * $mails15_30) / $nbr_mails), 0);
				echo $pourc_mailsSup30." *** ".$pourc_dessous15." *** ".$pourc_mails15_30;
				
				 ?>
				 <input id="Sup30" type="hidden" value="<?=$pourc_mailsSup30?>">
				 <input id="Dessous15" type="hidden" value="<?=$pourc_dessous15?>">
				 <input id="Entre15_30" type="hidden" value="<?=$pourc_mails15_30?>">
				<?php
				$tab = $donne["tableau"];
				
				
				echo $donne["1"];
				echo'<br>';echo'<br>';
				require("char.html");
				echo'<br>';echo'<br>';echo'<br>';echo'<br>';
				require("baton.html");
			}
			else{
				echo $c->RechercheMaha($dateSelect , $poleSelect , $clientSelect , $intervenantSelect , $ticketSelect);
			}
			
			//$moisSelect = $_REQUEST['moisSelect'];
			
			//echo $c->RechercheMaha($dateSelect , $poleSelect , $clientSelect , $intervenantSelect , $ticketSelect);
			/*	
			if(!empty($_REQUEST['moisSelect'])){
				echo $c->RechercheMaha($dateSelect , $poleSelect , $clientSelect , $intervenantSelect , $ticketSelect);	
			}
			else{
				echo $c->RechercheMois($moisSelect , $poleSelect , $clientSelect , $intervenantSelect , $ticketSelect);	
			}	
			*/	
		break;
		case "supprimerMaha":

			$id = $_GET['id'];
			
			echo $c->DeleteHelpdesk($id);
		break;
		case "supprimerMahaSup":

			$id = $_GET['id'];
			
			echo $c->DeleteSupervision($id);
		break;
		
		case "rechercheMahaSup":

			$dateSelect = $_REQUEST['dateSelect'] ;
			$etatSelect = $_REQUEST['etatSelect'] ;
			$clientSelect = $_REQUEST['clientSelect'] ;			
			$intervenantSelect = $_REQUEST['intervenantSelect'] ;	
			$ticketSelect = $_REQUEST['ticketSelect'] ;	
			
			if(!empty($_REQUEST['moisSelectSup'])){
				$moisSelect = $_REQUEST['moisSelectSup'];
				$donne = $c->RechercheMois($moisSelectSup , $etatSelect , $clientSelect , $intervenantSelect , $ticketSelect);
								
				$nbr_mails = intval($donne["2"]);
				$mailsSup30 = intval($donne["3"]);
				$dessous15  = intval($donne["4"]);
				$mails15_30  = intval($donne["5"]);
			
				$pourc_mailsSup30 = round( ( (100 * $mailsSup30) / $nbr_mails) , 0);
				$pourc_dessous15 = round( ( (100 * $dessous15) / $nbr_mails), 0);
				$pourc_mails15_30 = round( ( (100 * $mails15_30) / $nbr_mails), 0);
				echo $pourc_mailsSup30." *** ".$pourc_dessous15." *** ".$pourc_mails15_30;
				
				 ?>
				 <input id="Sup30" type="hidden" value="<?=$pourc_mailsSup30?>">
				 <input id="Dessous15" type="hidden" value="<?=$pourc_dessous15?>">
				 <input id="Entre15_30" type="hidden" value="<?=$pourc_mails15_30?>">
				<?php
				$tab = $donne["tableau"];
				
				
				echo $donne["1"];
				echo'<br>';echo'<br>';
				require("char.html");
				echo'<br>';echo'<br>';echo'<br>';echo'<br>';
				require("baton.html");
			}
			else{
				echo $c->RechercheMahaSup($dateSelect , $etatSelect  , $clientSelect , $intervenantSelect , $ticketSelect);
			}
					
		break;
		case "insertHelpdesk":

			$date_arrivee_php = $_POST['date_arrivee_php'];
			$heure_arrivee_php = $_POST['heure_arrivee_php'];
			$client_php = $_POST['client_php'];
			$demandeur_php = $_POST['demandeur_php'];
			$numero_ticket_php = $_POST['numero_ticket_php'];
			$heure_creation_ticket_php = $_POST['heure_creation_ticket_php'];
			$pole_actuel_php = $_POST['pole_actuel_php'];
			$intervenant_php = $_POST['intervenant_php'];
			$commentaire_php = $_POST['commentaire_php'];
			$tempsla_php = $_POST['tempsla_php'];//ajout luc

			echo $c->InsertHelpdesk($date_arrivee_php , $heure_arrivee_php , $client_php , $demandeur_php , $heure_creation_ticket_php, $numero_ticket_php,  $pole_actuel_php, $intervenant_php, $commentaire_php,$tempsla_php);//ajout luc			
		break;
		case "updateHelpdesk":

			$id = $_GET['id'];
			$date_arrivee_php = $_POST['date_arrivee_php'];
			$heure_arrivee_php = $_POST['heure_arrivee_php'];
			$client_php = $_POST['client_php'];
			$demandeur_php = $_POST['demandeur_php'];
			$numero_ticket_php = $_POST['numero_ticket_php'];
			$heure_creation_ticket_php = $_POST['heure_creation_ticket_php'];
			$pole_actuel_php = $_POST['pole_actuel_php'];
			$intervenant_php = $_POST['intervenant_php'];
			$commentaire_php = $_POST['commentaire_php'];
			$tempsla_php = $_POST['tempsla_php'];//ajout luc

			echo $c->UpdateHelpdesk($id , $date_arrivee_php , $heure_arrivee_php , $client_php , $demandeur_php , $heure_creation_ticket_php, $numero_ticket_php,  $pole_actuel_php, $intervenant_php, $commentaire_php,$tempsla_php);			
		break;
		case "insertSupervision":

			$date_arrivee_php = $_POST['date_arrivee_php'];
			$heure_arrivee_php = $_POST['heure_arrivee_php'];
			$client_php = $_POST['client_php'];
			$origine_php = $_POST['origine_php'];
			$numero_ticket_php = $_POST['numero_ticket_php'];
			$heure_creation_ticket_php = $_POST['heure_creation_ticket_php'];
			$etat_php = $_POST['etat_php'];
			$intervenant_php = $_POST['intervenant_php'];
			$commentaire_php = $_POST['commentaire_php'];

			echo $c->InsertSupervision($date_arrivee_php , $heure_arrivee_php , $client_php , $origine_php , $heure_creation_ticket_php, $numero_ticket_php,  $etat_php, $intervenant_php, $commentaire_php);			
		break;
		case "updateSupervision":

			$id = $_GET['id'];
			$date_arrivee_php = $_POST['date_arrivee_php'];
			$heure_arrivee_php = $_POST['heure_arrivee_php'];
			$client_php = $_POST['client_php'];
			$origine_php = $_POST['origine_php'];
			$numero_ticket_php = $_POST['numero_ticket_php'];
			$heure_creation_ticket_php = $_POST['heure_creation_ticket_php'];
			$etat_php = $_POST['etat_php'];
			$intervenant_php = $_POST['intervenant_php'];
			$commentaire_php = $_POST['commentaire_php'];

			echo $c->UpdateSupervision($id , $date_arrivee_php , $heure_arrivee_php , $client_php , $origine_php , $heure_creation_ticket_php, $numero_ticket_php,  $etat_php, $intervenant_php, $commentaire_php);			
		break;
		case "rechercheHistorique":

			$dateSelect = $_GET['dateSelect'];
			$numTicketSelect = $_GET['numTicketSelect'];
			$matriculSelect = $_GET['matriculSelect'];
			$actionSelect = $_GET['actionSelect'];
			$typeSelect = $_GET['typeSelect'];

			//echo $dateSelect.$numTicketSelect.$matriculSelect.$actionSelect.$typeSelect;

			echo $c->RechercheHistorique($dateSelect, $numTicketSelect, $matriculSelect, $actionSelect, $typeSelect);

			break;
		case "supprimerUtilisateur":

			$matricul = $_GET['matricul'];

			echo $c->supprimerUtilisateur($matricul);

			break;
		case "saveUser":

			$matricul = $_GET['matricul'];

			echo $c->saveUser($matricul);

			break;


		//POUR L'APPEL
		case "rechercheAppel":

			$dateSelect = $_REQUEST['dateSelect'] ;
			$societeSelect = $_REQUEST['societeSelect'] ;
			$interlocuteurSelect = $_REQUEST['interlocuteurSelect'] ;			
			$intervenantSelect = $_REQUEST['intervenantSelect'] ;	
			$ticketSelect = $_REQUEST['ticketSelect'] ;	
			
			echo $c->RechercheAppel($dateSelect , $societeSelect , $interlocuteurSelect , $intervenantSelect , $ticketSelect);			
		break;
		case "supprimerAppel":

			$id = $_GET['id'];			
			echo $c->DeleteAppel($id);

		break;
		case "insertAppel":

			//echo "success";

			$date_php = $_POST['date_php'];
			$heure_php = $_POST['heure_php'];
			$duree_php = $_POST['duree_php'];
			$societe_php = $_POST['societe_php'];
			$interlocuteur_php = $_POST['interlocuteur_php'];
			$ticket_php = $_POST['ticket_php'];
			$type_php = $_POST['type_php'];
			$comportement_php = $_POST['comportement_php'];
			$intervenant_php = $_POST['intervenant_php'];
			$description_php = $_POST['description_php'];

			echo $c->InsertAppel($date_php , $heure_php , $duree_php , $societe_php , $interlocuteur_php, $ticket_php, $type_php, $comportement_php, $intervenant_php , $description_php);			
		
		break;
		case "updateAppel":

			$id = $_GET['id'];
			$date_php = $_POST['date_php'];
			$heure_php = $_POST['heure_php'];
			$duree_php = $_POST['duree_php'];
			$societe_php = $_POST['societe_php'];
			$interlocuteur_php = $_POST['interlocuteur_php'];
			$ticket_php = $_POST['ticket_php'];
			$type_php = $_POST['type_php'];
			$comportement_php = $_POST['comportement_php'];
			$intervenant_php = $_POST['intervenant_php'];
			$description_php = $_POST['description_php'];

			echo $c->UpdateAppel($id , $date_php , $heure_php , $duree_php , $societe_php , $interlocuteur_php, $ticket_php, $type_php, $comportement_php, $intervenant_php , $description_php);			
		break;

		//pour les paramètres dans APPEL
		case "addParamAppel":

			$id = $_GET['id'];
			$type = $_GET['type'];			
			echo $c->addList($id , $type);

		break;
		case "deleteParamAppel":

			$id = $_GET['id'];
			$type = $_GET['type'];		
			echo $c->DeleteParamAppel($id , $type);

		break;
		case "rechercheTicketParIntervenant":

			$dateDebut = $_GET['dateDebut'];
			$dateFin = $_GET['dateFin'];	
			$intervenant = $_GET['intervenant'];	
			echo $c->rechercheTicketParIntervenant($dateDebut , $dateFin , $intervenant);

		break;
	}
$c = null;
// AUT Mirah RATAHIRY
// DES lien ajax
// DAT 2012 03 06
?>
