<?php
include_once('header.incgpao.php');
include_once('php/common.php');
?>

<div id="myCarousel" class="carousel slide" data-ride="carousel" >
    <!-- Wrapper for slides -->
    <div id="myCarousel" class="carousel slide imgresp" data-ride="carousel">
        <!-- Indicators -->
        <ol class="carousel-indicators">
            <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
            <li data-target="#myCarousel" data-slide-to="1"></li>
            <li data-target="#myCarousel" data-slide-to="2"></li>
        </ol>

        <div class="carousel-inner" role="listbox">
            <div class="item active" class="col-lg-12">
                <img class="img-responsive" src = "img/ban1.jpeg" alt = "Image">
                <div class="carousel-caption">
                </div>
            </div>
            <div class="item" class="col-lg-12">
                <img class = "img-responsive" src = "img/ban2.jpg" alt = "Image">
                <div class = "carousel-caption">
                </div>
            </div>
            <div class="item" class="col-lg-12">
                <img class ="img-responsive" src ="img/ban3.jpg" alt ="Image">
                <div class ="carousel-caption">
                </div>
            </div>
            <!--
            <?php
            $dir = "img/ARO/*";
            foreach (glob($dir) as $file) {
                ?>
    <div class = "item" class = "col-lg-12">
    <img class = "img-responsive" src = "<?php echo $file; ?>" alt = "Image">
    <div class = "carousel-caption">
    </div>
    </div>
                <?php
            }
            ?>-->
        </div>

        <!-- Left and right controls -->
        <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
            <span class="fa fa-chevron-left" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
            <span class="fa fa-chevron-right" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
</div>
<div id="mcorps">

    <div id="head">
        <?php
        include_once('baniR.php');
        include_once('headMen.php');

        $c = new Cnx();
        $divFlux = $c->GetFluxRss("", "", "", "", "", "");
        //echo $c->GetIOUser();
        ?>
    </div>

    <!-- MENU DROITRE -->
<?php
if ((isset($_SESSION['pseudo'])) && (!empty($_SESSION['pseudo'])))
    if ($_SESSION['id_droit'] == 2 || $_SESSION['id_droit'] == 3 || $_SESSION['id_droit'] == 5 || $_SESSION['id_droit'] == 4 || $_SESSION['id_droit'] == 7) {
        ?>
<!--            <tr><td><a  title="Gestion documentaire alfresco"  class="hvr-bounce-in" href="http://doc.easytech.mg/share/page/" class="ri" ><img src="img/dossier.png" width="100px;"></img><br><span>ALFRESCO</span></a></td></tr>
            <tr><td><a   title="Gestion des non conformité" class="hvr-bounce-in" href="http://smq.easytech.mg/login?" class="ri"  ><img  width="100px;" src="img/clipboard.png"></img><br><span>Non conformité</span></a></td></tr>-->
        <?php
    }
//if ((isset($_SESSION['pseudo'])) && (!empty($_SESSION['pseudo']))) 
//echo $c->enqueteDejaFait('ALL',"enquete_medaille");
?>

    <?php
    if ((isset($_SESSION['pseudo'])) && (!empty($_SESSION['pseudo'])))
        if (!$c->enqueteDejaFait('', "enquete_Localisation_Bureau")) {
            ?>
            <tr><td><a href="LocalisationBureauEasytech.php" class="ri blink" style="background-color:#06c2e3" ><h3 class="blink">Enquete</h3></a></td></tr> 
            <?php
        }
    if ((isset($_SESSION['pseudo'])) && (!empty($_SESSION['pseudo'])))
    //ho '<p class="top100">'.$c->enqueteDejaFait('ALL',"enquete_Localisation_Bureau").'</p>';
        
        ?> 
    <!-- /MENU DROITRE -->
	

    <div id="content">

        <!-- ********************************************************************************************************************************** -->

        <!-- ********************************************************************************************************************************** -->

        <center>

            <!-- NEw -->

            <div id="content" class="bodyWrap">
				<div class="row main-slider" style="float: none;margin-left: 10%;margin-right: 10%;">
					</div>

                <!-- Projects Row -->
                <div class="row  main-slider" style="float: none;margin-left: auto;margin-right: auto;">
                    <div class="col-md-4 text-center wow fadeInLeft block" data-wow-duration="2000ms" data-wow-delay="300ms" >


                        <div class="mini">

                            <h3><a href="http://doc.easytech.mg/share/page/" target="blank" class="margin">Reglement interieur</a></h3>

                            <div id="slider1_container" class="text-center col-md-4" style="position: relative; top: 0px; left: 0px; width: 400px; height: 200px;">

                                <div u="loading" class="hidden" style="position: absolute; top: 0px; left: 0px;">
                                    <div style="filter: alpha(opacity=70); opacity:0.7; position: absolute; display: block;
                                         background-color: #000000; top: 0px; left: 0px;width: 100%;height:100%;">
                                    </div>
                                    <div style="position: absolute; display: block; background: url(img/loading.gif) no-repeat center center;
                                         top: 0px; left: 0px;width: 100%;height:100%;">
                                    </div>
                                </div>

                                <div u="slides" style="cursor: move; position: absolute; center: 100px; top: 10px; width: 400px; height: 340px;overflow: hidden;">
<?php echo $divFlux; ?>
                                </div>

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

                                <span u="arrowleft" class="jssorn08l" style="width: 50px; height: 50px; top: 8px; left: 8px;">
                                </span>
                                <span u="arrowright" class="jssorn08r" style="width: 50px; height: 50px; bottom: 8px; left: 8px">
                                </span>
                            </div> 
<?php
$color = substr(md5(rand()), 0, 6);

function rand_color7() {
    return '#' . str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT);
}
?>
                        </div> 

                        <a class="btn btn-primary " href="ri.htm" target="blank" class="margin"><i class="fa fa-hand-o-right fa-lg"></i> Reglement interieur <i class="fa fa-angle-right"></i></a>

                    </div>

                    <div class="col-md-4 text-center wow scaleIn block" data-wow-duration="500ms" data-wow-delay="300ms">
                        <div class="mini">
                            <h3><a href="#">Recrutement</a></h3>
                            <!--<img src="img/recrutement.jpg" height="600" width="450" >-->
                            <div class="col-lg-5 col-lg-5 col-lg-5">
                                <a class="thumbnail" href="#" data-image-id="" data-toggle="modal" data-title="Recrutement" data-image="img/recrutement.jpg" data-target="#image-gallery">
                                    <img class="img-responsive" src="img/recrutement.jpg" alt="Another alt text">
                                </a>
                            </div>
                        </div>
                        <a class="btn btn-primary " href="#" data-image-id="" data-toggle="modal" data-title="Recrutement" data-image="img/recrutement.jpg" data-target="#image-gallery" ><i class="fa fa-hand-o-right fa-lg"></i>  Recrutement <i class="fa fa-angle-right"></i></a>
                    </div>

                    <div class="col-md-4 text-center wow fadeInRight block" data-wow-duration="2000ms" data-wow-delay="300ms">
                        <div class="mini">
                            <h3><a href="http://smq.easytech.mg/login?" target="blank" class="margin">SMQ</a></h3>
                            <div id="myCarousel2" class="carousel slide" data-ride="carousel">
                                <ol class="carousel-indicators">
                                    <li data-target="#myCarousel2" data-slide-to="0" class="active"></li>
                                    <li data-target="#myCarousel2" data-slide-to="1"></li>
                                </ol>

                                <div class="carousel-inner" role="listbox">
                                    <div class="item active">
                                        <div class="col-lg-5">
                                            <a class="thumbnail" href="#" data-image-id="" data-toggle="modal" data-title="SMQ" data-image="img/DO_SMQ_POQ_Politique_qualité_20150826.jpg" data-target="#image-gallery">
                                                <img  class="img-responsive" src="img/DO_SMQ_POQ_Politique_qualité_20150826.jpg" alt="Another alt text"/>
                                            </a>
                                        </div>
                                    </div>

                                    <div class="item col-lg-5">
                                        <a  title="Gestion documentaire alfresco"  class="hvr-bounce-in" href="http://doc.easytech.mg/share/page/" class="ri" target="blank" >
                                            <img class="img-responsive" src="img/dossier.png" alt="Alfresco">
                                        </a>
                                        <br><span>ALFRESCO</span>
                                    </div>
                                      <div class="item col-lg-5">
                                          <a   title="Gestion des non conformité" class="hvr-bounce-in" href="http://smq.easytech.mg/login?" class="ri"  target="blank" >
                                            <img class="img-responsive" src="img/clipboard.png" alt="Alfresco">
                                        </a>
                                        <br><span>Non conformité</span>
                                    </div>
                                  <div class="item">
                                        <p class="text-justify"><b>Politique qualit&#233; d'EASYTECH-INOVCOM (r&#233;sum&#233;)</b> </p>
                                        <p class="text-justify">1-  Am&#233;lioration continue</p>
                                        <p class="text-justify">2-  Satisfaction client et parties prenantes</p>
                                        <p class="text-justify">3-  Qualit&#233; des prestations</p>
                                        <p class="text-justify">4- Valorisation des Collaborateurs</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <a class="btn btn-primary " href="http://smq.easytech.mg/login?" target="blank"><i class="fa fa-hand-o-right fa-lg"></i> SMQ <i class="fa fa-angle-right"></i></a>
                    </div>

<?php
if ((isset($_SESSION['pseudo'])) && (!empty($_SESSION['pseudo'])))
    if ($_SESSION['id_droit'] == 2 || $_SESSION['id_droit'] == 3 || $_SESSION['id_droit'] == 5 || $_SESSION['id_droit'] == 4 || $_SESSION['id_droit'] == 7) {
        ?>
                            <!-- ATOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOO -->
                            <?php
                        }
                    ?>
                </div>
                <!-- /.row -->
                <!-- /NEw -->
                <center>
                    <div id="content_centre">
                        <hr>
<?php
include('corps.php');
?>
                    </div>	
                </center>
            </div>
        </center>
    </div>


    <!-- MODAL <a href="#" data-toggle="modal" data-target="#login-modal">Login</a> -->

    <div class="modal fade" id="login-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="loginmodal-container">

                <form class="form-signin mg-btm">
                    <h3 class="heading-desc">Identification</h3>

                    <div class="main">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-user"></i></span>
                            <input type="text" name="user" placeholder="Identifiant" id="log">
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                            <input type="password" name="pass" placeholder="Mot de passe" id="mdp" required="true">
                        </div>

                        <div class="row">
                            <div class="col-xs-6 col-md-6 pull-right">
                                <button type="submit" class="btn btn-large btn-primary pull-right" name="login" id="submitLogin">Connexion</button>
                            </div>
                        </div>
                    </div>

                </form>

            </div>
        </div>
    </div>


    <!--modal IMAGE -->
    <div class="modal fade" id="image-gallery" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="image-gallery-title"></h4>
                </div>
                <div class="modal-body">
                    <img id="image-gallery-image" class="img-responsive" src="">
                </div>
            </div>
        </div>
    </div>
	
	
	<!--modal MAP -->
    <div class="modal fade" id="map-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="image-gallery-title">Carte</h4>
                </div>
                <div class="modal-body">
                    <!DOCTYPE html>
                    <html>
                    <head>
                        <style type="text/css">
                        html, body { height: 100%; margin: 0; padding: 0; }
                        #map { height: 100%; }
                        </style>
                    </head>
                    <body>
                        <div id="map"></div>
                        <script type="text/javascript">

                    var map;
                    function initMap() {
                    map = new google.maps.Map(document.getElementById('map'), {
                        center: {lat: -18.917106, lng: 47.546985},
                        zoom: 18
                    });
                    }

                        </script>
                        <script async defer
                        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC_3tNUBCAeWoTHRvhg1V4zJzVrcgO-zMA&callback=initMap">
                        </script>
                    </body>
                    </html>
                </div>
            </div>
        </div>
    </div>
	
	


    <!-- /MODAL -->

    <div id="root">
        <div id="handle"></div>
        <div id="divflottant"></div>
    </div>
</div>
</body>

<?php
include('footer.php');
?>

<!-- DEBUT SCRIPT_______________________________________________________________________________________________________________________ -->

<!-- NEW SCRIPT -->

<!-- jQuery -->

<script>

    $(document).ready(function () {

        loadGallery(true, 'a.thumbnail');

        //This function disables buttons when needed
        function disableButtons(counter_max, counter_current) {
            $('#show-previous-image, #show-next-image').show();
            if (counter_max == counter_current) {
                $('#show-next-image').hide();
            } else if (counter_current == 1) {
                $('#show-previous-image').hide();
            }
        }

        /**
         *
         * @param setIDs        Sets IDs when DOM is loaded. If using a PHP counter, set to false.
         * @param setClickAttr  Sets the attribute for the click handler.
         */

        function loadGallery(setIDs, setClickAttr) {
            var current_image,
                    selector,
                    counter = 0;

            $('#show-next-image, #show-previous-image').click(function () {
                if ($(this).attr('id') == 'show-previous-image') {
                    current_image--;
                } else {
                    current_image++;
                }

                selector = $('[data-image-id="' + current_image + '"]');
                updateGallery(selector);
            });

            function updateGallery(selector) {
                var $sel = selector;
                current_image = $sel.data('image-id');
                $('#image-gallery-caption').text($sel.data('caption'));
                $('#image-gallery-title').text($sel.data('title'));
                $('#image-gallery-image').attr('src', $sel.data('image'));
                disableButtons(counter, $sel.data('image-id'));
            }

            if (setIDs == true) {
                $('[data-image-id]').each(function () {
                    counter++;
                    $(this).attr('data-image-id', counter);
                });
            }
            $(setClickAttr).on('click', function () {
                updateGallery($(this));
            });
        }
    });

</script>



<!-- /NEW SCRIPT -->


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
                    $AutoPlay: true, //[Optional] Whether to auto play, to enable slideshow, this option must be set to true, default value is false
                    $PlayOrientation: 2, //[Optional] Orientation to play slide (for auto play, navigation), 1 horizental, 2 vertical, default value is 1
                    $DragOrientation: 2, //[Optional] Orientation to drag slide, 0 no drag, 1 horizental, 2 vertical, 3 either, default value is 1 (Note that the $DragOrientation should be the same as $PlayOrientation when $DisplayPieces is greater than 1, or parking position is not 0)

                    $DirectionNavigatorOptions: {
                        $Class: $JssorDirectionNavigator$, //[Requried] Class to create direction navigator instance
                        $ChanceToShow: 2, //[Required] 0 Never, 1 Mouse Over, 2 Always
                        $AutoCenter: 1, //[Optional] Auto center arrows in parent container, 0 No, 1 Horizontal, 2 Vertical, 3 Both, default value is 0
                        $Steps: 1                                       //[Optional] Steps to go for each navigation request, default value is 1
                    }
                };

                var jssor_slider1 = new $JssorSlider$("slider1_container", options);



            });





            var theHandle = document.getElementById("handle");
            var theRoot = document.getElementById("root");
            Drag.init(theHandle, theRoot);
            var idCV = $("#id").val();

            $("#fermer").click(function () {
                $("#tab_login").hide("slow");
            });

            $("#goMd5").click(function () {
                var val = $("#md5").val();

                $.ajax({
                    type: "GET",
                    url: "php/link.php?action=md5&val=" + val,
                    success: function (msg) {
                        $("#result").val(msg);
                    }
                });
            });

            /* fonction qui check que l'element n'est pas encore utilisé */
            /*
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
             
             */

            $("#logIN").click(function () {
                $("#tab_login").show("slow");
            });

            $("#submitLogin").click(function () {
                //alert('ok');
                identification();
            });

            $('#mdp').bind('keypress', function (e) {
                if (e.keyCode == 13) {
                    identification();
                }
            });


            function newLdt()
            {
                var strHTML = "";
                strHTML += "<table style=\"margin-top: 20px;margin-left: 7px;\">";
                strHTML += "<tr><td valign=\"top\">PROJET : </td><td><select class=\"sel\" id=\"PRJ\"><option  value='004712'>004712</option><option  value='004728'>004728</option><option  value='004747'>004747</option><option  value='004795'>004795</option><option  value='004833'>004833</option><option  value='004836'>004836</option></select></td></tr>";
                strHTML += "<tr><td valign=\"top\">OPERATION : </td><td><select  class=\"sel\" id=\"OPR\"><option  value='RD'>RD</option><option  value='DEV'>DEV</option><option  value='DOC'>DOC</option><option  value='ASSIST'>ASSIST</option></select></td></tr>";
                strHTML += "<tr><td valign=\"top\">STATUT : </td><td><select  class=\"sel\" id=\"STAT\"><option  value=''>---------------------</option><option  value='OK'>OK</option><option  value='KO'>KO</option><option  value='EC'>EC</option></select></td></tr>";
                strHTML += "<tr><td valign=\"top\">COMMENTAIRES : </td><td><textarea rows=\"5\" id=\"COM\"></textarea></td></tr>";

                strHTML += "<tr><td colspan=\"2\"><br /><center><input type=\"button\" value=\"Modifier\" onclick=\"insertLDT();\"></center></td></tr></table>";

                document.getElementById('root').style.display = "block";
                document.getElementById('root').style.height = "300px";
                document.getElementById('root').style.width = "300px";
                document.getElementById('root').style.left = "70px";
                document.getElementById('root').style.top = "8px";
                document.getElementById('divflottant').innerHTML = strHTML;
                document.getElementById('handle').innerHTML = '<div id=\"handleTtl\" style=\"text-align: center\">Ligne de temps ING</div><img src="img/cl.png" style="float: right; margin-right: 5px;clear: none;margin-top: -25px; position: relative;" onclick="document.getElementById(\'root\').style.display = \'none\' ;">';
            }
            function insertLDT()
            {
                var PRJ = $("#PRJ").val();
                var OPR = $("#OPR").val();
                var STAT = $("#STAT").val();
                var COM = $("#COM").val();

                $.ajax({
                    type: "GET",
                    url: "php/link.php?action=insertLDT&PRJ=" + PRJ + "&OPR=" + OPR + "&STAT=" + STAT + "&COM=" + COM,
                    success: function (msg) {
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
                var log = $("#log").val().trim();
                var mdp = $("#mdp").val().trim();

        if (mdp === "")
        {
           // alert("mot de passe  vide");
            return;
        }

                //alert(encodeURI(mdp));
                mdp = encodeURIComponent(mdp);
                var response = "";
                $.ajax({
                    type: "GET",
                    url: "php/link.php?action=identification&log=" + log + "&mdp=" + mdp, async: false,
                    success: function (msg) {
                        var s = 4;
                        s = msg;
                        if (s == 1)
                        {
                            $("#tab_login").hide("slow");
                            location.reload();
                            //location.href = "http://gpao.easytech.mg/index.php";
                        } else
                        {
                            alert("Login ou mot de passe incorecte!");
                        }
                    }
                });
            }

            function showIt(elem)
            {
                if ($.browser.msie && parseInt($.browser.version) < 8) {
                    $(elem).show(100);
                    return;
                }
                $(elem).slideDown(100);
            }

// #REGION popup fade principale
            $('a.poplight[href^=#]').click(function () {
                var popID = $(this).attr('rel'); //Trouver la pop-up correspondante
                var popURL = $(this).attr('href'); //Retrouver la largeur dans le href

                //Récupérer les variables depuis le lien
                var query = popURL.split('?');
                var dim = query[1].split('&amp;');
                var popWidth = dim[0].split('=')[1]; //La première valeur du lien
                $('.popup_block').html($('#' + popID).html());
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
                    'margin-top': -popMargTop,
                    'margin-left': -popMargLeft
                });

                //Effet fade-in du fond opaque
                $('body').append('<div id="fade"></div>'); //Ajout du fond opaque noir
                //Apparition du fond - .css({'filter' : 'alpha(opacity=80)'}) pour corriger les bogues de IE
                $('#fade').css({'filter': 'alpha(opacity=80)'}).fadeIn();

                return false;
            });

            /*
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
             */
            $('#enquete').click(function () {
                var popID = $(this).attr('rel'); //Trouver la pop-up correspondante
                var popURL = $(this).attr('href'); //Retrouver la largeur dans le href

                //Récupérer les variables depuis le lien
                var query = popURL.split('?');
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
                var popMargTop = ($('#penquete').height() + 80) / 2;
                var popMargLeft = ($('#penquete').width() + 80) / 2;

                //alert (htmlcontent);
                //On affecte le margin
                $('.popup_block').css({
                    'top': '10%',
                    'left': '10%'
                });

                //Effet fade-in du fond opaque
                $('body').append('<div id="fade"></div>'); //Ajout du fond opaque noir
                //Apparition du fond - .css({'filter' : 'alpha(opacity=80)'}) pour corriger les bogues de IE
                $('#fade').css({'filter': 'alpha(opacity=80)'}).fadeIn();

                return false;
            });
            /*
             //Fermeture de la pop-up et du fond
             $('a.close, #fade, #annuler_enquete').live('click', function() { //Au clic sur le bouton ou sur le calque...
             $('#fade , .popup_block').fadeOut(function() {
             $('#fade, a.close').remove();  //...ils disparaissent ensemble
             });
             return false;
             });
             
             */
// END REGION
</script>

<script>

    $(document).ready(function () {
        $('.slider2').bxSlider({
            slideWidth: 300,
            minSlides: 1,
            maxSlides: 1,
            slideMargin: 10
        });
    });
</script>

<!-- FIN SCRIPT____________________________________________________________________________________________________________________________ -->
</html>

