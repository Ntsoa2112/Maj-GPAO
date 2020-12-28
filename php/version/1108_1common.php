<?php

// AUT Mirah RATAHIRY
// DES Requete et fonctions dossiers
// DAT 2012 03 06
// MAJ 2012 10 02 Ajout filtre au niveau du ldt (tri header)

/*

 */
Class OperateurTemps
		{
			public $cDate;
			public $heureProd;
			public $heureHorsProd;
			public $Qte;
			public $vBrute;
			public $vNette;
			
			public function __Construct($_date, $_heureProd, $_heureHorsProd, $_Qte)
			{
				$this->cDate = $_date;
			    $this->heureProd = $_heureProd;
			    $this->heureHorsProd= $_heureHorsProd;
			    $this->Qte = $_Qte;
			}
		}
		
class Cnx extends PDO {

    public $cnx;
	
   // const DEFAULT_DNS = 'pgsql:host=10.128.1.2 port=5432;dbname=easy';
    const DEFAULT_DNS = 'pgsql:dbname=easy';
    const DEFAULT_SQL_USER = 'rami';
    // const DEFAULT_SQL_PASS = 'Ra123456$';
    const DEFAULT_SQL_PASS = '$rami$$';

    public function  Cnx() {
        $this->cnx = new PDO(
                self::DEFAULT_DNS, self::DEFAULT_SQL_USER, self::DEFAULT_SQL_PASS
        );
    }

    // fonction utilisé par angular pour la recuperation du pointage
    function ngGetData() {
        "SELECT entree, source, id_pointage from r_pointage where pdate = '2017/05/15'		order by entree limit 10";

        $arr = array();
        $rs = $this->cnx->query($sql);

        foreach ($rs as $row) {
            $arr[] = $row;
        }
        //unset($rs);
        echo $json_response = json_encode($rs);
    }

    function checkMatricule() {

        $sqlPointage = "select count(*) from enquete_smq where id_pers = " . $_SESSION['id'];
        $rs1 = $this->cnx->query($sqlPointage);
        while ($arr1 = $rs1->fetch()) {
            if ($arr1[0] > 0)
                return true;
            else
                return false;
        }
    }

    //mise a jour de l'adresse mac a partir du plan html editable
    function updateMac($id) {
        //$macz = str_replace(":", "", $mac);

        $pc = GetHostByName($_SERVER['REMOTE_ADDR']); //IP of the PC to manage
        if ($pc == "127.0.0.1" || $pc == "localhost")
            return 'localhost';
        $WbemLocator = new COM("WbemScripting.SWbemLocator");
        $domaine = "EASYTECH";

        $WbemServices = $WbemLocator->ConnectServer($pc, 'root\\cimv2', 'mirah', 'Ra123456$', "MS_409", "ntlmdomain:" . $domaine);
        $WbemServices->Security_->ImpersonationLevel = 3;

        $disks = $WbemServices->ExecQuery("Select * from Win32_NetworkAdapterConfiguration  WHERE IPEnabled=TRUE");

        foreach ($disks as $d) {
            $macz = str_replace(":", "", $d->MACAddress);
            $rs = $this->cnx->exec("update r_listemachine set mac='" . $macz . "', date_insert= '" . date("Ymd H:i:s") . "' where id=$id");
            return $macz;
        }
    }

    //rermine les lignes de temps
    function noNullFinLdt() {
        return "SELECT noNullDateFin()";
        echo $this->cnx->exec($sqlDoss);
    }

    //nombre heure des opérateurs mensuelle ou par intervale, dans le reporting
    function nombreHeureOP($intervalle, $matricule, $dossier) {
        $tk = explode(",", $intervalle);

        $filtreIntervaleTemps = " AND p_ldt.date_deb_ldt = '" . $intervalle . "'";
        if (count($tk) > 1)
            $filtreIntervaleTemps = " AND p_ldt.date_deb_ldt >=  '" . $tk[0] . "' AND p_ldt.date_deb_ldt <= '" . $tk[1] . "'";
        if ($dossier != "")
            $filtreIntervaleTemps .= " AND p_ldt.id_dossier = " . $dossier;
        $sql = "SELECT date_deb_ldt, h_deb, h_fin FROM p_ldt WHERE id_pers = " . $matricule . $filtreIntervaleTemps . " order by p_ldt.date_deb_ldt, p_ldt.h_deb";

        $sql = "select SUM(DATE_PART('epoch', ('2011-12-29 '||h_fin)::timestamp - ('2011-12-29 '||h_deb)::timestamp )) as somme from p_ldt where id_pers = " . $matricule . $filtreIntervaleTemps;

        $diff;
        $somme = "0:0:0";
        $rs = $this->cnx->query($sql);

        foreach ($rs as $row) {
            return $this->sec2hms($row['somme'], true);


            if ($row['h_deb'] == "" || $row['h_fin'] == "")
                continue;
            $diff = $this->hDiff($row['h_deb'], $row['h_fin'], "");
            $somme = $this->hDiff($somme, $diff, "+");
        }
        return $somme;
    }

    // recuperation des données dans la base pour affichage a l'accueil de la GPAO
    function GetFluxRss($date, $auteur, $heure, $id, $titre, $content) {
        $sqlDoss = "SELECT titre, content, auteur,  fluxdate, fluxheure, id FROM p_flux order by RANDOM()";
        $str = "";
        $rsDoss = $this->cnx->query($sqlDoss);
        while ($arr = $rsDoss->fetch()) {
            $str .= '<div><div id="' . $arr['id'] . '" ><a href="#?w=500" rel=' . $arr['id'] . ' class="poplight"><b>' . $arr['titre'] . '</b></a>';
            $str .= '<p  class="div_flux">' . $arr['content'] . "</p></div></div>";
        }
        return $str;
    }

    function enqueteDejaFait($all) {
        $sqlPointage = "select * from enquete_smq where id_pers = " . $_SESSION['id'];
        if ($all == 'ALL')
            $sqlPointage = "select id_pers from r_personnel where actif=true and id_pers not in (select id_pers from enquete_smq order by id_pers) order by id_pers";

        $rs1 = $this->cnx->query($sqlPointage);

        $str = '';
        while ($arr1 = $rs1->fetch()) {
            if ($all == 'ALL')
                $str .= ' - ' . $arr1['id_pers'];
            else
                return true;
        }
        return $str;
    }

    function enquete($score, $priorite, $Soarano, $Ankorondrano, $Alarobia, $Andraharo) {
        $sqlPointage = "select id from enquete_demenagement where id_pers = " . $_SESSION['id'];
        $rs1 = $this->cnx->query($sqlPointage);
        while ($arr1 = $rs1->fetch()) {
            return true;
        }
        $sql = "INSERT INTO enquete_demenagement (id_pers, priorite, score, soarano, ankorondrano, alarobia, andraharo)
		values (" . $_SESSION['id'] . ", '$priorite',$score, $Soarano, $Ankorondrano, $Alarobia, $Andraharo)";
        //return $sql;
        if ($this->cnx->exec($sql)) {
            return true;
        }
        return false;
    }

    function suiviHeureOP($intervalle, $dossier, $departement, $matricule) {
        // selection OP
        // somme heure op pendant la periode
        // ajout dossier si possible</div>

        set_time_limit(30000);
        $tk = explode(",", $intervalle);
        $filtreIntervaleTemps = " AND p_ldt.date_deb_ldt = '" . $intervalle . "'";
        if (count($tk) > 1) $filtreIntervaleTemps = " AND p_ldt.date_deb_ldt >=  '" . $tk[0] . "' AND p_ldt.date_deb_ldt <= '" . $tk[1] . "'";
		
		$filtreDossier = ($dossier != "")? " AND p_ldt.id_dossier =  $dossier" :"";
		$filtreMatricule = ($matricule != "")? " AND p_ldt.id_pers =  $matricule" :"";

        $filtreDepartement = "";
        if ($departement != "" && $departement != " ") {            
            $filtreDepartement = " AND r_personnel.id_departement = $departement ";
        }
        

        $sql = "select SUM(DATE_PART('epoch', ('2011-12-29 '||h_fin)::timestamp - ('2011-12-29 '||h_deb)::timestamp )) as somme,  sum(to_number('0'||quantite,'99999')) as qte, p_ldt.id_pers, id_type_ldt, r_personnel.appelation
		FROM p_ldt 
		LEFT JOIN r_personnel ON r_personnel.id_pers=p_ldt.id_pers 
		where 1=1 		
		$filtreDepartement $filtreIntervaleTemps	$filtreDossier	$filtreMatricule
		GROUP BY p_ldt.id_pers,  r_personnel.appelation, id_type_ldt order by p_ldt.id_pers, id_type_ldt ";
		
		
        $ii = 0;
        $str = "<table class='hp'>";
		$str .= "<tr><td class='vertical-text matricule'><h3 class='title3'>MATRICULE</h3></td>
		<td class='vertical-text texte_vert'>VITESSE NETTE</td>
		<td class='title4 vertical-text texte_bleu'>VITESSE BRUTE</td>
		<td class='vertical-text'>QTE</td>	
		<td class='vertical-text texte_bleu'>PROD&#176; BRUTE</td>
			
		<td class='vertical-text texte_vert'>PROD&#176; NETTE</td>
		<td class='vertical-text texte_grenat'>HORS PROD</td>
		<td class='vertical-text gray'>PAUSE</td>
		<td class='vertical-text gray nopading '>FORMATION</td>
		<td class='vertical-text gray nopading '>ATTENTE_DE_TRAVAIL</td>
		<td class='vertical-text gray nopading '>PAUSE_DEJEUNER</td>
		<td class='vertical-text gray nopading '>PANNE_MACHINE</td>
		<td class='vertical-text gray nopading '>PANNE_INTERNET</td>
		<td class='vertical-text gray nopading '>PANNE_RESEAU</td>
		<td class='vertical-text gray nopading '>Delegues_du_personnel</td>
		<td class='vertical-text gray nopading '>PAUSE_TOILETTE</td>
		<td class='vertical-text gray nopading '>INSTALLATION</td>
		<td class='vertical-text gray nopading '>OSTIE</td>
		<td class='vertical-text gray nopading '>REUNION</td>
		<td class='vertical-text gray nopading '>MAINTENANCE</td>
		<td class='vertical-text gray nopading '>PERMISSION</td>
		<td class='vertical-text gray nopading '>EXERCICE_Sous_charge</td>
		<td class='vertical-text gray nopading '>PROBLEME_APPLICATION</td>
		<td class='vertical-text gray nopading '>TEST_APPLICATION</td>
		<td class='vertical-text gray nopading '>REFECTION</td></tr>";

		
        $rsDoss = $this->cnx->query($sql);
		$lastIdPers=0;
		
		$PAUSE=0;
		$FORMATION=0;
		$ATTENTE_DE_TRAVAIL=0;
		$PAUSE_DEJEUNER=0;
		$PANNE_MACHINE=0;
		$PANNE_INTERNET=0;
		$PANNE_RESEAU=0;
		$Delegues_du_personnel=0;
		$PAUSE_TOILETTE=0;
		$INSTALLATION=0;
		$OSTIE=0;
		$REUNION=0;
		$MAINTENANCE=0;
		$PERMISSION=0;
		$EXERCICE_Sous_charge=0;
		$PROBLEME_APPLICATION=0;
		$TEST_APPLICATION=0;
		$REFECTION=0;
		
		//return $sql;
		$qte=0;
		$nbOp = 1;
		$prod = 0;
		$horsProd = 0;
		
		$sommeQte=0;
		$sommeHeure=0;
		$sommeHeureProd = 0;
		$sommeHeureHorsProd = 0;
		$tmpStr = "";
		$cl='';

        while ($arr = $rsDoss->fetch()) {
			$date = "";
			$pers = "";
			
			if ($ii >= 3) $ii = 0;
            $cl = 'classe' . $ii;
						
			$somme = $arr['somme'];
			
			
			
			if ($lastIdPers <> $arr['id_pers']) 
			{
				$str .= str_replace('0.00', "", $tmpStr);
				
				$ii++;
				$nbOp++;				
				
				$sommeQte+=$qte;
				$sommeHeureProd += $prod;
				$sommeHeureHorsProd += $horsProd;
				
				$qte=0;
				$prod = 0;
				$horsProd = 0;
				
				$PAUSE=0;
				$FORMATION=0;
				$ATTENTE_DE_TRAVAIL=0;
				$PAUSE_DEJEUNER=0;
				$PANNE_MACHINE=0;
				$PANNE_INTERNET=0;
				$PANNE_RESEAU=0;
				$Delegues_du_personnel=0;
				$PAUSE_TOILETTE=0;
				$INSTALLATION=0;
				$OSTIE=0;
				$REUNION=0;
				$MAINTENANCE=0;
				$PERMISSION=0;
				$EXERCICE_Sous_charge=0;
				$PROBLEME_APPLICATION=0;
				$TEST_APPLICATION=0;
				$REFECTION=0;	
			}
			$qte += $arr['qte'];
			
			
			switch($arr['id_type_ldt']){
				case 0:	$prod+= $arr['somme'];break;
				//case 1:	$PAUSE+= $arr['somme'];$horsProd += $arr['somme'];break;					
				case 2:	$FORMATION+= $arr['somme'];$horsProd += $arr['somme'];break;					
				case 3:	$ATTENTE_DE_TRAVAIL+= $arr['somme'];$horsProd += $arr['somme'];break;					
				//case 4:	$PAUSE_DEJEUNER+= $arr['somme'];$horsProd += $arr['somme'];break;					
				case 5:	$PANNE_MACHINE+= $arr['somme'];$horsProd += $arr['somme'];break;					
				case 6:	$PANNE_INTERNET+= $arr['somme'];$horsProd += $arr['somme'];break;					
				case 7:	$PANNE_RESEAU+= $arr['somme'];$horsProd += $arr['somme'];break;					
				case 8:	$Delegues_du_personnel+= $arr['somme'];$horsProd += $arr['somme'];break;					
				//case 9:	$PAUSE_TOILETTE+= $arr['somme'];$horsProd += $arr['somme'];break;					
				case 10:$INSTALLATION+= $arr['somme'];$horsProd += $arr['somme'];break;					
				case 11:$OSTIE+= $arr['somme'];$horsProd += $arr['somme'];break;					
				case 12:$REUNION+= $arr['somme'];$horsProd += $arr['somme'];break;					
				case 13:$MAINTENANCE+= $arr['somme'];$horsProd += $arr['somme'];break;					
				case 14:$PERMISSION+= $arr['somme'];$horsProd += $arr['somme'];break;					
				case 15:$EXERCICE_Sous_charge+= $arr['somme'];$horsProd += $arr['somme'];break;					
				case 16:$PROBLEME_APPLICATION+= $arr['somme'];$horsProd += $arr['somme'];break;					
				case 17:$TEST_APPLICATION+= $arr['somme'];$horsProd += $arr['somme'];break;					
				case 18:$REFECTION+= $arr['somme'];$horsProd += $arr['somme'];break;
			}

			
			//if ($lastIdPers <> $arr['id_pers'])
			{
				
				$total = $prod + $horsProd;				
				if (($total/3600) < 7) $cl = "warning";
		
				$pers = $arr['id_pers'];
				$vitesse_brute = ($qte != 0) ? number_format($qte / ($total/3600), 2) : '';
				$vitesse_nette = ($qte != 0) ? number_format($qte / ($prod/3600), 2) : '';
				
				$tmpStr = "<tr class = $cl>";
				//$sommeQte = ($sommeQte == 0)?'':$sommeQte;
				
				$tmpStr .= "<td><h3 class='title3 matricule'>" . $pers. "\n<h5>".$arr['appelation']."</h5></h3></td>";
				$tmpStr .= "<td><h4  class='title4 texte_vert'>" . $vitesse_nette . "</h4></td>";
				$tmpStr .= "<td><h4  class='title4 texte_bleu'>" . $vitesse_brute . "</h4></td>";
				$tmpStr .= "<td class=' ".$cl."_1'><h4  class='title4'>" . $qte . "</h4></td>";
				$tmpStr .= "<td class=' ".$cl."_1 texte_bleu'>" . sprintf("%01.2f", $total/3600) . "</td>";
				
				$tmpStr .= "<td class=' ".$cl."_1 texte_vert'>" . sprintf("%01.2f", $prod/3600)  . "</td>";
				$tmpStr .= "<td class=' ".$cl."_1 texte_grenat'><i>" . sprintf("%01.2f", $horsProd/3600)  . "</i></td>";
				$tmpStr .= "<td class='gray ".$cl."_2'>". sprintf("%01.2f", $PAUSE/3600)  . "</td>
				<td class='gray nopading  ".$cl."_2'>" . sprintf("%01.2f", $FORMATION/3600)  . "</td>
				<td class='gray nopading ".$cl."_2'>" . sprintf("%01.2f", $ATTENTE_DE_TRAVAIL/3600)  . "</td>
				<td class='gray nopading ".$cl."_2'>" . sprintf("%01.2f", $PAUSE_DEJEUNER/3600)  . "</td>
				<td class='gray nopading ".$cl."_2'>" . sprintf("%01.2f", $PANNE_MACHINE/3600)  . "</td>
				<td class='gray nopading ".$cl."_2'>" . sprintf("%01.2f", $PANNE_INTERNET/3600)  . "</td>
				<td class='gray nopading ".$cl."_2'>" . sprintf("%01.2f", $PANNE_RESEAU/3600)  . "</td>
				<td class='gray nopading ".$cl."_2'>" . sprintf("%01.2f", $Delegues_du_personnel/3600)  . "</td>
				<td class='gray nopading ".$cl."_2'>" . sprintf("%01.2f", $PAUSE_TOILETTE/3600)  . "</td>
				<td class='gray nopading ".$cl."_2'>" . sprintf("%01.2f", $INSTALLATION/3600)  . "</td>
				<td class='gray nopading ".$cl."_2'>" . sprintf("%01.2f", $OSTIE/3600)  . "</td>
				<td class='gray nopading ".$cl."_2'>" . sprintf("%01.2f", $REUNION/3600)  . "</td>
				<td class='gray nopading ".$cl."_2'>" . sprintf("%01.2f", $MAINTENANCE/3600)  . "</td>
				<td class='gray nopading ".$cl."_2'>" . sprintf("%01.2f", $PERMISSION/3600)  . "</td>
				<td class='gray nopading ".$cl."_2'>" . sprintf("%01.2f", $EXERCICE_Sous_charge/3600)  . "</td>
				<td class='gray nopading ".$cl."_2'>" . sprintf("%01.2f", $PROBLEME_APPLICATION/3600)  . "</td>
				<td class='gray nopading ".$cl."_2'>" . sprintf("%01.2f", $TEST_APPLICATION/3600)  . "</td>
				<td class='gray nopading ".$cl."_2'>" . sprintf("%01.2f", $REFECTION/3600)  . "</td>";
				$tmpStr .= "</tr>";	
			}
			$lastIdPers = $arr['id_pers'];
        }
		
		$sommeQte+=$qte;
		$sommeHeureProd += $prod;
		$sommeHeureHorsProd += $horsProd;		
		
		$str .= str_replace('0.00', "", $tmpStr);
		
		$sommeHeure = $sommeHeureProd+$sommeHeureHorsProd;
		$sommeHeureProd = ($sommeHeureProd == 0)?1:$sommeHeureProd;
		$hProd = ($sommeHeure == 0)?1:($sommeHeure/3600);

		//return $sommeProd/3600;
		$str .= "<tr class = classe2>";
				
				$str .= "<td><h3 class='title3'>AVG</h3></td>";
				
				$str .= "<td><h4  class='title4 texte_vert'>" . sprintf("%01.2f", ($sommeQte / ($sommeHeureProd/3600)), 2) ."</h4></td>";
				$str .= "<td><h4  class='title4 texte_bleu'>" . sprintf("%01.2f", ($sommeQte / $hProd), 2) ."</h4></td>";
				$str .= "<td class=' ".$cl."_1'><h4  class='title4'>" . sprintf("%01.2f", $sommeQte/$nbOp) . "</h4></td>";
				
				
				$str .= "<td class=' ".$cl."_1 texte_bleu'>" . sprintf("%01.2f", ($sommeHeure/3600)/$nbOp) . "</td>";
				
				$str .= "<td class=' ".$cl."_1 texte_vert'>" . sprintf("%01.2f", ($prod/3600)/$nbOp).			"</td>";
				$str .= "<td class=' ".$cl."_1 texte_grenat'><i>" . sprintf("%01.2f", ($horsProd/3600)/$nbOp).			"</i></td>";
				$str .= "<td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>";
							$str .= "</tr>";
							
		$str .= "<tr class = classe1>";
				
				$qteMoyenne = $sommeQte/$nbOp;
				
				$str .= "<td><h3 class='title3'>TOTAL</h3></td>";
				$str .= "<td><h4  class='title4 texte_vert'></h4></td>";
				$str .= "<td><h4  class='title4 texte_bleu'></h4></td>";
				$str .= "<td class=' ".$cl."_1'><h4  class='title4'>" . $sommeQte . "</h4></td>";
				
				
				$str .= "<td class=' ".$cl."_1 texte_bleu'>" . sprintf("%01.2f", ($sommeHeure/3600)) . "</td>";
				
				$str .= "<td class=' ".$cl."_1 texte_vert'>" . sprintf("%01.2f", $sommeHeureProd/	3600).			"</td>";
				$str .= "<td class=' ".$cl."_1 texte_grenat'><i>" . sprintf("%01.2f", $sommeHeureHorsProd/		3600).			"</i></td>";
				$str .= "<td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td>";
							$str .= "</tr>";

        $str .= "</table>";

        return $str;
    }
	
	function evolutionVitesse()
	{
		$date = date("Ymd");
		$dateJmoins1 = ($date-1000).",".$date;
		
		$arrayDate = array();
		
		$sql = "select p_ldt.date_deb_ldt, SUM(DATE_PART('epoch', ('2011-12-29 '||h_fin)::timestamp - ('2011-12-29 '||h_deb)::timestamp )) as somme, sum(to_number('0'||quantite,'99999')) as qte, 
			id_type_ldt FROM p_ldt 

			where 1=1 AND p_ldt.date_deb_ldt > '$dateJmoins1' 
			AND p_ldt.id_pers = ".$_SESSION['id']." GROUP BY p_ldt.date_deb_ldt, id_type_ldt order by p_ldt.date_deb_ldt, id_type_ldt";
			
			$rsDoss = $this->cnx->query($sql);
		
		//return $sql;
		
        while ($arr = $rsDoss->fetch()) 
		{
		
			/*
			public $Qte;
			public $vBrute;
			public $vNette;
			*/
			$somme = sprintf("%01.2f", $arr['somme']/3600);
			if (array_key_exists($arr['date_deb_ldt'], $arrayDate))
			{
				$arrayDate[$arr['date_deb_ldt']]->heureHorsProd += $somme;
				
				if ($arrayDate[$arr['date_deb_ldt']]->Qte > 0)
				{
					$arrayDate[$arr['date_deb_ldt']]->vBrute = sprintf("%d", ($arrayDate[$arr['date_deb_ldt']]->Qte / ($arrayDate[$arr['date_deb_ldt']]->heureHorsProd + $arrayDate[$arr['date_deb_ldt']]->heureProd)), 2);
					$arrayDate[$arr['date_deb_ldt']]->vNette = sprintf("%d", ($arrayDate[$arr['date_deb_ldt']]->Qte / ($arrayDate[$arr['date_deb_ldt']]->heureProd)), 2);
				}
			}
			else $arrayDate[$arr['date_deb_ldt']] = new OperateurTemps($arr['date_deb_ldt'], $somme, 0, $arr['qte']);
		}
		return $arrayDate;
	}

    function suiviHeureOP_($intervalle, $dossier, $departement) {
        // selection OP
        // somme heure op pendant la periode
        // ajout dossier si possible</div>

        set_time_limit(30000);
        $tk = explode(",", $intervalle);
        $filtreIntervaleTemps = " where p_ldt.date_deb_ldt = '" . $intervalle . "'";
        if (count($tk) > 1)
            $filtreIntervaleTemps = " where p_ldt.date_deb_ldt >=  '" . $tk[0] . "' AND p_ldt.date_deb_ldt <= '" . $tk[1] . "'";

        $filtreDepartement = ($departement == "" ? "" : " WHERE id_departement = '" . $departement . "'");

        $sqlDoss = "SELECT id_pers FROM r_personnel " . $filtreDepartement . " order by id_pers";

        $ii = 0;
        $str = "<table >";
        $rsDoss = $this->cnx->query($sqlDoss);

        while ($arr = $rsDoss->fetch()) {
            if ($ii >= 3)
                $ii = 0;
            $cl = 'classe' . $ii;
            $ii++;

            $somme = $this->ToHeureDecimal($this->nombreHeureOP($intervalle, $arr['id_pers'], $dossier));
            if ($somme == '0,00')
                continue;
            $str .= "<tr class = $cl>";
            $str .= "<td id='$" . $arr['id_pers'] . '|' . $somme . "'>" . $intervalle . "</td>";
            $str .= "<td>" . $arr['id_pers'] . "</td>";
            $str .= "<td>" . $somme . "</td>";
            $str .= "</tr>";
        }

        $str .= "</table>";

        return $str;
    }

    // DEBUT	Gestion lot et ligne de temps

    function nextLotDispo($doss, $oper) {
        /* chargement lot en cours pour l'utilisateur courant
          si pas de lot en cours
          Chargement lot dispo
         */
        $rez = $this->lotEnCours($_SESSION['id']);
        if ($rez == "") {
            $sql = "SELECT p_lot.id_lot, p_lot.libelle FROM p_lot
			LEFT JOIN p_lot_client ON p_lot.id_lotclient=p_lot_client.id_lotclient
			WHERE p_lot_client.id_dossier=$doss AND p_lot.id_etape=$oper AND p_lot.id_etat=0 order by priority ASC";

            //return $sql;
            $rs = $this->cnx->query($sql);
            $str = '';
            while ($arr = $rs->fetch()) {
                $idLot = $arr['id_lot'];
                $libLot = $arr['libelle'];
                $str .= "<option value='$idLot'>$libLot</option>";
                $this->updateLot($idLot, '1', "");
                return $str;
            }
            return $str;
        }
        return $rez;
    }

    function initialisation($mat) {
        $rs = $this->cnx->exec("update p_logon set connected=false  where id_pers=$mat");
        return "update p_logon set connected=false  where id_pers=$mat";
    }

    function getLDW($doss, $oper) {
        //return $this->nextLotDispo($doss, $oper);
        $rez = $this->lotEnCours($_SESSION['id']);
        if ($rez != "")
            return $rez;
        $sql = "SELECT p_lot.id_lot, p_lot.libelle FROM p_lot
		LEFT JOIN p_lot_client ON p_lot.id_lotclient=p_lot_client.id_lotclient
		WHERE p_lot_client.id_lotclient=$doss AND p_lot.id_etape=$oper AND p_lot.id_etat=0 order by priority ASC";

        //return $sql;
        $rs = $this->cnx->query($sql);
        $str = '<option value="_"> </option>';
        while ($arr = $rs->fetch()) {
            $str .= '<option value="' . $arr['id_lot'] . '">' . $arr['libelle'] . '</option>';
        }
        return $str;
    }

    function lotEnCours($idPers) {
        $sql = "SELECT p_lot.id_lot, p_lot.libelle FROM p_lot WHERE id_pers = $idPers AND id_etat = 1";

        //return $sql;
        $rs = $this->cnx->query($sql);
        $str = "";
        while ($arr = $rs->fetch()) {
            $str .= '<option value="' . $arr['id_lot'] . '">' . $arr['libelle'] . '</option>';
            return $str;
        }
        return $str;
    }

    // FIN Gestion lot


    function insertConsigne($doss, $etap, $url) {
        $url = substr($url, 2, strlen($url));
        $sql = "INSERT INTO p_consigne (id_dossier, id_etape, url) values ($doss, $etap, '$url')";
        //return $sql;
        if ($this->cnx->exec($sql)) {
            return $this->getLstConsigne($doss, $etap);
        }
    }

    function getLstConsigne($idDossier, $idEtape) {
        $sql = "SELECT id, url from p_consigne where id_dossier = $idDossier";

        if ($idEtape != "")
            $sql .=" AND id_etape = $idEtape";

        $sql .= ' order by id DESC';

        $rs = $this->cnx->query($sql);

        $str = "<table>";

        foreach ($rs as $row) {
            if ($_SESSION['id_droit'] == 1)
                return $row['url'];

            $tk = explode("/", $row['url']);
            $str .= "<tr><td><a href='" . $row['url'] . "' class='consigne'>" . $tk[count($tk) - 1] . "</a><hr/></td>";
            if ($_SESSION['id_droit'] != 1)
                $str .= "<td OnClick=deleteConsigne('" . $row['id'] . "') class='delete'></td>";
            $str .= "</tr>";
        }
        $str .= "</table>";

        if ($_SESSION['id_droit'] == 1)
            return "aucun.htm";
        return $str;
    }

    function getInfo2($idPers) {
        $currDate = date("Ymd");
        $sql = "SELECT p_ldt.id_ldt, p_ldt.id_dossier, p_ldt.date_deb_ldt,p_ldt.date_fin_ldt, r_personnel.appelation, r_personnel.matricule, p_dossier.num_dossier,p_etape.libelle as lib, p_ldt.commentaire, p_type_ldt.libelle as type, p_ldt.h_deb, p_ldt.h_fin, p_ldt.quantite, p_ldt.address_ip, p_ldt.nbre_erreur, p_etat.libelle as statu FROM p_ldt
			LEFT JOIN p_dossier ON p_ldt.id_dossier=p_dossier.id_dossier
			LEFT JOIN p_lot_client ON p_ldt.id_lotclient=p_lot_client.id_lotclient
			LEFT JOIN p_lien_oper_dossier ON p_ldt.id_etape=p_lien_oper_dossier.id_lien
			LEFT JOIN p_etape ON p_lien_oper_dossier.id_oper=p_etape.id_etape
			LEFT JOIN p_etat ON p_ldt.id_etat=p_etat.id_etat
			LEFT JOIN p_type_ldt on p_type_ldt.id_type_ldt = p_ldt.id_type_ldt
			LEFT JOIN r_personnel ON r_personnel.id_pers=p_ldt.id_pers WHERE  p_ldt.id_pers = $idPers And date_deb_ldt = '$currDate' order by h_deb desc limit 1";
        //return $sql;
        $rs = $this->cnx->query($sql);
        $str = "<table><tr><td></td><td>$idPers</td></tr>";
        foreach ($rs as $row) {
            $str .= "<tr><td></td><td>" . $row['num_dossier'] . "</td></tr>";
            $str .= "<tr><td></td><td>" . $row['h_deb'] . "</td></tr>";
            $str .= "<tr><td></td><td>" . $row['h_fin'] . "</td></tr>";

            $str .= "<tr><td></td><td>" . $row['lib'] . "</td></tr>";
            $str .= "<tr><td></td><td><span class='duration'>Il y a: " . $this->hDiff($row['h_deb'], date("H:i:s"), "") . "</span></td></tr>";
            $str .= "<tr><td></td><td>" . $row['address_ip'] . "</td></tr></table>";

            return "$str";
        }
        return $str . "</table>";
    }

    function getInfo_($idPers, $dossier) {
        $currDate = date("Ymd");
        $sql = "SELECT p_ldt.id_ldt, p_ldt.id_dossier, p_ldt.date_deb_ldt,p_ldt.date_fin_ldt, r_personnel.appelation, r_personnel.matricule, p_dossier.num_dossier,p_etape.libelle as lib, p_ldt.commentaire, p_type_ldt.libelle as type, p_ldt.h_deb, p_ldt.h_fin, p_ldt.quantite, p_ldt.address_ip, p_ldt.nbre_erreur, p_etat.libelle as statu FROM p_ldt
			LEFT JOIN p_dossier ON p_ldt.id_dossier=p_dossier.id_dossier
			LEFT JOIN p_lot_client ON p_ldt.id_lotclient=p_lot_client.id_lotclient
			LEFT JOIN p_lien_oper_dossier ON p_ldt.id_etape=p_lien_oper_dossier.id_lien
			LEFT JOIN p_etape ON p_lien_oper_dossier.id_oper=p_etape.id_etape
			LEFT JOIN p_etat ON p_ldt.id_etat=p_etat.id_etat
			LEFT JOIN p_type_ldt on p_type_ldt.id_type_ldt = p_ldt.id_type_ldt
			LEFT JOIN r_personnel ON r_personnel.id_pers=p_ldt.id_pers WHERE date_deb_ldt = '$currDate' AND  p_ldt.id_pers = $idPers";
        if ($dossier != "")
            $sql .= " AND p_ldt.id_dossier= $dossier ";
        $sql .= "order by h_deb desc limit 1";

        //return $sql;
        $rs = $this->cnx->query($sql);
        $str = "<table><tr><td></td><td>$idPers</td></tr>";
        foreach ($rs as $row) {
            $str .= "<tr><td></td><td>" . $row['num_dossier'] . "</td></tr>";
            $str .= "<tr><td></td><td>" . $row['h_deb'] . "</td></tr>";
            $str .= "<tr><td></td><td>" . $row['h_fin'] . "</td></tr>";

            $str .= "<tr><td></td><td>" . $row['lib'] . $row['type'] . "</td></tr>";
            $str .= "<tr><td></td><td><span class='duration'>Il y a: " . $this->hDiff($row['h_deb'], date("H:i:s"), "") . "</span></td></tr>";
            $str .= "<tr><td></td><td>" . $row['address_ip'] . "</td></tr></table>";

            return "$str";
        }
        return $str . "</table>";
    }

    function getInfo($idPers, $dossier) {
        $currDate = date("Ymd");
        $sql = "SELECT p_ldt.id_ldt, p_ldt.id_dossier, p_ldt.date_deb_ldt,p_ldt.date_fin_ldt, r_personnel.appelation, r_personnel.matricule, p_dossier.num_dossier,p_etape.libelle as lib, p_ldt.commentaire, p_type_ldt.libelle as type, p_ldt.h_deb, p_ldt.h_fin, p_ldt.quantite, p_ldt.address_ip, p_ldt.nbre_erreur, p_etat.libelle as statu FROM p_ldt
			LEFT JOIN p_dossier ON p_ldt.id_dossier=p_dossier.id_dossier
			LEFT JOIN p_lot_client ON p_ldt.id_lotclient=p_lot_client.id_lotclient
			LEFT JOIN p_lien_oper_dossier ON p_ldt.id_etape=p_lien_oper_dossier.id_lien
			LEFT JOIN p_etape ON p_lien_oper_dossier.id_oper=p_etape.id_etape
			LEFT JOIN p_etat ON p_ldt.id_etat=p_etat.id_etat
			LEFT JOIN p_type_ldt on p_type_ldt.id_type_ldt = p_ldt.id_type_ldt
			LEFT JOIN r_personnel ON r_personnel.id_pers=p_ldt.id_pers WHERE date_deb_ldt = '$currDate' AND  p_ldt.id_pers = $idPers";
        if ($dossier != "")
            $sql .= " AND p_ldt.id_dossier= $dossier ";
        $sql .= "order by h_deb desc limit 1";

        //return $sql;
        $rs = $this->cnx->query($sql);
        $str = "";
        foreach ($rs as $row) {
            //$str .= "<td><span class='duration'>Il y a: ".$this->hDiff($row['h_deb'], date("H:i:s"), "")."</span></td><td>".$row['address_ip']."</td></tr>";
            return "<td>" . $row['num_dossier'] . "</td><td>" . $row['lib'] . $row['type'] . "</td><td>" . $row['h_deb'] . "</td>";
        }
        return "<tr><td>$idPers</td><td></td><td></td><td></td><td></td></tr>";
    }

    function MapMacID() {

        $sql = "SELECT  id, mac from r_listemachine where length(mac) > 5";
        /*
          Array $rs=$this->cnx->query($sql);

          return $rs;
         */
    }

    function GetConnectedMac() {
        $sql = "SELECT  p_ldt.h_deb, p_ldt.h_fin, r_personnel.appelation, r_personnel.id_droit  FROM p_ldt
		INNER JOIN r_personnel ON p_ldt.id_pers = r_personnel.id_pers
		WHERE  mac = '$mac' AND date_deb_ldt = '$currDate' order by h_deb desc limit 1";

        $sql = "select max(id_ldt), mac from p_ldt where date_deb_ldt = '20140115' group by mac order by mac";

        $rs = $this->cnx->query($sql);
        $str = "<table><tr><td></td><td>$idPers</td></tr>";
        foreach ($rs as $row) {
            $str .= "<tr><td></td><td>" . $row['num_dossier'] . "</td></tr>";
            $str .= "<tr><td></td><td>" . $row['h_deb'] . "</td></tr>";
            $str .= "<tr><td></td><td>" . $row['h_fin'] . "</td></tr>";

            $str .= "<tr><td></td><td>" . $row['lib'] . "</td></tr>";
            $str .= "<tr><td></td><td><span class='duration'>Il y a: " . $this->hDiff($row['h_deb'], date("H:i:s"), "") . "</span></td></tr>";
            $str .= "<tr><td></td><td>" . $row['address_ip'] . "</td></tr></table>";

            return "$str";
        }
        return $str . "</table>";
    }

    function ScopeInfoMachine() {
        $currDate = date("Ymd");

        $sql = "select mac from r_listemachine where length(mac) > 5";
        $rs = $this->cnx->query($sql);
        $str = "";
        while ($arr = $rs->fetch()) {
            $str = $arr['mac'];


            $sql = "SELECT  p_ldt.h_deb, p_ldt.h_fin, r_personnel.appelation, r_personnel.id_droit, p_dossier.num_dossier,p_etape.libelle as lib, r_droit.libelle as libdroit,r_departement.libelle as departement  FROM p_ldt
			INNER JOIN r_personnel ON p_ldt.id_pers = r_personnel.id_pers
			LEFT JOIN p_dossier ON p_ldt.id_dossier=p_dossier.id_dossier
			LEFT JOIN p_lien_oper_dossier ON p_ldt.id_etape=p_lien_oper_dossier.id_lien
			LEFT JOIN p_etape ON p_lien_oper_dossier.id_oper=p_etape.id_etape
			LEFT JOIN r_droit ON r_personnel.id_droit=r_droit.id_droit
			LEFT JOIN r_departement on r_departement.id = r_personnel.id_departement
			WHERE  mac = '$str' AND date_deb_ldt = '$currDate' order by h_deb desc limit 1";


            $rs = $this->cnx->query($sql);
            $str = "";
            $etat = 'normal';

            foreach ($rs as $row) {
                $diff;
                if ($row['h_fin'] != "") {
                    $connected = true;
                    $etat = 'deconnected';
                    $sqlIsOut = "SELECT entree from r_pointage where pdate = '" . date("Y/m/d") . "' AND source like 'OUT%' order by entree limit 1";
                    $rs1 = $this->cnx->query($sqlIsOut);
                    foreach ($rs1 as $row1) {
                        if ($row1['entree'] > $row['h_fin'])
                            $etat = 'error';
                        break;
                    }
                    $diff = $this->hDiff($row['h_fin'], date("H:i:s"), "");
                }
                else {
                    $diff = $this->hDiff($row['h_deb'], date("H:i:s"), "");
                    $tk = explode(":", $diff);
                    if ($tk[0] > 1)
                        $etat = 'anomalie';
                }

                if ($row['id_droit'] != '1')
                    $str .="<div class='red_case occuped'><div class='etat $etat'><span>" . $row['appelation'] . "</span></div>";
                else
                    $str .="<div class='blue_case occuped'><div class='etat $etat'><span>" . $row['appelation'] . "</span></div>";

                $str .= "<table><tr><td>" . $row['libdroit'] . ' - ' . $row['departement'] . "</td></tr><tr><td>" . $row['num_dossier'] . " | $diff </td></tr><tr><td>" . $row['lib'] . "</td></tr></table>";
                return "$str</div>";
            }
        }
        return $str . "";
    }

    function getStatutIP($mac) {
        $currDate = date("Ymd");

        $sql = "select mac from r_listemachine where id = $mac";
        $rs = $this->cnx->query($sql);
        $str = "";
        while ($arr = $rs->fetch()) {
            $str = $arr['mac'];
            //return $str;
        }

        $sql = "SELECT p_ldt.id_pers,   p_ldt.h_deb, p_ldt.h_fin, r_personnel.appelation, r_personnel.id_droit, p_dossier.num_dossier,p_etape.libelle as lib, r_droit.libelle as libdroit,r_departement.libelle as departement  FROM p_ldt
		INNER JOIN r_personnel ON p_ldt.id_pers = r_personnel.id_pers
		LEFT JOIN p_dossier ON p_ldt.id_dossier=p_dossier.id_dossier
		LEFT JOIN p_lien_oper_dossier ON p_ldt.id_etape=p_lien_oper_dossier.id_lien
		LEFT JOIN p_etape ON p_lien_oper_dossier.id_oper=p_etape.id_etape
		LEFT JOIN r_droit ON r_personnel.id_droit=r_droit.id_droit
		LEFT JOIN r_departement on r_departement.id = r_personnel.id_departement
		WHERE  mac = '$str' AND date_deb_ldt = '$currDate' order by h_deb desc limit 1";


        $rs = $this->cnx->query($sql);
        $str = "";
        $etat = 'normal';

        foreach ($rs as $row) {
            $diff;
            if ($row['h_fin'] != "") {
                $connected = true;
                $etat = 'deconnected';
                $sqlIsOut = "SELECT entree from r_pointage where pdate = '" . date("Y/m/d") . "' AND source like 'OUT%' order by entree limit 1";
                $rs1 = $this->cnx->query($sqlIsOut);
                foreach ($rs1 as $row1) {
                    if ($row1['entree'] > $row['h_fin'])
                        $etat = 'error';
                    break;
                }
                $diff = $this->hDiff($row['h_fin'], date("H:i:s"), "");
            }
            else {
                $diff = $this->hDiff($row['h_deb'], date("H:i:s"), "");
                $tk = explode(":", $diff);
                if ($tk[0] > 1)
                    $etat = 'anomalie';
            }

            if ($row['id_droit'] != '1')
                $str .="<div class='red_case occuped'><div class='etat $etat'><span>" . $row['appelation'] . "</span></div>";
            else
                $str .="<div class='blue_case occuped'><div class='etat $etat'><span>" . $row['appelation'] . "</span></div>";

            $str .= "<table><tr><td>" . $row['libdroit'] . ' - ' . $row['departement'] . "</td></tr><tr><td>" . $row['num_dossier'] . " | $diff </td></tr><tr><td>" . $row['lib'] . "</td></tr></table>";
            return "$str</div>";
        }
        return $str . "";
    }

    // generation dinamique des directives pour le plan 2D
    function echoS($s) {

        echo '

		<input data-ng-init="' . $s . '=\'' . $s . '\'" type="text" data-ng-model="' . $s . '"/>
		<div class ="{{cust.etat}}" data-ng-repeat="cust in gpao  | filter:' . $s . '">

		<div class=\'s{{cust.id_droit}}\' occuped\'>
		<table border="1px"><tr  class=\'{{cust.etat}}\'><td class=\'{{cust.etat}}\'>{{cust.appelation}} - {{cust.id_pers}}</td></tr>

		<tr><td>{{cust.departement}}&nbsp;</td></tr>
		<tr><td>{{cust.num_dossier}}</td></tr>

		<tr><td  class="mintd {{cust.typeEtape}}">{{cust.lib}}&nbsp;</td></tr>
		<tr><td>{{cust.diff}}</td></tr>
		<tr><td>Deb:{{cust.h_deb}}</td></tr>
		<tr><td>Fin:{{cust.h_fin}}</td></tr>
		<tr><td>::{{cust.address_ip}}</td></tr>

		</table>
		</div>
		</div>';
    }

    function getInfo_save($idPers) {
        $currDate = date("Ymd");
        $sql = "SELECT p_ldt.id_ldt, p_ldt.id_dossier, p_ldt.date_deb_ldt,p_ldt.date_fin_ldt, r_personnel.appelation, r_personnel.matricule, p_dossier.num_dossier,p_etape.libelle as lib, p_ldt.commentaire, p_type_ldt.libelle as type, p_ldt.h_deb, p_ldt.h_fin, p_ldt.quantite, p_ldt.address_ip, p_ldt.nbre_erreur, p_etat.libelle as statu FROM p_ldt
			LEFT JOIN p_dossier ON p_ldt.id_dossier=p_dossier.id_dossier
			LEFT JOIN p_lot_client ON p_ldt.id_lotclient=p_lot_client.id_lotclient
			LEFT JOIN p_lien_oper_dossier ON p_ldt.id_etape=p_lien_oper_dossier.id_lien
			LEFT JOIN p_etape ON p_lien_oper_dossier.id_oper=p_etape.id_etape
			LEFT JOIN p_etat ON p_ldt.id_etat=p_etat.id_etat
			LEFT JOIN p_type_ldt on p_type_ldt.id_type_ldt = p_ldt.id_type_ldt
			LEFT JOIN r_personnel ON r_personnel.id_pers=p_ldt.id_pers WHERE  p_ldt.id_pers = $idPers And date_deb_ldt = '$currDate' order by h_deb desc";
        //return $sql;
        $rs = $this->cnx->query($sql);
        $str = "<table><tr><td></td><td>$idPers</td></tr>";
        foreach ($rs as $row) {

            $str .= "<tr><td></td><td>" . $row['h_deb'] . "</td></tr>";
            $str .= "<tr><td></td><td>" . $row['h_fin'] . "</td></tr>";
            $str .= "<tr><td></td><td><h2>" . $row['num_dossier'] . "</h2></td></tr>";
            $str .= "<tr><td></td><td>" . $row['lib'] . "</td></tr>";
            $str .= "<tr><td></td><td>" . $row['address_ip'] . "</td></tr></table>";
            return "$str";
        }
        return $str . "</table>";
    }

    function getInfoIP($mac) {
        $currDate = date("Ymd");
        $sql = "SELECT p_ldt.id_ldt, p_ldt.id_dossier, p_ldt.date_deb_ldt,p_ldt.date_fin_ldt, r_personnel.nom, r_personnel.prenom, r_personnel.appelation, r_personnel.matricule, p_dossier.num_dossier,p_etape.libelle as lib, p_ldt.commentaire, p_type_ldt.libelle as type, p_ldt.h_deb, p_ldt.h_fin, p_ldt.quantite, p_ldt.address_ip, p_ldt.nbre_erreur, p_etat.libelle as statu, r_departement.libelle as departement FROM p_ldt
			LEFT JOIN p_dossier ON p_ldt.id_dossier=p_dossier.id_dossier
			LEFT JOIN p_lot_client ON p_ldt.id_lotclient=p_lot_client.id_lotclient
			LEFT JOIN p_lien_oper_dossier ON p_ldt.id_etape=p_lien_oper_dossier.id_lien
			LEFT JOIN p_etape ON p_lien_oper_dossier.id_oper=p_etape.id_etape
			LEFT JOIN p_etat ON p_ldt.id_etat=p_etat.id_etat
			LEFT JOIN p_type_ldt on p_type_ldt.id_type_ldt = p_ldt.id_type_ldt
			LEFT JOIN r_personnel ON r_personnel.id_pers=p_ldt.id_pers
			LEFT JOIN r_departement on r_departement.id = r_personnel.id_departement
			WHERE  p_ldt.mac = '$mac' And date_deb_ldt = '$currDate' order by h_deb desc limit 1";
        //return $sql;
        $rs = $this->cnx->query($sql);
        $str = "";
        foreach ($rs as $row) {
            $str .= "<table><tr><td>Appelation</td><td>" . $row['appelation'] . "</td></tr>";
            $str .= "<tr><td>Nom</td><td>" . $row['nom'] . "</td></tr>";
            $str .= "<tr><td>Prenom</td><td>" . $row['prenom'] . "</td></tr>";
            $str .= "<tr><td>Departement</td><td>" . $row['departement'] . "</td></tr>";
            $str .= "<tr><td>Matricule</td><td>" . $row['matricule'] . "</td></tr>";
            $str .= "<tr><td>Dossier</td><td>" . $row['num_dossier'] . "</td></tr>";
            $str .= "<tr><td>Heure Debut</td><td>" . $row['h_deb'] . "</td></tr>";
            $str .= "<tr><td>Heure Fin</td><td>" . $row['h_fin'] . "</td></tr>";

            $str .= "<tr><td>Tache</td><td>" . $row['lib'] . "</td></tr>";
            $str .= "<tr><td>Il y a</td><td><span class='duration'>" . $this->hDiff($row['h_deb'], date("H:i:s"), "") . "</span></td></tr>";
            $str .= "<tr><td>IP</td><td>" . $row['address_ip'] . "</td></tr>";
            $str .= "<tr><td>MAC</td><td>$mac</td></tr></table>";


            return "$str";
        }
        return $str . "</table>";
    }

    function getLstMat() {
        $sql = "select id_pers, matricule from r_personnel order by id_pers";
        $rs = $this->cnx->query($sql);
        $str = "";
        while ($arr = $rs->fetch()) {
            $str .= '<option value="' . $arr['id_pers'] . '">' . $arr['id_pers'] . '</option>';
        }

        return $str;
    }

    function getListConnected($dossier, $departement) {
        $currDate = date("Y/m/d");
        //return $currDate;
        $batiment = 'IN';

        $sql = "SELECT distinct(id_util) from r_pointage where pdate='" . $currDate . "' order by id_util";

        if ($departement != "") {
            $sql = "SELECT r_personnel.id_pers as id_util, appelation FROM r_personnel
				LEFT JOIN r_affectation ON r_affectation.id_pers = r_personnel.id_pers
				LEFT JOIN r_departement ON r_affectation.id_departement = r_departement.id  WHERE  r_departement.id = " . $departement . " AND actif = true order by r_personnel.id_pers";
        }

        if ($dossier != "" & $departement == "") {
            $sql = "SELECT distinct(r_personnel.id_pers) as id_util, appelation FROM r_personnel
				LEFT JOIN p_affectation ON p_affectation.id_pers = r_personnel.id_pers
				WHERE actif = true AND p_affectation.id_dossier = " . $dossier . " order by r_personnel.id_pers";
        }

        $folder = '../CSV/' . $_SESSION['id'];
        $this->clearDir($folder);
        if (!is_dir($folder))
            mkdir($folder, 0755, true);
        $fName = $folder . '/ETAT_OP_' . date("Ymd") . '_' . $dossier . $departement . '.csv';
        $fw = fopen($fName, 'w');

        $row = "MATRICULE\tNOM\tDOSSIER\tETAPE\tDEBUT\n";
        fwrite($fw, $row);

        $strCsv = "";

        $rs = $this->cnx->query($sql);
        $str = "<br /><table class='table'>
		<tr>
		<th id='date_deb_ldt' class='th'>MATRICULE</td>
		<th id='date_deb_ldt'>NOM</td>
		<th id='date_deb_ldt'>DOSSIER</th>
		<th id='date_fin_ldt'>ETAPE</th>
		<th id='appelation'>tDebut</th>
		<th id='matricule'></th></tr>";

        $i = 0;
        $nb = 0;
        $rows = "";

        foreach ($rs as $row) {
            if ($row['id_util'] == '0')
                continue;

            $etat = $this->getEtat($row['id_util']);
            if ($i > 3)
                $i = 0;
            switch ($etat) {
                case "-1":
                    $rows .= "<tr class='classe$i'><td>" . $row['id_util'] . "</td><td>" . $row['appelation'] . "</td><td>non connect&eacute;</td><td></td><td></td><td></td></tr>";
                    break;
                case "0":
                    $rows .= "<tr class='classe$i'><td>" . $row['id_util'] . "</td><td>" . $row['appelation'] . "</td>" . $this->getInfo($row['id_util'], $dossier) . "</tr>";
                    break;
                case "1":
                    $rows .= "<tr class='classe$i'><td>" . $row['id_util'] . "</td><td>" . $row['appelation'] . "</td>" . $this->getInfo($row['id_util'], $dossier) . "</tr>";
                    break;
                case "2":
                    $rows .= "<tr class='classe$i'><td>" . $row['id_util'] . "</td><td>" . $row['appelation'] . "</td>" . $this->getInfo($row['id_util'], $dossier) . "</tr>";
                    break;
                case "3":
                    $rows .= "<tr class='classe$i'><td>" . $row['id_util'] . "</td><td>" . $row['appelation'] . "</td>" . $this->getInfo($row['id_util'], $dossier) . "</tr>";
                    break;
                default:
                    $rows .= "<tr class='classe$i'><td>" . $row['id_util'] . "</td><td>" . $row['appelation'] . "</td><td>SORTIE</td><td>POINTAGE BIO</td><td>" . $etat . "</td><td></td></tr>";
            }

            $i++;
            $nb++;
        }
        $strCsv = preg_replace('@</td><td>@', "\t", $rows);
        $strCsv = preg_replace('@<tr class=\'classe[0-9]\'><td>@', '', $strCsv);
        $strCsv = preg_replace('@</td></tr>@', "\r\n", $strCsv);

        fwrite($fw, $strCsv);
        $str .= $rows . "</table>";
        fclose($fw);

        $str = "</table><table><tr><td><h4>Found: $nb</h4></td><td><a href='./CSV/$fName' OnClick=deleteReport('" . $_SESSION['id'] . "')><input type='submit' value='' class='copy' title='Exporter au format CSV'/></a></td></tr></table>" . $str;

        return $str;
    }

    function getEtat($idPers) {
        $currDate = date("Ymd");
        $sql = "SELECT h_deb as deb, h_fin from p_ldt where id_pers = $idPers And date_deb_ldt = '$currDate' order by id_ldt desc";
        $rs = $this->cnx->query($sql);
        foreach ($rs as $row) {
            // Verifie si l'utilisateur a une sortie dans pointage
            $sqlIsOut = "SELECT entree, source from r_pointage where id_util = " . $idPers . " AND pdate = '" . date("Y/m/d") . "' AND source like 'OUT%' order by entree DESC limit 1";
            $rs1 = $this->cnx->query($sqlIsOut);
            foreach ($rs1 as $row1) {
                $temps = $row['h_fin'] != '' ? $row['h_fin'] : $row['deb'];
                //if ($row1['entree'] > $temps  ) return  $row['h_fin'].' '.$row1['source'].' '.$row1['entree'];
                if ($row1['entree'] > $temps)
                    return $row1['entree'];
            }

            $currTime = date("H:i:s");
            $currTime = $this->hDiff($currTime, '00:05:00', "+");
            $diff = $this->hDiff($row['deb'], $currTime, "");

            $tokens = explode(":", $diff);

            $h = $tokens[0];
            $m = $tokens[1];

            if ($row['h_fin'] == "") {
                if ($h > 1)
                    return '2';
                if ($h > 0)
                    return '1';
                if ($h == 0)
                    return '3';
                return 0;
            } else
                return '0';
        }
        return -1;
    }

    function ToHeureDecimal($strTime) {
        $h = explode(":", $strTime);
        return number_format($h[0] + ($h[1] / 60), 4, ',', '.');
    }

    function ToSeconde($strTime) {
        $h = explode(":", $strTime);
        return ($h[0] * 3600) + ($h[1] * 60) + $h[2];
    }

    function dDiff($deb, $fin) {
        $datetime1 = strtotime($deb);
        $datetime2 = strtotime($fin);
        $interval = abs($datetime2 - $datetime1);
        $minutes = round($interval / 60);
        echo 'Diff. in minutes is: ' . $minutes;
    }

    function hDiff($t1, $t2, $oper) {
        // difference heure hH:im:ss
        $h = explode(":", $t1);
        $m = explode(":", $t2);

        $h1 = $h[0];
        $h2 = $m[0];
        $m1 = $h[1];
        $m2 = $m[1];
        $s1 = $h[2];
        $s2 = $m[2];

        if ($oper == "+")
            $ret = (($h2 * 3600) + ($m2 * 60) + ($s2)) + (($h1 * 3600) + ($m1 * 60) + ($s1));
        else
            $ret = (($h2 * 3600) + ($m2 * 60) + ($s2)) - (($h1 * 3600) + ($m1 * 60) + ($s1));

        $h = floor($ret / 3600);
        $m = floor(($ret - ($h * 3600)) / 60);
        $s = ($ret - ($h * 3600)) - $m * 60;

        return $h . ':' . $m . ':' . $s;
    }

    function deleteLdt($p_id_ldt) {
        $rs = $this->cnx->exec("delete from p_ldt where id_ldt=$p_id_ldt");
    }

    function deleteLot($idLot) {
        $rs = $this->cnx->exec("delete from p_lot where id_lot=$idLot");
    }

    function delConsigne($p_id_ldt) {
        $sql = "SELECT url from p_consigne where id = $p_id_ldt";
        $rs = $this->cnx->query($sql);
        $url = "";

        foreach ($rs as $row) {
            $url = $row['url'];
        }
        $sql = "delete from p_consigne where id=$p_id_ldt";
        $rs = $this->cnx->exec($sql);

        $filename = $_SERVER['DOCUMENT_ROOT'] . "$/" . $url;
        //return $filename;
        unlink($filename);
    }

    function updateLot($lstId, $etat, $prio, $mat) {
        $filtre = "";
        $sql = "update p_lot set duree=".$_SESSION['id'].",  id_pers =" . $_SESSION['id'];
        if ($mat != "")
            $sql = "update p_lot set duree=".$_SESSION['id'].",  id_pers =$mat";
        if ($etat != "")
            $filtre .= ", id_etat = $etat";
        if ($prio != "")
            $filtre .= ", priority = $prio";

        $sql .= $filtre . " where id_lot IN ($lstId)";
        //return " id_etat = $etat"." priority = $prio";
        $rs = $this->cnx->exec($sql);
    }

    function updateLdt($deb, $fin, $qt, $err, $stat, $id, $dDeb, $dFin, $com) {
        $sql = "UPDATE p_ldt SET h_deb='" . $deb . "'";

        $sql .= ", h_fin='" . $fin . "'";
        $sql .= ", quantite='" . $qt . "'";
        $sql .= ", nbre_erreur='" . $err . "'";
        $sql .= ", date_deb_ldt='" . $dDeb . "'";
        $sql .= ", date_fin_ldt='" . $dFin . "'";
        $sql .= ", machine='" . $com . "'";
        if ($stat != "")
            $sql .= ", id_etat=" . $stat;
        $sql .= " WHERE id_ldt=" . $id;
        //return $sql;
        $rs = $this->cnx->exec($sql);
    }

    function getOneLdt($id) {
        // recherche
        $sql = "SELECT p_ldt.id_ldt, p_ldt.id_dossier, p_ldt.date_deb_ldt,p_ldt.date_fin_ldt, r_personnel.appelation, r_personnel.matricule, p_dossier.num_dossier,p_etape.libelle as lib, p_ldt.commentaire, p_type_ldt.libelle as type, p_ldt.h_deb, p_ldt.h_fin, p_ldt.quantite, p_ldt.nbre_erreur, p_etat.libelle as statu, p_ldt.machine FROM p_ldt
			LEFT JOIN p_dossier ON p_ldt.id_dossier=p_dossier.id_dossier
			LEFT JOIN p_lot_client ON p_ldt.id_lotclient=p_lot_client.id_lotclient
			LEFT JOIN p_lien_oper_dossier ON p_ldt.id_etape=p_lien_oper_dossier.id_lien
			LEFT JOIN p_etape ON p_lien_oper_dossier.id_oper=p_etape.id_etape
			LEFT JOIN p_etat ON p_ldt.id_etat=p_etat.id_etat
			LEFT JOIN p_type_ldt on p_type_ldt.id_type_ldt = p_ldt.id_type_ldt
			LEFT JOIN r_personnel ON r_personnel.id_pers=p_ldt.id_pers WHERE p_ldt.id_ldt= " . $id;

        $rs = $this->cnx->query($sql);
        foreach ($rs as $row) {
            $str = $row['num_dossier'] . "|" . $row['lib'] . "|" . $row['h_deb'] . "|" . $row['h_fin'] . "|" . $row['quantite'] . "|" . $row['nbre_erreur'] . "|" . $row['statu'] . "|" . $row['matricule'] . "|" . $row['id_dossier'] . "|" . $row['date_deb_ldt'] . "|" . $row['date_fin_ldt'] . "|" . $row['machine'];
            return $str;
        }
        return "";
    }

    function TempsParDossierEtape($dossier, $etape, $lstPeriode, $matricule, $statut, $orderby, $dep) {
        $filtre = "";
        if ($lstPeriode != "") {
            $filtre = " AND p_ldt.date_deb_ldt = '" . $lstPeriode . "'";

            $tk = explode(",", $lstPeriode);
            if (count($tk) > 1) {
                $lstPeriode = str_replace($lstPeriode, ",", "_");
                $filtre = " AND p_ldt.date_deb_ldt >=  '" . $tk[0] . "' AND p_ldt.date_deb_ldt <= '" . $tk[1] . "'";
            }
        }
        //return $lstPeriode;
        if ($dep != "")
            $filtre .= " AND r_personnel.id_departement = $dep";
        if ($dossier != "")
            $filtre .= " AND p_ldt.id_dossier = $dossier";
        if ($matricule != "")
            $filtre .= " AND p_ldt.id_pers = $matricule";

        $sql = "SELECT SUM(DATE_PART('epoch', ('2011-12-29 '||h_fin)::timestamp - ('2011-12-29 '||h_deb)::timestamp )) as duree, sum(to_number('0'||quantite,'99999')) as qte, p_dossier.num_dossier as num, p_etape.libelle, p_type_ldt.libelle as lib  from p_ldt
			LEFT JOIN p_dossier ON p_ldt.id_dossier=p_dossier.id_dossier
			LEFT JOIN p_lot_client ON p_ldt.id_lotclient=p_lot_client.id_lotclient
			LEFT JOIN p_lien_oper_dossier ON p_ldt.id_etape=p_lien_oper_dossier.id_lien
			LEFT JOIN p_etape ON p_lien_oper_dossier.id_oper=p_etape.id_etape
			LEFT JOIN p_etat ON p_ldt.id_etat=p_etat.id_etat
			LEFT JOIN p_type_ldt on p_type_ldt.id_type_ldt = p_ldt.id_type_ldt
			LEFT JOIN r_personnel ON r_personnel.id_pers=p_ldt.id_pers
			where 1=1   $filtre group by p_dossier.num_dossier, p_type_ldt.libelle, p_etape.libelle  order by p_dossier.num_dossier, p_etape.libelle, p_type_ldt.libelle";

        $str = "<table width=\"100%\">";
        $ii = 0;

        //return $sql;

        $rs = $this->cnx->query($sql);

        $i = 0;
        $qteTotal = 0;
        $hTotalLdt = 0;
        $totalVitess = 0;
        $lastDossier = '';
        foreach ($rs as $row) {
            $dossier = ($row['num'] == $lastDossier) ? '' : $row['num'];

            if ($row['num'] != $lastDossier) {
                $str .= "</table></tr><tr><table width=\"100%\"><tr class='classe1'>

							<td class='thx'  id='date_fin_ldt'  width=\"30%\"><h3 class='title3'>" . $row['num'] . "</h3></th>
							<td   width=\"10%\"  class='grayLight title3'>Duree</td><td width=\"10%\" class='grayLight title3'>Quantite</td><td class='grayLight title3'>Vitesse</td></tr>";
            } else {
                if ($row['num'] != '')
                    $str .= "";
            }
            $qte = $row['qte'];
            $duree = $row['duree'] / 3600;

            $vitesse = ($qte != 0) ? number_format($qte / $duree, 2) : '';
            $qte = ($qte != 0) ? $qte : '';
            $lastDossier = $row['num'];
            $cl = 'classe' . $ii++;
            $clGray = "";
            $lib = ($row['libelle'] == '') ? "<span  class='gray'>" . $row['lib'] . "</span>" : "" . $row['libelle'] . "";

            if ($row['libelle'] == '') {
                $clGray = " class='gray'";
            }

            if ($ii == 3)
                $ii = 0;

            $str .= "<tr class = $cl id='" . $row['num'] . "' >";
            $str .= "<td>\t$lib</td>";
            $str .= "<td $clGray>" . number_format($duree, 2) . "</td><td>" . $qte . "</td><td>" . $vitesse . "</td></tr>";
        }
        return $str . '</table>';
    }

	function VitesseOP($dossier, $etape, $lstPeriode, $matricule, $statut, $orderby, $dep) {
        $filtre = "";
        if ($lstPeriode != "") {
            $filtre = " AND p_ldt.date_deb_ldt = '" . $lstPeriode . "'";

            $tk = explode(",", $lstPeriode);
            if (count($tk) > 1) {
                $lstPeriode = str_replace($lstPeriode, ",", "_");
                $filtre = " AND p_ldt.date_deb_ldt >=  '" . $tk[0] . "' AND p_ldt.date_deb_ldt <= '" . $tk[1] . "'";
            }
        }
        //return $lstPeriode;
        if ($dep != "")
            $filtre .= " AND r_personnel.id_departement = $dep";
        if ($dossier != "")
            $filtre .= " AND p_ldt.id_dossier = $dossier";
        if ($matricule != "")
            $filtre .= " AND p_ldt.id_pers = $matricule";

        $sql = "SELECT p_ldt.id_pers, SUM(DATE_PART('epoch', ('2011-12-29 '||h_fin)::timestamp - ('2011-12-29 '||h_deb)::timestamp )) as duree, sum(to_number('0'||quantite,'99999')) as qte,
			p_dossier.num_dossier as num, p_etape.libelle, p_type_ldt.libelle as lib
			from p_ldt
			LEFT JOIN p_dossier ON p_ldt.id_dossier=p_dossier.id_dossier
			LEFT JOIN p_lot_client ON p_ldt.id_lotclient=p_lot_client.id_lotclient
			LEFT JOIN p_lien_oper_dossier ON p_ldt.id_etape=p_lien_oper_dossier.id_lien
			LEFT JOIN p_etape ON p_lien_oper_dossier.id_oper=p_etape.id_etape
			LEFT JOIN p_etat ON p_ldt.id_etat=p_etat.id_etat
			LEFT JOIN p_type_ldt on p_type_ldt.id_type_ldt = p_ldt.id_type_ldt
			LEFT JOIN r_personnel ON r_personnel.id_pers=p_ldt.id_pers
			where 1=1 $filtre
			group by p_ldt.id_pers, p_dossier.num_dossier, p_type_ldt.libelle, p_etape.libelle order by  p_ldt.id_pers, p_dossier.num_dossier, p_etape.libelle, p_type_ldt.libelle ";

        $str = "<table width=\"100%\"><tr class='classe1'>

							<td class='thx'  id='date_fin_ldt'  width=\"30%\"><h3 class='title3'>MATRICULE</h3></th>
							<td   width=\"25%\"  class='grayLight title3'>DOSSIER</td><td   width=\"10%\"  class='grayLight title3'>Duree</td><td width=\"10%\" class='grayLight title3'>Quantite</td><td class='grayLight title3'>Vitesse</td></tr>";
        $ii = 0;

        //return $sql;

        $rs = $this->cnx->query($sql);

        $i = 0;
        $qteTotal = 0;
        $hTotalLdt = 0;
        $totalVitess = 0;
        $lastDossier = '';
        foreach ($rs as $row)
		{
            $dossier = ($row['num'] == $lastDossier) ? '' : $row['num'];

            if ($row['num'] != $lastDossier) {
                $str .= "</tr><tr><table width=\"100%\"><tr class='classe1'>

							<td class='thx'  id='date_fin_ldt'  width=\"30%\"><h3 class='title3'>" . $row['id_pers'] . "</h3></th>
							<td   width=\"25%\"  class='grayLight title3'>".$row['num']."</td><td   width=\"10%\"  class='grayLight title3'></td><td width=\"10%\" class='grayLight title3'></td><td class='grayLight title3'></td></tr>";
            } else {
                if ($row['num'] != '')
                    $str .= "";
            }
            $qte = $row['qte'];
            $duree = $row['duree'] / 3600;

            $vitesse = ($qte != 0) ? number_format($qte / $duree, 2) : '';
            $qte = ($qte != 0) ? $qte : '';
            $lastDossier = $row['num'];
            $cl = 'classe' . $ii++;
            $clGray = "";
            $lib = ($row['libelle'] == '') ? "<span  class='gray'>" . $row['lib'] . "</span>" : "" . $row['libelle'] . "";

            if ($row['libelle'] == '') {
                $clGray = " class='gray'";
            }

            if ($ii == 3) $ii = 0;

            $str .= "<tr class = $cl id='" . $row['num'] . "' >";
            $str .= "<td>\t$lib</td>";
            $str .= "<td $clGray></td><td $clGray>" . number_format($duree, 2) . "</td><td $clGray>" . $qte . "</td><td $clGray>" . $vitesse . "</td></tr>";
        }
        return $str . '</table>';
    }

	function VitesseOP_Dossier($dossier, $etape, $lstPeriode, $matricule, $statut, $orderby, $dep) {
        $filtre = "";
        if ($lstPeriode != "") {
            $filtre = " AND p_ldt.date_deb_ldt = '" . $lstPeriode . "'";

            $tk = explode(",", $lstPeriode);
            if (count($tk) > 1) {
                $lstPeriode = str_replace($lstPeriode, ",", "_");
                $filtre = " AND p_ldt.date_deb_ldt >=  '" . $tk[0] . "' AND p_ldt.date_deb_ldt <= '" . $tk[1] . "'";
            }
        }
        //return $lstPeriode;
        if ($dep != "")
            $filtre .= " AND r_personnel.id_departement = $dep";
        if ($dossier != "")
            $filtre .= " AND p_ldt.id_dossier = $dossier";
        if ($matricule != "")
            $filtre .= " AND p_ldt.id_pers = $matricule";

        $sql = "SELECT p_ldt.id_pers, SUM(DATE_PART('epoch', ('2011-12-29 '||h_fin)::timestamp - ('2011-12-29 '||h_deb)::timestamp )) as duree, sum(to_number('0'||quantite,'99999')) as qte,
			p_dossier.num_dossier as num, p_etape.libelle, p_type_ldt.libelle as lib
			from p_ldt
			LEFT JOIN p_dossier ON p_ldt.id_dossier=p_dossier.id_dossier
			LEFT JOIN p_lot_client ON p_ldt.id_lotclient=p_lot_client.id_lotclient
			LEFT JOIN p_lien_oper_dossier ON p_ldt.id_etape=p_lien_oper_dossier.id_lien
			LEFT JOIN p_etape ON p_lien_oper_dossier.id_oper=p_etape.id_etape
			LEFT JOIN p_etat ON p_ldt.id_etat=p_etat.id_etat
			LEFT JOIN p_type_ldt on p_type_ldt.id_type_ldt = p_ldt.id_type_ldt
			LEFT JOIN r_personnel ON r_personnel.id_pers=p_ldt.id_pers
			where 1=1 AND p_ldt.date_deb_ldt = '20150630'
			group by p_ldt.id_pers, p_dossier.num_dossier, p_type_ldt.libelle, p_etape.libelle order by  p_ldt.id_pers, p_dossier.num_dossier, p_etape.libelle, p_type_ldt.libelle ";

        $str = "<table width=\"100%\">";
        $ii = 0;

        return $sql;

        $rs = $this->cnx->query($sql);

        $i = 0;
        $qteTotal = 0;
        $hTotalLdt = 0;
        $totalVitess = 0;
        $lastDossier = '';
        foreach ($rs as $row)
		{
            $dossier = ($row['num'] == $lastDossier) ? '' : $row['num'];

            if ($row['num'] != $lastDossier) {
                $str .= "</table></tr><tr><table width=\"100%\"><tr class='classe1'>

							<td class='thx'  id='date_fin_ldt'  width=\"30%\"><h3 class='title3'>" . $row['id_pers'] . "</h3></th>
							<td   width=\"10%\"  class='grayLight title3'>".$row['num']."</td><td   width=\"10%\"  class='grayLight title3'>Duree</td><td width=\"10%\" class='grayLight title3'>Quantite</td><td class='grayLight title3'>Vitesse</td></tr>";
            } else {
                if ($row['num'] != '')
                    $str .= "";
            }
            $qte = $row['qte'];
            $duree = $row['duree'] / 3600;

            $vitesse = ($qte != 0) ? number_format($qte / $duree, 2) : '';
            $qte = ($qte != 0) ? $qte : '';
            $lastDossier = $row['num'];
            $cl = 'classe' . $ii++;
            $clGray = "";
            $lib = ($row['libelle'] == '') ? "<span  class='gray'>" . $row['lib'] . "</span>" : "" . $row['libelle'] . "";

            if ($row['libelle'] == '') {
                $clGray = " class='gray'";
            }

            if ($ii == 3)
                $ii = 0;

            $str .= "<tr class = $cl id='" . $row['num'] . "' >";
            $str .= "<td>\t$lib</td>";
            $str .= "<td $clGray>".$row['id_pers']."</td><td>" . number_format($duree, 2) . "----</td><td>" . $qte . "</td><td>" . $vitesse . "</td></tr>";
        }
        return $str . '</table>';
    }

    function TPDossierTypeLdt($currentPeriod) {
        $sql = "SELECT SUM(DATE_PART('epoch', ('2011-12-29 '||h_fin)::timestamp - ('2011-12-29 '||h_deb)::timestamp )) as somme, p_dossier.num_dossier as num, p_type_ldt.libelle  from p_ldt
			LEFT JOIN p_dossier ON p_ldt.id_dossier=p_dossier.id_dossier
			LEFT JOIN p_lot_client ON p_ldt.id_lotclient=p_lot_client.id_lotclient
			LEFT JOIN p_lien_oper_dossier ON p_ldt.id_etape=p_lien_oper_dossier.id_lien
			LEFT JOIN p_etape ON p_lien_oper_dossier.id_oper=p_etape.id_etape
			LEFT JOIN p_etat ON p_ldt.id_etat=p_etat.id_etat
			LEFT JOIN p_type_ldt on p_type_ldt.id_type_ldt = p_ldt.id_type_ldt
			where p_ldt.date_deb_ldt = '$currentPeriod' group by p_dossier.num_dossier, p_type_ldt.libelle  order by p_dossier.num_dossier";
    }

    function getLdt($dossier, $etape, $lstPeriode, $matricule, $statut, $orderby, $dep) {
        //return $this->TempsParDossierEtape($lstPeriode, $dossier, $dep);
        $filtre = "";
        if ($lstPeriode != "") {
            $filtre = " AND p_ldt.date_deb_ldt = '" . $lstPeriode . "'";

            $tk = explode(",", $lstPeriode);
            if (count($tk) > 1) {
                $lstPeriode = str_replace($lstPeriode, ",", "_");
                $filtre = " AND p_ldt.date_deb_ldt >=  '" . $tk[0] . "' AND p_ldt.date_deb_ldt <= '" . $tk[1] . "'";
            }
        }


        $folder = '../CSV/' . $_SESSION['id'];
        $this->clearDir($folder);

        $isOP = ($_SESSION['id_droit'] == 1 ? true : false);

        if (!$isOP)
            if (!is_dir($folder))
                mkdir($folder, 0755, true);
        $fName = $folder . '/LDT_' . $_SESSION['id'] . '_' . $lstPeriode . '.csv';
        if (!$isOP)
            $fw = fopen($fName, 'w');
        if ($dep != "")
            $filtre .= " AND id_departement = $dep";
        if ($dossier != "")
            $filtre .= " AND p_ldt.id_dossier = $dossier";
        if ($matricule != "")
            $filtre .= " AND p_ldt.id_pers = $matricule";
        if ($statut != "")
            $filtre .= " AND p_ldt.id_etat = $statut";
        if ($etape != "")
            $filtre .= " AND p_ldt.id_etape = $etape";

        $sql = "SELECT p_ldt.id_ldt, p_ldt.id_lot, p_ldt.machine, p_ldt.date_deb_ldt,p_ldt.date_fin_ldt, r_personnel.appelation, r_personnel.matricule, p_dossier.num_dossier,p_etape.libelle as lib, p_ldt.commentaire, p_type_ldt.libelle as type, p_ldt.h_deb, p_ldt.h_fin, p_ldt.quantite, p_ldt.nbre_erreur, p_etat.libelle as statu, p_lot.libelle as liblot, p_lot_client.libelle as liblotclient,
		DATE_PART('epoch', ('2011-12-29 '||p_ldt.h_fin)::timestamp - ('2011-12-29 '||p_ldt.h_deb)::timestamp ) as duree FROM p_ldt
			LEFT JOIN p_dossier ON p_ldt.id_dossier=p_dossier.id_dossier
			LEFT JOIN p_lot ON p_ldt.id_lot=p_lot.id_lot
			LEFT JOIN p_lot_client ON p_ldt.id_lotclient=p_lot_client.id_lotclient
			LEFT JOIN p_lien_oper_dossier ON p_ldt.id_etape=p_lien_oper_dossier.id_lien
			LEFT JOIN p_etape ON p_lien_oper_dossier.id_oper=p_etape.id_etape
			LEFT JOIN p_etat ON p_ldt.id_etat=p_etat.id_etat
			LEFT JOIN p_type_ldt on p_type_ldt.id_type_ldt = p_ldt.id_type_ldt
			LEFT JOIN r_personnel ON r_personnel.id_pers=p_ldt.id_pers

			WHERE 1=1 ";
        $sql .= $filtre;

        if ($orderby == "")
            $orderby = 'p_ldt.h_deb';
        $sql .= " ORDER BY " . $orderby;

        $str = "<table width=\"100%\"><thead><tr>
		<th class='th'  id='date_deb_ldt'>Debut</th>
		<th class='th'  id='date_fin_ldt'>Fin</th>
		<th class='th'  id='appelation'>Nom</th>
		<th class='th'  id='matricule'>User</th>
		<th class='th'  id='num_dossier'>Dossier</th>
		<th class='th'  id='lib'>Etape</th>
		<th class='th'  id='commentaire'>Lot</th>
		<th class='th'  id='machine'>Comment</th>
		<th class='th'  id='type'>Type</th>
		<th class='th'  id='h_deb'>Heure Debut</th>
		<th class='th'  id='h_fin'>Heure Fin</th>
		<th class='th'  id='h_fin'>Duree</th>
		<th class='th'  id='quantite'>Qte</th>
		<th class='th'  id='quantite'>Vitesse</th>
		<th class='th'  id='nbre_erreur'>NbErr</th>
		<th class='th'  id='statu'>Statut</th>
		<th></th></tr></thead>";
        $ii = 0;

        $row = "Date debut\tDate fin\tAppelation\tMatricule\tDossier\tEtape\tLot\tComment\tType\tHeure Debut\tHeure Fin\tDuree\tQuantite\tVitesse\tNombre Erreur\tStatut\n";
        if (!$isOP)
            fwrite($fw, $row);


        $rs = $this->cnx->query($sql);
        //return $sql;
        $i = 0;
        $qteTotal = 0;
        $hTotalLdt = 0;
        $totalVitess = 0;

        foreach ($rs as $row) {
            $vitesse = '';
            $diff = "0:0:0";
            if ($row['h_fin'] != "") {
                $diff = $row['duree'];

                if ($row['quantite'] != '' && $row['quantite'] != 0)
                    $vitesse = number_format($row['quantite'] / ($diff / 3600), 2);
                $totalVitess += $vitesse;
                $hTotalLdt += $diff;
            }

            //vitesse = Qte * duree / h
            //1 p / h


            if ($ii == 3)
                $ii = 0;

            $cl = 'classe' . $ii;
            $ii++;
            $str .= "<tr class = $cl id='" . $row['id_ldt'] . "' >";
            $str .= "<td><div class=\"ldt_date\">" . $row['date_deb_ldt'] . "</div></td>";
            $str .= "<td><div class=\"ldt_date\">" . $row['date_fin_ldt'] . "</div></td>";
            $str .= "<td>" . $row['appelation'] . "</td>";
            $str .= "<td><div class=\"ldt_mat\">" . $row['matricule'] . "</div></td>";

            $str .= "<td>" . $row['num_dossier'] . "</td>";

            $str .= "<td>" . $row['lib'] . "</td>";
            if ($row['id_lot'] != 0) {
                $str .= "<td><div class=\"ldtlib\">" . $row['liblot'] . "</div></td>";
                $str .= "<td>" . $row['commentaire'] . "</td>";
            } else {
                $str .= "<td><div class=\"ldtlib\">" . $row['commentaire'] . "</div></td>";
                $str .= "<td>" . $row['machine'] . "</td>";
            }

            $str .= "<td>" . $row['type'] . "</td>";
            $str .= "<td><div class=\"ldt_date\">" . $row['h_deb'] . "</div></td>";
            $str .= "<td><div class=\"ldt_date\">" . $row['h_fin'] . "</div></td>";
            $str .= "<td><div class=\"ldt_date\">" . number_format($diff / 3600, 2) . "</div></td>";
            $str .= "<td><div class=\"ldt_nb\">" . $row['quantite'] . "</div></td>";
            $str .= "<td><div class=\"ldt_nb\">" . $vitesse . "</div></td>";
            $qteTotal += $row['quantite'];
            $str .= "<td><div class=\"ldt_nb\">" . $row['nbre_erreur'] . "</div></td>";
            $str .= "<td>" . $row['statu'] . "</td>";
            if ($_SESSION['id_droit'] != 1) {
                $str .= "<td OnClick=updateLdtForm('" . $row['id_ldt'] . "') class='edit'></td>";
                $str .= "<td OnClick=deleteLdt('" . $row['id_ldt'] . "') class='delete'></td>";
            }
            $str .= "</tr>";
            $i++;


            $rw = $row['date_deb_ldt'] . "\t";
            $rw .= $row['date_fin_ldt'] . "\t";
            $rw .= $row['appelation'] . "\t";
            $rw .= $row['matricule'] . "\t";
            $rw .=$row['num_dossier'] . "\t";

            $rw .= $row['lib'] . "\t";
            if ($row['id_lot'] != 0) {
                $rw .= $row['liblot'] . "\t";
                $rw .= $row['commentaire'] . "\t";
            } else {
                $rw .= $row['commentaire'] . "\t";
                $rw .= $row['machine'] . "\t";
            }

            $rw .= $row['type'] . "\t";
            $rw .= $row['h_deb'] . "\t";
            $rw .= $row['h_fin'] . "\t";
            $rw .= $diff . "\t";
            $rw .= $row['quantite'] . "\t";
            $rw .= $vitesse . "\t";
            $rw .= $row['nbre_erreur'] . "\t";
            $rw .= $row['statu'] . "\n";

            if (!$isOP)
                fwrite($fw, $rw);
        }
        $str.= '<tr  class = "th"><td><b>Total:</b></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td><b>' . number_format($hTotalLdt / 3600, 2) . '</b></td><td><b>' . $qteTotal . '</b></td><td><b>' . $totalVitess . '</b></td><td></td></tr>';

        if (!$isOP)
            fclose($fw);
        $nbLigne = "</table><table><tr><td><h4>Total Found: $i</h4></td><td><a href='./CSV/$fName' OnClick=deleteReport('" . $matricule . "')><input type='submit' value='' class='copy' title='Exporter au format CSV'/></a></td></tr></table>";
        return $nbLigne . $str;
    }

    function deleteReport($idPers) {
        foreach (@glob($path . $Patern) as $filename) {
            @unlink($filename);
        }
    }

    function clearDir($dossier) {
        $ouverture = @opendir($dossier);
        if (!$ouverture)
            return;
        while ($fichier = readdir($ouverture)) {
            if ($fichier == '.' || $fichier == '..')
                continue;
            if (is_dir($dossier . "/" . $fichier)) {
                $r = $this->clearDir($dossier . "/" . $fichier);
                if (!$r)
                    return false;
            }
            else {
                $r = @unlink($dossier . "/" . $fichier);
                if (!$r)
                    return false;
            }
        }
        closedir($ouverture);
        $r = @rmdir($dossier);
        if (!$r)
            return false;
        return true;
    }

    function GetImageInDir($item) {
        $dossier = 'img/' . $item;
        $lstImage = array();
		$strLstImage = "";
        $ouverture = @opendir($dossier);
        if (!$ouverture)
            return;
        while ($fichier = readdir($ouverture)) {
            if ($fichier == '.' || $fichier == '..')
                continue;
            if (is_dir($dossier . "/" . $fichier)) {
                continue;
            } else {
                $lstImage[] ='<div><a u=image href="#"><img src="' . $dossier . '/' . $fichier . '" /></a></div>';
            }
        }
        closedir($ouverture);
		sort($lstImage);
		foreach ($lstImage as &$value) {
			$strLstImage .= $value;
		}

        return $strLstImage;
    }

    function GetLstFolder($path) {
        $path = 'img';
        $strLstImage = "";
        $ouverture = @opendir($path);
        if (!$ouverture)
            return 'cant open';
        while ($fichier = readdir($ouverture)) {


            if ($fichier == '.' || $fichier == '..')
                continue;
            if (is_dir($path . "/" . $fichier)) {
                if ($fichier == 'img')
                    continue;
                $strLstImage.= '<h1><br /><a href="#" id="' . $fichier . '">' . $fichier . '</a></h1>';
            }
        }
        closedir($ouverture);
        return $strLstImage;
    }

    function getLot($dossier, $lotClient, $matricule, $statut, $etape, $prio, $name, $ordre) {
        //
        $filtre = "";
        if ($dossier != "") {
            // spécifique pour le projet detourage ou il fallait ressembler tout les dossier
            if ($dossier == '39')
                $filtre .= " AND p_dossier.id_dossier IN (108,109,110,111,112,113,107,39)";
            else
                $filtre .= " AND p_dossier.id_dossier = $dossier";
        }
        if ($lotClient != "")
            $filtre .= " AND p_lot.id_lotclient = $lotClient";
        if ($matricule != "")
            $filtre .= " AND p_lot.id_pers = $matricule";
        if ($statut != "")
            $filtre .= " AND p_lot.id_etat = $statut";
        if ($etape != "")
            $filtre .= " AND p_lot.id_etape = $etape";
        if ($prio != "")
            $filtre .= " AND p_lot.priority = $prio";
        if ($name != "")
            $filtre .= " AND p_lot.libelle like '%$name%'";

        $sql = "SELECT p_dossier.num_dossier, p_lot_client.libelle as ldg, p_lot.id_lot as id,p_lot.libelle as lib, p_etat.libelle as etat, p_etape.libelle as etape ,p_lot.id_pers, p_lot.priority, p_lot.id_pers, p_lot.duree, p_lot.qte FROM p_lot
        LEFT JOIN p_etat ON p_lot.id_etat= p_etat.id_etat
		LEFT JOIN p_lien_oper_dossier ON p_lot.id_etape= p_lien_oper_dossier.id_lien
		LEFT JOIN p_etape ON p_etape.id_etape= p_lien_oper_dossier.id_oper
		LEFT JOIN p_lot_client ON p_lot.id_lotclient = p_lot_client.id_lotclient
		LEFT JOIN p_dossier ON p_lot_client.id_dossier = p_dossier.id_dossier
		WHERE 1=1";

        if ($ordre == "")
            $sql .= $filtre . " order by lib";
        elseif ($ordre == "stat")
            return $this->SuiviLot($dossier, $lotClient, $matricule, $statut, $etape, $prio, $name, $ordre);
        else
            $sql .= $filtre . " ORDER BY " . $ordre;

        //return $sql;

        $folder = '../CSV/' . $_SESSION['id'];
        $this->clearDir($folder);
        if (!is_dir($folder))
            mkdir($folder, 0755, true);
        $fName = $folder . '/LOT_' . $_SESSION['id'] . '_' . $dossier . '_' . $lotClient . '_' . $etape . '.csv';
        $fw = fopen($fName, 'w');

        $str = "<table width='100%'>
		<thead><tr>
		<th  class='th' width='20%' id='num_dossier' class='filter'>Dossier</th>
		<th  class='th' id='p_lot_client.libelle' class='filter'>Lot client</th>
		<th  class='th' id='p_lot.libelle'>Lot</th>
		<th  class='th' id='p_etape.libelle'>Etape</th>
		<th  class='th' id='p_etat.libelle'>Etat</th>

		<th  class='th' id='p_etat.duree'>Duree</th>
		<th  class='th' id='p_lot.qte'>Qte</th>
		<th  class='th' id='p_lot.qte'>Vitesse</th>
		<th  class='th' id='p_lot.id_pers'>Matricule</th>
		<th  class='th' id='p_lot.priority'>Priorite</th>
		<th id='lib'><input type='checkbox' id='selectall'  ></th>
		</tr></thead>";

        $row = "Dossier\tLot client\tLot\tEtape\tEtat\tEtape\tDuree\tVitesse\tMatricule\tPriorite\n";
        fwrite($fw, $row);

        $strCsv = "";

        //return $sql;
        $ii = 0;
        $nbResult = 0;
        $rs = $this->cnx->query($sql);

        foreach ($rs as $row) {
            $rez = explode('$', $this->GetDureeLot($row['id']));
            $duree = $rez[0];
            $qte = $rez[1];
            $vitesse = number_format(($this->ToSeconde($duree) * $qte) / 3600, 2);

            if ($ii == 3)
                $ii = 0;
            $cl = 'classe' . $ii;
            $ii++;
            $str .= "<tr class = $cl id='" . $row['id'] . "' >";
            $str .= "<td>" . $row['num_dossier'] . "</td>";
            $str .= "<td>" . $row['ldg'] . "</td>";
            $str .= "<td>" . $row['lib'] . "</td>";
            $str .= "<td>" . $row['etape'] . "</td>";
            $str .= "<td>" . $row['etat'] . "</td>";
            // if ($row['etat'] == "TERMINE")
            $str .= "<td>" . $this->ToHeureDecimal($duree) . "</td>";
            //else $str .= "<td></td>";
            $str .= "<td>" . $qte . "</td>";
            $str .= "<td>" . $vitesse . "</td>";
            $str .= "<td>" . $row['id_pers'] . "</td>";
            $str .= "<td>" . $row['priority'] . "</td>";
            $str .= "<td><input type='checkbox'  class='case' name='options[]' id=" . $row['id'] . ">";
            if ($_SESSION['id'] == '177')
                $str .= "<td OnClick=deleteLot('" . $row['id'] . "') class='delete'></td>";
            $str .= "</tr>";
            $nbResult++;

            $sr = $row['num_dossier'] . "\t";
            $sr .= $row['ldg'] . "\t";
            $sr .= $row['lib'] . "\t";
            $sr .= $row['etape'] . "\t";
            $sr .= $row['etat'] . "\t";
            $sr .= $row['qte'] . "\t";
            if ($row['etat'] == "TERMINE")
                $sr .= $this->ToHeureDecimal($duree) . "\t";
            else
                $sr .= "\t";
            $sr .= $vitesse . "\t";
            $sr .= $row['id_pers'] . "\t";
            $sr .= $row['priority'] . "\n";

            fwrite($fw, $sr);
        }
        fclose($fw);
        $str .= "</table>";
        $nbLigne = "</table><table><tr><td><h4>Total Found: $nbResult</h4></td><td><a href='./CSV/$fName'><input type='submit' value='' class='copy' title='Exporter au format CSV'/></a></td></tr></table>";

        return $nbLigne . $str;
    }

    function getIdLotAlmerys($id) {
        $sql = "select libelle, qte, id_lotclient, id_pers, num_nuo, num_ps, is_interial, is_rejet, id_motif_rejet from almerys_p_lot where id_lot = " . $id;
        $rs = $this->cnx->query($sql);

        foreach ($rs as $row) {
            return $row['libelle'] . '$' . $row['qte'] . '$' . $row['id_lotclient'] . '$' . $row['id_pers'] . '$' . $row['num_nuo'] . '$' . $row['num_ps'] . '$ ' . $row['is_interial'] . '$' . $row['is_rejet'] . '$' . $row['id_motif_rejet'];
        }
        return '';
    }

	function enqueteSMQ($comment, $durration)
	{
		$sqlPointage = "select id from enquete_smq where id_pers = " . $_SESSION['id'];
        $rs1 = $this->cnx->query($sqlPointage);
        while ($arr1 = $rs1->fetch()) {
            return true;
        }
        $sql = "INSERT INTO enquete_smq (id_pers, duration, commentaires)
		values (" . $_SESSION['id'] . ", $durration,'$comment')";
       // return $sql;
        if ($this->cnx->exec($sql)) {
            return true;
        }
        return false;
	}

    function getLotAlmerys_old($dossier, $lotClient, $matricule, $statut, $etape, $prio, $name, $ordre, $is_interial) {
        $filtre = "";
        if ($dossier != "")
            $filtre .= " AND p_dossier.id_dossier = $dossier";

        $filtreLotClient = "";

        if ($lotClient != "")
            $filtre .= " AND almerys_p_lot.id_lotclient = $lotClient";
        if ($lotClient != "")
            $filtreLotClient .= " AND almerys_p_lot.id_lotclient = $lotClient";

        if ($matricule != "")
            $filtre .= " AND almerys_p_lot.id_pers = $matricule";

        if ($etape != "")
            $filtre .= " AND almerys_p_lot.id_etape = $etape";

        if ($name != "")
            $filtre .= " AND almerys_p_lot.libelle like '%$name%'";

        if ($prio != "")
            $filtre .= " AND almerys_p_lot.date_deb = '$prio'";

        $arrayAllowedMatricul = array('55' => '177', '177' => '177', '1' => '', '432' => '', '70' => '', '32' => '', '435' => '', '323' => '', '449' => '', '418' => '', '450' => '', '347' => '');

        if (!array_key_exists($_SESSION['id'], $arrayAllowedMatricul))
            $filtre .= " AND almerys_p_lot.id_pers IN (select matricule from almerys_user where id_cq = " . $_SESSION['id'] . ')';

        $sql = "SELECT p_dossier.num_dossier, p_lot_client.libelle as ldg,almerys_p_lot.id_lotclient,almerys_p_lot.etat as etat_saisie,almerys_p_lot.num_nuo,almerys_p_lot.num_ps, almerys_p_lot.id_lot,almerys_p_lot.libelle as lib, p_etat.libelle as etat, p_etape.libelle as etape ,almerys_p_lot.id_pers, almerys_p_lot.priority, almerys_p_lot.id_pers, almerys_p_lot.duree, almerys_p_lot.qte, almerys_p_lot.erreur, almerys_p_lot.is_rejet,almerys_motif_rejet.libelle as lib_rejet,
		(select sat from almerys_user  where almerys_user.matricule = almerys_p_lot.id_pers limit 1) as sat, (select nom||' '||prenom from r_personnel  where r_personnel.id_pers = almerys_p_lot.id_cq) as nom
		FROM almerys_p_lot
        LEFT JOIN p_etat ON almerys_p_lot.id_etat= p_etat.id_etat
		LEFT JOIN p_lien_oper_dossier ON almerys_p_lot.id_etape= p_lien_oper_dossier.id_lien
		LEFT JOIN p_etape ON p_etape.id_etape= p_lien_oper_dossier.id_oper
		LEFT JOIN p_lot_client ON almerys_p_lot.id_lotclient = p_lot_client.id_lotclient
		LEFT JOIN p_dossier ON p_lot_client.id_dossier = p_dossier.id_dossier
	LEFT JOIN almerys_motif_rejet ON almerys_motif_rejet.id= almerys_p_lot.id_motif_rejet

		WHERE almerys_p_lot.id_etat=0 and is_interial=$is_interial";

        $boolInterial = $is_interial === 'TRUE' ? true : false;
        //$is_interial = $is_interial === 'TRUE'? true: false;
        //return $sql;
        if ($ordre == "")
            $sql .= $filtre . " order by lib";
        elseif ($ordre == "stat") {
            $POLE = $boolInterial ? "SPECIALITE" : "POLE";
            $str = "<table width='100%'>
			<thead><tr>

			<th  class='th' id='p_lot_client.libelle' class='filter'>$POLE</th>
			<th  class='th' id='almerys_p_lot.libelle'>FACTURE SAISIE</th>
			<th  class='th' >FACTURE DEJA CONTROLE</th>
			<th  class='th' id='almerys_p_lot.qte'>OK</th>
			<th  class='th' id='almerys_p_lot.id_pers'>NOK</th>
			<th  class='th' id='almerys_p_lot.priority'>NRRG</th>
			<th  class='th' id='almerys_p_lot.p_etape'>ES</th>
			<th  class='th' id='almerys_p_lot.p_etape'>EN ATTENTE</th>
			</tr></thead>";

            $sqlDoss = 'select distinct(id_lotclient) from almerys_p_lot order by id_lotclient desc';
            $rss = $this->cnx->query($sqlDoss);

            $ii = 0;
            while ($arrDoss = $rss->fetch()) {
                if ($ii == 3)
                    $ii = 0;
                $str .= "<tr class = 'classe" . $ii . "'>" . $this->SuiviLotAlmerys($dossier, $arrDoss['id_lotclient'], $matricule, $statut, $etape, $prio, $name, $ordre, $is_interial) . '</tr>';
                $ii++;
            }

            $str.="<tr  class='th'>";
            $str.='</tr></table>#
			<hr>
			<h3>Facture controle par CQ</h3>
			<hr>';
            //return $str;
            // affichage erreur par CQ et nombre de facture controlé par CQ.

            /*
              $sql = "select almerys_p_lot.id_pers as cq, p_lot_client.libelle as lib, p_etape.libelle as etape,  count(almerys_p_lot.id_etape) as nb from almerys_p_lot
              inner join p_lot_client on almerys_p_lot.id_lotclient = p_lot_client.id_lotclient
              LEFT JOIN p_lien_oper_dossier ON almerys_p_lot.id_etape=p_lien_oper_dossier.id_lien
              LEFT JOIN p_etape ON p_lien_oper_dossier.id_oper=p_etape.id_etape
              where almerys_p_lot.id_etape <> 943 $filtreLotClient and date_deb = '$prio'   AND is_interial=$is_interial
              group by almerys_p_lot.id_pers,  p_etape.libelle, p_lot_client.libelle order by almerys_p_lot.id_pers";

             */

            $sql = "select almerys_p_lot.id_pers as cq, p_lot_client.libelle as lib, p_etape.libelle as etape,  count(almerys_p_lot.id_etape) as nb from almerys_p_lot
			inner join p_lot_client on almerys_p_lot.id_lotclient = p_lot_client.id_lotclient
			LEFT JOIN p_lien_oper_dossier ON almerys_p_lot.id_etape=p_lien_oper_dossier.id_lien
			LEFT JOIN p_etape ON p_lien_oper_dossier.id_oper=p_etape.id_etape
			where almerys_p_lot.id_etape <> 943 $filtreLotClient and date_deb = '$prio'   AND is_interial=$is_interial
			group by almerys_p_lot.id_pers,  p_etape.libelle, p_lot_client.libelle order by almerys_p_lot.id_pers";

            $str .= "<table width='100%'>
			<thead><tr>

			<th  class='th' id='p_lot_client.libelle' class='filter'>CQ</th>
			<th  class='th' id='almerys_p_lot.libelle'>POLE</th>
			<th  class='th' >ERREUR</th>
			<th  class='th' id='almerys_p_lot.qte'>NB</th>
			</tr></thead>";


            $rss = $this->cnx->query($sql);

            $ii = 0;
            while ($arrDoss = $rss->fetch()) {
                //$sql = "select id_pers from almerys_p_lot
                if ($ii == 3)
                    $ii = 0;
                $str .= "<tr class = 'classe" . $ii . "'><td>" . $arrDoss['cq'] . '</td><td>' . $arrDoss['lib'] . '</td><td>' . $arrDoss['etape'] . '</td><td>' . $arrDoss['nb'] . '</td></tr>';
                $ii++;
            }

            $str.="<tr  class='th'>";
            $str.='</tr></table>';

            return $str;
        } else
            $sql .= $filtre . " ORDER BY " . $ordre;

        $folder = '../CSV/' . $_SESSION['id'];
        $this->clearDir($folder);
        if (!is_dir($folder))
            mkdir($folder, 0755, true);
        $fName = $folder . '/LOT_' . $_SESSION['id'] . '_' . $dossier . '_' . $lotClient . '_' . $etape . '.csv';
        $fw = fopen($fName, 'w');

        //$is_interial = false;

        $facture = $boolInterial ? "SECU" : "FACTURE";
        $decompte = $boolInterial ? "DECOMPTE" : "NUO";
        $PS = $boolInterial ? "" : "NUMERO PS";
        $POLE = $boolInterial ? "SPECIALITE" : "POLE";
        $etat = $boolInterial ? "<th  class='th' id='almerys_p_lot.etat'>ETAT</th>" : "";

        //return $sql;

        $str = "<table width='100%'>
		<thead><tr>

		<th  class='th' id='p_lot_client.libelle' class='filter'>$POLE</th>
		<th  class='th' id='almerys_p_lot.libelle'>NUMERO $facture</th>
		<th  class='th' id='almerys_p_lot.num_nuo'>NUMERO $decompte</th>
		<th  class='th' id='almerys_p_lot.num_ps'>$PS</th>
		<th  class='th' >NIVEAU</th>
		<th  class='th' id='almerys_p_lot.qte'>MONTANT RC</th>
		<th  class='th' id='almerys_p_lot.id_pers'>MATRICULE</th>
		<th  class='th' id='almerys_p_lot.priority'>SAT</th>
		<th  class='th' id='p_lot_client.id_cq' class='filter'>NOM CQ</th>
		<th  class='th' id='almerys_p_lot.p_etape'>ETAT</th>
		<th  class='th' id='almerys_p_lot.erreur'>ERREUR</th>
		<th  class='th' id='almerys_p_lot.id_rejet'>RETOUR</th>
		<th  class='th' id='almerys_p_lot.lib_rejet'>LIB RETOUR</th>$etat</tr>
		</thead>";

        $row = "POLE\tNIVEAU\tNUMERO FACTURE\tNUMERO NUO\tNUMERO PS\tMONTANT FACTURE\tERREUR\tDETAILS\tMATRICULE\tSAT\n";
        fwrite($fw, $row);

        $strCsv = "";

        //return $sql;
        $ii = 0;
        $nbResult = 0;
        $rs = $this->cnx->query($sql);

        //return $sql;
        foreach ($rs as $row) {
            $montant = (double) str_replace(",", ".", $row['qte']);
            $niveau = "";

            if ($boolInterial) {
                if ($montant >= 350)
                    $niveau = 'NIVEAU_A';
                if ($montant < 350)
                    $niveau = 'NIVEAU_B';
            }
            else {


                switch ($row['id_lotclient']) {
                    case 2385: //SE
                        if ($montant >= 100)
                            $niveau = 'NIVEAU_A';
                        if ($montant > 85 && $montant < 100)
                            $niveau = 'NIVEAU_B';
                        if ($montant <= 85)
                            $niveau = 'NIVEAU_C';

                        break;
                    case 2387: //HOSPI
                        if ($montant >= 2500)
                            $niveau = 'NIVEAU_A';
                        if ($montant > 2000 && $montant < 2500)
                            $niveau = 'NIVEAU_B';
                        if ($montant > 1500 && $montant <= 2000)
                            $niveau = 'NIVEAU_C';
                        if ($montant > 1000 && $montant <= 1500)
                            $niveau = 'NIVEAU_D';
                        if ($montant > 500 && $montant <= 1000)
                            $niveau = 'NIVEAU_E';
                        if ($montant > 300 && $montant <= 500)
                            $niveau = 'NIVEAU_F';
                        if ($montant <= 300)
                            $niveau = 'NIVEAU_G';
                        break;

                    case 2391: //HOSPI
                        if ($montant >= 2500)
                            $niveau = 'NIVEAU_A';
                        if ($montant > 2000 && $montant < 2500)
                            $niveau = 'NIVEAU_B';
                        if ($montant > 1500 && $montant <= 2000)
                            $niveau = 'NIVEAU_C';
                        if ($montant > 1000 && $montant <= 1500)
                            $niveau = 'NIVEAU_D';
                        if ($montant > 500 && $montant <= 1000)
                            $niveau = 'NIVEAU_E';
                        if ($montant > 300 && $montant <= 500)
                            $niveau = 'NIVEAU_F';
                        if ($montant <= 300)
                            $niveau = 'NIVEAU_G';
                        break;
                    case 2386: //OPTIQUE
                        if ($montant >= 700)
                            $niveau = 'NIVEAU_A';
                        if ($montant > 300 && $montant < 700)
                            $niveau = 'NIVEAU_B';
                        if ($montant <= 300)
                            $niveau = 'NIVEAU_C';
                        break;
                    case 2388: //SANTECLAIR
                        if ($montant >= 600)
                            $niveau = 'NIVEAU_A';
                        if ($montant > 300 && $montant < 600)
                            $niveau = 'NIVEAU_B';
                        if ($montant <= 300)
                            $niveau = 'NIVEAU_C';
                        break;
                    case 2390: //PUBLIPOSTAGE
                        if ($montant >= 700)
                            $niveau = 'NIVEAU_A';
                        if ($montant > 300 && $montant < 700)
                            $niveau = 'NIVEAU_B';
                        if ($montant <= 300)
                            $niveau = 'NIVEAU_C';
                        break;
                    case 2395: //INTERIAL

                    case 2462: //TPS
                        if ($montant >= 100)
                            $niveau = 'NIVEAU_A';
                        if ($montant > 85 && $montant < 100)
                            $niveau = 'NIVEAU_B';
                        if ($montant <= 85)
                            $niveau = 'NIVEAU_C';

                        break;

                    Default:
                        $niveau = 'NIVEAU_A';
                        break;
                }
            }

            $montantRC = "";
            if ($ii == 3)
                $ii = 0;
            $cl = 'classe' . $ii;
            $ii++;
            $str .= "<tr class = '" . $cl . " " . $niveau . "' id='" . $row['id_lot'] . "' >";


            $str .= "<td>" . $row['ldg'] . "</td>";
            if ($row['etape'] == 'Saisie')
                $str .= "<td  OnClick=getIdLotAlmerys('" . $row['id_lot'] . "')>" . $row['lib'] . "</td>";
            else
                $str .= "<td>" . $row['lib'] . "</td>";
            $str .= "<td>" . $row['num_nuo'] . "</td>";
            $str .= "<td>" . $row['num_ps'] . "</td>";
            $str .= "<td>" . $niveau . "</td>";
            $str .= "<td>" . $row['qte'] . "</td>";
            $str .= "<td>" . $row['id_pers'] . "</td>";
            $str .= "<td>" . $row['sat'] . "</td>";
            $str .= "<td>" . $row['nom'] . "</td>";
            $str .= "<td>" . $row['etape'] . "</td>";
            $str .= "<td>" . $row['erreur'] . "</td>";

            $rejet = $row['is_rejet'] == '1' ? 'R' : '';
            $str .= "<td>" . $rejet . "</td>";
            $str .= "<td>" . $row['lib_rejet'] . "</td>";
            if ($boolInterial == true)
                $str .= "<td>" . $row['etat_saisie'] . "</td>";
            //$str .= "<td><input type='checkbox'  class='case' name='options[]' id=".$row['id_lot'].">";
            //if ($_SESSION['id'] == '177')
            //$str .= "<td OnClick=deleteLot('".$row['id_lot']."') class='delete'></td>";

            $str .= "</tr>";
            $nbResult++;


            $sr = $row['ldg'] . "\t";
            $sr .= $niveau . "\t";
            $sr .= $row['lib'] . "\t";
            $sr .= $row['num_nuo'] . "\t";
            $sr .= $row['num_ps'] . "\t";
            $sr .= $row['qte'] . "\t";
            $sr .= $row['etape'] . "\t";
            $sr .= $row['erreur'] . "\t";
            $sr .= $row['id_pers'] . "\t";

            $sr .= $row['sat'] . "\t";
            $sr .= $row['nom'] . "\t";
            $sr .= $rejet . "\n";
            fwrite($fw, $sr);
        }

        fclose($fw);
        $str .= "</table>";
        $nbLigne = "</table><table><tr><td><h4>Total Found: $nbResult</h4></td><td><a href='./CSV/$fName'><input type='submit' value='' class='copy' title='Exporter au format CSV'/></a></td></tr></table>";

        return $nbLigne . $str;
    }
	
	function getLotAlmerys($dossier, $lotClient, $matricule, $statut, $etape, $prio, $name, $ordre, $is_interial) {
        $filtre = "";
        if ($dossier != "")
            $filtre .= " AND p_dossier.id_dossier = $dossier";

        $filtreLotClient = "";

        if ($lotClient != "")
            $filtre .= " AND almerys_p_lot.id_lotclient = $lotClient";
        if ($lotClient != "")
            $filtreLotClient .= " AND almerys_p_lot.id_lotclient = $lotClient";

        if ($matricule != "")
            $filtre .= " AND almerys_p_lot.id_pers = $matricule";

        if ($etape != "")
            $filtre .= " AND almerys_p_lot.id_etape = $etape";

        if ($name != "")
            $filtre .= " AND almerys_p_lot.libelle like '%$name%'";

        if ($prio != "")
            $filtre .= " AND almerys_p_lot.date_deb = '$prio'";

        //  $arrayAllowedMatricul = array('55' => '177', '177' => '177', '487' => '487', '1' => '', '432' => '', '70' => '', '32' => '', '435' => '', '323' => '', '449' => '', '418' => '', '450' => '', '347' => '');
        $sqlallow = "SELECT id_pers, id_droit_menu
  FROM p_logon where id_pers=" . $_SESSION['id'];
        $id_droit = 0;
        $droit_almerys = $this->cnx->query($sqlallow);
        while ($allow = $droit_almerys->fetch()) {
            $id_droit = $allow['id_droit_menu'];
        }
        //  return $id_droit;
        if ($id_droit != 2) {
            $filtre .= " AND almerys_p_lot.id_pers IN (select matricule from almerys_user where id_cq = " . $_SESSION['id'] . ')';

            //    //added by Vololona to check for almerys user
            if ($id_droit == 1 && (date('H')>12 &&(date('H')<13)) ) {
                return date('H');
                $yesterday = date("Ymd") - 1;
                $sqluserview = "SELECT almerys_p_lot.id_pers AS op
     , p_lot_client.libelle  AS lib
     , p_etape.libelle       AS etape
     , COUNT( almerys_p_lot.id_etape ) AS nb
	 ,almerys_p_lot.erreur as erreur
   FROM almerys_p_lot
        INNER JOIN p_lot_client ON almerys_p_lot.id_lotclient = p_lot_client.id_lotclient 
        LEFT  JOIN p_lien_oper_dossier ON almerys_p_lot.id_etape=p_lien_oper_dossier.id_lien 
        LEFT  JOIN p_etape ON p_lien_oper_dossier.id_oper=p_etape.id_etape
		WHERE almerys_p_lot.id_etape <> 943
    AND date_deb        = '" . $yesterday . "'
    AND p_etape.libelle IN ( 'NRRG', 'ES' )
	AND almerys_p_lot.id_pers=" . $_SESSION['id'] . "
    AND is_interial=$is_interial
  GROUP BY
        almerys_p_lot.id_pers
      , p_lot_client.libelle
      , p_etape.libelle
	  ,almerys_p_lot.erreur
  ORDER BY almerys_p_lot.id_pers";

                $str_user = "<table width='100%'>
            <thead><tr>
                <th class='th'>#</th>
                <th class='th'>Pole</th>
                <th class='th'>Operateur</th>
                <th class='th'>Etat</th>
                <th class='th'>Type d'erreur</th>
                <th class='th'>Nombre d'erreur</th>
            </tr></thead>";
                $totalerror = 0;
                $numero = 1;

                $useralmview = $this->cnx->query($sqluserview);
                while ($user = $useralmview->fetch()) {
                    $str_user.= "<tr><td>" . $numero . "</td>
                <td>" . $user['lib'] . "</td>
               <td>" . $user['op'] . "</td>
                    <td>" . $user['etape'] . "</td>
                <td>" . $user['erreur'] . "</td>
                <td>" . $user['nb'] . "</td></tr>";
                    $totalerror+=$user['nb'];
                    $numero++;
                }
                $str_user.="</table> <hr> <h3>Nombre total d'erreur hier pour l'operateur " . $_SESSION['id'] . " est : " . $totalerror . "</h3>";

                return $str_user;
            } else
                return "<h3>Acces non autorise</h3>" .date('H');
        }
//else{
//    //added by Vololona to check for almerys user
//        $almuser="SELECT count(matricule) as nb,  matricule  FROM almerys_user where matricule =17 group by matricule";
//        return $almuser;
//    
//}
        $sql = "SELECT p_dossier.num_dossier, p_lot_client.libelle as ldg,almerys_p_lot.id_lotclient,almerys_p_lot.etat as etat_saisie,almerys_p_lot.num_nuo,almerys_p_lot.num_ps, almerys_p_lot.id_lot,almerys_p_lot.libelle as lib, p_etat.libelle as etat, p_etape.libelle as etape ,almerys_p_lot.id_pers, almerys_p_lot.priority, almerys_p_lot.id_pers, almerys_p_lot.duree, almerys_p_lot.qte, almerys_p_lot.erreur, almerys_p_lot.is_rejet,almerys_motif_rejet.libelle as lib_rejet,
		(select sat from almerys_user  where almerys_user.matricule = almerys_p_lot.id_pers limit 1) as sat, (select nom||' '||prenom from r_personnel  where r_personnel.id_pers = almerys_p_lot.id_cq) as nom
		FROM almerys_p_lot
        LEFT JOIN p_etat ON almerys_p_lot.id_etat= p_etat.id_etat 
		LEFT JOIN p_lien_oper_dossier ON almerys_p_lot.id_etape= p_lien_oper_dossier.id_lien  
		LEFT JOIN p_etape ON p_etape.id_etape= p_lien_oper_dossier.id_oper 
		LEFT JOIN p_lot_client ON almerys_p_lot.id_lotclient = p_lot_client.id_lotclient
		LEFT JOIN p_dossier ON p_lot_client.id_dossier = p_dossier.id_dossier
	LEFT JOIN almerys_motif_rejet ON almerys_motif_rejet.id= almerys_p_lot.id_motif_rejet 
	
		WHERE almerys_p_lot.id_etat=0 and is_interial=$is_interial";

        $boolInterial = $is_interial === 'TRUE' ? true : false;
        //$is_interial = $is_interial === 'TRUE'? true: false;
        //return $sql;
        if ($ordre == "")
            $sql .= $filtre . " order by lib";
        elseif ($ordre == "stat") {
            $POLE = $boolInterial ? "SPECIALITE" : "POLE";
            $str = "<table width='100%'>
			<thead><tr>
			
			<th  class='th' id='p_lot_client.libelle' class='filter'>$POLE</th>
			<th  class='th' id='almerys_p_lot.libelle'>FACTURE SAISIE</th>	
			<th  class='th' >FACTURE DEJA CONTROLE</th>
			<th  class='th' id='almerys_p_lot.qte'>OK</th>
			<th  class='th' id='almerys_p_lot.id_pers'>NOK</th>
			<th  class='th' id='almerys_p_lot.priority'>NRRG</th>
			<th  class='th' id='almerys_p_lot.p_etape'>ES</th>
			<th  class='th' id='almerys_p_lot.p_etape'>EN ATTENTE</th>
			</tr></thead>";

            $sqlDoss = 'select distinct(id_lotclient) from almerys_p_lot order by id_lotclient desc';
            $rss = $this->cnx->query($sqlDoss);

            $ii = 0;
            while ($arrDoss = $rss->fetch()) {
                if ($ii == 3)
                    $ii = 0;
                $str .= "<tr class = 'classe" . $ii . "'>" . $this->SuiviLotAlmerys($dossier, $arrDoss['id_lotclient'], $matricule, $statut, $etape, $prio, $name, $ordre, $is_interial) . '</tr>';
                $ii++;
            }

            $str.="<tr  class='th'>";
            $str.='</tr></table>#
			<hr>
			<h3>Nombre d\'Erreur par Operateur</h3>
			<hr>';
            //return $str;
            // affichage erreur par CQ et nombre de facture controlé par CQ.

            /*
              $sql = "select almerys_p_lot.id_pers as cq, p_lot_client.libelle as lib, p_etape.libelle as etape,  count(almerys_p_lot.id_etape) as nb from almerys_p_lot
              inner join p_lot_client on almerys_p_lot.id_lotclient = p_lot_client.id_lotclient
              LEFT JOIN p_lien_oper_dossier ON almerys_p_lot.id_etape=p_lien_oper_dossier.id_lien
              LEFT JOIN p_etape ON p_lien_oper_dossier.id_oper=p_etape.id_etape
              where almerys_p_lot.id_etape <> 943 $filtreLotClient and date_deb = '$prio'   AND is_interial=$is_interial
              group by almerys_p_lot.id_pers,  p_etape.libelle, p_lot_client.libelle order by almerys_p_lot.id_pers";

             */



            $str .= "<table width='100%'>
			<thead><tr>
			
			<th  class='th' id='p_lot_client.libelle' class='filter'>OP</th>
			<th  class='th' id='almerys_p_lot.libelle'>POLE</th>	
			<th  class='th' >ERREUR</th>
                        <th  class='th' >NB</th>
                        <th  class='th' >Taux Erreur</th>
			</tr></thead>";

            $arrayIdPersCountSaisie = Array();
            $sqlCountSaisie = " select  id_pers ,count(id_lot) as total from almerys_p_lot  WHERE almerys_p_lot.id_etape <> 943
    AND date_deb   = '" . str_replace("/", "", $prio) . "' GROUP BY id_pers order by id_pers";
            $rss = $this->cnx->query($sqlCountSaisie);
            while ($rowcount = $rss->fetch()) {

                $arrayIdPersCountSaisie[$rowcount['id_pers']] = $rowcount['total'];
            }
  $sqlop = "SELECT almerys_p_lot.id_pers AS op
     , p_lot_client.libelle  AS lib
     , p_etape.libelle       AS etape
     , COUNT( almerys_p_lot.id_etape ) AS nb
   FROM almerys_p_lot
        INNER JOIN p_lot_client ON almerys_p_lot.id_lotclient = p_lot_client.id_lotclient 
        LEFT  JOIN p_lien_oper_dossier ON almerys_p_lot.id_etape=p_lien_oper_dossier.id_lien 
        LEFT  JOIN p_etape ON p_lien_oper_dossier.id_oper=p_etape.id_etape
  WHERE almerys_p_lot.id_etape <> 943
    AND date_deb        = '" . str_replace("/", "", $prio) . "'
    AND p_etape.libelle IN ( 'NRRG', 'ES' )
  GROUP BY
        almerys_p_lot.id_pers
      , p_lot_client.libelle
      , p_etape.libelle
  ORDER BY almerys_p_lot.id_pers";
            $rss = $this->cnx->query($sqlop);
         
            $ii = 0;
            while ($arrDoss = $rss->fetch()) {
                //$sql = "select id_pers from almerys_p_lot 
                if ($ii == 3)
                    $ii = 0;
                       $total = 0;

                $total = $arrayIdPersCountSaisie[$arrDoss['op']];
                $rate = ($arrDoss['nb'] / $total) * 100;
                $str .= "<tr class = 'classe" . $ii . "'><td>" . $arrDoss['op'] . '</td><td>' . $arrDoss['lib'] . '</td><td>' . $arrDoss['etape'] . '</td><td>' . $arrDoss['nb'] . '</td><td>' .number_format($rate,2) . '</td></tr>';
                $ii++;
            }

            $str.="<tr  class='th'>";
           $str.='</tr></table>#';
            $str.= '<hr>
                    <h3>Facture controle par CQ</h3>
			<hr>';
 $sql = "select (select nom||' '||prenom from r_personnel  where r_personnel.id_pers = almerys_p_lot.id_cq) as cq, p_lot_client.libelle as lib, p_etape.libelle as etape,  count(almerys_p_lot.id_etape) as nb from almerys_p_lot 
			inner join p_lot_client on almerys_p_lot.id_lotclient = p_lot_client.id_lotclient 
			LEFT JOIN p_lien_oper_dossier ON almerys_p_lot.id_etape=p_lien_oper_dossier.id_lien 
			LEFT JOIN p_etape ON p_lien_oper_dossier.id_oper=p_etape.id_etape
			where almerys_p_lot.id_etape <> 943 and date_deb = '" . str_replace("/", "", $prio) . "' and p_etape.libelle IN ( 'NRRG', 'ES' )
			group by almerys_p_lot.id_cq,  p_etape.libelle, p_lot_client.libelle order by almerys_p_lot.id_cq";


            $str .= "<table width='100%'>
			<thead><tr>
			
			<th  class='th' id='p_lot_client.libelle' class='filter'>Nom CQ</th>
			<th  class='th' id='almerys_p_lot.libelle'>POLE</th>
                        <th  class='th' >NB CONTROLEE</th>
			<th  class='th' >ERREUR</th>
			</tr></thead>";


            $rss = $this->cnx->query($sql);

            $ii = 0;
            while ($arrDoss = $rss->fetch()) {

                if ($ii == 3)
                    $ii = 0;
                $sqltotal = "select (select nom||' '||prenom from r_personnel  where r_personnel.id_pers = almerys_p_lot.id_cq) as cq, p_lot_client.libelle as lib,count(almerys_p_lot.id_etape) as nb from almerys_p_lot 
			inner join p_lot_client on almerys_p_lot.id_lotclient = p_lot_client.id_lotclient 
			LEFT JOIN p_lien_oper_dossier ON almerys_p_lot.id_etape=p_lien_oper_dossier.id_lien 
			LEFT JOIN p_etape ON p_lien_oper_dossier.id_oper=p_etape.id_etape
			where almerys_p_lot.id_etape <> 943 and date_deb = '" . str_replace("/", "", $prio) . "' and p_etape.libelle IN ( 'NRRG', 'ES','OK','NOK' )
			group by almerys_p_lot.id_cq,  p_lot_client.libelle order by almerys_p_lot.id_cq";

                $rsstotal = $this->cnx->query($sqltotal);
                $jj = 0;
                $total = 0;
                while ($totalb = $rsstotal->fetch()) {
                    if ($jj = 3)
                        $jj = 0;
                    if ($totalb['cq'] == $arrDoss['cq'] && $totalb['lib'] == $arrDoss['lib']) {
                        $total = $totalb['nb'];
                        break; 
                    }
                    $jj++;
                }
                $str .= "<tr class = 'classe" . $ii . "'><td>" . $arrDoss['cq'] . '</td><td>' . $arrDoss['lib'] . '</td><td>' . $total . '</td><td>' . $arrDoss['nb'] . '</td></tr>';
                $ii++;
            }
            $str.="<tr  class='th'>";
            $str.='</tr></table>';

            return $str;
        } else
            $sql .= $filtre . " ORDER BY " . $ordre;

        $folder = '../CSV/' . $_SESSION['id'];
        $this->clearDir($folder);
        if (!is_dir($folder))
            mkdir($folder, 0755, true);
        $fName = $folder . '/LOT_' . $_SESSION['id'] . '_' . $dossier . '_' . $lotClient . '_' . $etape . '.csv';
        $fw = fopen($fName, 'w');

        //$is_interial = false;

        $facture = $boolInterial ? "SECU" : "FACTURE";
        $decompte = $boolInterial ? "DECOMPTE" : "NUO";
        $PS = $boolInterial ? "" : "NUMERO PS";
        $POLE = $boolInterial ? "SPECIALITE" : "POLE";
        $etat = $boolInterial ? "<th  class='th' id='almerys_p_lot.etat'>ETAT</th>" : "";

        //return $sql;

        $str = "<table width='100%'>
		<thead><tr>
		
		<th  class='th' id='p_lot_client.libelle' class='filter'>$POLE</th>
		<th  class='th' id='almerys_p_lot.libelle'>NUMERO $facture</th>	
		<th  class='th' id='almerys_p_lot.num_nuo'>NUMERO $decompte</th>	
		<th  class='th' id='almerys_p_lot.num_ps'>$PS</th>
		<th  class='th' >NIVEAU</th>
		<th  class='th' id='almerys_p_lot.qte'>MONTANT RC</th>
		<th  class='th' id='almerys_p_lot.id_pers'>MATRICULE</th>
		<th  class='th' id='almerys_p_lot.priority'>SAT</th>
		<th  class='th' id='p_lot_client.id_cq' class='filter'>NOM CQ</th>
		<th  class='th' id='almerys_p_lot.p_etape'>ETAT</th>
		<th  class='th' id='almerys_p_lot.erreur'>ERREUR</th>
		<th  class='th' id='almerys_p_lot.id_rejet'>RETOUR</th>
		<th  class='th' id='almerys_p_lot.lib_rejet'>LIB RETOUR</th>$etat</tr>
		</thead>";

        $row = "POLE\tNIVEAU\tNUMERO FACTURE\tNUMERO NUO\tNUMERO PS\tMONTANT FACTURE\tERREUR\tDETAILS\tMATRICULE\tSAT\n";
        fwrite($fw, $row);

        $strCsv = "";

        //return $sql;
        $ii = 0;
        $nbResult = 0;
        $rs = $this->cnx->query($sql);

        //return $sql;
        foreach ($rs as $row) {
            $montant = (double) str_replace(",", ".", $row['qte']);
            $niveau = "";

            if ($boolInterial) {
                if ($montant >= 350)
                    $niveau = 'NIVEAU_A';
                if ($montant < 350)
                    $niveau = 'NIVEAU_B';
            }
            else {


                switch ($row['id_lotclient']) {
                    case 2385: //SE
                        if ($montant >= 100)
                            $niveau = 'NIVEAU_A';
                        if ($montant > 85 && $montant < 100)
                            $niveau = 'NIVEAU_B';
                        if ($montant <= 85)
                            $niveau = 'NIVEAU_C';

                        break;
                    case 2387: //HOSPI
                        if ($montant >= 2500)
                            $niveau = 'NIVEAU_A';
                        if ($montant > 2000 && $montant < 2500)
                            $niveau = 'NIVEAU_B';
                        if ($montant > 1500 && $montant <= 2000)
                            $niveau = 'NIVEAU_C';
                        if ($montant > 1000 && $montant <= 1500)
                            $niveau = 'NIVEAU_D';
                        if ($montant > 500 && $montant <= 1000)
                            $niveau = 'NIVEAU_E';
                        if ($montant > 300 && $montant <= 500)
                            $niveau = 'NIVEAU_F';
                        if ($montant <= 300)
                            $niveau = 'NIVEAU_G';
                        break;

                    case 2391: //HOSPI
                        if ($montant >= 2500)
                            $niveau = 'NIVEAU_A';
                        if ($montant > 2000 && $montant < 2500)
                            $niveau = 'NIVEAU_B';
                        if ($montant > 1500 && $montant <= 2000)
                            $niveau = 'NIVEAU_C';
                        if ($montant > 1000 && $montant <= 1500)
                            $niveau = 'NIVEAU_D';
                        if ($montant > 500 && $montant <= 1000)
                            $niveau = 'NIVEAU_E';
                        if ($montant > 300 && $montant <= 500)
                            $niveau = 'NIVEAU_F';
                        if ($montant <= 300)
                            $niveau = 'NIVEAU_G';
                        break;
                    case 2386: //OPTIQUE
                        if ($montant >= 700)
                            $niveau = 'NIVEAU_A';
                        if ($montant > 300 && $montant < 700)
                            $niveau = 'NIVEAU_B';
                        if ($montant <= 300)
                            $niveau = 'NIVEAU_C';
                        break;
                    case 2388: //SANTECLAIR
                        if ($montant >= 600)
                            $niveau = 'NIVEAU_A';
                        if ($montant > 300 && $montant < 600)
                            $niveau = 'NIVEAU_B';
                        if ($montant <= 300)
                            $niveau = 'NIVEAU_C';
                        break;
                    case 2390: //PUBLIPOSTAGE
                        if ($montant >= 700)
                            $niveau = 'NIVEAU_A';
                        if ($montant > 300 && $montant < 700)
                            $niveau = 'NIVEAU_B';
                        if ($montant <= 300)
                            $niveau = 'NIVEAU_C';
                        break;
                    case 2395: //INTERIAL

                    case 2462: //TPS
                        if ($montant >= 100)
                            $niveau = 'NIVEAU_A';
                        if ($montant > 85 && $montant < 100)
                            $niveau = 'NIVEAU_B';
                        if ($montant <= 85)
                            $niveau = 'NIVEAU_C';

                        break;

                    Default:
                        $niveau = 'NIVEAU_A';
                        break;
                }
            }

            $montantRC = "";
            if ($ii == 3)
                $ii = 0;
            $cl = 'classe' . $ii;
            $ii++;
            $str .= "<tr class = '" . $cl . " " . $niveau . "' id='" . $row['id_lot'] . "' >";


            $str .= "<td>" . $row['ldg'] . "</td>";
            if ($row['etape'] == 'Saisie')
                $str .= "<td  OnClick=getIdLotAlmerys('" . $row['id_lot'] . "')>" . $row['lib'] . "</td>";
            else
                $str .= "<td>" . $row['lib'] . "</td>";
            $str .= "<td>" . $row['num_nuo'] . "</td>";
            $str .= "<td>" . $row['num_ps'] . "</td>";
            $str .= "<td>" . $niveau . "</td>";
            $str .= "<td>" . $row['qte'] . "</td>";
            $str .= "<td>" . $row['id_pers'] . "</td>";
            $str .= "<td>" . $row['sat'] . "</td>";
            $str .= "<td>" . $row['nom'] . "</td>";
            $str .= "<td>" . $row['etape'] . "</td>";
            $str .= "<td>" . $row['erreur'] . "</td>";

            $rejet = $row['is_rejet'] == '1' ? 'R' : '';
            $str .= "<td>" . $rejet . "</td>";
            $str .= "<td>" . $row['lib_rejet'] . "</td>";
            if ($boolInterial == true)
                $str .= "<td>" . $row['etat_saisie'] . "</td>";
            //$str .= "<td><input type='checkbox'  class='case' name='options[]' id=".$row['id_lot'].">";
            //if ($_SESSION['id'] == '177')
            //$str .= "<td OnClick=deleteLot('".$row['id_lot']."') class='delete'></td>";

            $str .= "</tr>";
            $nbResult++;


            $sr = $row['ldg'] . "\t";
            $sr .= $niveau . "\t";
            $sr .= $row['lib'] . "\t";
            $sr .= $row['num_nuo'] . "\t";
            $sr .= $row['num_ps'] . "\t";
            $sr .= $row['qte'] . "\t";
            $sr .= $row['etape'] . "\t";
            $sr .= $row['erreur'] . "\t";
            $sr .= $row['id_pers'] . "\t";

            $sr .= $row['sat'] . "\t";
            $sr .= $row['nom'] . "\t";
            $sr .= $rejet . "\n";
            fwrite($fw, $sr);
        }

        fclose($fw);
        $str .= "</table>";
        $nbLigne = "</table><table><tr><td><h4>Total Found: $nbResult</h4></td><td><a href='./CSV/$fName'><input type='submit' value='' class='copy' title='Exporter au format CSV'/></a></td></tr></table>";

        return $nbLigne . $str;
    }


    function GetDureeLot($idLot) {
        $sql = "SELECT p_ldt.h_deb, p_ldt.h_fin, quantite FROM p_ldt where id_lot =" . $idLot;
        //return $sql;
        $rs = $this->cnx->query($sql);
        $qte = 0;
        $somme = "0:0:0";
        foreach ($rs as $row) {
            if ($row['h_deb'] == "" || $row['h_fin'] == "")
                continue;
            $diff = $this->hDiff($row['h_deb'], $row['h_fin'], "");
            $somme = $this->hDiff($somme, $diff, "+");
            $qte+=$row['quantite'];
        }
        return $somme . "$" . $qte;
    }

    function getIOUser() {
        if (!isset($_SESSION['pseudo']))
            return;
        $sqlPointage = "select pdate, source, entree from r_pointage where id_util = " . $_SESSION['id'] . " AND pdate = '" . date("Y/m/d") . "'  AND source ~ '[IN]|[OUT]' order by entree ";
        $rs1 = $this->cnx->query($sqlPointage);

        //return $sqlPointage;
        $str = "<div id='io_user'><table><tr><td> Entree/Sortie</td></tr><tr><td><table>";
        while ($arr1 = $rs1->fetch()) {
            $str .= "<tr><td>" . $arr1['source'] . "</td><td>" . $arr1['entree'] . "</td></tr>";
        }
        $str .= "</table></td></tr></table></div>";
        return $str;
    }

    function SuiviLot($dossier, $lotClient, $matricule, $statut, $etape, $prio, $name, $ordre) {
        $filtre = "";
        $filtreEtape = "";
        //if ($dossier != "") $filtre .= " AND p_dossier.id_dossier = $dossier";

        if ($lotClient != "")
            $filtre .= " AND p_lot.id_lotclient = $lotClient";
        if ($matricule != "")
            $filtre .= " AND p_lot.id_pers = $matricule";
        if ($statut != "")
            $filtre .= " AND p_lot.id_etat = $statut";
        if ($etape != "")
            $filtreEtape .= " AND p_lien_oper_dossier.id_lien = $etape";
        if ($prio != "")
            $filtre .= " AND p_lot.priority = $prio";
        if ($name != "")
            $filtre .= " AND p_lot.libelle like '%$name%'";


        $sql = "select id_lien, p_etape.libelle from p_lien_oper_dossier
				LEFT JOIN p_etape ON p_lien_oper_dossier.id_oper=p_etape.id_etape
				WHERE id_dossier = $dossier $filtreEtape order by id_lien";
        //echo $sql;
        $rs = $this->cnx->query($sql);
        $str = "<table width='100%'>
		<thead><tr>
		<th  class='th' width='20%' id='num_dossier' class='filter'>Ordre</th>
		<th  class='th' id='p_etape.libelle'>Etape</th>
		<th  class='th' id='p_etape.libelle'>Nombre Lot</th>
		<th  class='th' id='p_etat.libelle'>Libre</th>
		<th  class='th' id='p_etat.duree'>En cours pris</th>
		<th  class='th' id='p_etat.duree'>En cours non pris</th>
		<th  class='th' id='p_lot.id_pers'>Terminee</th>
		<th  class='th' id='p_lot.id_pers'>Duree</th>
		<th  class='th' id='p_lot.priority'>Autres</th>
		</tr></thead>";

        $i = 1;
        $ii = 0;


        while ($arr = $rs->fetch()) {

            $nbLot = 0;
            $statut0 = 0;
            $statut1 = 0;
            $statut2 = 0;
            $statut1_pris = 0;
            $statutAutre = 0;

            $dureeLotEtape = "0:0:0";

            if ($ii == 3)
                $ii = 0;
            $cl = 'classe' . $ii;
            $ii++;

            $sqlStatLot = "select id_etat, id_lot from p_lot where id_dossier = $dossier AND p_lot.id_etape =" . $arr['id_lien'] . $filtre;
            $rs1 = $this->cnx->query($sqlStatLot);
            while ($arr1 = $rs1->fetch()) {
                $nbLot++;
                $rez = explode('$', $this->GetDureeLot($arr1['id_lot']));
                $duree = $rez[0];
                // $qte =  $rez[1];
                // $vitesse = number_format(($this->ToSeconde($duree)*$qte)/3600, 2);

                $dureeLotEtape = $this->hDiff($dureeLotEtape, $duree, "+");

                switch ($arr1['id_etat']) {
                    case '0':
                        $statut0++;
                        break;
                    case '1':
                        // chercher si en cours pris
                        $d = date("Ymd", time());
                        $sqle = "SELECT p_ldt.h_deb FROM p_ldt where id_lot =" . $arr1['id_lot'] . " AND date_deb_ldt='$d'";
                        //return $sqle;
                        $rse = $this->cnx->query($sqle);
                        foreach ($rse as $row) {
                            $statut1_pris++;
                            break;
                        }
                        $statut1++;
                        break;
                    case '2':
                        $statut2++;
                        break;
                    Default:
                        $statutAutre++;
                        break;
                }
            }
            $str .= "<tr class = $cl id='" . $arr['id_lien'] . "' >";
            $str .= "<td>" . $i++ . "</td>";
            $str .= "<td>" . $arr['libelle'] . "</td>";
            $str .= "<td>" . $nbLot . "</td>";
            $str .= "<td>" . $statut0 . "</td>";
            $str .= "<td>" . $statut1 . "</td>";
            $str .= "<td>" . $statut1_pris . "</td>";
            $str .= "<td>" . $statut2 . "</td>";
            $str .= "<td>" . $dureeLotEtape . "</td>";
            $str .= "<td>" . $statutAutre . "</td></tr>";
        }
        $str .= "</table>";
        return $str;
    }

    function SuiviLotAlmerys($dossier, $lotClient, $matricule, $statut, $etape, $prio, $name, $ordre, $is_interial) {
        $filtre = "";
        if ($dossier != "")
            $filtre .= " AND p_dossier.id_dossier = $dossier";

        if ($lotClient != "")
            $filtre .= " AND almerys_p_lot.id_lotclient = $lotClient";
        if ($matricule != "")
            $filtre .= " AND almerys_p_lot.id_pers = $matricule";

        if ($etape != "")
            $filtre .= " AND almerys_p_lot.id_etape = $etape";

        if ($name != "")
            $filtre .= " AND almerys_p_lot.libelle like '%$name%'";

        if ($prio != "")
            $filtre .= " AND almerys_p_lot.date_deb = '$prio'";

        //$filtre .= " AND almerys_p_lot.id_pers IN (select matricule from almerys_user where id_cq = ".$_SESSION['id'].')';

        $sql = "SELECT  almerys_p_lot.id_etape, p_dossier.num_dossier, p_lot_client.libelle as ldg,almerys_p_lot.id_lotclient, almerys_p_lot.id_lot,almerys_p_lot.libelle as lib, p_etat.libelle as etat, p_etape.libelle as etape ,almerys_p_lot.id_pers, almerys_p_lot.priority, almerys_p_lot.id_pers, almerys_p_lot.duree, almerys_p_lot.qte, almerys_p_lot.erreur
		FROM almerys_p_lot
        LEFT JOIN p_etat ON almerys_p_lot.id_etat= p_etat.id_etat
		LEFT JOIN p_lien_oper_dossier ON almerys_p_lot.id_etape= p_lien_oper_dossier.id_lien
		LEFT JOIN p_etape ON p_etape.id_etape= p_lien_oper_dossier.id_oper
		LEFT JOIN p_lot_client ON almerys_p_lot.id_lotclient = p_lot_client.id_lotclient
		LEFT JOIN p_dossier ON p_lot_client.id_dossier = p_dossier.id_dossier

		WHERE is_interial=$is_interial";

        //return $is_interial;
        $sql .= $filtre . " order by lib";

        $str = "";
        $rs = $this->cnx->query($sql);

        $nbSaisie = 0;
        $nbFdc = 0;
        $nbOK = 0;
        $nbNOK = 0;
        $nbES = 0;
        $nbNRRG = 0;
        $nbAtt = 0;

        //return $sql.'\n';
        foreach ($rs as $row) {

            /*
              <option value="943">Saisie</option>
              <option value="945">OK</option>
              <option value="946">NOK</option>
              <option value="947">NRRG</option>
              <option value="948">ES</option>

              $nbSaisie=0;
              $nbOK=0;
              $nbNOK=0;
              $nbES=0;
              $nbNRRG=0;

             */

            switch ($row['id_etape']) {
                case 943:
                    $nbSaisie++;
                    break;
                case 945:
                    $nbOK++;
                    $nbFdc++;
                    break;
                case 946:
                    $nbNOK++;
                    $nbFdc++;
                    break;
                case 947:
                    $nbNRRG++;
                    $nbNOK++;
                    $nbFdc++;
                    break;
                case 948:
                    $nbES++;
                    $nbNOK++;
                    $nbFdc++;
                    break;
                case 1007:
                    $nbAtt++;
                    //$nbFdc++;
                    break;
                Default:

                    break;
            }
        }
        if (!empty($row['ldg'])) {
            $ldgname = ($lotClient != "") ? $row['ldg'] : '<h3>TOTAL:</h3>';
            $str .= "
				<td>" . $ldgname . "</td>
				<td>$nbSaisie</td>
				<td>$nbFdc</td>
				<td>$nbOK</td>
				<td>$nbNOK</td>
				<td>$nbES</td>
				<td>$nbNRRG</td>
				<td>$nbAtt</td>";
        }

        return $str;
    }

    function _suiviParMois($mois) {
        $sql = "SELECT p_ldt.date_deb_ldt,  p_ldt.h_deb, p_ldt.h_fin  FROM p_ldt

				where p_ldt.date_deb_ldt like '" . $mois . "%' order by p_ldt.date_deb_ldt, p_ldt.h_deb";

        //return $sql;
        $rs = $this->cnx->query($sql);

        $str = "<table  class='hj'>
		<thead><tr>
		<th  class='th' width='20%' id='num_dossier' class='filter'>Date</th>
		<th  class='th' id='p_etape.libelle'>Volume Horaire</th>
		</tr></thead>";

        $ii = 0;

        $diff;
        $somme = "0:0:0";
        $lastDate = "";

        foreach ($rs as $row) {
            if ($ii >= 3)
                $ii = 0;
            if ($row['h_deb'] == "" || $row['h_fin'] == "")
                continue;

            $cl = 'classe' . $ii;

            if ($lastDate != $row['date_deb_ldt']) {
                $hdec = $this->ToHeureDecimal($somme);
                if ($lastDate != "") {
                    $str .= "<tr class = $cl>";
                    $str .= "<td id='$" . $lastDate . '|' . $hdec . ">" . $lastDate . "</td>";
                    $str .= "<td>" . $hdec . "</td>";
                    $str .= "</tr>";
                }
                $somme = "0:0:0";
                $ii++;
            }

            $lastDate = $row['date_deb_ldt'];
            $diff = $this->hDiff($row['h_deb'], $row['h_fin'], "");
            $somme = $this->hDiff($somme, $diff, "+");
        }
        $str .= "</table>";
        return $str;
    }

    function suiviParMois($mois) {

        $sql = "SELECT p_ldt.date_deb_ldt,  p_ldt.h_deb, p_ldt.h_fin  FROM p_ldt

				where p_ldt.date_deb_ldt like '" . $mois . "%' order by p_ldt.date_deb_ldt, p_ldt.h_deb";

        $sql = "SELECT SUM(DATE_PART('epoch', ('2011-12-29 '||h_fin)::timestamp - ('2011-12-29 '||h_deb)::timestamp )) as somme, p_ldt.date_deb_ldt  from p_ldt where p_ldt.date_deb_ldt like '" . $mois . "%' group by p_ldt.date_deb_ldt order by p_ldt.date_deb_ldt ";

        //return $sql;
        $rs = $this->cnx->query($sql);

        $str = "<table  class='hj'>
		<thead><tr>
		<th  class='th' width='20%' id='num_dossier' class='filter'>Date</th>
		<th  class='th' id='p_etape.libelle'>Volume Horaire</th>
		</tr></thead>";

        $ii = 0;

        $diff;
        $somme = "0:0:0";
        $lastDate = "";

        foreach ($rs as $row) {
            $cl = 'classe' . $ii++;
            if ($ii >= 3)
                $ii = 0;
            $str .= "<tr class = $cl>";
            $str .= "<td id='$" . $row['date_deb_ldt'] . '|' . $row['somme'] . ">" . $row['date_deb_ldt'] . "</td>";
            $str .= "<td>" . $row['somme'] . "</td>";
            $str .= "</tr>";
        }

        $str .= "</table>";
        echo $str;
    }

    function suiviDossierPeriode($lstPeriode) {
        $periode = $lstPeriode;
        $filtrePeriode = " AND p_ldt.date_deb_ldt = '" . $lstPeriode . "'";
        $tk = explode(",", $lstPeriode);

        if (count($tk) > 1) {
            $filtrePeriode = " AND p_ldt.date_deb_ldt >=  '" . $tk[0] . "' AND p_ldt.date_deb_ldt <= '" . $tk[1] . "'";
        }
        $sqlDoss = "select id_dossier, num_dossier from p_dossier order by num_dossier";

        $rsDoss = $this->cnx->query($sqlDoss);
        $str = "<table class='dp'><thead><tr>";
        $str .= "<th>PERIODE</th>";
        $str .= "<th>DOSSIER</th>";
        $str .= "<th>DUREE PRODUCTION</th>";
        $str .= "<th>PAUSE</th>";
        $str .= "<th>PANNE</th>";
        $str .= "<th>FORMATION</th>";
        $str .= "<th>EXO</th>";
        $str .= "<th>AUTRE HORS PROD</th></tr></thead>";
        $ii = 0;

        foreach ($rsDoss as $rowDoss) {
            $dossier = $rowDoss['id_dossier'];
            //$str .= "<td>".$dossier."</td>";
            //:: selection utilisateur affecté au dossier
            //continue;

            $sql = "SELECT date_deb_ldt, h_deb, h_fin, id_type_ldt FROM p_ldt WHERE id_dossier = $dossier " . $filtrePeriode . " order by p_ldt.date_deb_ldt, p_ldt.h_deb";

            //return $sqlDoss;

            $rs = $this->cnx->query($sql);
            $diff;
            $somme = "0:0:0";
            $pause = "0:0:0";
            $panne = "0:0:0";
            $formation = "0:0:0";
            $exo = "0:0:0";
            $formation = "0:0:0";
            $autres = "0:0:0";

            //if ($dossier == "") continue;

            foreach ($rs as $row) {
                if ($row['h_deb'] == "" || $row['h_fin'] == "")
                    continue;
                if (strlen($row['h_deb']) != 8 || strlen($row['h_deb']) != 8)
                    continue;
                $diff = $this->hDiff($row['h_deb'], $row['h_fin'], "");


                //$str .= '<br/>'.$row['id_type_ldt'];
                switch ($row['id_type_ldt']) {
                    case "0":
                        $somme = $this->hDiff($somme, $diff, "+");
                        break;
                    case "1":
                        $pause = $this->hDiff($pause, $diff, "+");
                        break;
                    case "2":
                        $formation = $this->hDiff($formation, $diff, "+");
                        break;
                    case "3":
                        $autres = $this->hDiff($autres, $diff, "+");
                        break;
                    case "4":
                        $pause = $this->hDiff($pause, $diff, "+");
                        break;
                    case "5":
                        $panne = $this->hDiff($panne, $diff, "+");
                        break;
                    case "6":
                        $panne = $this->hDiff($panne, $diff, "+");
                        break;
                    case "7":
                        $panne = $this->hDiff($panne, $diff, "+");
                        break;
                    case "8":
                        $autres = $this->hDiff($autres, $diff, "+");
                        break;
                    case "9":
                        $pause = $this->hDiff($pause, $diff, "+");
                        break;
                    case "10":
                        $autres = $this->hDiff($autres, $diff, "+");
                        break;
                    case "11":
                        $autres = $this->hDiff($autres, $diff, "+");
                        break;
                    case "12":
                        $autres = $this->hDiff($autres, $diff, "+");
                        break;
                    case "13":
                        $autres = $this->hDiff($autres, $diff, "+");
                        break;
                    case "14":
                        $autres = $this->hDiff($autres, $diff, "+");
                        break;
                    case "15":
                        $exo = $this->hDiff($exo, $diff, "+");
                        break;
                    default:
                        $autres = $this->hDiff($autres, $diff, "+");
                        break;
                }
            }
            if ($somme == "0:0:0")
                continue;
            //$rs->close();
            if ($ii >= 3)
                $ii = 0;
            $cl = 'classe' . $ii;
            $ii++;

            $nomDossier = $rowDoss['num_dossier'];
            $str .= "<tr class = $cl>";
            $str .= "<td>" . $ii . $periode . "</td>";
            $str .= "<td>" . $nomDossier . "</td>";
            $str .= "<td>" . $this->ToHeureDecimal($somme) . "</td>";
            $str .= "<td>" . $this->ToHeureDecimal($pause) . "</td>";
            $str .= "<td>" . $this->ToHeureDecimal($panne) . "</td>";
            $str .= "<td>" . $this->ToHeureDecimal($formation) . "</td>";
            $str .= "<td>" . $this->ToHeureDecimal($exo) . "</td>";
            $str .= "<td>" . $this->ToHeureDecimal($autres) . "</td>";
            $str .= "</tr>";
            $diff;
            $somme = "0:0:0";
            $pause = "0:0:0";
            $panne = "0:0:0";
            $formation = "0:0:0";
            $attente = "0:0:0";
            $formation = "0:0:0";
            $autres = "0:0:0";
        }
        $str .= "</table>";
        return $str;
    }

    function suiviDossierPeriodeSave($lstPeriode) {
        $periode = $lstPeriode;
        $filtrePeriode = " AND p_ldt.date_deb_ldt = '" . $lstPeriode . "'";
        $tk = explode(",", $lstPeriode);

        if (count($tk) > 1) {
            $filtrePeriode = " AND p_ldt.date_deb_ldt >=  '" . $tk[0] . "' AND p_ldt.date_deb_ldt <= '" . $tk[1] . "'";
        }
        $sqlDoss = "select id_dossier, num_dossier from p_dossier";

        $rsDoss = $this->cnx->query($sqlDoss);
        $str = "<table class='dp'>";
        $ii = 0;

        return $sqlDoss;
        foreach ($rsDoss as $rowDoss) {
            $dossier = $rowDoss['id_dossier'];
            //$str .= "<td>".$dossier."</td>";
            //:: selection utilisateur affecté au dossier
            //continue;

            $sql = "SELECT date_deb_ldt, h_deb, h_fin FROM p_ldt WHERE id_dossier = " . $rowDoss['id_dossier'] . $filtrePeriode . " order by p_ldt.date_deb_ldt, p_ldt.h_deb";

            //return $sqlDoss;

            $rs = $this->cnx->query($sql);
            $diff;
            $somme = "0:0:0";
            if ($dossier == "")
                continue;

            foreach ($rs as $row) {
                if ($row['h_deb'] == "" || $row['h_fin'] == "")
                    continue;
                if (strlen($row['h_deb']) != 8 || strlen($row['h_deb']) != 8)
                    continue;
                $diff = $this->hDiff($row['h_deb'], $row['h_fin'], "");
                $somme = $this->hDiff($somme, $diff, "+");
            }
            if ($somme == "0:0:0")
                continue;
            //$rs->close();
            if ($ii >= 3)
                $ii = 0;
            $cl = 'classe' . $ii;
            $ii++;

            $nomDossier = $rowDoss['num_dossier'];
            if ($nomDossier == "")
                $nomDossier = "Hors prod";
            $str .= "<tr class = $cl>";
            $str .= "<td>" . $periode . "</td>";
            $str .= "<td>" . $nomDossier . "</td>";
            $str .= "<td>" . $somme . "</td>";
            $str .= "</tr>";
        }
        $str .= "</table>";
        return $str;
    }

    function dureeHorsProd($lstPeriode) {
        $periode = $lstPeriode;
        $filtrePeriode = " AND p_ldt.date_deb_ldt = '" . $lstPeriode . "'";
        $tk = explode(",", $lstPeriode);

        if (count($tk) > 1) {
            $filtrePeriode = " AND p_ldt.date_deb_ldt >=  '" . $tk[0] . "' AND p_ldt.date_deb_ldt <= '" . $tk[1] . "'";
        }
        $sqlDoss = "select id_dossier, num_dossier from p_dossier where id_etat = 0";

        $rsDoss = $this->cnx->query($sqlDoss);
        $str = "<table class='dp'>";
        $ii = 0;

        foreach ($rsDoss as $rowDoss) {
            $dossier = $rowDoss['id_dossier'];
            $sql = "SELECT date_deb_ldt, h_deb, h_fin FROM p_ldt WHERE id_type_ldt <> 0 " . $filtrePeriode . " order by p_ldt.date_deb_ldt, p_ldt.h_deb";

            $rs = $this->cnx->query($sql);
            $diff;
            $somme = "0:0:0";
            if ($dossier != "")
                continue;
            foreach ($rs as $row) {
                if ($row['h_deb'] == "" || $row['h_fin'] == "")
                    continue;
                $diff = $this->hDiff($row['h_deb'], $row['h_fin'], "");
                $somme = $this->hDiff($somme, $diff, "+");
            }
            //$rs->close();
            if ($ii >= 3)
                $ii = 0;
            $cl = 'classe' . $ii;
            $ii++;

            $nomDossier = $rowDoss['num_dossier'];
            if ($nomDossier == "")
                $nomDossier = "Hors prod";
            $str .= "<tr class = $cl>";
            $str .= "<td>" . $periode . "</td>";
            $str .= "<td>" . $nomDossier . "</td>";
            $str .= "<td>" . $somme . "</td>";
            $str .= "</tr>";
        }
        $str .= "</table>";
        return $str;
    }

    function getLstEtape($dossier) {
        $sql = "select id_lien, p_etape.libelle from p_lien_oper_dossier
				LEFT JOIN p_etape ON p_lien_oper_dossier.id_oper=p_etape.id_etape
				WHERE id_dossier = $dossier order by id_lien";
        $rs = $this->cnx->query($sql);
        $str = '<option value=""></option>';
        ;
        while ($arr = $rs->fetch()) {
            $str .= '<option value="' . $arr['id_lien'] . '">' . $arr['libelle'] . '</option>';
        }
        return $str;
    }

    function suiviDossierEtape($lstPeriode, $dossier) {
        $periode = $lstPeriode;
        $filtrePeriode = " where p_ldt.date_deb_ldt = '" . $lstPeriode . "'";
        $tk = explode(",", $lstPeriode);

        if (count($tk) > 1) {
            $filtrePeriode = " where p_ldt.date_deb_ldt >=  '" . $tk[0] . "' AND p_ldt.date_deb_ldt <= '" . $tk[1] . "'";
        }
        $filtrePeriode .= " AND p_ldt.id_dossier = $dossier";
        $sqlLstEtape = "select distinct(id_etape) from p_ldt " . $filtrePeriode;

        $sqlLstEtape = "select id_lien, p_etape.libelle from p_lien_oper_dossier
							LEFT JOIN p_etape ON p_lien_oper_dossier.id_oper=p_etape.id_etape
							WHERE id_dossier = $dossier order by id_lien";

        $rsEtape = $this->cnx->query($sqlLstEtape);
        $str = "<table class='je'>";
        $ii = 0;

        //return $sqlDoss;
        foreach ($rsEtape as $rowDoss) {
            $etape = $rowDoss['id_lien'];
            $sql = "SELECT date_deb_ldt, h_deb, h_fin FROM p_ldt
					$filtrePeriode AND p_ldt.id_etape = $etape order by p_ldt.date_deb_ldt, p_ldt.h_deb";

            $rs = $this->cnx->query($sql);
            $diff;
            $somme = "0:0:0";

            //echo $sql;
            foreach ($rs as $row) {
                if (count(explode(":", $row['h_deb'])) != 3 || count(explode(":", $row['h_fin'])) != 3)
                    continue;

                $diff = $this->hDiff($row['h_deb'], $row['h_fin'], "");
                $somme = $this->hDiff($somme, $diff, "+");
            }
            if ($somme == "0:0:0")
                continue;
            if ($ii >= 3)
                $ii = 0;
            $cl = 'classe' . $ii;
            $ii++;

            $nomDossier = $this->getNumDossier($dossier);
            if ($nomDossier == "")
                $nomDossier = "Hors prod";
            $str .= "<tr class = $cl>";
            $str .= "<td>" . $periode . "</td>";
            $str .= "<td>" . $nomDossier . "</td>";
            $str .= "<td>" . $rowDoss['libelle'] . "</td>";
            $str .= "<td>" . $somme . "</td>";
            $str .= "</tr>";
        }
        $str .= "</table>";
        return $str;
    }

    function suiviDossierEtape4($lstPeriode, $dossier) {
        $periode = $lstPeriode;
        $filtrePeriode = " where p_ldt.date_deb_ldt = '" . $lstPeriode . "'";
        $tk = explode(",", $lstPeriode);

        if (count($tk) > 1) {
            $filtrePeriode = " where p_ldt.date_deb_ldt >=  '" . $tk[0] . "' AND p_ldt.date_deb_ldt <= '" . $tk[1] . "'";
        }
        $filtrePeriode .= " AND p_ldt.id_dossier = $dossier";
        $sqlDoss = "select distinct(id_etape) from p_ldt " . $filtrePeriode;

        $rsDoss = $this->cnx->query($sqlDoss);
        $str = "<table class='je'>";
        $ii = 0;

        //return $sqlDoss;
        /*

          lister les etapes concerné


         */
        foreach ($rsDoss as $rowDoss) {
            $etape = $rowDoss['id_etape'];
            $sql = "SELECT date_deb_ldt, h_deb, h_fin, num_dossier, p_etape.libelle  FROM p_ldt
					LEFT JOIN p_dossier ON p_ldt.id_dossier=p_dossier.id_dossier
					LEFT JOIN p_lien_oper_dossier ON p_ldt.id_etape=p_lien_oper_dossier.id_lien
					LEFT JOIN p_etape ON p_lien_oper_dossier.id_oper=p_etape.id_etape
					$filtrePeriode AND p_ldt.id_etape = $etape order by p_ldt.date_deb_ldt, p_ldt.h_deb";

            $rs = $this->cnx->query($sql);
            $diff;
            $somme = "0:0:0";

            //return $sql;
            foreach ($rs as $row) {
                if ($row['h_deb'] == "" || $row['h_fin'] == "")
                    continue;
                $diff = $this->hDiff($row['h_deb'], $row['h_fin'], "");
                $somme = $this->hDiff($somme, $diff, "+");
            }

            if ($ii >= 3)
                $ii = 0;
            $cl = 'classe' . $ii;
            $ii++;

            $nomDossier = $row['num_dossier'];
            if ($nomDossier == "")
                $nomDossier = "Hors prod";
            $str .= "<tr class = $cl>";
            $str .= "<td>" . $periode . "</td>";
            $str .= "<td>" . $nomDossier . "</td>";
            $str .= "<td>" . $row['libelle'] . "</td>";
            $str .= "<td>" . $somme . "</td>";
            $str .= "</tr>";
        }
        $str .= "</table>";
        return $str;
    }

    function UpdateCqLot($qt, $err, $stat, $id, $lib, $com, $ldg, $doss, $id_pers, $id_nuo, $id_etat, $id_ps, $is_interial, $is_rejet, $idMotifRejet) {
        if ((isset($_SESSION['id'])) && (!empty($_SESSION['id']))) {

        } else {
            $menu = '';
            $menu .= '<a href="#"  id="logIN"><BLINK>Connexion</BLINK></a>';
            echo $menu;

            $pos = strpos($PHP_SELF, "index");
            if ($pos === false) {
                //header('Location: index.php');

                echo '<script language="Javascript">
				<!--
				document.location.replace("index.php");
				// -->
				</script>';
            }
        }



        $sql = "INSERT INTO almerys_p_lot (id_dossier, id_lotclient, id_etat,id_etape,libelle, date_deb, h_deb, qte, erreur, id_pers, id_cq, num_nuo, num_ps, is_interial, etat, is_rejet, id_motif_rejet)VALUES (" . $doss . "," . $ldg . ",0," . $stat . ",'" . $lib . "', substr(now()|| ' ', 0, 5)||substr(now()|| ' ', 6, 2)||substr(now()|| ' ', 9, 2), substr(now()|| ' ', 12, 8), '" . $qt . "', '" . $err . "', " . $id_pers . ", " . $_SESSION['id'] . ", '" . $id_nuo . "', '" . $id_ps . "', $is_interial, '" . $id_etat . "', $is_rejet, $idMotifRejet)";
        //return $sql;
        if ($this->cnx->exec($sql) != 0) {
            if ($this->cnx->exec("update almerys_p_lot set id_etat = 2 where id_lot = $id") != 0)
                return "";
            return "Error Request :: Veuillez le signaler aux reponsable => INSERT INTO almerys_p_lot (id_dossier, id_lotclient, id_etat,id_etape,libelle, date_deb, h_deb, qte, erreur, id_pers, id_cq, num_nuo, num_ps, is_interial, etat, is_rejet, id_motif_rejet)VALUES (" . $doss . "," . $ldg . ",0," . $stat . ",'" . $lib . "', substr(now()|| ' ', 0, 5)||substr(now()|| ' ', 6, 2)||substr(now()|| ' ', 9, 2), substr(now()|| ' ', 12, 8), '" . $qt . "', '" . $err . "', " . $id_pers . ", " . $_SESSION['id'] . ", '" . $id_nuo . "', '" . $id_ps . "', $is_interial, '" . $id_etat . "', $is_rejet, $idMotifRejet)";
        }
        return 'Possible Doublon!, attention!.';
    }

    function getLstDossier() {
        $sql = "SELECT p_affectation.id_dossier,p_dossier.num_dossier FROM p_affectation LEFT JOIN p_dossier ON p_affectation.id_dossier = p_dossier.id_dossier WHERE id_pers=" . $_SESSION['id'] . " AND id_etat = 0 ORDER BY num_dossier ASC";
        $rs = $this->cnx->query($sql);
        $str = "";
        //return $sql;
        while ($arr = $rs->fetch()) {
            $str .= '<option value="' . $arr['id_dossier'] . '">' . $arr['num_dossier'] . '</option>';
        }

        return $str;
    }

    function getLstDosdsier() {
        $sql = "select id_dossier, num_dossier from p_dossier  where id_etat <> 4 order by num_dossier";
        $rs = $this->cnx->query($sql);
        $str = "";
        while ($arr = $rs->fetch()) {
            $str .= '<option value="' . $arr['id_dossier'] . '">' . $arr['num_dossier'] . '</option>';
        }

        return $str;
    }

    function getLotClient($idDossier) {
        $sql = "select id_lotclient, libelle from p_lot_client WHERE id_dossier = $idDossier AND id_etat <> 2 order by id_lotclient DESC";
        $rs = $this->cnx->query($sql);
        $str = '<option value=""> </option>';
        while ($arr = $rs->fetch()) {
            $str .= '<option value="' . $arr['id_lotclient'] . '">' . $arr['libelle'] . '</option>';
        }
        return $str;
    }

    function getSuiviDossier($pDate, $pEtape, $pMat, $pTypeEtape, $Dossier) {
        $date = " And p_ldt.date_deb_ldt = '" . $pDate . "'";
        if ($pDate == "")
            $date = "";

        $matricule = " And p_ldt.id_pers = " . $pMat;
        if ($pMat == "")
            $matricule = "";

        $typeEtape = " And p_ldt.id_type_ldt = " . $pTypeEtape;
        if ($pTypeEtape == "")
            $typeEtape = "";

        $numDossier = " And p_ldt.id_dossier = " . $Dossier;
        if ($Dossier == "")
            $numDossier = "";

        $etape = " And p_ldt.id_etape = " . $pEtape;
        if ($pEtape == "")
            $etape = "";

        $filtre = $date . $matricule . $typeEtape . $numDossier . $etape;

        $sql = "SELECT p_ldt.date_deb_ldt, r_personnel.appelation, r_personnel.matricule, p_dossier.num_dossier,p_etape.libelle as etapLibelle, p_ldt.h_deb, p_ldt.h_fin,r_personnel.departement, p_type_ldt.libelle  FROM p_ldt
				LEFT JOIN p_dossier ON p_ldt.id_dossier=p_dossier.id_dossier
				LEFT JOIN p_lot_client ON p_ldt.id_lotclient=p_lot_client.id_lotclient
				LEFT JOIN p_lien_oper_dossier ON p_ldt.id_etape=p_lien_oper_dossier.id_lien
				LEFT JOIN p_etape ON p_lien_oper_dossier.id_oper=p_etape.id_etape
				LEFT JOIN p_type_ldt on p_type_ldt.id_type_ldt = p_ldt.id_type_ldt
				LEFT JOIN r_personnel ON r_personnel.id_pers=p_ldt.id_pers
				where 1=1" . $filtre;

        //return $sql;
        $rs = $this->cnx->query($sql);

        $str = "<table class='tbLate'>";
        $ii = 0;

        $diff;
        $somme = "0:0:0";

        foreach ($rs as $row) {
            if ($ii == 3)
                $ii = 0;
            if ($row['h_deb'] == "" || $row['h_fin'] == "")
                continue;
            $diff = $this->hDiff($row['h_deb'], $row['h_fin'], "");
            $somme = $this->hDiff($somme, $diff, "+");

            $cl = 'classe' . $ii;
            $ii++;
            $str .= "<tr class = $cl>";
            $str .= "<td>" . $row['h_deb'] . "</td>";
            $str .= "<td>" . $row['h_fin'] . "</td>";
            $str .= "<td>" . $diff . "</td>";
            $str .= "<td>" . $somme . "</td>";
            $str .= "</tr>";
        }
        $str .= "</table>";
        return $str;
    }

    function getLate($date, $dpt) {

        $qdate = "";
        $qdpt = "";
        if ($date != "") {
            $qdate = " AND r_retard.date_retard='" . $date . "'";
        }
        if ($dpt != "") {
            $qdpt = " AND r_retard.id_pers = r_personnel.id_pers AND r_personnel.departement = '" . $dpt . "' ";
        }
        $sql_Late = "SELECT r_retard.id_pers as matricule, r_personnel.nom as nom, r_personnel.prenom as prenom, r_retard.heure_entree_theo as heure_entree_theo , r_retard.heure_entree_reel as heure_entree_reel, r_retard.duree_retard as duree_retard, r_retard.date_retard as date_retard FROM r_personnel, r_retard WHERE r_personnel.id_pers = r_retard.id_pers";
        $sql_Late .=$qdate . $qdpt;
        $sql_Late .=" ORDER BY r_retard.id_retard ";

        $rs_Late = $this->cnx->query($sql_Late);

        $str = "<table class='tbLate'><thead><tr><th>Matricule</th>
			<th>Nom</th>
			<th>Prenom</th>
			<th>Heure entree theorique</th>
			<th>Heure arrivee</th>
			<th>Duree retard</th>
			<th>Date retard</th></tr></thead>";
        $ii = 0;


        foreach ($rs_Late as $row) {
            if ($ii == 3)
                $ii = 0;

            $cl = 'classe' . $ii;
            $ii++;
            $str .= "<tr class = $cl>";
            $str .= "<td>" . $row['matricule'] . "</td>";
            $str .= "<td>" . $row['nom'] . "</td>";
            $str .= "<td>" . $row['prenom'] . "</td>";
            $str .= "<td>" . $row['heure_entree_theo'] . "</td>";
            $str .= "<td>" . $row['heure_entree_reel'] . "</td>";
            $str .= "<td>" . $row['duree_retard'] . "</td>";
            $str .= "<td>" . $row['date_retard'] . "</td>";
            $str .= "</tr>";
        }
        $str .= "</table>";
        return $str;
    }

    function getDateAbs() {
        $sql = "SELECT distinct(date_abs) FROM r_absence  ORDER BY date_abs ASC";
        $rs = $this->cnx->query($sql);
        $str = "";
        while ($arr = $rs->fetch()) {
            $str .= '<option value="' . $arr['date_abs'] . '">' . $arr['date_abs'] . '</option>';
        }
        return $str;
    }

    function getListAbsence($date) {
        if ($date == "")
            $sql_abs = "select id_abs, r_absence.id_pers,r_personnel.nom ,r_personnel.prenom, date_abs,motif from r_absence ,r_personnel where r_absence.id_pers=r_personnel.id_pers ";
        else {
            $sql_abs = "select id_abs, r_absence.id_pers,r_personnel.nom ,r_personnel.prenom , date_abs,motif from r_absence,r_personnel where r_absence.id_pers=r_personnel.id_pers and date_abs='" . $date . "'";
        }
        $ii = 0;

        $rs = $this->cnx->query($sql_abs);
        $str = "<table class='tbAbsence'>
      <thead>
        <tr>
          <th>Identifiant absence </th>
          <th>Identifiant Personnel </th>
          <th>Nom </th>
          <th>Prenom </th>
          <th>Date Absence </th>
          <th>Motif </th>
        </tr>
      </thead>";
        while ($arr = $rs->fetch()) {
            if ($ii == 3)
                $ii = 0;

            $cl = 'classe' . $ii;
            $ii++;
            $str .= "<tr class= $cl>";
            $str .="<td>" . $arr['id_abs'] . "</td>";
            $str .= "<td>" . $arr['id_pers'] . "</td>";
            $str .= "<td>" . $arr['nom'] . "</td>";
            $str .= "<td>" . $arr['prenom'] . "</td>";
            $str .= "<td>" . $arr['date_abs'] . "</td>";
            $str .= "<td>" . $arr['motif'] . "</td>";
            $str .="</tr>";
        }
        $str .="</table>";
        return $str;
    }

    // Retourne les lignes de temps
    // $p_type_get in ('tous', 'util', 'proj', 'appli')
    function get_ldt($p_type_get, $p_param, $p_deb, $p_fin) {

        $sql = "select ldt.id, util.login, ldt.id_appli, ldt.debut, ldt.fin, ldt.commentaires, typ.designation";
        $sql = $sql . " from ldt, utilisateurs as util, types_ldt as typ";
        $sql = $sql . " where ldt.id_util=util.id and ldt.id_type=typ.id";

        switch ($p_type_get) {
            case 'util':
                $sql = $sql . " and util.login='$p_param'";
                break;
            case 'proj':
                $sql = $sql . " and ldt.id_appli in (select appli.id from applications as appli, projets as proj";
                $sql = $sql . " where appli.id_proj=proj.id and proj.designation='$p_param')";
                break;
            case 'appli':
                $sql = $sql . " and ldt.id_appli=(select id from applications where designation='$p_param')";
                break;
        }
        if ($p_deb) {
            $sql = $sql . " and ldt.debut > $p_deb";
        }
        if ($p_fin) {
            $sql = $sql . " and ldt.debut < $p_deb + 1";
        }
        $rs = $cnx->Execute($sql);
        $res = $rs->GetArray();
        $rs->Close();

        return $res;
    }

    function insertLDT($P, $O, $S, $C, $Q, $E) {
        $d = date("Y/m/d", time());
        $h = date("H:i:s", time());
        $U = $_SESSION['id'];
        $sql = "INSERT INTO p_ldt (d_date, h_deb, projet, operation, statut, id_util, commentaire, quantite, nbre_erreur) values ('$d','$h','$P','$O', '$S', $U, '$C', '$Q', '$E')";
        if ($this->cnx->exec($sql)) {
            return 1;
        }
        return 0;
    }

    function getLDG() {
        $sql = "SELECT distinct(num_dossier), id_dossier FROM p_dossier where id_etat <> 4 order by num_dossier";
        $rs = $this->cnx->query($sql);
        $str = '<option value="_"> </option>';
        while ($arr = $rs->fetch()) {
            $str .= '<option value="' . $arr['id_dossier'] . '">' . $arr['num_dossier'] . '</option>';
        }
        return $str;
    }

    function getNumDossier($idDossier) {
        $sql = "SELECT num_dossier FROM p_dossier where id_dossier=$idDossier";
        $rs = $this->cnx->query($sql);
        while ($arr = $rs->fetch())
            return $arr['num_dossier'];
    }


	function getDepartement() {
        $sql = "SELECT libelle, id FROM r_departement order by libelle";
        $rs = $this->cnx->query($sql);
        $str = '';
        while ($arr = $rs->fetch()) {
            $str .= '<option value="' . $arr['id'] . '">' . $arr['libelle'] . '</option>';
        }
        return $str;
    }

    function getEtats() {
        $sql = "SELECT distinct(id_etat), libelle FROM p_etat";
        $rs = $this->cnx->query($sql);
        $str = '<option value="_"> </option>';
        while ($arr = $rs->fetch()) {
            $str .= '<option value="' . $arr['id_etat'] . '">' . $arr['libelle'] . '</option>';
        }
        return $str;
    }

    function getTypeLdt() {
        $sql = "SELECT id_type_ldt, libelle FROM p_type_ldt";
        $rs = $this->cnx->query($sql);
        $str = "";
        while ($arr = $rs->fetch()) {
            $str .= '<option value="' . $arr['id_type_ldt'] . '">' . $arr['libelle'] . '</option>';
        }
        echo $str;
    }

    function getTaches() {
        $sql = "SELECT distinct(libelle), id_etape FROM p_etape";
        $rs = $this->cnx->query($sql);
        $str = '<option value="_"> </option>';
        while ($arr = $rs->fetch()) {
            $str .= '<option value="' . $arr['id_etape'] . '">' . $arr['libelle'] . '</option>';
        }
        return $str;
    }

    function identification($log, $mdp) {
        $sql = "select nom, prenom , id_pers, id_droit from r_personnel where matricule = '$log' and mdp = '$mdp'";

        $rs = $this->cnx->query($sql);
        while ($arr = $rs->fetch()) {
            $_SESSION['pseudo'] = $arr['nom'] . "  " . $arr['prenom'];
            $_SESSION['id'] = $arr['id_pers'];
            $_SESSION['id_droit'] = $arr['id_droit'];

            $P = 'connection';
            $O = 'connection sur GPAO WEB';
            $S = 'OK';

            $d = date("Y/m/d", time());
            $h = date("H:i:s", time());
            $ip = $_SERVER['REMOTE_ADDR'];

            /*
              regarder si pointage OK sinon pointage
             */


            $sqlPointage = "select pdate, source from r_pointage where id_util = " . $arr['id_pers'] . " AND source like 'IN%' order by pdate desc limit 1";

            $rs1 = $this->cnx->query($sqlPointage);


            while ($arr1 = $rs1->fetch()) {
                if ($arr1['pdate'] != $d) {
                    if ($arr['id_pers'] == '177')
                        return 1;
                    session_destroy();
                    return "Veuillez vous connecter a la pointage BIO";
                    $ip = $arr1['source'];
                }
                //return 1;
                break;
            }


            $sql = "INSERT INTO r_pointage (id_util, entree, pdate, source) VALUES (" . $arr['id_pers'] . ", '$h', '$d', '$ip')";
            if ($this->cnx->exec($sql)) {
                return 1;
            }
        }
        session_destroy();
        return "Login ou mdp incorrecte.";
    }

    function pointage($id_pers, $pt, $h) {
        include_once 'cnx1.4.php';
        $cc = new Cnxx();
        $cc->pointage($id_pers, $pt, $h);


        $d = date("Y/m/d", time());
        //$h= date("H:i:s", time());
        $ip = $_SERVER['REMOTE_ADDR'] . '-' . $_SESSION['id'];

        $sql = "INSERT INTO r_pointage (id_util, entree, pdate, source, sortie) VALUES (" . $id_pers . ", '$h', '$d', '$pt', '$ip')";
        //return $sql;
        if ($this->cnx->exec($sql)) {
            return 1;
        }
    }

    function Deconnect() {
        $d = date("Y/m/d", time());
        $h = date("H:i:s", time());

        $sqlPointage = "select pdate, source from r_pointage where pdate= '$d' AND id_util = " . $_SESSION['id'] . " AND source like 'IN%' order by pdate desc limit 1";
        $rs1 = $this->cnx->query($sqlPointage);

        while ($arr1 = $rs1->fetch()) {
            $lettre = $arr1['source'];
            $ip = str_replace("IN", "OUT", $lettre);
            $sql = "INSERT INTO r_pointage (id_util, entree, pdate, source) VALUES (" . $_SESSION['id'] . ", '$h', '$d', '$ip')";
            if ($this->cnx->exec($sql)) {
                return true;
            }
            break;
        }
        return false;
    }

    function getDatePt() {
        $sql = "SELECT distinct(pdate) FROM r_pointage   ORDER BY pdate DESC";
        $rs = $this->cnx->query($sql);
        $str = "";
        while ($arr = $rs->fetch()) {
            $str .= '<option value="' . $arr['pdate'] . '">' . $arr['pdate'] . '</option>';
        }
        return $str;
    }

    function getMoisPt() {
        $sql = "SELECT distinct(pdate) as mois FROM r_pointage order by pdate desc";
        $rs = $this->cnx->query($sql);
        $str = "";
        $arrayDate = array();
        while ($arr = $rs->fetch()) {
            $currMois = substr($arr['mois'], 0, -3);
            if (!array_key_exists($currMois, $arrayDate)) {
                echo $currMois;
                $arrayDate[$currMois] = '';
                $str .= '<option value="' . $currMois . '">' . $currMois . '</option>';
            }
        }
        //echo "-------".$str;exit();
        return $str;
    }

    function lstPointage($datePt, $matriPt, $typePoint, $departement) {
        $sql;
        $qDate = "";
        $qMatri = "";
        $qType = "";


        if ($matriPt != "") {
            $qMatri = " AND id_util = " . $matriPt;
        }
        if ($datePt != "") {
            $qDate = " AND pdate = '" . $datePt . "'";
        }

        if ($typePoint != "") {
            $qType = " AND source = '" . $typePoint . "'";
            if (strstr($typePoint, 'IN_ARO'))
                $qType = " AND source IN ('IN_ARO', 'IN_ARO1')";
            if (strstr($typePoint, 'OUT_ARO'))
                $qType = " AND source IN ('OUT_ARO', 'OUT_ARO1')";
        }
        else {
            $qType = " AND source IN ('IN', 'OUT','IN_ARO', 'OUT_ARO','IN_ARO1', 'OUT_ARO1', 'IN_RDJ', 'OUT_RDJ') ";
        }

        $filtreDepartement = ($departement != "") ? " AND id_departement = $departement" : "";

        $sql = "SELECT r_personnel.matricule, r_pointage.pdate, r_pointage.entree, r_pointage.sortie, r_pointage.id_pointage, r_personnel.nom, r_personnel.prenom, r_pointage.source FROM r_pointage
			INNER JOIN r_personnel ON  r_pointage.id_util = r_personnel.id_pers WHERE 1=1 ";

        $sql .= $qType;
        $sql .= $qDate . $qMatri . $filtreDepartement;

        $sql .= " ORDER BY pdate, entree DESC";

        //return $sql;
        $rs = $this->cnx->query($sql);

        $ii = 0;
        $str = "<table  id='listePointage'><thead><tr><th>Nom</th>
			<th>Prenom</th>
			<th>Matricule</th>
			<th>Date</th>
			<th>entree</th>
			<th>Pointeuse</th></tr></thead>";

        while ($arr = $rs->fetch()) {
            if ($ii == 3)
                $ii = 0;

            $cl = 'classe' . $ii;
            $ii++;
            $str .= "<tr class = $cl>";
            $str .= "<td>" . $arr['nom'] . "</td>";
            $str .= "<td>" . $arr['prenom'] . "</td>";
            $str .= "<td>" . $arr['matricule'] . "</td>";
            $str .= "<td>" . $arr['pdate'] . "</td>";
            $str .= "<td>" . $arr['entree'] . "</td>";
            $str .= "<td>" . $arr['source'] . "</td>";
            $str .= "</tr>";
        }
        $str .= "</table>";
        return $str;
    }

    function lstPointagePlat($datePt, $matriPt, $typePoint, $departement) {
        $qDate = "";
        $qMatri = "";
        $qType = "";


        if ($matriPt != "") {
            $qMatri = " AND id_util = " . $matriPt;
        }
        if ($datePt != "") {
            $qDate = " AND pdate = '" . $datePt . "'";
        }
        if ($typePoint != "") {
            $qType = " AND source = '" . $typePoint . "'";
        } else {
            $qType = "";
        }
        if ($departement != "") {
            $qType .= " AND Departement = '" . $departement . "'";
        }

        $sql = "SELECT id, pdate, id_util, in1, out1, in2, out2, valide, commentaire, err_type FROM r_pointage_jour WHERE id <> 1 ";

        $sql .= $qType;
        $sql .= $qDate . $qMatri;

        $sql .= " ORDER BY pdate ASC";

        $rs = $this->cnx->query($sql);
        //return $sql;
        //exit();
        $ii = 0;
        $str = "<table id='listePointage'><thead>
			<th>ID</th>
			<th>DATE</th>
			<th>Matricule</th>
			<th>Entree 1</th>
			<th>Sortie 1</th>
			<th>Entree 2</th>
			<th>Sortie 2</th>
			<th>ANOMALIE</th>
			<th>Commentaires</th>
			<th>Type</th></tr></thead>";

        while ($arr = $rs->fetch()) {
            if ($ii == 3)
                $ii = 0;

            $cl = 'classe' . $ii;
            $ii++;
            $str .= "<tr class = $cl>";
            $str .= "<td>" . $arr['id'] . "</td>";
            $str .= "<td>" . $arr['pdate'] . "</td>";
            $str .= "<td>" . $arr['id_util'] . "</td>";
            $str .= "<td>" . $arr['in1'] . "</td>";
            $str .= "<td>" . $arr['out1'] . "</td>";
            $str .= "<td>" . $arr['in2'] . "</td>";
            $str .= "<td>" . $arr['out2'] . "</td>";
            $str .= "<td>" . $arr['valide'] . "</td>";
            $str .= "<td>" . $arr['commentaire'] . "</td>";
            $str .= "<td>" . $arr['err_type'] . "</td>";
            $str .= "</tr>";
        }
        $str .= "</table>";
        return $str;
    }

    //§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§§

    function util_existe($p_login) {
        $sql = "select matricule from personnel where matricule = '$p_login'";

        $rs = $this->cnx->query($sql);
        $arr = $rs->fetch();
        return $arr['matricule'];
    }

    function sec2hms($sec, $padHours = false) {

        // start with a blank string
        $hms = "";

        // do the hours first: there are 3600 seconds in an hour, so if we divide
        // the total number of seconds by 3600 and throw away the remainder, we're
        // left with the number of hours in those seconds
        $hours = intval(intval($sec) / 3600);

        // add hours to $hms (with a leading 0 if asked for)
        $hms .= ($padHours) ? str_pad($hours, 2, "0", STR_PAD_LEFT) . ":" : $hours . ":";

        // dividing the total seconds by 60 will give us the number of minutes
        // in total, but we're interested in *minutes past the hour* and to get
        // this, we have to divide by 60 again and then use the remainder
        $minutes = intval(($sec / 60) % 60);

        // add minutes to $hms (with a leading 0 if needed)
        $hms .= str_pad($minutes, 2, "0", STR_PAD_LEFT) . ":";

        // seconds past the minute are found by dividing the total number of seconds
        // by 60 and using the remainder
        $seconds = intval($sec % 60);

        // add seconds to $hms (with a leading 0 if needed)
        $hms .= str_pad($seconds, 2, "0", STR_PAD_LEFT);

        // done!
        return $hms;
    }

}

?>