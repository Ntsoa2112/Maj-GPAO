<?php
// AUT Mirah RATAHIRY
// DES Requete et fonctions dossiers
// DAT 2012 03 06
// MAJ 2012 10 02 Ajout filtre au niveau du ldt (tri header)

/*

*/
class Cnxx extends PDO
{
		public $cnx;
		const DEFAULT_DNS = 'pgsql:host=10.128.1.4 port=5432;dbname=easygpao';
		//const DEFAULT_DNS = 'pgsql:dbname=easy';
		const DEFAULT_SQL_USER = 'admin';
		const DEFAULT_SQL_PASS = 'easy';		

		function Cnxx()
		{
			date_default_timezone_set('Africa/Nairobi');
			ini_set('memory_limit', '-1');
			ini_set('max_execution_time', 0);

		//$this->cnx = null;
		  $this->cnx = new PDO	(
										self::DEFAULT_DNS,
										self::DEFAULT_SQL_USER,
										self::DEFAULT_SQL_PASS
									);
			return ;
		}
		
		function pointage($id_pers, $pt, $h)
		{
			$d= date("d/m/Y", time());
			//$h= date("H:i:s", time());
			$ip = $_SERVER['REMOTE_ADDR'].'-'.$_SESSION['id'];
			
			$ArrayPt = array(
			"IN"=>		"1",
			"IN_ARO"=>    "2",
			"IN_ARO1"=>   "3",
			"IN_RDJ" =>   "4",
			"OUT"  =>     "5",
			"OUT_ARO"  => "6",
			"OUT_ARO1" => "7",
			"OUT_RDJ"  => "8");
			
			$pt = $ArrayPt[$pt];

			$sql = "INSERT INTO r_pointage(id_pers, date, heure, id_pointeuse) VALUES (".$id_pers.", '$d', '$h', '$pt')";
			if ($this->cnx->exec($sql))
			{
				return 1;
			}
		}
}