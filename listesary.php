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
			if ((isset($_SESSION['error_msg'])) && (!empty($_SESSION['error_msg'])))
				{
					echo $_SESSION['error_msg'].'<br>';
				}
		?>
	</div>

	<center>
	<?php
	 echo $c->GetLstFolder('img');
	
	?>
	<center>
	
	<script language="javascript" type="text/javascript" src="js/jquery.js"></script>
<script language="javascript" type="text/javascript" charset="utf-8">


	$("a").click(function(){
		var val = $(this).attr('id');
		
		//alert(val);
		$(location).attr('href',"sary.php?item="+val);
	/*
		$.ajax({
		type: "GET",
		url: "php/link.php?action=md5&val="+val,
			success: function(msg){
				$("#result").val(msg);
			}
		});
		*/
	});
	
	</script>