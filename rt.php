<?php
	include_once('header.inc.php');
	include_once('php/common.php');
	$c = new Cnx();
?>

<div id="mini_banni1ere">
<?php
	if ((isset($_SESSION['pseudo'])) && (!empty($_SESSION['pseudo'])))
	{
		echo '<a href="index.php" id="ldtIdProf">  Accueil |</a>
				<a href="pt.php" id="ldtIdProf">  Pointage |</a>';
		echo '<a href="abs.php" id="ldtIdProf">  Abscence |</a>';
	}
	else
	{
		
	}
?>
</div>


<div id="menFilter">

<table id="tpLate">
		<tr><td class="tdMen"></td><td id="sepTD"></td><td class="tdMen"></td>
      <td>
			Departement
			<select  id="depart"><option value=""></option>;
				<option>ALMERYS</option>
				<option>AGT DE SERVICE</option>
				<option>CLASSIQUE</option>
				<option>CADRE</option>
				<option>NF SANTE</option>
				<option>REF WEB</option>
			</select>
      <td>
			Date
			<select  id="dateRt"><option value=""></option>;
				<?php
					echo ''.$c->getDatePt().'';
				?>
			</select>
			</td><td class="tdMen"></td><td><input type="submit" value="Filtrer" id="valid" /></td><td class="tdMen"></td>
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
<div id="listeRetard">
	<?php
		$currDate = date('Y/m/d');
		echo "<h2>Liste Retard $currDate</h2>";
		echo ''.$c->getLate($currDate,"").'';
	?>
</div>
</center>
<div class="sep"></div>
</body>
<script language="javascript" type="text/javascript" src="js/jquery.js"></script>
<script language="javascript" type="text/javascript" charset="utf-8">

	$("#valid").click(function(){
		var dRt = $("#dateRt").val();
		var dpt = $("#depart").val();
		
		getLate(dRt,dpt);
	});
	
	function getLate(rt,dpt)
	{
		//alert(tp);
		var response = "";
		$.ajax({
		type: "GET",
		url: "php/link.php?action=getLate&rt="+rt+"&dpt="+dpt,async: false,

			success: function(msg){
					response = msg;
					$("#listeRetard").html(response);
			}
		});
	}

</script>
</html>
