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

	if(/*in_array($_SESSION['id'], $autorises)*/true){

?>

<div id="mcorps">
	<div id="head">

		<?php

		?>
	</div>

	<div id="content">

		<?php
        	$ajax = "ajaxMaha";
			$dateDebut = $c->GetDateDbt();
			//$dateFin = $c->GetDateFinDistinct();
			$Intervenant = $c->GetIntervenant(-1);

			?>
		<center>
			<h1>Tickets par Intervenant</h1>
			<div id="content_centre">
				<table>
					<tr class="tb_header">
						<td  class="tb_header">
							<div>
								<table id="ldtHead">
									<tr>
										<td>
											<span>Date Debut</span>
											<br />
											<br />
											<select  id="dateDebut">
												<option value=""/>
												<?php
								echo $dateDebut;
								?>
											</select>
										</td>

										<td>								
											<span>Date Fin</span>
											<br />
											<br />
											<select  id="dateFin">
												<option value=""/>
												<?php
                                    echo $dateDebut;
                                    ?>
											</select> 
										</td>


										<td>
											<span>Intervenant</span>
											<br />
											<br />
											<select  id="intervenant">
												<option value=""/>
												<?php
                                    echo $Intervenant
                                    ?>
											</select>                                                                
										</td>

										<td>
											<input type="button" id="rechercheSelect"  value="Recherche" title="rechercheSelect" class="" />
										</td>
									</tr>
								</table>
							</div>
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
</div>
</body>


<script language="javascript" type="text/javascript" src="js/jquery.js" ></script>
<script language="javascript" type="text/javascript" src="js/ticketParIntervenant.js"></script>
<!--<script language="javascript" type="text/javascript" src="js/traitementMaha.js"></script>-->

</html>

<?php }

//PAGE POUR DIRE QU'il n'y a pas d'accès
else{ 
	include_once("error.php");
}?>

