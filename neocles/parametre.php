<?php
// AUT Mirah RATAHIRY
// DES page ligne de temps de tous les dossiers
// DAT 2012 03 06

	include_once('header.inc.php');
	
	include_once('php/common.php');


	$date_du_jour = date("d/m/Y");
	$ajax = "ajaxMahaSup";
	$c = new Cnx();

	$utilisateur = $c->GetUtilisateur();

?>

<div id="mcorps">
	<div id="head">

	</div>
	
	<div id="content">

		<center>
			<h1>PARAMETRE</h1>	
		<div id="content_centre">
				
				<table>
					<tr class="tb_header">
						<td  class="tb_header">
						<div>
							<table id="ldtHead">
							<tr>
							
								<td>
								<span>MATRICULE</span><br /><br />
                                    <input type="text" name="matricul"  id="matricul"  class = "heure"/>                                                             
								</td>

								<td><input type="button" id="Add"  value="Ajouter" title="Add" class="" /></td>
							</tr>

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
									echo $utilisateur;
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
<script language="javascript" type="text/javascript" src="js/parametre.js"></script>


</html>

