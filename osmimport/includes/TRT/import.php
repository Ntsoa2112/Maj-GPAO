<?php
$xml ="error";
if (isset($_FILES['file']) && ($_FILES['file']['error'] == UPLOAD_ERR_OK)) {
    $xml = simplexml_load_file($_FILES['file']['tmp_name']);
	$placemarks = $xml->Document->Folder->Placemark;
	if($_POST['btn']=='telecharger le fichier'){
		for ($i = 0; $i < sizeof($placemarks); $i++) {
			echo "<br/>name:";print_r((string)$placemarks[$i]->name[0]);
			echo "<br/>longitude:";print_r((string)$placemarks[$i]->LookAt->longitude[0]);
			echo "<br/>latitude:";print_r((string)$placemarks[$i]->LookAt->latitude[0]);
			echo "<br/>------------------------------x-------------------------------------------";
			$result = pg_query($db_connection, "INSERT INTO osm_coordonnee (id_pers,lat,lon) VALUES (".(string)$placemarks[$i]->name[0].",'".(string)$placemarks[$i]->LookAt->latitude[0]."','".(string)$placemarks[$i]->LookAt->longitude[0]."')");
		}	
	}else{
		for ($i = 0; $i < sizeof($placemarks); $i++) {
			echo "<br/>name:";print_r((string)$placemarks[$i]->name[0]);
			echo "<br/>longitude:";print_r((string)$placemarks[$i]->LookAt->longitude[0]);
			echo "<br/>latitude:";print_r((string)$placemarks[$i]->LookAt->latitude[0]);
			echo "<br/>------------------------------x-------------------------------------------";
			
			if(in_array((string)$placemarks[$i]->name[0],$array_idpers)){
				$result = pg_query($db_connection, "DELETE FROM osm_coordonnee WHERE id_pers = ".(string)$placemarks[$i]->name[0].";");
			}
			$result = pg_query($db_connection, "INSERT INTO osm_coordonnee (id_pers,lat,lon) VALUES (".(string)$placemarks[$i]->name[0].",'".(string)$placemarks[$i]->LookAt->latitude[0]."','".(string)$placemarks[$i]->LookAt->longitude[0]."');");
			
		}
	}
	
	header('Location: index.php');
}
