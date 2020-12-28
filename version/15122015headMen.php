<?php
include_once('php/common.php');
$c = new Cnx();
?>
<div class="navbar navbar-inverse navbar-fixed-top menu_haut">
<ul class="nav navbar-nav"><li><a href="end.php"  class="logout" id="fermer_session" title="Fermer la session" 
    <?php
    if (!isset($_SESSION['pseudo']))
        echo 'style="display:none"';
    ?>><img src="img/deconnect.png" class="logout"/></a></li>
	<?php
	if ((isset($_SESSION['pseudo'])) && (!empty($_SESSION['pseudo']))) {
            echo '<li><a href="#" title="Cliquer pour vous deconnecter!" onClick="deconnect();">Bonjour ' . $_SESSION['pseudo'] . '</a></li></ul><ul  class="nav navbar-nav pull-right">';
        } 
      ?>  
		
        <?php
        $PHP_SELF = $_SERVER['PHP_SELF'];
        if ((isset($_SESSION['pseudo'])) && (!empty($_SESSION['pseudo']))) {
            $arrayAllowedMatricul = array('69' => '69', '210' => '', '243' => '', '177' => '', '1' => '', '3' => '', '5' => '', '421' => '', '699' => '');
            // $arrayUserAlmerys = array('435' => '', '323' => '', '449' => '', '418' => '', '347' => '', '450' => '');
//added by Vololona 13/08/2015
            $sqlallow = "SELECT id_pers, id_droit_menu
  FROM p_logon where id_pers=" . $_SESSION['id'];
            $id_droit = 0;
            $droit_almerys = $c->cnx->query($sqlallow);
            while ($allow = $droit_almerys->fetch()) {
                $id_droit = $allow['id_droit_menu'];
            }

            $menu = '<li><a href="index.php">ACCUEIL |</a></li>';
            


            //$menu .= '<li><a href="cons.php"><blink>CONSIGNES</blink> |</a></li>';
            //$menu .= '<li><a  onclick ="loadPhp(\'ri.php\', \'content_centre\');" href="#">Reglement Interieur |</a></li>';
            
            if ($_SESSION['id_droit'] == 2 || $_SESSION['id_droit'] == 3 || $_SESSION['id_droit'] == 5 || $_SESSION['id_droit'] == 4 || $_SESSION['id_droit'] == 7) {
                
                $menu .= '<li><a  data-toggle="dropdown" class="dropdown-toggle" href="http://10.128.2.3/redmine" title="SMQ">SMQ<b class="caret"></b> |</a>
				<ul class="dropdown-menu"><li><a href="http://smq.easytech.mg/login?"  target="_blank" title="Gestion de ticket Redmine">G-NC</a></li>
				<li><a href="http://doc.easytech.mg/share/page/"  target="_blank" title="Gestion Documentaire Alfresco">G-DOC</a></li>
				</ul>
				</li>';

				$menu .= '<li><a href="visu.php">PLAN2D |</a></li>';
                $menu .= '<li><a href="Dossier.php">DOSSIER |</a></li>';
                $menu .= '<li><a href="lot.php">LOT |</a></li>';
                $menu .= '<li><a href="plan.php">SUIVI |</a></li>';
                $menu .= '<li><a href="rapp.php">REPORTING |</a></li>';

                //$menu .= '<li><a href="listesary.php">Gallery |</a></li>';
			}
                $menu .= '<li>
				<a   data-toggle="dropdown" class="dropdown-toggle" id="ldtING" href="#">POINTAGES<b class="caret"></b> |</a>
					<ul class="dropdown-menu">
					<li><a href="pt.php">LISTES</a></li>';
					if (array_key_exists($_SESSION['id'], $arrayAllowedMatricul)) {
						$menu .= '<li><a  id="ldtING" href="pointage.php">MANUELLE</a></li>';
					}					
				  $menu .= '</ul>
				</li>';
            
			$menu .= '<li><a href="ldt.php" ">LIGNE DE TEMPS |</a></li>';
            
            
			$menu .= '<li><a href="neocles/index.php">NEOCLES |</a></li>';

            $menu .= '<li><a  data-toggle="dropdown" class="dropdown-toggle" href="http://10.128.2.3/redmine" title="ALMERYS">ALMERYS<b class="caret"></b> |</a>
				<ul class="dropdown-menu"><li><a href="interial.cq.php">INTERIAL </a></li>';
            if ($id_droit == 3 || $id_droit == 2 || $id_droit == 1 || $_SESSION['id_droit'] == 4) {
                $menu .= '<li><a href="almerys.cq.php">CQ-ALMERYS </a></li>';
            }
            if ($id_droit==2 || $id_droit==3) {
                $menu .= '<li><a href="Almerys.user.php">USER ADMIN </a></li>';
            }
			$menu .= '</ul>';
			
			
            $menu .= '<li><a href="dec.php">D&eacute;connexion</a></li>';
            echo $menu;
        } else {
            $menu = '';
            $menu .= '<li><a href="#"  id="logIN"><BLINK>CONNEXION</BLINK></a></li>';
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


