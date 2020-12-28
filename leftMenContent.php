<center>
	<li><a href="index.php">Fandraisana</a></li>
	<li><a href="#">Fikambanana</a></li>
	<li><a href='fandraisana.php'>Hiresaka</a></li>
	<li><a href="#">Fanazarantena</a></li>
	<li><a href="#">Lohateny</a></li>
	<li><a href="#">Fizestiavana</a></li>

	<li><a href="#">Namana</a></li>
	<li><a href="#">hametraka</a></li>
	<li><a href="Lyrics.php">Lyrics</a></li>
	<br>
	<hr class="separator">
	<li>
		<form id="frm" onsubmit="alert(document.getElementById('login').value);alert('Miala tsiny fa tsy ao amin\'ny tambanjotra ianao!');">
			<p></p>
			<strong>Login</strong>
			<input type="label" id="login" size="18"/>
			<strong>Password</strong>
			<input type="password" id="pwd" size="18"/>
			<p></p>
			<input type="submit" value="OK" class="bt" style="width:130px"/>
			<p></p>
		</form>
	</li>
	<br>
	<hr class="separator">
	<?php
		echo date('l')." ".date('d')." ".date('F');
	?>
</center>