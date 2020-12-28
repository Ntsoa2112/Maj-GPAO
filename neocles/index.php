<?php
include_once('header.inc.php');
include_once('php/common.php');

	$c = new Cnx();
	$autorises = $c->GetAutorises();

	//$autorises = array('551','471','548','412','414','467','485','568','569','570','629','662','663','664');

	if(in_array($_SESSION['id'], $autorises)){

?>

<body>
	<center id = "acceuil">
		<img src="img/easyTeach.jpg" alt="Easytech" />
		<h1 id="redirection">Page de Redirection</h1>
		<p class = "lien"><a href = "neocles.php?page=helpdesk">MAILS</a></p>
		<p class = "lien"><a href = "neocles.php?page=supervision">SUPERVISION</a></p>
		<?php 
		$autorize = array("551","471","177","730","412","414","1257","1253");


		if(in_array($_SESSION['id'], $autorize)){ ?>

			<p class = "lien"><a href = "parametre.php">Parametre</a></p>
		<?php } ?>

	</center>
</body>
</html>

<?php }
 else{
 	include_once("error.php");
} 
?> 