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
	echo "Le résultat de la recherche est $result <br />";

	echo "Le nombre d'entrées retournées est ".ldap_count_entries($lc,$result)."<p />\n";
	echo "Lecture de ces entrées ....<p />";
	$info = ldap_get_entries($lc, $result);
	echo "Données pour ".$info["count"]." entrées:<p /><br />";

	for ($i=0; $i < $info["count"]; $i++) {
		echo "dn est : ". print_r($info[$i], true) ."<br />\n";
		echo "premiere entree cn : ". $info[$i]["cn"][0] ."<br /><br />";
		echo "premier email : ". $info[$i]["mail"][0] ."<p /><br />";
		break;
	}
	/* 4ème étape : cloture de la session  */
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

	// on teste : le serveur LDAP est-il trouvé ?
	if ($conn)
		echo "Le résultat de connexion est <".$conn ."><br />";
	else
		die("connexion impossible au serveur LDAP"."<br />");



	/* 2ème étape : on effectue une liaison au serveur, ici de type "anonyme"
	 * pour une recherche permise par un accès en lecture seule
	 */

	// On dit qu'on utilise LDAP V3, sinon la V2 par défaut est utilisé
	// et le bind ne passe pas. 
	if (ldap_set_option($conn, LDAP_OPT_PROTOCOL_VERSION, 3)) {
		echo "Utilisation de LDAPv3<br />";
	} else {
		echo "Impossible d'utiliser LDAP V3<br />";
		exit;
	}


	// Instruction de liaison. 
	// Décommenter la ligne pour une connexion authentifiée
	// ou pour une connexion anonyme.
	// Connexion authentifiée
	 print ("Connexion authentifiée ...$conn -- $rdn -- $mdp<br />");
	 //$bindServerLDAP=ldap_bind($conn,$rdn,$mdp);
	// print ("Connexion anonyme...<br />");
	$bindServerLDAP=ldap_bind($conn);

	print ("Liaison au serveur : ". ldap_error($conn)."<br />");
	// en cas de succès de la liaison, renvoie Vrai
	if ($bindServerLDAP)
		echo "Le résultat de connexion est $bindServerLDAP <br />";
	else
		die("Liaison impossible au serveur ldap ...<br />");

	/* 3ème étape : on effectue une recherche anonyme, avec le dn de base,
	 * par exemple, sur tous les noms commençant par B
	 */
	echo "Recherche suivant le filtre (sn=B*) <br />";
	$query = "sn=R*";
	$result=ldap_search($conn, $baseDN, $query);
	echo "Le résultat de la recherche est $result <br />";

	echo "Le nombre d'entrées retournées est ".ldap_count_entries($conn,$result)."<p />\n";
	echo "Lecture de ces entrées ....<p />";
	$info = ldap_get_entries($conn, $result);
	echo "Données pour ".$info["count"]." entrées:<p /><br />";

	for ($i=0; $i < $info["count"]; $i++) {
		echo "dn est : ". $info[$i]["cn"] ."<br />\n";
		echo "premiere entree cn : ". $info[$i]["cn"][0] ."<br /><br />";
		echo "premier email : ". $info[$i]["mail"][0] ."<p /><br />";
	}
	/* 4ème étape : cloture de la session  */
	echo "Fermeture de la connexion";
	ldap_close($conn);

?>