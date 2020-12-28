<?php
include_once('header.inc.php');

	$isset = isset($_POST['ip']); //true si le formulaire est posté
	$erreur = false; //On change cette valeur à la moindre erreur
	if ($isset) {
		 //Si le formulaire a été posté
		 if (!empty($_POST['ip'])) {
			  $ip = ip2long($_POST['ip']);
			  if ($ip != false && $ip != -1) {
				   //Si l'ip est valide
	 
				   require ('libs/div/is_ban.php');
				   if (!is_ban($ip)) {
						mysql_query('INSERT INTO ban (`ip`) VALUES(\'' . $ip . '\')');
						print('Cette adresse est désormais non-autorisée.');
				   }
				   else
						print ('Cette adresse est déjà bannie.');
			  }
			  else 
				   $erreur = 1; //L'ip est invalide, erreur #1
		 }
		 else
			  $erreur = 0; //Le champ est vide, erreur #0
	}
	if (!$isset || $erreur !== false) {
		 //Si le formulaire n'a pas été posté ou qu'une erreur a été détectée
		 $erreurs = array('Vous devez entrer une adresse ip.', 'L\'adresse ip est invalide.');
		 
		 if ($erreur !== false) {
			  //Si on a une erreur, on l'affiche
			  print('<p style="color: red; font-weight: bold;">' . $erreurs[$erreur] . '</p>');
		 }
		 
		 //On affiche le formulaire
		 print ('<form action="ban.php" method="post">
				   <fieldset>
						<legend>Bannir une adresse IP</legend>
						<p><label for="ip">Adresse a bannir : </label>
						<input type="text" name="ip" id="ip" />
						<input type="submit" value="Bannir" />
				   </fieldset>
				 </form>');
	}
?>
