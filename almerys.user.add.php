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
        <hr/>
        <?php
        $c = new Cnx();
        $strDate = $c->getDatePt();
        $strCat = $c->getLstCategorie();
        ?>
        <form class="form-horizontal">
            <div class="form-group form-group-sm">
                <h1 class="bigger lighter">INSERTION OPERATEUR</h1>
                <label class="col-sm-1 control-label" for="lg">SAT</label>
                <div class="col-sm-10">
                    <input class="form-control" type="text" id="sat">
                </div>
            </div>
            <div class="form-group form-group-sm">
                <label class="col-sm-1 control-label" for="sm">MATRICULE OP</label>
                <div class="col-sm-10">
                    <input class="form-control" type="text" id="matriculeop">
                </div>
            </div>

            <div class="form-group form-group-sm">
                <label class="col-sm-1 control-label" for="sm">MATRICULE CQ</label>
                <div class="col-sm-10">
                    <input class="form-control" type="text" id="matriculecq">
                </div>
            </div>

            <div class="form-group form-group-sm">
                <label class="col-sm-1 control-label" for="sm">POLE</label>
                <div class="col-sm-10">
                    <select  id="ldg" class="form-control" data-style="btn-primary">
                    </select>
                </div>
            </div>
    </div>
    <div class="checkbox">
        <label>  <input type="checkbox" class="checkbox style-5 pull-right" id="isnovice"> Novice</label>

    </div>
    <div class="form-group form-group-sm">
        <input type="submit" id="goSaveUser"  value=" Enregistrer" title="lancer la recherche" class="btn btn-primary" />

    </div>
    <?php
    //include('corps.php');
    ?>
</form>
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


    $(document).ready(function () {

        //DrawGraph([1,2,3, 4], ["1","2","3","4"]);
        var ldg = $("#ldg").val();
        getLotClient(201);

        $('#ldtCorp').on('click', '.th', function () {
            goSaveUser(this.id);
        });

        $('#root').on('click', '#STAT option', function () {

            $(".ALMERYS_ERR_TYPE").hide();
            classErr = "." + $("#STAT").val() + "." + $("#idLdg").val();
            //alert(classErr);
            $(classErr).show();
        });

    });

    $("#goSaveUser").click(function () {
        goSaveUser("");
    });

    $('.th').click(function () {
        alert("ok");
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

//fonction pour l'insertion des utilisateur almerys
    function goSaveUser(ordre)
    {

        var ldg = ($("#ldg").val() == undefined) ? '' : $("#ldg").val();
        var sat = ($("#sat").val() == undefined) ? '' : $("#sat").val();
        var mat = ($("#matriculeop").val() == undefined) ? '' : $("#matriculeop").val();
        var matriculecq = ($("#matriculecq").val() == undefined) ? '' : $("#matriculecq").val();
        var isnovice = ($('#isnovice:checked').val() == undefined) ? 'FALSE' : 'TRUE';

        //   $("#ldtCorp").html('<div class="body" id="Etape"><img src = "img/ramiLoad.gif"/>Loading ...</div>');
        $.ajax({
            type: "GET",
            url: "php/link.php?action=insertAlmerysUser&sat=" + sat + "&pole=" + ldg + "&matr=" + mat + "&matrcq=" + matriculecq + "&novice=" + isnovice,
            success: function (msg) {
                // alert(msg);
                // $("#ldtCorp").html(msg);
            }
        });
        alert("enregistrement faite");
    }

//fonction permetant de lister les pole existant
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
</script>
</html>

