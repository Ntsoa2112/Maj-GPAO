<?php

header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past

	include_once('php/cnx.inc.php');
	include_once('php/fonc.inc.php');
	$action = $_REQUEST['action'];
	
	switch($action){
		case "load":
			$res = returnContent('mini_chat');
			echo 'split_content'.$res.'split_content';
		break;
		case "sendMs":
			$user = $_REQUEST['user'];
			$message = $_REQUEST['message'];
			if ($message != "")
			{
				$pseudo = mysql_real_escape_string(htmlspecialchars($user));
				$message = mysql_real_escape_string(htmlspecialchars($message));
				insertMs($pseudo, $message);
			}
			$res = returnContent('mini_chat');
			echo 'split_content'.$res.'split_content';
		break;
		case "loadFile":
			$file = $_REQUEST['idAppli'];
			$Fichier="";
			if (!$fp = fopen($file,"r")) {
				echo "Echec de l'ouverture du fichier";
				exit;
			}
			else {
				while(!feof($fp)) {
					$Ligne = fgets($fp,255);
					if ($Ligne =="") continue;
					$Fichier = $Fichier.'<br>'.$Ligne;
				}
				//$accent="ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿ";
				///$noAccent="aaaaaaaceeeeiiiidnoooooouuuuybsaaaaaaaceeeeiiiidnoooooouuuyyby";
				//$Fichier=strtr(trim($Fichier),$accent,$noAccent); 
				echo ($Fichier);
				fclose($fp);
			}
		break;
		case "loadSongList":
			$file = $_REQUEST['idAppli'];
			$Fichier="";
			if (!$fp = fopen($file,"r")) {
				echo "Echec de l'ouverture du fichier";
				exit;
			}
			else {
				while(!feof($fp)) {
					$Ligne = fgets($fp,255);
					if ($Ligne =="") continue;
					$Fichier = $Fichier.$Ligne;
				}
				echo addslashes($Fichier);
				fclose($fp);
			}
		break;
		case "insertUser":
			$anarana = $_REQUEST['pseudo'];
			echo insertUser($anarana);
		break;
		case "removeUser":
			$anarana = $_REQUEST['pseudo'];
			removeUser($anarana);
		break;
		case "sendMail":
			$sender = strtolower($_REQUEST['sender']);
			$object = $_REQUEST['object'];
			$content = $_REQUEST['content'];
			$dest = $_REQUEST['destinataire']; 
			sendMail($sender,$dest, $object, $content);
		break;
		case "loadPhp":
			$file = $_REQUEST['page'];
			header("Location: index.php");
		break;
	}
?>

