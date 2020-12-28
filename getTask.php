<?php

	include_once('php/common.php');	
	$c = new Cnx();
	
		$currDate = date("Ymd");
		$arr = array();
		$sqlGetMac = "select mac, id from r_listemachine where length(mac) > 5";
		$rsMac=$c->cnx->query($sqlGetMac);

		while($arrMac = $rsMac->fetch())
		{
			$mac = $arrMac['mac'];		
			
			$sql = "SELECT  p_ldt.id_pers, p_ldt.address_ip, p_ldt.h_deb, p_ldt.h_fin, r_personnel.appelation,p_ldt.id_type_ldt, r_personnel.id_droit, p_dossier.num_dossier,p_etape.libelle as lib, r_droit.libelle as libdroit,r_departement.libelle as departement, p_type_ldt.libelle as type  FROM p_ldt 
			INNER JOIN r_personnel ON p_ldt.id_pers = r_personnel.id_pers 
			LEFT JOIN p_dossier ON p_ldt.id_dossier=p_dossier.id_dossier
			LEFT JOIN p_lien_oper_dossier ON p_ldt.id_etape=p_lien_oper_dossier.id_lien 
			LEFT JOIN p_etape ON p_lien_oper_dossier.id_oper=p_etape.id_etape
			LEFT JOIN r_droit ON r_personnel.id_droit=r_droit.id_droit
			LEFT JOIN r_affectation ON r_affectation.id_pers = r_personnel.id_pers
            LEFT JOIN r_departement ON r_affectation.id_departement = r_departement.id
			LEFT JOIN p_type_ldt on p_type_ldt.id_type_ldt = p_ldt.id_type_ldt
			WHERE  mac = '$mac' AND date_deb_ldt = '$currDate' order by h_deb desc limit 1";
		
		//echo $sql;
			$rs=$c->cnx->query($sql);		
			$str = "";
			$etat = 'normal';
			
			
			/* test sur les acces concurent*/

			foreach($rs as $row)
			{
				$diff;
				if ($row['h_fin'] != "") 
				{
					$etat = 'wrapup';
					$sqlIsOut = "SELECT entree from r_pointage where id_util = ".$row['id_pers']." AND pdate = '".date("Y/m/d")."' AND source like 'OUT%' order by entree DESC limit 1";
					$rs1=$c->cnx->query($sqlIsOut);
					foreach($rs1 as $row1)
					{
						if ($row1['entree'] > $row['h_fin']) $etat = 'deconnected';
						break;
					}
					$diff = $c->hDiff($row['h_fin'], date("H:i:s"), "");	
				}
				else
				{			
					$diff = $c->hDiff($row['h_deb'], date("H:i:s"), "");	
					$tk = 	explode(":", $diff)	;		
					if ($tk[0] > 1) $etat = 'anomalie';
				}
				$typeEtape = $row['id_type_ldt'] == '0'?"ldt":"autre";
				
				$arr[] = array("typeEtape"=>$typeEtape,"id"=>"s".$arrMac["id"]."s", "mac"=>$arrMac["mac"], 'id_pers'=>$row['id_pers'], 'address_ip'=>$row['address_ip'], 'libdroit'=>$row['libdroit'], "h_deb"=>$row["h_deb"], 'h_fin'=>$row['h_fin'],  'departement'=>$row['departement'],  'num_dossier'=>substr($row['num_dossier'], 0, 12),  'appelation'=>$row['appelation'],  'id_droit'=>$row['id_droit'],  'diff'=>$diff,  'etat'=>$etat,   'lib'=>substr($row['lib'].$row['type'], 0, 12) );
				
			}
		}
		echo $json_response = json_encode($arr);
	
	
?>