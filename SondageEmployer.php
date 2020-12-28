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
        //include('headMen.php');
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
            <h1 class="wtitle1"> Pour la préparation de la remise de médaille de travail, prévue l’année prochaine, <br>La Direction et les délégués du personnel demandent à chaque salarié de répondre aux questionnaires suivants <br></h1>
			<br><br>
            <div id="Question1">
			<hr>
                <h3 class="title3">1.	Le cumul de vos années de travail formel (chez Easytech Madagascar et dans d’autres sociétés) serait de :</h3>
				<h4 class="title4">
                <input type="radio" name="1" value="Moins de 10 ans" id="1">	Moins de 10 ans <br>
                <input type="radio" name="1" value="10 ans à 14 ans (Médaille de bronze)" id="2">	10 ans à 14 ans (Médaille de bronze) <br>
                <input type="radio" name="1" value="15 ans et plus ( Médaille d’argent )" id="3">	15 ans et plus ( Médaille d’argent ) <br>
				</h4>
            </div>
            <div id="Question2" style="display:none"><br><br>
			<hr>
                <h3 class="title3">2.	Quand souhaiteriez-vous être décoré de médaille de travail?</h3>
				<h4 class="title4">
                <input type="radio" name="2" value="2016" id="2">	2016 <br>
                <input type="radio" name="2" value="2017" id="2">	2017 <br>
                <input type="radio" name="2" value="Jamais" id="2">	Jamais <br>
				</h4>
				<br><br>
				<hr>
            </div>
			<br><br>
            <div>
                <input type="hidden" value="<?php echo $_SESSION['id']; ?>" id="idsess">
                <input type="submit" value="Valider" name="valider" id="survey">
            </div>
		</div>
        
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

	$( "input[type='radio']" ).change(function() {
		if($("input:radio[name='1']:checked").val() == "Moins de 10 ans")
		{
			$("#Question2").slideUp("slow");
		}else{
			$("#Question2").slideDown("slow");
		}
	});

    $("#survey").click(function() {

		$("#survey").attr('disabled','disabled');
        var idpers = $("#idsess").val();
        var anneetrvail = $("input:radio[name='1']:checked").val();
        var decormedail = $("input:radio[name='2']:checked").val();
		alert(decormedail);
       if(anneetrvail == 'Moins de 10 ans')
	   {
			//InsertSOndage(idpers, anneetrvail, "");
	   }else{
			if (anneetrvail !== undefined && decormedail !== undefined)
			{
				//InsertSOndage(idpers, anneetrvail, decormedail);
			}
			else
			{
				alert('Vous devez remplir tout les champs');
				$('#survey').removeAttr('disabled');
				return;
			}
	   }
    });

    function checkMatricule(matricule) {
        alert(matricule);
    }
	
	//Ajout des données dans la base "enquete_medaille"
    function InsertSOndage(idpers, anneetrvail, decormedail)
    {
        $.ajax({
            type: 'GET',
            url: "php/link.php?action=insertSondage&idpers=" + idpers + "&anneetrvail=" + anneetrvail+"&decormedail="+decormedail,
            success: function(msg) {
               // alert("Merci pour votre réponse!");
               alert(msg);
                window.location = "index.php";
            }
        });
    }
</script>
</html>




