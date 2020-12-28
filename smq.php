<?php
	include_once('header.inc.php');
	include_once('php/common.php');
	$c = new Cnx();
	$divFluxImages  = $c->GetImageInDir('SLIDES comm SMQ');
	//echo $divFluxImages;exit();
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
<body style="background:white;">
	
<div id="popup_name" class="popup_block">


</div>
<center>


    <!-- Jssor Slider Begin -->
    <!-- You can move inline styles (except 'top', 'left', 'width' and 'height') to css file or css block. -->
     <div id="slider1_container" style="position: relative; width:800px;
        height: 400px; background-color:white;">

        <!-- Loading Screen -->
        <div u="loading" style="position: absolute; top: 0px; left: 0px;">
            <div style="filter: alpha(opacity=70); opacity:0.7; position: absolute; display: block;
                background-color: #000; top: 0px; left: 0px;width: 100%;height:100%;">
            </div>
            <div style="position: absolute; display: block; background: url(img/loading.gif) no-repeat center center;
                top: 0px; left: 0px;width: 100%;height:100%;">
            </div>
        </div>

        <!-- Slides Container -->
        <div u="slides" class="smq_slide" style="cursor: move; position: absolute; left: 0px; top: 0px; width: 800px; height: 400px;
            overflow: hidden;">
			<?php
				echo $divFluxImages;
			?>
		</div>
            

            
            <!--#region Arrow Navigator Skin Begin -->
            <!-- Help: http://www.jssor.com/development/slider-with-arrow-navigator-jquery.html -->
			
			
            <!-- Arrow Left -->
            <span u="arrowleft" class="jssora02l" style="top: 123px; left: 8px;">
            </span>
            <!-- Arrow Right -->
            <span u="arrowright" class="jssora02r" style="top: 123px; right: 8px;">
			
			
            </span>
			</div>
			<div id="fin" class="dfin blink"></div>
		</center>
		
		<div id="root">
		<div id="handle"></div>
		<div id="divflottant"></div>
</div>
		
    <!-- it works the same with all jquery version from 1.3.1 to 2.0.3 -->
    <script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
    <!-- use jssor.slider.mini.js (39KB) or jssor.sliderc.mini.js (31KB, with caption, no slideshow) or jssor.sliders.mini.js (26KB, no caption, no slideshow) instead for release -->
    <!-- jssor.slider.mini.js = jssor.sliderc.mini.js = jssor.sliders.mini.js = (jssor.core.js + jssor.utils.js + jssor.slider.js) -->
    <script type="text/javascript" src="js/jssor.slider.mini.js"></script>
    <script>
        //Reference http://www.jssor.com/development/slider-with-slideshow.html
        //Reference http://www.jssor.com/development/tool-slideshow-transition-viewer.html
		var now = new Date().getTime();
        var _SlideshowTransitions = [
        //Fade
        {$Duration: 700, $Opacity: 2, $Brother: { $Duration: 1000, $Opacity: 2} }
        ];
    </script>
    <script>
        jQuery(document).ready(function ($) {
			
            var options = {
                $FillMode: 1,                                       //[Optional] The way to fill image in slide, 0 stretch, 1 contain (keep aspect ratio and put all inside slide), 2 cover (keep aspect ratio and cover whole slide), 4 actuall size, default value is 0
                $DragOrientation: 0,                                //[Optional] Orientation to drag slide, 0 no drag, 1 horizental, 2 vertical, 3 either, default value is 1 (Note that the $DragOrientation should be the same as $PlayOrientation when $DisplayPieces is greater than 1, or parking position is not 0)
                $AutoPlay: false,                                    //[Optional] Whether to auto play, to enable slideshow, this option must be set to true, default value is false
                $AutoPlayInterval: 60000,  
				
				$ArrowNavigatorOptions: {                           //[Optional] Options to specify and enable arrow navigator or not
                    $Class: $JssorArrowNavigator$,                  //[Requried] Class to create arrow navigator instance
                    $ChanceToShow: 2,                               //[Required] 0 Never, 1 Mouse Over, 2 Always
                    $AutoCenter: 2,                                 //[Optional] Auto center arrows in parent container, 0 No, 1 Horizontal, 2 Vertical, 3 Both, default value is 0
                    $Steps: 1,                                      //[Optional] Steps to go for each navigation request, default value is 1
                    $Scale: false                                   //Scales bullets navigator or not while slider scale
                },
				//[Optional] Interval (in milliseconds) to go for next slide since the previous stopped if the slider is auto playing, default value is 3000
                $SlideshowOptions: {                                //[Optional] Options to specify and enable slideshow or not
                    $Class: $JssorSlideshowRunner$,                 //[Required] Class to create instance of slideshow
                    $Transitions: _SlideshowTransitions,            //[Required] An array of slideshow transitions to play slideshow
                    $TransitionsOrder: 1,                           //[Optional] The way to choose transition to play slide, 1 Sequence, 0 Random
                    $ShowLink: true                                    //[Optional] Whether to bring slide link on top of the slider when slideshow is running, default value is false
                }
            };

            //Make the element 'slider1_container' visible before initialize jssor slider.
            $("#slider1_container").css("display", "block");
            var jssor_slider1 = new $JssorSlider$("slider1_container", options);
			
			

            //responsive code begin
            //you can remove responsive code if you don't want the slider scales while window resizes
            function ScaleSlider() {
                var parentWidth = jssor_slider1.$Elmt.parentNode.clientWidth;
                if (parentWidth) {
                    jssor_slider1.$ScaleWidth(parentWidth - 30);
                }
                else
                    window.setTimeout(ScaleSlider, 30);
            }
			
			

            ScaleSlider();

            $(window).bind("load", ScaleSlider);
            $(window).bind("resize", ScaleSlider);
            $(window).bind("orientationchange", ScaleSlider);
            //responsive code end
			


           function DisplayHideArrow() {
				if (currentIndex == 0) {
					//hit first slide, display arrow right and hide arrow left
					jQuery(".jssora02r").show(); 
					jQuery(".jssora02l").hide(); 
				}
				else if (currentIndex == jssor_slider1.$SlidesCount - 1) {
					//hit last slide, display arrow left and hide arrow right
					jQuery(".jssora02r").hide(); 
					jQuery(".jssora02l").show(); 
				}
			}

        jssor_slider1.$On($JssorSlider$.$EVT_PARK, UpdateArrows);
			
			function UpdateArrows(currentIndex, previousIndex) {
			
				$('.jssora02l').css("visibility", "visible");
				$('.jssora02r').css("visibility", "visible");
				$('.dfin').css("visibility", "hidden");
				
				if (currentIndex == 0) {
					$('.jssora02l').css("visibility", "hidden");
                }
                else if (currentIndex == jssor_slider1.$SlidesCount() - 1) {
					$('.jssora02r').css("visibility", "hidden");
					$('.dfin').css("visibility", "visible");
                }				
			}
			
			
			
			
			
			
        });
		
		$(".dfin").click(function(){
				
				// var ti = new Date().getTime()-now;
				// alert(ti);
				// .click(function() {
				var popID = $(this).attr('rel'); //Trouver la pop-up correspondante
				var popURL = $(this).attr('href'); //Retrouver la largeur dans le href

				//Récupérer les variables depuis le lien
				// var query= popURL.split('?');
				//var dim= query[1].split('&amp;');
				// var content = $('#penquete');
				var htmlcontent = '';
				htmlcontent += "<h1 class='wtitle1'>... </h1><h1 class='wtitle1'>Si vous avez des remarques sur cette d&#233;marche, merci de les &#233;crire ci dessous, puis cliquez sur Terminer </h1><br/>";
				htmlcontent += "<input type=\text\" id=\"com\"  style=\"width:80%; font-size:24px; \"  ><br><br><br>" ;
				htmlcontent += "<input id = 'submit' type=\"button\" value=\"Terminer\" onclick=\"insertLDT();\" style=\"width:120px; font-size:24px; \" ><br><br>";
				
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
			
			function insertLDT(){
			
				var comment = $("#com").val();
				var durration = new Date().getTime()-now;
					$.ajax({
							type: "GET",
							url: "php/link.php?action=enqueteSMQ&comment="+comment+"&durration="+durration,
							success: function(msg){

									alert('Merci!');
									$('#fade , .popup_block, #enquete').fadeOut(function() {
										$('#fade, a.close').remove();  //...ils disparaissent ensemble
									});
									window.location = "index.php";
						}
					});
			}
		
				
				
				// $("#root").hide(500);
			
    </script>
	
</body>
</html>