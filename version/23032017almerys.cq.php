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

            <div id='piecvs'>	
                <canvas id="cvs" width="800" height="500" !style="border:1px solid #ccc">[No canvas support]</canvas>
            </div>

            <div id="content_centre">
                <h1 class="bigger lighter">ALMERYS CQ</h1>
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
                                    <td>	
                                        <span>SAT</span><br/>
                                        <select  id="satpers"><option value=""></option>

                                        </select>
                                    </td>
                                    <td>	
                                        <span>LIB RETOUR</span><br/>
                                        <select  id="libretour"><option value=""></option>

                                        </select>
                                    </td>
                                    <td>	
                                        <span>TYPE FAV</span><br/>
                                        <select id="typefav">
                                            <option value=""></option>
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
                .Set('exploded', [10, ])
                .Set('shadow', true)
                .Set('shadow.offsetx', 0)
                .Set('shadow.offsety', 0)
                .Set('shadow.blur', 20)
                .Set('labels', arrayLabel)
                .Set('labels.sticks', [false])
                .Set('labels.sticks.length', 10)

        RGraph.Effects.Pie.RoundRobin(pie)
    }

    $('#cvs').click(function () {
        this.width = this.width;
        $('#cvs').hide();
        //RGraph.clearAnnotations($this);
        //RGraph.clear(this);
        //obj.draw();
    });

    $(document).ready(function () {

        //DrawGraph([1,2,3, 4], ["1","2","3","4"]);

        var idDoss = $("#doss").val();
        var ldg = $("#ldg").val();
        getLotClient(201);
        getLstEtape(idDoss);
        getLstSat(ldg);
        getLstrejet(ldg);
        getLstTypeFav(ldg);

        $('#mcorps').on('click', '#selectall', function () {
            $('.case').attr('checked', this.checked);
        });

        $('#ldtCorp').on('click', '.th', function () {
            goLdt(this.id);
        });

        $('#root').on('click', '#STAT option', function () {

            $(".ALMERYS_ERR_TYPE").hide();
            classErr = "." + $("#STAT").val() + "." + $("#idLdg").val();
            //alert(classErr);
            $(classErr).show();
        });

    });

    $("#showHide").click(function () {
        if (flagShow == 0)
        {
            $("#sh").css("display", 'none');
            $("#oContent").slideUp(1000);
            flagShow = 1;
            $("#hd").css("display", 'block');
        } else
        {
            $("#hd").css("display", 'none');
            $("#oContent").slideDown(1000);
            flagShow = 0;
            $("#sh").css("display", 'block');
        }
    });
    $("#goLdt").click(function () {
        goLdt("");
    });
    $("#goLdtStat").click(function () {
        goLdt("stat");
    });


    $('.th').click(function () {
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
            success: function (msg) {
                goLdt("");
            }
        });
    }
    function updateLot(etat, priorite, mat)
    {
        var lstID = "";
        var nb = 0;
        $("input:checked").each(
                function () {
                    nb++;
                    if ($(this).attr("id") != 'selectall')
                        lstID += "," + $(this).attr("id");
                }
        );

        if (nb != 0)
        {
            lstID = lstID.substring(1);
            $.ajax({
                type: "POST",
                url: "php/link.php?action=updateLot&lstId=" + lstID + "&etat=" + etat + "&prio=" + priorite + "&mat=" + mat,
                success: function (msg) {
                    //alert(msg);
                    goLdt("");
                }
            });
        } else
            alert("Veuillez selectionner les lots a traiter!");
    }
    $("#btSetPrio").click(function () {
        var prio = $("#prio").val();
        updateLot("", prio, "");
    });
    $("#reinitialiser").click(function () {
        updateLot(0, "", "");
    });
    $("#Affecter").click(function () {
        var mat = $("#matricule").val();
        //alert(mat);
        updateLot(1, "", mat);

    });

    $("#Initialiser").click(function () {
        var mat = $("#matricule").val();
        //alert(mat);
        $.ajax({
            type: "GET",
            url: "php/link.php?action=initMat&mat=" + mat,
            success: function (msg) {
                //alert(msg);
                //goLdt("");
            }
        });
    });

    $("#bloquer").click(function () {
        updateLot(6, "", "");
    });
    $("#terminer").click(function () {
        updateLot(2, "", "");
    });
    $("#annomalie").click(function () {
        updateLot(3, "", "");
    });
    $("#doss").change(function () {
        var idDoss = $("#doss").val();
        getLotClient(idDoss);
        getLstEtape(idDoss);
    });

    $("#ldg").change(function () {
        var ldg = $("#ldg").val();
        getLstSat(ldg);
        getLstrejet(ldg);
        getLstTypeFav(ldg);
    });

    $("#goLdtCat").click(function () {

        var ldg = $("#ldg").val();
        var deb = $("#deb").val();
        var catg = $("#catg").val();
        var etape = $("#etape").val();
        var prio = deb.replace("/", '').replace("/", '');

        $.ajax({
            type: 'GET',
            url: "php/link.php?action=InsertCategorieDay&ldg=" + ldg + "&catg=" + catg + "&prio=" + prio,
            success: function (msg) {
                alert(msg);

            }
        });

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
            success: function (msg) {
                if (msg == "")
                    return;
                else
                {
                    var tk = msg.split('$');
                    var pole = tk[2];
//alert(tk[5]);		
                    var isRejet = (tk[7] == 1) ? true : false;

                    var strHTML = "";
                    strHTML += "<table style=\"margin-top: 20px;margin-left: 7px;\" >";

                    strHTML += "<tr><td valign=\"top\">MATRICULE : </td><td><input type=\text\" id=\"idpers\"  class=\"sel\" value =" + tk[3] + " ></td></tr>";
                    strHTML += "<tr><td valign=\"top\">NUMERO FACTURE : </td><td><input type=\text\" id=\"idLdg\"  class=\"sel\"  value =" + tk[2] + " style=\"display:none\" ><input type=\text\" id=\"idLot\"  class=\"sel\"  value =" + id + " style=\"display:none\" ><input type=\text\" id=\"numFac\"  class=\"sel\"  value =" + tk[0] + " ></td></tr>";
                    strHTML += "<tr><td valign=\"top\">NUMERO NUO : </td><td><input type=\text\" id=\"idNuo\"  class=\"sel\" value =" + tk[4] + " ></td></tr>";
                    strHTML += "<tr><td valign=\"top\">NUMERO PS : </td><td><input type=\text\" id=\"idPs\"  class=\"sel\" value =" + tk[5] + " ></td></tr>";
                    strHTML += "<tr><td valign=\"top\">MONTANT : </td><td><input type=\text\" id=\"montant\"  class=\"sel\" value =" + tk[1] + " ></td></tr>";
                    strHTML += "<tr   style=\"display:none\"><td valign=\"top\">REJET : </td><td><input type=\text\" id=\"rejet\"    disabled=\"disabled\" class=\"sel\" value =" + isRejet + " ><input type=\text\" id=\"idMotifRejet\"    style=\"display:none\" value =" + tk[8] + " ></td></tr>";
                    strHTML += "<tr><td valign=\"top\">STATUT : </td><td><select  class=\"sel\" id=\"STAT\"><option value=\"\"></option><option value=\"945\">OK</option><option value=\"946\">NOK</option><option value=\"947\">NRRG</option><option value=\"948\">ES</option><option value=\"1007\">EN ATTENTE</option></select></td></tr>";

                    strHTML += '<tr><td valign=\"top\">DETAILS</td><td>';
                    strHTML += '<select id="erreurNRRG" class="ALMERYS_ERR_TYPE TPS SE NRRG 2385 2462 6919 947"><option>Saisie d une facture plus de 2 ans</option><option>Manque pr&#233;scripteur/erreur prescripteur</option><option>Manque date prescripteur/erreur date pr&#233;scripteur</option><option>B&#233;n&#233;ficiaire retrouv&#233;</option><option>Saisie de B indeterminable</option><option>Saisie en une seule ligne pour qt&#233; acte<10</option><option>Rejet BI au lieu de B Indet</option><option>selection contrat</option><option>taux</option><option>part assur&#233; &#224; mettre dans la case assur&#233;e</option><option>non saisie acte transmis</option><option>saisie d une facture IDT</option><option>Rejet oubli commentaire</option><option>saisie d une facture Destinataire Incertain</option><option>Saisie d un compl&#233;ment de facture</option><option>Saisie d une facture 100% RO</option><option>Saisie d une facture manque d&#233;tail code/coef/qt&#233; acte</option><option>Saisie d une facture assur&#233;</option><option>Saisie d une facture acte de transport incert.</option><option>Saisie Carte blanche</option><option>Rejet BNC suite &#224; non tentative de recherche d un autre contrat</option><option>Saisie d une facture iliisible</option><option>saisie d une facture erreur contenu</option><option>Saisie d une facture BNC</option><option>Rejet &#224; tort, RC correcte</option><option>saisie part RC diff</option><option>rejet erron&#233;: d&#233;j&#224; pay&#233; au lieu de compl&#233;ment de fact</option><option>Rejet erron&#233;: case assur&#233; au lieu de part RC</option><option>Rejet erron&#233;: dest incert. Au lieu de fact. Assur&#233;</option><option>Rejet erron&#233;: part RC alors que OK</option><option>Rejet erron&#233;: montant total alors que OK</option><option>Rejet erron&#233;: acte en doublon au lieu de compl. Fact</option><option>Rejet erron&#233;: compl. Au lieu de d&#233;j&#224; pay&#233;</option><option>rejet erron&#233;: d&#233;j&#224; pay&#233; au lieu de compl&#233;ment de fact</option><option>Rejet erron&#233;: part RC au lieu de Bug </option><option>Rejet Manque d&#233;tail alors que OK</option><option>Rejet facture assus&#233; alors que OK</option><option>Rejet BNC au lieu de bug</option><option>Saisie d une facture avec b&#233;n&#233;ficiaire RMS</option><option>Rejet manque d&#233;tail au lieu de r&#233;clamation PS</option><option>Rejet PS inconnu alors que PS trouv&#233;</option><option>Saisie d une facture HCS</option><option>Saisie d une facture 100% RC</option><option>Rejet Part RC diff&#233;rente au lieu de Case assur&#233;e</option><option>Rejet Montant total diff&#233;rent alors que Montant correct</option><option>Rejet 100% RC alors que Contrat Frontalier</option><option>Rejet Facture d&#233;j&#224; saisie au lieu de Facture d&#233;j&#224; pay&#233;e</option><option>Rejet d&#233;j&#224; saisie au lieu de droits ferm&#233;s</option></select>';

                    strHTML += '<select id="erreurSaisie" class="ALMERYS_ERR_TYPE TPS SE SAISIE 2385 948 2462 6919"><option>Erreur quantit&#233; et/ou Coefficient</option><option>Num&#233;ro facture</option><option>date de facture</option><option>date des soins</option><option>code acte</option><option>erreur finess</option><option>confusion entre qt&#233; et coef acte</option><option>omission acte</option><option>prix unitaire</option><option>montant total</option><option>case hospi non coch&#233;e T</option><option>b&#233;n&#233;ficiaire</option></select>';

                    strHTML += '<select id="erreurSaisie" class="ALMERYS_ERR_TYPE PEC_HOSPI SAISIE 6883 947"><option>Erreur motif de rejet</option><option>Saisie d une facture &#224; rejeter</option><option>Rejet d une facture &#224; saisir</option><option>B&#233;n&#233;ficiaire trouv&#233;</option></select>';

                    strHTML += '<select id="erreurSaisie" class="ALMERYS_ERR_TYPE PEC_HOSPI SAISIE 6883 948"><option>Erreur finess</option><option>Erreur b&#233;n&#233;ficiaire</option><option>Erreur date d entr&#233;e</option><option>Erreur num&#233;ro d entr&#233;e</option><option>Erreur nombre de jours</option><option>Erreur MT</option><option>Erreur DMT</option></select>';

                    strHTML += '<select id="erreurSaisie" class="ALMERYS_ERR_TYPE PEC_audio NRRG 7042 947"><option>Refus &#224; saisir</option><option>PEC d&#233;j&#224; existante</option><option>Oubli de la pi&#232;ce jointe</option><option>Refus de PEC en amont oubli&#233;</option></select>';

                    strHTML += '<select id="erreurSaisie" class="ALMERYS_ERR_TYPE PEC_audio ES SAISIE 7042 948"><option>Erreur b&#233;n&#233;ficiaire</option><option>Erreur date de demande</option><option>Erreur montant</option><option>Manque acte</option><option>Acte &#233;rron&#233;</option></select>';


                    strHTML += '<select id="erreurNRRG" class="ALMERYS_ERR_TYPE NRRG 6920 6921 947"><option>Saisie d une facture plus de 2 ans</option><option>Manque pr&#233;scripteur/erreur prescripteur</option><option>Manque date prescripteur/erreur date pr&#233;scripteur</option><option>B&#233;n&#233;ficiaire retrouv&#233;</option><option>Saisie de B indeterminable</option><option>Saisie en une seule ligne pour qt&#233; acte<10</option><option>Rejet BI au lieu de B Indet</option><option>selection contrat</option><option>taux</option><option>part assur&#233; &#224; mettre dans la case assur&#233;e</option><option>non saisie acte transmis</option><option>saisie d une facture IDT</option><option>Rejet oubli commentaire</option><option>saisie d une facture Destinataire Incertain</option><option>Saisie d un compl&#233;ment de facture</option><option>Saisie d une facture 100% RO</option><option>Saisie d une facture manque d&#233;tail code/coef/qt&#233; acte</option><option>Saisie d une facture assur&#233;</option><option>Saisie d une facture acte de transport incert.</option><option>Saisie Carte blanche</option><option>Rejet BNC suite &#224; non tentative de recherche d un autre contrat</option><option>Saisie d une facture iliisible</option><option>saisie d une facture erreur contenu</option><option>Saisie d une facture BNC</option><option>Rejet &#224; tort, RC correcte</option><option>saisie part RC diff</option><option>rejet erron&#233;: d&#233;j&#224; pay&#233; au lieu de compl&#233;ment de fact</option><option>Rejet erron&#233;: case assur&#233; au lieu de part RC</option><option>Rejet erron&#233;: dest incert. Au lieu de fact. Assur&#233;</option><option>Rejet erron&#233;: part RC alors que OK</option><option>Rejet erron&#233;: montant total alors que OK</option><option>Rejet erron&#233;: acte en doublon au lieu de compl. Fact</option><option>Rejet erron&#233;: compl. Au lieu de d&#233;j&#224; pay&#233;</option><option>rejet erron&#233;: d&#233;j&#224; pay&#233; au lieu de compl&#233;ment de fact</option><option>Rejet erron&#233;: part RC au lieu de Bug </option><option>Rejet Manque d&#233;tail alors que OK</option><option>Rejet facture assus&#233; alors que OK</option><option>Rejet BNC au lieu de bug</option><option>Saisie d une facture avec b&#233;n&#233;ficiaire RMS</option><option>Rejet manque d&#233;tail au lieu de r&#233;clamation PS</option><option>Rejet PS inconnu alors que PS trouv&#233;</option><option>Saisie d une facture HCS</option><option>Saisie d une facture 100% RC</option><option>Rejet Part RC diff&#233;rente au lieu de Case assur&#233;e</option><option>Rejet Montant total diff&#233;rent alors que Montant correct</option><option>Rejet 100% RC alors que Contrat Frontalier</option><option>Rejet Facture d&#233;j&#224; saisie au lieu de Facture d&#233;j&#224; pay&#233;e</option><option>Rejet d&#233;j&#224; saisie au lieu de droits ferm&#233;s</option><option>quantit&#233; PJ (LMG)</option><option>calcul PJ avec FJ inclus</option><option>DMT erron&#233;</option><option>DMT inchang&#233;</option><option>mauvaise PEC</optio n><option>omission reliquat</option><option>MT non conforme &#224; la facture</option><option>mode de calcul CPC</option><option>Saisie de fact. Compl de facture</option><option>saisie b&#233;n&#233;ficiaire indet</option><option>saisie facture d&#233;j&#224; pay&#233;e</option><option>saisie d une facture avec page manquante</option><option>saisie d une facture pour refacturation</option><option>saisie d une facture assur&#233;e</option><option>facture non conforme &#224; PEC</option><option>Reliquat erron&#233;</option><option>Saisie d une facture avec DMT diff&#233;rents</option><option>Saisie d une facture avec multi nature des soins</option><option>Erreur mode de calcul April Frontalier</option><option>FJ non facturable : date de d&#233;c&#232;s = date fin des soins</option><option>MT manquant</option><option>Saisie avec 2 num&#233;ros factures diff&#233;rents</option><option>Saisie d une facture 100% RO</option><option>Saisie facture &#224; rejeter</option><option>Rejet facture &#224; saisir</option><option>Saisie d une facture sur 2 ann&#233;es</option><option>Erreur motif de rejet</option><option>B&#233;n&#233;ficiaire trouv&#233;</option><option>AUTRES</option></select>';

                    strHTML += '<select id="erreurSaisie" class="ALMERYS_ERR_TYPE TPS SE SAISIE 6921 6920 948 "><option>Erreur quantit&#233; et/ou Coefficient</option><option>Num&#233;ro facture</option><option>date de facture</option><option>date des soins</option><option>code acte</option><option>erreur finess</option><option>confusion entre qt&#233; et coef acte</option><option>omission acte</option><option>prix unitaire</option><option>montant total</option><option>case hospi non coch&#233;e T</option><option>b&#233;n&#233;ficiaire</option><option>Num&#233;ro facture</option><option>date de facture</option><option>date des soins</option><option>code acte</option><option>erreur finess</option><option>montant CPC</option><option>quantit&#233; acte</option><option>nombre FJ inclus</option><option>montant acte</option><option>omission acte</option><option>prix unitaire</option><option>montant RC</option><option>b&#233;n&#233;ficiaire</option><option></select>';


                    strHTML += '<select id="erreur1" class="ALMERYS_ERR_TYPE TPS SE 2387 2391 13062 12779 12778 12777 7900 947"><option>quantit&#233; PJ (LMG)</option><option>calcul PJ avec FJ inclus</option><option>DMT erron&#233;</option><option>DMT inchang&#233;</option><option>mauvaise PEC</option><option>omission reliquat</option><option>MT non conforme &#224; la facture</option><option>mode de calcul CPC</option><option>Saisie de fact. Compl de facture</option><option>saisie b&#233;n&#233;ficiaire indet</option><option>saisie facture d&#233;j&#224; pay&#233;e</option><option>saisie d une facture avec page manquante</option><option>saisie d une facture pour refacturation</option><option>saisie d une facture assur&#233;e</option><option>facture non conforme &#224; PEC</option><option>Reliquat erron&#233;</option><option>Saisie d une facture avec DMT diff&#233;rents</option><option>Saisie d une facture avec multi nature des soins</option><option>Erreur mode de calcul April Frontalier</option><option>FJ non facturable : date de d&#233;c&#232;s = date fin des soins</option><option>MT manquant</option><option>Saisie avec 2 num&#233;ros factures diff&#233;rents</option><option>Saisie d une facture 100% RO</option><option>Saisie facture &#224; rejeter</option><option>Rejet facture &#224; saisir</option><option>Saisie d une facture sur 2 ann&#233;es</option><option>Erreur motif de rejet</option><option>B&#233;n&#233;ficiaire trouv&#233;</option><option>AUTRES</option></select>';

                    strHTML += '<select id="erreur2" class="ALMERYS_ERR_TYPE TPS SE 2387 2391 13062 12779 12778 12777 7900 948"><option>Num&#233;ro facture</option><option>date de facture</option><option>date des soins</option><option>code acte</option><option>erreur finess</option><option>montant CPC</option><option>quantit&#233; acte</option><option>nombre FJ inclus</option><option>montant acte</option><option>omission acte</option><option>prix unitaire</option><option>montant RC</option><option>b&#233;n&#233;ficiaire</option><option></select>';

                    strHTML += '<select id="erreur3" class="ALMERYS_ERR_TYPE TPS SE 2386 947 2390"><option>Date facture ant&#233;rieure &#224; la date de validation</option><option>Date facture post&#233;rieure &#224; la date de p&#233;remption</option><option>B&#233;n&#233;ficiaire inconnu</option><option>B&#233;n&#233;ficiaire incertain</option><option>Devis </option><option>Erreur scann (facture audio , hospi, tiers)</option><option>erreur code LPP</option><option>Erreur &#233;quipement (&#233;quipement diff&#233;rent)</option><option>erreur montant (verre ou monture)</option><option>Saisie d une facture avec DDN diff&#233;rentes</option><option>Saisie d une facture avec Finess opticien diff&#233;rents</option><option>Saisie d une facture avec montants RO diff&#233;rents</option><option>Saisie d une facture avec montants RC diff&#233;rents</option><option>Saisie d une facture manque d&#233;tail code LPP</option><option>Autres</option></select>';

                    strHTML += '<select id="erreur4" class="ALMERYS_ERR_TYPE 7330 947 "><option>Non conforme et non OK</option><option>OK et non non conforme</option>n><option></option>n></select></td></tr>';


                    strHTML += '<select id="erreur4" class="ALMERYS_ERR_TYPE TPS SE 2386 948 2390"><option>Num&#233;ro facture</option><option>date facture</option><option>b&#233;n&#233;ficiaire</option><option>Crit&#232;re d archivage</option><option></select></td></tr>';

                    strHTML += '</td><td></td><td><select id="erreur5" class="ALMERYS_ERR_TYPE TPS SE 2388 947"><option>Hors P&#233;rim&#232;tre au lieu de Non g&#233;r&#233;</option><option>Saisie d&#39;une fact. Manque d&#233;tail signature</option><option>Date de PEC non conforme </option><option>Montant d&#233;pense non conforme</option><option>Montant RC non conforme</option><option>B&#233;n&#233;ficiaire des soins non conformes</option><option>Manque d&#233;tail signature de l assur&#233;</option><option>Saisie d une facture illisible</option><option>Rejet illisible alors que OK</option></select></td></tr>';


                    strHTML += '</td><td></td><td><select id="erreur6" class="ALMERYS_ERR_TYPE 6117 947"><option>Incoh&#233;rence code LPP</option><option>Incoh&#233;rence code taux RO</option><option>Oubli de saisir les remises</option><option>Oubli supplements</option><option>Oubli options</option><option>Erreur de calcul sur les corrections</option></select></td></tr>';

                    strHTML += '</td><td></td><td><select id="erreur7" class="ALMERYS_ERR_TYPE 6117 948"><option>Incoh&#233;rence date de naissance</option><option>Manque ordonnance</option><option>Pec d&#233;j&#224; saisie</option><option>Oubli r&#233;nouvellement</option><option>Demande de cotation</option><option>Erreur d&#233;signation (krys group)</option></select></td></tr>';

                    strHTML += '</td><td></td><td><select id="erreur8" class="ALMERYS_ERR_TYPE TPS SE 2388 948 "><option>Num&#233;ro facture</option><option>Date des soins</option><option>date de facture</option><option>Crit&#232;re d archivage</option><option></select></td></tr>';

                    strHTML += '</td><td></td><td><select id="erreur9" class="ALMERYS_ERR_TYPE 2396 947"><option>Erreur dans la civilit&#233; (inversion nom et pr&#233;nom)</option><option>Num&#233;ro tel pas modifi&#233;</option><option>Pas de civilit&#233; sur le RIB</option><option>Erreur sur le type d utilisation(il fallait prendre TP et non mandataire</option><option>Adresse mise dans la raison sociale</option><option>Inversion du nom et pr&#233;noms</option><option>Omission de saisir le num&#233;ro tel- flux - nom de l interlocuteur - logiciel </option><option>Omission de rajouter le num&#233;ro t&#233;l&#233;phone sur le cachet</option><option>Omission de mettre &#224; jour le nom de l interlocuteur</option><option>Omission de mettre &#224; jour l adresse mail ou code postal ou adresse</option></select></td></tr>';

                    strHTML += '</td><td></td><td><select id="erreur10" class="ALMERYS_ERR_TYPE 2396 948"><option>Erreurs de frappe</option><option>Erreur code BIC</option><option>Raison sociale &#233;rron&#233;e</option><option>Non respect des caract&#232;re sp&#233;ciaux (trait d union_apostrophe/espace/point)</option></select></td></tr>';

                    //ajout pec et facture dentaire
                    strHTML += '</td><td></td><td><select id="erreur11" class="ALMERYS_ERR_TYPE 11334 948"><option>Numero facture</option><option>Montant honoraire</option><option>B&#233;n&#233;ficiaire</option><option>Date des soins</option><option>Erreur montant RC</option><option>Erreur montant d&#233;pense</option><option>Erreur code acte</option><option>Erreur b&#233;n&#233;ficiaire</option><option>Erreur quantit&#233; acte</option><option>Erreur coefficient</option><option>Erreur date des soins</option><option>Erreur code affin&#233; acte SPR</option><option>Erreur PU</option><option>Erreur r&#233;alisateur</option><option>Manque facture</option><option>Omission acte</option><option>Omission num&#233;ro dent</option><option>Omission accord RO oui/non</option></select></td></tr>';


                    strHTML += '</td><td></td><td><select id="erreur12" class="ALMERYS_ERR_TYPE 11334 947"><option>Devis</option>\n\
                <option>erreur date de la PEC</option><option>Erreur de saisie acte TO</option><option>Inoch&#233;rence entre PEC et facture</option>\n\
<option>Autres</option><option>Manque d&#233;tail : date d&#233;but Semestre acte TO</option><option>Demande assur&#233;e: la facture n\'aurait du pas &#234;tre saisie</option>\n\
<option>IDT: il ne fallait pas saisir la facture</option><option>Facture assur&#233;e</option>\n\
<option>Montant part RC non conforme</option><option>Aucune garanteie n\'a &#233;t&#233; trouv&#233;</option>\n\
<option>Droit ferm&#233;</option><option>Autre+ case commentaire</option><option>Erreur Taux RO</option>\n\
<option>Erreur mode de calcul d&#145;osth&#233;opathe</option><option>Acte SPR saisie 2 fois au lieru de 1</option>\n\
<option>Saisie facture d&#233;j&#224; pay&#233;e</option><option>R&#233;alisateur inconnu</option><option>Absence remboursement RO</option><option>Saisie facture TP</option>\n\
<option>DMT et MT non pr&#233;cis&#233;s</option><option>Remboursement fait alors que d&#233;compte RO &#224; 100%</option><option>Remboursement RO+RC</option>\n\
<option>Autre remboursement : 1&#232; mutuelle</option><option>Parodontologie non pr&#233;vu dans la garantie de l&#145;adh&#233;rent</option><option>Envoi courrier &#224; tord</option>\n\
<option>Erreur motif de soin sur le commentaire-courrier</option><option>Saisie d&#145;une facture facture non acquitt&#233;e</option>\n\
<option>Validation d&#145;une facture sans d&#233;compte ou flux</option><option>Remboursement TO 90 pour adulte</option><option>Temporisation &#224; tord</option></select></td></tr>';


                    strHTML += '</td><td></td><td><select id="erreur13" class="ALMERYS_ERR_TYPE 11335 948"><option>Erreur date des soins </option><option>Erreur numero de facture</option><option>Manque d&#233;tail/finess</option><option>Facture illisible</option><option>Incoh&#233;rence document tache</option><option>Facture d&#233;j&#224; pay&#233;e</option><option>Absence PEC</option><option>Surcompl&#233;mentaire</option><option>Non conforme PEC</option><option>Facture partiellement illisible</option><option>Fcature +2ans</option><option>Droit ferm&#233;</option><option>PEC en instance</option><option>Manque d&#233;tail</option><option>Consultation non autoris&#233;</option><option>PEC d&#233;j&#224; saisie</option><option>Demande assur&#233;e</option></select></td></tr>';

                    strHTML += '</td><td></td><td><select id="erreur14" class="ALMERYS_ERR_TYPE 11335 947"><option>Erreur date des soins </option><option>Erreur numero de facture</option><option>manque d&#233;tail/part RC</option><option>manque d&#233;tail/ finess</option><option>facture illisible</option><option>incoh&#233;rence document tache</option><option>facture d&#233;j&#224; pay&#233;e</option><option>Absence de PEC</option><option>surcompl&#233;mentaire</option><option>non conformer PEC</option><option>facture partiellement illisible</option><option>facture + 2ans</option><option>Droit ferm&#233;</option><option>PEC en instance</option><option>Manque d&#233;tail</option><option>Consultation non autoris&#233;</option><option>PEC d&#233;j&#224; saisie</option><option>Demande assur&#233;e</option><option>Autre+ case commentaire</option><option>Erreur date des soins</option><option>Erreur num&#233;ro de facture</option></select></td></tr>';
//fin dentaire
//ajout CMUC
                    strHTML += '</td><td></td><td><select id="erreurNRRG" class="ALMERYS_ERR_TYPE 14152 948"><option>Erreur quantit&#233; et&#47;ou coefficient</option><option>Erreur num&#233;ro facture</option><option>Erreur date de facture</option><option>Erreur dates des soins</option><option>Erreur code acte</option><option>Erreur finess</option><option>Confusion entre quantit&#233; et coefficient</option><option>omission acte</option><option>Erreur prix unitaire</option><option>Erreur montant</option><option>Erreur b&#233;n&#233;ficiaire</option>option>Erreur selection contrat</option>option>Oubli prescripteur</option></select></td></tr>';
                    strHTML += '</td><td></td><td><select id="erreurNRRG" class="ALMERYS_ERR_TYPE 14152 947"><option>rejet erron&#233;: pas de contrat CMU, </option><option>rejet erron&#233;: traitement plateforme </option><option>rejet erron&#233;: acte dentaire non param&#233;tr&#233;</option><option>rejet erron&#233;: droit ferm&#233;</option><option>rejet erron&#233;: b&#233;n&#233;ficiaire inconnu</option><option>rejet erron&#233;: montant diff&#233;rent</option><option>B&#233;n&#233;ficiaire retrouv&#233;</option><option>Erreur taux</option><option>saisie: pas de contrat CMU</option><option>saisie: traitement plateforme</option><option>saisie : acte dentaire non param&#233;tr&#233;</option><option>saisie : droit ferm&#233;</option><option>saisie : b&#233;n&#233;ficiaire inconnu</option><option>saisie : montant diff&#233;rent</option></select></td></tr>';

                    strHTML += "<tr><td colspan=\"2\"><br /><center><input type=\"button\" id=\"valider_cq\" value=\"Valider\" onclick=\"updateCqLot();\"><input type=\"button\" value=\"Annuler\" onclick=\"document.getElementById( root ).style.display =  none ;\"></center></td></tr></table>";

                    

                    document.getElementById('root').style.display = "block";
                    document.getElementById('root').style.height = "40%";
                    document.getElementById('root').style.width = "40%";
                    document.getElementById('root').style.left = "70px";
                    document.getElementById('root').style.top = "8px";
                    document.getElementById('divflottant').innerHTML = strHTML;
                    document.getElementById('handle').innerHTML = '<div id=\"handleTtl\" style=\"text-align: center\">' + tk[0] + " | " + tk[1] + '</div><img src="img/cl.png" style="float: right; margin-right: 5px;clear: none;margin-top: -25px; position: relative;" onclick="document.getElementById( root ).style.display =  none  ;">';
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
        var isRejet = $("#rejet").val();
        var idMotifRejet = ($("#idMotifRejet").val() == '') ? '0' : $("#idMotifRejet").val();

        $("#valider_cq").attr('disabled', 'disabled');

        //alert(idMotifRejet+"______");
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
            url: "php/link.php?action=updateCqLot&qt=" + qt + "&err=" + err + "&stat=" + stat + "&id=" + id + "&lib=" + lib + "&nature=0&ldg=" + ldg + "&doss=" + doss + "&idpers=" + idpers + "&idNuo=" + idNuo + "&idEtat=&idPs=" + idPs + "&isInterial=FALSE&is_rejet=" + isRejet + "&idMotifRejet=" + idMotifRejet, async: false,
            success: function (msg) {
                if (msg != "")
                {
                    alert(msg);
                }
                $('#valider_cq').removeAttr('disabled');
                $("#root").hide("slow");
            }

        });

        goLdt("");

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
        var sat = ($("#satpers").val() == undefined) ? '' : $("#satpers").val();
        var libretour = ($("#libretour").val() == undefined) ? '' : $("#libretour").val();
        var typefav = ($("#typefav").val() == undefined) ? '' : $("#typefav").val();
        prio = prio.replace("/", '').replace("/", '');
        last = last.replace("/", '').replace("/", '');
        if (doss == "")
        {
            alert("choisissez un dossier!");
            return;
        }
        //alert ('msg');
        $("#ldtCorp").html('<div class="body" id="Etape"><img src = "img/ramiLoad.gif"/>Loading ...</div>');
        $.ajax({
            type: "GET",
            url: "php/link.php?action=getLstLotAlmerys&doss=" + doss + "&ldg=" + ldg + "&mat=" + mat + "&stat=" + stat + "&etape=" + etape + "&prio=" + prio + "&last=" + last + "&name=" + name + "&ordre=" + ordre + "&isInterial=FALSE&sat=" + sat + "&libretour=" + libretour + "&typefav=" + typefav,
            success: function (msg) {
                // alert (msg);
                if (ordre == 'stat')
                {
                    var regTd = new RegExp("<.[^>]*>", "g");
                    // alert(msg);
                    var tmp = msg.split('#')[1].replace(regTd, "");

                    var data = tmp.split('TOTAL:')[0].split('\n');
                    var ArrayStat = [];
                    data.shift();

                    for (i = 2; i < data.length; i++)
                        ArrayStat[i - 2] = Number(data[i]);

                    $('#cvs').show();
                    DrawGraph(ArrayStat, ["OK", "NOK", "NRRG", "ES", "ATT", "ATT"]);

                }

                $("#ldtCorp").html(msg);
            }
        });
    }

    function getLotClient(idDossier)
    {
        $.ajax({
            type: "GET",
            url: "php/link.php?action=getLotClient&doss=" + idDossier,
            success: function (msg) {
                $("#ldg").html(msg);
            }
        });
    }

//liste des sats disponible
    function getLstSat(idpole)
    {
        $.ajax({
            type: "GET",
            url: "php/link.php?action=GetLstSat&ldg=" + idpole,
            success: function (msg) {
                $("#satpers").html(msg);
            }
        });
    }

    //liste des motif rejet disponible
    function getLstrejet(idpole)
    {
        $.ajax({
            type: "GET",
            url: "php/link.php?action=GetLstRejet&ldg=" + idpole,
            success: function (msg) {
                $("#libretour").html(msg);
            }
        });
    }

    function getLstEtape(idDossier)
    {
        $.ajax({
            type: "GET",
            url: "php/link.php?action=getLstEtape&doss=" + idDossier,
            success: function (msg) {
                $("#etape").html(msg);
            }
        });
    }

    function getLstTypeFav(idpole)
    {
        $.ajax({
            type: "GET",
            url: "php/link.php?action=getLstTypeFav&ldg=" + idpole,
            success: function (msg) {
                $("#typefav").html(msg);
            }
        });

    }

</script>
</html>

