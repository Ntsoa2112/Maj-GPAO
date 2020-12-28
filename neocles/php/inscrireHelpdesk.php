<?php

include_once("../modele/inscription.php");

//------------------RECUPTERATION DES DONNEES--------------
$date_arrivee_php = $_POST['date_arrivee_php'];
$heure_arrivee_php = $_POST['heure_arrivee_php'];
$client_php = $_POST['client_php'];
$demandeur_php = $_POST['demandeur_php'];
$numero_ticket_php = $_POST['numero_ticket_php'];
$heure_creation_ticket_php = $_POST['heure_creation_ticket_php'];
$pole_actuel_php = $_POST['pole_actuel_php'];
$intervenant_php = $_POST['intervenant_php'];
$commentaire_php = $_POST['commentaire_php'];
$tempsla_php = $_POST['tempsla_php'];
//-----------------------------------------------------------

//---------traitement des donnees-----------------------
//-------construction du tableau de donnee
$tableau=array(
	"date_arrivee_php"=>$date_arrivee_php,
	"heure_arrivee_php"=>$heure_arrivee_php,
	"client_php"=>$client_php,
	"demandeur_php"=>$demandeur_php,
	"numero_ticket_php"=>$numero_ticket_php,
	"heure_creation_ticket_php"=>$heure_creation_ticket_php,
	"pole_actuel_php"=>$pole_actuel_php,
	"intervenant_php"=>$intervenant_php,
	"commentaire_php"=>$commentaire_php,
	"tempsla_php"=>$tempsla_php
);

$inscription= new Inscription();
$inscription->enregistrement($tableau);

?>