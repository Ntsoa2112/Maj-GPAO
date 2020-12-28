<?php
// AUT Mirah RATAHIRY
// DES page ligne de temps de tous les dossiers
// DAT 2012 03 06

	include_once('header.inc.php');

	include_once('php/common.php');
?>

<div id="mcorps">
	<div id="head">
	
		<?php

		?>
	</div>
	
	<div id="content">
		<center>
			<h1>REPORTING EXPORT MADA</h1>		
			<?php
				$c = new Cnx();

				$strDateDbt = $c->GetDateDbt();
				$strDateFin = $c->GetDateFin();
				$strIntervenant = $c->GetIntervenant(-1);
				$strStatut = $c->GetStatut();
				$strTicket = $c->GetTicket(-1);
				
				$strSujet = $c->GetSujet();
				/*$strSujet = "";
				
				foreach	($listSujet as $sujet)
				{
					$strSujet .= '<option value="'.$sujet.'">'.$sujet.'</option>';
				}*/				
				
				$strBeneficiaire = $c->GetBeneficiaire(-1);
				$strDemandeur = $c->GetDemandeur(-1);
				$strTypeAction = $c->GetTypeAction();
			?>
		<div id="content_centre">
			
				<table>
					<tr class="tb_header">
						<td  class="tb_header">
						<div>
							<table id="ldtHead">
							<tr>
							<td>
								<span>Debut</span><br /><br />
								<select  id="jour"><option value=""></option>
								<?php
								echo $strDateDbt;
								?>
								</select>
								</td><td>
								<span>Fin</span><br /><br />
								<select  id="fin"><option value=""></option>
								<?php
								echo $strDateDbt;
								?>
								</select>
								
								<td>
								<span>Intervenant</span><br /><br />
                                                                    <select  id="idIntervenant">
                                                                        <option value=""></option>
                                                                    <?php
                                                                    echo $strIntervenant;
                                                                    ?>
                                                                    </select>                                                                
								</td><td>
									
								<span>Ticket</span><br /><br />
                                                                    <select  id="idTicket">
                                                                        <option value=""></option>
                                                                    <?php
                                                                    echo $strTicket;
                                                                    ?>
                                                                    </select>                                                                
								</td><td>								
								<span>Statut</span><br /><br />
                                                                    <select  id="statut">
                                                                        <option value=""></option>
                                                                    <?php
                                                                    echo $strStatut;
                                                                    ?>
                                                                    </select> 
								</td><td>									
								<span>Choix de dossier</span>
								<br /><br />
									<select  id="dossier" onchange="document.getElementById('GetStats').click();">
										<option value="par_type_action">type action</option>																	
										<option value="par_statut">statut</option>																		
										<option value="par_sujet">sujet</option>																																				
									</select>
									
								</td>
							</tr>
							<tr><td COLSPAN=3>
								<span>Sujet</span><br /><br />
									<select  id="sujet">
										<option value=""></option>
											<?php
												echo $strSujet;
											?>
									</select>  							
							</td>
							<td COLSPAN=2>
								<span>Beneficiaire</span><br /><br />
									<select  id="beneficiaire">
										<option value=""></option>
											<?php
												echo $strBeneficiaire;
											?>
									</select> 							
							</td>
							<td>
								<span>Résolution en ligne</span><br />
									<select  id="resolution_en_ligne">
										<option value=""></option>
										<option value="OUI">OUI</option>
										<option value="NON">NON</option>										
									</select> 							
							</td>							
							
							</tr>
													
							<tr>
								<td  style="text-align:center" COLSPAN=3>
									<table>
										<tr><td><input type="radio" name="choixReport" id="choixReport1" value="1" checked=""/></td><td>REPORTING CLASSIQUE</td></tr>
										<tr><td><input type="radio" name="choixReport" id="choixReport2" value="2" /></td><td>ACTIONS SUR LES TICKETS</td></tr>
										<tr><td><input type="radio" name="choixReport" id="choixReport3" value="3" /></td><td>SUJETS SUR LES TICKETS</td></tr>
										<tr><td><input type="radio" name="choixReport" id="choixReport4" value="4" /></td><td>STATUTS SUR LES TICKETS</td></tr>
										<tr><td><input type="radio" name="choixReport" id="choixReport5" value="5" /></td><td>INTERVENANTS</td><td><input type="checkbox" name="checkChoixTypeSujet" id="checkChoixTypeSujet"/> Demandes</td></tr>
										<tr><td><input type="radio" name="choixReport" id="choixReport6" value="6" /></td><td>Analyse par heures</td>
										
									</table>								
								</td>
								<td COLSPAN=4>
									<span>Demandeur</span><br /><br />
										<select  id="demandeur">
											<option value=""></option>
												<?php
													echo $strDemandeur;
												?>
										</select> 								
								</td>
							</tr>									

							<tr>
								<td  style="text-align:center" COLSPAN=3>
									<span> </span>
									<span></span>
									<input type="button" id=""  value="Lancer" title="GetStats" class="" 
									onclick="if(document.getElementById('choixReport1').checked)document.getElementById('GetStats').click();
									else if(document.getElementById('choixReport2').checked)document.getElementById('GetActionTickets').click();
									else if(document.getElementById('choixReport3').checked)document.getElementById('GetSujetsTickets').click();
									else if(document.getElementById('choixReport4').checked)document.getElementById('GetStatutsTickets').click();
									else if(document.getElementById('choixReport5').checked)document.getElementById('GetIntervenantTickets').click();
									else if(document.getElementById('choixReport6').checked)document.getElementById('GetAnalyseParHeure').click();"/>
									
									<input type="submit" id="GetStats"  value="Lancer" title="GetStats" class="" style="display:none"/>									
									<input type="submit" id="GetActionTickets"  value="Lancer" title="GetStats" class="" style="display:none"/>
									<input type="submit" id="GetSujetsTickets"  value="Lancer" title="GetStats" class="" style="display:none"/>
									<input type="submit" id="GetStatutsTickets"  value="Lancer" title="GetStats" class="" style="display:none"/>
									<input type="submit" id="GetIntervenantTickets"  value="Lancer" title="GetStats" class="" style="display:none"/>
									<input type="submit" id="GetAnalyseParHeure"  value="Lancer" title="GetStats" class="" style="display:none"/>
									
								</td>
								<td COLSPAN=4>
									<span>Type d'action</span><br /><br />
										<select  id="type_action">
											<option value=""></option>
												<?php
													echo $strTypeAction;
												?>
										</select> 								
								</td>
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
<script language="javascript" type="text/javascript" charset="utf-8">

	//about:config
	//signed.applets.codebase_principal_support;true
	
// AUT Mirah RATAHIRY
// DES page ligne de temps de tous les dossiers
// DAT 2012 03 06
	
	var theHandle = document.getElementById("handle");
	var theRoot   = document.getElementById("root");
	Drag.init(theHandle, theRoot);
	
	
	$(document).ready(function() 
	{
		$('#mcorps').on('click', '.th', function () {
			goLdt(this.id);
		});
	});
	
	
	$("#goLdt").click(function(){
		goLdt("");
	});

	function deleteLdt(str)
	{
		$.ajax({
		type: "GET",
		url: "php/link.php?action=delLdt&id="+str,
			success: function(msg){
				goLdt("");
			}
		});
	}
	
	$("#GetStats").click(function(){
		var idIntervenant = ($("#idIntervenant").val() == undefined)?'':$("#idIntervenant").val();
		var idTicket = ($("#idTicket").val() == undefined)?'':$("#idTicket").val();
		var jour = ($("#jour").val() == undefined)?'':$("#jour").val();
		var sujet = ($("#sujet").val() == undefined)?'':$("#sujet").val();		
		var statut = ($("#statut").val() == undefined)?'':$("#statut").val();		
		var dateFin = ($("#fin").val() == undefined)?'':$("#fin").val();		
		var dossier = ($("#dossier").val() == undefined)?'':$("#dossier").val();		
		var beneficiaire = ($("#beneficiaire").val() == undefined)?'':$("#beneficiaire").val();		
		var demandeur = ($("#demandeur").val() == undefined)?'':$("#demandeur").val();				
		var resolution_en_ligne = ($("#resolution_en_ligne").val() == undefined)?'':$("#resolution_en_ligne").val();
		
		$("#ldtCorp").html('<div class="body" id="Etape"><img src = "img/ramiLoad.gif" width="50px"/>Loading ...</div>');
		$.ajax({
		type: "GET",
		url: "php/link.php?action=GetStats&idIntervenant="+idIntervenant+"&idTicket="+idTicket+"&jour="+jour+"&sujet="+sujet+"&statut="+statut+"&dateFin="+dateFin+"&dossier="+dossier+"&beneficiaire="+beneficiaire+"&demandeur="+demandeur+"&resolution_en_ligne="+resolution_en_ligne+"&type_action="+type_action+"&choix="+'',
			success: function(msg){
				//alert(msg);
				$("#ldtCorp").html(msg);
			}
		});
	});	
	
	$("#GetAnalyseParHeure").click(function(){
		var jourDbt = ($("#jour").val() == undefined)?'':$("#jour").val();
		var jourFin = ($("#fin").val() == undefined)?'':$("#fin").val();		
		
		$("#ldtCorp").html('<div class="body" id="Etape"><img src = "img/ramiLoad.gif" width="50px"/>Loading ...</div>');
		$.ajax({
		type: "GET",
		url: "php/link.php?action=GetAnalyseParHeure&jourDbt="+jourDbt+"&jourFin="+jourFin,
			success: function(msg){
				//alert(msg);
				$("#ldtCorp").html(msg);
			}
		});
	});		
	
	$("#GetStatutsTickets").click(function(){
		var jour = ($("#jour").val() == undefined)?'':$("#jour").val();		
		var dateFin = ($("#fin").val() == undefined)?'':$("#fin").val();		
		
		$("#ldtCorp").html('<div class="body" id="Etape"><img src = "img/ramiLoad.gif" width="50px"/>Loading ...</div>');
		$.ajax({
		type: "GET",
		url: "php/link.php?action=GetStatutsTickets&jour="+jour+"&dateFin="+dateFin,
			success: function(msg){
				//alert(msg);
				$("#ldtCorp").html(msg);
			}
		});
	});	

	$("#GetIntervenantTickets").click(function(){
		var jour = ($("#jour").val() == undefined)?'':$("#jour").val();		
		var dateFin = ($("#fin").val() == undefined)?'':$("#fin").val();
		var choix = '';
		
		if(document.getElementById('checkChoixTypeSujet').checked){
			choix = 'demandes';
		}				
		
		$("#ldtCorp").html('<div class="body" id="Etape"><img src = "img/ramiLoad.gif" width="50px"/>Loading ...</div>');
		$.ajax({
		type: "GET",
		url: "php/link.php?action=GetIntervenantTickets&jour="+jour+"&dateFin="+dateFin+"&choix="+choix,
			success: function(msg){
				//alert(msg);
				$("#ldtCorp").html(msg);
			}
		});
	});	
	
	
	$("#GetActionTickets").click(function(){
		var jour = ($("#jour").val() == undefined)?'':$("#jour").val();		
		var dateFin = ($("#fin").val() == undefined)?'':$("#fin").val();		
		
		$("#ldtCorp").html('<div class="body" id="Etape"><img src = "img/ramiLoad.gif" width="50px"/>Loading ...</div>');
		$.ajax({
		type: "GET",
		url: "php/link.php?action=GetActionTickets&jour="+jour+"&dateFin="+dateFin,
			success: function(msg){
				//alert(msg);
				$("#ldtCorp").html(msg);
			}
		});
	});		
	
	$("#GetSujetsTickets").click(function(){
		var jour = ($("#jour").val() == undefined)?'':$("#jour").val();		
		var dateFin = ($("#fin").val() == undefined)?'':$("#fin").val();		
		
		$("#ldtCorp").html('<div class="body" id="Etape"><img src = "img/ramiLoad.gif" width="50px"/>Loading ...</div>');
		$.ajax({
		type: "GET",
		url: "php/link.php?action=GetSujetsTickets&jour="+jour+"&dateFin="+dateFin,
			success: function(msg){
				//alert(msg);
				$("#ldtCorp").html(msg);
			}
		});
	});			
	
	$("#GetNbTycketByActionType").click(function(){
		var idIntervenant = ($("#idIntervenant").val() == undefined)?'':$("#idIntervenant").val();
		var jour = ($("#jour").val() == undefined)?'':$("#jour").val();

		
		
		$("#ldtCorp").html('<div class="body" id="Etape"><img src = "img/ramiLoad.gif" width="50px"/>Loading ...</div>');
		$.ajax({
		type: "GET",
		url: "php/link.php?action=GetNbTycketByActionType&idIntervenant="+idIntervenant+"&jour="+jour,
			success: function(msg){
				alert(msg);
				$("#ldtCorp").html(msg);
			}
		});
	});
	
	$("#GetNbTycketSujet").click(function(){
		var idIntervenant = $("#idIntervenant").val();
		var jour = $("#jour").val();

		
		$("#ldtCorp").html('<div class="body" id="Etape"><img src = "img/ramiLoad.gif" width="50px"/>Loading ...</div>');
		$.ajax({
		type: "GET",
		url: "php/link.php?action=GetNbTycketByActionType&idIntervenant="+idIntervenant+"&jour="+jour,
			success: function(msg){
				alert(msg);
				$("#ldtCorp").html(msg);
			}
		});
		
		
	});
	
	function deleteReport(str)
	{
		$.ajax({
		type: "GET",
		url: "php/link.php?action=deleteReport&id="+str,
			success: function(msg){
				//goLdt("");
			}
		});
	}

	$("#copyLdt").click(function(){
		var textValue = new String(($("#ldtCorp").html()));
		copyToClipboard(html2Str(textValue));
	});
	
	function getLstEtape(idDossier)
	{
		$.ajax({
		type: "GET",
		url: "php/link.php?action=getLstEtape&doss="+idDossier,
			success: function(msg){
				$("#etape").html(msg);
			}
		});
	}
	
	function html2Str(str)
	{
		var tab=new RegExp("</td><td>","g");
		var ret=new RegExp("</td></tr><tr><td>","g");
		var reg=new RegExp(" class=\"classe[0-9]\"","g");
		var id=new RegExp(" id=\"[0-9]+\"","g");
		var id2=new RegExp("><td>","g");
		var id3=new RegExp("</td></tr><tr","g");
		var id4=new RegExp("</td><td onclick=\"updateLdtForm\\('[0-9]+'\\)\" class=\"edit\">", "g");
		var id5=new RegExp("</th><th>","g");
		var id6=new RegExp("<table><thead><tr><th>","g");
		var id7=new RegExp("</th></tr></thead>","g");
		
		str = str.replace(id, "\n");

		str = str.replace(reg, "").replace(" class=\"rapport\"", "");
		str = str.replace(tab, "\t");
		str = str.replace(ret, "\n");
		str = str.replace("<table><tbody><tr><td>", "");
		str = str.replace("</td></tr></tbody></table>", "");
				str = str.replace(id2, "");
		str = str.replace(id3, "");
		str = str.replace(id4, "");

		str = str.replace(id5, "\t");
		str = str.replace("<tbody><tr", "");
		str = str.replace(id6, "");
		str = str.replace(id7, "");	
		//alert (str);
		return str;
	}
	function copyToClipboard(meintext) {  
		if (window.clipboardData)   
			 window.clipboardData.setData("Text", meintext);  
		else if (window.netscape) {  
			 netscape.security.PrivilegeManager.enablePrivilege('UniversalXPConnect');  
			 var clip = Components.classes['@mozilla.org/widget/clipboard;1'].createInstance(Components.interfaces.nsIClipboard);  
			 if (!clip)  
				  return false;  
			 var trans = Components.classes['@mozilla.org/widget/transferable;1'].createInstance(Components.interfaces.nsITransferable);  
			 if (!trans)  
				  return false;  
			 trans.addDataFlavor('text/unicode');  
			 var str = new Object();  
			 var len = new Object();  
			 var str = Components.classes["@mozilla.org/supports-string;1"].createInstance(Components.interfaces.nsISupportsString);  
			 str.data=meintext;  
			 trans.setTransferData("text/unicode",str,meintext.length*2);  
			 var clipid=Components.interfaces.nsIClipboard;  
			 if (!clipid)  
				  return false;  
			 clip.setData(trans,null,clipid.kGlobalClipboard);  
		}  
			 return false;  
	}
	function updateLdtForm(id)
	{
		
		$.ajax({
		type: "GET",
		url: "php/link.php?action=getLdt&id="+id,
			success: function(msg){
				if(msg=="") return;
				else
				{
					var tk = msg.split('|');
					
					var strHTML = "" ;
					strHTML += "<table style=\"margin-top: 20px;margin-left: 7px;\">" ;
					strHTML += "<tr><td valign=\"top\">Statut : </td><td><select  class=\"sel\" id=\"STAT\"><option  value=''></option><option  value='1'>EN COURS</option><option  value='2'>TERMINE</option></select></td></tr>";
					strHTML += "<tr><td valign=\"top\">Date Deb : </td><td><input type=\text\" id=\"dDeb\"  class=\"sel\" value ="+tk[9]+" ></td></tr>" ;
					strHTML += "<tr><td valign=\"top\">Date Fin : </td><td><input type=\text\" id=\"dFin\"  class=\"sel\" value ="+tk[10]+" ></td></tr>" ;
					strHTML += "<tr><td valign=\"top\">Heure Deb : </td><td><input type=\text\" id=\"hDeb\"  class=\"sel\"  value ="+tk[2]+" ></td></tr>" ;					
					strHTML += "<tr><td valign=\"top\">Heure Fin : </td><td><input type=\text\" id=\"hFin\"  class=\"sel\" value ="+tk[3]+" ></td></tr>" ;
					strHTML += "<tr><td valign=\"top\">Quantite : </td><td><input type=\text\" id=\"qt\"  class=\"sel\"  value ="+tk[4]+" ></td></tr>" ;
					strHTML += "<tr><td valign=\"top\">Nb Erreur : </td><td><input type=\text\" id=\"err\"  class=\"sel\"  value ="+tk[5]+" ></td></tr>" ;
					strHTML += "<tr><td valign=\"top\">Comment : </td><td><input type=\text\" id=\"com\"  class=\"sel\"  value ="+tk[11]+" ></td></tr>" ;
					
					strHTML += "<tr><td colspan=\"2\"><br /><center><input id=\"modifier\" type=\"button\" value=\"Annuler\" onclick=\"document.getElementById(\'root\').style.display = 'none' ;\"><input type=\"button\" value=\"Modifier\" onclick=\"updateLdt("+id+");\"></center></td></tr></table>" ;
					
					document.getElementById('root').style.display = "block" ;
					document.getElementById('root').style.height = "325px" ;
					document.getElementById('root').style.width = "300" ;
					document.getElementById('root').style.left = "70px" ;
					document.getElementById('root').style.top = "8px" ;
					document.getElementById('divflottant').innerHTML = strHTML;
					document.getElementById('handle').innerHTML = '<div id=\"handleTtl\" style=\"text-align: center\">'+tk[7]+" | "+tk[0]+" | "+tk[1]+'</div><img src="img/cl.png" style="float: right; margin-right: 5px;clear: none;margin-top: -25px; position: relative;" onclick="document.getElementById(\'root\').style.display = \'none\' ;">' ;

					if (tk[6] == 'EN COURS')
					{					
						$( '#STAT option[value="1"]').attr('selected', 'true');
					}
					else $( '#STAT option[value="2"]').attr('selected', 'true');
				}
			}
		});
		
	}
	
	function updateLdt(id)
	{
		var deb = $("#hDeb").val();
		var fin = $("#hFin").val();
		var qt = $("#qt").val();
		var err = $("#err").val();
		var stat = $("#stat").val();
		var dDeb  = $("#dDeb").val();
		var dFin  = $("#dFin").val();
		var com = $("#com").val();
		
		 if (!isHeureValid(deb))
		 {
			alert("heure debut invalide!");
			return;		 
		 }
		
		if (!isHeureValid(fin))
		 {
			alert("heure fin invalide!");
			return;		 
		 }
		
		
		if (fin != "" && fin.replace(new RegExp("/", "g"), "") < deb.replace(new RegExp("/", "g"), ""))
		{
			alert("l'heure fin doit etre supperieur a l'heure de debut!");
			return;
		}
		if (dFin != "" && dFin < dDeb)
		{
			alert("la date fin doit etre supperieur a la date debut!");
			return;
		}
		if (deb=="")
		{
			alert("Heure debut obligatoire!");
			return;
		}
		$.ajax({
		type: "GET",
		url: "php/link.php?action=updateLdt&deb="+deb+"&fin="+fin+"&qt="+qt+"&err="+err+"&stat="+stat+"&id="+id+"&ddeb="+dDeb+"&dfin="+dFin+"&com="+com,
			success: function(msg){
			//alert(msg);
				goLdt("");
				$("#root").hide("slow");
			}
		});
	
	}
	
	function noNullFinLdt()
	{
		$.ajax({
		type: "GET",
		url: "php/link.php?action=noNullFinLdt",async: true,
			success: function(msg){
				alert(msg);
			}
		});
	}
	function isHeureValid(heure)
	{
		if(heure.split(':').length == 3 )return true;
		return false;
	}
	function insertLDT()
	{
		alert($("#PRJ").val());
	}
	function goLdt(orderBy)
	{
		var deb = $("#deb").val();
		var fin = $("#fin").val();
		var doss = $("#doss").val();
		var mat = $("#mat").val();
		var stat = $("#stat").val();
		var dep = $("#dep").val();
		var etape = $("#etape").val();
		
		if (fin != "" && fin.replace(new RegExp("/", "g"), "") < deb.replace(new RegExp("/", "g"), ""))
		{
			alert("la date fin doit etre supperieur a la date debut!");
			return;
		}
		if (deb=="")
		{
			alert("choisissez la date debut!");
			return;
		}
		$("#ldtCorp").html('<div class="body" id="Etape"><img src = "img/ramiLoad.gif" width="50px"/>Loading ...</div>');
		$.ajax({
		type: "GET",
		url: "php/link.php?action=getLstLdt&doss="+doss+"&mat="+mat+"&deb="+deb+"&fin="+fin+"&stat="+stat+"&orderby="+orderBy+"&dep="+dep+"&etape="+etape,
			success: function(msg){
				$("#ldtCorp").html(msg);
			}
		});
	}
	</script>
</html>

