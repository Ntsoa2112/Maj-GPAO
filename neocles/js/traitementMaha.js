// JavaScript Document

//style et effet couleur pour les input texte
$(document).ready(function(){
	
	rechercheDate();

	$("input[type=text]").focusin(function (){
			$(this).css("backgroundColor","#b2b4cc");
		});
	$("input[type=text]").focusout(	
		function (){
			$(this).css("backgroundColor","white");
		});	

	//compléter automatiquement la date avec la date du jour
	$("#date_arrivee").val(dateNow());

	HeureTraitement();
	Duree();

});

//-----------------fonction pour le input vide ou faux---------------
function vide($var){
	$var.addClass("vide");
	$var.focus(function(){
		$var.removeClass("vide");
	});
}

function dateNow(){
	var d = new Date();

	var month = d.getMonth()+1;
	var day = d.getDate();

	var output = (day<10 ? '0' : '') + day + '/' + (month<10 ? '0' : '') + month + '/' + d.getFullYear();

	return output;
}
function Heure(){          
    $('#heure_arrivee').keypress(function(e) {
	
        var a = [];
        var k = e.which;

        for (i = 48; i < 58; i++)
            a.push(i);

        if (!(a.indexOf(k)>=0))
            e.preventDefault();
    });
}
function HeureTraitement(){
	
	//pour l'heure
	$(".heure").keyup(function (e){
    	
    	if($(this).val().length == 2){
    		if(e.keyCode != 8){
    			$(this).val($(this).val() + ":"); 
    		}  	
    	}
	});


	$(".heure").keydown(function (e) {

	    // Allow: backspace, delete, tab, escape, enter and .
	    if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||

	         // Allow: Ctrl+A, Command+A
	        (e.keyCode == 65 && ( e.ctrlKey === true || e.metaKey === true ) ) || 

		//appui sur shift
		  (e.shiftKey && $(this).val().length < 5) ||

	         // Allow: home, end, left, right, down, up
	        (e.keyCode >= 35 && e.keyCode <= 40)) {
	             // let it happen, don't do anything
	             return;
	    }
	    // Ensure that it is a number and stop the keypress
	    if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
	        e.preventDefault();
	    }

	    //nombre maximum 5
	    if($(this).val().length >= 5)
		e.preventDefault();
	});
}
function Duree(){          
    //pour l'heure
	$(".duree").keyup(function (e){
    	
    	if($(this).val().length == 2 || $(this).val().length == 5){
    		if(e.keyCode != 8){
    			$(this).val($(this).val() + ":"); 
    		}  	
    	}
	});


	$(".duree").keydown(function (e) {
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
}