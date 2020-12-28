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

		<div class="wcenter">
            <h1 class="wtitle1">Pour le besoin d’une étude de bien-être de ses collaborateurs, la Direction Générale invite chaque salarié à répondre aux questionnaires suivants : <br></h1>
			<hr>
            <div id="Question1">
                <h3 class="title3">1.	Parmi les quartiers ci dessous, lequel est le plus près de chez vous? donnez le temps moyen pour vous y rendre, sans bouchons, en minutes :</h3>
                <div style="margin-left:50px;"><h4><input type="radio" name="1" value="Itoasy" id="1">	Itoasy <br>
                <input type="radio" name="1" value="Ampefiloha" id="2">	Ampefiloha <br>
                <input type="radio" name="1" value="Ankorondrano" id="3">	Ankorondrano <br>
				<input type="radio" name="1" value="Andraharo" id="4">	Andraharo <br>
                <input type="radio" name="1" value="Soanierana" id="5">	Soanierana <br>
                <input type="radio" name="1" value="Antsakaviro" id="3">	Antsakaviro <br></h4></div>
				
				<label style="margin-left:50px;">Le temps moyen pour vous y rendre ( minute(s) ) : 
					<select id="temps" name="select">
						<?php
							for($i=1; $i<=500; $i++)
							{
								?>
									<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
								<?php
							}
						?>
					</select> mn(s)
				</label><br>
            </div>
            <div>
                <h3 class="title3">2.	Merci de noter de 0 à 4 les exemples de locaux disponibles à ce jour pour la société. Merci de tenir compte des autres aspects que l'emplacement. </h3>
				<h4 class="title4">
                <div style="margin-left:50px;">
					<p> 0 = impossible. Dans ce cas, merci d'expliquer pourquoi </p>
					<p> 1 = peu favorable. Dans ce cas, merci d'expliquer pourquoi </p>
					<p> 2 = sans avis </p>
					<p> 3 = favorable </p>
					<p> 4 = très favorable </p>
				</div>
				</h4>
				<table border="1">
				   <tr>
					   <td>A: Route Digue, derrière Score Digue. Type: local industriel, type hangar, 2 niveaux,  réaménagé en bureau. Petit espace extérieur. Terrain partagé avec d'autres sociétés.</td>
					   <!--<td><input id="NoteA" type="number" min="0" max="4" value ="" onclick="test('NoteA','A')"/></td>-->
					   <td>
							<select id="NoteA" name="selectA" onchange="test('NoteA','A')"><option value=""></option>
								<?php
									for($i=0; $i<=4; $i++)
									{
										?>
											<option value="<?php echo $i; ?>" onclick="test('NoteA','A')"><?php echo $i; ?></option>
										<?php
									}
								?>
							</select>
						</td>
					   <td id="A" style="display:none"><textarea rows="4" cols="50" id="InfoA" placeholder="merci d'expliquer pourquoi ?"></textarea></td>
				   </tr>
				   <tr>
					   <td>B: Tsiadana proche Clinic 24h. Type: locaux éclairés et vastes 2 niveaux, coin calme, cours et jardin, espace privé extérieur et espace pour restauration. Terrain privé cloturé.</td>
					   <!--<td><input id="NoteB" type="number" min="0" max="4" value ="" onclick="test('NoteB','B')"/></td>-->
					   <td>
							<select id="NoteB" name="selectB" onchange="test('NoteB','B')"><option value=""></option>
								<?php
									for($i=0; $i<=4; $i++)
									{
										?>
											<option value="<?php echo $i; ?>" onclick="test('NoteA','A')"><?php echo $i; ?></option>
										<?php
									}
								?>
							</select>
						</td>
					   <td id="B" style="display:none"><textarea rows="4" cols="50" id="InfoB" placeholder="merci d'expliquer pourquoi ?"></textarea></td>
				   </tr>
				   <tr>
					   <td>C: Antsakaviro proche croustipain. Type: locaux type immeuble  5 niveaux , pas d'espace extérieur mais possibilité terrasse. Pas de terrain.</td>
					   <!--<td><input id="NoteC" type="number" min="0" max="4" value ="" onclick="test('NoteC','C')"/></td>-->
					   <td>
							<select id="NoteC" name="selectC" onchange="test('NoteC','C')"><option value=""></option>
								<?php
									for($i=0; $i<=4; $i++)
									{
										?>
											<option value="<?php echo $i; ?>" onclick="test('NoteA','A')"><?php echo $i; ?></option>
										<?php
									}
								?>
							</select>
						</td>
					   <td id="C" style="display:none"><textarea rows="4" cols="50" id="InfoC" placeholder="merci d'expliquer pourquoi ?"></textarea></td>
				   </tr>
				   <tr>
					   <td>D: Soanierano, vers chocolaterie Robert. Type: Hangar réaménagés en bureaux, espaces extérieur vastes.   Terrain privé cloturé.</td>
					   <!--<td><input id="NoteD" type="number" min="0" max="4" value ="" onclick="test('NoteD','D')"/></td>-->
					   <td>
							<select id="NoteD" name="selectD" onchange="test('NoteD','D')"><option value=""></option>
								<?php
									for($i=0; $i<=4; $i++)
									{
										?>
											<option value="<?php echo $i; ?>" onclick="test('NoteA','A')"><?php echo $i; ?></option>
										<?php
									}
								?>
							</select>
						</td>
					   <td id="D" style="display:none"><textarea rows="4" cols="50" id="InfoD" placeholder="merci d'expliquer pourquoi ?"></textarea></td>
				   </tr>
				   <tr>
					   <td>E: Andraharo vers madauto. Type: immeuble de bureaux partagé avec d'autres sociétés, 2 niveaux. Espace extérieur non privé.  Terrain partagé avec d'autres sociétés.</td>
					   <!--<td><input id="NoteE" type="number" min="0" max="4" value ="" onclick="test('NoteE','E')"/></td>-->
					   <td>
							<select id="NoteE" name="selectE" onchange="test('NoteE','E')"><option value=""></option>
								<?php
									for($i=0; $i<=4; $i++)
									{
										?>
											<option value="<?php echo $i; ?>" onclick="test('NoteA','A')"><?php echo $i; ?></option>
										<?php
									}
								?>
							</select>
						</td>
					   <td id="E" style="display:none"><textarea rows="4" cols="50" id="InfoE" placeholder="merci d'expliquer pourquoi ?"></textarea></td>
				   </tr>
				   <tr>
					   <td>F: Ampefiloha: Locaux type bureaux, exactement comme ARO: pas d'espace extérieur et dans un immeuble avec d'autres sociétés. Pas de terrain.</td>
					   <!--<td><input id="NoteF" type="number" min="0" max="4" value ="" onclick="test('NoteF','F')"/></td>-->
					   <td>
							<select id="NoteF" name="selectF" onchange="test('NoteF','F')"><option value=""></option>
								<?php
									for($i=0; $i<=4; $i++)
									{
										?>
											<option value="<?php echo $i; ?>" onclick="test('NoteA','A')"><?php echo $i; ?></option>
										<?php
									}
								?>
							</select>
						</td>
					   <td id="F" style="display:none"><textarea rows="4" cols="50" id="InfoF" placeholder="merci d'expliquer pourquoi ?"></textarea></td>
				   </tr>
				</table></br>
            </div>
			<hr>
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

	/*function test(id,info)
	{
		$("input[type='number']" ).change(function() 
		{
			if($("#"+id+"").val() == "0" || $("#"+id+"").val() == "1")
			{
				$("#"+info+"").show('medium');
			}else{
				$("#"+info+"").hide('medium');
				
			}
		});
	}*/
	function test(id,info)
	{
		$("#"+id+"").each(function(){
			if($("#"+id+"").val() == "0" || $("#"+id+"").val() == "1")
			{
				$("#"+info+"").show('medium');
			}else{
				$("#"+info+"").hide('medium');
				
			}
		});
	}

	

    $("#survey").click(function() {
		//$("#survey").attr('disabled','disabled');
		
        var idpers = $("#idsess").val();

		//Question 1
        var quartier = $("input:radio[name='1']:checked").val();
        var temps = $("#temps").val();
		
		//Question 2
		var NoteA = $("#NoteA").val();
		var NoteB = $("#NoteB").val();
		var NoteC = $("#NoteC").val();
		var NoteD = $("#NoteD").val();
		var NoteE = $("#NoteE").val();
		var NoteF = $("#NoteF").val();
		
		//Raison question 2
		var InfoA = $("#InfoA").val();
		var InfoB = $("#InfoB").val();
		var InfoC = $("#InfoC").val();
		var InfoD = $("#InfoD").val();
		var InfoE = $("#InfoE").val();
		var InfoF = $("#InfoF").val();
		
		/*alert('Quartier : '+ quartier +' Temps : '+ temps);
		alert('A : '+ NoteA + ' B : '+ NoteB +' C : '+ NoteC +' D : '+ NoteD +' E : '+ NoteE +' F : ' + NoteF);
		alert('A : '+ InfoA + ' B : '+ InfoB +' C : '+ InfoC +' D : '+ InfoD +' E : '+ InfoE +' F : ' + InfoF);*/
		
		if (quartier !== undefined && temps !== undefined)
		{
			if(((NoteA == '0' || NoteA == '1') && (InfoA == "")) || ((NoteB == '0' || NoteB == '1') && (InfoB == "")) || ((NoteC == '0' || NoteC == '1') && (InfoC == "")) || ((NoteD == '0' || NoteD == '1') && (InfoD == "")) || ((NoteE == '0' || NoteE == '1') && (InfoE == "")) || ((NoteF == '0' || NoteF == '1') && (InfoF == "")) )
			{
				alert('Il faut préciser la raison de votre note égal 0 ou 1');
			}else{
				if( NoteA == '' || NoteB == '' || NoteC == '' || NoteD == '' || NoteE == '' || NoteF == '' )
				{
					alert('Un ou plusieur choix vide');
				}else{
					InsertSLocalisationBureau(idpers, quartier, temps, NoteA, NoteB, NoteC, NoteD, NoteE, NoteF, InfoA, InfoB, InfoC, InfoD, InfoE, InfoF);
				}
			}
		}
		else
		{
			alert('Erreur !!!\n\nToute les questions sont obligatoires');
			$('#survey').removeAttr('disabled');
			return;
		}
    });
	
	/*function check_numerique(input){
            var reg= /^[0-9]*$/;
			if(input == "")
			{
				return false;
			}else{
				if(reg.test(input)){
					return true;
				}
				else {
					return false;
				}
			}
    }*/

    function checkMatricule(matricule) {
        alert(matricule);
    }
	
	//Ajout des données dans la base "enquete_medaille"
    function InsertSLocalisationBureau(idpers, quartier, temps, NoteA, NoteB, NoteC, NoteD, NoteE, NoteF, InfoA, InfoB, InfoC, InfoD, InfoE, InfoF)
    {
        $.ajax({
            type: 'POST',
            url: "php/link.php?action=InsertSLocalisationBureau&idpers=" + idpers + "&quartier=" + quartier+"&temps="+temps+"&NoteA="+NoteA+"&NoteB="+NoteB+"&NoteC="+NoteC+"&NoteD="+NoteD+"&NoteE="+NoteE+"&NoteF="+NoteF+"&InfoA="+InfoA+"&InfoB="+InfoB+"&InfoC="+InfoC+"&InfoD="+InfoD+"&InfoE="+InfoE+"&InfoF="+InfoF,
            success: function(msg) {
               // alert("Merci pour votre réponse!");
               alert(msg);
                window.location = "index.php";
            }
        });
    }
</script>
</html>




