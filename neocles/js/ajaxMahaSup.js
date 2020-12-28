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
			link = "php/link.php?action=insertSupervision";
		}
		else{
			link = "php/link.php?action=updateSupervision&id="+$("#hidden").attr("value");
		}

		var date_arrivee = $("input[name='date_arrivee']").val();
		var heure_arrivee = $("input[name='heure_arrivee']").val();
		var client = $("input[name='client']").val();
		var origine = $("input[name='origine']").val();
		var numero_ticket = $("input[name='numero_ticket']").val();
		var heure_creation_ticket = $("input[name='heure_creation_ticket']").val();
		var etat = $("input[name='etat']").val();
		var intervenant = $("input[name='intervenant']").val();
		var commentaire = $("input[name='commentaire']").val();

		
		if(date_arrivee!='' && verifFormatDate(date_arrivee)){
			
			if (heure_arrivee!='' && verifFormatHeure(heure_arrivee)) {
				
				if(client!=''){

					if(demandeur!=''){

						if(numero_ticket!=''){	

							if(heure_creation_ticket != '' || verifFormatHeure(heure_creation_ticket)){

								if( pole_actuel!=''){

									if(intervenant!=''){

										if(commentaire!=''){
											
											//envoi des données via AJAX
											$.post(
												link,
												{
													date_arrivee_php:date_arrivee,
													heure_arrivee_php:heure_arrivee,
													client_php:client,
													origine_php:origine,
													numero_ticket_php:numero_ticket,
													heure_creation_ticket_php:heure_creation_ticket,
													etat_php:etat,
													intervenant_php:intervenant,
													commentaire_php:commentaire
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
											vide($("input[name='commentaire']"));
										}
									}
									else{
										vide($("input[name='intervenant']"));
									}
								}
								else{
									vide($("input[name='etat']"));
								}
							}
							else{
								//console.log("fokontany vide");
								vide($("input[name='heure_creation_ticket']"));
							}							
						}
						else{
							//console.log("fokontany vide");
							vide($("input[name='numero_ticket']"));
						}
					}
					else{
						//console.log("lieu_naissance vide");
						vide($("input[name='origine']"));
					}
				}
				else{

					vide($("input[name='client']"));
				}
			}
			else{
				vide($("input[name='heure_arrivee']"));
			}			
		}
		else{
			vide($("input[name='date_arrivee']"));
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

			$("#date_arrivee").val($("#date_arrivee"+id).text());
			$("#heure_arrivee").val($("#heure_arrivee"+id).text());
			$("#client").val($("#client"+id).text());
			$("#origine").val($("#origine"+id).text());
			$("#heure_creation_ticket").val($("#heure_creation_ticket"+id).text());
			$("#numero_ticket").val($("#numero_ticket"+id).text());
			$("#etat").val($("#etat"+id).text());
			$("#intervenant").val($("#intervenant"+id).text());
			$("#commentaire").val($("#commentaire"+id).text());
			
			$("#titreMaha").text("MODIFICATION");

			var annuler = $("#Annuler");
			var hidden = $("#hidden");

			if(!(annuler.length && hidden.length)){
				$("<input type='button' id='Annuler'  value='Annuler' title='Annuler' />").insertAfter("#valider");
				$("<input type='hidden' id='hidden'  value='"+id+"' />").insertAfter("#valider");
			}
			$("#valider").attr("value","Modifier");
			
			//$("#cadreBouton").
			//console.log(date_arrivee);
		}
		//console.log(id);
		
	});

	//click sur annuler
	$("#cadreBouton").on('click','#Annuler',function(){
		
		reinitialisation();
	});

	//MAHASETRA CODE
	$("#rechercheSelect").click(function(){

		var dateSelect = ($("#dateSelect").val() == undefined)?'':$("#dateSelect").val();
		var etatSelect = ($("#etatSelect").val() == undefined)?'':$("#etatSelect").val();
		var clientSelect = ($("#clientSelect").val() == undefined)?'':$("#clientSelect").val();
		var intervenantSelect = ($("#intervenantSelect").val() == undefined)?'':$("#intervenantSelect").val();		
		var ticketSelect = ($("#ticketSelect").val() == undefined)?'':$("#ticketSelect").val();		
		var moisSelect = ($("#moisSelectSup").val() == undefined)?'':$("#moisSelectSup").val();	
		
		
		$("#ldtCorp").html('<div class="body" id="Etape"><img src = "img/loader.gif" width="50px"/>Loading ...</div>');
		$.ajax({
		type: "GET",
		url: "php/link.php?action=rechercheMahaSup&dateSelect="+dateSelect+"&etatSelect="+etatSelect+"&clientSelect="+clientSelect+"&intervenantSelect="+intervenantSelect+"&ticketSelect="+ticketSelect+"&moisSelectSup="+moisSelectSup,
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
	$("#origine").val("");
	$("#heure_creation_ticket").val("");
	$("#numero_ticket").val("");
	$("#etat").val("");
	$("#intervenant").val("");
	$("#commentaire").val("");
}
function rechercheDate(){

	var date = dateNow();
	
	var etatSelect = "";
	var clientSelect = "";
	var intervenantSelect = "";		
	var ticketSelect = "";		
	
	
	$("#ldtCorp").html('<div class="body" id="Etape"><img src = "img/loader.gif" width="50px"/>Loading ...</div>');
	$.ajax({
	type: "GET",
	url: "php/link.php?action=rechercheMahaSup&dateSelect="+date+"&etatSelect="+etatSelect+"&clientSelect="+clientSelect+"&intervenantSelect="+intervenantSelect+"&ticketSelect="+ticketSelect,
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
		url: "php/link.php?action=supprimerMahaSup&id="+id,
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