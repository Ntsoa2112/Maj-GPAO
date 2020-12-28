<?php
// AUT Mirah RATAHIRY
// DES Reporting dossier etape
// DAT 2012 03 06
include_once('header.inc.php');
include_once('php/common.php');
?>

<div id="mcorps">
    <div id="head">
        <?php
        include('baniR.php');
        include('headMen2.php');
        if ((isset($_SESSION['error_msg'])) && (!empty($_SESSION['error_msg']))) {
            echo $_SESSION['error_msg'] . '<br>';
        }
        ?>
    </div>

    <div id="content" >

        <center>
            <div id="content_gauche" style="margin-top:30px;">
                <a href="#showH" id="showH" class="suivi_heure"> SUIVI HEURES/<blink>j</blink> </a>
                <!--<a href="#showDep"  id="showDep" class="suivi_heure">SUIVI DEPARTEMENT sur une periode</a>-->
                <a href="#showD"  id="showD" class="suivi_heure">SUIVI DOSSIERS sur une periode </a>
                <a href="#showDE"  id="showDE" class="suivi_heure">SUIVI Dossier par etape et par periode </a>
                <a href="#showLC"  id="showLC" class="suivi_heure">SUIVI Dossier par lot client et par periode </a>
                <a href="#showDet"  id="showDet" class="suivi_heure">SUIVI Dossier DETOURAGE </a>
                <a href="#showOP"  id="showOP" class="suivi_heure">SUIVI HEURES Op&eacute;rateurs</a>
                <hr />
                <div id="content_centre">
                    <?php
                    $c = new Cnx();
                    $strDate = $c->getDatePt();
                    ?>
                    <table id="hj" class="suiviHeure">
                        <tr>
                            <td>
                        <center>
                            <h4>SUIVI HEURES/j</h4>
                        </center>
                        </td>
                        </tr>
                        <tr>
                            <td>
                        <center>
                            <table>
                                <tr>
                                    <td>
                                        <span>Mois</span>
                                    </td>
                                    <td>
                                        <select  id="debDate">
                                            <option value=""></option>
                                            <?php
                                            echo $c->getMoisPt();
                                            ?>
                                        </select>
                                    </td>
                                    <td>
                                        <input type="submit" id="goDate" value="" class="recherche" title="Lancer la recherche"/>
                                        <input type="submit" id="copyDate" value="" class="copy" title="copier dans le presse papier"/>
                                    </td>
                                </tr>
                            </table>
                        </center>
                        </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="body" id="sHeure"></div>
                            </td>
                        </tr>
                    </table>

                    <table id="hop" class="suiviHeure">
                        <tr>
                            <td>
                        <center>
                            <table>

                                <tr>
                                    <td>
                                        Departement<br />
                                        <select  id="dep">
                                            <option value=""></option>;
                                            <?php
                                            echo '' . $c->getDepartement() . '';
                                            ?>
                                        </select>
                                    </td>

                                    <td>
                                        <span>matricule</span>
                                        <br />
                                        <input type="text" id="mat" />
                                    </td>

                                    <td>
                                        <span>Dossier</span>
                                        <br />
                                        <select  id="dossHeureOP">
                                            <option value=""></option>
                                            <?php
                                            echo $c->getLstDossier();
                                            ?>
                                        </select>
                                    </td>

                                    <td>
                                        <span>Debut</span>
                                        <br />
                                        <select  id="debPeriodeOP">
                                            <option value=""></option>
                                            <?php
                                            echo $strDate;
                                            ?>
                                        </select>
                                    </td>
                                    <td>
                                        <span>Fin</span>
                                        <br />
                                        <select  id="finPeriodeOP">
                                            <option value=""></option>
                                            <?php
                                            echo $strDate;
                                            ?>
                                        </select>
                                    </td>
                                    <td>
                                        <input type="submit" id="goOP"  value="" class="recherche" title="Lancer la recherche"/>
                                        <!--<input type="submit" id="copyPeriode" value="" class="copy" title="copier dans le presse papier"/>-->
                                    </td>
                                </tr>
                            </table>
                        </center>
                        </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="body" id="op"></div>
                            </td>
                        </tr>
                    </table>
                    <!--debut hpp--> 
                    <table id="hdp" class="suiviHeure">
                        <tr>
                            <td>
                        <center>
                            <h4>SUIVI DOSSIERS sur une periode</h4>
                        </center>
                        </td>
                        </tr>
                        <tr>
                            <td>
                        <center>
                            <table>

                                <tr>
                                    <td>
                                        <span>Dossier</span>
                                        <br />
                                    </td>
                                    <td>
                                        <select  id="idDossPeriod">
                                            <option value=""></option>
                                            <?php
                                            echo $c->GetDossierLibre();
                                            ?>
                                        </select>
                                        <br />
                                    </td>
                                    <td>
                                        <span>Debut</span>
                                        <br />
                                    </td>
                                    <td>
                                        <select  id="debPeriode">
                                            <option value=""></option>
                                            <?php
                                            echo $strDate;
                                            ?>
                                        </select>
                                    </td>
                                    <td>
                                        <span>Fin</span>
                                        <br />
                                    </td>
                                    <td>
                                        <select  id="finPeriode">
                                            <option value=""></option>
                                            <?php
                                            echo $strDate;
                                            ?>
                                        </select>
                                    </td>
                                    <td>
                                        <input type="submit" id="goPeriod"  value="" class="recherche" title="Lancer la recherche"/>
                                        <input type="submit" id="copyPeriode" value="" class="copy" title="copier dans le presse papier"/>
                                    </td>
                                </tr>
                            </table>
                        </center>
                        </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="body" id="periodique"></div>
                            </td>
                        </tr>
                    </table>
                    <!--fin suivi dossier sur une période-->
                    <!--debut suivi departement sur une période-->
                    <table id="hdpp" class="suiviHeure">
                        <tr>
                            <td>
                        <center>
                            <h4>SUIVI DEPARTEMENT sur une periode</h4>
                        </center>
                        </td>
                        </tr>
                        <tr>
                            <td>
                        <center>
                            <table>

                                <tr>
                                    <td>
                                        <span>Debut</span>
                                        <br />
                                    </td>
                                    <td>
                                        <select  id="debPeriodedep">
                                            <option value=""></option>
                                            <?php
                                            echo $strDate;
                                            ?>
                                        </select>
                                    </td>
                                    <td>
                                        <span>Fin</span>
                                        <br />
                                    </td>
                                    <td>
                                        <select  id="finPeriodedep">
                                            <option value=""></option>
                                            <?php
                                            echo $strDate;
                                            ?>
                                        </select>
                                    </td>
                                    <td>
                                        <input type="submit" id="goDepartement"  value="" class="recherche" title="Lancer la recherche"/>
                                        <input type="submit" id="copyDepartement" value="" class="copy" title="copier dans le presse papier"/>
                                    </td>
                                </tr>
                            </table>
                        </center>
                        </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="body" id="periodique"></div>
                            </td>
                        </tr>
                    </table>
                    <!--fin suivi departement sur une période-->



                    <table id="hde" class="suiviHeure">
                        <tr>
                            <td>
                        <center>
                            <h4>SUIVI Dossier par etape et par periode</h4>
                        </center>
                        </td>
                        </tr>
                        <tr>
                            <td>
                        <center>
                            <table>

                                <tr>

                                    <td>
                                        <span>Dossier</span>
                                        <br />
                                    </td>
                                    <td>
                                        <select  id="dossEtape">
                                            <option value=""></option>
                                            <?php
                                            echo $c->getLstDossier();
                                            ?>
                                        </select>
                                    </td>
                                    <td>
                                        <span>Debut</span>
                                        <br />
                                    </td>
                                    <td>
                                        <select  id="debEtape">
                                            <option value=""></option>
                                            <?php
                                            echo $strDate;
                                            ?>
                                        </select>
                                    </td>
                                    <td>
                                        <span>Fin</span>
                                        <br />
                                    </td>
                                    <td>
                                        <select  id="finEtape">
                                            <option value=""></option>
                                            <?php
                                            echo $strDate;
                                            ?>
                                        </select>
                                    </td>
                                    <td>
                                        <input type="submit" id="goEtape"  value="" class="recherche" title="Lancer la recherche"/>
                                        <input type="submit" id="copyEtape" value="" class="copy" title="copier dans le presse papier"/>
                                    </td>
                                </tr>
                            </table>
                        </center>
                        </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="body" id="Etape"></div>
                            </td>
                        </tr>
                    </table>
                    <table id="hdlc" class="suiviHeure">
                        <tr>
                            <td>
                        <center>
                            <h4>SUIVI Dossier par lot client et par periode</h4>
                        </center>
                        </td>
                        </tr>
                        <tr>
                            <td>
                        <center>
                            <table>

                                <tr>

                                    <td>
                                        <span>Dossier</span>
                                        <br />
                                    </td>
                                    <td>
                                        <select  id="dossLotClient">
                                            <option value=""></option>
                                            <?php
                                            echo $c->getLstDossier();
                                            ?>
                                        </select>
                                    </td>
                                    <td>
                                        <span>Debut</span>
                                        <br />
                                    </td>
                                    <td>
                                        <select  id="debLotClient">
                                            <option value=""></option>
                                            <?php
                                            echo $strDate;
                                            ?>
                                        </select>
                                    </td>
                                    <td>
                                        <span>Fin</span>
                                        <br />
                                    </td>
                                    <td>
                                        <select  id="finLotClient">
                                            <option value=""></option>
                                            <?php
                                            echo $strDate;
                                            ?>
                                        </select>
                                    </td>
                                    <td>
                                        <input type="submit" id="goLotclient"  value="" class="recherche" title="Lancer la recherche"/>
                                        <input type="submit" id="copyLotclient" value="" class="copy" title="copier dans le presse papier"/>
                                    </td>
                                </tr>
                            </table>
                        </center>
                        </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="body" id="Lotclient"></div>
                            </td>
                        </tr>
                    </table>
                    <table id="hdet" class="suiviHeure">
                        <tr>
                            <td>
                        <center>
                            <h4>SUIVI DETOURAGE</h4>
                        </center>
                        </td>
                        </tr>
                        <tr>
                            <td>
                        <center>
                            <table>
                                <tr>
                                    <td>
                                        <span>Client</span>
                                        <br />
                                    </td>
                                    <td>
                                        <select  id="groupeClient">
                                            <option value=""></option>
                                            <?php
                                            echo $c->getListGroupe();
                                            ?>
                                        </select>
                                    </td>
                                    <td>
                                        <span>Debut</span>
                                        <br />
                                    </td>
                                    <td>
                                        <select  id="debClient">
                                            <option value=""></option>
                                            <?php
                                            echo $strDate;
                                            ?>
                                        </select>
                                    </td>
                                    <td>
                                        <span>Fin</span>
                                        <br />
                                    </td>
                                    <td>
                                        <select  id="finClient">
                                            <option value=""></option>
                                            <?php
                                            echo $strDate;
                                            ?>
                                        </select>
                                    </td>
                                    <td>
                                        <input type="submit" id="goClient"  value="" class="recherche" title="Lancer la recherche"/>
                                        <input type="submit" id="copyClient" value="" class="copy" title="copier dans le presse papier"/>
                                    </td>
                                </tr>
                            </table>
                        </center>
                        </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="body" id="Client"></div>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </center>
    </div>
</div>
<!--<canvas id="cv5s" width="1500" height="400">[No canvas support]</canvas>-->

<?php
//include('footer.php');
?>
<div id="root">
    <div id="handle"></div>
    <div id="divflottant"></div>
</div>
</body>
<script language="javascript" type="text/javascript" src="js/jquery.js"></script>
<script language="javascript" type="text/javascript" charset="utf-8">

    function DrawGraph(data, label, toolTips, title) {
        var popWidth = $('#content').width();
        $('.hj').css({
            'left': Number(popWidth) - Number($('.hj').width()),
            'top': 200
        })

        $('#cvs').css({
            'width': Number(popWidth)
        })


        RGraph.ObjectRegistry.Clear();

        $('#content').height(700);
        var color = '#' + (function co(lor) {
            return (lor += [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 'a', 'b', 'c', 'd', 'e', 'f'][Math.floor(Math.random() * 16)]) && (lor.length == 6) ? lor : co(lor);
        })('');


        /*
         /*
         var data1 = [4,6,12,16,8,4,2,8,18,16,14,16];
         var data2 = [2,4,8,4,2,6,6,12,8,10,6,8];
         var label = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
         */
        /*
         var myLine = new RGraph.Line('cvs',data)
         .Set('labels', label)
         
         .Set('gutter.left', 40)
         .Set('gutter.right', 15)
         .Set('gutter.bottom', 20)
         .Set('colors', [color, 'black'])
         .Set('units.post', '')
         .Set('linewidth', 1)
         .Set('hmargin', 10)
         .Set('text.color', color)
         .Set('text.font', 'Arial')
         .Set('background.grid.autofit', true)
         .Set('background.grid.autofit.numvlines', 11)
         .Set('shadow', true)
         .Set('shadow.color', 'rgba(20,20,20,0.3)')
         .Set('shadow.blur',  10)
         .Set('shadow.offsetx', 0)
         .Set('shadow.offsety', 0)
         .Set('background.grid.vlines', false)
         .Set('background.grid.border', true)
         .Set('noxaxis', true)
         .Set('title', title)
         .Set('axis.color', '#666')
         .Set('text.color', color)
         .Set('spline', true)
         
         /**
         * Use the Trace animation to show the chart
         */
        /*
         if (ISOLD) {
         // IE7/8 don't support shadow blur, so set custom shadow properties
         myLine.Set('shadow.offsetx', 3)
         .Set('shadow.offsety', 3)
         .Set('shadow.color', '#aaa')
         .Draw();
         } else {
         //alert('tooltype');
         myLine.Set('tooltips', toolTips);
         RGraph.Effects.Line.jQuery.Trace(myLine, {'duration': 1000});
         }
         
         */

        var bar = new RGraph.Bar('cvs', data)
                .Set('labels', label)
                .Set('tooltips', toolTips)

                .Set('tooltips.event', 'onmousemove')

                .Set('strokestyle', 'white')
                .Set('linewidth', 2)
                .Set('shadow', true)
                .Set('shadow.offsetx', 0)
                .Set('shadow.offsety', 0)
                .Set('shadow.blur', 10)
                .Set('hmargin.grouped', 2)
                .Set('units.pre', 'h:')
                .Set('title', title)
                .Set('gutter.bottom', 20)
                .Set('gutter.left', 40)
                .Set('gutter.right', 15)
                .Set('colors', ['Gradient(white:rgba(255, 176, 176, 0.5))', 'Gradient(white:rgba(153, 208, 249,0.5))'])
                .Set('background.grid.autofit.numhlines', 5)
                .Set('background.grid.autofit.numvlines', 4)

        // This draws the chart
        RGraph.Effects.Fade.In(bar, {'duration': 250});
    }
//about:config
//signed.applets.codebase_principal_support;true

    var theHandle = document.getElementById("handle");
    var theRoot = document.getElementById("root");
    Drag.init(theHandle, theRoot);
    var idCV = $("#id").val();

    $("#goPeriod").click(function () {
        $("#periodique").hide();
        goPeriod();
        $("#periodique").html('<div class="body" id="periodique"><img src = "img/ramiLoad.gif"/>Loading ...</div>');
        $("#periodique").show('slow');
    });


    $("#goDepartement").click(function () {
        $("#depart").hide();
        goDepartement();
        $("#depart").html('<div class="body" id="depart"><img src = "img/ramiLoad.gif"/>Loading ...</div>');
        $("#depart").show('slow');
    });

    $("#showH").click(function () {

        hideAll();
        $("#cvs").show('slow');
        $("#hj").show('slow');
    });
    $("#showOP").click(function () {

        hideAll();
        $("#hop").show('slow');
    });
    $("#showD").click(function () {

        hideAll();
        $("#hdp").show('slow');
    });

    $("#showDep").click(function () {

        hideAll();
        $("#hdpp").show('slow');
    });


    $("#showDE").click(function () {

        hideAll();
        $("#hde").show('slow');
    });

    $("#showLC").click(function () {

        hideAll();
        $("#hdlc").show('slow');
    });
    $("#showDet").click(function () {

        hideAll();
        $("#hdet").show('slow');
    });
    function hideAll() {
        $("#cvs").hide();
        $("#hj").hide();
        $("#hop").hide();
        $("#hdp").hide();
        $("#hde").hide();
        $("#hdpp").hide();
        $("#hdlc").hide();
        $("#hdet").hide();
    }

    $("#goOP").click(function () {
        $("#op").hide();
        goOP();
        $("#op").html('<div class="body" id="op"><img src = "img/ramiLoad.gif"/>Loading ...</div>');
        $("#op").show('slow');
    });

    $("#showHeureJournalier").click(function () {
        $("#op").hide();
        showHeureJournalier();
        $("#op").html('<div class="body" id="op"><img src = "img/ramiLoad.gif"/>Loading ...</div>');
        $("#op").show('slow');
    });

    $("#goDate").click(function () {
        $("#sHeure").hide();
        goDate();
        $("#sHeure").html('<div class="body" id="sHeure"><img src = "img/ramiLoad.gif"/>Loading ...</div>');
        $("#sHeure").show('slow');
    });
    $("#goEtape").click(function () {
        $("#Etape").hide();
        goEtape();
        $("#Etape").html('<div class="body" id="Etape"><img src = "img/ramiLoad.gif"/>Loading ...</div>');
        $("#Etape").show('slow');
    });

    //pour la chargement de la liste des lot client
    $("#goLotclient").click(function () {
        $("#Lotclient").hide();
        goLotClient();
        $("#Lotclient").html('<div class="body" id="Etape"><img src = "img/ramiLoad.gif"/>Loading ...</div>');
        $("#Lotclient").show('slow');
    });
    //pour la chargement de la liste ded sous dossier  ceci est spécialement pour ledépartement DETOURAGE
    $("#goClient").click(function () {
        $("#Client").hide();
        goClient();
        $("#Client").html('<div class="body" id="Etape"><img src = "img/ramiLoad.gif"/>Loading ...</div>');
        $("#Client").show('slow');
    });


    $("#copyDate").click(function () {
        var textValue = new String(($("#sHeure").html()));
        copyToClipboard(html2Str(textValue));
    });
    $("#copyEtape").click(function () {
        var textValue = new String(($("#Etape").html()));
        copyToClipboard(html2Str(textValue));
    });
    $("#copyPeriode").click(function () {
        var textValue = new String(($("#periodique").html()));
        copyToClipboard(html2Str(textValue));
    });

    $("#logIN").click(function () {
        $("#tab_login").show("slow");
    });

    $("#submitLogin").click(function () {
        identification();
    });

    function html2Str(str) {
        var tab = new RegExp("</td><td>", "g");
        var ret = new RegExp("</td></tr><tr><td>", "g");
        var reg = new RegExp(" class=\"classe[0-9]\"", "g");
        var tb = new RegExp("<table class=\"[a-z]+\"><tbody><tr><td>", "g");

        str = str.replace(reg, "").replace(" class=\"rapport\"", "");
        str = str.replace(tab, "\t");
        str = str.replace(ret, "\n");
        str = str.replace(tb, "");
        str = str.replace("</td></tr></tbody></table>", "");
        return str;
    }

    function copyToClipboard(meintext) {
        if (window.clipboardData)
            window.clipboardData.setData("Text", meintext);
        else if (window.netscape) {
            netscape.security.PrivilegeManager.enablePrivilege('UniversalXPConnect');
            var clip = Components.classes['@mozilla.org/widget/clipboard;1'].createInstance(Components.interfaces.nsIClipboard);
            if (!clip)
                return false;
            var trans = Components.classes['@mozilla.org/widget/transferable;1'].createInstance(Components.interfaces.nsITransferable);
            if (!trans)
                return false;
            trans.addDataFlavor('text/unicode');
            var str = new Object();
            var len = new Object();
            var str = Components.classes["@mozilla.org/supports-string;1"].createInstance(Components.interfaces.nsISupportsString);
            str.data = meintext;
            trans.setTransferData("text/unicode", str, meintext.length * 2);
            var clipid = Components.interfaces.nsIClipboard;
            if (!clipid)
                return false;
            clip.setData(trans, null, clipid.kGlobalClipboard);
        }
        return false;
    }

    function goPeriod() {
        var deb = $("#debPeriode").val();
        var fin = $("#finPeriode").val();
        var dossier = $("#idDossPeriod").val();


        if (fin != "" && fin.replace(new RegExp("/", "g"), "") < deb.replace(new RegExp("/", "g"), "")) {
            alert("la date fin doit etre supperieur a la date debut!");
            return;
        }
        if (deb == "") {
            alert("choisissez la date debut!");
            return;
        }
        $.ajax({
            type: "GET",
            url: "php/link.php?action=goPeriod&deb=" + deb + "&fin=" + fin + "," + dossier,
            success: function (msg) {
                $("#periodique").html(msg);
            }
        });
    }

    function goOP() {
        var deb = $("#debPeriodeOP").val();
        var fin = $("#finPeriodeOP").val();
        var doss = $("#dossHeureOP").val();
        var departement = $("#dep").val();
        var matricule = $("#mat").val();

        if (fin != "" && fin.replace(new RegExp("/", "g"), "") < deb.replace(new RegExp("/", "g"), "")) {
            alert("la date fin doit etre supperieur a la date debut!");
            return;
        }
        if (deb == "") {
            alert("choisissez la date debut!");
            return;
        }
        $.ajax({
            type: "GET",
            url: "php/link.php?action=goOP&deb=" + deb + "&fin=" + fin + "&doss=" + doss + "&departement=" + departement + "&matricule=" + matricule,
            success: function (msg) {

                $("#cvs").show('slow');
                //$("#hj").show('slow');

                $("#op").html(msg);
                var heightOP = $("#content_centre").height();

                $("#sHeure").html(msg);
                //alert(heightOP);

                $("#content").css({'height': heightOP});

                var data = msg.split("$");

                var listeValeur = [];
                var listeLabel = [];
                var listToolTips = [];

                var i = 0;
                for (key in data) {
                    if (key == 0)
                        continue;
                    var token = data[key].split("'")[0].split('|');
                    var matricule = Number(token[0]);
                    var sommeHeure = Number(token[1]);
                    //alert(token);
                    listeValeur[i] = sommeHeure;
                    listeLabel[i] = matricule;
                    listToolTips[i] = sommeHeure;
                    i++;
                }

                // alert(listeValeur);
                // alert(listeLabel);
                DrawGraph(listeValeur, listeLabel, listToolTips, "Heure OP " + deb);

            }
        });
    }

    function showHeureJournalier() {
        var deb = $("#debPeriodeOP").val();
        var fin = $("#finPeriodeOP").val();
        var doss = $("#dossHeureOP").val();
        var departement = $("#dep").val();

        if (fin != "" && fin.replace(new RegExp("/", "g"), "") < deb.replace(new RegExp("/", "g"), "")) {
            alert("la date fin doit etre supperieur a la date debut!");
            return;
        }
        if (deb == "") {
            alert("choisissez la date debut!");
            return;
        }
        $.ajax({
            type: "GET",
            url: "php/link.php?action=goOP&deb=" + deb + "&fin=" + fin + "&doss=" + doss + "&departement=" + departement,
            success: function (msg) {

                $("#cvs").show('slow');
                //$("#hj").show('slow');

                $("#op").html(msg);
                $("#content").height = $("#op").height();

                $("#sHeure").html(msg);


                var data = msg.split("$");

                var listeValeur = [];
                var listeLabel = [];
                var listToolTips = [];

                var i = 0;
                for (key in data) {
                    if (key == 0)
                        continue;
                    var token = data[key].split("'")[0].split('|');
                    var matricule = Number(token[0]);
                    var sommeHeure = Number(token[1]);
                    //alert(token);
                    listeValeur[i] = sommeHeure;
                    listeLabel[i] = matricule;
                    listToolTips[i] = sommeHeure;
                    i++;
                }

                // alert(listeValeur);
                // alert(listeLabel);

                DrawGraph(listeValeur, listeLabel, listToolTips, "Heure OP " + deb);

            }
        });
    }

    function goEtape() {
        var deb = $("#debEtape").val();
        var fin = $("#finEtape").val();
        var doss = $("#dossEtape").val();

        if (doss == "") {
            alert("Selectionner un dossier!");
            return;
        }

        if (fin != "" && fin.replace(new RegExp("/", "g"), "") < deb.replace(new RegExp("/", "g"), "")) {
            alert("la date fin doit etre supperieur a la date debut!");
            return;
        }
        if (deb == "") {
            alert("choisissez la date debut!");
            return;
        }
        $.ajax({
            type: "GET",
            url: "php/link.php?action=goEtape&deb=" + deb + "&fin=" + fin + "&doss=" + doss,
            success: function (msg) {
                //alert(msg);
                $("#Etape").html(msg);
            }
        });
    }

    function goLotClient() {

        var deb = $("#debLotClient").val();
        var fin = $("#finLotClient").val();
        var doss = $("#dossLotClient").val();

        if (doss == "") {
            alert("Selectionner un dossier!");
            return;
        }

        if (fin != "" && fin.replace(new RegExp("/", "g"), "") < deb.replace(new RegExp("/", "g"), "")) {
            alert("la date fin doit etre supperieur a la date debut!");
            return;
        }
        if (deb == "") {
            alert("choisissez la date debut!");
            return;
        }
        $.ajax({
            type: "GET",
            url: "php/link.php?action=goLotclient&deb=" + deb + "&fin=" + fin + "&doss=" + doss,
            success: function (msg) {
                // alert(msg);
                $("#Lotclient").html(msg);
            }
        });
    }

    function goDate() {
        var deb = $("#debDate").val();

        if (deb == "") {
            alert("choisissez le mois!");
            exit();
        }
        $.ajax({
            type: "GET",
            url: "php/link.php?action=goDate&deb=" + deb,
            success: function (msg) {
                $("#sHeure").html(msg);

                // alert(msg);
                var data = msg.split("$");

                var listeValeur = [];
                var listeLabel = [];
                var listToolTips = [];

                var ArrayTemp = [];
                for (key in data) {
                    if (key == 0)
                        continue;
                    var token = data[key].split(">")[0].split('|');
                    var matricule = Number(token[0].slice(-2));
                    var sommeHeure = Number(token[1]);
                    //alert(token);
                    ArrayTemp[matricule] = sommeHeure;
                }

                for (i = 0; i < 32; i++) {
                    listeValeur[i] = 0;
                    if (ArrayTemp[i] != undefined)
                        listeValeur[i] = ArrayTemp[i];
                    listeLabel[i] = i + 1;
                }
                listToolTips = listeLabel;

                //DrawGraph(listeValeur, listeLabel, listToolTips, "Volume horaire - Mois " + deb);
            }
        });
    }

    function showIt(elem) {
        if ($.browser.msie && parseInt($.browser.version) < 8) {
            $(elem).show(100);
            return;
        }
        $(elem).slideDown(100);
    }

//fonction permettant de rescenser la liste des departement sur une période
    function goDepartement()
    {
        var deb = $("#debPeriodedep").val();
        var fin = $("#finPeriodedep").val();

        if (fin != "" && fin.replace(new RegExp("/", "g"), "") < deb.replace(new RegExp("/", "g"), "")) {
            alert("la date fin doit etre supperieur a la date debut!");
            return;
        }
        if (deb == "") {
            alert("choisissez la date debut!");
            return;
        }
        $.ajax({
            type: "GET",
            url: "php/link.php?action=goDepartement&deb=" + deb + "&fin=" + fin,
            success: function (msg) {
                alert(msg);

                $("#depart").html(msg);
            }
        });
    }

    function goClient()
    {
        var deb = $("#debClient").val();
        var fin = $("#finClient").val();
        var doss = $("#dossClient").val();
        var groupe = $("#groupeClient").val();

        if (fin != "" && fin.replace(new RegExp("/", "g"), "") < deb.replace(new RegExp("/", "g"), "")) {
            alert("la date fin doit etre supperieur a la date debut!");
            return;
        }
        if (deb == "") {
            alert("choisissez la date debut!");
            return;
        }
        $.ajax({
            type: "GET",
            url: "php/link.php?action=goClient&deb=" + deb + "&fin=" + fin + "&doss=" + doss + "&groupe=" + groupe,
            success: function (msg) {
                alert(msg);
                $("#Client").html(msg);
            }
        });
    }

    function deleteReport(str)
    {
        $.ajax({
            type: "GET",
            url: "php/link.php?action=deleteReport&id=" + str,
            success: function (msg) {
                //goLdt("");
            }
        });
    }
</script>
</html>

