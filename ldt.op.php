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
			include('baniR.php');
			include('headMen.php');
			if ((isset($_SESSION['error_msg'])) && (!empty($_SESSION['error_msg'])))
				{
					echo $_SESSION['error_msg'].'<br>';
				}
		?>
	</div>
	
	<div id="content">
		<center>
			<?php
				$c = new Cnx();

				$strDate = $c->getDatePt();
			?>
		<div id="content_centre">
<div id="graphe_heure" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
<div id="graphe_vitesse" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
<div id="graphe_quantite" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
								<div id="ldtCorp">
								<?php
									//if($_SESSION['id_droit']==1)
									{
										$idPers = $_SESSION['id'];
										$idPers = 597;
										$date = date("Ymd");
										
										$dateJmoins1 = ($date-6).",".$date;

										echo  ($dateJmoins1);
										
										//return;

										echo '<h1 class="titre_tableau">Repartition par type</h1><hr/>';
										echo $c->suiviHeureOP($date, '', '', $idPers);
										
										echo '<h1 class="titre_tableau">Repartition par Dossier</h1><hr/>';
										echo $c->VitesseOP('', '', $date, $idPers, '', '', '');

										
										echo '<h1 class="titre_tableau">Details</h1><hr/>';
										//echo $c->getLdt('', '', $date, $idPers, '', 'p_ldt.date_deb_ldt', '');										
										
										echo $c->getLdt('', '', $dateJmoins1, $idPers, '', 'p_ldt.date_deb_ldt', '');										
									}
								?>
								</div>

		</div>

		</center>
	</div>

</div>
<div id="root">
		<div id="handle"></div>
		<div id="divflottant"></div>
</div>
</body>
	<?php
		include('footer.php');
	?>
<script language="javascript" type="text/javascript" src="js/jquery.js"></script>
<script src="hcart/js/highcharts.js"></script>
<script src="hcart/js/modules/exporting.js"></script>


<script language="javascript" type="text/javascript" charset="utf-8">

	//about:config
	//signed.applets.codebase_principal_support;true
	
// AUT Mirah RATAHIRY
// DES page ligne de temps de tous les dossiers
// DAT 2012 03 06
	
	var theHandle = document.getElementById("handle");
	var theRoot   = document.getElementById("root");
	Drag.init(theHandle, theRoot);
	
	function aPush(array, value)
	{
		if (value == null || value <0) array.push(0);
		else array.push(value);
		return array;
	}
$(function () {



		$.ajax({
		type: "GET",
		url: "php/link.php?action=evolutionVitesse",
			success: function(msg)
			{
				var json = $.parseJSON(msg);

				var dateLabel = [];
				var arrayHeureProd = [];
				var arrayHeureHorsProd = [];
				var arrayQuantite  = [];
				var arrayVitesseBrute = [];
				var arrayVitesseNette = [];


				$.each(json, function(k, v) {
				
					dateLabel.push(k);
					if (v.heureProd == null || v.heureProd <0) arrayHeureProd.push(0);
					else arrayHeureProd.push(parseFloat(v.heureProd));
					
					if (v.heureProd == null || v.heureHorsProd <0) arrayHeureHorsProd.push(0);
					else arrayHeureHorsProd.push(parseFloat(v.heureHorsProd));
					
					if (v.Qte == null || v.Qte <0) arrayQuantite.push(0);
					else arrayQuantite.push(parseFloat(v.Qte));
					
					if (v.vBrute == null || v.vBrute <0) arrayVitesseBrute.push(0);
					else arrayVitesseBrute.push(parseFloat(v.vBrute));
					
					if (v.vNette == null || v.vNette <0) arrayVitesseNette.push(0);
					else arrayVitesseNette.push(parseFloat(v.vNette));
		/*
					arrayHeureProd.push(v.heureProd);
					arrayHeureHorsProd.push(v.heureHorsProd);
					arrayQuantite.push(v.Qte);
					arrayVitesseBrute.push(v.vBrute);
					arrayVitesseNette.push(v.vNette);
*/


				});	
				
//alert(JSON.stringify(arrayHeureProd));

					$('#graphe_heure').highcharts({
						title: {
							text: 'Heure production',
							x: -20 //center
						},
						subtitle: {
							text: 'Prod/Hors Prod',
							x: -20
						},
						xAxis: {
							categories: dateLabel
						},
						yAxis: {
							title: {
								text: 'Nombre d\'heures'
							},
							plotLines: [{
								value: 0,
								width: 1,
								color: '#307ecc'
							}]
						},
						tooltip: {
							valueSuffix: 'h'
						},
						legend: {
							layout: 'vertical',
							align: 'right',
							verticalAlign: 'middle',
							borderWidth: 0
						},
						series: [{
							name: 'Heure Prod',
							data: arrayHeureProd
						}, {
							name: 'Heure Hors Prod',
							data: arrayHeureHorsProd
						}]
						
					});
					
					$('#graphe_vitesse').highcharts({
						title: {
							text: 'Vitesse',
							x: -20 //center
						},
						subtitle: {
							text: 'cadence',
							x: -20
						},
						xAxis: {
							categories: dateLabel
						},
						yAxis: {
							title: {
								text: 'Vitesse en heure'
							},
							plotLines: [{
								value: 0,
								width: 1,
								color: '#808080'
							}]
						},
						legend: {
							layout: 'vertical',
							align: 'right',
							verticalAlign: 'middle',
							borderWidth: 0
						},
						series: [{
							name: 'Vitesse Brute',
							data: arrayVitesseBrute
						}, {
							name: 'Vitesse Nette',
							data: arrayVitesseNette
						}]
						
					});
					
					$('#graphe_quantite').highcharts({
						title: {
							text: 'Quantite',
							x: -20 //center
						},
						
						xAxis: {
							categories: dateLabel
						},
						yAxis: {
							title: {
								text: 'Volume'
							},
							plotLines: [{
								value: 0,
								width: 1,
								color: '#808080'
							}]
						},
						legend: {
							layout: 'vertical',
							align: 'right',
							verticalAlign: 'middle',
							borderWidth: 0
						},
						series: [{
							name: 'Quantite',
							data: arrayQuantite
						}]
						
					});
					
			}
		});

		//return;
	


    
});



	$(document).ready(function() 
	{
	
	

		$('#mcorps').on('click', '.th', function () {
			goLdt(this.id);
		});
		
		
	});
	
	
	$("#goLdt").click(function(){
		goLdt("");
	});
	$("#goLdtStat").click(function(){
		goLdtStat("");
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
	
	$('#mdp').bind('keypress', function(e) {
        if(e.keyCode==13){
            identification();
        }
	});
	
	$("#doss").change(function(){
		var idDoss = $("#doss").val();
		getLstEtape(idDoss);
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
					strHTML += "<tr><td class=\"noBreak\">Statut : </td><td><select  class=\"sel\" id=\"STAT\"><option  value=''></option><option  value='1'>EN COURS</option><option  value='2'>TERMINE</option></select></td></tr>";
					strHTML += "<tr><td class=\"noBreak\">Date Deb : </td><td><input type=\text\" id=\"dDeb\"  class=\"sel\" value ="+tk[9]+" ></td></tr>" ;
					strHTML += "<tr><td class=\"noBreak\">Date Fin : </td><td><input type=\text\" id=\"dFin\"  class=\"sel\" value ="+tk[10]+" ></td></tr>" ;
					strHTML += "<tr><td class=\"noBreak\">Heure Deb : </td><td><input type=\text\" id=\"hDeb\"  class=\"sel\"  value ="+tk[2]+" ></td></tr>" ;					
					strHTML += "<tr><td class=\"noBreak\">Heure Fin : </td><td><input type=\text\" id=\"hFin\"  class=\"sel\" value ="+tk[3]+" ></td></tr>" ;
					strHTML += "<tr><td class=\"noBreak\">Quantite : </td><td><input type=\text\" id=\"qt\"  class=\"sel\"  value ="+tk[4]+" ></td></tr>" ;
					strHTML += "<tr><td class=\"noBreak\">Nb Erreur : </td><td><input type=\text\" id=\"err\"  class=\"sel\"  value ="+tk[5]+" ></td></tr>" ;
					strHTML += "<tr><td class=\"noBreak\">Comment : </td><td><input type=\text\" id=\"com\"  class=\"sel\"  value ="+tk[11]+" ></td></tr>" ;
					
					strHTML += "<tr><td colspan=\"2\"><br /><center><input id=\"modifier\" type=\"button\" value=\"Annuler\" onclick=\"document.getElementById(\'root\').style.display = 'none' ;\"><input type=\"button\" value=\"Modifier\" onclick=\"updateLdt("+id+");\"></center></td></tr></table>" ;
					
					document.getElementById('root').style.display = "block" ;
					//document.getElementById('root').style.height = "325px" ;
					document.getElementById('root').style.width = "350" ;
					//document.getElementById('root').style.left = "70px" ;
					//document.getElementById('root').style.top = "8px" ;
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
	function goLdtStat(orderBy)
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
		url: "php/link.php?action=getLstLdtRecap&doss="+doss+"&mat="+mat+"&deb="+deb+"&fin="+fin+"&stat="+stat+"&orderby="+orderBy+"&dep="+dep+"&etape="+etape,
			success: function(msg){
				$("#ldtCorp").html(msg);
			}
		});
	}
	</script>
</html>

