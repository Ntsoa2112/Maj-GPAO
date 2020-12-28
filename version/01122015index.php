<?php
	include_once('header.inc.php');
	include_once('php/common.php');

?>

<div id="mcorps">
	<div id="head">
		<?php
			include_once('baniR.php');
			include_once('headMen.php');

			$c = new Cnx();
			$divFlux  = $c->GetFluxRss("","","","","","");
			echo $c->GetIOUser();

		?>
	</div>
	
<div id="popup_name" class="popup_block">


</div>

	<table id="menu_droiteE">
	
	<tr><td><a href="ri.htm" class="ri"  <?php echo( 'style="background-color:#'.substr(md5(rand()), 0, 6)).'"';?>>Reglement Interieur</a></td></tr>
	<?php if ((isset($_SESSION['pseudo'])) && (!empty($_SESSION['pseudo']))) if (!$c->enqueteDejaFait('')) { ?>
	<tr><td><a href="SondageEmployer.php" class="ri blink" style="background-color:#06c2e3" ><h3 class="blink">Sondage</h3></a></td></tr>
	<?php } 
	if ((isset($_SESSION['pseudo'])) && (!empty($_SESSION['pseudo']))) echo $c->enqueteDejaFait('ALL');
	?>
	
	
	</table>
	
	
	
	<div id="content">
	<div id="fluxrss">
	<div class="flux">
	<div id="slider1_container" style="position: relative; top: 0px; left: 0px; width: 300px;
        height: 200px;">

        <!-- Loading Screen -->
        <div u="loading" style="position: absolute; top: 0px; left: 0px;">
            <div style="filter: alpha(opacity=70); opacity:0.7; position: absolute; display: block;
                background-color: #000000; top: 0px; left: 0px;width: 100%;height:100%;">
            </div>
            <div style="position: absolute; display: block; background: url(img/loading.gif) no-repeat center center;
                top: 0px; left: 0px;width: 100%;height:100%;">
            </div>
        </div>

        <!-- Slides Container -->
        <div u="slides" style="cursor: move; position: absolute; left: 0px; top: 0px; width: 300px; height: 200px;
            overflow: hidden;">
             <?php echo $divFlux; ?>
        </div>
        
        <!-- Direction Navigator Skin Begin -->
        <style>
            .jssorn08l, .jssorn08r, .jssorn08ldn, .jssorn08rdn
            {
            	position: absolute;
            	cursor: pointer;
            	display: block;
                
                overflow:hidden;
                opacity: .4; filter:alpha(opacity=40);
            }
            .jssorn08l { background-position: -5px -35px; }
            .jssorn08r { background-position: -65px -35px; }
            .jssorn08l:hover { background-position: -5px -35px; opacity: .8; filter:alpha(opacity=80); }
            .jssorn08r:hover { background-position: -65px -35px; opacity: .8; filter:alpha(opacity=80); }
            .jssorn08ldn { background-position: -5px -35px; opacity: .3; filter:alpha(opacity=30); }
            .jssorn08rdn { background-position: -65px -35px; opacity: .3; filter:alpha(opacity=30); }
        </style>
        <!-- Arrow Left -->
        <span u="arrowleft" class="jssorn08l" style="width: 50px; height: 50px; top: 8px; left: 8px;">
        </span>
        <!-- Arrow Right -->
        <span u="arrowright" class="jssorn08r" style="width: 50px; height: 50px; bottom: 8px; left: 8px">
        </span>
        <!-- Direction Navigator Skin End -->
        
    </div>
	</div>
	
<?php
$color = substr(md5(rand()), 0, 6);



function rand_color() {
    return '#' . str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT);
}

?>
	</div>

	
	<center>
			<div id="content_centre">
			

				<?php
					include('corps.php');
				?>
				
				
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
	
    <script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
    <!-- use jssor.slider.mini.js (39KB) or jssor.sliderc.mini.js (31KB, with caption, no slideshow) or jssor.sliders.mini.js (26KB, no caption, no slideshow) instead for release -->
    <!-- jssor.slider.mini.js = jssor.sliderc.mini.js = jssor.sliders.mini.js = (jssor.core.js + jssor.utils.js + jssor.slider.js) -->
    <script type="text/javascript" src="js/jssor.core.js"></script>
    <script type="text/javascript" src="js/jssor.utils.js"></script>
    <script type="text/javascript" src="js/jssor.slider.js"></script>

<script language="javascript" type="text/javascript" src="js/jquery.js"></script>
<script language="javascript" type="text/javascript" charset="utf-8">

var ArrayItem = {};

jQuery(document).ready(function ($) {
            var options = {
                $AutoPlay: true,                                    //[Optional] Whether to auto play, to enable slideshow, this option must be set to true, default value is false
                $PlayOrientation: 2,                                //[Optional] Orientation to play slide (for auto play, navigation), 1 horizental, 2 vertical, default value is 1
                $DragOrientation: 2,                                //[Optional] Orientation to drag slide, 0 no drag, 1 horizental, 2 vertical, 3 either, default value is 1 (Note that the $DragOrientation should be the same as $PlayOrientation when $DisplayPieces is greater than 1, or parking position is not 0)

                $DirectionNavigatorOptions: {
                    $Class: $JssorDirectionNavigator$,              //[Requried] Class to create direction navigator instance
                    $ChanceToShow: 2,                               //[Required] 0 Never, 1 Mouse Over, 2 Always
                    $AutoCenter: 1,                                 //[Optional] Auto center arrows in parent container, 0 No, 1 Horizontal, 2 Vertical, 3 Both, default value is 0
                    $Steps: 1                                       //[Optional] Steps to go for each navigation request, default value is 1
                }
            };

            var jssor_slider1 = new $JssorSlider$("slider1_container", options);
			
		
		
        });
		
		
		

		
	var theHandle = document.getElementById("handle");
	var theRoot   = document.getElementById("root");
	Drag.init(theHandle, theRoot);
	var idCV = $("#id").val();

	$("#fermer").click(function(){
		$("#tab_login").hide("slow");
	});
	
	$("#goMd5").click(function(){
		var val = $("#md5").val();
	
		$.ajax({
		type: "GET",
		url: "php/link.php?action=md5&val="+val,
			success: function(msg){
				$("#result").val(msg);
			}
		});
	});

	/* fonction qui check que l'element n'est pas encore utilisé */
	
	$("select").live('change', function() {
		var inHTML='';
		var indexItem = Number($(this).val());
		if (ArrayItem[indexItem-1] == indexItem)
		{
			//alert('choisir un autre'+ ArrayItem[indexItem-1].toString() + ' ' + indexItem.toString() + ' ' +ArrayItem.toString());
			$(this).prop('selectedIndex', -1);
		}

     });
	 
	 $("select").live('click', function() {
	
		for (i=0;i<5;i++)
		{
			ArrayItem[i]=0;
		}
		$("select").each(function(){
			var tempIdx = Number($(this).val());
			ArrayItem[tempIdx-1]=tempIdx;
		});

     });
	 

	
	$("#logIN").click(function(){
		$("#tab_login").show("slow");
	});

	$("#submitLogin").click(function(){
		identification();
	});
	
	$('#mdp').bind('keypress', function(e) {
        if(e.keyCode==13){
            identification();
        }
	});
	

	function newLdt()
	{
		var strHTML = "" ;
			strHTML += "<table style=\"margin-top: 20px;margin-left: 7px;\">" ;
			strHTML += "<tr><td valign=\"top\">PROJET : </td><td><select class=\"sel\" id=\"PRJ\"><option  value='004712'>004712</option><option  value='004728'>004728</option><option  value='004747'>004747</option><option  value='004795'>004795</option><option  value='004833'>004833</option><option  value='004836'>004836</option></select></td></tr>";
			strHTML += "<tr><td valign=\"top\">OPERATION : </td><td><select  class=\"sel\" id=\"OPR\"><option  value='RD'>RD</option><option  value='DEV'>DEV</option><option  value='DOC'>DOC</option><option  value='ASSIST'>ASSIST</option></select></td></tr>";
			strHTML += "<tr><td valign=\"top\">STATUT : </td><td><select  class=\"sel\" id=\"STAT\"><option  value=''>---------------------</option><option  value='OK'>OK</option><option  value='KO'>KO</option><option  value='EC'>EC</option></select></td></tr>";
			strHTML += "<tr><td valign=\"top\">COMMENTAIRES : </td><td><textarea rows=\"5\" id=\"COM\"></textarea></td></tr>" ;
			
			strHTML += "<tr><td colspan=\"2\"><br /><center><input type=\"button\" value=\"Modifier\" onclick=\"insertLDT();\"></center></td></tr></table>" ;
			
		document.getElementById('root').style.display = "block" ;
		document.getElementById('root').style.height = "300px" ;
		document.getElementById('root').style.width = "300px" ;
		document.getElementById('root').style.left = "70px" ;
		document.getElementById('root').style.top = "8px" ;
		document.getElementById('divflottant').innerHTML = strHTML;
		document.getElementById('handle').innerHTML = '<div id=\"handleTtl\" style=\"text-align: center\">Ligne de temps ING</div><img src="img/cl.png" style="float: right; margin-right: 5px;clear: none;margin-top: -25px; position: relative;" onclick="document.getElementById(\'root\').style.display = \'none\' ;">' ;
	}
	function insertLDT()
	{
		var PRJ = $("#PRJ").val();
		var OPR = $("#OPR").val();
		var STAT = $("#STAT").val();
		var COM = $("#COM").val();
		
		$.ajax({
		type: "GET",
		url: "php/link.php?action=insertLDT&PRJ="+PRJ+"&OPR="+OPR+"&STAT="+STAT+"&COM="+COM,
			success: function(msg){
				if (msg.length > 2)
				{
					alert(msg);
				}
			}
		});
		
		$("#root").hide(500);
	}
	function identification()
	{
		var log = $("#log").val();
		var mdp = $("#mdp").val();
		var response = "";
		$.ajax({
		type: "GET",
		url: "php/link.php?action=identification&log="+log+"&mdp="+mdp,async: false,

			success: function(msg){
				var s = 4;
				s=msg;
				if (s==1)
				{				
					$("#tab_login").hide("slow");					
					location.reload();					
				}
				else
				{
					alert(s);
				}
			}
		});
	}	

function showIt(elem)
{
	if ($.browser.msie && parseInt($.browser.version)<8) { 
		$(elem).show(100);
		return;
	}	
	$(elem).slideDown(100);
}

// #REGION popup fade principale
$('a.poplight[href^=#]').click(function() {
	var popID = $(this).attr('rel'); //Trouver la pop-up correspondante
	var popURL = $(this).attr('href'); //Retrouver la largeur dans le href

	//Récupérer les variables depuis le lien
	var query= popURL.split('?');
	var dim= query[1].split('&amp;');
	var popWidth = dim[0].split('=')[1]; //La première valeur du lien
	$('.popup_block').html($('#'+popID).html());
	//Faire apparaitre la pop-up et ajouter le bouton de fermeture
	$('.popup_block').fadeIn().css({
		'width': Number(popWidth)
	})	
	.prepend('<a href="#" class="close"><img src="img/close_pop.png" class="btn_close" title="Fermer" alt="Fermer" /></a>');

	//Récupération du margin, qui permettra de centrer la fenêtre - on ajuste de 80px en conformité avec le CSS
	var popMargTop = ($('#' + popID).height() + 80) / 2;
	var popMargLeft = ($('#' + popID).width() + 80) / 2;

	//On affecte le margin
	$('.popup_block').css({
		'margin-top' : -popMargTop,
		'margin-left' : -popMargLeft
	});
	
	//Effet fade-in du fond opaque
	$('body').append('<div id="fade"></div>'); //Ajout du fond opaque noir
	//Apparition du fond - .css({'filter' : 'alpha(opacity=80)'}) pour corriger les bogues de IE
	$('#fade').css({'filter' : 'alpha(opacity=80)'}).fadeIn();

	return false;
});

$('#valider_enquete').live('click', function() {



var priorite = $("input[name=priorite]:checked").val();

var score = ($("#Score").val() == '')?'0':$("#Score").val();
var Soarano = ($("#Soarano").val() == '')?'0':$("#Soarano").val();
var Ankorondrano = ($("#Ankorondrano").val() == '')?'0':$("#Ankorondrano").val();
var Alarobia = ($("#Alarobia").val() == '')?'0':$("#Alarobia").val();
var Andraharo = ($("#Andraharo").val() == '')?'0':$("#Andraharo").val();



if (priorite== undefined)
{
	alert('vous devez remplir tout les champs');
	return;
}
//alert("php/link.php?action=enquete&Andraharo="+Andraharo+"&priorite="+priorite+"&score="+score+"&Soarano="+Soarano+"&Ankorondrano="+Ankorondrano+"&Alarobia="+Alarobia);

		var response = "";
		$.ajax({
		type: "GET",
		url: "php/link.php?action=enquete&Andraharo="+Andraharo+"&priorite="+priorite+"&score="+score+"&Soarano="+Soarano+"&Ankorondrano="+Ankorondrano+"&Alarobia="+Alarobia,async: false,

			success: function(msg){
				if (msg==true)
				{	
				//alert(msg);

			
					alert('Merci');	
					
					
					$('#fade , .popup_block, #enquete').fadeOut(function() {
						$('#fade, a.close').remove();  //...ils disparaissent ensemble
					});
					
				}
				else
				{
					alert('Veuillez reesayer!');
				}
			}
		});
});

$('#enquete').click(function() {
	var popID = $(this).attr('rel'); //Trouver la pop-up correspondante
	var popURL = $(this).attr('href'); //Retrouver la largeur dans le href

	//Récupérer les variables depuis le lien
	var query= popURL.split('?');
	//var dim= query[1].split('&amp;');
	var content = $('#penquete');
	var htmlcontent = $('#penquete').html();
	var popWidth = 900; //La première valeur du lien
	$('.popup_block').html(htmlcontent);
	
	$('.popup_block').fadeIn().css({
		'width': '80%'
	})	
	.prepend('<a href="#" class="close"><img src="img/close_pop.png" class="btn_close" title="Fermer" alt="Fermer" /></a>');

	//Récupération du margin, qui permettra de centrer la fenêtre - on ajuste de 80px en conformité avec le CSS
	var popMargTop = ($('#penquete' ).height() + 80) / 2;
	var popMargLeft = ($('#penquete' ).width() + 80) / 2;

	//alert (htmlcontent);
	//On affecte le margin
	$('.popup_block').css({
		'top' : '10%',
		'left' : '10%'
	});
	
	//Effet fade-in du fond opaque
	$('body').append('<div id="fade"></div>'); //Ajout du fond opaque noir
	//Apparition du fond - .css({'filter' : 'alpha(opacity=80)'}) pour corriger les bogues de IE
	$('#fade').css({'filter' : 'alpha(opacity=80)'}).fadeIn();

	return false;
});

//Fermeture de la pop-up et du fond
$('a.close, #fade, #annuler_enquete').live('click', function() { //Au clic sur le bouton ou sur le calque...
	$('#fade , .popup_block').fadeOut(function() {
		$('#fade, a.close').remove();  //...ils disparaissent ensemble
	});
	return false;
});


// END REGION
</script>

</html>

