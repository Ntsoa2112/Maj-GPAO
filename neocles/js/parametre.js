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

	//click sur le bouton MODIFIER ou SUPPRIMER
	$("#ldtCorp").on('click','.button',function(){
		
		var id = $(this).attr("id");

		if(confirm("Voulez-vous vraiment supprimer cette ligne?")){
			supprimer(id);
			//console.log("suppression id = "+id);
		}		
		//$("#cadreBouton").
		//console.log(date_arrivee);
	});

	///MAHASETRA CODE
	$("#Add").click(function(){

		var matricul = ($("#matricul").val() == undefined)?'':$("#matricul").val();	
		
		console.log(matricul);
		
		$("#ldtCorp").html('<div class="body" id="Etape"><img src = "img/loader.gif" width="50px"/>Loading ...</div>');
		$.ajax({
		type: "GET",
		url: "php/link.php?action=saveUser&matricul="+matricul,
			success: function(data){
				$("#ldtCorp").empty();
				if(data != "success"){
					var affiche = "<p class = 'fail'>Echec de l'inscription'</p>";
					$("#ldtCorp").html(affiche);
				}
				else{
					reinitialisation();
					var affiche = "<p class = 'success'>Element inseré avec succes</p>";
					$("#ldtCorp").html(affiche);

					setTimeout(function(){
					    location.reload();
					}, 1000);
				}
			}
		});
	});

	$("#matricul").keydown(function (e) {
	    // Allow: backspace, delete, tab, escape, enter and .
	    if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
	         // Allow: Ctrl+A, Command+A
	        (e.keyCode == 65 && ( e.ctrlKey === true || e.metaKey === true ) ) || 
	         // Allow: home, end, left, right, down, up
	        (e.keyCode >= 35 && e.keyCode <= 40)) {
	             // let it happen, don't do anything
	             return;
	    }
	    // Ensure that it is a number and stop the keypress
	    if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
	        e.preventDefault();
	    }
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
	url: "php/link.php?action=rechercheMaha&dateSelect="+date+"&poleSelect="+poleSelect+"&clientSelect="+clientSelect+"&intervenantSelect="+intervenantSelect+"&ticketSelect="+ticketSelect,
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
		url: "php/link.php?action=supprimerUtilisateur&matricul="+id,
		dataType:'text',
		success: function(data){
			//alert(msg);
			//console.log(msg);
			//$("#ldtCorp").html(msg);

			$("#ldtCorp").empty();
			if(data != "success"){
				var affiche = "<p class = 'fail'>Echec de la suppression</p>";
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