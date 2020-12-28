<?php
include_once('header.inc.php');
include_once('php/common.php');
$c = new Cnx();
?>

<div id="mcorps">
    <div id="head">
        <?php
        include('baniR.php');
        include('headMen.php');
        if ((isset($_SESSION['error_msg'])) && (!empty($_SESSION['error_msg']))) {
            echo $_SESSION['error_msg'] . '<br>';
        }
        $currDate = date('Y/m/d');
        ?>
    </div>

    <div id="content">

        <center>
            <div id="content_centre">


                <div id="info">
                    <?php
                    echo "Pointage du: $currDate";
                    ?>
                </div>
                <br>
                <table id="lot">
                    <tr  class="tb_header">
                        <td>

                            <table  id="ldtHead">
                                <tr  class="tb_header">
                                    <td class="tdMen"></td>
                                    <td> Matricule
                                        <input type="text"  id="matricule" />
                                    </td>
                                    <td> Departement
                                        <select  id="dep"><option value=""></option>;
                                            <?php
                                            echo '' . $c->getDepartement() . '';
                                            ?>
                                        </select>
                                    </td>
                                    <td>
                                        Date Debut
                                        <select  id="datePt"><option value=""></option>;
                                            <?php
                                            echo '' . $c->getDatePt() . '';
                                            ?>
                                        </select>
                                    </td>
                                    <td>
                                        Date fin
                                        <select  id="dateFin"><option value=""></option>;
                                            <?php
                                            echo '' . $c->getDatePt() . '';
                                            ?>
                                        </select>
                                    </td>
									<td>
										 Anomalie
						<input type="checkbox" id="anomalie" name="anomalie" value="Anomalie">
					
                                    </td>
                                    <td>
                                        Pointeuse
                                        <select  id="typePt"><option value=""></option><option value="IN">IN</option><option value="IN-1">IN-1</option><option value="IN-2">IN-2</option><option value="IN-3">IN-3</option><option value="IN-4">IN-4</option><option value="OUT">OUT</option><option value="OUT-1">OUT-1</option><option value="OUT-2">OUT-2</option><option value="OUT-3">OUT-3</option><option value="OUT-4">OUT-4</option>
                                        </select>
                                    </td>
                                    <td><input type="submit" value="" id="validNP"  class="recherche" title="Lancer la recherche"/></td>
                                    <?php 
                                    $canSee = [551, 552, 70];
                                    if(in_array($_SESSION['id'], $canSee))
                                        echo '<td><input type="submit" value="" id="pointage-cp-alemrys"  class="recherche" title="Pointage CP almerys"/></td>';
                                    ?>
                                </tr>
                            </table>

                        </td></tr><tr><td id="lstpt">
                            <?php
                            echo '' . $c->lstPointage($currDate, "", "", "", "","") . '';
                            ?>
                        </td></tr></table></div>
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
        var dateFin = $("#dateFin").val();
        var mt = $("#matricule").val();
        var tp = $("#typePt").val();
        var dep = $("#dep").val();
		var anomalie=$("#anomalie:checkbox:checked").length > 0;
		 var checkanomalie = anomalie.toString();
        $("#listePointage").hide();
        getLstPt(dPt, dateFin, mt, tp, dep,checkanomalie);
        $("#listePointage").show('slow');
    });

    $("#pointage-cp-alemrys").click(function () {
        var dPt = $("#datePt").val();
        var dateFin = $("#dateFin").val();

        $("#listePointage").hide();
        getLstPtCpAlm(dPt, dateFin);
        $("#listePointage").show('slow');
    });

    function getLstPt(dt, dateFin, mt, tp, dep,anomalie)
    {
        //alert("php/link.php?action=getLstPt&dt="+dt+"&mt="+mt+"&tp="+tp+"&dep="+dep);
        var response = "";
        $.ajax({
            type: "GET",
            url: "php/link.php?action=getLstPt&dt=" + dt + "&dtfin=" + dateFin + "&mt=" + mt + "&tp=" + tp + "&dep=" + dep+"&ch=.&anomalie="+anomalie, async: false,
            //url: "php/link.php?action=getLstPt&dt=" + dt + "&dtfin=" + dateFin + "&mt=" + mt + "&tp=" + tp + "&dep=" + dep, async: false,

            success: function (msg) {
				
                response = msg;
                var phpScript = "";
               // $("#lstpt").html(response);
                $("#lstpt").html(response);
                $("#info").html("Poitage du: " + dt + " | matricule: " + mt);
                
            }
        });
    }

    function getLstPtCpAlm(dt, dateFin)
    {
        var response = "";
        $.ajax({
            type: "GET",
            url: "php/link.php?action=getLstPtCpAlm&dt=" + dt + "&dtfin=" + dateFin + "&ch=.", async: false,

            success: function (msg) {
                response = msg;
                var phpScript = "";
               // $("#lstpt").html(response);
                $("#lstpt").html(response);
                $("#info").html("Poitage du: " + dt + " | matricule: " + mt);
                
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
