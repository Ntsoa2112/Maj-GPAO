<?php
include_once('php/common.php');
$c = new Cnx();
?>
<div class="navbar navbar-inverse navbar-fixed-top menu_haut" role="navigation">
	<div class="container-fluid">
		<!-- Brand and toggle get grouped for better mobile display -->
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>  
			</button>
			<ul class="nav navbar-nav hidden-md hidden-sm"><li class=""><a href="end.php"  class="logout col-xs-1" id="fermer_session" title="Fermer la session" 
				<?php
				if (!isset($_SESSION['pseudo']))
					echo 'style="display:none"';
				?>><img src="img/deconnect.png" class="logout"/></a></li>
					<?php
					if ((isset($_SESSION['pseudo'])) && (!empty($_SESSION['pseudo']))) {
						echo '<li><a class="navbar-brand" href="#" title="Cliquer pour vous deconnecter!" onClick="deconnect();"> &nbsp; Bonjour ' . $_SESSION['pseudo'] . '</a></li></ul>';
					}
					?> 
		</div>
		
		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
		<ul class="nav navbar-nav navbar-right"><li class=""><!--<a href="end.php"  class="logout col-xs-1" id="fermer_session" title="Fermer la session" 
				<?php
				if (!isset($_SESSION['pseudo']))
					echo 'style="display:none"';
				?>><img src="img/deconnect.png" class="logout"/></a>--> </li>
					<?php // <a href="#" title="Cliquer pour vous deconnecter!" onClick="deconnect();">Bonjour ' . $_SESSION['pseudo'] . '</a>
					if ((isset($_SESSION['pseudo'])) && (!empty($_SESSION['pseudo']))) {
						echo '<li></li></ul><ul  class="nav navbar-nav pull-right">'; //here
					}
					?>  

			<?php
			$PHP_SELF = $_SERVER['PHP_SELF'];
			if ((isset($_SESSION['pseudo'])) && (!empty($_SESSION['pseudo']))) {
				$arrayAllowedMatricul = array('69' => '69', '210' => '', '243' => '', '177' => '', '1' => '', '3' => '', '5' => '', '421' => '', '699' => '','60'=>'','487'=>'487');
				// $arrayUserAlmerys = array('435' => '', '323' => '', '449' => '', '418' => '', '347' => '', '450' => '');
	//added by Vololona 13/08/2015
				$sqlallow = "SELECT id_pers, id_droit_menu
	  FROM p_logon where id_pers=" . $_SESSION['id'];
				$id_droit = 0;
				$droit_almerys = $c->cnx->query($sqlallow);
				while ($allow = $droit_almerys->fetch()) {
					$id_droit = $allow['id_droit_menu'];
				}

				$menu = '<li><a  class="hvr-bounce-to-right pull-right" href="index.php">ACCUEIL |</a></li>';



				$menu .= '<li><a href="cons.php" class="hidden-md hidden-sm"><blink>CONSIGNES</blink> |</a></li>';
				//$menu .= '<li><a  onclick ="loadPhp(\'ri.php\', \'content_centre\');" href="#">Reglement Interieur |</a></li>';

				if ($_SESSION['id_droit'] == 2 || $_SESSION['id_droit'] == 3 || $_SESSION['id_droit'] == 5 || $_SESSION['id_droit'] == 4 || $_SESSION['id_droit'] == 7) {

					$menu .= '<li><a  class="hvr-bounce-to-right pull-right"  data-toggle="dropdown" class="dropdown-toggle" href="http://10.128.2.3/redmine" title="SMQ">SMQ<b class="caret"></b> |</a>
					<ul class="dropdown-menu"><li><a  class="hvr-bounce-to-right pull-left" href="http://smq.easytech.mg/login?"  target="_blank" title="Gestion de ticket Redmine">G-NC</a></li>
					<li><a  class="hvr-bounce-to-right pull-left" href="http://doc.easytech.mg/share/page/"  target="_blank" title="Gestion Documentaire Alfresco">G-DOC</a></li>
                                        <li><a  class="hvr-bounce-to-right pull-left" href="http://db1:1150"  target="_blank" title="Enquete">Enquete</a></li>
					</ul>
					</li>';

					$menu .= '<li><a  class="hvr-bounce-to-right pull-right hidden-md hidden-sm" href="visu.php">PLAN2D</a></li>';
					$menu .= '<li><a  class="hvr-bounce-to-right pull-right hidden-md hidden-sm"  href="Dossier.php">DOSSIER</a></li>';
					$menu .= '<li><a   class="hvr-bounce-to-right pull-right" href="lot.php">LOT</a></li>';
					$menu .= '<li><a  class="hvr-bounce-to-right pull-right"  href="plan.php">SUIVI</a></li>';
					$menu .= '<li><a  class="hvr-bounce-to-right pull-right"  href="rapp.php">REPORTING</a></li>';

					//$menu .= '<li><a href="listesary.php">Gallery |</a></li>';
				}
				$menu .= '<li>
					<a  class="hvr-bounce-to-right pull-right"   data-toggle="dropdown" class="dropdown-toggle" id="ldtING" href="#">POINTAGES<b class="caret"></b> |</a>
						<ul class="dropdown-menu">
						<li><a class="hvr-bounce-to-right pull-left"  href="pt.php">LISTES</a></li>';
				if (array_key_exists($_SESSION['id'], $arrayAllowedMatricul)) {
					$menu .= '<li><a class="hvr-bounce-to-right pull-left"  id="ldtING" href="pointage.php">MANUELLE</a></li>';
				}
				$menu .= '</ul>
					</li>';

				$menu .= '<li><a  class="hvr-bounce-to-right pull-right" href="ldt.php" ">LIGNE DE TEMPS |</a></li>';


				$menu .= '<li><a  class="hvr-bounce-to-right pull-right"   data-toggle="dropdown" class="dropdown-toggle" id="neocles" href="#">NEOCLES<b class="caret"></b> |</a>
						<ul class="dropdown-menu">
						<li><a  class="hvr-bounce-to-right pull-left" href="neocles/index.php">PAGE </a></li><li> <a class="hvr-bounce-to-right pull-left" href="ldt.neocles.php">Ligne de temps</a></li></ul></li>';

				$menu .= '<li><a  class="hvr-bounce-to-right pull-right"  data-toggle="dropdown" class="dropdown-toggle" href="http://10.128.2.3/redmine" title="ALMERYS">ALMERYS<b class="caret"></b> |</a>
					<ul class="dropdown-menu"><li><a class="hvr-bounce-to-right pull-left"  href="interial.cq.php">INTERIAL </a></li>';
				if ($id_droit == 3 || $id_droit == 2 || $id_droit == 1 || $_SESSION['id_droit'] == 4) {
					$menu .= '<li><a class="hvr-bounce-to-right pull-left" href="almerys.cq.php">CQ-ALMERYS</a></li>';
				}
				if ($id_droit == 2 || $id_droit == 3) {
					$menu .= '<li><a  class="hvr-bounce-to-right pull-left" href="Almerys.user.php">USER ADMIN</a></li><li><a class="hvr-bounce-to-right pull-left"  href="almerys.user.add.php">AJOUT UTILISATEUR </a></li>';
				}
                               
                                
				$menu .= '</ul>';
                                $menu .='<li> <a  class="hvr-bounce-to-right pull-right"  data-toggle="dropdown" class="dropdown-toggle" href="#">DEV <b class="caret"></b>|</a>'
                                        . '<ul class="dropdown-menu"><li><a  class="hvr-bounce-to-right pull-left" href="http://10.128.2.3/redmine/" target="_blank">redmine-dev</a></li>'
                                        . '<li><a  class="hvr-bounce-to-right pull-left" href="http://db1:1337" target="_blank">FICHE RECETTE</a></li>'
                                        . '<li><a  class="hvr-bounce-to-right pull-left" href="http://db1:9090" target="_blank">TABLMEAU DE BORD</a></li></ul></li>';


				$menu .= '<li><a class="hvr-bounce-to-right pull-right hidden-md hidden-sm"  href="dec.php" >D&eacute;connexion</a></li>'; 
				echo $menu;
			} else {
				$menu = '';
				$menu .= '<li><a class="hvr-bounce-to-right pull-right"  href="#"  data-toggle="modal" data-target="#login-modal" ><BLINK>CONNEXION</BLINK></a></li>'; //connexion Modal
				$menu .= '</ul>';


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
			?>
		</div>
	</div>
</div>


