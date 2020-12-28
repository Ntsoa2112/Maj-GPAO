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
		
		<?php
        	$ajax = "ajaxMaha";
			$date = $c->GetDateAppel();
			$Societe = $c->GetSocieteAppel();
			$Interlocuteur = $c->GetInterlocuteurAppel();
			$Intervenant = $c->GetIntervenantAppel();
			$Ticket = $c->GetTicketAppel();
			$type = $c->GetTypeAppel();
			$comportement = $c->GetComportementAppel();

			?>
			<center>
			<h1>APPEL</h1>
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
								<span>Societe</span><br /><br />
                                    <select  id="societeSelect">
                                        <option value=""></option>
                                    <?php
                                    echo $Societe;
                                    ?>
                                    </select> 
								</td>

								<td>
								<span>Interlocuteur</span><br /><br />
								<select  id="interlocuteurSelect"><option value=""></option>
								<?php
								echo $Interlocuteur;
								?>
								</select>
								</td>


								<td>
								<span>Intervenant</span><br /><br />
                                    <select  id="intervenantSelect">
                                        <option value=""></option>
                                    <?php
                                    echo $Intervenant
                                    ?>
                                    </select>                                                                
								</td>
								
								<td>	
								<span>Ticket</span><br /><br />
                                    <select  id="ticketSelect">
                                        <option value=""></option>
                                    <?php
                                    echo $Ticket;
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
										<span>Date</span><br/><br/>
										<input type="text" name="date" id="date_arrivee" placeholder="Date" />
										</td>

										<td>
										<span>Heure</span><br/><br/>
										<input type="text" name="heure"  id="heure" placeholder="Heure d'appel" class = "heure"/>
										</td>

										<td>
										<span>Dur&eacute;e</span><br/><br/>
										<input type="text" name="duree"  id="duree" placeholder="Format hh:mm:ss" class = "duree"/>
										</td>

										<td>
										<span>Societe</span><br/><br/>
										<input type="text" name="societe"  id="societe" placeholder="Société" />
										</td>

										<td>
										<span>Interlocuteur</span><br/><br/>
										<input type="text" name="interlocuteur"  id="interlocuteur" placeholder="Interlocuteur"/>
										</td>

										<td ROWSPAN=2 id = "cadreBouton">
											<p class="imageok"><input id="valider" type="submit" NAME="nom" VALUE="Enregistrer"></p>
										</td>

									</tr>

									<tr>
										
										<td>
										<span>Ticket</span><br/><br/>
										<input type="text" name="ticket"  id="ticket" placeholder="Numero du ticket" />
										</td>

										<td>
										<span>Type<a href="paramAppel.php?type=type"><img src="img/modif.png" alt="Modif"></a></span><br/><br/>
										<!--<input type="text" name="type"  id="type" placeholder="Type" />-->
										<select  id="type">
	                                        <option value=""></option>
											<?php echo $type; ?>
											</select>
										</td>

										<td>
										<span>Comportement<a href="paramAppel.php?type=comportement"><img src="img/modif.png" alt="Modif"></a></span><br/><br/>
										<!--<input type="text" name="comportement"  id="comportement" placeholder="Comportement" />!-->
										<select  id="comportement">
	                                        <option value=""></option>
											<?php echo $comportement; ?>
										</select>
										</td>


										<td>
										<span>Intervenant</span><br/><br/>
										<input type="text" name="intervenant"  id="intervenant" placeholder="Intervenant"/>
										</td>

										<td>
										<span>Description</span><br/><br/>
										<input type="text" name="description"  id="description" placeholder="Description inf&eacute;rieur a 100 caracteres"/>
										
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
<script language="javascript" type="text/javascript" src="js/ajaxAppel.js"></script>
<script language="javascript" type="text/javascript" src="js/traitementMaha.js"></script>

</html>

<?php }

//PAGE POUR DIRE QU'il n'y a pas d'accès
else{ 
	include_once("error.php");
}?>

