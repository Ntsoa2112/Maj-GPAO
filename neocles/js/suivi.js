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
	
	///MAHASETRA CODE
	$("#rechercheSelect").click(function(){

		var dateSelect = ($("#dateSelect").val() == undefined)?'':$("#dateSelect").val();
		var numTicketSelect = ($("#numTicketSelect").val() == undefined)?'':$("#numTicketSelect").val();
		var matriculSelect = ($("#matriculSelect").val() == undefined)?'':$("#matriculSelect").val();
		var actionSelect = ($("#actionSelect").val() == undefined)?'':$("#actionSelect").val();		
		var typeSelect = ($("#typeSelect").val() == undefined)?'':$("#typeSelect").val();		
		
		
		$("#ldtCorp").html('<div class="body" id="Etape"><img src = "img/loader.gif" width="50px"/>Loading ...</div>');
		$.ajax({
		type: "GET",
		url: "php/link.php?action=rechercheHistorique&dateSelect="+dateSelect+"&numTicketSelect="+numTicketSelect+"&matriculSelect="+matriculSelect+"&actionSelect="+actionSelect+"&typeSelect="+typeSelect,
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

function reinitialisation(){
	$("#Annuler").remove();
	$("#hidden").remove();
	$("#valider").attr("value","Enregistrer");

	$("#titreMaha").text("INSERTION");

	$("#date_arrivee").val("");
	$("#heure_arrivee").val("");
	$("#client").val("");
	$("#demandeur").val("");
	$("#heure_creation_ticket").val("");
	$("#numero_ticket").val("");
	$("#pole_actuel").val("");
	$("#intervenant").val("");
	$("#commentaire").val("");
}

function rechercheDate(){

	var date = dateNow();

	var poleSelect = "";
	var clientSelect = "";
	var intervenantSelect = "";	
	var ticketSelect = "";	
	
	$("#ldtCorp").html('<div class="body" id="Etape"><img src = "img/loader.gif" width="50px"/>Loading ...</div>');
	$.ajax({
	type: "GET",
	url: "php/link.php?action=rechercheHistorique&dateSelect="+date+"&poleSelect="+poleSelect+"&clientSelect="+clientSelect+"&intervenantSelect="+intervenantSelect+"&ticketSelect="+ticketSelect,
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
		url: "php/link.php?action=supprimerMaha&id="+id,
		dataType:'text',
		success: function(data){
			//alert(msg);
			//console.log(msg);
			//$("#ldtCorp").html(msg);

			$("#ldtCorp").empty();
			if(data != "success"){
				var affiche = "<p class = 'Fail'>Echec de la suppression/p>";
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