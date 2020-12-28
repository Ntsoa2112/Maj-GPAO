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

	//SUPPESSION
	$("#ldtCorp").on('click','.button',function(){
		
		var id = $(this).attr("id");

		if(confirm("Voulez-vous vraiment supprimer cette ligne?")){
			supprimer(id , getUrlParameter("type"));
			//console.log("suppression id = "+id);

		}		
	});


	//AJOUT
	$("#Add").click(function(){

		var matricul = ($("#matricul").val() == undefined)?'':$("#matricul").val();	
		
		$("#ldtCorp").html('<div class="body" id="Etape"><img src = "img/loader.gif" width="50px"/>Loading ...</div>');
		$.ajax({
		type: "GET",
		url: "php/link.php?action=addParamAppel&id="+matricul+"&type="+getUrlParameter("type"),
			success: function(data){
				$("#ldtCorp").empty();
				if(data != "success"){
					var affiche = "<p class = 'fail'>Echec de l'enregistrement'</p>";
					$("#ldtCorp").html(affiche);
				}
				else{
					var affiche = "<p class = 'success'>Element inseré avec succes</p>";
					$("#ldtCorp").html(affiche);

					setTimeout(function(){
					    location.reload();
					}, 1000);
				}
			}
		});
	});	
});

//pour avoir la valeur du parametre sParam en Get
function getUrlParameter(sParam) {
    var sPageURL = decodeURIComponent(window.location.search.substring(1)),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;

    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');

        if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : sParameterName[1];
        }
    }
};


//suppression 
function supprimer(id , type){
	$("#ldtCorp").html('<div class="body" id="Etape"><img src = "img/loader.gif" width="50px"/>Loading ...</div>');
	$.ajax({
		type: "GET",
		url: "php/link.php?action=deleteParamAppel&id="+id+"&type="+type,
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
				var affiche = "<p class = 'success'>Element supprimer avec succes</p>";
				$("#ldtCorp").html(affiche);

				setTimeout(function(){
				    location.reload();
				}, 1000);
			}
		}
	});
}