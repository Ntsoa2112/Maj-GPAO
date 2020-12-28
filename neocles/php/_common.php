<?php
// AUT Mirah RATAHIRY
// DES Requete et fonctions dossiers
// DAT 2012 03 06
// MAJ 2012 10 02 Ajout filtre au niveau du ldt (tri header)
/*
*/

class Cnx extends PDO
{
		public $cnx;
#		pgsql:host=db1.easytech.mg port=5432;dbname=easy
		const DEFAULT_DNS = 'pgsql:host=db1.easytech.mg port=5432;dbname=Neocles';
		//const DEFAULT_DNS = 'pgsql:dbname=Neocles';
		const DEFAULT_SQL_USER = 'postgres';
		// const DEFAULT_SQL_PASS = 'Ra123456$';
		const DEFAULT_SQL_PASS = 'postgres';		

	function Cnx()
	{
		date_default_timezone_set('Africa/Nairobi');
		ini_set('memory_limit', '-1');
		ini_set('max_execution_time', 0);

	//$this->cnx = null;
	  $this->cnx = new PDO(self::DEFAULT_DNS,self::DEFAULT_SQL_USER,self::DEFAULT_SQL_PASS);
		return $this->cnx ;
	}
	
	// fonction utilis� par angular pour la recuperation du pointage
	function ngGetData()
	{
		"SELECT entree, source, id_pointage from r_pointage where pdate = '2017/05/15'		order by entree limit 10";
		
		$arr = array();
		$rs=$this->cnx->query($sql);
		
		foreach($rs as $row)
		{
			$arr[] = $row;
		}	
		echo $json_response = json_encode($rs);		
	}
	
	//mise a jour de l'adresse mac a partir du plan html editable
	function updateMac($id)
	{
	//$macz = str_replace(":", "", $mac);
	
		$pc = GetHostByName($_SERVER['REMOTE_ADDR']); //IP of the PC to manage
		if ($pc == "127.0.0.1" || $pc == "localhost") return 'localhost';
		$WbemLocator = new COM ("WbemScripting.SWbemLocator");
		$domaine = "EASYTECH";
 
		$WbemServices = $WbemLocator->ConnectServer($pc, 'root\\cimv2', 'mirah', 'Ra123456$', "MS_409", "ntlmdomain:". $domaine);
		$WbemServices->Security_->ImpersonationLevel = 3;
		
		$disks =    $WbemServices->ExecQuery("Select * from Win32_NetworkAdapterConfiguration  WHERE IPEnabled=TRUE");
		
		foreach ($disks as $d)
		{
			$macz = str_replace(":", "", $d->MACAddress);
			$rs=$this->cnx->exec("update r_listemachine set mac='".$macz."', date_insert= '".date("Ymd H:i:s")."' where id=$id");
			return $macz;
		}	
	}
	
	//rermine les lignes de temps
	function noNullFinLdt()
	{
		return "SELECT noNullDateFin()";		
		echo $this->cnx->exec($sqlDoss);
	}
	
	//nombre heure des op�rateurs mensuelle ou par intervale, dans le reporting
	function nombreHeureOP($intervalle, $matricule, $dossier)
	{
		$tk = explode(",", $intervalle);
		
		$filtreIntervaleTemps = " AND p_ldt.date_deb_ldt = '".$intervalle."'";			
		if (count($tk) > 1) $filtreIntervaleTemps = " AND p_ldt.date_deb_ldt >=  '".$tk[0]."' AND p_ldt.date_deb_ldt <= '".$tk[1]."'";
		if ($dossier !=	"") 	$filtreIntervaleTemps .= " AND p_ldt.id_dossier = ".$dossier;
		$sql = "SELECT date_deb_ldt, h_deb, h_fin FROM p_ldt WHERE id_pers = ".$matricule.$filtreIntervaleTemps ." order by p_ldt.date_deb_ldt, p_ldt.h_deb";		
		
		$diff;
		$somme="0:0:0";
		$rs=$this->cnx->query($sql);
		
		foreach($rs as $row)
		{
			if ($row['h_deb'] == "" || $row['h_fin'] == "") continue;
			$diff = $this->hDiff($row['h_deb'], $row['h_fin'], "");
			$somme = $this->hDiff($somme, $diff, "+");
		}		
		return $somme;
	}
	
	// recuperation des donn�es dans la base pour affichage a l'accueil de la GPAO
	function GetFluxRss($date, $auteur, $heure, $id, $titre, $content)
	{
		$sqlDoss = "SELECT titre, content, auteur,  fluxdate, fluxheure, id FROM p_flux order by RANDOM()";				
		$str = "";
		$rsDoss=$this->cnx->query($sqlDoss);		
		while($arr = $rsDoss->fetch())
		{		
			$str .= '<div><div id="'.$arr['id'].'" ><a href="#?w=500" rel='.$arr['id'].' class="poplight"><b>'.$arr['titre'].'</b></a>';
			$str .= '<p  class="div_flux">'.$arr['content']."</p></div></div>";		
		}	
		return $str;	
	}
	
	function suiviHeureOP($intervalle, $dossier, $departement)
	{
		// selection OP
		// somme heure op pendant la periode
		// ajout dossier si possible</div>
		
		set_time_limit(30000);
		$tk = explode(",", $intervalle);		
		$filtreIntervaleTemps = " where p_ldt.date_deb_ldt = '".$intervalle."'";		
		if (count($tk) > 1) $filtreIntervaleTemps = " where p_ldt.date_deb_ldt >=  '".$tk[0]."' AND p_ldt.date_deb_ldt <= '".$tk[1]."'";
		
		$filtreDepartement = ($departement == ""?"":" WHERE id_departement = '".$departement."'");
			
		$sqlDoss = "SELECT id_pers FROM r_personnel ".$filtreDepartement." order by id_pers";		
		
		$ii = 0; 
		$str = "<table >";
		$rsDoss=$this->cnx->query($sqlDoss);
		
		while($arr = $rsDoss->fetch())
		{		
			if ($ii >= 3) $ii = 0;
			$cl = 'classe'.$ii;
			$ii++;
			
			$somme = $this->ToHeureDecimal($this->nombreHeureOP($intervalle, $arr['id_pers'], $dossier));
			if ($somme == '0,00') continue;
			$str .= "<tr class = $cl>";
			$str .= "<td id='$".$arr['id_pers'].'|'.$somme."'>".$intervalle."</td>";
			$str .= "<td>".$arr['id_pers']."</td>";
			$str .= "<td>".$somme."</td>";
			$str .= "</tr>";			
		}
		
		$str .= "</table>";
		
		return $str;		
	}
	
	// DEBUT	Gestion lot et ligne de temps
	
	function nextLotDispo($doss, $oper)
	{
		/* chargement lot en cours pour l'utilisateur courant
			si pas de lot en cours
			Chargement lot dispo			
		*/
		$rez = $this->lotEnCours($_SESSION['id']);
		if ($rez == "")
		{
			$sql = "SELECT p_lot.id_lot, p_lot.libelle FROM p_lot 
			LEFT JOIN p_lot_client ON p_lot.id_lotclient=p_lot_client.id_lotclient
			WHERE p_lot_client.id_dossier=$doss AND p_lot.id_etape=$oper AND p_lot.id_etat=0 order by priority ASC";
			
			//return $sql;
			$rs=$this->cnx->query($sql);
			$str='';
			while($arr = $rs->fetch())
			{
				$idLot =$arr['id_lot'];
				$libLot=$arr['libelle'];
				$str .= "<option value='$idLot'>$libLot</option>";
				$this->updateLot($idLot, '1', "");
				return $str;
			}
			return $str;
		}
		return $rez;
	}
	
	function initialisation($mat)
	{
		$rs=$this->cnx->exec("update p_logon set connected=false  where id_pers=$mat");
		return "update p_logon set connected=false  where id_pers=$mat";
	}
	
	function getLDW($doss, $oper)
	{
		//return $this->nextLotDispo($doss, $oper);
		$rez = $this->lotEnCours($_SESSION['id']);
		if ($rez != "") return $rez;
		$sql = "SELECT p_lot.id_lot, p_lot.libelle FROM p_lot 
		LEFT JOIN p_lot_client ON p_lot.id_lotclient=p_lot_client.id_lotclient
		WHERE p_lot_client.id_lotclient=$doss AND p_lot.id_etape=$oper AND p_lot.id_etat=0 order by priority ASC";
		
		//return $sql;
		$rs=$this->cnx->query($sql);
		$str='<option value="_"> </option>';
		while($arr = $rs->fetch())
		{
			$str .= '<option value="'.$arr['id_lot'].'">'.$arr['libelle'].'</option>';
		}
		return $str;
	}
		
	function lotEnCours($idPers)
	{
		$sql = "SELECT p_lot.id_lot, p_lot.libelle FROM p_lot WHERE id_pers = $idPers AND id_etat = 1";
				
		//return $sql;
		$rs=$this->cnx->query($sql);
		$str="";
		while($arr = $rs->fetch())
		{
			$str .= '<option value="'.$arr['id_lot'].'">'.$arr['libelle'].'</option>';
			return $str;
		}
		return $str;
	}
	
	// FIN Gestion lot
	
	
	function insertConsigne($doss, $etap, $url)
	{
		$url = substr($url, 2, strlen($url));
		$sql = "INSERT INTO p_consigne (id_dossier, id_etape, url) values ($doss, $etap, '$url')";
		//return $sql;
		if ($this->cnx->exec($sql))
		{
			 return $this->getLstConsigne($doss, $etap);
		}
	}
	
	function getLstConsigne($idDossier, $idEtape)
	{
		$sql = "SELECT id, url from p_consigne where id_dossier = $idDossier";
		
		if ($idEtape != "")  $sql .=" AND id_etape = $idEtape";
		
		$sql .= ' order by id DESC';
		
		$rs=$this->cnx->query($sql);
		
		$str = "<table>";
		
		foreach($rs as $row)
		{
			if($_SESSION['id_droit']== 1) return $row['url'];
			
			$tk = explode("/", $row['url']);
			$str .= "<tr><td><a href='".$row['url']."' class='consigne'>".$tk[count($tk) - 1]."</a><hr/></td>";
			if ($_SESSION['id_droit'] != 1)
				$str .= "<td OnClick=deleteConsigne('".$row['id']."') class='delete'></td>";
			$str .= "</tr>";

		}
		$str .= "</table>";
		
		if($_SESSION['id_droit']== 1) return "aucun.htm";
		return $str;	
	}
	
	function getInfo2($idPers)
	{
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
		$rs=$this->cnx->query($sql);
		$str = "<table><tr><td></td><td>$idPers</td></tr>";
		foreach($rs as $row)
		{
			$str .= "<tr><td></td><td>".$row['num_dossier']."</td></tr>";
			$str .= "<tr><td></td><td>".$row['h_deb']."</td></tr>";
			$str .= "<tr><td></td><td>".$row['h_fin']."</td></tr>";
			
			$str .= "<tr><td></td><td>".$row['lib']."</td></tr>";
			$str .= "<tr><td></td><td><span class='duration'>Il y a: ".$this->hDiff($row['h_deb'], date("H:i:s"), "")."</span></td></tr>";
			$str .= "<tr><td></td><td>".$row['address_ip']."</td></tr></table>";			

			return "$str";
		}
		return $str."</table>";
	}	
	
	function getInfo_($idPers, $dossier)
	{
		$currDate = date("Ymd");
		$sql = "SELECT p_ldt.id_ldt, p_ldt.id_dossier, p_ldt.date_deb_ldt,p_ldt.date_fin_ldt, r_personnel.appelation, r_personnel.matricule, p_dossier.num_dossier,p_etape.libelle as lib, p_ldt.commentaire, p_type_ldt.libelle as type, p_ldt.h_deb, p_ldt.h_fin, p_ldt.quantite, p_ldt.address_ip, p_ldt.nbre_erreur, p_etat.libelle as statu FROM p_ldt 
			LEFT JOIN p_dossier ON p_ldt.id_dossier=p_dossier.id_dossier 
			LEFT JOIN p_lot_client ON p_ldt.id_lotclient=p_lot_client.id_lotclient  
			LEFT JOIN p_lien_oper_dossier ON p_ldt.id_etape=p_lien_oper_dossier.id_lien 
			LEFT JOIN p_etape ON p_lien_oper_dossier.id_oper=p_etape.id_etape
			LEFT JOIN p_etat ON p_ldt.id_etat=p_etat.id_etat
			LEFT JOIN p_type_ldt on p_type_ldt.id_type_ldt = p_ldt.id_type_ldt
			LEFT JOIN r_personnel ON r_personnel.id_pers=p_ldt.id_pers WHERE date_deb_ldt = '$currDate' AND  p_ldt.id_pers = $idPers";
			if ($dossier != "") $sql .= " AND p_ldt.id_dossier= $dossier ";
			$sql .= "order by h_deb desc limit 1";
			
		//return $sql;
		$rs=$this->cnx->query($sql);
		$str = "<table><tr><td></td><td>$idPers</td></tr>";
		foreach($rs as $row)
		{
			$str .= "<tr><td></td><td>".$row['num_dossier']."</td></tr>";
			$str .= "<tr><td></td><td>".$row['h_deb']."</td></tr>";
			$str .= "<tr><td></td><td>".$row['h_fin']."</td></tr>";
			
			$str .= "<tr><td></td><td>".$row['lib'].$row['type']."</td></tr>";
			$str .= "<tr><td></td><td><span class='duration'>Il y a: ".$this->hDiff($row['h_deb'], date("H:i:s"), "")."</span></td></tr>";
			$str .= "<tr><td></td><td>".$row['address_ip']."</td></tr></table>";			

			return "$str";
		}
		return $str."</table>";
	}
	
	function getInfo($idPers, $dossier)
	{
		$currDate = date("Ymd");
		$sql = "SELECT p_ldt.id_ldt, p_ldt.id_dossier, p_ldt.date_deb_ldt,p_ldt.date_fin_ldt, r_personnel.appelation, r_personnel.matricule, p_dossier.num_dossier,p_etape.libelle as lib, p_ldt.commentaire, p_type_ldt.libelle as type, p_ldt.h_deb, p_ldt.h_fin, p_ldt.quantite, p_ldt.address_ip, p_ldt.nbre_erreur, p_etat.libelle as statu FROM p_ldt 
			LEFT JOIN p_dossier ON p_ldt.id_dossier=p_dossier.id_dossier 
			LEFT JOIN p_lot_client ON p_ldt.id_lotclient=p_lot_client.id_lotclient  
			LEFT JOIN p_lien_oper_dossier ON p_ldt.id_etape=p_lien_oper_dossier.id_lien 
			LEFT JOIN p_etape ON p_lien_oper_dossier.id_oper=p_etape.id_etape
			LEFT JOIN p_etat ON p_ldt.id_etat=p_etat.id_etat
			LEFT JOIN p_type_ldt on p_type_ldt.id_type_ldt = p_ldt.id_type_ldt
			LEFT JOIN r_personnel ON r_personnel.id_pers=p_ldt.id_pers WHERE date_deb_ldt = '$currDate' AND  p_ldt.id_pers = $idPers";
			if ($dossier != "") $sql .= " AND p_ldt.id_dossier= $dossier ";
			$sql .= "order by h_deb desc limit 1";
			
		//return $sql;
		$rs=$this->cnx->query($sql);
		$str = "";
		foreach($rs as $row)
		{
			//$str .= "<td><span class='duration'>Il y a: ".$this->hDiff($row['h_deb'], date("H:i:s"), "")."</span></td><td>".$row['address_ip']."</td></tr>";	
			return "<td>".$row['num_dossier']."</td><td>".$row['lib'].$row['type']."</td><td>".$row['h_deb']."</td>";
		}
		return "<tr><td>$idPers</td><td></td><td></td><td></td><td></td></tr>";
	}
	
	function MapMacID()
	{
	
		$sql = "SELECT  id, mac from r_listemachine where length(mac) > 5";
		/*
		Array $rs=$this->cnx->query($sql);

		return $rs;
		*/
	}
	
	function GetConnectedMac()
	{	
		$sql = "SELECT  p_ldt.h_deb, p_ldt.h_fin, r_personnel.appelation, r_personnel.id_droit  FROM p_ldt 
		INNER JOIN r_personnel ON p_ldt.id_pers = r_personnel.id_pers 
		WHERE  mac = '$mac' AND date_deb_ldt = '$currDate' order by h_deb desc limit 1";
		
		$sql = "select max(id_ldt), mac from p_ldt where date_deb_ldt = '20140115' group by mac order by mac";
		
		$rs=$this->cnx->query($sql);
		$str = "<table><tr><td></td><td>$idPers</td></tr>";
		foreach($rs as $row)
		{
			$str .= "<tr><td></td><td>".$row['num_dossier']."</td></tr>";
			$str .= "<tr><td></td><td>".$row['h_deb']."</td></tr>";
			$str .= "<tr><td></td><td>".$row['h_fin']."</td></tr>";
			
			$str .= "<tr><td></td><td>".$row['lib']."</td></tr>";
			$str .= "<tr><td></td><td><span class='duration'>Il y a: ".$this->hDiff($row['h_deb'], date("H:i:s"), "")."</span></td></tr>";
			$str .= "<tr><td></td><td>".$row['address_ip']."</td></tr></table>";			

			return "$str";
		}
		return $str."</table>";
	}	
	
	
	function ScopeInfoMachine()
	{
		$currDate = date("Ymd");
		
		$sql = "select mac from r_listemachine where length(mac) > 5";
		$rs=$this->cnx->query($sql);
		$str="";
		while($arr = $rs->fetch())
		{
			$str = $arr['mac'];
		
			
			$sql = "SELECT  p_ldt.h_deb, p_ldt.h_fin, r_personnel.appelation, r_personnel.id_droit, p_dossier.num_dossier,p_etape.libelle as lib, r_droit.libelle as libdroit,r_departement.libelle as departement  FROM p_ldt 
			INNER JOIN r_personnel ON p_ldt.id_pers = r_personnel.id_pers 
			LEFT JOIN p_dossier ON p_ldt.id_dossier=p_dossier.id_dossier
			LEFT JOIN p_lien_oper_dossier ON p_ldt.id_etape=p_lien_oper_dossier.id_lien 
			LEFT JOIN p_etape ON p_lien_oper_dossier.id_oper=p_etape.id_etape
			LEFT JOIN r_droit ON r_personnel.id_droit=r_droit.id_droit
			LEFT JOIN r_departement on r_departement.id = r_personnel.id_departement
			WHERE  mac = '$str' AND date_deb_ldt = '$currDate' order by h_deb desc limit 1";
		
		
			$rs=$this->cnx->query($sql);		
			$str = "";
			$etat = 'normal';

			foreach($rs as $row)
			{
				$diff;
				if ($row['h_fin'] != "") 
				{
					$connected = true;
					$etat = 'deconnected';
					$sqlIsOut = "SELECT entree from r_pointage where pdate = '".date("Y/m/d")."' AND source like 'OUT%' order by entree limit 1";
					$rs1=$this->cnx->query($sqlIsOut);
					foreach($rs1 as $row1)
					{
						if ($row1['entree'] > $row['h_fin']) $etat = 'error';
						break;
					}
					$diff = $this->hDiff($row['h_fin'], date("H:i:s"), "");	
				}
				else
				{			
					$diff = $this->hDiff($row['h_deb'], date("H:i:s"), "");	
					$tk = 	explode(":", $diff)	;		
					if ($tk[0] > 1) $etat = 'anomalie';
				}
				
				if ($row['id_droit'] != '1') $str .="<div class='red_case occuped'><div class='etat $etat'><span>".$row['appelation']."</span></div>";
				else $str .="<div class='blue_case occuped'><div class='etat $etat'><span>".$row['appelation']."</span></div>";			
				
				$str .= "<table><tr><td>".$row['libdroit'].' - '.$row['departement']."</td></tr><tr><td>".$row['num_dossier']." | $diff </td></tr><tr><td>".$row['lib']."</td></tr></table>";
				return "$str</div>";
			}
		}
		return $str."";
	}
	
	function getStatutIP($mac)
	{
		$currDate = date("Ymd");
		
		$sql = "select mac from r_listemachine where id = $mac";
		$rs=$this->cnx->query($sql);
		$str="";
		while($arr = $rs->fetch())
		{
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
	
	
		$rs=$this->cnx->query($sql);		
		$str = "";
		$etat = 'normal';

		foreach($rs as $row)
		{
			$diff;
			if ($row['h_fin'] != "") 
			{
				$connected = true;
				$etat = 'deconnected';
				$sqlIsOut = "SELECT entree from r_pointage where pdate = '".date("Y/m/d")."' AND source like 'OUT%' order by entree limit 1";
				$rs1=$this->cnx->query($sqlIsOut);
				foreach($rs1 as $row1)
				{
					if ($row1['entree'] > $row['h_fin']) $etat = 'error';
					break;
				}
				$diff = $this->hDiff($row['h_fin'], date("H:i:s"), "");	
			}
			else
			{			
				$diff = $this->hDiff($row['h_deb'], date("H:i:s"), "");	
				$tk = 	explode(":", $diff)	;		
				if ($tk[0] > 1) $etat = 'anomalie';
			}
			
			if ($row['id_droit'] != '1') $str .="<div class='red_case occuped'><div class='etat $etat'><span>".$row['appelation']."</span></div>";
			else $str .="<div class='blue_case occuped'><div class='etat $etat'><span>".$row['appelation']."</span></div>";			
			
			$str .= "<table><tr><td>".$row['libdroit'].' - '.$row['departement']."</td></tr><tr><td>".$row['num_dossier']." | $diff </td></tr><tr><td>".$row['lib']."</td></tr></table>";
			return "$str</div>";
		}
		return $str."";
	}
	
	
	// generation dinamique des directives pour le plan 2D
	function echoS($s){
	
	echo '
	
		<input data-ng-init="'.$s.'=\''.$s.'\'" type="text" data-ng-model="'.$s.'"/>
		<div class ="{{cust.etat}}" data-ng-repeat="cust in gpao  | filter:'.$s.'">
		
		<div class=\'s{{cust.id_droit}}\' occuped\'>
		<table border="1px"><tr  class=\'{{cust.etat}}\'><td class=\'{{cust.etat}}\'>{{cust.appelation}} - {{cust.id_pers}}</td></tr>
		
		<tr><td>{{cust.departement}}&nbsp;</td></tr>
		<tr><td>{{cust.num_dossier}}</td></tr>
		
		<tr><td  class="mintd {{cust.typeEtape}}">{{cust.lib}}&nbsp;</td></tr>
		<tr><td>{{cust.diff}}</td></tr>
		<tr><td>Deb:{{cust.h_deb}}</td></tr>
		<tr><td>Fin:{{cust.h_fin}}</td></tr>
		
		</table>
		</div>
		</div>';
		}
	
	function getInfo_save($idPers)
	{
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
		$rs=$this->cnx->query($sql);
		$str = "<table><tr><td></td><td>$idPers</td></tr>";
		foreach($rs as $row)
		{
			
			$str .= "<tr><td></td><td>".$row['h_deb']."</td></tr>";
			$str .= "<tr><td></td><td>".$row['h_fin']."</td></tr>";
			$str .= "<tr><td></td><td><h2>".$row['num_dossier']."</h2></td></tr>";
			$str .= "<tr><td></td><td>".$row['lib']."</td></tr>";
			$str .= "<tr><td></td><td>".$row['address_ip']."</td></tr></table>";
			return "$str";
		}
		return $str."</table>";
	}
	
	
	function getInfoIP($mac)
	{
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
		$rs=$this->cnx->query($sql);
		$str = "";
		foreach($rs as $row)
		{
			$str .= "<table><tr><td>Appelation</td><td>".$row['appelation']."</td></tr>";
			$str .= "<tr><td>Nom</td><td>".$row['nom']."</td></tr>";
			$str .= "<tr><td>Prenom</td><td>".$row['prenom']."</td></tr>";
			$str .= "<tr><td>Departement</td><td>".$row['departement']."</td></tr>";
			$str .= "<tr><td>Matricule</td><td>".$row['matricule']."</td></tr>";
			$str .= "<tr><td>Dossier</td><td>".$row['num_dossier']."</td></tr>";
			$str .= "<tr><td>Heure Debut</td><td>".$row['h_deb']."</td></tr>";
			$str .= "<tr><td>Heure Fin</td><td>".$row['h_fin']."</td></tr>";
			
			$str .= "<tr><td>Tache</td><td>".$row['lib']."</td></tr>";
			$str .= "<tr><td>Il y a</td><td><span class='duration'>".$this->hDiff($row['h_deb'], date("H:i:s"), "")."</span></td></tr>";
			$str .= "<tr><td>IP</td><td>".$row['address_ip']."</td></tr>";
			$str .= "<tr><td>MAC</td><td>$mac</td></tr></table>";
			

			return "$str";
		}
		return $str."</table>";
	}
	
	function getLstMat()
	{
		$sql = "select id_pers, matricule from r_personnel order by id_pers";
		$rs=$this->cnx->query($sql);
		$str="";
		while($arr = $rs->fetch())
		{
			$str .= '<option value="'.$arr['id_pers'].'">'.$arr['id_pers'].'</option>';
		}
		
		return $str;
	}
	
	function getListConnected($dossier, $departement)
	{
		$currDate = date("Y/m/d");
		//return $currDate;
		$batiment='IN';
		
		$sql = "SELECT distinct(id_util) from r_pointage where pdate='".$currDate."' order by id_util";
		
		if ($departement != "")
		{
			$sql = "SELECT r_personnel.id_pers as id_util, appelation FROM r_personnel 
				LEFT JOIN r_affectation ON r_affectation.id_pers = r_personnel.id_pers 
				LEFT JOIN r_departement ON r_affectation.id_departement = r_departement.id  WHERE  r_departement.id = ".$departement." AND actif = true order by r_personnel.id_pers";
		}
		
		if ($dossier != "" & $departement == "")
		{
			$sql = "SELECT distinct(r_personnel.id_pers) as id_util, appelation FROM r_personnel 
				LEFT JOIN p_affectation ON p_affectation.id_pers = r_personnel.id_pers 
				WHERE actif = true AND p_affectation.id_dossier = ".$dossier." order by r_personnel.id_pers";
		}
		
		$folder = '../CSV/'.$_SESSION['id'];
		$this->clearDir($folder );
		if (!is_dir($folder)) mkdir($folder, 0755, true);
		$fName = $folder.'/ETAT_OP_'.date("Ymd").'_'.$dossier.$departement.'.csv';
		$fw = fopen($fName, 'w');
		
		$row = "MATRICULE\tNOM\tDOSSIER\tETAPE\tDEBUT\n";
		fwrite($fw, $row);		

		$strCsv="";	
		
		$rs=$this->cnx->query($sql);
		$str = "<br /><table class='table'>
		<tr>
		<th id='date_deb_ldt' class='th'>MATRICULE</td>
		<th id='date_deb_ldt'>NOM</td>
		<th id='date_deb_ldt'>DOSSIER</th>
		<th id='date_fin_ldt'>ETAPE</th>
		<th id='appelation'>tDebut</th>
		<th id='matricule'></th></tr>";
		
		$i=0;
		$nb=0;
		$rows = "";
		
		foreach($rs as $row)
		{
			if ($row['id_util'] == '0') continue;				
				
				$etat = $this->getEtat($row['id_util']);
				if ($i>3) $i=0;
				switch($etat)
				{
					case "-1":
						$rows .= "<tr class='classe$i'><td>".$row['id_util']."</td><td>".$row['appelation']."</td><td>non connect&eacute;</td><td></td><td></td><td></td></tr>";
						break;
					case "0":
						$rows .= "<tr class='classe$i'><td>".$row['id_util']."</td><td>".$row['appelation']."</td>".$this->getInfo($row['id_util'], $dossier)."</tr>";
						break;
					case "1":
						$rows .= "<tr class='classe$i'><td>".$row['id_util']."</td><td>".$row['appelation']."</td>".$this->getInfo($row['id_util'], $dossier)."</tr>";
						break;
					case "2":
						$rows .= "<tr class='classe$i'><td>".$row['id_util']."</td><td>".$row['appelation']."</td>".$this->getInfo($row['id_util'], $dossier)."</tr>";
						break;
					case "3":
						$rows .= "<tr class='classe$i'><td>".$row['id_util']."</td><td>".$row['appelation']."</td>".$this->getInfo($row['id_util'], $dossier)."</tr>";
						break;
					default:
						$rows .= "<tr class='classe$i'><td>".$row['id_util']."</td><td>".$row['appelation']."</td><td>SORTIE</td><td>POINTAGE BIO</td><td>".$etat."</td><td></td></tr>";
				}

				$i++;
				$nb++;
		}
		$strCsv = preg_replace('@</td><td>@', "\t", $rows);
		$strCsv = preg_replace('@<tr class=\'classe[0-9]\'><td>@', '', $strCsv);
		$strCsv = preg_replace('@</td></tr>@', "\r\n", $strCsv);
				
				fwrite($fw, $strCsv);
		$str .= $rows."</table>";
		fclose($fw);
		
		$str = "</table><table><tr><td><h4>Found: $nb</h4></td><td><a href='./CSV/$fName' OnClick=deleteReport('".$_SESSION['id']."')><input type='submit' value='' class='copy' title='Exporter au format CSV'/></a></td></tr></table>".$str;
		
		return $str;
	}
	
	
	function getEtat($idPers)
	{		
		$currDate = date("Ymd");
		$sql = "SELECT h_deb as deb, h_fin from p_ldt where id_pers = $idPers And date_deb_ldt = '$currDate' order by id_ldt desc";
		$rs=$this->cnx->query($sql);
		foreach($rs as $row)
		{
			// Verifie si l'utilisateur a une sortie dans pointage
			$sqlIsOut = "SELECT entree, source from r_pointage where id_util = ".$idPers." AND pdate = '".date("Y/m/d")."' AND source like 'OUT%' order by entree DESC limit 1";
			$rs1=$this->cnx->query($sqlIsOut);
			foreach($rs1 as $row1)
			{
				$temps = $row['h_fin'] != ''?$row['h_fin']:$row['deb'];
				//if ($row1['entree'] > $temps  ) return  $row['h_fin'].' '.$row1['source'].' '.$row1['entree'];
				if ($row1['entree'] > $temps  ) return  $row1['entree'];
			}
		
			$currTime = date("H:i:s"); 
			$currTime = $this->hDiff($currTime, '00:05:00', "+");
			$diff = $this->hDiff($row['deb'], $currTime, "");
			
			$tokens =  explode(":", $diff);
			
			$h = $tokens[0];
			$m = $tokens[1];

			if ($row['h_fin'] == "")
			{
				if ($h > 1)return '2';
				if ($h > 0)return '1';
				if ($h == 0)return '3';
				return 0;
			}
			else return '0';
		}
		return	-1;	
	}
	
	function ToHeureDecimal($strTime)
	{
		$h = explode(":", $strTime);		
		return number_format($h[0]+($h[1]/60), 4, ',', '.');
	}
	function ToSeconde($strTime)
	{
		$h = explode(":", $strTime);		
		return ($h[0]*3600)+($h[1]*60) +$h[2];
	}
	
	function dDiff($deb, $fin)
	{
		$datetime1 = strtotime($deb);
		$datetime2 = strtotime($fin);
		$interval  = abs($datetime2 - $datetime1);
		$minutes   = round($interval / 60);
		echo 'Diff. in minutes is: '.$minutes; 
	}
	
    function hDiff($t1, $t2, $oper)
	{
		// difference heure hH:im:ss
		$h = explode(":", $t1);
		$m = explode(":", $t2);
		
		$h1 = $h[0];
		$h2 = $m[0];
		$m1 = $h[1];
		$m2 = $m[1];
		$s1 = $h[2];
		$s2 = $m[2];
		
		if ($oper == "+") $ret = (($h2*3600)+($m2*60)+($s2)) + (($h1*3600)+($m1*60)+($s1));
		else $ret = (($h2*3600)+($m2*60)+($s2)) - (($h1*3600)+($m1*60)+($s1));
		
		$h=floor($ret/3600);
		$m=floor(($ret-($h*3600))/60);
		$s=($ret-($h*3600))-$m*60;
		
		return $h.':'.$m .':'.$s;
	}
	
	function deleteLdt($p_id_ldt)
	{
		$rs=$this->cnx->exec("delete from p_ldt where id_ldt=$p_id_ldt");
	}
	
	function deleteLot($idLot)
	{
		$rs=$this->cnx->exec("delete from p_lot where id_lot=$idLot");
	}
	
	function delConsigne($p_id_ldt)
	{
		$sql = "SELECT url from p_consigne where id = $p_id_ldt";
		$rs=$this->cnx->query($sql);
		$url = "";
		
		foreach($rs as $row)
		{
			$url = $row['url'];
		}
		$sql = "delete from p_consigne where id=$p_id_ldt";
		$rs=$this->cnx->exec($sql);
		
		$filename = $_SERVER['DOCUMENT_ROOT']."$/".$url;
		//return $filename;
		unlink($filename);
	}
	
	function updateLot($lstId, $etat, $prio, $mat)
	{
		$filtre = "";
		$sql = "update p_lot set id_pers =".$_SESSION['id'];
		if ($mat != "") $sql = "update p_lot set id_pers =$mat";
		if ($etat != "") $filtre .= ", id_etat = $etat";
		if ($prio != "") $filtre .= ", priority = $prio";

		$sql .= $filtre." where id_lot IN ($lstId)";
		//return " id_etat = $etat"." priority = $prio";
		$rs=$this->cnx->exec($sql);
	}
	
	function updateLdt($deb, $fin, $qt, $err, $stat, $id, $dDeb, $dFin, $com)
	{
		$sql = "UPDATE p_ldt SET h_deb='".$deb."'";

		$sql .= ", h_fin='".$fin."'";
		$sql .= ", quantite='".$qt."'";
		$sql .= ", nbre_erreur='".$err."'";
		$sql .= ", date_deb_ldt='".$dDeb."'";
		$sql .= ", date_fin_ldt='".$dFin."'";
		$sql .= ", machine='".$com."'";
		if ($stat != "") $sql .= ", id_etat=".$stat;
		$sql .= " WHERE id_ldt=".$id;
		//return $sql;
		$rs=$this->cnx->exec($sql);
	}
	
	function getOneLdt($id)
	{
	// recherche
		$sql = "SELECT p_ldt.id_ldt, p_ldt.id_dossier, p_ldt.date_deb_ldt,p_ldt.date_fin_ldt, r_personnel.appelation, r_personnel.matricule, p_dossier.num_dossier,p_etape.libelle as lib, p_ldt.commentaire, p_type_ldt.libelle as type, p_ldt.h_deb, p_ldt.h_fin, p_ldt.quantite, p_ldt.nbre_erreur, p_etat.libelle as statu, p_ldt.machine FROM p_ldt 
			LEFT JOIN p_dossier ON p_ldt.id_dossier=p_dossier.id_dossier 
			LEFT JOIN p_lot_client ON p_ldt.id_lotclient=p_lot_client.id_lotclient  
			LEFT JOIN p_lien_oper_dossier ON p_ldt.id_etape=p_lien_oper_dossier.id_lien 
			LEFT JOIN p_etape ON p_lien_oper_dossier.id_oper=p_etape.id_etape
			LEFT JOIN p_etat ON p_ldt.id_etat=p_etat.id_etat
			LEFT JOIN p_type_ldt on p_type_ldt.id_type_ldt = p_ldt.id_type_ldt
			LEFT JOIN r_personnel ON r_personnel.id_pers=p_ldt.id_pers WHERE p_ldt.id_ldt= ".$id;
		
		$rs=$this->cnx->query($sql);
		foreach($rs as $row)
		{
			$str = $row['num_dossier']."|".$row['lib']."|".$row['h_deb']."|".$row['h_fin']."|".$row['quantite']."|".$row['nbre_erreur']."|".$row['statu']."|".$row['matricule']."|".$row['id_dossier']."|".$row['date_deb_ldt']."|".$row['date_fin_ldt']."|".$row['machine'];
			return $str;
		}
		return "";
	}
	
	function getLdt($dossier, $etape, $lstPeriode, $matricule, $statut, $orderby)
	{
		$filtre = "";		
		if ($lstPeriode != "")
		{
			$filtre = " AND p_ldt.date_deb_ldt = '".$lstPeriode."'";
			
			$tk = explode(",", $lstPeriode);
			if (count($tk) > 1)
			{
				$lstPeriode= str_replace($lstPeriode, ",", "_");
				$filtre = " AND p_ldt.date_deb_ldt >=  '".$tk[0]."' AND p_ldt.date_deb_ldt <= '".$tk[1]."'";
			}		
		}
		$folder = '../CSV/'.$_SESSION['id'];
		$this->clearDir($folder );
		
		$isOP = ($_SESSION['id_droit']==1?true:false);

		if(!$isOP) if (!is_dir($folder)) mkdir($folder, 0755, true);
		$fName = $folder.'/LDT_'.$_SESSION['id'].'_'.$lstPeriode.'.csv';
		if(!$isOP) $fw = fopen($fName, 'w');	
				
		if ($dossier != "") 	$filtre .= " AND p_ldt.id_dossier = $dossier";
		if ($matricule != "") 	$filtre .= " AND p_ldt.id_pers = $matricule";
		if ($statut != "") 		$filtre .= " AND p_ldt.id_etat = $statut";	
		if ($etape != "") 		$filtre .= " AND p_ldt.id_etape = $etape";		

		$sql = "SELECT p_ldt.id_ldt, p_ldt.id_lot, p_ldt.machine, p_ldt.date_deb_ldt,p_ldt.date_fin_ldt, r_personnel.appelation, r_personnel.matricule, p_dossier.num_dossier,p_etape.libelle as lib, p_ldt.commentaire, p_ldt.duration, p_type_ldt.libelle as type, p_ldt.h_deb, p_ldt.h_fin, p_ldt.quantite, p_ldt.nbre_erreur, p_etat.libelle as statu, p_lot.libelle as liblot, p_lot_client.libelle as liblotclient FROM p_ldt 
			LEFT JOIN p_dossier ON p_ldt.id_dossier=p_dossier.id_dossier 
			LEFT JOIN p_lot ON p_ldt.id_lot=p_lot.id_lot 
			LEFT JOIN p_lot_client ON p_ldt.id_lotclient=p_lot_client.id_lotclient  
			LEFT JOIN p_lien_oper_dossier ON p_ldt.id_etape=p_lien_oper_dossier.id_lien 
			LEFT JOIN p_etape ON p_lien_oper_dossier.id_oper=p_etape.id_etape
			LEFT JOIN p_etat ON p_ldt.id_etat=p_etat.id_etat
			LEFT JOIN p_type_ldt on p_type_ldt.id_type_ldt = p_ldt.id_type_ldt
			LEFT JOIN r_personnel ON r_personnel.id_pers=p_ldt.id_pers WHERE 1=1 ";
		$sql .= $filtre;
		
		if ($orderby == "") $orderby = 'p_ldt.h_deb';
		$sql .= " ORDER BY ".$orderby;
		
		$str = "<table width=\"100%\"><thead><tr>
		<th class='th'  id='date_deb_ldt'>Date debut</th>
		<th class='th'  id='date_fin_ldt'>Date fin</th>
		<th class='th'  id='appelation'>Appelation</th>
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
		if(!$isOP) fwrite($fw, $row);
		
      
		$rs=$this->cnx->query($sql);
		//return $sql;
		$i=0;
		$qteTotal=0;
		$hTotalLdt="0:0:0";
		$totalVitess=0;
		
		foreach($rs as $row)
		{
			$diff="0:0:0";
			if ($row['h_fin'] != "")
			{
				$diff = $this->hDiff($row['h_deb'], $row['h_fin'], "");
				$vitesse = number_format(($this->ToSeconde($diff)*$row['quantite'])/3600, 2);
				$totalVitess += $vitesse;
				$hTotalLdt = $this->hDiff($hTotalLdt, $diff, "+");
			}
			
			//vitesse = Qte * duree / h
			
			
			if ($ii == 3) $ii = 0;			

				$cl = 'classe'.$ii;
				$ii++;
				$str .= "<tr class = $cl id='".$row['id_ldt']."' >";
				$str .= "<td><div class=\"ldt_date\">".$row['date_deb_ldt']."</div></td>";
				$str .= "<td><div class=\"ldt_date\">".$row['date_fin_ldt']."</div></td>";
				$str .= "<td>".$row['appelation']."</td>";
				$str .= "<td><div class=\"ldt_mat\">".$row['matricule']."</div></td>";		
				
				$str .= "<td>".$row['num_dossier']."</td>";
				
				$str .= "<td>".$row['lib']."</td>";
				if ($row['id_lot'] != 0)
				{
					$str .= "<td><div class=\"ldtlib\">".$row['liblot']."</div></td>";
					$str .= "<td>".$row['commentaire']."</td>";
				}
				else 
				{
					$str .= "<td><div class=\"ldtlib\">".$row['commentaire']."</div></td>";
					$str .= "<td>".$row['machine']."</td>";
				}
				
				$str .= "<td>".$row['type']."</td>";
				$str .= "<td><div class=\"ldt_date\">".$row['h_deb']."</div></td>";
				$str .= "<td><div class=\"ldt_date\">".$row['h_fin']."</div></td>";
				$str .= "<td><div class=\"ldt_date\">".$this->ToHeureDecimal($diff)."</div></td>";
				$str .= "<td><div class=\"ldt_nb\">".$row['quantite']."</div></td>";
				$str .= "<td><div class=\"ldt_nb\">".$vitesse."</div></td>";
				$qteTotal += $row['quantite'];
				$str .= "<td><div class=\"ldt_nb\">".$row['nbre_erreur']."</div></td>";
				$str .= "<td>".$row['statu']."</td>";
				if ($_SESSION['id_droit'] != 1)
				{
					$str .= "<td OnClick=updateLdtForm('".$row['id_ldt']."') class='edit'></td>";				
					$str .= "<td OnClick=deleteLdt('".$row['id_ldt']."') class='delete'></td>";
				}
				$str .= "</tr>";
				$i++;
				
								
				$rw = $row['date_deb_ldt']."\t";
				$rw .= $row['date_fin_ldt']."\t";
				$rw .= $row['appelation']."\t";
				$rw .= $row['matricule']."\t";			
				$rw .=$row['num_dossier']."\t";
				
				$rw .= $row['lib']."\t";
				if ($rw['id_lot'] != 0)
				{
					$rw .= $row['liblot']."\t";
					$rw .= $row['commentaire']."\t";
				}
				else 
				{
					$rw .= $row['commentaire']."\t";
					$rw .= $row['machine']."\t";
				}
				
				$rw .= $row['type']."\t";
				$rw .= $row['h_deb']."\t";
				$rw .= $row['h_fin']."\t";
				$rw .= $diff."\t";
				$rw .= $row['quantite']."\t";
				$rw .= $vitesse."\t";
				$rw .= $row['nbre_erreur']."\t";
				$rw .= $row['statu']."\n";
			
				if(!$isOP) fwrite($fw, $rw);
		}
		$vitesse = number_format(($this->ToSeconde($hTotalLdt)*$qteTotal)/3600, 2);
		$str.= '<tr  class = "th"><td><b>Total:</b></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td><b>'.$this->ToHeureDecimal($hTotalLdt).'</b></td><td><b>'.$qteTotal.'</b></td><td><b>'.$vitesse.'</b></td><td></td></tr>';
		
		if(!$isOP) fclose($fw);
		$nbLigne = "</table><table><tr><td><h4>Total Found: $i</h4></td><td><a href='./CSV/$fName' OnClick=deleteReport('".$matricule."')><input type='submit' value='' class='copy' title='Exporter au format CSV'/></a></td></tr></table>";
		return $nbLigne.$str;		
	}
		
	function deleteReport($idPers)
	{
		foreach (@glob($path.$Patern) as $filename) 
		{
				@unlink($filename);
		}
	}
	
	
	function clearDir($dossier) 
	{
		$ouverture=@opendir($dossier);
		if (!$ouverture) return;
		while($fichier=readdir($ouverture)) {
			if ($fichier == '.' || $fichier == '..') continue;
			if (is_dir($dossier."/".$fichier)) 
			{
				$r=$this->clearDir($dossier."/".$fichier);
				if (!$r) return false;
			}
			else 
			{
				$r=@unlink($dossier."/".$fichier);
				if (!$r) return false;
			}
		}
		closedir($ouverture);
		$r=@rmdir($dossier);
		if (!$r) return false;
		return true;
	}
	
	function GetImageInDir($item)
	{
		$dossier = 'img/'.$item;
		$strLstImage="";
		$ouverture=@opendir($dossier);
		if (!$ouverture) return;
		while($fichier=readdir($ouverture)) {
			if ($fichier == '.' || $fichier == '..') continue;
			if (is_dir($dossier."/".$fichier)) 
			{
				continue;
			}
			else 
			{
				$strLstImage.='<div><a u=image href="#"><img src="'.$dossier.'/'.$fichier.'" /></a></div>';
			}
		}
		closedir($ouverture);
		
		return $strLstImage;
	}
	function GetLstFolder($path)
	{
	$path = 'img';
		$strLstImage="";
		$ouverture=@opendir($path);
		if (!$ouverture) return 'cant open';
		while($fichier=readdir($ouverture)) {
		
		
			if ($fichier == '.' || $fichier == '..') continue;
			if (is_dir($path."/".$fichier)) 
			{
				if ($fichier == 'img') continue;
				$strLstImage.= '<h1><br /><a href="#" id="'.$fichier.'">'.$fichier.'</a></h1>';
			}			
		}
		closedir($ouverture);
		return $strLstImage;
	}
	
	function getLot($dossier, $lotClient, $matricule, $statut, $etape, $prio, $name, $ordre)
	{	
		//	
		$filtre = "";
		if ($dossier != "")
		{
			// sp�cifique pour le projet detourage ou il fallait ressembler tout les dossier
			 if ($dossier == '39') $filtre .= " AND p_dossier.id_dossier IN (108,109,110,111,112,113,107,39)";
			 else $filtre .= " AND p_dossier.id_dossier = $dossier";
		}
		if ($lotClient != "") 	$filtre .= " AND p_lot.id_lotclient = $lotClient";
		if ($matricule != "") 	$filtre .= " AND p_lot.id_pers = $matricule";
		if ($statut != "") 		$filtre .= " AND p_lot.id_etat = $statut";	
		if ($etape != "") 		$filtre .= " AND p_lot.id_etape = $etape";
		if ($prio != "") 		$filtre .= " AND p_lot.priority = $prio";
		if ($name != "") 		$filtre .= " AND p_lot.libelle like '%$name%'";		

		$sql = "SELECT p_dossier.num_dossier, p_lot_client.libelle as ldg, p_lot.id_lot as id,p_lot.libelle as lib, p_etat.libelle as etat, p_etape.libelle as etape ,p_lot.id_pers, p_lot.priority, p_lot.id_pers, p_lot.duree, p_lot.qte FROM p_lot
        LEFT JOIN p_etat ON p_lot.id_etat= p_etat.id_etat 
		LEFT JOIN p_lien_oper_dossier ON p_lot.id_etape= p_lien_oper_dossier.id_lien  
		LEFT JOIN p_etape ON p_etape.id_etape= p_lien_oper_dossier.id_oper 
		LEFT JOIN p_lot_client ON p_lot.id_lotclient = p_lot_client.id_lotclient
		LEFT JOIN p_dossier ON p_lot_client.id_dossier = p_dossier.id_dossier
		WHERE 1=1";	
		
		
		
		if ($ordre == "") $sql .= $filtre." order by lib";
		elseif ($ordre == "stat") return $this->SuiviLot($dossier, $lotClient, $matricule, $statut, $etape, $prio, $name, $ordre);
		else $sql .= $filtre." ORDER BY ".$ordre;
		
		//return $sql;
		
		$folder = '../CSV/'.$_SESSION['id'];
		$this->clearDir($folder );
		if (!is_dir($folder)) mkdir($folder, 0755, true);
		$fName = $folder.'/LOT_'.$_SESSION['id'].'_'.$dossier.'_'.$lotClient.'_'.$etape.'.csv';
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

		$strCsv="";		
		
		return $sql;
		$ii = 0;  
		$nbResult=0;		
		$rs=$this->cnx->query($sql);

		foreach($rs as $row)
		{
			$rez = explode('$', $this->GetDureeLot($row['id']));
			$duree = $rez[0];
			$qte =  $rez[1];
			$vitesse = number_format(($this->ToSeconde($duree)*$qte)/3600, 2);
			
			if ($ii == 3) $ii = 0;
				$cl = 'classe'.$ii;
				$ii++;
				$str .= "<tr class = $cl id='".$row['id']."' >";
				$str .= "<td>".$row['num_dossier']."</td>";
				$str .= "<td>".$row['ldg']."</td>";
				$str .= "<td>".$row['lib']."</td>";
				$str .= "<td>".$row['etape']."</td>";
				$str .= "<td>".$row['etat']."</td>";
				// if ($row['etat'] == "TERMINE") 
				$str .= "<td>".$this->ToHeureDecimal($duree)."</td>";
				//else $str .= "<td></td>";
				$str .= "<td>".$qte."</td>";
				$str .= "<td>".$vitesse."</td>";
				$str .= "<td>".$row['id_pers']."</td>";
				$str .= "<td>".$row['priority']."</td>";
				$str .= "<td><input type='checkbox'  class='case' name='options[]' id=".$row['id'].">";
				if ($_SESSION['id'] == '177')
				$str .= "<td OnClick=deleteLot('".$row['id']."') class='delete'></td>";
				$str .= "</tr>";
				$nbResult++;

				$sr = $row['num_dossier']."\t";
				$sr .= $row['ldg']."\t";
				$sr .= $row['lib']."\t";
				$sr .= $row['etape']."\t";
				$sr .= $row['etat']."\t";
				$sr .= $row['qte']."\t";
				if ($row['etat'] == "TERMINE") $sr .= $this->ToHeureDecimal($duree)."\t";
				else $sr .= "\t";
				$sr .= $vitesse."\t";
				$sr .= $row['id_pers']."\t";
				$sr .= $row['priority']."\n";

				fwrite($fw, $sr);				
		}
		fclose($fw);
		$str .= "</table>";
		$nbLigne = "</table><table><tr><td><h4>Total Found: $nbResult</h4></td><td><a href='./CSV/$fName'><input type='submit' value='' class='copy' title='Exporter au format CSV'/></a></td></tr></table>";
		

		return $nbLigne.$str;
	}
	
	function getIdLotAlmerys($id)
	{
		$sql = "select libelle, qte, id_lotclient, id_pers, num_nuo, num_ps from almerys_p_lot where id_lot = ".$id;
		$rs=$this->cnx->query($sql);

		foreach($rs as $row)
		{
			return $row['libelle'] . '$' . $row['qte'] . '$' . $row['id_lotclient'] . '$' . $row['id_pers'] . '$' . $row['num_nuo']. '$' . $row['num_ps'];
		}
		return '';
	}
	function getLotAlmerys($dossier, $lotClient, $matricule, $statut, $etape, $prio, $name, $ordre)
	{	
		$filtre = "";
		if ($dossier != "")
		{
			// sp�cifique pour le projet detourage ou il fallait ressembler tout les dossier
			 if ($dossier == '39') $filtre .= " AND p_dossier.id_dossier IN (108,109,110,111,112,113,107,39)";
			 else $filtre .= " AND p_dossier.id_dossier = $dossier";
		}
		if ($lotClient != "") 	$filtre .= " AND almerys_p_lot.id_lotclient = $lotClient";
		if ($matricule != "") 	$filtre .= " AND almerys_p_lot.id_pers = $matricule";
		
		if ($etape != "") 		$filtre .= " AND almerys_p_lot.id_etape = $etape";
		
		if ($name != "") 		$filtre .= " AND almerys_p_lot.libelle like '%$name%'";	
		
		if ($prio != "") 		$filtre .= " AND almerys_p_lot.date_deb = '$prio'";	
		
		$arrayAllowedMatricul = array('55'=>'177','177'=>'177','1'=>'','432'=>'','70'=>'','32'=>'');
		
		if (!array_key_exists($_SESSION['id'], $arrayAllowedMatricul)) $filtre .= " AND almerys_p_lot.id_pers IN (select matricule from almerys_user where id_cq = ".$_SESSION['id'].')';

		$sql = "SELECT p_dossier.num_dossier, p_lot_client.libelle as ldg,almerys_p_lot.id_lotclient,almerys_p_lot.num_nuo,almerys_p_lot.num_ps, almerys_p_lot.id_lot,almerys_p_lot.libelle as lib, p_etat.libelle as etat, p_etape.libelle as etape ,almerys_p_lot.id_pers, almerys_p_lot.priority, almerys_p_lot.id_pers, almerys_p_lot.duree, almerys_p_lot.qte, almerys_p_lot.erreur, 
		(select distinct(sat) from almerys_user where almerys_user.matricule = almerys_p_lot.id_pers) as sat
		FROM almerys_p_lot
        LEFT JOIN p_etat ON almerys_p_lot.id_etat= p_etat.id_etat 
		LEFT JOIN p_lien_oper_dossier ON almerys_p_lot.id_etape= p_lien_oper_dossier.id_lien  
		LEFT JOIN p_etape ON p_etape.id_etape= p_lien_oper_dossier.id_oper 
		LEFT JOIN p_lot_client ON almerys_p_lot.id_lotclient = p_lot_client.id_lotclient
		LEFT JOIN p_dossier ON p_lot_client.id_dossier = p_dossier.id_dossier
	
		WHERE almerys_p_lot.id_etat=0";	
		
		//return $_SESSION['id'];
		if ($ordre == "") $sql .= $filtre." order by lib";
		elseif ($ordre == "stat")
		{
			$str = "<table width='100%'>
			<thead><tr>
			
			<th  class='th' id='p_lot_client.libelle' class='filter'>POLE</th>
			<th  class='th' id='almerys_p_lot.libelle'>FACTURE SAISIE</th>	
			<th  class='th' >FACTURE DEJA CONTROLE</th>
			<th  class='th' id='almerys_p_lot.qte'>OK</th>
			<th  class='th' id='almerys_p_lot.id_pers'>NOK</th>
			<th  class='th' id='almerys_p_lot.priority'>NRRG</th>
			<th  class='th' id='almerys_p_lot.p_etape'>ES</th>
			<th  class='th' id='almerys_p_lot.p_etape'>EN ATTENTE</th>
			</tr></thead>";
			
			$sqlDoss = 'select distinct(id_lotclient) from almerys_p_lot order by id_lotclient desc';
			$rss=$this->cnx->query($sqlDoss);
			
			$ii=0;
			while($arrDoss = $rss->fetch())
			{
				if ($ii == 3) $ii = 0;
				$str .= "<tr class = 'classe".$ii."'>".$this->SuiviLotAlmerys($dossier, $arrDoss['id_lotclient'], $matricule, $statut, $etape, $prio, $name, $ordre).'</tr>';
				$ii++;
			}
			
			$str.="<tr  class='th'>";
			$str.='</tr></table>';
			
			return $str;			
		}
		
		else $sql .= $filtre." ORDER BY ".$ordre;
		
		$folder = '../CSV/'.$_SESSION['id'];
		$this->clearDir($folder );
		if (!is_dir($folder)) mkdir($folder, 0755, true);
		$fName = $folder.'/LOT_'.$_SESSION['id'].'_'.$dossier.'_'.$lotClient.'_'.$etape.'.csv';
		$fw = fopen($fName, 'w');
		
		$str = "<table width='100%'>
		<thead><tr>
		
		<th  class='th' id='p_lot_client.libelle' class='filter'>POLE</th>
		<th  class='th' id='almerys_p_lot.libelle'>NUMERO FACTURE</th>	
		<th  class='th' id='almerys_p_lot.num_nuo'>NUMERO NUO</th>	
		<th  class='th' id='almerys_p_lot.num_ps'>NUMERO PS</th>
		<th  class='th' >NIVEAU</th>
		<th  class='th' id='almerys_p_lot.qte'>MONTANT RC</th>
		<th  class='th' id='almerys_p_lot.id_pers'>MATRICULE</th>
		<th  class='th' id='almerys_p_lot.priority'>SAT</th>
		<th  class='th' id='almerys_p_lot.p_etape'>ETAT</th>
		<th  class='th' id='almerys_p_lot.erreur'>ERREUR</th>
		
		
		</tr></thead>";

		$row = "POLE\tNIVEAU\tNUMERO FACTURE\tNUMERO NUO\tNUMERO PS\tMONTANT FACTURE\tERREUR\tDETAILS\tMATRICULE\tSAT\n";
		fwrite($fw, $row);		

		$strCsv="";		
		
		//return $sql;
		$ii = 0;  
		$nbResult=0;		
		$rs=$this->cnx->query($sql);

		//return $sql;
		foreach($rs as $row)
		{
			$montant = (double)$row['qte'];
			$niveau = "";

			switch ($row['id_lotclient'])
				{
					case 2385: //TPS
						if ($montant >= 100) $niveau = 'NIVEAU_A';
						if ($montant >85 && $montant <100) $niveau = 'NIVEAU_B';
						if ($montant <= 85) $niveau = 'NIVEAU_C';
						
						break;
					case 2387: //HOSPI
						if ($montant >= 2500) $niveau = 'NIVEAU_A';
						if ($montant >2000 && $montant <2500) $niveau = 'NIVEAU_B';
						if ($montant >1500 && $montant <=2000) $niveau = 'NIVEAU_C';
						if ($montant >1000 && $montant <=1500) $niveau = 'NIVEAU_D';
						if ($montant >500 && $montant <=1000) $niveau = 'NIVEAU_E';
						if ($montant >300 && $montant <=500) $niveau = 'NIVEAU_F';
						if ($montant <= 300) $niveau = 'NIVEAU_G';
						break;
					case 2386: //OPTIQUE
						if ($montant >= 700) $niveau = 'NIVEAU_A';
						if ($montant >300 && $montant <700) $niveau = 'NIVEAU_B';
						if ($montant <= 300) $niveau = 'NIVEAU_A';
						break;
					case 2388: //SANTECLAIR
						if ($montant >= 600) $niveau = 'NIVEAU_A';
						if ($montant >300 && $montant <600) $niveau = 'NIVEAU_B';
						if ($montant <= 300) $niveau = 'NIVEAU_A';
						break;
					case 2390: //PUBLIPOSTAGE
						if ($montant >= 700) $niveau = 'NIVEAU_A';
						if ($montant >300 && $montant <700) $niveau = 'NIVEAU_B';
						if ($montant <= 300) $niveau = 'NIVEAU_A';
						break;
					Default:
						$niveau = 'NIVEAU_A';
					break;
				}

			$montantRC = "";
			if ($ii == 3) $ii = 0;
				$cl = 'classe'.$ii;
				$ii++;
				$str .= "<tr class = '".$cl." ".$niveau."' id='".$row['id_lot']."' >";
	
				$str .= "<td>".$row['ldg']."</td>";
				if ($row['etape'] == 'Saisie')
				$str .= "<td  OnClick=getIdLotAlmerys('".$row['id_lot']."')>".$row['lib']."</td>";
				else $str .= "<td>".$row['lib']."</td>";
				$str .= "<td>".$row['num_nuo']."</td>";
				$str .= "<td>".$row['num_ps']."</td>";
				$str .= "<td>".$niveau."</td>";
				$str .= "<td>".$row['qte']."</td>";
				$str .= "<td>".$row['id_pers']."</td>";
				$str .= "<td>".$row['sat']."</td>";
				$str .= "<td>".$row['etape']."</td>";
				$str .= "<td>".$row['erreur']."</td>";
				//$str .= "<td><input type='checkbox'  class='case' name='options[]' id=".$row['id_lot'].">";
				//if ($_SESSION['id'] == '177')
				//$str .= "<td OnClick=deleteLot('".$row['id_lot']."') class='delete'></td>";
				$str .= "</tr>";
				$nbResult++;


				$sr = $row['ldg']."\t";
				$sr .= $niveau."\t";
				$sr .= $row['lib']."\t";
				$sr .= $row['num_nuo']."\t";
				$sr .= $row['num_ps']."\t";
				$sr .= $row['qte']."\t";
				$sr .= $row['etape']."\t";
				$sr .= $row['erreur']."\t";
				$sr .= $row['id_pers']."\t";
				$sr .= $row['id_pers']."\n";
				
				fwrite($fw, $sr);				
		}
		
		fclose($fw);
		$str .= "</table>";
		$nbLigne = "</table><table><tr><td><h4>Total Found: $nbResult</h4></td><td><a href='./CSV/$fName'><input type='submit' value='' class='copy' title='Exporter au format CSV'/></a></td></tr></table>";
		
		return $nbLigne.$str;
	}
	
	function GetDureeLot($idLot)
	{
		$sql = "SELECT p_ldt.h_deb, p_ldt.h_fin, quantite FROM p_ldt where id_lot =".$idLot;
		//return $sql;
		$rs=$this->cnx->query($sql);
		$qte=0;
		$somme="0:0:0";
		foreach($rs as $row)
		{
			if ($row['h_deb'] == "" || $row['h_fin'] == "") continue;
			$diff = $this->hDiff($row['h_deb'], $row['h_fin'], "");
			$somme = $this->hDiff($somme, $diff, "+");
			$qte+=$row['quantite'];
		}
		return $somme."$".$qte;
	}
	
	function SuiviLot($dossier, $lotClient, $matricule, $statut, $etape, $prio, $name, $ordre)
	{	
		$filtre = "";
		$filtreEtape = "";
		//if ($dossier != "") $filtre .= " AND p_dossier.id_dossier = $dossier";
		
		if ($lotClient != "") 	$filtre .= " AND p_lot.id_lotclient = $lotClient";
		if ($matricule != "") 	$filtre .= " AND p_lot.id_pers = $matricule";
		if ($statut != "") 		$filtre .= " AND p_lot.id_etat = $statut";	
		if ($etape != "") 		$filtreEtape .= " AND p_lien_oper_dossier.id_lien = $etape";
		if ($prio != "") 		$filtre .= " AND p_lot.priority = $prio";
		if ($name != "") 		$filtre .= " AND p_lot.libelle like '%$name%'";		
		
		
		$sql = "select id_lien, p_etape.libelle from p_lien_oper_dossier 
				LEFT JOIN p_etape ON p_lien_oper_dossier.id_oper=p_etape.id_etape
				WHERE id_dossier = $dossier $filtreEtape order by id_lien";
				//echo $sql;
		$rs=$this->cnx->query($sql);
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
		
		$i=1;
		$ii = 0;
		
		
		while($arr = $rs->fetch())
		{
		
		$nbLot=0;
		$statut0=0;
		$statut1=0;
		$statut2=0;
		$statut1_pris=0;
		$statutAutre=0;
		
		$dureeLotEtape = "0:0:0";
		
			if ($ii == 3) $ii = 0;
				$cl = 'classe'.$ii;
				$ii++;
				
			$sqlStatLot = "select id_etat, id_lot from p_lot where id_dossier = $dossier AND p_lot.id_etape =".$arr['id_lien'].$filtre;
			$rs1=$this->cnx->query($sqlStatLot);
			while($arr1 = $rs1->fetch())
			{
				$nbLot++;
				$rez = explode('$', $this->GetDureeLot($arr1['id_lot']));
				$duree = $rez[0];
				// $qte =  $rez[1];
				// $vitesse = number_format(($this->ToSeconde($duree)*$qte)/3600, 2);
				
				$dureeLotEtape  = $this->hDiff($dureeLotEtape, $duree, "+");
			
				switch ($arr1['id_etat'])
				{
					case '0':
						$statut0++;
						break;
					case '1':
						// chercher si en cours pris
						$d= date("Ymd", time());
						$sqle = "SELECT p_ldt.h_deb FROM p_ldt where id_lot =".$arr1['id_lot']." AND date_deb_ldt='$d'";
						//return $sqle;
						$rse=$this->cnx->query($sqle);
						foreach($rse as $row)
						{
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
			$str .= "<tr class = $cl id='".$arr['id_lien']."' >";
				$str .= "<td>".$i++."</td>";
				$str .= "<td>".$arr['libelle']."</td>";
				$str .= "<td>".$nbLot."</td>";
				$str .= "<td>".$statut0."</td>";
				$str .= "<td>".$statut1."</td>";
				$str .= "<td>".$statut1_pris."</td>";
				$str .= "<td>".$statut2."</td>";
				$str .= "<td>".$dureeLotEtape."</td>";
				$str .= "<td>".$statutAutre."</td></tr>";
		}
		$str .= "</table>";
		return $str;		
	}
	
	function SuiviLotAlmerys($dossier, $lotClient, $matricule, $statut, $etape, $prio, $name, $ordre)
	{	
		$filtre = "";
		if ($dossier != "") 	$filtre .= " AND p_dossier.id_dossier = $dossier";

		if ($lotClient != "") 	$filtre .= " AND almerys_p_lot.id_lotclient = $lotClient";
		if ($matricule != "") 	$filtre .= " AND almerys_p_lot.id_pers = $matricule";
		
		if ($etape != "") 		$filtre .= " AND almerys_p_lot.id_etape = $etape";
		
		if ($name != "") 		$filtre .= " AND almerys_p_lot.libelle like '%$name%'";	
		
		if ($prio != "") 		$filtre .= " AND almerys_p_lot.date_deb = '$prio'";	

		//$filtre .= " AND almerys_p_lot.id_pers IN (select matricule from almerys_user where id_cq = ".$_SESSION['id'].')';

		$sql = "SELECT  almerys_p_lot.id_etape, p_dossier.num_dossier, p_lot_client.libelle as ldg,almerys_p_lot.id_lotclient, almerys_p_lot.id_lot,almerys_p_lot.libelle as lib, p_etat.libelle as etat, p_etape.libelle as etape ,almerys_p_lot.id_pers, almerys_p_lot.priority, almerys_p_lot.id_pers, almerys_p_lot.duree, almerys_p_lot.qte, almerys_p_lot.erreur 
		FROM almerys_p_lot
        LEFT JOIN p_etat ON almerys_p_lot.id_etat= p_etat.id_etat 
		LEFT JOIN p_lien_oper_dossier ON almerys_p_lot.id_etape= p_lien_oper_dossier.id_lien  
		LEFT JOIN p_etape ON p_etape.id_etape= p_lien_oper_dossier.id_oper 
		LEFT JOIN p_lot_client ON almerys_p_lot.id_lotclient = p_lot_client.id_lotclient
		LEFT JOIN p_dossier ON p_lot_client.id_dossier = p_dossier.id_dossier
	
		WHERE 1=1";	

		$sql .= $filtre." order by lib";

		$str = "";
		$rs=$this->cnx->query($sql);
		
		$nbSaisie=0;
		$nbFdc=0;
		$nbOK=0;
		$nbNOK=0;
		$nbES=0;
		$nbNRRG=0;
		$nbAtt=0;

		//return $sql;
		foreach($rs as $row)
		{
				
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
			switch ($row['id_etape'])
				{
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
		if(!empty($row['ldg']))
		{
				$ldgname = ($lotClient != "") ? $row['ldg']: '<h3>TOTAL:</h3>';
				$str .= "
				<td>".$ldgname."</td>
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
	
	function suiviParMois($mois)
	{
		$sql = "SELECT p_ldt.date_deb_ldt,  p_ldt.h_deb, p_ldt.h_fin  FROM p_ldt 
				 
				where p_ldt.date_deb_ldt like '".$mois."%' order by p_ldt.date_deb_ldt, p_ldt.h_deb";
				
		//return $sql;
		$rs=$this->cnx->query($sql);
      
		$str = "<table  class='hj'>
		<thead><tr>
		<th  class='th' width='20%' id='num_dossier' class='filter'>Date</th>
		<th  class='th' id='p_etape.libelle'>Volume Horaire</th>
		</tr></thead>";
		
		$ii = 0; 
		
		$diff;
		$somme="0:0:0";
		$lastDate = "";
		
		foreach($rs as $row)
		{
			if ($ii >= 3) $ii = 0;
			if ($row['h_deb'] == "" || $row['h_fin'] == "") continue;

			$cl = 'classe'.$ii;			
						
			if ($lastDate != $row['date_deb_ldt']) 
			{
				$hdec = $this->ToHeureDecimal($somme);
				if ($lastDate != "") 
				{
					$str .= "<tr class = $cl>";
					$str .= "<td id='$".$lastDate.'|'.$hdec.">".$lastDate."</td>";
					$str .= "<td>".$hdec."</td>";
					$str .= "</tr>";
				}
				$somme="0:0:0";
				$ii++;
			}
			
			$lastDate = $row['date_deb_ldt'];
			$diff = $this->hDiff($row['h_deb'], $row['h_fin'], "");
			$somme = $this->hDiff($somme, $diff, "+");		
		}
		$str .= "</table>";
		return $str;		
	}
	
	function suiviDossierPeriode($lstPeriode)
	{
		$periode = $lstPeriode;
		$filtrePeriode = " AND p_ldt.date_deb_ldt = '".$lstPeriode."'";
		$tk = explode(",", $lstPeriode);
		
		if (count($tk) > 1)
		{
			$filtrePeriode = " AND p_ldt.date_deb_ldt >=  '".$tk[0]."' AND p_ldt.date_deb_ldt <= '".$tk[1]."'";
		}
		$sqlDoss = "select id_dossier, num_dossier from p_dossier order by num_dossier";

		$rsDoss=$this->cnx->query($sqlDoss);
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

		foreach($rsDoss as $rowDoss)
		{
			$dossier = $rowDoss['id_dossier'];
			//$str .= "<td>".$dossier."</td>";
			
			//:: selection utilisateur affect� au dossier
			//continue;
			
			$sql = "SELECT date_deb_ldt, h_deb, h_fin, id_type_ldt FROM p_ldt WHERE id_dossier = $dossier ".$filtrePeriode ." order by p_ldt.date_deb_ldt, p_ldt.h_deb";
			
			//return $sqlDoss;
			
			$rs=$this->cnx->query($sql);
			$diff;
			$somme="0:0:0";
			$pause="0:0:0";
			$panne="0:0:0";
			$formation="0:0:0";
			$exo="0:0:0";
			$formation="0:0:0";
			$autres="0:0:0";
			
			//if ($dossier == "") continue;
			
			foreach($rs as $row)
			{
				if ($row['h_deb'] == "" || $row['h_fin'] == "") continue;
				if (strlen($row['h_deb']) != 8 || strlen($row['h_deb']) != 8)continue;
				$diff = $this->hDiff($row['h_deb'], $row['h_fin'], "");
				
				
				//$str .= '<br/>'.$row['id_type_ldt'];
				switch($row['id_type_ldt'])
				{				
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
			if ($somme=="0:0:0") continue;
			//$rs->close();
			if ($ii >= 3) $ii = 0;
			$cl = 'classe'.$ii;
			$ii++;
			
			$nomDossier = $rowDoss['num_dossier'];
			$str .= "<tr class = $cl>";
			$str .= "<td>".$ii.$periode."</td>";
			$str .= "<td>".$nomDossier."</td>";
			$str .= "<td>".$this->ToHeureDecimal($somme)."</td>";
			$str .= "<td>".$this->ToHeureDecimal($pause)."</td>";
			$str .= "<td>".$this->ToHeureDecimal($panne)."</td>";
			$str .= "<td>".$this->ToHeureDecimal($formation)."</td>";
			$str .= "<td>".$this->ToHeureDecimal($exo)."</td>";
			$str .= "<td>".$this->ToHeureDecimal($autres)."</td>";
			$str .= "</tr>";
			$diff;
			$somme="0:0:0";
			$pause="0:0:0";
			$panne="0:0:0";
			$formation="0:0:0";
			$attente="0:0:0";
			$formation="0:0:0";
			$autres="0:0:0";
		}
		$str .= "</table>";
		return $str;
	}
	
	function suiviDossierPeriodeSave($lstPeriode)
	{
		$periode = $lstPeriode;
		$filtrePeriode = " AND p_ldt.date_deb_ldt = '".$lstPeriode."'";
		$tk = explode(",", $lstPeriode);
		
		if (count($tk) > 1)
		{
			$filtrePeriode = " AND p_ldt.date_deb_ldt >=  '".$tk[0]."' AND p_ldt.date_deb_ldt <= '".$tk[1]."'";
		}
		$sqlDoss = "select id_dossier, num_dossier from p_dossier";

		$rsDoss=$this->cnx->query($sqlDoss);
		$str = "<table class='dp'>";
		$ii = 0; 

		return $sqlDoss;
		foreach($rsDoss as $rowDoss)
		{
			$dossier = $rowDoss['id_dossier'];
			//$str .= "<td>".$dossier."</td>";
			
			//:: selection utilisateur affect� au dossier
			//continue;
			
			$sql = "SELECT date_deb_ldt, h_deb, h_fin FROM p_ldt WHERE id_dossier = ".$rowDoss['id_dossier'].$filtrePeriode ." order by p_ldt.date_deb_ldt, p_ldt.h_deb";
			
			//return $sqlDoss;
			
			$rs=$this->cnx->query($sql);
			$diff;
			$somme="0:0:0";
			if ($dossier == "") continue;
			
			foreach($rs as $row)
			{
				if ($row['h_deb'] == "" || $row['h_fin'] == "") continue;
				if (strlen($row['h_deb']) != 8 || strlen($row['h_deb']) != 8)continue;
				$diff = $this->hDiff($row['h_deb'], $row['h_fin'], "");
				$somme = $this->hDiff($somme, $diff, "+");
			}
			if ($somme=="0:0:0") continue;
			//$rs->close();
			if ($ii >= 3) $ii = 0;
			$cl = 'classe'.$ii;
			$ii++;
			
			$nomDossier = $rowDoss['num_dossier'];
			if ($nomDossier == "") $nomDossier  = "Hors prod";
			$str .= "<tr class = $cl>";
			$str .= "<td>".$periode."</td>";
			$str .= "<td>".$nomDossier."</td>";
			$str .= "<td>".$somme."</td>";
			$str .= "</tr>";
		}
		$str .= "</table>";
		return $str;
	}
	
	function dureeHorsProd($lstPeriode)
	{
		$periode = $lstPeriode;
		$filtrePeriode = " AND p_ldt.date_deb_ldt = '".$lstPeriode."'";
		$tk = explode(",", $lstPeriode);
		
		if (count($tk) > 1)
		{
			$filtrePeriode = " AND p_ldt.date_deb_ldt >=  '".$tk[0]."' AND p_ldt.date_deb_ldt <= '".$tk[1]."'";
		}
		$sqlDoss = "select id_dossier, num_dossier from p_dossier where id_etat = 0";

		$rsDoss=$this->cnx->query($sqlDoss);
		$str = "<table class='dp'>";
		$ii = 0; 

		foreach($rsDoss as $rowDoss)
		{
			$dossier = $rowDoss['id_dossier'];
			$sql = "SELECT date_deb_ldt, h_deb, h_fin FROM p_ldt WHERE id_type_ldt <> 0 ".$filtrePeriode ." order by p_ldt.date_deb_ldt, p_ldt.h_deb";
							
			$rs=$this->cnx->query($sql);
			$diff;
			$somme="0:0:0";
			if ($dossier != "") continue;
			foreach($rs as $row)
			{
				if ($row['h_deb'] == "" || $row['h_fin'] == "") continue;
				$diff = $this->hDiff($row['h_deb'], $row['h_fin'], "");
				$somme = $this->hDiff($somme, $diff, "+");
			}
			//$rs->close();
			if ($ii >= 3) $ii = 0;
			$cl = 'classe'.$ii;
			$ii++;
			
			$nomDossier = $rowDoss['num_dossier'];
			if ($nomDossier == "") $nomDossier  = "Hors prod";
			$str .= "<tr class = $cl>";
			$str .= "<td>".$periode."</td>";
			$str .= "<td>".$nomDossier."</td>";
			$str .= "<td>".$somme."</td>";
			$str .= "</tr>";
		}
		$str .= "</table>";
		return $str;
	}
	
	function getLstEtape($dossier)
	{
		$sql = "select id_lien, p_etape.libelle from p_lien_oper_dossier 
				LEFT JOIN p_etape ON p_lien_oper_dossier.id_oper=p_etape.id_etape
				WHERE id_dossier = $dossier order by id_lien";
		$rs=$this->cnx->query($sql);
		$str='<option value=""></option>';;
		while($arr = $rs->fetch())
		{
			$str .= '<option value="'.$arr['id_lien'].'">'.$arr['libelle'].'</option>';
		}
		return $str;
	}
	
	function suiviDossierEtape($lstPeriode, $dossier)
	{
		$periode = $lstPeriode;
		$filtrePeriode = " where p_ldt.date_deb_ldt = '".$lstPeriode."'";
		$tk = explode(",", $lstPeriode);
		
		if (count($tk) > 1)
		{
			$filtrePeriode = " where p_ldt.date_deb_ldt >=  '".$tk[0]."' AND p_ldt.date_deb_ldt <= '".$tk[1]."'";
		}
		$filtrePeriode .= " AND p_ldt.id_dossier = $dossier";
		$sqlLstEtape = "select distinct(id_etape) from p_ldt ".$filtrePeriode ;
		
		$sqlLstEtape = "select id_lien, p_etape.libelle from p_lien_oper_dossier 
							LEFT JOIN p_etape ON p_lien_oper_dossier.id_oper=p_etape.id_etape
							WHERE id_dossier = $dossier order by id_lien";
		
		

		$rsEtape=$this->cnx->query($sqlLstEtape);
		$str = "<table class='je'>";
		$ii = 0; 
		
		//return $sqlDoss;
		foreach($rsEtape as $rowDoss)
		{
			$etape = $rowDoss['id_lien'];
			$sql = "SELECT date_deb_ldt, h_deb, h_fin FROM p_ldt 
					$filtrePeriode AND p_ldt.id_etape = $etape order by p_ldt.date_deb_ldt, p_ldt.h_deb";
			
			$rs=$this->cnx->query($sql);
			$diff;
			$somme="0:0:0";
			
			//echo $sql;
			foreach($rs as $row)
			{
				if (count(explode(":", $row['h_deb'])) != 3 || count(explode(":", $row['h_fin'])) != 3) continue;
				
				$diff = $this->hDiff($row['h_deb'], $row['h_fin'], "");
				$somme = $this->hDiff($somme, $diff,"+");
			}
			if ($somme == "0:0:0") continue;
			if ($ii >= 3) $ii = 0;
			$cl = 'classe'.$ii;
			$ii++;
			
			$nomDossier = $this->getNumDossier($dossier);
			if ($nomDossier == "") $nomDossier  = "Hors prod";
			$str .= "<tr class = $cl>";
			$str .= "<td>".$periode."</td>";
			$str .= "<td>".$nomDossier."</td>";
			$str .= "<td>".$rowDoss['libelle']."</td>";
			$str .= "<td>".$somme."</td>";
			$str .= "</tr>";
		}
		$str .= "</table>";
		return $str;
	}
	
	function suiviDossierEtape4($lstPeriode, $dossier)
	{
		$periode = $lstPeriode;
		$filtrePeriode = " where p_ldt.date_deb_ldt = '".$lstPeriode."'";
		$tk = explode(",", $lstPeriode);
		
		if (count($tk) > 1)
		{
			$filtrePeriode = " where p_ldt.date_deb_ldt >=  '".$tk[0]."' AND p_ldt.date_deb_ldt <= '".$tk[1]."'";
		}
		$filtrePeriode .= " AND p_ldt.id_dossier = $dossier";
		$sqlDoss = "select distinct(id_etape) from p_ldt ".$filtrePeriode ;

		$rsDoss=$this->cnx->query($sqlDoss);
		$str = "<table class='je'>";
		$ii = 0; 
		
		//return $sqlDoss;
		/*
		
		lister les etapes concern�
		
		
		*/
		foreach($rsDoss as $rowDoss)
		{
			$etape = $rowDoss['id_etape'];
			$sql = "SELECT date_deb_ldt, h_deb, h_fin, num_dossier, p_etape.libelle  FROM p_ldt 
					LEFT JOIN p_dossier ON p_ldt.id_dossier=p_dossier.id_dossier
					LEFT JOIN p_lien_oper_dossier ON p_ldt.id_etape=p_lien_oper_dossier.id_lien 
					LEFT JOIN p_etape ON p_lien_oper_dossier.id_oper=p_etape.id_etape
					$filtrePeriode AND p_ldt.id_etape = $etape order by p_ldt.date_deb_ldt, p_ldt.h_deb";
			
			$rs=$this->cnx->query($sql);
			$diff;
			$somme="0:0:0";
			
			//return $sql;
			foreach($rs as $row)
			{
				if ($row['h_deb'] == "" || $row['h_fin'] == "") continue;
				$diff = $this->hDiff($row['h_deb'], $row['h_fin'], "");
				$somme = $this->hDiff($somme, $diff, "+");
			}
			
			if ($ii >= 3) $ii = 0;
			$cl = 'classe'.$ii;
			$ii++;
			
			$nomDossier = $row['num_dossier'];
			if ($nomDossier == "") $nomDossier  = "Hors prod";
			$str .= "<tr class = $cl>";
			$str .= "<td>".$periode."</td>";
			$str .= "<td>".$nomDossier."</td>";
			$str .= "<td>".$row['libelle']."</td>";
			$str .= "<td>".$somme."</td>";
			$str .= "</tr>";
		}
		$str .= "</table>";
		return $str;
	}
        
	function UpdateCqLot($qt, $err, $stat, $id, $lib, $com, $ldg, $doss, $id_pers, $id_nuo, $id_ps)
	{
		$rs=$this->cnx->exec("update almerys_p_lot set id_etat = 2 where id_lot = $id");
		$rs=$this->cnx->exec("INSERT INTO almerys_p_lot (id_dossier, id_lotclient, id_etat,id_etape,libelle, date_deb, h_deb, qte, erreur, id_pers, id_cq, num_nuo, num_ps)VALUES (" .$doss. "," .$ldg. ",0," .$stat. ",'" .$lib. "', substr(now()|| ' ', 0, 5)||substr(now()|| ' ', 6, 2)||substr(now()|| ' ', 9, 2), substr(now()|| ' ', 12, 8), '".$qt."', '".$err."', ".$id_pers.", ".$_SESSION['id'].", '".$id_nuo."', '".$id_ps."')");
		
		return "INSERT INTO almerys_p_lot (id_dossier, id_lotclient, id_etat,id_etape,libelle, date_deb, h_deb, qte, erreur, id_pers, id_cq, num_nuo)VALUES (" .$doss. "," .$ldg. ",0," .$stat. ",'" .$lib. "', substr(now()|| ' ', 0, 5)||substr(now()|| ' ', 6, 2)||substr(now()|| ' ', 9, 2), substr(now()|| ' ', 12, 8), '".$qt."', '".$err."', ".$id_pers.", ".$_SESSION['id'].", '".$id_nuo."')";
	}
	
        /**
         * 
         * Add by Mika RAHELISON
         * **/
        function GetDateDbt(){
            $sql = "SELECT distinct(jour_debut_action) FROM action ORDER BY jour_debut_action DESC";
			//$sql = "SELECT to_char(jour_debut_action,'dd/MM/yyyy') as test FROM action ORDER BY test;";
			//echo$sql;
			
            $rs=$this->cnx->query($sql);
            $str = "";
			
			while($arr = $rs->fetch())
			{
				$str .= '<option value="'.$arr['jour_debut_action'].'">'.$arr['jour_debut_action'].'</option>';
			}
		
		return $str;            
        }   
        
        function GetTicket($id){
			if($id != -1){
				$sql = "SELECT numero FROM ticket WHERE id_ticket=".(int)$id;
				$rs=$this->cnx->query($sql);
				$str = "";
				while($arr = $rs->fetch())
				{
					return $arr['numero'];
				}			
			}
			
            $sql = "SELECT * FROM ticket order by numero";
            $rs=$this->cnx->query($sql);
            $str = "";
			while($arr = $rs->fetch())
			{
				$str .= '<option value="'.$arr['id_ticket'].'">'.$arr['numero'].'</option>';
			}
		
		return $str;            
        }
		
        function GetDemandeur($id){
			if($id != -1){
				$sql = "SELECT id_demandeur,nom_prenom FROM demandeur WHERE id_demandeur=".(int)$id;
				$rs=$this->cnx->query($sql);
				$str = "";
				while($arr = $rs->fetch())
				{
					return $arr['nom_prenom'];
				}			
			}
			
            $sql = "SELECT id_demandeur,nom_prenom FROM demandeur";
            $rs=$this->cnx->query($sql);
            $str = "";
			while($arr = $rs->fetch())
			{
				$str .= '<option value="'.$arr['id_demandeur'].'">'.$arr['nom_prenom'].'</option>';
			}
		
		return $str;            
        }

        function GetTypeAction(){			
            $sql = "SELECT distinct(type_action) FROM action";
            $rs=$this->cnx->query($sql);
            $str = "";
			while($arr = $rs->fetch())
			{
				$str .= '<option value="'.$arr['type_action'].'">'.$arr['type_action'].'</option>';
			}
		
		return $str;            
        }				
		
        function GetSujet(){
            $sql = "SELECT distinct(sujet) FROM action";
            $rs=$this->cnx->query($sql);
            $str = "";
			$listSujet = array();
			
			while($arr = $rs->fetch())
			{
				$str .= '<option value="'.$arr['sujet'].'">'.$arr['sujet'].'</option>';
				//$listSujet[] = $arr['sujet'];
			}
		
		return $str;            
        }   

        function GetBeneficiaire($id){
			if($id == -1)
            $sql = "SELECT id_beneficiaire,nom_prenom FROM beneficiaire";
			else{
				$sql = "SELECT id_beneficiaire,nom_prenom FROM beneficiaire WHERE id_beneficiaire=".(int)$id;
				
				$rs=$this->cnx->query($sql);
				while($arr = $rs->fetch())
				{
					return $arr['nom_prenom'];
				}				
			}
			
            $rs=$this->cnx->query($sql);
            $str = "";
			while($arr = $rs->fetch())
			{
				$str .= '<option value="'.$arr['id_beneficiaire'].'">'.$arr['nom_prenom'].'</option>';
			}
		
		return $str;            
        }   		

        function GetStatut(){
            $sql = "SELECT statut FROM action";
            $rs=$this->cnx->query($sql);
            $str = "";
			$arrayToManipulate = array();
			
			while($arr = $rs->fetch())
			{
				if(!in_array($arr['statut'], $arrayToManipulate))
					$arrayToManipulate[] = $arr['statut'];
			}			
			
			foreach	($arrayToManipulate as $key)
			{
				$str .= '<option value="'.$key.'">'.$key.'</option>';
			}
		
			return $str;            
        }           		
		
        function GetDateFin(){
            $sql = "SELECT id_action,jour_fin_action FROM action  ORDER BY jour_fin_action";
            $rs=$this->cnx->query($sql);
            $str = "";
			while($arr = $rs->fetch())
			{
				$str .= '<option value="'.$arr['id_action'].'">'.$arr['jour_fin_action'].'</option>';
			}
			
			return $str;            
        }         
        
		function GetDateFinDistinct(){
            $sql = "SELECT DISTINCT jour_fin_action FROM action  ORDER BY jour_fin_action DESC";
            $rs=$this->cnx->query($sql);
            $str = "";
			while($arr = $rs->fetch())
			{
				$str .= '<option value="'.$arr['jour_fin_action'].'">'.$arr['jour_fin_action'].'</option>';
			}
			
			return $str;            
        }  

        function GetIntervenant($id){
			if($id != -1){
				$sql = "SELECT id_intervenant,nom_prenom FROM intervenant WHERE id_intervenant=".(int)$id;
				$rs=$this->cnx->query($sql);
				$str = "";
				while($arr = $rs->fetch())
				{
					return $arr['nom_prenom'];
				}			
			}
			
            $sql = "SELECT id_intervenant,nom_prenom FROM intervenant";
            $rs=$this->cnx->query($sql);
            $str = "";
			while($arr = $rs->fetch())
			{
				$str .= '<option value="'.$arr['id_intervenant'].'">'.$arr['nom_prenom'].'</option>';
			}
		
		return $str;            
        }        
		
		function GetActionTickets($_jourDebut,$_jour_fin){
			$jourDbt = "";
			$jourFin = "";
			$listAction = array();
			$listDate = array();
			$listActionDate = array();
		
			if($_jourDebut =="" || $_jour_fin=="" || $_jourDebut>$_jour_fin){
				return null;
				//$jourFin = " AND jour_debut_action <= '" . $_jour_fin."'" ;
			}
			
			$sqlAction = "SELECT distinct(type_action) from action ORDER BY type_action";
			//$sqlAction = "SELECT distinct(type_action) from action";
			$sqlDate = "SELECT distinct(jour_debut_action) FROM action WHERE jour_debut_action BETWEEN '".$_jourDebut."' AND '".$_jour_fin."'";
			//echo$sqlDate;
			
			
			$rsAction=$this->cnx->query($sqlAction);
			$rsDate=$this->cnx->query($sqlDate);
			
			$str = "<table id='table_1' class='value'><tr><td>Actions sur les tickets</td>";
			while($arrDate = $rsDate->fetch())
			{
				$listDate[] = $arrDate["jour_debut_action"];
				$str .= "<td>".$arrDate["jour_debut_action"]."</td>";
			}			
			$str .= "<tr/>";	
			
			while($arrAction = $rsAction->fetch())
			{
				$listAction[] = $arrAction["type_action"];
			}
							
			foreach($listAction as &$action)
			{
				$str .= "<tr><td>".$action."</td>";
				foreach($listDate as &$date){
					//listStatutDate[statut] = $date;
					$sqlResult = "SELECT count(id_action) as nb_action FROM action WHERE TRUE AND type_action='".str_replace("'","''",$action)."' AND jour_debut_action='".$date."'";
					//echo$action."</br>";
					//break;
					$rsResult=$this->cnx->query($sqlResult);
					while($arrResult = $rsResult->fetch())
					{
						$str .= "<td>".$arrResult["nb_action"]."</td>";
					}								
				}
				$str .= "</tr>";
			}
			
			$str .= "</table>";
				
			include_once('exportTab.php');				
											
			return $str;
		}

		function GetAnalyseParHeure($_jourDebut,$_jour_fin){
			$jourDbt = "";
			$jourFin = "";
			$listAction = array();
			$listDate = array();
			$listActionDate = array();
			$listHeures = array();
		
			if(($_jourDebut =="" && $_jour_fin=="") || ($_jourDebut>$_jour_fin)){
				return null;
				//$jourFin = " AND jour_debut_action <= '" . $_jour_fin."'" ;
			}
			
			if($_jourDebut !="" && $_jour_fin!=""){
				$jourDbt = " AND jour_debut_action >='" . $_jourDebut."'" ;
				$jourFin = " And jour_fin_action < '" . $_jour_fin."'" ;
			}

			/*if($_jourDebut !="" && $_jour_fin==""){
				$jourFin = " And jour_fin_action < '" . date('Ymd')."'" ;
			}*/

			//echo$jourDbt;
			//$sqlAction = "SELECT distinct(type_action) from action";
			$sqlDate = "SELECT distinct(jour_debut_action) FROM action WHERE TRUE $jourDbt $jourFin";
			//echo$sqlDate;
			
			
			//$rsAction=$this->cnx->query($sqlAction);
			$rsDate=$this->cnx->query($sqlDate);
			
			$str = "<table id='table_1' class='value'><tr><td>Analyses par heure</td>";
			while($arrDate = $rsDate->fetch())
			{
				$listDate[] = $arrDate["jour_debut_action"];
				$str .= "<td>".$arrDate["jour_debut_action"]."</td>";
			}			
			$str .= "<tr/>";	
			
			$listHeures = array ("<24 h","<48h","plus de 3j","plus de 4j","plus de 5j","plus de 6j","plus de 7j","plus de 8j","plus de 9j","plus de 10j");			
			
			/*while($arrAction = $rsAction->fetch())
			{
				$listAction[] = $arrAction["type_action"];
			}*/
							
			foreach($listHeures as &$heure)
			{
				$str .= "<tr><td>".$heure."</td>";
				foreach($listDate as &$date){

					$sqlResultFinal = "";
					$hours = 24;
					$requete = "SELECT count(id_ticket) from (SELECT Distinct On(id_ticket) DATEDIFF('hh', action.date_ouverture::timestamp, action.date_fin::timestamp) as di, id_ticket  from action WHERE jour_debut_action = ";
					
					switch($heure){
							case "<24 h":
								$sqlResultFinal = $requete ."'".$date."' AND date_fin NOTNULL AND date_fin != '' and DATEDIFF('hh', action.date_ouverture::timestamp, action.date_fin::timestamp) < ".($hours).") AS count";
							break;
								
							case "<48h":
								$sqlResultFinal = $requete ."'".$date."' AND date_fin NOTNULL AND date_fin != '' and DATEDIFF('hh', action.date_ouverture::timestamp, action.date_fin::timestamp) < ".($hours * 2).") AS count";
							break;

							case "plus de 3j":
								$sqlResultFinal = $requete ."'".$date."' AND date_fin NOTNULL AND date_fin != '' and DATEDIFF('hh', action.date_ouverture::timestamp, action.date_fin::timestamp) < ".($hours * 3).") AS count";
							break;

							case "plus de 4j":
								$sqlResultFinal = $requete ."'".$date."' AND date_fin NOTNULL AND date_fin != '' and DATEDIFF('hh', action.date_ouverture::timestamp, action.date_fin::timestamp) < ".($hours * 4).") AS count";
							break;

							case "plus de 5j":
								$sqlResultFinal = $requete ."'".$date."' AND date_fin NOTNULL AND date_fin != '' and DATEDIFF('hh', action.date_ouverture::timestamp, action.date_fin::timestamp) < ".($hours * 5).") AS count";
							break;

							case "plus de 6j":
								$sqlResultFinal = $requete ."'".$date."' AND date_fin NOTNULL AND date_fin != '' and DATEDIFF('hh', action.date_ouverture::timestamp, action.date_fin::timestamp) < ".($hours * 6).") AS count";																
							break;

							case "plus de 7j":
								$sqlResultFinal = $requete ."'".$date."' AND date_fin NOTNULL AND date_fin != '' and DATEDIFF('hh', action.date_ouverture::timestamp, action.date_fin::timestamp) < ".($hours * 7).") AS count";
							break;

							case "plus de 8j":
								$sqlResultFinal = $requete ."'".$date."' AND date_fin NOTNULL AND date_fin != '' and DATEDIFF('hh', action.date_ouverture::timestamp, action.date_fin::timestamp) < ".($hours * 8).") AS count";
							break;

							case "plus de 9j":
								$sqlResultFinal = $requete ."'".$date."' AND date_fin NOTNULL AND date_fin != '' and DATEDIFF('hh', action.date_ouverture::timestamp, action.date_fin::timestamp) < ".($hours * 9).") AS count";
							break;

							case "plus de 10j":
								$sqlResultFinal = $requete ."'".$date."' AND date_fin NOTNULL AND date_fin != '' and DATEDIFF('hh', action.date_ouverture::timestamp, action.date_fin::timestamp) < ".($hours * 10).") AS count";
							break;
							
					}
						//echo $sqlResultFinal;
						
					$rsResultFinal = $this->cnx->query($sqlResultFinal);
								
					while($arrResultFinal = $rsResultFinal->fetch())
					{
						$str .= "<td>".$arrResultFinal["count"]."</td>";
					}			
								
				}
				$str .= "</tr>";
			}
			
			$str .= "<tr><td>Ticket le plus vieux en jours parmi les tickets en vie</td>";
			foreach($listDate as &$date){
				$sqlTicketLePlusVieux = "SELECT numero FROM ticket WHERE id_ticket = ";
				$sqlTicketLePlusVieux .= "(SELECT id_ticket FROM (SELECT Distinct On(id_ticket)";
				$sqlTicketLePlusVieux .= " DATEDIFF('hh', action.date_ouverture::timestamp, action.date_fin::timestamp)";
				$sqlTicketLePlusVieux .= " as di, id_ticket  from action WHERE jour_debut_action = '".$date."' AND date_fin NOTNULL AND date_fin != '')";
				$sqlTicketLePlusVieux .=  "As maxdurre WHERE di = (SELECT max(di) FROM (SELECT Distinct On(id_ticket)";
 				$sqlTicketLePlusVieux .=  "DATEDIFF('hh', action.date_ouverture::timestamp, action.date_fin::timestamp)";
 				$sqlTicketLePlusVieux .=  " as di, id_ticket  from action WHERE jour_debut_action = '".$date."' AND date_fin NOTNULL AND date_fin != '') As maxdurre))";

				$rsTicketLePlusVieux = $this->cnx->query($sqlTicketLePlusVieux);
								
				while($arrTicketLePlusVieux = $rsTicketLePlusVieux->fetch())
				{
					$str .= "<td>".$arrTicketLePlusVieux["numero"]."</td>";
				}						
			}
			$str .= "</tr>";
			
			$str .= "<tr><td>Durée de vie moyenne d'un ticket - Demande </td>";			
			
			foreach($listDate as &$date){
				$sqlDureeDevieTicketDemande = "SELECT avg(DATEDIFF('hh', date_ouverture::timestamp, date_fin::timestamp)) as moyenne";
				$sqlDureeDevieTicketDemande .= " from (SELECT DISTINCT ON (action.id_ticket) action.date_ouverture, action.date_fin";
				$sqlDureeDevieTicketDemande .= " FROM action inner join ticket USING (id_ticket) WHERE (statut = 'Clôturé' OR statut = ";
				$sqlDureeDevieTicketDemande .= "'En attente de validation') AND jour_debut_action = '".$date."' AND ticket.numero LIKE 'S%') AS action_ticket_distinct ";	

				$rsDureeDevieTicketDemande = $this->cnx->query($sqlDureeDevieTicketDemande );

				//echo$sqlDureeDevieTicketDemande;
					
				while($arrDureeDevieTicketDemande = $rsDureeDevieTicketDemande->fetch())
				{
					$str .= "<td>".round($arrDureeDevieTicketDemande["moyenne"])." h</td>";
				}						
				
			}
			
			$str .= "</tr>";
			
			$str .= "<tr><td>Durée de vie moyenne d'un ticket - Incidents</td>";			
			
			foreach($listDate as &$date){
				$sqlDureeDevieTicketIncident = "SELECT avg(DATEDIFF('hh', date_ouverture::timestamp, date_fin::timestamp)) as moyenne";
				$sqlDureeDevieTicketIncident .= " from (SELECT DISTINCT ON (action.id_ticket) action.date_ouverture, action.date_fin";
				$sqlDureeDevieTicketIncident .= " FROM action inner join ticket USING (id_ticket) WHERE (statut = 'Clôturé' OR statut = ";
				$sqlDureeDevieTicketIncident .= "'En attente de validation') AND jour_debut_action = '".$date."' AND ticket.numero LIKE 'I%') AS action_ticket_distinct ";	

				$rsDureeDevieTicketIncident = $this->cnx->query($sqlDureeDevieTicketIncident );

				//echo$sqlDureeDevieTicketDemande;
					
				while($arrDureeDevieTicketIncident = $rsDureeDevieTicketIncident->fetch())
				{
					$str .= "<td>".round($arrDureeDevieTicketIncident["moyenne"])." h</td>";
				}						
				
			}
			
			$str .= "</tr>";			

			$str .= "</table>";
				
			include_once('exportTab.php');				
											
			return $str;
		}		
		
		function GetStatutsTickets($_jourDebut,$_jour_fin){
			$jourDbt = "";
			$jourFin = "";
			$listStatut = array();
			$listDate = array();
			$listStatutDate = array();
		
			if($_jourDebut =="" || $_jour_fin=="" || $_jourDebut>$_jour_fin){
				return null;
				//$jourFin = " AND jour_debut_action <= '" . $_jour_fin."'" ;
			}
		
			$sqlStatut = "SELECT distinct(statut) from action ORDER BY statut";
			//$sqlStatut = "SELECT distinct(statut) from action";
			//$sqlDate = "SELECT distinct(jour_debut_action) FROM action WHERE jour_debut_action  ::date >= to_date('".$_jourDebut."','dd/mm/yyyy') and jour_debut_action::date <= to_date('".$_jour_fin."','dd/mm/yyyy')";
			$sqlDate = "SELECT distinct(jour_debut_action) FROM action WHERE jour_debut_action BETWEEN '".$_jourDebut."' AND '".$_jour_fin."'";
			//echo$sqlDate;

			
			$rsStatut=$this->cnx->query($sqlStatut);
			$rsDate=$this->cnx->query($sqlDate);
			
			$str = "<table id='table_1' class='value'><tr><td>Statuts des tickets</td>";
			while($arrDate = $rsDate->fetch())
			{
				$listDate[] = $arrDate["jour_debut_action"];
				$str .= "<td>".$arrDate["jour_debut_action"]."</td>";
			}			
			$str .= "<tr/>";	
			
			while($arrStatut = $rsStatut->fetch())
			{
				$listStatut[] = $arrStatut["statut"];
			}


			foreach($listStatut as &$statut) 
			{	
				$statut_sql = $this->cnx->quote($statut); 

				$str .= "<tr><td>".$statut."</td>"; 
				foreach($listDate as &$date){	
					//listStatutDate[statut] = $date;
					$compte = 0; 
					$sqlResult = "SELECT count(distinct id_ticket) as nb_action FROM action WHERE TRUE AND statut = $statut_sql AND jour_debut_action='".$date."'";
					$rsResult=$this->cnx->query($sqlResult);
					while($arrResult = $rsResult->fetch())
					{
						$compte++;
						$str .= "<td>".$arrResult["nb_action"]."</td>";
					}	
					$str .= "<td>".$compte."</td>";
				}
				$str .= "</tr>";
			}


			$str .= "<tr><td>Total</td>";
				foreach($listDate as &$date){
					//listStatutDate[statut] = $date;
					$sqlTotal = "SELECT count(distinct id_ticket) AS total FROM action WHERE TRUE AND jour_debut_action = '".$date."' AND (statut != ''  AND statut NOTNULL AND statut!=' ')";
					
					$rsResultPourcentage=$this->cnx->query($sqlTotal);
					while($arrResult = $rsResultPourcentage->fetch())
					{
						$str .= "<td style=''>".$arrResult["total"]."</td>";
					}								
				}
			$str .= "</tr>";


			$str .= "<tr><td>T% de traitement</td>";
				foreach($listDate as &$date){
					//listStatutDate[statut] = $date;
					$sqlPourcentage = "SELECT distinct(SELECT CAST((SELECT count(distinct id_ticket) FROM action WHERE TRUE AND jour_debut_action = '".$date."'";
					$sqlPourcentage .= " AND (statut = 'En attente de validation' OR statut = 'Clôturé')) AS float))/(SELECT CAST((SELECT count(distinct id_ticket)";
					$sqlPourcentage .= "   FROM action WHERE TRUE AND statut!='' AND statut NOTNULL AND statut!=' ' AND jour_debut_action = '".$date."') AS float))As pourcentage FROM action";
					
					$rsResultPourcentage=$this->cnx->query($sqlPourcentage);
					while($arrResult = $rsResultPourcentage->fetch())
					{
						$str .= "<td style='font-weight:bold'>".round($arrResult["pourcentage"]*100)."%</td>";
					}								
				}
			$str .= "</tr>";

			$str .= "<tr><td>Durée de vie d'un ticket</td>";
				foreach($listDate as &$date){
					$testBoolean = true;
					//listStatutDate[statut] = $date;
					$sqlTest = "SELECT DISTINCT ON (action.id_ticket) action.date_ouverture, action.date_fin FROM action WHERE (statut = 'Clôturé' OR statut = 'En attente de validation') AND jour_debut_action = '".$date."'";
					$rsResultTest=$this->cnx->query($sqlTest);
					while($arrResult = $rsResultTest->fetch())
					{
						if (strpos($arrResult["date_ouverture"], ',') != false) { 
							$testBoolean = false;
						}
						if (strpos($arrResult["date_fin"], ',') != false) { 
							$testBoolean = false;
						}
					}								
					
					
					$sqlDurre = "SELECT avg(DATEDIFF('hh', date_ouverture::timestamp, date_fin::timestamp)) from (SELECT DISTINCT ON (action.id_ticket) action.date_ouverture, action.date_fin FROM action WHERE (statut = 'Clôturé' OR statut = 'En attente de validation') AND jour_debut_action = '".$date."') AS action_ticket_distinct ";
					//echo$sqlDurre;
					if($testBoolean == true){
						$rsResultDurre=$this->cnx->query($sqlDurre);
						while($arrResult = $rsResultDurre->fetch())
						{
							$str .= "<td style='font-weight:bold'>".round($arrResult["avg"])." h</td>";
						}								
					}

				}
			$str .= "</tr>";

			
			$str .= "</table>";
				
			include_once('exportTab.php');				
			
			/*
			$date_Debut = DateTime::createFromFormat('Ymd',$_jourDebut);
			$date_Fin = DateTime::createFromFormat('Ymd',$_jour_fin);
			//return "debut = ".date_format($date_Debut,'Ymd')." Fin = ".$_jour_fin;

			while(true){
				$str .= $this->GetStatutsTicketsWithFiltreDateDuJour($_jourDebut , $_jour_fin , date_format($date_Debut,'Ymd'));
				$date_Debut->modify('+1 day');
				
				if($date_Debut > $date_Fin) break;
			}
			*/


			$str .= $this->GetStatutsTicketsWithFiltreDateDuJour($_jourDebut , $_jour_fin);

			return $str;
		}		
			
		function GetStatutsTicketsWithFiltreDateDuJour($_jourDebut,$_jour_fin){
			$jourDbt = "";
			$jourFin = "";
			$listStatut = array();
			$listDate = array();
			$listStatutDate = array();
			

			if($_jourDebut =="" || $_jour_fin=="" || $_jourDebut>$_jour_fin){
				return null;
				//$jourFin = " AND jour_debut_action <= '" . $_jour_fin."'" ;
			} 
		
			$sqlStatut = "SELECT distinct(statut) from action ORDER BY statut";
			//$sqlStatut = "SELECT distinct(statut) from action";
			//$sqlDate = "SELECT distinct(jour_debut_action) FROM action WHERE jour_debut_action  ::date >= to_date('".$_jourDebut."','dd/mm/yyyy') and jour_debut_action::date <= to_date('".$_jour_fin."','dd/mm/yyyy')";
			$sqlDate = "SELECT distinct(jour_debut_action) FROM action WHERE jour_debut_action BETWEEN '".$_jourDebut."' AND '".$_jour_fin."'";
			//echo$sqlDate;
			

			
			$rsStatut=$this->cnx->query($sqlStatut);
			$rsDate=$this->cnx->query($sqlDate);
			

			$str = "<h1>DATE DU JOUR</h1>";
			$str .= "<table id='table_1' class='value'><tr><td>Statuts des tickets</td>";
			while($arrDate = $rsDate->fetch())
			{
				$listDate[] = $arrDate["jour_debut_action"];
				$str .= "<td>".$arrDate["jour_debut_action"]."</td>";
			}			
			$str .= "<tr/>";	
			
			while($arrStatut = $rsStatut->fetch())
			{
				$listStatut[] = $arrStatut["statut"];
			}
							
			foreach($listStatut as &$statut)
			{
				$statut_sql = $this->cnx->quote($statut); 

				$str .= "<tr><td>".$statut."</td>";
				foreach($listDate as &$date){

					$filtre_date_du_jour = " AND to_char(CAST(date_ouverture AS TIMESTAMP),'YYYYMMDD') LIKE '".$date."' ";

					//listStatutDate[statut] = $date;
					$compte = 0;
					$sqlResult = "SELECT count(distinct id_ticket) as nb_action FROM action WHERE TRUE AND statut = $statut_sql AND jour_debut_action='".$date."'"; 
					$sqlResult .= $filtre_date_du_jour;

					$rsResult=$this->cnx->query($sqlResult);
					while($arrResult = $rsResult->fetch())
					{
						$compte++;
						$str .= "<td>".$arrResult["nb_action"]."</td>";
					}	
					//$str .= "<td>".$compte."</td>";
				}
				$str .= "</tr>";
			}

			$str .= "<tr><td>Total</td>";
				foreach($listDate as &$date){

					$filtre_date_du_jour = " AND to_char(CAST(date_ouverture AS TIMESTAMP),'YYYYMMDD') LIKE '".$date."' ";

					//listStatutDate[statut] = $date;
					$sqlTotal = "SELECT count(distinct id_ticket) AS total FROM action WHERE  jour_debut_action = '".$date."' AND (statut != ''  AND statut NOTNULL AND statut!=' ')";
					$sqlTotal .= $filtre_date_du_jour;

					$rsResultPourcentage=$this->cnx->query($sqlTotal);
					while($arrResult = $rsResultPourcentage->fetch())
					{
						$str .= "<td style=''>".$arrResult["total"]."</td>";
					}								
				}
			$str .= "</tr>";

			
			$str .= "<tr><td>T% de traitement</td>";
				foreach($listDate as &$date){

					$filtre_date_du_jour = " AND to_char(CAST(date_ouverture AS TIMESTAMP),'YYYYMMDD') LIKE '".$date."' ";

					//listStatutDate[statut] = $date;
					$sqlPourcentage = "SELECT distinct(SELECT CAST((SELECT count(distinct id_ticket) FROM action WHERE TRUE AND jour_debut_action = '".$date."'";
						$sqlPourcentage .= $filtre_date_du_jour;
					$sqlPourcentage .= " AND (statut = 'En attente de validation' OR statut = 'Clôturé')) AS float))/(SELECT CAST((SELECT count(distinct id_ticket)";
					$sqlPourcentage .= "   FROM action WHERE TRUE AND statut!='' AND statut NOTNULL AND statut!=' ' AND jour_debut_action = '".$date."' ".$filtre_date_du_jour.") AS float))As pourcentage FROM action";
					

					$rsResultPourcentage=$this->cnx->query($sqlPourcentage);
					while($arrResult = $rsResultPourcentage->fetch())
					{
						$str .= "<td style='font-weight:bold'>".round($arrResult["pourcentage"]*100)."%</td>";
					}								
				}
			$str .= "</tr>";

			$str .= "<tr><td>Durée de vie d'un ticket</td>";
				foreach($listDate as &$date){

					$filtre_date_du_jour = " AND to_char(CAST(date_ouverture AS TIMESTAMP),'YYYYMMDD') LIKE '".$date."' ";

					$testBoolean = true;
					//listStatutDate[statut] = $date;
					$sqlTest = "SELECT DISTINCT ON (action.id_ticket) action.date_ouverture, action.date_fin FROM action WHERE (statut = 'Clôturé' OR statut = 'En attente de validation') AND jour_debut_action = '".$date."'";
					$sqlTest .= $filtre_date_du_jour;

					$rsResultTest=$this->cnx->query($sqlTest);
					while($arrResult = $rsResultTest->fetch())
					{
						if (strpos($arrResult["date_ouverture"], ',') != false) { 
							$testBoolean = false;
						}
						if (strpos($arrResult["date_fin"], ',') != false) { 
							$testBoolean = false;
						}
					}								
					
					
					$sqlDurre = "SELECT avg(DATEDIFF('hh', date_ouverture::timestamp, date_fin::timestamp)) from (SELECT DISTINCT ON (action.id_ticket) action.date_ouverture, action.date_fin FROM action WHERE (statut = 'Clôturé' OR statut = 'En attente de validation') ".$filtre_date_du_jour."AND jour_debut_action = '".$date."') AS action_ticket_distinct ";

					//return $sqlDurre;
					//echo$sqlDurre;
					if($testBoolean == true){
						$rsResultDurre=$this->cnx->query($sqlDurre);
						while($arrResult = $rsResultDurre->fetch())
						{
							$str .= "<td style='font-weight:bold'>".round($arrResult["avg"])." h</td>";
						}								
					}
				}
			$str .= "</tr>";

			
			$str .= "</table>";
				
			include_once('exportTab.php');				
											
			return $str;
		}




		function GetSujetsTickets($_jourDebut,$_jour_fin){
			$jourDbt = "";
			$jourFin = "";
			$listSujet = array();
			$listDate = array();
		
			if($_jourDebut =="" || $_jour_fin=="" || $_jourDebut>$_jour_fin){
				return null;
				//$jourFin = " AND jour_debut_action <= '" . $_jour_fin."'" ;
			}
		
			$sqlSujet = "SELECT distinct(sujet) from action ORDER BY sujet";
			$sqlDate = "SELECT distinct(jour_debut_action) FROM action WHERE jour_debut_action BETWEEN '".$_jourDebut."' AND '".$_jour_fin."'";
			//echo$sqlDate;
			
			
			$rsSujet=$this->cnx->query($sqlSujet);
			$rsDate=$this->cnx->query($sqlDate);
			
			$str = "<table id='table_1' class='value'><tr><td>Sujets sur les tickets</td>";
			while($arrDate = $rsDate->fetch())
			{
				$listDate[] = $arrDate["jour_debut_action"];
				$str .= "<td>".$arrDate["jour_debut_action"]."</td>";
			}			
			$str .= "<tr/>";	
			
			while($arrSujet = $rsSujet->fetch())
			{
				$listSujet[] = $arrSujet["sujet"];
			}
							
			foreach($listSujet as &$sujet)
			{
				$str .= "<tr><td>".$sujet."</td>";
				foreach($listDate as &$date){
					//listStatutDate[statut] = $date;
					//$sqlResult = "SELECT count(distinct id_ticket) as nb_action FROM action WHERE TRUE AND statut='".$statut."' AND jour_debut_action='".$date."'";					
					$sqlResult = "SELECT count(distinct id_ticket) as nb_action FROM action WHERE TRUE AND sujet='".str_replace("'","''",$sujet)."' AND jour_debut_action='".$date."'";
					//echo$action."</br>";
					//break;
					$rsResult=$this->cnx->query($sqlResult);
					while($arrResult = $rsResult->fetch())
					{
						$str .= "<td>".$arrResult["nb_action"]."</td>";
					}								
				}
				$str .= "</tr>";
			}
			$str .= "</table>";
				
			include_once('exportTab.php');				
											
			return $str;
		}		
		
		function GetIntervenantTickets($_jourDebut,$_jour_fin,$_choix){
			$jourDbt = "";
			$jourFin = "";
			$listIntervenant = array();
			$listDate = array();
		
			if($_jourDebut =="" || $_jour_fin=="" || $_jourDebut>$_jour_fin){
				return null;
				//$jourFin = " AND jour_debut_action <= '" . $_jour_fin."'" ;
			}
		
			$sqlIntervenant = "SELECT distinct(nom_prenom) from intervenant ORDER BY nom_prenom";
			$sqlDate = "SELECT distinct(jour_debut_action) FROM action WHERE jour_debut_action BETWEEN '".$_jourDebut."' AND '".$_jour_fin."'";
			
			$sqlWithJoin = "SELECT (intervenant.nom_prenom) as nom_prenom_intervenant,action.debut_action,action.fin_action,";
			$sqlWithJoin .= "(action.type_action) as action_type_action,ticket.numero FROM intervenant inner join action USING";
			$sqlWithJoin .= " (id_intervenant) inner join ticket  USING (id_ticket) WHERE true";
			//echo$sqlDate;
			
			
			$rsIntervenant=$this->cnx->query($sqlIntervenant);
			$rsDate=$this->cnx->query($sqlDate);
			
			$str = "";
			
			if($_choix == 'demandes')
				$str = "<table id='table_1' class='value'><tr><td>INTERVENANTS  AVEC LES TICKETS DEMANDES </td>";
			else
				$str = "<table id='table_1' class='value'><tr><td>INTERVENANTS  AVEC LES TICKETS INCIDENTS </td>";
				
			
			while($arrDate = $rsDate->fetch())
			{
				$listDate[] = $arrDate["jour_debut_action"];
				$str .= "<td COLSPAN=2>".$arrDate["jour_debut_action"]."</td>";
			}			
			$str .= "<tr/><tr>";	
			$str .= "<td>&nbsp;</td>";
			
			foreach($listDate as $tmp)
			{
				$str .= "<td>Total</td><td>Clos</td>";	
			}				
						
			$str .= "<tr/>";				
			
			while($arrIntervenant = $rsIntervenant->fetch())
			{
				$listIntervenant[] = $arrIntervenant["nom_prenom"];
			}
							
			foreach($listIntervenant as &$intervenant)
			{
				$str .= "<tr><td>".$intervenant."</td>";
				foreach($listDate as &$date){
					//listStatutDate[statut] = $date;
					//$sqlResult = "SELECT count(id_action) as nb_action FROM action WHERE TRUE AND sujet='".str_replace("'","\'",$sujet)."' AND jour_debut_action='".$date."'";
					
					$sqlForDateEnAttenteCloturE = "SELECT count(distinct id_ticket) as nb_action";
					$sqlForDateEnAttenteCloturE .= " FROM intervenant inner join action USING";
					
					$sqlResult = "SELECT count(distinct id_ticket) as nb_action";
					$sqlResult .= " FROM intervenant inner join action USING";
					if($_choix == 'demandes'){
						$sqlResult .= " (id_intervenant) inner join ticket  USING (id_ticket) WHERE true AND jour_debut_action ='".$date."' AND (action.statut = 'Clôturé' OR action.statut = 'En attente de validation') AND intervenant.nom_prenom ='".$intervenant."' AND ticket.numero LIKE 'S%'";					
						$sqlForDateEnAttenteCloturE .= " (id_intervenant) inner join ticket  USING (id_ticket) WHERE true AND jour_debut_action ='".$date."' AND intervenant.nom_prenom ='".$intervenant."' AND ticket.numero LIKE 'S%'";										
					}
					else{
						$sqlResult .= " (id_intervenant) inner join ticket  USING (id_ticket) WHERE true  AND jour_debut_action ='".$date."' AND (action.statut = 'Clôturé' OR action.statut = 'En attente de validation') AND intervenant.nom_prenom ='".$intervenant."' AND ticket.numero LIKE 'I%'";					
						$sqlForDateEnAttenteCloturE .= " (id_intervenant) inner join ticket  USING (id_ticket) WHERE true  AND jour_debut_action ='".$date."' AND intervenant.nom_prenom ='".$intervenant."' AND ticket.numero LIKE 'I%'";					
					}					
						
					//echo$action."</br>";
					//break;
					$rsResult=$this->cnx->query($sqlResult);
					$rsResultForDateEnAttenteCloturE=$this->cnx->query($sqlForDateEnAttenteCloturE);

					while($arrResult = $rsResultForDateEnAttenteCloturE->fetch())
					{
						$str .= "<td>".$arrResult["nb_action"]."</td>";
					}					
					
					while($arrResult = $rsResult->fetch())
					{
						$str .= "<td>".$arrResult["nb_action"]."</td>";
					}

				}
				$str .= "</tr>";
			}
			$str .= "</table>";
				
			include_once('exportTab.php');				
											
			return $str;
		}				
	 
		function GetStats($_idIntervenant,$_idTicket,$_jour,$_sujet,$_statut,$_datefin,$_dossier,$_idbeneficiaire,$_idDemandeur,$_resolution_en_ligne,$type_action,$_choix){
			$nom_prenom_intervenant = "";
			$nom_prenom_beneficiaire = "";
			$nom_prenom_demandeur = "";
			$numero_ticket = "";
		
			$idIntervenant = " And id_intervenant = " . $_idIntervenant ;
			if($_idIntervenant == "") $idIntervenant = "";
			else $nom_prenom_intervenant = $this->GetIntervenant($_idIntervenant);
			
			$idDemandeur = " And id_demandeur = " . $_idDemandeur ;
			if($_idDemandeur == "") $idDemandeur = "";
			else $nom_prenom_demandeur = $this->GetDemandeur($_idDemandeur);			

			$idBeneficiaire = " And id_beneficiaire = " . $_idbeneficiaire ;
			if($_idbeneficiaire == "") $idBeneficiaire = "";
			else $nom_prenom_beneficiaire = $this->GetBeneficiaire($_idIntervenant);			
			
			$idTicket = " And id_ticket = " . $_idTicket ;
			if($_idTicket == "") $idTicket = "";
			else $numero_ticket = $this->GetTicket($_idTicket);
			
			$jour = " And debut_action like '" . $_jour."%'" ;
			if($_jour == "") $jour = "";
			
			$datefin = " And fin_action like '" . $_datefin."%'" ;
			if($_datefin == "") $datefin = "";			
			
			$resolution_en_ligne = " And resolution_en_ligne like '" . $_resolution_en_ligne."%'" ;
			if($_resolution_en_ligne == "") $resolution_en_ligne = "";			

			$sujet = " And sujet like '" . $macz = str_replace("'", "''", $_sujet)."%'" ;
			if($_sujet == "") $sujet = "";
			
			$statut = " And statut like '" . $_statut."%'" ;
			if($_statut == "") $statut = "";			

			if($jour !="" && $datefin!=""){
				$jour = " AND jour_debut_action >='" . $_jour."'" ;
				$datefin = " And jour_fin_action < '" . $_datefin."'" ;
			}
			
			$numberDays = "";
			
			if($_jour !="" && $_datefin!=""){
				$startTimeForPourcentage = strtotime($_jour);
				$endTimeForPourcentage = strtotime($_datefin);

				$timeDiff = abs($endTimeForPourcentage - $startTimeForPourcentage);

				$numberDays = $timeDiff/86400;  // 86400 seconds in one day

				// and you might want to convert to integer
				$numberDays = intval($numberDays);	
				if($_jour == $_datefin)
					$numberDays = 1;
				//echo$startTimeForPourcentage;					
			}
			
			$str = "<table id='table_1' class='value'><tr><td>Debut</td><td>Fin</td><td>Intervenant</td><td>Ticket</td><td>Statut</td><td>Choix de dossier</td><td>Sujet</td><td>Beneficiaire</td><td>Demandeur</td><td>Resolution en ligne</td><td>Nombre d'action et nombre de ticket</td>";
			if($_idTicket != "")
				$str = "<table id='table_1' class='value'><tr><td>Debut</td><td>Fin</td><td>Intervenant</td><td>Ticket</td><td>Statut</td><td>Choix de dossier</td><td>Sujet</td><td>Beneficiaire</td><td>Demandeur</td><td>Resolution en ligne</td><td>Nombre d'action pour le ticket $numero_ticket</td>";
			
			if($_dossier == 'par_type_action'){
				$sql = "SELECT count (id_action) as nb_action,type_action FROM action where true $idIntervenant $idTicket $jour $sujet $statut $datefin $idBeneficiaire $idDemandeur $resolution_en_ligne group by type_action";

				//echo$sql;
				$poucentage = "";
				
				$rs=$this->cnx->query($sql);
				$str .= "<td>Type d'action</td></tr>";
				while($arr = $rs->fetch())
				{
					if($_jour != "" && $_datefin!="")$poucentage = (($arr['nb_action']/$numberDays)*100);				
					$str.= "<tr><td>$_jour</td><td>$_datefin</td><td>$nom_prenom_intervenant</td><td>$numero_ticket</td><td>$_statut</td><td>$_dossier</td><td>$_sujet</td><td>$nom_prenom_beneficiaire</td><td>$nom_prenom_demandeur</td><td>$_resolution_en_ligne</td><td>".$arr['nb_action']."</td><td>".$arr['type_action']."</td><tr/>";
				}			
			}
			
			if($_dossier == 'par_statut'){
				$sql = "SELECT count(distinct id_ticket) as nb_action,statut FROM action where true $idIntervenant $idTicket $jour $sujet $statut $datefin $idBeneficiaire $idDemandeur $resolution_en_ligne group by statut";			
						
				$rs=$this->cnx->query($sql);
				$str .= "<td>Statut</td></tr>";
				while($arr = $rs->fetch())
				{
					$str.= "<tr><td>$_jour</td><td>$_datefin</td><td>$nom_prenom_intervenant</td><td>$numero_ticket</td><td>$_statut</td><td>$_dossier</td><td>$_sujet</td><td>$nom_prenom_beneficiaire</td><td>$nom_prenom_demandeur</td><td>$_resolution_en_ligne</td><td>".$arr['nb_action']."</td><td>".$arr['statut']."</td><tr/>";
				}	
			}			
			
			if($_dossier == 'par_sujet'){
				$sql = "SELECT count(distinct id_ticket) as nb_action,sujet FROM action where true $idIntervenant $idTicket $jour $sujet $statut $datefin $idBeneficiaire $idDemandeur $resolution_en_ligne group by sujet";			
				
				$rs=$this->cnx->query($sql);
				$str .= "<td>Sujet</td></tr>";
				while($arr = $rs->fetch())
				{
					$str.= "<tr><td>$_jour</td><td>$_datefin</td><td>$nom_prenom_intervenant</td><td>$numero_ticket</td><td>$_statut</td><td>$_dossier</td><td>$_sujet</td><td>$nom_prenom_beneficiaire</td><td>$nom_prenom_demandeur</td><td>$_resolution_en_ligne</td><td>".$arr['nb_action']."</td><td>".$arr['sujet']."</td><tr/>";
				}
			}
			
			if($_choix == "info"){
				/*$sql = "SELECT (intervenant.nom_prenom) as nom_prenom_intervenant,action.sujet,action.debut_action,action.fin_action,(action.resolution_en_ligne) as action_resolution_en_ligne,";
				$sql .= "(action.type_action) as action_type_action,(beneficiaire.nom_prenom) as nom_prenom_beneficiaire,action.statut,(demandeur.nom_prenom) as nom_prenom_demandeur,ticket.numero";
				$sql .= " FROM intervenant inner join action USING (id_intervenant)";
				$sql .= " inner join beneficiaire  USING (id_beneficiaire)";
				$sql .= " inner join demandeur  USING (id_demandeur)";
				$sql .= " inner join ticket  USING (id_ticket) WHERE true $idIntervenant $idDemandeur $idBeneficiaire $idTicket $jour $sujet $statut $datefin $resolution_en_ligne";						*/
			
				$sql = "SELECT (intervenant.nom_prenom) as nom_prenom_intervenant,action.sujet,action.debut_action,action.fin_action,(action.resolution_en_ligne) as action_resolution_en_ligne,";
				$sql .= "(information.description_courte) as information_description_courte,(label_action.libelle) as label_action_libelle,";
				$sql .= "(action.type_action) as action_type_action,(beneficiaire.nom_prenom) as nom_prenom_beneficiaire,action.statut,(demandeur.nom_prenom) as nom_prenom_demandeur,ticket.numero";
				$sql .= " FROM intervenant inner join action USING (id_intervenant)";
				$sql .= " inner join beneficiaire  USING (id_beneficiaire)";
				$sql .= " inner join demandeur  USING (id_demandeur)";
				$sql .= " inner join information  USING (id_info)";				
				$sql .= " inner join label_action  USING (id_label_action)";
				$sql .= " inner join ticket  USING (id_ticket) WHERE true $idIntervenant $idDemandeur $idBeneficiaire $idTicket $jour $sujet $statut $datefin $resolution_en_ligne";			
				
				//echo$sql;
				
				$str.= "<tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><tr/>";
				
				$rs=$this->cnx->query($sql);
				while($arr = $rs->fetch())
				{
					$str.= "<tr><td>".$arr['debut_action']."</td><td>".$arr['fin_action']."</td>";
					$str.= "<td>".$arr['nom_prenom_intervenant']."</td><td>".$arr['numero']."</td>";
					$str.= "<td>".$arr['statut']."</td><td>$_dossier</td><td>".$arr['sujet']."</td>";
					$str.="<td>".$arr['nom_prenom_beneficiaire']."</td><td>".$arr['nom_prenom_demandeur']."</td>";
					$str.="<td>$_resolution_en_ligne</td><td>néant</td><td>".$arr['action_type_action']."</td><tr/>";
				}				
			}
			
			$str .= "</table>";	

			include_once('exportTab.php');
			
            return $str;  
			
		}
		
        function GetNbTycketByActionType($_idIntervenant,$_jour)
		{
		
		$idIntervenant = " And idIntervenant = " . $_idIntervenant ;
		if($_idIntervenant == "") $idIntervenant = "";
		
		$jour = " And debut_action like '" . $_jour."%'" ;
		if($_jour == "") $jour = "";
		
		$sql = "SELECT count (id_action) as nb_action, type_action FROM action where true $idIntervenant $jour group by type_action";
		
                $rs=$this->cnx->query($sql);
                $str = "<table id='table_1' class='value'>";
                    while($arr = $rs->fetch())
                    {
                        $str.= "<tr><td>".$arr['nb_action']."</td><td>".$arr['type_action']."</td><tr/>";
                    }

                $str .= "</table>";
				
		include_once('exportTab.php');				
				
            return $str;      
		}
        
        function GetNbTycketSujet($idTicket,$sujet,$jour)
	{
            //nbre ticket par sujet
			
		$sql = "SELECT count (id_ticket) as nbticket, sujet FROM action WHERE id_ticket = ".$idTicket." AND sujet = '".$sujet."' AND debut_action = '".$jour."' group by sujet";
				  
                $rs=$this->cnx->query($sql);
                $str = "<table id='table_1' class='value'>";
                    while($arr = $rs->fetch())
                    {
                        $str.= "<tr><td>".$arr['nbticket']."</td><td>".$arr['sujet']."</td><tr/>";
                    }

                $str .= "</table>";
				
			include_once('exportTab.php');				
				
            return $str;
        }
        
        function GetNbTycketTech($idTicket,$idIntervenant,$jour)
	{
            //nbre ticket par tech
		$sql = "SELECT count (id_ticket) as nbticket, sujet FROM action WHERE id_ticket = ".$idTicket." AND id_intervenant = ".$idIntervenant." AND debut_action = '".$jour."' group by id_intervenant";
				  
                $rs=$this->cnx->query($sql);
                $str = "<table id='table_1' class='value'>";
                    while($arr = $rs->fetch())
                    {
                        $str.= "<tr><td>".$arr['nbticket']."</td><td>".$arr['sujet']."</td><tr/>";
                    }

                $str .= "</table>";
				
			include_once('exportTab.php');				
								
            return $str;
	}  
        
        function GetNbTycketByStatut($statut,$jour)
	{
            //nbre ticket par selon statut
		$sql = "SELECT count (id_ticket) as nbticket, sujet FROM action WHERE statut = '".$statut."' AND debut_action = '".$jour."' group by id_intervenant";
				  
                $rs=$this->cnx->query($sql);
                $str = "<table id='table_1' class='value'>";
                    while($arr = $rs->fetch())
                    {
                        $str.= "<tr><td>".$arr['nbticket']."</td><td>".$arr['sujet']."</td><tr/>";
                    }

                $str .= "</table>";
				
			include_once('exportTab.php');				
								
				
            return $str;
	}          
        
        function GetNbTycketByResolutionEnLigneEtStatut($statut,$resolution,$jour)
	{
            //nbre ticket selon statut et resolution
		$sql = "SELECT count (id_ticket) as nbticket, statut FROM action WHERE statut = '".$statut."' AND resolution_en_ligne = '".$resolution."' AND debut_action = '".$jour."' group by statut";
				  
                $rs=$this->cnx->query($sql);
                $str = "<table id='table_1' class='value'>";
                    while($arr = $rs->fetch())
                    {
                        $str.= "<tr><td>".$arr['nbticket']."</td><td>".$arr['statut']."</td><tr/>";
                    }

                $str .= "</table>";
				
			include_once('exportTab.php');				
								
				
            return $str;
	}        
        
        function GetNbTycketTechStatut($idTicket,$idIntervenant,$jour,$statut)
	{
            //nbre ticket par tech par statut
		$sql = "SELECT count (id_ticket) as nbticket, sujet FROM action WHERE id_ticket = ".$idTicket." AND id_intervenant = ".$idIntervenant." AND debut_action = '".$jour."'  AND statut = '".$statut."' group by id_intervenant";
				  
                $rs=$this->cnx->query($sql);
                $str = "<table id='table_1' class='value'>";
                    while($arr = $rs->fetch())
                    {
                        $str.= "<tr><td>".$arr['nbticket']."</td><td>".$arr['sujet']."</td><tr/>";
                    }

                $str .= "</table>";
				
			include_once('exportTab.php');				
												
            return $str;
	}          
        /**
         * 
         * End Add by Mika RAHELISON
         * **/        
        
	function getLstDossier()
	{
		$sql = "SELECT p_affectation.id_dossier,p_dossier.num_dossier FROM p_affectation LEFT JOIN p_dossier ON p_affectation.id_dossier = p_dossier.id_dossier WHERE id_pers=" .$_SESSION['id']. " AND id_etat = 0 ORDER BY num_dossier ASC";
		$rs=$this->cnx->query($sql);
		$str="";
		//return $sql;
		while($arr = $rs->fetch())
		{
			$str .= '<option value="'.$arr['id_dossier'].'">'.$arr['num_dossier'].'</option>';
		}
		
		return $str;
	}
	function getLstDosdsier()
	{
		$sql = "select id_dossier, num_dossier from p_dossier  where id_etat <> 4 order by num_dossier";
		$rs=$this->cnx->query($sql);
		$str="";
		while($arr = $rs->fetch())
		{
			$str .= '<option value="'.$arr['id_dossier'].'">'.$arr['num_dossier'].'</option>';
		}
		
		return $str;
	}
	function getLotClient($idDossier)
	{
		$sql = "select id_lotclient, libelle from p_lot_client WHERE id_dossier = $idDossier AND id_etat <> 2 order by id_lotclient DESC";
		$rs=$this->cnx->query($sql);
		$str='<option value=""> </option>';
		while($arr = $rs->fetch())
		{
			$str .= '<option value="'.$arr['id_lotclient'].'">'.$arr['libelle'].'</option>';
		}
		return $str;
	}
	function getSuiviDossier($pDate, $pEtape, $pMat, $pTypeEtape, $Dossier)
	{
		$date = " And p_ldt.date_deb_ldt = '" . $pDate . "'";
		if($pDate == "") $date = "";
		
		$matricule = " And p_ldt.id_pers = " . $pMat ;
		if($pMat == "") $matricule = "";
		
		$typeEtape = " And p_ldt.id_type_ldt = " . $pTypeEtape ;
		if($pTypeEtape == "") $typeEtape = "";
		
		$numDossier = " And p_ldt.id_dossier = " . $Dossier ;
		if($Dossier == "") $numDossier = "";
		
		$etape = " And p_ldt.id_etape = " . $pEtape ;
		if($pEtape == "") $etape = "";

		$filtre = $date.$matricule.$typeEtape.$numDossier.$etape;
		
		$sql = "SELECT p_ldt.date_deb_ldt, r_personnel.appelation, r_personnel.matricule, p_dossier.num_dossier,p_etape.libelle as etapLibelle, p_ldt.h_deb, p_ldt.h_fin,r_personnel.departement, p_type_ldt.libelle  FROM p_ldt 
				LEFT JOIN p_dossier ON p_ldt.id_dossier=p_dossier.id_dossier 
				LEFT JOIN p_lot_client ON p_ldt.id_lotclient=p_lot_client.id_lotclient  
				LEFT JOIN p_lien_oper_dossier ON p_ldt.id_etape=p_lien_oper_dossier.id_lien 
				LEFT JOIN p_etape ON p_lien_oper_dossier.id_oper=p_etape.id_etape
				LEFT JOIN p_type_ldt on p_type_ldt.id_type_ldt = p_ldt.id_type_ldt
				LEFT JOIN r_personnel ON r_personnel.id_pers=p_ldt.id_pers 
				where 1=1".$filtre;
				
		//return $sql;
		$rs=$this->cnx->query($sql);
      
		$str = "<table class='tbLate'>";
		$ii = 0; 
		
		$diff;
		$somme="0:0:0";

		foreach($rs as $row)
		{
			if ($ii == 3) $ii = 0;
			if ($row['h_deb'] == "" || $row['h_fin'] == "") continue;
			$diff = $this->hDiff($row['h_deb'], $row['h_fin'], "");
			$somme = $this->hDiff($somme, $diff, "+");

			$cl = 'classe'.$ii;
			$ii++;
			$str .= "<tr class = $cl>";
			$str .= "<td>".$row['h_deb']."</td>";
			$str .= "<td>".$row['h_fin']."</td>";
			$str .= "<td>".$diff."</td>";
			$str .= "<td>".$somme."</td>";
			$str .= "</tr>";
		}
		$str .= "</table>";
		return $str;
	}

    function getLate($date,$dpt)
    {
      
      $qdate="";
      $qdpt="";
      if ($date != "")
      {
        $qdate=" AND r_retard.date_retard='" .$date. "'"; 
      }
      if ($dpt != "")
      {
		$qdpt=" AND r_retard.id_pers = r_personnel.id_pers AND r_personnel.departement = '".$dpt."' ";		
      }
      $sql_Late="SELECT r_retard.id_pers as matricule, r_personnel.nom as nom, r_personnel.prenom as prenom, r_retard.heure_entree_theo as heure_entree_theo , r_retard.heure_entree_reel as heure_entree_reel, r_retard.duree_retard as duree_retard, r_retard.date_retard as date_retard FROM r_personnel, r_retard WHERE r_personnel.id_pers = r_retard.id_pers";
      $sql_Late .=$qdate.$qdpt;
      $sql_Late .=" ORDER BY r_retard.id_retard ";
	  
      $rs_Late=$this->cnx->query($sql_Late);
      
      $str = "<table class='tbLate'><thead><tr><th>Matricule</th>
			<th>Nom</th>
			<th>Prenom</th>
			<th>Heure entree theorique</th>
			<th>Heure arrivee</th>
			<th>Duree retard</th>
			<th>Date retard</th></tr></thead>";
		$ii = 0; 
      
     
		foreach($rs_Late as $row)
		{
			if ($ii == 3) $ii = 0;

				$cl = 'classe'.$ii;
				$ii++;
				$str .= "<tr class = $cl>";
				$str .= "<td>".$row['matricule']."</td>";
				$str .= "<td>".$row['nom']."</td>";
				$str .= "<td>".$row['prenom']."</td>";
				$str .= "<td>".$row['heure_entree_theo']."</td>";
				$str .= "<td>".$row['heure_entree_reel']."</td>";
				$str .= "<td>".$row['duree_retard']."</td>";
				$str .= "<td>".$row['date_retard']."</td>";
				$str .= "</tr>";
		  
		}
		$str .= "</table>";
		return $str;
    }
		
	function getDateAbs()
    {
      $sql = "SELECT distinct(date_abs) FROM r_absence  ORDER BY date_abs ASC";
      $rs=$this->cnx->query($sql);
      $str="";
      while($arr = $rs->fetch())
      {
        $str .= '<option value="'.$arr['date_abs'].'">'.$arr['date_abs'].'</option>';
      }
      return $str;
    } 
    
    
    function getListAbsence($date)
    {
      if ($date=="")
        $sql_abs= "select id_abs, r_absence.id_pers,r_personnel.nom ,r_personnel.prenom, date_abs,motif from r_absence ,r_personnel where r_absence.id_pers=r_personnel.id_pers ";
      else
      {
        $sql_abs= "select id_abs, r_absence.id_pers,r_personnel.nom ,r_personnel.prenom , date_abs,motif from r_absence,r_personnel where r_absence.id_pers=r_personnel.id_pers and date_abs='".$date."'";
      }
      $ii = 0;         
             
      $rs=$this->cnx->query($sql_abs);
      $str= "<table class='tbAbsence'>
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
      while($arr = $rs->fetch())    
      {    
         if ($ii == 3) $ii = 0;
        
         $cl = 'classe'.$ii;
         $ii++;
         $str .= "<tr class= $cl>";
         $str .="<td>".$arr['id_abs']."</td>"; 
         $str .= "<td>".$arr['id_pers']."</td>";
         $str .= "<td>".$arr['nom']."</td>";
         $str .= "<td>".$arr['prenom']."</td>";
         $str .= "<td>".$arr['date_abs']."</td>";
         $str .= "<td>".$arr['motif']."</td>";
         $str .="</tr>";      
      }
      $str .="</table>";
      return $str;
    }
			
		// Retourne les lignes de temps
		// $p_type_get in ('tous', 'util', 'proj', 'appli')
		function get_ldt($p_type_get, $p_param, $p_deb, $p_fin)
		{
			
			$sql = "select ldt.id, util.login, ldt.id_appli, ldt.debut, ldt.fin, ldt.commentaires, typ.designation";
			$sql = $sql." from ldt, utilisateurs as util, types_ldt as typ";
			$sql = $sql." where ldt.id_util=util.id and ldt.id_type=typ.id";
			
			switch ($p_type_get)
			{
				case 'util':
					$sql = $sql." and util.login='$p_param'";
					break;
				case 'proj':
					$sql = $sql." and ldt.id_appli in (select appli.id from applications as appli, projets as proj";
					$sql = $sql." where appli.id_proj=proj.id and proj.designation='$p_param')";
					break;
				case 'appli':
					$sql = $sql." and ldt.id_appli=(select id from applications where designation='$p_param')";
					break;
			}
			if ($p_deb)
			{
				$sql = $sql." and ldt.debut > $p_deb";
			}
			if ($p_fin)
			{
				$sql = $sql." and ldt.debut < $p_deb + 1";
			}
			$rs = $cnx->Execute($sql);
			$res = $rs->GetArray();
			$rs->Close();
			
			return $res;
		}
		
		function insertLDT($P, $O, $S, $C, $Q, $E)
		{
			$d= date("Y/m/d", time());
			$h= date("H:i:s", time());
			$U = $_SESSION['id'];
			$sql = "INSERT INTO p_ldt (d_date, h_deb, projet, operation, statut, id_util, commentaire, quantite, nbre_erreur) values ('$d','$h','$P','$O', '$S', $U, '$C', '$Q', '$E')";
			if ($this->cnx->exec($sql))
			{
				return 1;
			}
			return 0;
		}

		function getLDG()
		{
			$sql = "SELECT distinct(num_dossier), id_dossier FROM p_dossier where id_etat <> 4 order by num_dossier";
			$rs=$this->cnx->query($sql);
			$str='<option value="_"> </option>';
			while($arr = $rs->fetch())
			{
				$str .= '<option value="'.$arr['id_dossier'].'">'.$arr['num_dossier'].'</option>';
			}
			return $str;
		}
		
		function getNumDossier($idDossier)
		{
			$sql = "SELECT num_dossier FROM p_dossier where id_dossier=$idDossier";
			$rs=$this->cnx->query($sql);
			while($arr = $rs->fetch()) return $arr['num_dossier'];
		}
		
		function getDepartement()
		{
			$sql = "SELECT libelle, id FROM r_departement";
			$rs=$this->cnx->query($sql);
			$str='<option value="_"> </option>';
			while($arr = $rs->fetch())
			{
				$str .= '<option value="'.$arr['id'].'">'.$arr['libelle'].'</option>';
			}
			return $str;
		}
		
		function getEtats()
		{
			$sql = "SELECT distinct(id_etat), libelle FROM p_etat";
			$rs=$this->cnx->query($sql);
			$str='<option value="_"> </option>';
			while($arr = $rs->fetch())
			{
				$str .= '<option value="'.$arr['id_etat'].'">'.$arr['libelle'].'</option>';
			}
			return $str;
		}
		
		function getTypeLdt()
		{
			$sql = "SELECT id_type_ldt, libelle FROM p_type_ldt";
			$rs=$this->cnx->query($sql);
			$str="";
			while($arr = $rs->fetch())
			{
				$str .= '<option value="'.$arr['id_type_ldt'].'">'.$arr['libelle'].'</option>';
			}
			echo $str;
		}
		function getTaches()
		{
			$sql = "SELECT distinct(libelle), id_etape FROM p_etape";
			$rs=$this->cnx->query($sql);
			$str='<option value="_"> </option>';
			while($arr = $rs->fetch())
			{
				$str .= '<option value="'.$arr['id_etape'].'">'.$arr['libelle'].'</option>';
			}
			return $str;
		}
		function identification($log, $mdp)
		{
			$sql = "select nom, prenom , id_pers, id_droit from r_personnel where matricule = '$log' and mdp = '$mdp'";

			$rs=$this->cnx->query($sql);
			while($arr = $rs->fetch())
			{
				$_SESSION['pseudo'] = $arr['nom']. "  ".$arr['prenom'];
				$_SESSION['id'] 	= $arr['id_pers'];
				$_SESSION['id_droit'] 	= $arr['id_droit'];
				
				$P = 'connection';
				$O = 'connection sur GPAO WEB';
				$S = 'OK';
				
				$d= date("Y/m/d", time());
				$h= date("H:i:s", time());
				$ip = $_SERVER['REMOTE_ADDR'];
				
				/*
					regarder si pointage OK sinon pointage
				*/
				
				
				$sqlPointage = "select pdate, source from r_pointage where id_util = ".$arr['id_pers']." AND source like 'IN%' order by pdate desc limit 1";
				
				$rs1=$this->cnx->query($sqlPointage);
				
				
				while($arr1 = $rs1->fetch())
				{
					if ($arr1['pdate']  != $d)
					{	
						if($arr['id_pers'] == '177') return 1;
						session_destroy();
						return "Veuillez vous connecter a la pointage BIO";
						$ip = $arr1['source'];						
					}
					//return 1;		
					break;					
				}
				
				
				$sql = "INSERT INTO r_pointage (id_util, entree, pdate, source) VALUES (".$arr['id_pers'].", '$h', '$d', '$ip')";
				if ($this->cnx->exec($sql))
				{
					return 1;
				}
				
			}
			session_destroy();
			return "Login ou mdp incorrecte.";
		}
		function pointage($id_pers, $pt, $h)
		{
			include_once 'cnx1.4.php' ;
			$cc = new Cnxx();
			$cc->pointage($id_pers, $pt, $h);
			
			
			$d= date("Y/m/d", time());
			//$h= date("H:i:s", time());
			$ip = $_SERVER['REMOTE_ADDR'].'-'.$_SESSION['id'];
				
			$sql = "INSERT INTO r_pointage (id_util, entree, pdate, source, sortie) VALUES (".$id_pers.", '$h', '$d', '$pt', '$ip')";
			//return $sql;
			if ($this->cnx->exec($sql))
			{
				return 1;
			}
			
		}
		
		function Deconnect()
		{
			$d= date("Y/m/d", time());
			$h= date("H:i:s", time());

			$sqlPointage = "select pdate, source from r_pointage where pdate= '$d' AND id_util = ".$_SESSION['id']." AND source like 'IN%' order by pdate desc limit 1";
			$rs1=$this->cnx->query($sqlPointage);
			
			while($arr1 = $rs1->fetch())
			{
				$lettre = $arr1['source'];
				$ip = str_replace("IN", "OUT", $lettre);
				$sql = "INSERT INTO r_pointage (id_util, entree, pdate, source) VALUES (".$_SESSION['id'].", '$h', '$d', '$ip')";
				if ($this->cnx->exec($sql))
				{
					return true;
				}
				break;					
			}
			return false;
		}
		
		function getDatePt()
		{
			$sql = "SELECT distinct(pdate) FROM r_pointage   ORDER BY pdate DESC";
			$rs=$this->cnx->query($sql);
			$str="";
			while($arr = $rs->fetch())
			{
				$str .= '<option value="'.$arr['pdate'].'">'.$arr['pdate'].'</option>';
			}
			return $str;
		}
		function getMoisPt()
		{
			$sql = "SELECT distinct(pdate) as mois FROM r_pointage order by pdate desc";
			$rs=$this->cnx->query($sql);
			$str="";
			$arrayDate = array();
			while($arr = $rs->fetch())
			{
				$currMois = substr($arr['mois'], 0, -3);
				if (!array_key_exists($currMois , $arrayDate))
				{
					echo $currMois;
					$arrayDate[$currMois] = '';
					$str .= '<option value="'.$currMois.'">'.$currMois.'</option>';
				}
			}
			//echo "-------".$str;exit();
			return $str;
		}

		function lstPointage($datePt, $matriPt, $typePoint, $departement)
		{
			$sql;
			$qDate="";
			$qMatri="";
			$qType="";
			
			
			if ($matriPt != "")
			{
				$qMatri = " AND id_util = ".$matriPt;
			}
			if ($datePt != "")
			{
				$qDate = " AND pdate = '".$datePt."'";
			}
			
			if ($typePoint != "")
			{
				$qType = " AND source = '".$typePoint."'";
				if (strstr($typePoint, 'IN_ARO')) $qType = " AND source IN ('IN_ARO', 'IN_ARO1')";
				if (strstr($typePoint, 'OUT_ARO')) $qType = " AND source IN ('OUT_ARO', 'OUT_ARO1')";
			}
			else 
			{
				$qType = " AND source IN ('IN', 'OUT','IN_ARO', 'OUT_ARO','IN_ARO1', 'OUT_ARO1', 'IN_RDJ', 'OUT_RDJ') ";
			}
			if ($departement != "")
			{
				$sql = "SELECT r_personnel.matricule, r_pointage.pdate, r_pointage.entree, r_pointage.sortie, r_pointage.id_pointage, r_personnel.nom, r_personnel.prenom, r_pointage.source FROM r_pointage 
					INNER JOIN r_personnel ON  r_pointage.id_util = r_personnel.id_pers 
					LEFT JOIN r_affectation ON r_affectation.id_pers = r_personnel.id_pers 
					LEFT JOIN r_departement ON r_affectation.id_departement = r_departement.id  WHERE 1=1  AND r_departement.id = '".$departement."'";
			}
			else $sql = "SELECT r_personnel.matricule, r_pointage.pdate, r_pointage.entree, r_pointage.sortie, r_pointage.id_pointage, r_personnel.nom, r_personnel.prenom, r_pointage.source FROM r_pointage 
			INNER JOIN r_personnel ON  r_pointage.id_util = r_personnel.id_pers WHERE 1=1 ";
			
			$sql .= $qType;
			$sql .= $qDate.$qMatri;

			$sql .= " ORDER BY pdate, entree DESC";

			//return $sql;
			$rs=$this->cnx->query($sql);
			
			$ii = 0;
			$str = "<table  id='listePointage'><thead><tr><th>Nom</th>
			<th>Prenom</th>
			<th>Matricule</th>
			<th>Date</th>
			<th>entree</th>
			<th>Pointeuse</th></tr></thead>";

			while($arr = $rs->fetch())
			{
				if ($ii == 3) $ii = 0;
				
				$cl = 'classe'.$ii;
				$ii++;
				$str .= "<tr class = $cl>";
				$str .= "<td>".$arr['nom']."</td>";
				$str .= "<td>".$arr['prenom']."</td>";
				$str .= "<td>".$arr['matricule']."</td>";
				$str .= "<td>".$arr['pdate']."</td>";
				$str .= "<td>".$arr['entree']."</td>";
				$str .= "<td>".$arr['source']."</td>";
				$str .= "</tr>";
			}
			$str .= "</table>";
			return $str;
		}
		function lstPointagePlat($datePt, $matriPt, $typePoint, $departement)
		{
			$qDate="";
			$qMatri="";
			$qType="";
			
			
			if ($matriPt != "")
			{
				$qMatri = " AND id_util = ".$matriPt;
			}
			if ($datePt != "")
			{
				$qDate = " AND pdate = '".$datePt."'";
			}
			if ($typePoint != "")
			{
				$qType = " AND source = '".$typePoint."'";
			}
			else 
			{
				$qType = "";
			}
			if ($departement != "")
			{
				$qType .= " AND Departement = '".$departement."'";
			}
			
			$sql = "SELECT id, pdate, id_util, in1, out1, in2, out2, valide, commentaire, err_type FROM r_pointage_jour WHERE id <> 1 ";
			
			$sql .= $qType;
			$sql .= $qDate.$qMatri;
			
			$sql .= " ORDER BY pdate ASC";

			$rs=$this->cnx->query($sql);
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

			while($arr = $rs->fetch())
			{
				if ($ii == 3) $ii = 0;
				
				$cl = 'classe'.$ii;
				$ii++;
				$str .= "<tr class = $cl>";
				$str .= "<td>".$arr['id']."</td>";
				$str .= "<td>".$arr['pdate']."</td>";
				$str .= "<td>".$arr['id_util']."</td>";
				$str .= "<td>".$arr['in1']."</td>";
				$str .= "<td>".$arr['out1']."</td>";
				$str .= "<td>".$arr['in2']."</td>";
				$str .= "<td>".$arr['out2']."</td>";
				$str .= "<td>".$arr['valide']."</td>";
				$str .= "<td>".$arr['commentaire']."</td>";
				$str .= "<td>".$arr['err_type']."</td>";
				$str .= "</tr>";
			}
			$str .= "</table>";
			return $str;
		}

		//�������������������������������������
		
		function util_existe($p_login)
		{
			$sql = "select matricule from personnel where matricule = '$p_login'";

			$rs=$this->cnx->query($sql);
			$arr = $rs->fetch();
			return $arr['matricule'];
		}
		
		function sec2hms ($sec, $padHours = false) 
	  {

			// start with a blank string
			$hms = "";
			
			// do the hours first: there are 3600 seconds in an hour, so if we divide
			// the total number of seconds by 3600 and throw away the remainder, we're
			// left with the number of hours in those seconds
			$hours = intval(intval($sec) / 3600); 

			// add hours to $hms (with a leading 0 if asked for)
			$hms .= ($padHours) 
				  ? str_pad($hours, 2, "0", STR_PAD_LEFT). ":"
				  : $hours. ":";
			
			// dividing the total seconds by 60 will give us the number of minutes
			// in total, but we're interested in *minutes past the hour* and to get
			// this, we have to divide by 60 again and then use the remainder
			$minutes = intval(($sec / 60) % 60); 

			// add minutes to $hms (with a leading 0 if needed)
			$hms .= str_pad($minutes, 2, "0", STR_PAD_LEFT). ":";

			// seconds past the minute are found by dividing the total number of seconds
			// by 60 and using the remainder
			$seconds = intval($sec % 60); 

			// add seconds to $hms (with a leading 0 if needed)
			$hms .= str_pad($seconds, 2, "0", STR_PAD_LEFT);

			// done!
			return $hms;		
	  }	

	  //MODIFICATION ET FONCTION MAHASETRA

	  function GetDateMaha(){
		  	$sql = "SELECT distinct date_arrivee , CAST(date_arrivee AS date) AS indexage FROM helpdesk ORDER BY CAST(date_arrivee AS date) DESC";
		  	
				
	        $rs=$this->cnx->query($sql);
	        $str = "";
			
			if($rs != null){
				while($arr = $rs->fetch())
				{
					$str .= '<option value="'.$arr['date_arrivee'].'">'.$arr['date_arrivee'].'</option>';
				}
			}
			else{

				$sql = "SELECT distinct(date_arrivee) FROM helpdesk ORDER BY date_arrivee DESC";
				 $rs=$this->cnx->query($sql);
		        $str = "";
				
				if($rs != null){
					while($arr = $rs->fetch())
					{
						$str .= '<option value="'.$arr['date_arrivee'].'">'.$arr['date_arrivee'].'</option>';
					}
				}
			}
			
			return $str; 
	  }		
	  function GetClientMaha(){
	  	$sql = "SELECT distinct(client) FROM helpdesk ORDER BY client DESC";
			//$sql = "SELECT to_char(jour_debut_action,'dd/MM/yyyy') as test FROM action ORDER BY test;";
			//echo$sql;
			
            $rs=$this->cnx->query($sql);
            $str = "";
			
			while($arr = $rs->fetch())
			{
				$str .= '<option value="'.$arr['client'].'">'.$arr['client'].'</option>';
			}
		
		return $str; 
	  }
	  function GetIntervenantMaha(){
	  	$sql = "SELECT distinct(intervenant) FROM helpdesk ORDER BY intervenant DESC";
			//$sql = "SELECT to_char(jour_debut_action,'dd/MM/yyyy') as test FROM action ORDER BY test;";
			//echo$sql;
			
            $rs=$this->cnx->query($sql);
            $str = "";
			
			while($arr = $rs->fetch())
			{
				$str .= '<option value="'.$arr['intervenant'].'">'.$arr['intervenant'].'</option>';
			}
		
		return $str; 
	  }
	  function GetTicketMaha(){
	  	$sql = "SELECT distinct(numero_ticket) FROM helpdesk ORDER BY numero_ticket DESC";
			//$sql = "SELECT to_char(jour_debut_action,'dd/MM/yyyy') as test FROM action ORDER BY test;";
			//echo$sql;
			
            $rs=$this->cnx->query($sql);
            $str = "";
			
			while($arr = $rs->fetch())
			{
				$str .= '<option value="'.$arr['numero_ticket'].'">'.$arr['numero_ticket'].'</option>';
			}
		
		return $str; 
	  }
	  function GetPoleMaha(){
	  	$sql = "SELECT distinct(pole_actuel) FROM helpdesk ORDER BY pole_actuel DESC";
			//$sql = "SELECT to_char(jour_debut_action,'dd/MM/yyyy') as test FROM action ORDER BY test;";
			//echo$sql;
			
            $rs=$this->cnx->query($sql);
            $str = "";
			
			while($arr = $rs->fetch())
			{
				$str .= '<option value="'.$arr['pole_actuel'].'">'.$arr['pole_actuel'].'</option>';
			}
		
		return $str; 
	  }


	  function GetDateMahaSup(){
	  	$sql = "SELECT distinct date_arrivee , CAST(date_arrivee AS date) AS indexage FROM supervision ORDER BY CAST(date_arrivee AS date) DESC";
			//$sql = "SELECT to_char(jour_debut_action,'dd/MM/yyyy') as test FROM action ORDER BY test;";
			//echo$sql;
			
            $rs=$this->cnx->query($sql);
	        $str = "";
			
			if($rs != null){
				while($arr = $rs->fetch())
				{
					$str .= '<option value="'.$arr['date_arrivee'].'">'.$arr['date_arrivee'].'</option>';
				}
			}
			else{
				//$str .= '<option value=test>test</option>';
				
				$sql = "SELECT distinct(date_arrivee) FROM supervision ORDER BY date_arrivee DESC";
				$rs=$this->cnx->query($sql);
		        $str = "";
				
				if($rs != null){
					while($arr = $rs->fetch())
					{
						$str .= '<option value="'.$arr['date_arrivee'].'">'.$arr['date_arrivee'].'</option>';
					}
				}
			}
			
		
		return $str; 
	  }	
	
	  function GetClientMahaSup(){
	  	$sql = "SELECT distinct(client) FROM supervision ORDER BY client DESC";
			//$sql = "SELECT to_char(jour_debut_action,'dd/MM/yyyy') as test FROM action ORDER BY test;";
			//echo$sql;
			
            $rs=$this->cnx->query($sql);
            $str = "";
			
			while($arr = $rs->fetch())
			{
				$str .= '<option value="'.$arr['client'].'">'.$arr['client'].'</option>';
			}
		
		return $str; 
	  }
	  function GetIntervenantMahaSup(){
	  	$sql = "SELECT distinct(intervenant) FROM supervision ORDER BY intervenant DESC";
			//$sql = "SELECT to_char(jour_debut_action,'dd/MM/yyyy') as test FROM action ORDER BY test;";
			//echo$sql;
			
            $rs=$this->cnx->query($sql);
            $str = "";
			
			while($arr = $rs->fetch())
			{
				$str .= '<option value="'.$arr['intervenant'].'">'.$arr['intervenant'].'</option>';
			}
		
		return $str; 
	  }
	  function GetTicketMahaSup(){
	  	$sql = "SELECT distinct(numero_ticket) FROM supervision ORDER BY numero_ticket DESC";
			//$sql = "SELECT to_char(jour_debut_action,'dd/MM/yyyy') as test FROM action ORDER BY test;";
			//echo$sql;
			
            $rs=$this->cnx->query($sql);
            $str = "";
			
			while($arr = $rs->fetch())
			{
				$str .= '<option value="'.$arr['numero_ticket'].'">'.$arr['numero_ticket'].'</option>';
			}
		
		return $str; 
	  }
	  function GetEtatMahaSup(){
	  	$sql = "SELECT distinct(etat) FROM supervision ORDER BY etat DESC";
			//$sql = "SELECT to_char(jour_debut_action,'dd/MM/yyyy') as test FROM action ORDER BY test;";
			//echo$sql;
			
            $rs=$this->cnx->query($sql);
            $str = "";
			
			while($arr = $rs->fetch())
			{
				$str .= '<option value="'.$arr['etat'].'">'.$arr['etat'].'</option>';
			}
		
		return $str; 
	  }



	  function RechercheMaha($_date , $_pole , $_client , $_intervenant , $_ticket){

			$requete = "SELECT * FROM helpdesk WHERE ";
			$critere_exist = false;

			if($_date != ""){
				$requete = $requete." date_arrivee = '".$_date."'";
				$critere_exist = true;
			}

			if($_pole != ""){
				if($critere_exist){
					$requete .= " AND ";
				}
				$requete = $requete." pole_actuel = '".$_pole."'";
				$critere_exist = true;

			}

			if($_client != ""){
				if($critere_exist){
					$requete .= " AND ";
				}
				$requete = $requete." client = '".$_client."'";
				$critere_exist = true;
			}

			if($_intervenant != ""){
				if($critere_exist){
					$requete .= " AND ";
				}
				$requete = $requete." intervenant = '".$_intervenant."'";
				$critere_exist = true;
			}

			if($_ticket != ""){
				if($critere_exist){
					$requete .= " AND ";
				}
				$requete = $requete." numero_ticket = '".$_ticket."'";
				$critere_exist = true;
			}

			$requete .= " ORDER BY id DESC";

			$str = "<table id='table_1' class='value'><tr><td>Date d'arriv&eacutee</td><td>Heure</td><td>Client</td><td>Demandeur</td><td>Heure de creation du ticket</td><td>Numero de ticket</td><td>Pole actuel</td><td>Intervenant</td><td COLSPAN = 3>Commentaires</td><td>Modifier</td><td>Supprimer</td></tr>";

			$res = $this->cnx->query($requete);

			if($res == null || $res == false){
				$str = "<p>Aucun resultat</p>";
			}
			else{

				while($arr = $res->fetch()){

					$sup30Min = $this->dateSuperieur30Min($arr['heure_arrivee'] , $arr['heure_creation_ticket']);
					$str .= "<tr>";

					$str .= "<td id = date_arrivee".$arr['id'].$this->ColorerChampVide_HeureInf30Minute($arr['date_arrivee'], $sup30Min).">".$arr['date_arrivee']."</td>";
					$str .= "<td id = heure_arrivee".$arr['id'].$this->ColorerChampVide_HeureInf30Minute($arr['heure_arrivee'], $sup30Min).">".$arr['heure_arrivee']."</td>";
					$str .= "<td id = client".$arr['id'].$this->ColorerChampVide_HeureInf30Minute($arr['client'], $sup30Min).">".$arr['client']."</td>";
					$str .= "<td id = demandeur".$arr['id'].$this->ColorerChampVide_HeureInf30Minute($arr['demandeur'], $sup30Min).">".$arr['demandeur']."</td>";
					$str .= "<td id = heure_creation_ticket".$arr['id'].$this->ColorerChampVide_HeureInf30Minute($arr['heure_creation_ticket'], $sup30Min).">".$arr['heure_creation_ticket']."</td>";
					$str .= "<td id = numero_ticket".$arr['id'].$this->ColorerChampVide_HeureInf30Minute($arr['numero_ticket'], $sup30Min).">".$arr['numero_ticket']."</td>";
					$str .= "<td id = pole_actuel".$arr['id'].$this->ColorerChampVide_HeureInf30Minute($arr['pole_actuel'], $sup30Min).">".$arr['pole_actuel']."</td>";
					$str .= "<td id = intervenant".$arr['id'].$this->ColorerChampVide_HeureInf30Minute($arr['intervenant'], $sup30Min).">".$arr['intervenant']."</td>";
					$str .= "<td COLSPAN = 3 id = commentaire".$arr['id'].$this->ColorerChampVide_HeureInf30Minute($arr['commentaire'], $sup30Min).">".$arr['commentaire']."</td>";
					$str .= "<td><button id = '".$arr['id']."' class = 'button'>Modifier</button></td>";

					$str .= "<td><button id = '".$arr['id']."s' class = 'button'>Supprimer</button></td>";


					$str .= "</tr>";
				}
			}
			$str .= "</table>";

			include_once('exportTab.php');
			
			$str .= $this->statistiqueHelpdesk($_date);
			
            return $str; 
		}



	  function RechercheMahaSup($_date , $_etat , $_client , $_intervenant , $_ticket){

			$requete = "SELECT * FROM supervision WHERE ";
			$critere_exist = false;

			if($_date != ""){
				$requete = $requete." date_arrivee = '".$_date."'";
				$critere_exist = true;
			}

			if($_etat != ""){
				if($critere_exist){
					$requete .= " AND ";
				}
				$requete = $requete." etat = '".$_etat."'";
				$critere_exist = true;

			}

			if($_client != ""){
				if($critere_exist){
					$requete .= " AND ";
				}
				$requete = $requete." client = '".$_client."'";
				$critere_exist = true;
			}

			if($_intervenant != ""){
				if($critere_exist){
					$requete .= " AND ";
				}
				$requete = $requete." intervenant = '".$_intervenant."'";
				$critere_exist = true;
			}

			if($_ticket != ""){
				if($critere_exist){
					$requete .= " AND ";
				}
				$requete = $requete." numero_ticket = '".$_ticket."'";
				$critere_exist = true;
			}


			$requete .= " ORDER BY id DESC";


			$str = "<table id='table_1' class='value'><tr><td>Date d'arriv&eacutee</td><td>Heure</td><td>Client</td><td>Origine</td><td>Heure de creation du ticket</td><td>Numero de ticket</td><td>Etat</td><td>Intervenant</td><td COLSPAN = 3>Commentaires</td><td>Modifier</td><td>Supprimer</td></tr>";

			$res = $this->cnx->query($requete);

			if($res == null || $res == false){
				$str = "<p>Aucun resultat</p>";
			}
			else{

				while($arr = $res->fetch()){
					
					$sup30Min = $this->dateSuperieur30Min($arr['heure_arrivee'] , $arr['heure_creation_ticket']);

					$str .= "<tr>";

					$str .= "<td id = date_arrivee".$arr['id'].$this->ColorerChampVide_HeureInf30Minute($arr['date_arrivee'] , $sup30Min).">".$arr['date_arrivee']."</td>";
					$str .= "<td id = heure_arrivee".$arr['id'].$this->ColorerChampVide_HeureInf30Minute($arr['heure_arrivee'], $sup30Min).">".$arr['heure_arrivee']."</td>";
					$str .= "<td id = client".$arr['id'].$this->ColorerChampVide_HeureInf30Minute($arr['client'], $sup30Min).">".$arr['client']."</td>";
					$str .= "<td id = origine".$arr['id'].$this->ColorerChampVide_HeureInf30Minute($arr['origine'], $sup30Min).">".$arr['origine']."</td>";
					$str .= "<td id = heure_creation_ticket".$arr['id'].$this->ColorerChampVide_HeureInf30Minute($arr['heure_creation_ticket'], $sup30Min).">".$arr['heure_creation_ticket']."</td>";
					$str .= "<td id = numero_ticket".$arr['id'].$this->ColorerChampVide_HeureInf30Minute($arr['numero_ticket'], $sup30Min).">".$arr['numero_ticket']."</td>";
					$str .= "<td id = etat".$arr['id'].$this->ColorerChampVide_HeureInf30Minute($arr['etat'], $sup30Min).">".$arr['etat']."</td>";
					$str .= "<td id = intervenant".$arr['id'].$this->ColorerChampVide_HeureInf30Minute($arr['intervenant'], $sup30Min).">".$arr['intervenant']."</td>";
					$str .= "<td COLSPAN = 3 id = commentaire".$arr['id'].$this->ColorerChampVide_HeureInf30Minute($arr['commentaire'], $sup30Min).">".$arr['commentaire']."</td>";
					$str .= "<td><button id = '".$arr['id']."' class = 'button'>Modifier</button></td>";

					$str .= "<td><button id = '".$arr['id']."s' class = 'button'>Supprimer</button></td>";

					$str .= "</tr>";
				}
			}
			$str .= "</table>";

			include_once('exportTab.php');
			
			$str .= $this->statistiqueSupervision($_date);

            return $str; 
		}

		function ColorerChampVide_HeureInf30Minute($champ , $superieur30Min){

			if($champ == "" || $superieur30Min){
				return " class = vide ";
			}
		}
		function dateSuperieur30Min($heure_arrivee , $heure_creation){
			if($heure_arrivee == "" || $heure_creation == ""){
				return false;
			}
			else{
				$arrivee = date_create_from_format('G:i',$heure_arrivee);
				$creation = date_create_from_format('G:i',$heure_creation);
				$diff = date_diff($arrivee , $creation );

				//bien aider avec var_dump(expression)

				if($diff->h > 0 || $diff->i > 30){
					return true;
				}
				else{
					return false;
				}
			}
		}

		function InsertHelpdesk($date_arrivee_php , $heure_arrivee_php , $client_php , $demandeur_php , $numero_ticket_php, $heure_creation_ticket_php, $pole_actuel_php, $intervenant_php, $commentaire_php){

			$date_arrivee_sql = $this->cnx->quote($date_arrivee_php);
			$heure_arrivee_sql = $this->cnx->quote($heure_arrivee_php);
			$client_sql = $this->cnx->quote($client_php);
			$demandeur_sql = $this->cnx->quote($demandeur_php);
			$numero_ticket_sql = $this->cnx->quote($numero_ticket_php);
			$heure_creation_ticket_sql = $this->cnx->quote($heure_creation_ticket_php);
			$pole_actuel_sql = $this->cnx->quote($pole_actuel_php);
			$intervenant_sql = $this->cnx->quote($intervenant_php);
			$commentaire_sql = $this->cnx->quote($commentaire_php);


			
			$requete = "INSERT INTO helpdesk (date_arrivee,heure_arrivee,client,demandeur,heure_creation_ticket,numero_ticket,pole_actuel,intervenant,commentaire) 
						VALUES ($date_arrivee_sql, $heure_arrivee_sql, $client_sql, $demandeur_sql,$numero_ticket_sql,
								$heure_creation_ticket_sql, $pole_actuel_sql, $intervenant_sql, $commentaire_sql)";		

			$resultat = $this->cnx->query($requete);
			

			if($resultat===FALSE)
			{
				//return $requete;
				return "fail";	
			}
			elseif($resultat==FALSE)
			{

				return "fail";
				
			}
			else  
			{	  // REUSSITE DANS DE L'inscription
				//prendre le ID avec une requete
				$requete = "SELECT id FROM  helpdesk WHERE 
							date_arrivee = $date_arrivee_sql AND
							heure_arrivee = $heure_arrivee_sql AND
							client = $client_sql AND
							demandeur = $demandeur_sql AND
							heure_creation_ticket = $numero_ticket_sql AND
							numero_ticket = $heure_creation_ticket_sql AND
							pole_actuel = $pole_actuel_sql AND
							intervenant = $intervenant_sql AND
							commentaire = $commentaire_sql";
				
				$resultat = $this->cnx->query($requete);

				if($resultat != null && $resultat != false){
					
					while($arr = $resultat->fetch()){
						
						$id = $arr['id'];
						//$id_sql =  $this->cnx->quote($id);

						$this->EcrireHistorique("insertion", $id, "HELPDESK", $date_arrivee_sql , $heure_creation_ticket_sql);
						
						break;
					}
				}

				return "success";
			}
		}
		function UpdateHelpdesk($id , $date_arrivee_php , $heure_arrivee_php , $client_php , $demandeur_php , $heure_creation_ticket_php, $numero_ticket_php, $pole_actuel_php, $intervenant_php, $commentaire_php){

			$id_sql =  $this->cnx->quote($id);
			$date_arrivee_sql = $this->cnx->quote($date_arrivee_php);
			$heure_arrivee_sql = $this->cnx->quote($heure_arrivee_php);
			$client_sql = $this->cnx->quote($client_php);
			$demandeur_sql = $this->cnx->quote($demandeur_php);
			$numero_ticket_sql = $this->cnx->quote($numero_ticket_php);
			$heure_creation_ticket_sql = $this->cnx->quote($heure_creation_ticket_php);
			$pole_actuel_sql = $this->cnx->quote($pole_actuel_php);
			$intervenant_sql = $this->cnx->quote($intervenant_php);
			$commentaire_sql = $this->cnx->quote($commentaire_php);

			$requete = "UPDATE helpdesk SET 
			date_arrivee = $date_arrivee_sql,
			heure_arrivee = $heure_arrivee_sql,
			client = $client_sql,
			demandeur = $demandeur_sql,
			heure_creation_ticket = $heure_creation_ticket_sql,
			numero_ticket = $numero_ticket_sql,
			pole_actuel = $pole_actuel_sql,
			intervenant = $intervenant_sql,
			commentaire = $commentaire_sql 
			WHERE id = $id_sql";			
			

			
			$resultat = $this->cnx->query($requete);
			
			//return $requete;

			if($resultat===FALSE)
			{
				//return $requete;
				return "fail";	
			}
			elseif($resultat==FALSE)
			{

				return "fail";
				
			}
			else  
			{	  // REUSSITE DANS DE L'inscription
				$this->EcrireHistorique("modification", $id, "HELPDESK", $date_arrivee_sql , $numero_ticket_sql);
				return "success";
			}	
		}

		function DeleteHelpdesk($id){
			
			$requete = "SELECT numero_ticket FROM  helpdesk WHERE id='$id'";
			$numero_ticket="";
			$resultat = $this->cnx->query($requete);				
			if($resultat != null && $resultat != false){	
				while($arr = $resultat->fetch()){
					$numero_ticket = $arr['numero_ticket'];
					break;
				}
			}
			$numero_ticket = $this->cnx->quote($numero_ticket);	


			$requete = "DELETE FROM helpdesk WHERE id='$id'";
			
			$date_arrivee_sql = $this->cnx->quote(date("d/m/Y"));
			$resultat = $this->cnx->query($requete);


			if($resultat===FALSE)
			{
				//return $requete;
				return "fail";	
			}
			elseif($resultat==FALSE)
			{

				return "fail";
				
			}
			else  
			{	  // REUSSITE DANS DE L'inscription

				$this->EcrireHistorique("suppression", $id, "HELPDESK", $date_arrivee_sql , $numero_ticket);
				return "success";
			}	

			return $requete;
		}


		function InsertSupervision($date_arrivee_php , $heure_arrivee_php , $client_php , $origine_php , $numero_ticket_php, $heure_creation_ticket_php, $etat_php, $intervenant_php, $commentaire_php){

			$date_arrivee_sql = $this->cnx->quote($date_arrivee_php);
			$heure_arrivee_sql = $this->cnx->quote($heure_arrivee_php);
			$client_sql = $this->cnx->quote($client_php);
			$origine_sql = $this->cnx->quote($origine_php);
			$numero_ticket_sql = $this->cnx->quote($numero_ticket_php);
			$heure_creation_ticket_sql = $this->cnx->quote($heure_creation_ticket_php);
			$etat_sql = $this->cnx->quote($etat_php);
			$intervenant_sql = $this->cnx->quote($intervenant_php);
			$commentaire_sql = $this->cnx->quote($commentaire_php);

			$requete = "INSERT INTO supervision (date_arrivee,heure_arrivee,client,origine,heure_creation_ticket,numero_ticket,etat,intervenant,commentaire) 
						VALUES ($date_arrivee_sql, $heure_arrivee_sql, $client_sql, $origine_sql,$numero_ticket_sql,
								$heure_creation_ticket_sql, $etat_sql, $intervenant_sql, $commentaire_sql)";		
	
			
			$resultat = $this->cnx->query($requete);
			

			if($resultat===FALSE)
			{
				//return $requete;
				return "fail";	
			}
			elseif($resultat==FALSE)
			{

				return "fail";
				
			}
			else  
			{	  // REUSSITE DANS DE L'inscription
				
				//prendre le ID avec une requete
				$requete = "SELECT id FROM supervision WHERE 
							date_arrivee = $date_arrivee_sql AND
							heure_arrivee = $heure_arrivee_sql AND
							client = $client_sql AND
							origine =  $origine_sql AND
							heure_creation_ticket = $numero_ticket_sql AND
							numero_ticket = $heure_creation_ticket_sql AND
							etat = $etat_sql AND
							intervenant = $intervenant_sql AND
							commentaire =  $commentaire_sql";	
				
				
				$resultat = $this->cnx->query($requete);


				if($resultat != null && $resultat != false){
					
					while($arr = $resultat->fetch()){
						
						$id = $arr['id'];
						//$id_sql =  $this->cnx->quote($id);

						$this->EcrireHistorique("insertion", $id, "SUPERVISION", $date_arrivee_sql, $heure_creation_ticket_sql);
						
						break;
					}
				}

				return "success";
			}	
		}

		function UpdateSupervision($id , $date_arrivee_php , $heure_arrivee_php , $client_php , $origine_php , $heure_creation_ticket_php, $numero_ticket_php, $etat_php, $intervenant_php, $commentaire_php){

			$id_sql =  $this->cnx->quote($id);
			$date_arrivee_sql = $this->cnx->quote($date_arrivee_php);
			$heure_arrivee_sql = $this->cnx->quote($heure_arrivee_php);
			$client_sql = $this->cnx->quote($client_php);
			$origine_sql = $this->cnx->quote($origine_php);
			$numero_ticket_sql = $this->cnx->quote($numero_ticket_php);
			$heure_creation_ticket_sql = $this->cnx->quote($heure_creation_ticket_php);
			$etat_sql = $this->cnx->quote($etat_php);
			$intervenant_sql = $this->cnx->quote($intervenant_php);
			$commentaire_sql = $this->cnx->quote($commentaire_php);

			$requete = "UPDATE supervision SET 
			date_arrivee = $date_arrivee_sql,
			heure_arrivee = $heure_arrivee_sql,
			client = $client_sql,
			origine = $origine_sql,
			heure_creation_ticket = $heure_creation_ticket_sql,
			numero_ticket = $numero_ticket_sql,
			etat = $etat_sql,
			intervenant = $intervenant_sql,
			commentaire = $commentaire_sql 
			WHERE id = $id_sql";			
			

			
			$resultat = $this->cnx->query($requete);
			
			//return $requete;

			if($resultat===FALSE)
			{
				//return $requete;
				return "fail";	
			}
			elseif($resultat==FALSE)
			{

				return "fail";
				
			}
			else  
			{	  // REUSSITE DANS DE L'inscription

				//EcrireHistorique($action, $ligne, $type, $date);
				$this->EcrireHistorique("modification", $id, "SUPERVISION", $date_arrivee_sql, $numero_ticket_sql);

				return "success";
			}	
		}

		function DeleteSupervision($id){

			$requete = "SELECT numero_ticket FROM  supervision WHERE id='$id'";
			$numero_ticket="";
			$resultat = $this->cnx->query($requete);				
			if($resultat != null && $resultat != false){	
				while($arr = $resultat->fetch()){
					$numero_ticket = $arr['numero_ticket'];
					break;
				}
			}
			
			$numero_ticket = $this->cnx->quote($numero_ticket);


			$requete = "DELETE FROM supervision WHERE id='$id'";
			
			$date_arrivee_sql = $this->cnx->quote(date("d/m/Y"));
			$resultat = $this->cnx->query($requete);

			
			if($resultat===FALSE)
			{
				//return $requete;
				return "fail";	
			}
			elseif($resultat==FALSE)
			{

				return "fail";
				
			}
			else  
			{	  // REUSSITE DANS DE L'inscription

			    $this->EcrireHistorique("suppression", $id, "SUPERVISION", $date_arrivee_sql, $numero_ticket);
				return "success";
			}	
			
			return $requete;
		}

		function GetAutorises(){
			$requete = "SELECT matricul FROM utilisateur";

			$res = $this->cnx->query($requete);


			if($res == null || $res == false){
				return array('mahasetra');			
			}
			else{
				$retour = array();
				while($arr = $res->fetch()){
					
					$retour[] = $arr['matricul'];
				}
				return $retour;
			}
		}
///////////////////////////////////////////////////////////////////////////////////////////



//POUR LE SUIVIE ET HISTORIQUE
		function EcrireHistorique($action, $ligne, $type, $date , $numero_ticket){

			//SERVEUR
			$matricul = $_SESSION['id'];
			
			//LOCAL
			//$matricul = '551';

			$matricul = $this->cnx->quote($matricul);
			
			if($type=="HELPDESK"){
				$ligne.="h";
			}
			else if($type=="APPEL"){
				$ligne.="a";
			}
			else{
				$ligne.="s";
			}

			$ligne = $this->cnx->quote($ligne);
			$action = $this->cnx->quote($action);
			
			$requete = "INSERT INTO historique (matricul,action,id_ligne,date_creation,numero_ticket) 
						VALUES ($matricul, $action, $ligne, $date, $numero_ticket)";		
	
			//return $requete;
			$resultat = $this->cnx->query($requete);
			
		}


		function GetAllTicket(){
			$helpdesk = $this->GetTicketMaha();
			$supervision = $this->GetTicketMahaSup();

			return $helpdesk.$supervision;
		}
		function GetTicketHistorique(){
			
			$sql = "SELECT distinct(numero_ticket) FROM historique ORDER BY numero_ticket DESC";
			//$sql = "SELECT to_char(jour_debut_action,'dd/MM/yyyy') as test FROM action ORDER BY test;";
			//echo$sql;
			
            		$rs=$this->cnx->query($sql);
            		$str = "";
			
			while($arr = $rs->fetch())
			{
				$str .= '<option value="'.$arr['numero_ticket'].'">'.$arr['numero_ticket'].'</option>';
			}
		
			return $str; 
			
		}

		function GetDateHistorique(){
	  		$sql = "SELECT distinct date_creation , CAST(date_creation AS date) AS indexage FROM historique ORDER BY CAST(date_creation AS date) DESC";
			
            		$rs=$this->cnx->query($sql);
	        	$str = "";
			
			if($rs != null){
				while($arr = $rs->fetch())
				{
					$str .= '<option value="'.$arr['date_creation'].'">'.$arr['date_creation'].'</option>';
				}
			}
			else{
				//$str .= '<option value=test>test</option>';
				
				$sql = "SELECT distinct(date_creation) FROM historique ORDER BY date_creation DESC";
				$rs=$this->cnx->query($sql);
		        $str = "";
				
				if($rs != null){
					while($arr = $rs->fetch())
					{
						$str .= '<option value="'.$arr['date_creation'].'">'.$arr['date_creation'].'</option>';
					}
				}
			}
			
		
		return $str; 	  	}	
		
		function GetMatricul(){
			$sql = "SELECT matricul FROM utilisateur ORDER BY matricul ASC";
			
       		$rs=$this->cnx->query($sql);
 	 		$str = "";
			
			while($arr = $rs->fetch())
			{
				$str .= '<option value="'.$arr['matricul'].'">'.$arr['matricul'].'</option>';
			}
		
			return $str;
		}



	  function RechercheHistorique($dateSelect, $numTicketSelect, $matriculSelect, $actionSelect, $typeSelect){

			$requete = "SELECT * FROM historique WHERE ";
			$critere_exist = false;

			if($dateSelect != ""){
				$requete = $requete." date_creation = '".$dateSelect."'";
				$critere_exist = true;
			}

			if($numTicketSelect != ""){
				if($critere_exist){
					$requete .= " AND ";
				}
				$requete = $requete." numero_ticket = '".$numTicketSelect."'";
				$critere_exist = true;

			}

			if($matriculSelect != ""){
				if($critere_exist){
					$requete .= " AND ";
				}
				$requete = $requete." matricul = '".$matriculSelect."'";
				$critere_exist = true;
			}

			if($actionSelect != ""){
				if($critere_exist){
					$requete .= " AND ";
				}
				$requete = $requete." action = '".$actionSelect."'";
				$critere_exist = true;
			}

			if($typeSelect != ""){
				if($critere_exist){
					$requete .= " AND ";
				}
				if($typeSelect=="helpdesk"){
					$requete = $requete." id_ligne LIKE '%h'";	
				}
				else if($typeSelect=="appel"){
					$requete = $requete." id_ligne LIKE '%a'";
				}
				else{
					$requete = $requete." id_ligne LIKE '%s'";
				}
			}


			$requete .= " ORDER BY id DESC LIMIT 150";


			$str = "<table id='table_1' class='value'><tr><td>Date</td><td>Numero Ticket</td><td>Matricule</td><td>Action</td><td>Type</td><td>Ligne</td></tr>";

			$res = $this->cnx->query($requete);

			if($res == null || $res == false){
				$str = "<p>Aucun resultat</p>";
			}
			else{

				while($arr = $res->fetch()){
			
					$str .= "<tr>";

					$str .= "<td id = date_creation".$arr['id'].">".$arr['date_creation']."</td>";
					$str .= "<td id = numero_ticket".$arr['id'].">".$arr['numero_ticket']."</td>";
					$str .= "<td id = matricul".$arr['id'].">".$arr['matricul']."</td>";
					$str .= "<td id = action".$arr['id'].">".$arr['action']."</td>";
					
					if(substr($arr['id_ligne'], -1)=="h"){
						$str .= "<td id = type".$arr['id'].">HELPDESK</td>";
					}
					else if(substr($arr['id_ligne'], -1)=="a"){
						$str .= "<td id = type".$arr['id'].">APPEL</td>";
					}
					else{
						$str .= "<td id = type".$arr['id'].">SUPERVISION</td>";
					}

					$str .= "<td id = id_ligne".$arr['id'].">".$arr['id_ligne']."</td>";

					//$str .= "<td><button id = '".$arr['id']."' class = 'button'>Modifier</button></td>";
					//$str .= "<td><button id = '".$arr['id']."s' class = 'button'>Supprimer</button></td>";

					$str .= "</tr>";
				}
			}
			$str .= "</table>";

			include_once('exportTab.php');
			
            		return $str;  
		}
////////////////////////////////////////////////////////////////////////////////////


		//PARAMETRE
		function GetUtilisateur(){
			$sql = "SELECT matricul FROM utilisateur ORDER BY matricul ASC";
			
       		$rs=$this->cnx->query($sql);

			$str = "<table id='table_1' class='value'><tr><td>Matricule</td><td>Supprimer</td></tr>";
			while($arr = $rs->fetch())
			{
				$str .= "<tr>";
				$str .= "<td id = date_creation".$arr['matricul'].">".$arr['matricul']."</td>";
				//$str .= "<td><button id = '".$arr['matricul']."' class = 'button'>Modifier</button></td>";
				$str .= "<td><button id = '".$arr['matricul']."' class = 'button'>Supprimer</button></td>";
				$str .= "</tr>";
			}
			$str .= "</table>";
			return $str;
		}


		function supprimerUtilisateur($matricul){

			if(is_numeric($matricul)){

				$requete = "DELETE FROM utilisateur WHERE matricul='$matricul'";

				$resultat = $this->cnx->query($requete);


				if($resultat===FALSE)
				{
					//return $requete;
					return "fail";	
				}
				elseif($resultat==FALSE)
				{

					return "fail";
					
				}
				else  
				{	  // REUSSITE DANS DE L'inscription

					return "success";
				}	
			}
			else{
				return "mba ataovy chiffre fa tss";
			}
			
		}
		function saveUser($matricul){

			if(is_numeric($matricul)){

				$requete = "INSERT INTO utilisateur (matricul) VALUES ('$matricul')";

				$resultat = $this->cnx->query($requete);


				if($resultat===FALSE)
				{
					//return $requete;
					return "fail";	
				}
				elseif($resultat==FALSE)
				{

					return "fail";
					
				}
				else  
				{	  // REUSSITE DANS DE L'inscription

					return "success";
				}	
			}
			else{
				return "mba ataovy chiffre fa tss";
			}
			
		}
///////////////////////////////////////////////////////////////////////////////////////////

		//STATISTIQUE HELPDESK ET SUPERVISION
		function statistiqueHelpdesk($date){

			$str = "<br/><div><h2>STATISTIQUE DU $date</h2></div>";

			$str .= "<table id='table_2' class='value'><tr><td>Dur&eacutee Total de prise en compte</td><td>Dur&eacutee Moyenne de prise en compte</td><td>Dur&eacutee maximum de prise en compte</td><td>Quantit&eacute de mails</td><td>Quantit&eacute de mails depassant 30mn</td></tr>";
			
			$str .= "<tr>";

			$requete = "SELECT SUM(CAST(heure_creation_ticket AS TIME)) - SUM(CAST(heure_arrivee AS TIME)) AS resultat FROM helpdesk WHERE date_arrivee = '$date'";				
			$str .= $this->getResFromReq($requete);
			$requete = "SELECT AVG(CAST(heure_creation_ticket AS TIME)) - AVG(CAST(heure_arrivee AS TIME)) AS resultat FROM helpdesk WHERE date_arrivee = '$date'";				
			$str .= $this->getResFromReq($requete);
			$requete = "SELECT MAX((CAST(heure_creation_ticket AS TIME)) - (CAST(heure_arrivee AS TIME))) AS resultat FROM helpdesk WHERE date_arrivee = '$date'";				
			$str .= $this->getResFromReq($requete);
			$requete = "SELECT COUNT(*) AS resultat FROM helpdesk WHERE date_arrivee = '$date'";				
			$str .= $this->getResFromReq($requete);
			$requete = "SELECT COUNT(*) AS resultat FROM helpdesk WHERE date_arrivee = '$date' AND ((CAST(heure_creation_ticket AS TIME)) - (CAST(heure_arrivee AS TIME))) > ('00:30:00')";				
			$str .= $this->getResFromReq($requete);

			$str .= "</tr>";
			$str.="</table>";

			return $str;
		}
		function statistiqueSupervision($date){

			$str = "<br/><div><h2>STATISTIQUE DU $date</h2></div>";

			$str .= "<table id='table_2' class='value'><tr><td>Dur&eacutee Total de prise en compte</td><td>Dur&eacutee Moyenne de prise en compte</td><td>Dur&eacutee maximum de prise en compte</td><td>Quantit&eacute de mails</td><td>Quantit&eacute de mails depassant 30mn</td></tr>";
			
			$str .= "<tr>";

			$requete = "SELECT SUM(CAST(heure_creation_ticket AS TIME)) - SUM(CAST(heure_arrivee AS TIME)) AS resultat FROM supervision WHERE date_arrivee = '$date'";				
			$str .= $this->getResFromReq($requete);
			$requete = "SELECT AVG(CAST(heure_creation_ticket AS TIME)) - AVG(CAST(heure_arrivee AS TIME)) AS resultat FROM supervision WHERE date_arrivee = '$date'";				
			$str .= $this->getResFromReq($requete);
			$requete = "SELECT MAX((CAST(heure_creation_ticket AS TIME)) - (CAST(heure_arrivee AS TIME))) AS resultat FROM supervision WHERE date_arrivee = '$date'";				
			$str .= $this->getResFromReq($requete);
			$requete = "SELECT COUNT(*) AS resultat FROM supervision WHERE date_arrivee = '$date'";				
			$str .= $this->getResFromReq($requete);
			$requete = "SELECT COUNT(*) AS resultat FROM supervision WHERE date_arrivee = '$date' AND ((CAST(heure_creation_ticket AS TIME)) - (CAST(heure_arrivee AS TIME))) > ('00:30:00')";				
			$str .= $this->getResFromReq($requete);

			$str .= "</tr>";
			$str.="</table>";

			return $str;
		}

		function getResFromReq($requete){			
			$str = "";
			$resultat = $this->cnx->query($requete);
			if($resultat != null){
				while($arr = $resultat->fetch())
				{				
					$str .= "<td>".$arr['resultat']."</td>";
					break;
				}
			}
			else{
				$str .= "<td>Certains champs sont vides</td>";
			}
			if($str == "") $str = "<td></td>"; 
			return $str;
		}
/////////////////////////////////////////////////////////////////////////////////////


		//POUR APPEL

		function GetDateAppel(){
		  	$sql = "SELECT distinct date , CAST(date AS date) AS indexage FROM appel_saisi ORDER BY CAST(date AS date) DESC";
		  	
				
	        $rs=$this->cnx->query($sql);
	        $str = "";
			
			if($rs != null){
				while($arr = $rs->fetch())
				{
					$str .= '<option value="'.$arr['date'].'">'.$arr['date'].'</option>';
				}
			}
			else{

				$sql = "SELECT distinct(date) FROM appel_saisi ORDER BY date DESC";
				 $rs=$this->cnx->query($sql);
		        $str = "";
				
				if($rs != null){
					while($arr = $rs->fetch())
					{
						$str .= '<option value="'.$arr['date'].'">'.$arr['date'].'</option>';
					}
				}
			}
			
			return $str; 
		  }		
		  function GetSocieteAppel(){
		  	$sql = "SELECT distinct(societe) FROM appel_saisi ORDER BY societe DESC";
				//$sql = "SELECT to_char(jour_debut_action,'dd/MM/yyyy') as test FROM action ORDER BY test;";
				//echo$sql;
				
		        $rs=$this->cnx->query($sql);
		        $str = "";
				
				while($arr = $rs->fetch())
				{
					$str .= '<option value="'.$arr['societe'].'">'.$arr['societe'].'</option>';
				}
			
			return $str; 
		  }
		  function GetInterlocuteurAppel(){
		  	$sql = "SELECT distinct(interlocuteur) FROM appel_saisi ORDER BY interlocuteur DESC";
				//$sql = "SELECT to_char(jour_debut_action,'dd/MM/yyyy') as test FROM action ORDER BY test;";
				//echo$sql;
				
		        $rs=$this->cnx->query($sql);
		        $str = "";
				
				while($arr = $rs->fetch())
				{
					$str .= '<option value="'.$arr['interlocuteur'].'">'.$arr['interlocuteur'].'</option>';
				}
			
			return $str; 
		  }
		  function GetIntervenantAppel(){
		  	$sql = "SELECT distinct(intervenant) FROM appel_saisi ORDER BY intervenant DESC";
				//$sql = "SELECT to_char(jour_debut_action,'dd/MM/yyyy') as test FROM action ORDER BY test;";
				//echo$sql;
				
		        $rs=$this->cnx->query($sql);
		        $str = "";
				
				while($arr = $rs->fetch())
				{
					$str .= '<option value="'.$arr['intervenant'].'">'.$arr['intervenant'].'</option>';
				}
			
			return $str; 
		  }
		  function GetTicketAppel(){
		  	$sql = "SELECT distinct(ticket) FROM appel_saisi ORDER BY ticket DESC";
				//$sql = "SELECT to_char(jour_debut_action,'dd/MM/yyyy') as test FROM action ORDER BY test;";
				//echo$sql;
				
		        $rs=$this->cnx->query($sql);
		        $str = "";
				
				while($arr = $rs->fetch())
				{
					$str .= '<option value="'.$arr['ticket'].'">'.$arr['ticket'].'</option>';
				}
			
			return $str; 
		  }
		  function GetTypeAppel(){
		  	$sql = "SELECT distinct(type) FROM appel_saisi_type ORDER BY type DESC";
				//$sql = "SELECT to_char(jour_debut_action,'dd/MM/yyyy') as test FROM action ORDER BY test;";
				//echo$sql;
				
		        $rs=$this->cnx->query($sql);
		        $str = "";
				
				while($arr = $rs->fetch())
				{
					$str .= '<option value="'.$arr['type'].'">'.$arr['type'].'</option>';
				}
			
			return $str; 
		  }
		  function GetComportementAppel(){
		  	$sql = "SELECT distinct(comportement) FROM appel_saisi_comportement ORDER BY comportement DESC";
				//$sql = "SELECT to_char(jour_debut_action,'dd/MM/yyyy') as test FROM action ORDER BY test;";
				//echo$sql;
				
		        $rs=$this->cnx->query($sql);
		        $str = "";
			
				while($arr = $rs->fetch())
				{
					$str .= '<option value="'.$arr['comportement'].'">'.$arr['comportement'].'</option>';
				}
			
			return $str; 
		  }

			function InsertAppel($date_php , $heure_php , $duree_php , $societe_php , $interlocuteur_php, $ticket_php, $type_php, $comportement_php, $intervenant_php , $description_php){

				$date_php_sql = $this->cnx->quote($date_php);
				$heure_sql = $this->cnx->quote($heure_php);
				$duree_sql = $this->cnx->quote($duree_php);
				$societe_sql = $this->cnx->quote($societe_php);
				$interlocuteur_sql = $this->cnx->quote($interlocuteur_php);
				$ticket_sql = $this->cnx->quote($ticket_php);
				$type_sql = $this->cnx->quote($type_php);
				$comportement_sql = $this->cnx->quote($comportement_php);
				$intervenant_sql = $this->cnx->quote($intervenant_php);
				$description_sql = $this->cnx->quote($description_php);


				
				$requete = "INSERT INTO appel_saisi (date,heure,duree,societe,interlocuteur,ticket,type,comportement,description,intervenant) 
							VALUES ($date_php_sql, $heure_sql, $duree_sql, $societe_sql,$interlocuteur_sql,
									$ticket_sql, $type_sql, $comportement_sql, $description_sql , $intervenant_sql)";		

				$resultat = $this->cnx->query($requete);
				

				if($resultat===FALSE)
				{
					//return $requete;
					return "fail";	
				}
				elseif($resultat==FALSE)
				{

					return "fail";
					
				}
				else  
				{	  // REUSSITE DANS DE L'inscription
					//prendre le ID avec une requete
					$requete = "SELECT id FROM  appel_saisi WHERE 
								date = $date_php_sql AND
								heure = $heure_sql AND
								duree = $duree_sql AND
								societe = $societe_sql AND
								interlocuteur = $interlocuteur_sql AND
								ticket = $ticket_sql AND
								type = $type_sql AND
								comportement = $intervenant_sql AND
								intervenant = $comportement_sql AND
								description = $description_sql";
					
					$resultat = $this->cnx->query($requete);

					if($resultat != null && $resultat != false){
						
						while($arr = $resultat->fetch()){
							
							$id = $arr['id'];
							//$id_sql =  $this->cnx->quote($id);

							$this->EcrireHistorique("insertion", $id, "APPEL", $date_php_sql , $ticket_sql);
							
							break;
						}
					}

					return "success";
				}
			}
			function UpdateAppel($id , $date_php , $heure_php , $duree_php , $societe_php , $interlocuteur_php, $ticket_php, $type_php, $comportement_php, $intervenant_php , $description_php){

				$id_sql =  $this->cnx->quote($id);
				$date_php_sql = $this->cnx->quote($date_php);
				$heure_sql = $this->cnx->quote($heure_php);
				$duree_sql = $this->cnx->quote($duree_php);
				$societe_sql = $this->cnx->quote($societe_php);
				$interlocuteur_sql = $this->cnx->quote($interlocuteur_php);
				$ticket_sql = $this->cnx->quote($ticket_php);
				$type_sql = $this->cnx->quote($type_php);
				$comportement_sql = $this->cnx->quote($comportement_php);
				$intervenant_sql = $this->cnx->quote($intervenant_php);
				$description_sql = $this->cnx->quote($description_php);

				$requete = "UPDATE appel_saisi SET 
				date = $date_php_sql,
				heure = $heure_sql,
				duree = $duree_sql,
				societe = $societe_sql,
				interlocuteur = $interlocuteur_sql,
				ticket = $ticket_sql,
				type = $type_sql,
				comportement = $comportement_sql,
				description = $description_sql,
				intervenant = $intervenant_sql 
				WHERE id = $id_sql";			
				

				
				$resultat = $this->cnx->query($requete);
				
				//return $requete;

				if($resultat===FALSE)
				{
					//return $requete;
					return "fail";	
				}
				elseif($resultat==FALSE)
				{

					return "fail";
					
				}
				else  
				{	  // REUSSITE DANS DE L'inscription
					$this->EcrireHistorique("modification", $id, "APPEL", $date_php_sql , $ticket_sql);
					return "success";
				}	
			}

			function DeleteAppel($id){
				
				$requete = "SELECT ticket FROM  appel_saisi WHERE id='$id'";
				$numero_ticket="";
				$resultat = $this->cnx->query($requete);				
				if($resultat != null && $resultat != false){	
					while($arr = $resultat->fetch()){
						$numero_ticket = $arr['ticket'];
						break;
					}
				}
				$numero_ticket = $this->cnx->quote($numero_ticket);	


				$requete = "DELETE FROM appel_saisi WHERE id='$id'";
				
				$date_arrivee_sql = $this->cnx->quote(date("d/m/Y"));
				$resultat = $this->cnx->query($requete);


				if($resultat===FALSE)
				{
					//return $requete;
					return "fail";	
				}
				elseif($resultat==FALSE)
				{

					return "fail";
					
				}
				else  
				{	  // REUSSITE DANS DE L'inscription

					$this->EcrireHistorique("suppression", $id, "APPEL", $date_arrivee_sql , $numero_ticket);
					return "success";
				}	

				return $requete;
			}



	  		function RechercheAppel($dateSelect , $societeSelect , $interlocuteurSelect , $intervenantSelect , $ticketSelect){

				$requete = "SELECT * FROM appel_saisi WHERE ";
				$critere_exist = false;

				if($dateSelect != ""){
					$requete = $requete." date = '".$dateSelect."'";
					$critere_exist = true;
				}

				if($societeSelect != ""){
					if($critere_exist){
						$requete .= " AND ";
					}
					$requete = $requete." societe = '".$societeSelect."'";
					$critere_exist = true;

				}

				if($interlocuteurSelect != ""){
					if($critere_exist){
						$requete .= " AND ";
					}
					$requete = $requete." interlocuteur = '".$interlocuteurSelect."'";
					$critere_exist = true;
				}

				if($intervenantSelect != ""){
					if($critere_exist){
						$requete .= " AND ";
					}
					$requete = $requete." intervenant = '".$intervenantSelect."'";
					$critere_exist = true;
				}

				if($ticketSelect != ""){
					if($critere_exist){
						$requete .= " AND ";
					}
					$requete = $requete." ticket = '".$ticketSelect."'";
					$critere_exist = true;
				}

				$requete .= " ORDER BY id DESC";

				$str = "<table id='table_1' class='value'><tr><td>Date</td><td>Heure</td><td>Duree</td><td>Societe</td><td>Interlocuteur</td><td>Ticket</td><td>Type</td><td>Comportement</td><td>Intervenant</td><td COLSPAN = 3>Description</td><td>Modifier</td><td>Supprimer</td></tr>";

				$res = $this->cnx->query($requete);

				if($res == null || $res == false){
					$str = "<p>Aucun resultat</p>";
				}
				else{

					while($arr = $res->fetch()){
				
						$str .= "<tr>";

						$str .= "<td id = date".$arr['id'].">".$arr['date']."</td>";
						$str .= "<td id = heure".$arr['id'].">".$arr['heure']."</td>";
						$str .= "<td id = duree".$arr['id'].">".$arr['duree']."</td>";
						$str .= "<td id = societe".$arr['id'].">".$arr['societe']."</td>";
						$str .= "<td id = interlocuteur".$arr['id'].">".$arr['interlocuteur']."</td>";
						$str .= "<td id = ticket".$arr['id'].">".$arr['ticket']."</td>";
						$str .= "<td id = type".$arr['id'].">".$arr['type']."</td>";
						$str .= "<td id = comportement".$arr['id'].">".$arr['comportement']."</td>";
						$str .= "<td id = intervenant".$arr['id'].">".$arr['intervenant']."</td>";
						$str .= "<td COLSPAN = 3 id = description".$arr['id'].">".$arr['description']."</td>";
						$str .= "<td><button id = '".$arr['id']."' class = 'button'>Modifier</button></td>";

						$str .= "<td><button id = '".$arr['id']."s' class = 'button'>Supprimer</button></td>";


						$str .= "</tr>";
					}
				}
				$str .= "</table>";

				include_once('exportTab.php');
				
				//pour le statistique
				$str .= $this->statistiqueAppel($dateSelect);
				
	            return $str; 
		}


		//STATISTIQUE APPEL
		function statistiqueAppel($date){

			$str = "<br/><div><h2>STATISTIQUE DU $date</h2></div>";

			$str .= "<table id='table_2' class='value'><tr><td>Date</td><td>Intervenant</td><td>Nombre d'appel</td><td>Duree</td></tr>";
			
			$requete = "SELECT DISTINCT intervenant FROM appel_saisi WHERE date = '$date'";	
			$res = $this->cnx->query($requete);
			while($arr = $res->fetch()){
				$str .= "<tr>";

				$intervenant = $arr['intervenant'];				
				$intervenant_sql = $this->cnx->quote($intervenant);
				//date
				$str .= "<td>".$date."</td>";

				//intervenant
				$str .= "<td>".$intervenant."</td>";

				//nombre d'appel
				$requete = "SELECT COUNT(*) AS resultat FROM appel_saisi WHERE date = '$date' AND intervenant = $intervenant_sql";	
				$str .= $this->getResFromReq($requete); 

				//duree total d'appel
				$requete = "SELECT SUM(duree) AS resultat FROM appel_saisi WHERE date = '$date' AND intervenant = $intervenant_sql";	
				$str .= $this->getResFromReq($requete);


				$str .= "</tr>";
			}

			//total
			$str .= "<tr>";
			$str .= "<td>".$date."</td>";
			$str .= "<td>TOTAL</td>";
			$requete = "SELECT COUNT(*) AS resultat FROM appel_saisi WHERE date = '$date'";	
			$str .= $this->getResFromReq($requete); 
			$requete = "SELECT SUM(duree) AS resultat FROM appel_saisi WHERE date = '$date'";	
			$str .= $this->getResFromReq($requete);
			$str .= "</tr>";



			$str.="</table>";

			return $str;
		}

		//PARAMETRE
		function GetListTypeOrComp($type){
			if($type == "type"){
				$sql = "SELECT * FROM appel_saisi_type ORDER BY type ASC";

				$rs=$this->cnx->query($sql);

				$str = "<table id='table_1' class='value'><tr><td>Type</td><td>Supprimer</td></tr>";
				while($arr = $rs->fetch())
				{
					$str .= "<tr>";
					$str .= "<td id = td".$arr['id'].">".$arr['type']."</td>";
					//$str .= "<td><button id = '".$arr['matricul']."' class = 'button'>Modifier</button></td>";
					$str .= "<td><button id = '".$arr['id']."' class = 'button'>Supprimer</button></td>";
					$str .= "</tr>";
				}
				$str .= "</table>";
				return $str;
			}
			else{
				$sql = "SELECT * FROM appel_saisi_comportement ORDER BY comportement ASC";
				$rs=$this->cnx->query($sql);

				$str = "<table id='table_1' class='value'><tr><td>Comportement</td><td>Supprimer</td></tr>";
				while($arr = $rs->fetch())
				{
					$str .= "<tr>";
					$str .= "<td id = td".$arr['id'].">".$arr['comportement']."</td>";
					//$str .= "<td><button id = '".$arr['matricul']."' class = 'button'>Modifier</button></td>";
					$str .= "<td><button id = '".$arr['id']."' class = 'button'>Supprimer</button></td>";
					$str .= "</tr>";
				}
				$str .= "</table>";
				return $str;
			}
       		
		}


		function DeleteParamAppel($id , $type){

			if(is_numeric($id)){

				if($type == "type"){
					$requete = "DELETE FROM appel_saisi_type WHERE id='$id'";
				}
				else{
					$requete = "DELETE FROM appel_saisi_comportement WHERE id='$id'";
				}

				$resultat = $this->cnx->query($requete);


				if($resultat===FALSE)
				{
					//return $requete;
					return "fail";	
				}
				elseif($resultat==FALSE)
				{

					return "fail";
					
				}
				else  
				{	  // REUSSITE DANS DE L'inscription

					return "success";
				}	
			}
			else{
				return "mba ataovy chiffre fa tss";
			}
			
		}
		function addList($valeur , $type){

			$valeur = $this->cnx->quote($valeur);
			if($type == "type"){
				$requete = "INSERT INTO appel_saisi_type (type) VALUES ($valeur)";
			}
			else{
				$requete = "INSERT INTO appel_saisi_comportement (comportement) VALUES ($valeur)";
			}

			$resultat = $this->cnx->query($requete);

			if($resultat===FALSE)
			{
				//return $requete;
				return "fail";	
			}
			elseif($resultat==FALSE)
			{

				return "fail";
				
			}
			else  
			{	  // REUSSITE DANS DE L'inscription

				return "success";
			}			
		}

		////TICKET PAR INTERVENANT

		//recherche
		function rechercheTicketParIntervenant($dateDebut , $dateFin , $intervenant){

			$retour = "<table id='table_1' class='value'><tr><td>Intervenant</td><td>Debut</td><td>Fin</td><td>Demande</td><td>Alerte</td><td>Incidents</td><td>Cloture</td><td>Durée moyenne</td><td>Durée maximum</td><td>Liste demande</td><td>Liste alerte</td><td>Liste incident</td></tr>";
			
			$req_allIntervenant = "SELECT id_intervenant,nom_prenom FROM intervenant WHERE nom_prenom NOT LIKE ''";

			if($intervenant != "") $req_allIntervenant .= " AND id_intervenant = $intervenant";

			$rs=$this->cnx->query($req_allIntervenant);
			
			//pour avoir l'historique de tous les tickets par date
			//return $this->getTicketClotByIntervenant($dateDebut , $dateFin);
			$historique = $this->getTicketClotByIntervenant($dateDebut , $dateFin);

			while($arr = $rs->fetch())
			{	
				$intervenant = $arr['id_intervenant'];

				$joinIntervenant = "INNER JOIN  intervenant ON action.id_intervenant = intervenant.id_intervenant";

				$req_alerte = "SELECT COUNT(DISTINCT(action.id_ticket)) AS resultat FROM action   WHERE UPPER(sujet) LIKE UPPER('INCIDENTS/ALERTE%') ";
				$req_demande = "SELECT COUNT(DISTINCT(action.id_ticket)) AS resultat FROM action  INNER JOIN ticket ON action.id_ticket = ticket.id_ticket  WHERE ticket.numero LIKE 'S%'";
				$req_incident = "SELECT COUNT(DISTINCT(action.id_ticket)) AS resultat FROM action  INNER JOIN ticket ON action.id_ticket = ticket.id_ticket  WHERE ticket.numero LIKE 'I%' AND sujet NOT LIKE '%ALERTE%'";
				
				$req_list_alerte = "SELECT DISTINCT(ticket.numero) AS resultat FROM action  INNER JOIN ticket ON action.id_ticket = ticket.id_ticket WHERE UPPER(sujet) LIKE UPPER('INCIDENTS/ALERTE%')";
				$req_list_demande = "SELECT DISTINCT(ticket.numero) AS resultat FROM action  INNER JOIN ticket ON action.id_ticket = ticket.id_ticket  WHERE ticket.numero LIKE 'S%'";
				$req_list_incident = "SELECT DISTINCT(ticket.numero) AS resultat FROM action  INNER JOIN ticket ON action.id_ticket = ticket.id_ticket  WHERE ticket.numero LIKE 'I%' AND sujet NOT LIKE '%ALERTE%'";
				

				$req_moyen = "SELECT AVG(res) AS resultat FROM (SELECT AVG(CAST(date_fin AS TIMESTAMP) - CAST(date_ouverture AS TIMESTAMP)) AS res FROM action INNER JOIN ticket ON action.id_ticket = ticket.id_ticket 
							 WHERE (statut LIKE 'Clôturé' OR statut LIKE 'En attente de validation') 
							 AND (type_action = 'Opération clôture' OR type_action ='Historique des mouvements' OR type_action = 'Prise d''appel' OR type_action = 'Requalification')";		


				$req_max = "SELECT MAX(res) AS resultat FROM (SELECT AVG(CAST(date_fin AS TIMESTAMP) - CAST(date_ouverture AS TIMESTAMP)) AS res FROM action INNER JOIN ticket ON action.id_ticket = ticket.id_ticket 
							 WHERE (statut LIKE 'Clôturé' OR statut LIKE 'En attente de validation') 
							 AND (type_action = 'Opération clôture' OR type_action ='Historique des mouvements' OR type_action = 'Prise d''appel' OR type_action = 'Requalification')";		


				//calcul des clots
				$counts = array_count_values($historique);
				$nb_clot = 0;
				@$nb_clot = $counts[$intervenant];
				/////////////////////////////////

				$condition = $this->addCondition($dateDebut , $dateFin , $intervenant);

				$req_alerte .= $condition;
				$req_demande .= $condition;
				$req_incident .= $condition;

				$req_list_alerte .= $condition;
				$req_list_demande .= $condition;
				$req_list_incident .= $condition;

				$req_moyen .= $condition."GROUP BY ticket.id_ticket) AS req";
				$req_max .= $condition."GROUP BY ticket.id_ticket) AS req";

				$retour .= "<tr>";

				$retour .= "<td>".$arr['nom_prenom']."</td>";
				$retour .= "<td>$dateDebut</td>";
				$retour .= "<td>$dateFin</td>";
				$retour .= $this->getResFromReq($req_demande);
				$retour .= $this->getResFromReq($req_alerte);
				$retour .= $this->getResFromReq($req_incident);
				$retour .= "<td>$nb_clot</td>";
				$retour .= $this->getResFromReq($req_moyen);
				$retour .= $this->getResFromReq($req_max);

				$retour .= $this->getListFromReq($req_list_demande, 3);
				$retour .= $this->getListFromReq($req_list_alerte, 3);
				$retour .= $this->getListFromReq($req_list_incident, 3);
				
				$retour .= "</tr>";
			}

			$retour .= "</table>";

			return $retour;
		}

		//CONSTRUIT LES FILTRES NECESSAIRES
		function addCondition($dateDebut , $dateFin , $intervenant){ 
				
			$retour = "";

			if($intervenant != ""){
				$retour .= " AND id_intervenant = '$intervenant'";
			}
			if($dateDebut != ""){

				if($dateFin != ""){
					$retour .= " AND jour_debut_action NOT LIKE ''";
					$retour .= " AND CAST(jour_debut_action AS INTEGER) >= '$dateDebut' AND CAST(jour_debut_action AS INTEGER) <= '$dateFin'";
				}
				else{
					$retour .= " AND jour_debut_action LIKE '$dateDebut'";
				}
			}
			else{

				if($dateFin != ""){
					$retour .= " AND jour_debut_action LIKE '$dateFin'";
				}
			}

			return $retour;	
		}

		function getTicketClotByIntervenant($dateDebut , $dateFin){
			$historique = array();

			$req_clot = "SELECT  action.id_ticket , id_intervenant  FROM action  WHERE (statut LIKE 'Clôturé' OR statut LIKE 'En attente de validation') 
						 AND (type_action = 'Opération clôture' OR type_action ='Historique des mouvements' OR type_action = 'Prise d''appel' OR type_action = 'Requalification')";

			$req_clot .= $this->addCondition($dateDebut , $dateFin , "");
			$req_clot .= " ORDER BY action.id_action ASC";

			$rs=$this->cnx->query($req_clot);

			while($arr = $rs->fetch())
			{
				$historique[$arr['id_ticket']] = $arr['id_intervenant'];
			}	

			return $historique;
		}

		function getListFromReq($requete, $size){			
			$str = "<td>";
			
			$resultat = $this->cnx->query($requete);
			if($resultat != null){
				$str .= "<select multiple size=".$size.">";
				while($arr = $resultat->fetch())
				{				
					$str .= "<option>".$arr['resultat']."</option>";
				}
				$str .= "</select>";
			}
			else{
				$str .= "Certains champs sont vides";
			}

			$str .= "</td>";

			return $str;
		}

	}
?>
