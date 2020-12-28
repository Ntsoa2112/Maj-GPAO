<?php
session_start();
include_once('php/common.php');
$c = new Cnx();

if (!empty($_FILES)) {

    $etape = isset($_REQUEST['etape'])?$_REQUEST['etape']:'0';
    $dossier = $_REQUEST['dossier'];

    //print_r($etape);

    foreach ($_FILES as $iFile) {			
        $tempFile = $iFile['tmp_name'];
        $targetPath = $_SERVER['DOCUMENT_ROOT'] . $_REQUEST['folder'] ;
        $targetDir = str_replace('//','/',$targetPath) .  '/'.$dossier. '/' .$etape;
        $targetFile =  $targetDir. '/' .$iFile['name'];
        $cheminRelatif = $_REQUEST['folder'] . '/' .$dossier. '/' .$etape. '/' .$iFile['name'];
        //return $cheminRelatif;
        //print_r($_REQUEST['folder']);
        //print_r('\n');
        print_r($targetDir);
					
        if (!mkdir($targetDir, 0777, true)) {
            //die('Echec lors de la création des répertoires...');
        }
		
        print_r($c->insertConsigne($dossier, $etape, htmlspecialchars($iFile['name'])));

        // $fileTypes  = str_replace('*.','',$_REQUEST['fileext']);
        // $fileTypes  = str_replace(';','|',$fileTypes);
        // $typesArray = split('\|',$fileTypes);
        // $fileParts  = pathinfo($iFile['Filedata']['name']);

        // if (in_array($fileParts['extension'],$typesArray)) {
        // Uncomment the following line if you want to make the directory if it doesn't exist
        //mkdir(str_replace('//','/',$targetPath), 0755, true);
		
        move_uploaded_file($tempFile,$targetFile);		
        $url = str_replace($_SERVER['DOCUMENT_ROOT'],'',str_replace('$//', '', $targetFile));
        //echo $c->insertConsigne("1", "1", "$url");
       // echo $url;
	   
	   //split
	   $sortie = str_replace(" ","%20",$targetFile);
		$couper = explode("/", $sortie);
		$temps = "";
		
		for ($i = 0; $i< count($couper)-1 ; $i++) {
			$temps .= $couper[$i] . "/";
		}
	   $temps .= '/FB';
	   		
	   $votreDossier = str_replace("%20"," ",$temps);
	   $votreDossier = str_replace("//","/",$votreDossier);
	   /*if(!is_dir(str_replace("%20"," ",$temps)))
	   {
		   mkdir (str_replace("%20"," ",$temps)."/", 0777, true);
	   }*/
	   
	   /*if (!is_dir($votreDossier."/".str_replace("%20"," ",$couper[count($couper)-1])."/")) 
	   {
		   mkdir ($votreDossier."/".str_replace("%20"," ",$couper[count($couper)-1]."/"), 0777, true);
		   //system('cmd /c start flip/FLIPBOOK_INNOVCOM.exe '.str_replace(" ","%20",$targetFile).' '.str_replace(" ","%20",$votreDossier."/".$couper[count($couper)-1]).'');
	   }*/		

		//$myfile = fopen("\\\\10.128.0.88\\flip$\\temp\\OutPathTXT.txt", "w") or die("Unable to open file!");
		$myfile = fopen("flip_temp/temp/OutPathTXT.txt", "w") or die("Unable to open file!");
			$txt = $votreDossier."/".replaceCaractereSpeciaux($couper[count($couper)-1]);
			fwrite($myfile, $txt);
			fclose($myfile);
		if (copy($targetFile, "flip_temp/temp/".str_replace("%20"," ",replaceCaractereSpeciaux($couper[count($couper)-1])))) 
		{
		}
    }
	
		//mkdir($targetPath.'/one', 0755, true);
	// } else {
	// 	echo 'Invalid file type.';
	// }
}

function replaceCaractereSpeciaux($caractereSpeciaux)
	{
		$Caracte = array("#","[","]","é"," ");
		$equivalence = array("1","2","3","e","_");
		for ($i = 0; $i < count($Caracte); $i++) 
		{
			$caractereSpeciaux = str_replace($Caracte[$i],$equivalence[$i],$caractereSpeciaux);
		}
		return $caractereSpeciaux;
	}
?>