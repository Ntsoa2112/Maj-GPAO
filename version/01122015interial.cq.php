<?php
include_once('header.inc.php');
include_once('php/common.php');

// AUT Mirah RATAHIRY
// DES page Lot de tous les dossiers
// DAT 2012 03 06
?>

<div id="mcorps">
    <div id="head">
        <?php
        include('baniR.php');
        include('headMen.php');
        if ((isset($_SESSION['error_msg'])) && (!empty($_SESSION['error_msg']))) {
            echo $_SESSION['error_msg'] . '<br>';
        }
        ?>
    </div>

    <div id="content">
        <center>
            <hr/>
            <?php
            $c = new Cnx();
            $strDate = $c->getDatePt();
            $strCat = $c->getLstCategorie();
            ?>

            <div id="content_centre">
                <h1 class="bigger lighter">INTERIAL ALMERYS</h1>
                <table id="lot">
                    <tr  class="tb_header widget-header header-color-blue">
                        <td>
                            <table>
                                <tr>
                                    <td>
                                        <select  id="doss" class="hide"><option value=""></option>
                                            <option value="201" selected="true">CQ_ALMERYS</option>
                                        </select>
                                    </td>
                                    <td>						
                                        <span>POLE</span><br/>
                                        <select  id="ldg">

                                        </select>
                                    </td>
                                    <td>	
                                        <span>STATUT</span><br/>
                                        <select  id="etape"><option value=""></option>

                                        </select>
                                    </td>
                                    <td id="hiddenCtg">	
                                        <span>CATEGORIE</span><br/>
                                        <select  id="catg">
                                            <?php
                                            echo $strCat;
                                            // echo "to be continued"
                                            ?>
                                        </select>
                                    </td>
                                    <td>	
                                        <span>DATE DEBUT</span><br/>
                                        <select  id="deb"><option value=""></option>
                                            <?php
                                            echo $strDate;
                                            ?>
                                        </select>
                                    </td>
                                    <td>	
                                        <span>DATE FIN</span><br/>
                                        <select  id="fin"><option value=""></option>
                                            <?php
                                            echo $strDate;
                                            ?>
                                        </select>
                                    </td>

                                    <td>	
                                        <span>matricule</span><br/>
                                        <input type="text" id="mat" />
                                    </td>


                                    <td>
                                        <span> </span><br/>
                                        <input type="submit" id="goLdt"  value="" title="lancer la recherche" class="recherche"/>
                                        <input type="submit" id="goLdtStat"  value="" title="Statistique" class="statistique"/>
                                        <input type="submit" id="goLdtCat"  value="" title="Categorie" class="categorie"   />
                                    </td>	
                                </tr>
                            </table>
                        </td>						
                    </tr>

                    <tr>
                        <td>										
                            <div id="ldtCorp">
                                <?php
//include('corps.php');
                                ?>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>

        </center>
    </div>
    <?php
    include('footer.php');
    ?>

</div>
<div id="root">
    <div id="handle"></div>
    <div id="divflottant"></div>
</div>
</body>
<script language="javascript" type="text/javascript" src="js/jquery.js"></script>
<script language="javascript" type="text/javascript" charset="utf-8">
// AUT Mirah RATAHIRY
// DES page Lot de tous les dossiers
// DAT 2012 03 06
    //about:config
    //signed.applets.codebase_principal_support;true
    var flagShow = 1;
    var classErr;

    var theHandle = document.getElementById("handle");
    var theRoot = document.getElementById("root");
    Drag.init(theHandle, theRoot);

    function DrawGraph(data, arrayLabel)
    {
        var arrayColor = [];
        var i = 0;
        for (key in data)
        {
            arrayColor[i] = '#' + (function co(lor) {
                return (lor += [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 'a', 'b', 'c', 'd', 'e', 'f'][Math.floor(Math.random() * 16)]) && (lor.length == 6) ? lor : co(lor);
            })('');
            i++;
        }
        var pie = new RGraph.Pie('cvs', data)
                .Set('strokestyle', 'white')
                .Set('colors', arrayColor)
                .Set('linewidth', 3)
                .Set('exploded', [15, ])
                .Set('shadow', true)
                .Set('shadow.offsetx', 0)
                .Set('shadow.offsety', 0)
                .Set('shadow.blur', 20)
                .Set('labels', arrayLabel)
                .Set('labels.sticks', [true])
                .Set('labels.sticks.length', 20)

        RGraph.Effects.Pie.RoundRobin(pie)
    }

    $('#cvs').click(function() {
        $('#cvs').hide();
    });

    $(document).ready(function() {

        //DrawGraph([1,2,3, 4], ["1","2","3","4"]);

        var idDoss = $("#doss").val();
        getLotClient(201);
        getLstEtape(idDoss);


        $('#mcorps').on('click', '#selectall', function() {
            $('.case').attr('checked', this.checked);
        });

        $('#ldtCorp').on('click', '.th', function() {
            goLdt(this.id);
        });

        $('#root').on('click', '#STAT option', function() {

            $(".ALMERYS_ERR_TYPE").hide();
            classErr = "." + $("#STAT").val();
            //alert(classErr);
            $(classErr).show();

        });
    });

    $("#showHide").click(function() {
        if (flagShow == 0)
        {
            $("#sh").css("display", 'none');
            $("#oContent").slideUp(1000);
            flagShow = 1;
            $("#hd").css("display", 'block');
        }
        else
        {
            $("#hd").css("display", 'none');
            $("#oContent").slideDown(1000);
            flagShow = 0;
            $("#sh").css("display", 'block');
        }
    });
    $("#goLdt").click(function() {
        goLdt("");
    });
    $("#goLdtStat").click(function() {
        goLdt("stat");
    });


    $('.th').click(function() {
        alert("ok");
    });
    function updateLdt(str)
    {
        getLdt(str);
    }
    function deleteLot(idLot)
    {
        $.ajax({
            type: "GET",
            url: "php/link.php?action=delLot&id=" + idLot,
            success: function(msg) {
                goLdt("");
            }
        });
    }
    function updateLot(etat, priorite, mat)
    {
        var lstID = "";
        var nb = 0;
        $("input:checked").each(
                function() {
                    nb++;
                    if ($(this).attr("id") != 'selectall')
                        lstID += "," + $(this).attr("id");
                }
        );

        if (nb != 0)
        {
            lstID = lstID.substring(1);
            $.ajax({
                type: "GET",
                url: "php/link.php?action=updateLot&lstId=" + lstID + "&etat=" + etat + "&prio=" + priorite + "&mat=" + mat,
                success: function(msg) {
                    //alert(msg);
                    goLdt("");
                }
            });
        }
        else
            alert("Veuillez selectionner les lots a traiter!");
    }
    $("#btSetPrio").click(function() {
        var prio = $("#prio").val();
        updateLot("", prio, "");
    });
    $("#reinitialiser").click(function() {
        updateLot(0, "", "");
    });
    $("#Affecter").click(function() {
        var mat = $("#matricule").val();
        //alert(mat);
        updateLot(1, "", mat);

    });

    $("#Initialiser").click(function() {
        var mat = $("#matricule").val();
        //alert(mat);
        $.ajax({
            type: "GET",
            url: "php/link.php?action=initMat&mat=" + mat,
            success: function(msg) {
                //alert(msg);
                //goLdt("");
            }
        });
    });

    $("#bloquer").click(function() {
        updateLot(6, "", "");
    });
    $("#terminer").click(function() {
        updateLot(2, "", "");
    });
    $("#annomalie").click(function() {
        updateLot(3, "", "");
    });
    $("#doss").change(function() {
        var idDoss = $("#doss").val();
        getLotClient(idDoss);
        getLstEtape(idDoss);
    });



    function html2Str(str)
    {
        var tab = new RegExp("</td><td>", "g");
        var ret = new RegExp("</td></tr><tr><td>", "g");
        var reg = new RegExp(" class=\"classe[0-9]\"", "g");
        var id = new RegExp(" id=\"[0-9]+\"", "g");
        var id2 = new RegExp("><td>", "g");
        var id3 = new RegExp("</td></tr><tr", "g");
        var id4 = new RegExp("</td><td onclick=\"updateLdt\\('[0-9]+'\\)\" class=\"edit\">", "g");
        var id5 = new RegExp("</th><th>", "g");
        var id6 = new RegExp("<table><thead><tr><th>", "g");
        var id7 = new RegExp("</th></tr></thead>", "g");

        str = str.replace(id, "\n");

        str = str.replace(reg, "").replace(" class=\"rapport\"", "");
        str = str.replace(tab, "\t");
        str = str.replace(ret, "\n");
        str = str.replace("<table><tbody><tr><td>", "");
        str = str.replace("</td></tr></tbody></table>", "");
        str = str.replace(id2, "");
        str = str.replace(id3, "");
        str = str.replace(id4, "");

        str = str.replace(id5, "\t");
        str = str.replace("<tbody><tr", "");
        str = str.replace(id6, "");
        str = str.replace(id7, "");
        //alert (str);
        return str;
    }

    function getIdLotAlmerys(id)
    {

        $.ajax({
            type: "GET",
            url: "php/link.php?action=getIdLotAlmerys&id=" + id,
            success: function(msg) {
                if (msg == "")
                    return;
                else
                {
                    var tk = msg.split('$');
                    var pole = tk[2];

                    var strHTML = "";
                    strHTML += "<input type=\"hidden\" name=\"nature\" id=\"nature\" value=" + tk[9] + "> <table style=\"margin-top: 20px;margin-left: 7px;\" >";

                    strHTML += "<tr><td valign=\"top\">MATRICULE : </td><td><input type=\text\" id=\"idpers\"  class=\"sel\" value =" + tk[3] + " ></td></tr>";
                    strHTML += "<tr><td valign=\"top\">NUMERO SECU : </td><td><input type=\text\" id=\"idLdg\"  class=\"sel\"  value =" + tk[2] + " style=\"display:none\" ><input type=\text\" id=\"idLot\"  class=\"sel\"  value =" + id + " style=\"display:none\" ><input type=\text\" id=\"numFac\"  class=\"sel\"  value =" + tk[0] + " ></td></tr>";
                    strHTML += "<tr><td valign=\"top\">NUMERO DECOMPTE : </td><td><input type=\text\" id=\"idNuo\"  class=\"sel\" value =" + tk[4] + " ></td></tr>";
                    strHTML += "<tr><td valign=\"top\">ETAT : </td><td><input type=\text\" id=\"idPs\"  class=\"sel\" value =" + tk[5] + " ></td></tr>";
                    strHTML += "<tr><td valign=\"top\">MONTANT : </td><td><input type=\text\" id=\"montant\"  class=\"sel\" value =" + tk[1] + " ></td></tr>";
                    strHTML += "<tr><td valign=\"top\">ETAT : </td><td><select  class=\"sel\" id=\"idEtat\"><option value=\"\"></option><option value=\"a_controler\">a_controler</option><option value=\"en_cours\">en_cours</option></select></td></tr>";
                    strHTML += "<tr><td valign=\"top\">STATUT : </td><td><select  class=\"sel\" id=\"STAT\"><option value=\"\"></option><option value=\"945\">OK</option><option value=\"946\">NOK</option><option value=\"947\">NRRG</option><option value=\"948\">ES</option><option value=\"1007\">EN ATTENTE</option></select></td></tr>";

                    strHTML += '<tr><td valign=\"top\">DETAILS</td><td>';
                    strHTML += '<select id="erreurNRRG" class="ALMERYS_ERR_TYPE 947"><option>Erreur taux RO</option><option>Erreur mode de calcul d’ost&#233;opathie</option><option>Acte SPR saisie 2 fois au lieu de 1</option><option>Saisie facture d&#233;j&#224; pay&#233;e</option><option>R&#233;alisateur inconnu</option><option>Absence remboursement RO</option><option>Saisie facture tiers-payant</option><option>DMT et MT non pr&#233;cis&#233;s</option><option>Remboursement fait alors que d&#233;compte RO &#224; 100%, </option><option>Remboursement RO+RC</option><option>Autre remboursement : 1&#232; mutuelle</option><option>Parodontologie non pr&#233;vu dans la garantie de l’adh&#233;rent</option><option>Envoi courrier alors que pas besoin d’envoyer un courrier</option><option>Erreur motif de soin sur le commentaire-courrier</option><option>Saisie d’une facture non acquitt&#233;e</option><option> Validation d’une facture sans d&#233;compte ou flux</option><option>Remboursement TO 90 pour adulte</option><option>Temporisation alors que pas besoin de temporiser</option></select>';

                    strHTML += '<select id="erreurSaisie" class="ALMERYS_ERR_TYPE 948"><option>Erreur montant RC</option><option>Erreur montant d&#233;pense</option><option>Erreur code acte</option><option>Erreur b&#233;n&#233;ficiaire</option><option>Erreur quantit&#233; acte</option><option>Erreur coefficient acte</option><option>Erreur dates des soins</option><option>Erreur code affin&#233; acte SPR</option><option>Erreur PU</option><option>Erreur r&#233;alisateur</option><option>Manque facture</option><option>Omission acte</option><option>Omission code affin&#233;</option><option>Omission num&#233;ro de dent</option><option>Omission accord RO oui/non</option></select>';



                    strHTML += "<tr><td colspan=\"2\"><br /><center><input type=\"button\" value=\"Valider\" onclick=\"updateCqLot();\"><input type=\"button\" value=\"Annuler\" onclick=\"document.getElementById(\'root\').style.display = \'none\';\"></center></td></tr></table>";

                    document.getElementById('root').style.display = "block";
                    document.getElementById('root').style.height = "40%";
                    document.getElementById('root').style.width = "40%";
                    document.getElementById('root').style.left = "70px";
                    document.getElementById('root').style.top = "8px";
                    document.getElementById('divflottant').innerHTML = strHTML;
                    document.getElementById('handle').innerHTML = '<div id=\"handleTtl\" style=\"text-align: center\">' + tk[0] + " | " + tk[1] + '</div><img src="img/cl.png" style="float: right; margin-right: 5px;clear: none;margin-top: -25px; position: relative;" onclick="document.getElementById(\'root\').style.display = \'none\' ;">';
                }
            }
        });
    }

    function updateCqLot()
    {

        var ldg = $("#idLdg").val();
        var doss = $("#doss").val();
        var lib = $("#numFac").val();
        var qt = $("#montant").val();
        var stat = $("#STAT").val();
        var err = ($(classErr).val() == undefined) ? '' : $(classErr).val();
        var id = $("#idLot").val();
        var idNuo = $("#idNuo").val();
        var idPs = $("#idPs").val();
        var idpers = $("#idpers").val();
        var idEtat = $("#idEtat").val();
        var nature = $("#nature").val();

        //alert(idEtat+"______");
        if (stat == '')
            return;
        //return;
        if (stat == '945' || stat == '946')
        {
            //alert(err);
            err = '';
        }

        $.ajax({
            type: "GET",
            url: "php/link.php?action=updateCqLot&qt=" + qt + "&err=" + err + "&stat=" + stat + "&id=" + id + "&lib=" + lib +"&nature="+nature+ "&ldg=" + ldg + "&doss=" + doss + "&idpers=" + idpers + "&idNuo=" + idNuo + "&idEtat=" + idEtat + "&idPs=&isInterial=TRUE&is_rejet=false&idMotifRejet=0",
            success: function(msg) {
                //alert(msg);
                goLdt("");
                $("#root").hide("slow");
            }
        });
    }

    function insertLDT()
    {
        alert($("#PRJ").val());
    }

    function goLdt(ordre)
    {
        var ldg = ($("#ldg").val() == undefined) ? '' : $("#ldg").val();
        var doss = ($("#doss").val() == undefined) ? '' : $("#doss").val();
        var mat = ($("#mat").val() == undefined) ? '' : $("#mat").val();
        var stat = ($("#stat").val() == undefined) ? '' : $("#stat").val();
        var etape = ($("#etape").val() == undefined) ? '' : $("#etape").val();
        var prio = ($("#deb").val() == undefined) ? '' : $("#deb").val();
        var name = ($("#lotName").val() == undefined) ? '' : $("#lotName").val();
        var last = ($("#fin").val() == undefined) ? '' : $("#fin").val();
        prio = prio.replace("/", '').replace("/", '');
        last = last.replace("/", '').replace("/", '');
        if (doss == "")
        {
            alert("choisissez un dossier!");
            return;
        }
        $("#ldtCorp").html('<div class="body" id="Etape"><img src = "img/ramiLoad.gif"/>Loading ...</div>');
        $.ajax({
            type: "GET",
            url: "php/link.php?action=getLstLotAlmerys&doss=" + doss + "&ldg=" + ldg + "&mat=" + mat + "&stat=" + stat + "&etape=" + etape + "&prio=" + prio + "&last=" + last + "&name=" + name + "&ordre=" + ordre + "&isInterial=TRUE",
            success: function(msg) {
                //var data=msg.split('TOTAL')[1].split('</td>');

                //alert(msg);
                //$('#cvs').show();
                //DrawGraph([1,2,3,4], ["Saisie","OK","ES","NRRG"]);
                $("#ldtCorp").html(msg);
            }
        });
    }

    function getLotClient(idDossier)
    {
        $.ajax({
            type: "GET",
            url: "php/link.php?action=getLotClient&doss=" + idDossier,
            success: function(msg) {
                $("#ldg").html(msg);
            }
        });
    }

    function getLstEtape(idDossier)
    {
        $.ajax({
            type: "GET",
            url: "php/link.php?action=getLstEtape&doss=" + idDossier,
            success: function(msg) {
                $("#etape").html(msg);
            }
        });
    }

</script>
</html>

