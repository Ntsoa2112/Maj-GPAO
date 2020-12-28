<?php
// AUT Mirah RATAHIRY
// DES page ligne de temps de tous les dossiers
// DAT 2012 03 06

	include_once('header.inc.php');
	
	include_once('php/common.php');


	$date_du_jour = date("d/m/Y");
	$ajax = "ajaxMahaSup";
	$c = new Cnx();

	$date = $c->GetDateHistorique();
	$numero_ticket = $c->GetTicketHistorique();
	$matricul = $c->GetMatricul();

?>

<div id="mcorps">
	<div id="head">

	</div>
	
	<div id="content">

		<center>
			<h1>SUIVI</h1>	
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
								<span>Numero ticket</span><br /><br />
                                    <select  id="numTicketSelect">
                                        <option value=""></option>
                                    <?php
                                    echo $numero_ticket;
                                    ?>
                                    </select> 
								</td>

								<td>
								<span>Matricule</span><br /><br />
								<select  id="matriculSelect"><option value=""></option>
								<?php
								echo $matricul;
								?>
								</select>
								</td>


								<td>
								<span>Action</span><br /><br />
                                    <select  id="actionSelect">
                                        <option value=""></option>
                                        <option value="insertion">Insertion</option>
                                        <option value="modification">Modification</option>
                                        <option value="suppression">Suppression</option>
                                    </select>                                                                
								</td>

								<td>
								<span>Type</span><br /><br />
                                    <select  id="typeSelect">
					     <option value=""></option>
					     				<option value="appel">APPEL</option>
                                        <option value="helpdesk">HELPDESK</option>
                                        <option value="supervision">SUPERVISION</option>

                                    </select>                                                                
								</td>

								<td><input type="button" id="rechercheSelect"  value="Recherche" title="rechercheSelect" class="" /></td>
							</tr>

								<!--ONGLETT RECHERCHE TERMINE-->
								
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
<script language="javascript" type="text/javascript" src="js/suivi.js"></script>

</html>

