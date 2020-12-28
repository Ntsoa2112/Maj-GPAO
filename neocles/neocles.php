<?php
// AUT Mirah RATAHIRY
// DES page ligne de temps de tous les dossiers
// DAT 2012 03 06

	include_once('header.inc.php');

	include_once('php/common.php');

	$date_du_jour = date("d/m/Y");
	
	$c = new Cnx();
	$autorises = $c->GetAutorises();

	//$autorises = array('551','471','548','412','414','467','485','568','569','570','629','662','663','664');

	if(in_array($_SESSION['id'], $autorises)){

?>

<div id="mcorps">
	<div id="head">
	
		<?php

		?>
	</div>
	
	<div id="content">
		
	<?php /*if(!in_array('page', $_GET))
			{*/
		if($_GET['page'] == "supervision")
		{ 
			$ajax = "ajaxMahaSup";			

			$date = $c->GetDateMahaSup();
			$client = $c->GetClientMahaSup();
			$intervenant = $c->GetIntervenantMahaSup();
			$ticket = $c->GetTicketMahaSup();
			$etat = $c->GetEtatMahaSup();
			$moisAnnee = $c->GetMoisAnneeMaha();

		?>
		
		<!DOCTYPE html>
		<html lang="en">
		<head>
			<meta charset="UTF-8">
			<meta name="viewport" content="width=device-width, initial-scale=1.0">
			<meta http-equiv="X-UA-Compatible" content="ie=edge">

			<title>Document</title>
		</head>
		<body>
		<center>
			
		
			<h1>SUPERVISION</h1>	
		<div id="content_centre">
				<table>
					<tr class="tb_header">
						<td  class="tb_header">
						<div>
							<table id="ldtHead">
							<tr>
							<td>
								<span>Date</span><br /><br />
								<select  id="dateSelect"><option value=""></option>
								<?php
								echo $date;
								?>
								</select>
								</td>
								<td>
								<span>Mois/Années</span><br /><br />
								<select  id="moisSelectSup"><option value=""></option>
									<?php
										echo $moisAnnee;
									?>
								</select>
								</td>
								<td>								
								<span>Etat</span><br /><br />
                                    <select  id="etatSelect">
                                        <option value=""></option>
                                    <?php
                                    echo $etat;
                                    ?>
                                    </select> 
								</td>

								<td>
								<span>Client</span><br /><br />
								<select  id="clientSelect"><option value=""></option>
								<?php
								echo $client;
								?>
								</select>
								</td>


								<td>
								<span>Intervenant</span><br /><br />
                                    <select  id="intervenantSelect">
                                        <option value=""></option>
                                    <?php
                                    echo $intervenant
                                    ?>
                                    </select>                                                                
								</td>
								
								<td>	
								<span>Ticket</span><br /><br />
                                    <select  id="ticketSelect">
                                        <option value=""></option>
                                    <?php
                                    echo $ticket;
                                    ?>
                                    </select>                                                                
								</td>

								<td><input type="button" id="rechercheSelect"  value="Recherche" title="rechercheSelect" class="" /></td>
							</tr>

								<!--ONGLETT RECHERCHE TERMINE-->
							<tr><td COLSPAN = 7 id ="insertionOuModification"><h1 id="titreMaha">INSERTION</h1></td></tr>

							<form action="fichier/traitement.php" method="post" id="formulaire">
								
									<tr>
										<td>
										<span>Date d'arriv&eacute;e:</span><br/><br/>
										<input  type="text" name="date_arrivee" id="date_arrivee" placeholder="Date d' arrivee" required="required" >
										</td>
										
										<td>
										<span>Heure d'arriv&eacute;e: </span><br/><br/>
										<input  type="time" name="heure_arrivee"  id="heure_arrivee" placeholder="Heure d'arrivee" class = "heure" required="required"/>
										</td>

										<td>
										<span>Client: </span><br/><br/>
										<input type="text" name="client"  id="client" placeholder="client" required="required"/>
										</td>

										<td>
										<span>Origine: </span><br/><br/>
										<input  type="text" name="origine"  id="origine" placeholder="origine" required="required"/>
										</td>

										<td>
										<span>Heure de Cr&eacute;ation du ticket: </span><br/><br/>
										<input  type="time" name="heure_creation_ticket"  id="heure_creation_ticket" placeholder="Heure de la création" class = "heure" required="required"/>
										</td>

										<td ROWSPAN=2 COLSPAN = 2 id = "cadreBouton">
											<p class="imageok"><input  id="valider" type="submit" NAME="nom" VALUE="Enregistrer" required="required"></p>
										</td>
										<!-- <td ROWSPAN=2 id = "cadreBouton">
											<p class="imageok"><input  id="valider" type="submit" NAME="nom" VALUE="Enregistrer" required="required"></p>
										</td> -->

									</tr>

									<tr>
										
										<td>
										<span>Numero Ticket: </span><br/><br/>
										<input type="text" name="numero_ticket"  id="numero_ticket" placeholder="numero du ticket" required="required" />
										</td>

										<td>
										<span>Etat: </span><br/><br/>
										<input type="text" name="etat"  id="etat" placeholder="etat" required="required" />
										</td>

										<td>
										<span>Intervenant: </span><br/><br/>
										<input  type="text" name="intervenant"  id="intervenant" placeholder="intervenant" required="required" />
										</td>

										<td colspan = 2>
										<span>Commentaire </span><br/><br/>

										<input type="text" name="commentaire"  id="commentaire" placeholder="Commentaire inf&eacute;rieur a 100 caracteres" required="required"/>
										
										<!--<TEXTAREA name="commentaire" id="commentaire" rows=1 cols=60 >Commentaire inf&eacuterieur a 100 caracteres</TEXTAREA>
										-->
										</td>
									</tr>
								
							</form>
							</table>
						</div>
						</td>
					</tr>
					<tr>
						<td>

						</td>
					</tr>
				</table>
		</div>
		</center>
        </body>
		</html>
        <?php }

        //else {
        else if($_GET['page'] == "helpdesk"){
        	$ajax = "ajaxMaha";

        	//POUR HELPDESK       		

			$date = $c->GetDateMaha();
			$client = $c->GetClientMaha();
			$intervenant = $c->GetIntervenantMaha();
			$ticket = $c->GetTicketMaha();
			$pole = $c->GetPoleMaha();
			$moisAnnee = $c->GetMoisAnneeMaha();

			?>
			<!DOCTYPE html>
			<html lang="en">
			<head>
				<meta charset="UTF-8">
				<meta name="viewport" content="width=device-width, initial-scale=1.0">
				<meta http-equiv="X-UA-Compatible" content="ie=edge">
				<title>Document</title>
			</head>
			<body>
				
			
			<center>
			<h1>MAILS</h1>
			<div id="content_centre">
				<table>
					<tr class="tb_header">
						<td  class="tb_header">
						<div>
							<table id="ldtHead">
							<tr>
							<td>
								<span>Date</span><br /><br />
								<select  id="dateSelect"><option value=""></option>
								<?php
								echo $date;
								?>
								</select>
							</td>
							<td>
								<span>Mois/Années</span><br /><br />
								<select  id="moisSelect"><option value=""></option>
									<?php
										echo $moisAnnee;
									?>
								</select>
							</td>
							<td>								
								<span>Pole</span><br /><br />
                                    <select  id="poleSelect">
                                        <option value=""></option>
                                    <?php
                                    echo $pole;
                                    ?>
                                    </select> 
							</td>

							<td>
								<span>Client</span><br /><br />
								<select  id="clientSelect"><option value=""></option>
								<?php
								echo $client;
								?>
								</select>
							</td>


							<td>
								<span>Intervenant</span><br /><br />
                                    <select  id="intervenantSelect">
                                        <option value=""></option>
                                    <?php
                                    echo $intervenant
                                    ?>
                                    </select>                                                                
							</td>
								
							<td>	
								<span>Ticket</span><br /><br />
                                    <select  id="ticketSelect">
                                        <option value=""></option>
                                    <?php
                                    echo $ticket;
                                    ?>
                                    </select>                                                                
							</td>

								<td><input type="button" id="rechercheSelect"  value="Recherche" title="rechercheSelect" class="" /></td>
							</tr>

								<!--ONGLETT RECHERCHE TERMINE-->
							<tr><td COLSPAN = 6 id ="insertionOuModification"><h1 id="titreMaha">INSERTION</h1></td></tr>

							<form action="fichier/traitement.php" method="post" id="formulaire">
								
									<tr>
										<td>
										<span>Date d'arriv&eacute;e:</span><br/><br/>
										<input  type="text" name="date_arrivee" id="date_arrivee" placeholder="Date d'arrivee" required="required" />
										</td>
										
										<td>
										<span>Heure d'arriv&eacute;e: </span><br/><br/>
										<input  type="time" name="heure_arrivee"  id="heure_arrivee" placeholder="Heure d'arrivee" class = "heure" required="required"/>
										</td>

										<td>
										<span>Client: </span><br/><br/>
										<input  type="text" name="client"  id="client" placeholder="client" required="required" />
										</td>

										<td>
										<span>Demandeur: </span><br/><br/>
										<input  type="text" name="demandeur"  id="demandeur" placeholder="demandeur" required="required" />
										</td>

										<td>
										<span>Heure de Cr&eacute;ation du ticket: </span><br/><br/>
										<input  type="time" name="heure_creation_ticket"  id="heure_creation_ticket" placeholder="Heure de la création" class = "heure" required="required"/>
										</td>

										<td ROWSPAN=2 id = "cadreBouton">
											<p class="imageok"><input id="valider" type="submit" NAME="nom" VALUE="Enregistrer"></p>
										</td>

									</tr>

									<tr>
										
										<td>
										<span>Numero Ticket: </span><br/><br/>
										<input type="text" name="numero_ticket"  id="numero_ticket" placeholder="numero du ticket" required="required" />
										</td>

										<td>
										<span>Pole actuel: </span><br/><br/>
										<input  type="text" name="pole_actuel"  id="pole_actuel" placeholder="pole actuel" required="required" />
										</td>

										<td>
										<span>Intervenant: </span><br/><br/>
										<input  type="text" name="intervenant"  id="intervenant" placeholder="intervenant" required="required" />
										</td>

										<td colspan = 2>
										<span>Commentaire </span><br/><br/>

										<input type="text" name="commentaire"  id="commentaire" placeholder="Commentaire inf&eacute;rieur a 100 caracteres" required="required"/>
										
										<!--<TEXTAREA name="commentaire" id="commentaire" rows=1 cols=60 >Commentaire inf&eacuterieur a 100 caracteres</TEXTAREA>
										-->
										</td>
									</tr>
								
							</form>
							</table>
						</div>
						</td>
					</tr>
					<tr>
						<td>

						</td>
					</tr>
				</table>
		</div>
		</center>
		</body>
			</html>

		<?php }

		?>

        <center>
        	
                    <div>
								<div id="ldtCorp">
								<?php
									
								?>
															
								</div>
								
                    </div>  		
		</center>
          
	</div>
	<?php
		//include('footer.php');
	?>

</div>
<div id="root">
		<div id="handle"></div>
		<div id="divflottant"></div>
</div>
</body>

<script language="javascript" type="text/javascript" src="js/jquery.js"></script>

<?php
	if($_GET['page'] == "helpdesk"){
		echo '<script language="javascript" type="text/javascript" src="js/ajaxMaha.js"></script>';
	}
	else if($_GET['page'] == "supervision"){
		echo '<script language="javascript" type="text/javascript" src="js/ajaxMahaSup.js"></script>';
	}
?>

<script language="javascript" type="text/javascript" src="js/traitementMaha.js"></script>

</html>

<?php }

//PAGE POUR DIRE QU'il n'y a pas d'accès
else{ 
	include_once("error.php");
}?>

