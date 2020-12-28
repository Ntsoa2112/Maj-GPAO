<?php

// AUT Mirah RATAHIRY
// DES Requete et fonctions dossiers
// DAT 2012 03 06
// MAJ 2012 10 02 Ajout filtre au niveau du ldt (tri header)

/*

 */
class Cnxx extends PDO {

    public $cnx;

    const DEFAULT_DNS = 'pgsql:host=db1.easytech.mg port=5432;dbname=easygpao';
    //const DEFAULT_DNS = 'pgsql:dbname=easy';
    const DEFAULT_SQL_USER = 'admin';
    const DEFAULT_SQL_PASS = 'easy$$';

    function Cnxx() {
        date_default_timezone_set('Africa/Nairobi');
        ini_set('memory_limit', '-1');
        ini_set('max_execution_time', 0);

        //$this->cnx = null;
        $this->cnx = new PDO(
                self::DEFAULT_DNS, self::DEFAULT_SQL_USER, self::DEFAULT_SQL_PASS
        );
        return;
    }

    function GetPersonneSite() {
        $sql = "SELECT id_pers, r_site.libelle as site
        FROM r_personnel
        left join r_site on r_site.id_site=r_personnel.id_site 
        where 1=1 
        order by id_pers;";
		$arr = array();
        $rs = $this->cnx->query($sql);
        foreach ($rs as $row) 
            $arr[$row['id_pers']] = $row['site'];
        return $arr;
    }

    function pointage($id_pers, $pt, $h, $d) {
        $d = date("d/m/Y", strtotime($d));
        //$h= date("H:i:s", time());
        $ip = $_SERVER['REMOTE_ADDR'] . '-' . $_SESSION['id'];
        $id_pers_motif = $_SESSION['id'];
        $jour = date('d/m/Y');
        $ArrayPt = array(
            "IN-1" => "1",
            "IN" => "9",
            "IN-3" => "3",
            "IN-4" => "4",
            "OUT-1" => "5",
            "OUT" => "10",
            "OUT-3" => "7",
            "OUT-4" => "8");

        $pt = $ArrayPt[$pt];

        $sql = "INSERT INTO r_pointage(id_pers, date, heure, id_pointeuse,commentaire_modif) VALUES (" . $id_pers . ", '$d', '$h', '$pt','CHECK TOURNIQUET REEL')";

//return $sql;
        if ($this->cnx->exec($sql)) {
            return 1;
        }
    }



}
