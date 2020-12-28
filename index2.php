<?php

echo 'begin<br />';
exit();

$user = "EASYTECH\Mirah";
$pass = "Ra123456$$$$";
$baseDN = "dc=easytech,dc=mg";
//in our system, we already use this account for LDAP authentication on the server above
$ldap_serv = 'ldap://10.128.1.21';

echo 'connect';
$conn=ldap_connect($ldap_serv);
$ldap_port = '389';
$lc = ldap_connect($ldap_serv, $ldap_port);
ldap_set_option($lc, LDAP_OPT_REFERRALS, 0);
ldap_set_option($lc, LDAP_OPT_PROTOCOL_VERSION, 3);
$ldapbind = ldap_bind($lc,$user,$pass);


if ($ldapbind == false) {
  echo 'username or password is wrong';
}
else
{
	echo "Recherche suivant le filtre (sn=B*) <br />";
	$query = "sn=RATAHIRY*";
	$result=ldap_search($lc, $baseDN, $query);
	echo "Le r�sultat de la recherche est $result <br />";

	echo "Le nombre d'entr�es retourn�es est ".ldap_count_entries($lc,$result)."<p />\n";
	echo "Lecture de ces entr�es ....<p />";
	$info = ldap_get_entries($lc, $result);
	echo "Donn�es pour ".$info["count"]." entr�es:<p /><br />";

	for ($i=0; $i < $info["count"]; $i++) {
		echo "dn est : ". print_r($info[$i], true) ."<br />\n";
		echo "premiere entree cn : ". $info[$i]["cn"][0] ."<br /><br />";
		echo "premier email : ". $info[$i]["mail"][0] ."<p /><br />";
		break;
	}
	/* 4�me �tape : cloture de la session  */
	echo "Fermeture de la connexion";
}
 exit();

	$baseDN = "dc=easytech,dc=mg";
	$ldapServer = "10.128.1.21";
	$ldapServerPort = 389;
	$rdn="Administrateur";
	$mdp="Root@2010ET";
	$dn = 'cn=10.128.1.21,dc=easytech,dc=mg';

	echo "Connexion au serveur <br />";
	$conn=ldap_connect($ldapServer);

	// on teste : le serveur LDAP est-il trouv� ?
	if ($conn)
		echo "Le r�sultat de connexion est <".$conn ."><br />";
	else
		die("connexion impossible au serveur LDAP"."<br />");



	/* 2�me �tape : on effectue une liaison au serveur, ici de type "anonyme"
	 * pour une recherche permise par un acc�s en lecture seule
	 */

	// On dit qu'on utilise LDAP V3, sinon la V2 par d�faut est utilis�
	// et le bind ne passe pas. 
	if (ldap_set_option($conn, LDAP_OPT_PROTOCOL_VERSION, 3)) {
		echo "Utilisation de LDAPv3<br />";
	} else {
		echo "Impossible d'utiliser LDAP V3<br />";
		exit;
	}


	// Instruction de liaison. 
	// D�commenter la ligne pour une connexion authentifi�e
	// ou pour une connexion anonyme.
	// Connexion authentifi�e
	 print ("Connexion authentifi�e ...$conn -- $rdn -- $mdp<br />");
	 //$bindServerLDAP=ldap_bind($conn,$rdn,$mdp);
	// print ("Connexion anonyme...<br />");
	$bindServerLDAP=ldap_bind($conn);

	print ("Liaison au serveur : ". ldap_error($conn)."<br />");
	// en cas de succ�s de la liaison, renvoie Vrai
	if ($bindServerLDAP)
		echo "Le r�sultat de connexion est $bindServerLDAP <br />";
	else
		die("Liaison impossible au serveur ldap ...<br />");

	/* 3�me �tape : on effectue une recherche anonyme, avec le dn de base,
	 * par exemple, sur tous les noms commen�ant par B
	 */
	echo "Recherche suivant le filtre (sn=B*) <br />";
	$query = "sn=R*";
	$result=ldap_search($conn, $baseDN, $query);
	echo "Le r�sultat de la recherche est $result <br />";

	echo "Le nombre d'entr�es retourn�es est ".ldap_count_entries($conn,$result)."<p />\n";
	echo "Lecture de ces entr�es ....<p />";
	$info = ldap_get_entries($conn, $result);
	echo "Donn�es pour ".$info["count"]." entr�es:<p /><br />";

	for ($i=0; $i < $info["count"]; $i++) {
		echo "dn est : ". $info[$i]["cn"] ."<br />\n";
		echo "premiere entree cn : ". $info[$i]["cn"][0] ."<br /><br />";
		echo "premier email : ". $info[$i]["mail"][0] ."<p /><br />";
	}
	/* 4�me �tape : cloture de la session  */
	echo "Fermeture de la connexion";
	ldap_close($conn);

?>