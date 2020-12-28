<?php
include_once('header.inc.php');
include_once('php/common.php');
$c = new Cnx();
?>
<script src="js/angular.min.js"></script>
<div id="mcorps">
    <div id="head">
        <?php
        include('baniR.php');
        include('headMen.php');

        if ((isset($_SESSION['error_msg'])) && (!empty($_SESSION['error_msg']))) {
            echo $_SESSION['error_msg'] . '<br>';
        }
        $currDate = date('Y/m/d');
        $h = date("H:i:s", time());
        $jour = date('Y/m/d');
        ?>
    </div>
    <div id='dDate' style="display:none"><?php echo $currDate ?></div>

    <div id="content">

        <center>
            <div id="content_centre">
                <div><span class="matLabel">----:: POINTAGE ::----</span><hr/><span class="matLabel">Matricule</span>
                    <select id="matriculeOP">
                        <?php echo $c->getLstMat(); ?>
                    </select>

                    <select  id="typePt"><option value=""></option><option value="IN">IN</option><option value="OUT">OUT</option><option value="IN_ARO">IN_ARO</option><option value="OUT_ARO">OUT_ARO</option><option value="IN_RDJ">IN_RDJ</option><option value="OUT_RDJ">OUT_RDJ</option>
                    </select>
                    <input id="iTime" type="text"  class="matLabel" value="<?php echo $h; ?>"/>
                    <input id="jour" type="text"  class="matLabel" value="<?php echo $jour; ?>"/>
                    <input id="gobutton" type="submit" value="Enregistrer" />
                </div>
                <div class="datecontent">

                    <hr />
                    <br />
                    <div>

                        <?php
                        echo '' . $c->lstPointage($currDate, "", "", "") . '';
                        ?>
                    </div>
                </div>

            </div>
    </div>
</div>
</center>
<div class="sep"></div>
</body>

<?php
include('footer.php');
?>
<script language="javascript" type="text/javascript" src="js/jquery.js"></script>
<script language="javascript" type="text/javascript" charset="utf-8">

    $("#validNP").click(function () {
        var dPt = $("#datePt").val();
        var mt = $("#matricule").val();
        var tp = $("#typePt").val();
        var dep = $("#dep").val();


        $("#listePointage").hide();
        getLstPt(dPt, mt, tp, dep);
        $("#listePointage").show('slow');
    });

    $("#gobutton").click(function () {
        var id_pers = $("#matriculeOP").val();
        $("#listePointage").hide();
        var pt = $("#typePt").val();
        var heurePt = $("#iTime").val();
        var jourPt = $("#jour").val();

        var heure = heurePt.split(':');
        if (heure[0].length != 2 || heure[1].length != 2 || heure[2].length != 2)
        {
            alert("format Heure incorrect! \n Veuillez ressaisir ");
            return;
        }

        if (parseInt(heure[0]) > 24 || parseInt(heure[1]) > 59 || parseInt(heure[2]) > 59)
        {
            alert("format Heure incorrect! \n Veuillez ressaisir ");
            return;
        }

        if (pt == '')
        {
            alert("Veuillez selectionner le site");
            return;
        }

        if ($("#dDate").html() == '')
        {
            alert("Veuillez selectionner le matricule");
            return;
        }
        $.ajax({
            type: "GET",
            url: "php/link.php?action=pointage&idpers=" + id_pers + "&pt=" + pt + "&heurePt=" + heurePt + "&jourPt=" + jourPt, async: true,
            success: function (msg) {
              //  alert(msg);
                getLstPt($("#dDate").html(), '', '', '');
                $("#listePointage").show('slow');
            }
        });
    });

    function getLstPt(dt, mt, tp, dep)
    {
        var response = "";
        $.ajax({
            type: "GET",
            url: "php/link.php?action=getLstPt&dt=" + dt + "&mt=" + mt + "&tp=" + tp + "&dep=" + dep, async: false,
            success: function (msg) {
                response = msg;
                $("#listePointage").html(response);
                $("#info").html("Poitage du: " + dt + " | matricule: " + mt);
            }
        });
    }

</script>
</html>
