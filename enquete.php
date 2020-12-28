<?php
	session_start();
	$path = $_SERVER['PHP_SELF']; // $path = /home/httpd/html/index.php
	$file = basename ($path);
	//echo"$file";
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml"  xml:lang="en" lang="en">
	<head>
		<title>Easytech.mg</title>
		<meta http-equiv="Content-Type" content="text/html; Charset=utf-8" />
		<style type="text/css">@import url(css/rami_css.css);</style>	
	</head>

<div id="mcorps">
    <div id="head">
        <?php
        //include('baniR.php');
        include('headMen.php');
        /*
if ((isset($_SESSION['error_msg'])) && (!empty($_SESSION['error_msg']))) {
            echo $_SESSION['error_msg'] . '<br>';
        }
        $currDate = date('Y/m/d');
        if ($c->checkMatricule()) {
            echo 'vita ny enquetes';
            header('Location:index.php');
        }
*/
        ?>
    </div>
    <div class="wcenter">
        
            <h1 class="wtitle1">
                Pour le besoin d’une étude de bien-être de ses collaborateurs, la Direction Générale invite chaque salarié à répondre aux questionnaires suivants : <br>            </h1>
<hr><hr>
            <div>
                <h3 class="title3">

                    1.	A quelle heure réveillez-vous le matin ?</h3>
                <input type="radio" name="1" value="a" id="1">a.	Avant 05 heures<br>
                <input type="radio" name="1" value="b" id="1">b.	Entre 05 heures et 06 heures<br>
                <input type="radio" name="1" value="c" id="1">c.	Entre 06 heures et 07 heures<br>
                <input type="radio" name="1" value="d" id="1">d.	Après 07 heures<br>
            </div>
            <div>
                <h3 class="title3">2.	A quelle heure couchez-vous le soir ?</h3>
                <input type="radio" name="2" value="a" id="2">a.	Avant 20 heures<br>
                <input type="radio" name="2" value="b" id="2">b.	Entre 20 heures et 21 heures<br>
                <input type="radio" name="2" value="c" id="2">c.	Entre 21 heures et 22 heures<br>
                <input type="radio" name="2" value="d" id="2">d.	Après 22 heures<br>
            </div><div>
                <h3 class="title3">3.	Passez-vous combien de temps pour aller au travail ? (Domicile/Lieu de travail)</h3>
                <input type="radio" name="3" value="a" id="3">a.	Moins de 30 minutes<br>
                <input type="radio" name="3" value="b" id="3">b.	Entre 30 minutes à 60 minutes<br>
                <input type="radio" name="3" value="c" id="3">c.	Entre 60 minutes et 90 minutes<br>
                <input type="radio" name="3" value="d" id="3">d.	Plus de 90 minutes<br>
            </div>
            <div>
                <h3 class="title3">4.	Quelle est actuellement la distance entre votre domicile et votre lieu de travail ?</h3>
                <input type="radio" name="4" value="a" id="4">a.	Moins de 5km<br>
                <input type="radio" name="4" value="b" id="4">b.	Entre 5km à 10km<br>
                <input type="radio" name="4" value="c" id="4">c.	Entre 10km à 15km<br>
                <input type="radio" name="4" value="d" id="4">d.	Plus de 15km<br>
            </div>
            <div>
                <h3 class="title3">5.	Quel est votre moyen de transport habituel pour se rendre au travail ?</h3>
                <input type="radio" name="5" value="a" id="5">a.	A pied<br>
                <input type="radio" name="5" value="b" id="5">b.	Par Taxi – be<br>
                <input type="radio" name="5" value="c" id="5">c.	Par bicyclette / Moto / Scooter<br>
                <input type="radio" name="5" value="d" id="5">d.	Autres : voiture particulière, ….<br>
            </div>
<hr><hr>
            <div>
                <input type="hidden" value="<?php echo $_SESSION['id']; ?>" id="idsess">
                <input type="submit" value="Valider" name="valider" id="survey">
            </div></div>
        
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
    $("#survey").click(function() {

		$("#survey").attr('disabled','disabled');
        var idpers = $("#idsess").val();
        var reveil = $("input:radio[name='1']:checked").val();
        var coucher = $("input:radio[name='2']:checked").val();
        var trajet = $("input:radio[name='3']:checked").val();
        var distance = $("input:radio[name='4']:checked").val();
        var transport = $("input:radio[name='5']:checked").val();
        if (reveil !== undefined && coucher !== undefined && trajet !== undefined && distance !== undefined && transport !== undefined)
            InsertSurvey(idpers, reveil, coucher, trajet, distance, transport);
        else
        {
            alert('Vous devez remplir tout les champs');
$('#survey').removeAttr('disabled');
            return;
        }
    });

    function checkMatricule(matricule) {
        alert(matricule);
    }
    function InsertSurvey(idpers, reveil, coucher, trajet, distance, transport)
    {
        $.ajax({
            type: 'GET',
            url: "php/link.php?action=InsertSurvey&idpers=" + idpers + "&reveil=" + reveil + "&coucher=" + coucher + "&trajet=" + trajet + "&distance=" + distance + "&transport=" + transport,
            success: function() {
                alert("Merci pour votre réponse!");
                window.location = "index.php";
            }
        });
    }
</script>
</html>




