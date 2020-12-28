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
        //

        if ($_SESSION['id_droit'] == 1) {
            header('Location: index.php');
            exit();
        }
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
?>

            <div id="optionsLot">
                <div class ="lab"><blink>Modification Selections</blink></div>
                <div id="oContent">
                    <hr/><br/>
                    <label>Affectation par Matricule</label><hr/>
                    <select  id="matricule" class="btOption"><option value=""></option>
<?php
echo $c->getLstMat();
?>
                    </select>

                    <input type="submit" id="Affecter"  value="Affecter" title="Affectater"/>
                    <input type="submit" id="Initialiser"  value="Init" title="Reinitialiser"/><br/>
                    <br/><br/><br/><br/>

                    <label>Changement statut</label><hr/><br/>
                    <input type="submit" id="reinitialiser"  value="Liberer" title="Reinitialiser" class="btOption"/><br/>
                    <input type="submit" id="terminer"  value="Terminer" title="Terminer" class="btOption"/><br/>
                    <input type="submit" id="bloquer"  value="Bloquer" title="Bloquer" class="btOption"/><br/>
                    <input type="submit" id="annomalie"  value="Annomalie" title="Annomalie" class="btOption"/><br/><br/>
                    <label>Changement priorite</label><hr/><br/>
                    <select  id="prio">

                        <option value="0">0</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                    </select><input type="submit" value="Valider" id="btSetPrio" class="btOption"/>
                    <hr/>
                </div>
                <div class ="lab"></div>
                <div id="showHide"><div id="sh"></div><div id="hd"></div></div>
            </div>


            <div id="content_centre">

                <table id="lot">
                    <tr  class="tb_header">
                        <td>
                            <table>
                                <tr>
                                    <td>
                                        <span>Dossier</span><br/>
                                        <select  id="doss"><option value=""></option>
<?php
echo $c->getLstDossier();
?>
                                        </select>
                                    </td>
                                    <td id="sousspehide">
                                        <span>Sous specialite</span><br/>
                                        <select  id="sous_specialite"><option value=""></option>

                                        </select>
                                    </td>
                                    <td>						
                                        <span>Lot Client</span><br/>
                                        <select  id="ldg"><option value=""></option>

                                        </select>
                                    </td>
                                    <td>	
                                        <span>Etapes</span><br/>
                                        <select  id="etape"><option value=""></option>

                                        </select>
                                    </td>
                                    <td>	
                                        <span>LOT</span><br/>
                                        <input type="text" id="lotName" />
                                    </td>
                                    <td>	
                                        <span>matricule</span><br/>
                                        <input type="text" id="mat" />
                                    </td>
                                    <td>	
                                        <span>Statut</span><br/>
                                        <select  id="stat"><option value=""></option><option value="0">LIBRE</option><option value="1">EN COURS</option><option value="2">TERMINE</option><option value="6">BLOQUE</option><option value="4">LIVRE</option><option value="3">ANNOMALIE</option>
                                        </select>
                                    </td>							
                                    <td>
                                        <span>Priorite</span><br/>
                                        <select  id="priorite">
                                            <option value=""></option>
                                            <option value="0">0</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                            <option value="6">6</option>
                                            <option value="7">7</option>
                                            <option value="8">8</option>
                                            <option value="9">9</option>
                                        </select>
                                    </td><td>
                                        <span> </span><br/>
                                        <input type="submit" id="goLdt"  value="" title="lancer la recherche" class="recherche"/>
                                        <input type="submit" id="goLdtStat"  value="" title="Statistique" class="statistique"/>
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


</div>
<div id="root">
    <div id="handle"></div>
    <div id="divflottant"></div>
</div>
</body>

<?php
include('footer.php');
?>
<script language="javascript" type="text/javascript" src="js/jquery.js"></script>
<script language="javascript" type="text/javascript" charset="utf-8">
// AUT Mirah RATAHIRY
// DES page Lot de tous les dossiers
// DAT 2012 03 06
    //about:config
    //signed.applets.codebase_principal_support;true
    var flagShow = 1;
    var theHandle = document.getElementById("handle");
    var theRoot = document.getElementById("root");
    Drag.init(theHandle, theRoot);



    $(document).ready(function () {
        $("td #sousspehide").hide();

        $('#mcorps').on('click', '#selectall', function () {
            $('.case').attr('checked', this.checked);
        });

        $('#ldtCorp').on('click', '.th', function () {
            //alert (this.id);
            goLdt(this.id);
        });

        /*
         $('#selectall').click(function() { // clic sur la case cocher/decocher
         
         var cases = $("#cases").find(':checkbox'); // on cherche les checkbox qui dépendent de la liste 'cases'
         if(this.checked){ // si 'cocheTout' est coché
         cases.attr('checked', true); // on coche les cases
         $('#case').html('Tout decocher'); // mise à jour du texte de cocheText
         }else{ // si on décoche 'cocheTout'
         cases.attr('checked', false);// on coche les cases
         $('#case').html('Cocher tout');// mise à jour du texte de cocheText
         }          
         
         });
         */
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
                type: "GET",
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
        if (idDoss == 712)
        {
            $("td #sousspehide").show();

        }
        getLstSousspecialite(idDoss);
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

    function getLdt(id)
    {

        $.ajax({
            type: "GET",
            url: "php/link.php?action=getLdt&id=" + id,
            success: function (msg) {
                if (msg == "")
                    return;
                else
                {
                    var tk = msg.split('|');
                    var strHTML = "";
                    strHTML += "<table style=\"margin-top: 20px;margin-left: 7px;\">";
                    strHTML += "<tr><td valign=\"top\">Statut : </td><td><select  class=\"sel\" id=\"STAT\"><option  value=''></option><option  value='1'>EN COURS</option><option  value='2'>TERMINE</option></select></td></tr>";
                    strHTML += "<tr><td valign=\"top\">Heure Debut : </td><td><input type=\text\" id=\"hDeb\"  class=\"sel\"  value =" + tk[2] + " ></td></tr>";
                    strHTML += "<tr><td valign=\"top\">Heure Fin : </td><td><input type=\text\" id=\"hFin\"  class=\"sel\" value =" + tk[3] + " ></td></tr>";
                    strHTML += "<tr><td valign=\"top\">Quantite : </td><td><input type=\text\" id=\"qt\"  class=\"sel\"  value =" + tk[4] + " ></td></tr>";
                    strHTML += "<tr><td valign=\"top\">Nb Erreur : </td><td><input type=\text\" id=\"err\"  class=\"sel\"  value =" + tk[5] + " ></td></tr>";

                    strHTML += "<tr><td colspan=\"2\"><br /><center><input type=\"button\" value=\"Annuler\" onclick=\"insertLDT();\"><input type=\"button\" value=\"Modifier\" onclick=\"insertLDT();\"></center></td></tr></table>";

                    document.getElementById('root').style.display = "block";
                    document.getElementById('root').style.height = "250px";
                    document.getElementById('root').style.width = "320px";
                    document.getElementById('root').style.left = "70px";
                    document.getElementById('root').style.top = "8px";
                    document.getElementById('divflottant').innerHTML = strHTML;
                    document.getElementById('handle').innerHTML = '<div id=\"handleTtl\" style=\"text-align: center\">' + tk[7] + " | " + tk[0] + " | " + tk[1] + '</div><img src="img/cl.png" style="float: right; margin-right: 5px;clear: none;margin-top: -25px; position: relative;" onclick="document.getElementById(\'root\').style.display = \'none\' ;">';

                    if (tk[6] == 'EN COURS')
                    {
                        $('option[value="1"]').attr('selected', 'true');
                    } else
                        $('option[value="2"]').attr('selected', 'true');
                }
            }
        });


    }
    function insertLDT()
    {
        alert($("#PRJ").val());
    }
    function goLdt(ordre)
    {
        var ldg = $("#ldg").val();
        var doss = $("#doss").val();
        var mat = $("#mat").val();
        var stat = $("#stat").val();
        var etape = $("#etape").val();
        var prio = $("#priorite").val();
        var name = $("#lotName").val();
        var sous_spe = $("#sous_specialite").val();


        if (doss == "")
        {
            alert("choisissez un dossier!");
            return;
        }
        $("#ldtCorp").html('<div class="body" id="Etape"><img src = "img/ramiLoad.gif"/>Loading ...</div>');
        $.ajax({
            type: "GET",
            url: "php/link.php?action=getLstLot&doss=" + doss + "&ldg=" + ldg + "&mat=" + mat + "&stat=" + stat + "&etape=" + etape + "&prio=" + prio + "&name=" + name + "&ordre=" + ordre + "&sous_spe=" + sous_spe,
            success: function (msg) {

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

    function getLstSousspecialite(idDossier)
    {
        $.ajax({
            type: "GET",
            url: "php/link.php?action=getListSousSpecialite&doss=" + idDossier,
            success: function (msg) {
                $("#sous_specialite").html(msg);
            }
        });

    }

</script>
</html>

