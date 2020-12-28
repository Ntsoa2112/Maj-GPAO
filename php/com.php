<?php

	

    //const DEFAULT_DNS = 'pgsql:host=db1.easytech.mg port=5432;dbname=easy';
    $dns = 'pgsql:dbname=easy';
    $user = 'rami';
    // const DEFAULT_SQL_PASS = 'Ra123456$';
    $pass = '$rami$$'; 
	$cnx = new PDO("pgsql:host=db1.easytech.mg;port=5432;dbname=easy;user=rami;password=$rami$$");
	echo "ici";
	csv();
	function csv() {
		$sql = "SELECT almerys_p_lot.date_deb,p_dossier.num_dossier, p_lot_client.libelle as ldg,almerys_p_lot.id_lotclient,almerys_p_lot.etat as etat_saisie,almerys_p_lot.num_nuo,almerys_tache.libelle as nature,almerys_p_lot.num_ps, almerys_p_lot.id_lot,almerys_p_lot.libelle as lib, p_etat.libelle as etat, p_etape.libelle as etape ,almerys_p_lot.id_pers, almerys_p_lot.priority, almerys_p_lot.id_pers, almerys_p_lot.duree, almerys_p_lot.qte, almerys_p_lot.erreur, almerys_p_lot.is_rejet,almerys_motif_rejet.libelle as lib_rejet,
		(select sat from almerys_user  where almerys_user.matricule = almerys_p_lot.id_pers limit 1) as sat, (select nom||' '||prenom from r_personnel  where r_personnel.id_pers = almerys_p_lot.id_cq) as nom,fav_a, fav_b, fav_c, non_fav 
		FROM almerys_p_lot
        LEFT JOIN p_etat ON almerys_p_lot.id_etat= p_etat.id_etat 
		LEFT JOIN p_lien_oper_dossier ON almerys_p_lot.id_etape= p_lien_oper_dossier.id_lien  
		LEFT JOIN p_etape ON p_etape.id_etape= p_lien_oper_dossier.id_oper 
		LEFT JOIN p_lot_client ON almerys_p_lot.id_lotclient = p_lot_client.id_lotclient
		LEFT JOIN p_dossier ON p_lot_client.id_dossier = p_dossier.id_dossier
                LEFT JOIN almerys_type_fav ON almerys_type_fav.id_pole = almerys_p_lot.id_lotclient
                LEFT JOIN almerys_tache ON almerys_p_lot.id_tache = almerys_tache.id_tache
	LEFT JOIN almerys_motif_rejet ON almerys_motif_rejet.id= almerys_p_lot.id_motif_rejet 
		WHERE almerys_p_lot.id_etat=0 AND almerys_p_lot.date_deb like '%2016%' and p_etape.libelle IN('NRRG','ES','OK','NOK') Limit 500";
		
		$folder = '../CSV/';
        $fName = $folder . '/LOT_EXP_.csv';
        $fw = fopen($fName, 'w');

        //$is_interial = false;

        $facture = $boolInterial ? "SECU" : "FACTURE";
        $decompte = $boolInterial ? "DECOMPTE" : "NUO";
        $PS = $boolInterial ? "" : "NUMERO PS";
        $POLE = $boolInterial ? "SPECIALITE" : "POLE";
        $etat = $boolInterial ? "<th  class='th' id='almerys_p_lot.etat'>ETAT</th>" : "";
        $nature = $boolInterial ? "<th  class='th' id='almerys_p_lot.id_tache'>NATURE</th>" : ""; //added by vololona col nature
        //return $sql;

        $str = "<table width='100%'>
		<thead><tr>
		
		<th  class='th' id='p_lot_client.libelle' class='filter'>$POLE</th>
		<th  class='th' id='almerys_p_lot.libelle'>NUMERO $facture</th>	
		<th  class='th' id='almerys_p_lot.num_nuo'>NUMERO $decompte</th>	
		<th  class='th' id='almerys_p_lot.num_ps'>$PS</th>
		<th  class='th' >TYPE DE FAV</th>
		<th  class='th' id='almerys_p_lot.qte'>MONTANT RC</th>
		<th  class='th' id='almerys_p_lot.id_pers'>MATRICULE</th>
		<th  class='th' id='almerys_p_lot.priority'>SAT</th>
		<th  class='th' id='p_lot_client.id_cq' class='filter'>NOM CQ</th>
		<th  class='th' id='almerys_p_lot.p_etape'>ETAT</th>
		<th  class='th' id='almerys_p_lot.erreur'>ERREUR</th>
		<th  class='th' id='almerys_p_lot.id_rejet'>RETOUR</th>
		<th  class='th' id='almerys_p_lot.lib_rejet'>LIB RETOUR</th>$etat $nature</tr>
		</thead>";

        $row = "DATE\tPOLE\tNIVEAU\tNUMERO FACTURE\tNUMERO NUO\tNUMERO PS\tMONTANT FACTURE\tERREUR\tDETAILS\tMATRICULE\tSAT\n";
        fwrite($fw, $row);

        $strCsv = "";

        //return $sql;
        $ii = 0;
        $nbResult = 0;
		echo 1;
		$rs = $cnx->query($sql);

        //return $sql;
		echo 1;
        foreach ($rs as $row) {
			echo 1;
            $montant = preg_replace('/\s+/  ', '', $row['qte']);
            $montant = (double) str_replace(",", ".", $montant);
            $niveau = "";

            if ($boolInterial) {
                if ($montant >= 350) {
                    $niveau = 'NIVEAU_A';
                    $classniveau = 'NIVEAU_A';
                }
                if ($montant < 350) {
                    $niveau = 'NIVEAU_B';
                    $classniveau = 'NIVEAU_B';
                }
            } else {

                
                $niveau = $row['non_fav'];
                $classniveau = "NON_FAV";

                if ($montant >= 30) {
                    $niveau = $row['fav_c'];
                    $classniveau = "FAV_C";
                }
                if ($montant >= 50) {
                    $niveau = $row['fav_b'];
                    $classniveau = "FAV_B";
                }
                if ($montant >= 100) {
                    $niveau = $row['fav_a'];
                    $classniveau = "FAV_A";
                }
            }

            $montantRC = "";
            if ($ii == 3)
                $ii = 0;
            $cl = 'classe' . $ii;
            $ii++;
            $str .= "<tr class = '" . $cl . " " . $classniveau . "' id='" . $row['id_lot'] . "' >";


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
            if ($boolInterial == true) {
                $str .= "<td>" . $row['etat_saisie'] . "</td>";
                $str.="<td>" . $row['nature'] . "</td>";
            }
            

            $str .= "</tr>";
            $nbResult++;


            $sr = $row['date_deb'] . "\t";
            $sr .= $row['ldg'] . "\t";
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

        echo $nbLigne . $str;
    }



?>
