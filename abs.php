<?php
         include_once('header.inc.php');
         include_once('php/common.php');
         $c =new Cnx();
?>

<div id="mini_banni1ere">
  <?php
	if ((isset($_SESSION['pseudo'])) && (!empty($_SESSION['pseudo'])))
	{
		echo '<a href="index.php" id="ldtIdProf">  Accueil |</a>';
		echo '<a href="rt.php" id="ldtIdProf">  Retard |</a>';
		echo '<a href="pt.php" id="ldtIdProf"> | Pointage |</a>';
	}
	else
	{
		
	}
?>
</div>
<div id="menFilter">
<table id="absFilter">
    <tr>
      <td class="tdMen"></td>
      <td id="sepTD"></td>
      <td class="tdMen"></td>
      
      <td>
  			Date
  			<select  id="dateAbs">
          <option value=""> </option>;
  				<?php
					//$currDate = date('Y/m/d');
  					echo ''.$c->getDateAbs().'';
  				?>
  			</select>
  			
  		</td>
      <td class="tdMen"></td>
      <td>
          <input type="submit" value="Filtrer" id="filterAbs" />
      </td>
      <td class="tdMen"></td>
		</tr>
		<tr>
      <td>
		    <center>
			
		    </center>
		  </td>
		</tr>
</table>

</div>
<div class="sep"></div>
<center>
  <div id="listeAbsc">
  	<?php
		$currDate = date('Y/m/d');
		echo "<h2>Abscence $currDate</h2>";
  		echo ''.$c->getListAbsence($currDate).'';
  	?>
  </div>
</center>
<div class="sep"></div>
</body>

<script language="javascript" type="text/javascript" src="js/jquery.js"></script>
<script language="javascript" type="text/javascript" charset="utf-8">

	$("#filterAbs").click(function(){

		var dAbs = $("#dateAbs").val();
	
		
		getLstAbs(dAbs);
	});
	
	function getLstAbs(dAbs)
	{
		//alert(tp);
		var response = "";
		$.ajax({
		type: "GET",
		url: "php/link.php?action=getLstAbs&dAbs="+dAbs,async: false,

			success: function(msg){
					response = msg;
					$("#listeAbsc").html(response);
			}
		});
	}

</script>
</html>
