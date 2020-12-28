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
			link = "php/link.php?action=insertHelpdesk";
		}
		else{
			link = "php/link.php?action=updateHelpdesk&id="+$("#hidden").attr("value");
		}
		
		var date_arrivee = $("input[name='date_arrivee']").val();
		var heure_arrivee = $("input[name='heure_arrivee']").val();
		var client = $("input[name='client']").val();
		var demandeur = $("input[name='demandeur']").val();
		var numero_ticket = $("input[name='numero_ticket']").val();
		var heure_creation_ticket = $("input[name='heure_creation_ticket']").val();
		var pole_actuel = $("input[name='pole_actuel']").val();
		var intervenant = $("input[name='intervenant']").val();
		var commentaire = $("input[name='commentaire']").val();
		var cl = client.length<=3;
		var t1 = heure_arrivee.split(':');
		var t2 = heure_creation_ticket.split(':');
		var ht1 = parseInt(t1[0],10);
		var mt1 = parseInt(t1[1],10);
		var ht2 = parseInt(t2[0],10);
		var mt2 = parseInt(t2[1],10);

		var temps1= (ht1 * 3600) + ( mt1 * 60) ;
		var temps2= (ht2 * 3600) + ( mt2 * 60) ;
		var tsla = temps2 - temps1; 
		

		function secondsToTime(secs)
			{
				var hours = Math.floor(secs / (60 * 60));

				var divisor_for_minutes = secs % (60 * 60);
				var minutes = Math.floor(divisor_for_minutes / 60);

				var divisor_for_seconds = divisor_for_minutes % 60;
				var seconds = Math.ceil(divisor_for_seconds);
				var te = hours + ":" + minutes + ":" + seconds;
				return te;
			}

//utilisation du regular expression string_reg.test(nom)
		
		if(date_arrivee!='' && verifFormatDate(date_arrivee)){
			
			if (heure_arrivee!='' && verifFormatHeure(heure_arrivee)) {
				
				if(client!='' && cl){

					if(demandeur!=''){

						if(numero_ticket!=''){	

							if(heure_creation_ticket != '' || verifFormatHeure(heure_creation_ticket)){

								if( pole_actuel!=''){

									if(intervenant!=''){

										if(commentaire!=''){

											if(temps2 > temps1){
												//envoi des données via AJAX
												var tempsla = secondsToTime(tsla);
											$.post(
												link,
												{
													date_arrivee_php:date_arrivee,
													heure_arrivee_php:heure_arrivee,
													client_php:client,
													demandeur_php:demandeur,
													numero_ticket_php:numero_ticket,
													heure_creation_ticket_php:heure_creation_ticket,
													pole_actuel_php:pole_actuel,
													intervenant_php:intervenant,
													commentaire_php:commentaire,
													tempsla_php:tempsla,//ajout luc
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
												 
												alert("L'heure de création de ticket doit être supérieur à l'heure d'arrivé de mail ");
											}
							
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
									vide($("input[name='pole_actuel']"));
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
						vide($("input[name='demandeur']"));
					}
				}
				else{
					alert("le nombre de caractères du client ne doit pas être supérieur à 3")
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
			//modification

			$("#date_arrivee").val($("#date_arrivee"+id).text());
			$("#heure_arrivee").val($("#heure_arrivee"+id).text());
			$("#client").val($("#client"+id).text());
			$("#demandeur").val($("#demandeur"+id).text());
			$("#heure_creation_ticket").val($("#heure_creation_ticket"+id).text());
			$("#numero_ticket").val($("#numero_ticket"+id).text());
			$("#pole_actuel").val($("#pole_actuel"+id).text());
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

		var dateSelect = ($("#dateSelect").val() == undefined)?'':$("#dateSelect").val();
		var poleSelect = ($("#poleSelect").val() == undefined)?'':$("#poleSelect").val();
		var clientSelect = ($("#clientSelect").val() == undefined)?'':$("#clientSelect").val();
		var intervenantSelect = ($("#intervenantSelect").val() == undefined)?'':$("#intervenantSelect").val();		
		var ticketSelect = ($("#ticketSelect").val() == undefined)?'':$("#ticketSelect").val();	
		var moisSelect = ($("#moisSelect").val() == undefined)?'':$("#moisSelect").val();		
		
		
		$("#ldtCorp").html('<div class="body" id="Etape"><img src = "img/loader.gif" width="50px"/>Loading ...</div>');
		$.ajax({
		type: "GET",
		url: "php/link.php?action=rechercheMaha&test=test&dateSelect="+dateSelect+"&poleSelect="+poleSelect+"&clientSelect="+clientSelect+"&intervenantSelect="+intervenantSelect+"&ticketSelect="+ticketSelect+"&moisSelect="+moisSelect,
			success: function(msg){
				$("#ldtCorp").html(msg);
				//$("#ldtCorp").load(".html");
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
		url: "php/link.php?action=supprimerMaha&id="+id,
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