<?php


	include_once('header.inc.php');
	include_once('php/common.php');
	$c = new Cnx();
?>

<div id="mini_banni1ere">
<?php
	if ((isset($_SESSION['pseudo'])) && (!empty($_SESSION['pseudo'])))
	{
		echo '<a href="index.php" id="ldtIdProf">  Accueil |</a>';
		echo '<a href="rt.php" id="ldtIdProf">  Retard |</a>';
		echo '<a href="abs.php" id="ldtIdProf">  Abscence |</a>';
	}
	else
	{
		
	}
?>
</div>


<div id="menFilter">

<table id="tpPoint">
		<tr><td class="tdMen"></td>
		<td id="sepTD"></td><td class="tdMen"></td><td> Matricule
		<input type="text"  id="matricule" />
		</td><td class="tdMen"></td><td class="tdMen"></td><td> Departement
		<select  id="dep"><option value=""></option>;
				<?php
					echo ''.$c->getDepartement().'';
				?>
			</select>
		</td><td class="tdMen"></td><td>
			Date
			<select  id="datePt"><option value=""></option>;
				<?php
					echo ''.$c->getDatePt().'';
				?>
			</select>
			</td><td class="tdMen"></td><td>
			Pointeuse
			<select  id="typePt"><option value=""></option><option value="IN">IN</option><option value="OUT">OUT</option>
				
			</select>
			
		</td><td class="tdMen"></td><td><input type="submit" value="Filtrer" id="validNP" /></td><td class="tdMen"></td>
		</tr>
		<tr><td>
		<center>
			
		</center>
		</td>
		</tr>
</table>

</div>

<div class="sep"></div>
<center>
<div id="listePointage">
	<?php
		
		$currDate = date('Y/m/d');
		echo "<h2>Pointage $currDate</h2>";
		echo ''.$c->lstPointagePlat($currDate,"","", "").'';
	?>
</div>
</center>
<div class="sep"></div>
</body>
<script language="javascript" type="text/javascript" src="js/jquery.js"></script>
<script language="javascript" type="text/javascript" charset="utf-8">

	$("#validNP").click(function(){
		var dPt = $("#datePt").val();
		var mt = $("#matricule").val();
		var tp = $("#typePt").val();
		var dep = $("#dep").val();
		
		
		//$("#listePointage").hide();
		
		//$("#listePointage").show('slow');
		
		getLstPt(dPt, mt, tp, dep);
	});
	
	function getLstPt(dt, mt, tp, dep)
	{
		//alert(tp);
		var response = "";
		$.ajax({
		type: "GET",
		url: "php/link.php?action=getLstPtPlat&dt="+dt+"&mt="+mt+"&tp="+tp+"&dep="+dep,async: false,

			success: function(msg){
					response = msg;
					$("#listePointage").html(response);
			}
		});
	}

</script>
</html>
