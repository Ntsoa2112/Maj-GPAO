// JavaScript Document

//expression regulier-----------------
var string_reg=/^[a-zA-Z][ a-zA-Z'-]+[a-z]$/;
var string_reg2=/^[a-zA-Z]{2}$/;
var annee_reg=/^[0-9]{4}$/;
var nom_reg1=/^[A-Z][ A-Z-]+[A-Z]$/;
var nom_reg2=/^[A-Z]{2}$/;
//----------------------------------------
$(document).ready(function(){

	$("#resultat").hide();
	
	$("#valider").click(function(event){
		
		event.preventDefault();

		var action = $("#valider").attr("value");
		var link 
		
		
		if(action == "Enregistrer"){
			link = "php/link.php?action=insertAppel";
		}
		else{
			link = "php/link.php?action=updateAppel&id="+$("#hidden").attr("value");
		}
		
		var date = $("input[name='date']").val();
		var heure = $("input[name='heure']").val();
		var duree = $("input[name='duree']").val();
		var societe = $("input[name='societe']").val();
		var interlocuteur = $("input[name='interlocuteur']").val();
		var ticket = $("input[name='ticket']").val();
		var type = ($("#type").val() == undefined)?'':$("#type").val();
		var comportement = ($("#comportement").val() == undefined)?'':$("#comportement").val();
		var intervenant = $("input[name='intervenant']").val();
		var description = $("input[name='description']").val();

//utilisation du regular expression string_reg.test(nom)
		if(!verifFormatDuree(duree)) {
			vide($("input[name='duree']"));
			return;
		}

		if(date!='' && verifFormatDate(date)){	
			if (heure!='' && verifFormatHeure(heure)) {				
				//envoi des données via AJAX
				$.post(
					link,
					{
						date_php : date,
						heure_php : heure,
						duree_php : duree,
						societe_php : societe,
						interlocuteur_php : interlocuteur,
						ticket_php : ticket,
						type_php : type,
						comportement_php : comportement,
						intervenant_php : intervenant,
						description_php : description
					},
					function(data){

						$("#ldtCorp").empty();
						if(data != "success"){
							var affiche = "<p class = 'fail'>Echec de l'operation</p>";
							$("#ldtCorp").html(affiche);
						}
						else{
							reinitialisation();
							var affiche = "<p class = 'success'>Reussite de l'operation</p>";
							$("#ldtCorp").html(affiche);

							setTimeout(function(){
							    location.reload();
							}, 1000);

						}
					},
					'text'
				);
				
			}
			else{
				vide($("input[name='heure']"));
			}			
		}
		else{
			vide($("input[name='date']"));
		}

	});

	//click sur le bouton MODIFIER ou SUPPRIMER
	$("#ldtCorp").on('click','.button',function(){
		
		var id = $(this).attr("id");
		
		var last = id.slice(-1);

		if(last == 's'){
			//suppression
			//console.log("Avant "+id);
			id = id.slice(0,-1);

			if(confirm("Voulez-vous vraiment supprimer cette ligne?")){
				supprimer(id);
				//console.log("suppression id = "+id);
			}		
		}
		else{
			//modification

			$("#date").val($("#date"+id).text());
			$("#heure").val($("#heure"+id).text());
			$("#duree").val($("#duree"+id).text());
			$("#societe").val($("#societe"+id).text());
			$("#interlocuteur").val($("#interlocuteur"+id).text());
			$("#ticket").val($("#ticket"+id).text());
			$("#type").val($("#type"+id).text());
			$("#comportement").val($("#comportement"+id).text());
			$("#intervenant").val($("#intervenant"+id).text());
			$("#description").val($("#description"+id).text());
			
			$("#titreMaha").text("MODIFICATION");

			var annuler = $("#Annuler");
			var hidden = $("#hidden");

			if(!(annuler.length && hidden.length)){
				$("<input type='button' id='Annuler'  value='Annuler' title='Annuler' />").insertAfter("#valider");
				$("<input type='hidden' id='hidden'  value='"+id+"' />").insertAfter("#valider");
			}
			$("#valider").attr("value","Modifier");
		}
		
		//$("#cadreBouton").
		//console.log(date_arrivee);
	});

	//click sur annuler
	$("#cadreBouton").on('click','#Annuler',function(){
		
		reinitialisation();

	});


	///MAHASETRA CODE
	$("#rechercheSelect").click(function(){

		console.log("test");

		var dateSelect = ($("#dateSelect").val() == undefined)?'':$("#dateSelect").val();
		var societeSelect = ($("#societeSelect").val() == undefined)?'':$("#societeSelect").val();
		var interlocuteurSelect = ($("#interlocuteurSelect").val() == undefined)?'':$("#interlocuteurSelect").val();
		var intervenantSelect = ($("#intervenantSelect").val() == undefined)?'':$("#intervenantSelect").val();		
		var ticketSelect = ($("#ticketSelect").val() == undefined)?'':$("#ticketSelect").val();		
		
		
		$("#ldtCorp").html('<div class="body" id="Etape"><img src = "img/loader.gif" width="50px"/>Loading ...</div>');
		$.ajax({
		type: "GET",
		url: "php/link.php?action=rechercheAppel&dateSelect="+dateSelect+"&societeSelect="+societeSelect+"&interlocuteurSelect="+interlocuteurSelect+"&intervenantSelect="+intervenantSelect+"&ticketSelect="+ticketSelect,
			success: function(msg){
				//alert(msg);
				//console.log(msg);
				$("#ldtCorp").html(msg);
			}
		});
	});		
});

function verifFormatDate(date){
	if(date != ''){
		var reg = new RegExp("^[0-9]{2}[/]{1}[0-9]{2}[/]{1}[0-9]{4}$","g");
		if(reg.test(date))
			return true;
		else
			return false;
	}
	else{
		return false;
	}
}
function verifFormatHeure(heure){
	if(heure != ''){
		var reg = new RegExp("^([0-9]|0[0-9]|1[0-9]|2[0-3]):[0-5][0-9]$");
		if(reg.test(heure))
			return true;
		else
			return false;
	}
	else{
		return false;
	}
}
function verifFormatDuree(heure){
	if(heure != ''){
		var reg = new RegExp("^[0-2][0-9]:[0-5][0-9]:[0-5][0-9]$");
		if(reg.test(heure))
			return true;
		else
			return false;
	}
	else{
		return false;
	}
}


function reinitialisation(){
	$("#Annuler").remove();
	$("#hidden").remove();
	$("#valider").attr("value","Enregistrer");

	$("#titreMaha").text("INSERTION");

	$("#date").val("");
	$("#heure").val("");
	$("#duree").val("");
	$("#societe").val("");
	$("#interlocuteur").val("");
	$("#ticket").val("");
	$("#type").val("");
	$("#comportement").val("");
	$("#intervenant").val("");
	$("#description").val("");
}

function rechercheDate(){

	var date = dateNow();

	var societeSelect = "";
	var interlocuteurSelect = "";
	var intervenantSelect = "";	
	var ticketSelect = "";	

	
	$("#ldtCorp").html('<div class="body" id="Etape"><img src = "img/loader.gif" width="50px"/>Loading ...</div>');
	$.ajax({
	type: "GET",
	url: "php/link.php?action=rechercheAppel&dateSelect="+date+"&societeSelect="+societeSelect+"&interlocuteurSelect="+interlocuteurSelect+"&intervenantSelect="+intervenantSelect+"&ticketSelect="+ticketSelect,
		success: function(msg){
			//alert(msg);
			//console.log(msg);
			$("#ldtCorp").html(msg);
		}
	});
}

function supprimer(id){
	$("#ldtCorp").html('<div class="body" id="Etape"><img src = "img/loader.gif" width="50px"/>Loading ...</div>');
	$.ajax({
		type: "GET",
		url: "php/link.php?action=supprimerAppel&id="+id,
		dataType:'text',
		success: function(data){
			//alert(msg);
			//console.log(msg);
			//$("#ldtCorp").html(msg);

			$("#ldtCorp").empty();
			if(data != "success"){
				var affiche = "<p class = 'dail'>Echec de la suppression</p>";
				$("#ldtCorp").html(affiche);
			}
			else{
				reinitialisation();
				var affiche = "<p class = 'success'>Element supprimer avec succes</p>";
				$("#ldtCorp").html(affiche);

				setTimeout(function(){
				    location.reload();
				}, 1000);
			}
		}
	});
}