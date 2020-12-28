<?php
session_start();
// AUTEUR RATAHIRY MIRAH
// DATE AVRIL 2011

	$path_models 	= 'lic_mvc\lic_m\\';
	$path_views 	= 'lic_mvc\lic_v\\';
	$path_ctrls 	= 'lic_mvc\lic_c\\';
	include_once $path_models.'func.php';

	$idcv = $_REQUEST['idcv'];
	echo $idcv;
	$input = dirname(__FILE__)."/temp";
	$output= "f_data";
	$repertoire = opendir($input);
	$e = '';
	while(false !== ($fichier = readdir($repertoire)))
	{
		$chemin = $input."/".$fichier;
		if($fichier!="." AND $fichier!=".." AND !is_dir($fichier))
		{
			$infos 			= pathinfo($chemin);
			$extension 		= $infos['extension'];
			$baseName		= $infos['basename'];
			
			$finalName		= "f_data/".$idcv.'_'.$baseName;
			
			copy($chemin, $finalName);
			if (file_exists($finalName))
			{
				unlink($chemin);
				saveFileInBase($finalName);
				$e.='<br>'.$finalName;
			}
			else
			{
				echo "Error upload-transfert: veuillez contacter l'administrateur!";
			}
		}
	}
	closedir($repertoire);
	echo $e;

/*
function supprevssion($dossier_traite , $extension_choisie, $age_requis)
{

	$repertoire = opendir($dossier_traite);
	while(false !== ($fichier = readdir($repertoire)))
	{
		$chemin = $dossier_traite."/".$fichier;
		$infos 			= pathinfo($chemin);
		$extension 		= $infos['extension'];
		$age_fichier 	= time() - filemtime($chemin);
			
		// On n'oublie pas LA condition sous peine d'avoir quelques surprises. :p
		if($fichier!="." AND $fichier!=".." AND !is_dir($fichier) 
		$extension == $extension_choisie AND $age_fichier > $age_requis)
		{
			unlink($chemin);
		}
	}
	closedir($repertoire); // On ferme !
}
*/
?>
