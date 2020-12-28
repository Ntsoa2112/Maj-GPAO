<?php

	include_once('header.inc.php');
	include_once('php/common.php');	
	 
?>

<div id="mcorps">
	<div id="head">
		<?php
			include('baniR.php');
			include('headMen.php');
			if ((isset($_SESSION['error_msg'])) && (!empty($_SESSION['error_msg'])))
				{
					echo $_SESSION['error_msg'].'<br>';
				}
				
				$c = new Cnx();

				$strDate = $c->getDatePt();
			

		?>
	</div>
	
	<div id="content">

<center>
		<div id="content_centre">
		
				<table style="width:80%">
					<tr class="tb_header">
						<td  class="tb_header">
							<table  id="ldtHead">
							<tr>
							<td>
								<span>Dossier</span><br/>
								<select  id="doss"><option value=""></option>
									<?php
									echo $c->getLstDossier();
									?>
								</select>
							</td>
							<td> <span>Departement</span><br/>
								<select  id="dep"><option value=""></option>;
									<?php
										echo ''.$c->getDepartement().'';
									?>
								</select>
							</td>							
							<td>	
								<span>matricule</span><br/>
								<input type="text" id="mat" />
							</td>
							<td>
								<span> </span><br/>
								<input type="submit" id="go"  value="" title="lancer la recherche" class="recherche"/>
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
<center>
<div id="result"></div>
</center>

		</div>
</center>
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
	
	var theHandle = document.getElementById("handle");
	var theRoot   = document.getElementById("root");
	Drag.init(theHandle, theRoot);
	var idCV = $("#id").val();

	
	$("#go").click(function(){
	var doss = $("#doss").val();
	var dep = $("#dep").val();
	var mat = $("#mat").val();

		$("#result").html('<div class="body" id="result"><img src = "img/ramiLoad.gif"/>Loading ...</div>');
		$.ajax({
		type: "GET",
		url: "php/link.php?action=getListConnected&dep="+dep+"&doss="+doss+"&mat="+mat,
			success: function(msg){
				$("#result").html(msg);
				$("#result").show('slow');
			}
		});
	});
	
	
	$("#goMd5").click(function(){
		var val = $("#md5").val();
	
		$.ajax({
		type: "GET",
		url: "php/link.php?action=md5&val="+val,
			success: function(msg){
				$("#result").val(msg);
			}
		});
	});
	
	function deleteReport(str)
	{
		$.ajax({
		type: "GET",
		url: "php/link.php?action=deleteReport&id="+str,
			success: function(msg){
				//goLdt("");
			}
		});
	}
	
	$("#goLdtStat").click(function(){
		goLdt("stat");
	});

function showIt(elem)
{
	if ($.browser.msie && parseInt($.browser.version)<8) { 
		$(elem).show(100);
		return;
	}	
	$(elem).slideDown(100);
}

</script>
</html>

