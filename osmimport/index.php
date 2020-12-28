

<?php
include "config/configuration.php";
include "includes/DB/cnx.php";
//include "includes/SOAP/soap_param.php";
//unset($_SESSION);session_destroy();exit;

//recuperer les anciens coordonnée
$result = pg_query($db_connection, "SELECT * FROM osm_coordonnee");
$htm_table_res = "";
$array_idpers = array();
while ($row = pg_fetch_row($result)) {
	$htm_table_res .= "<tr>";
	$array_idpers[] = $row[1];
	$htm_table_res .= "<td>".$row[1]."</td>";
	$htm_table_res .= "<td>".$row[2]."</td>";
	$htm_table_res .= "<td>".$row[3]."</td>";
	$htm_table_res .= "</tr>";
}

if(isset($_GET['action'])){
	switch($_GET['action']){
		case "import":
			include "includes/TRT/import.php";
		break;
	}
}

?>


<style>
	table,th,td {
		border : 1px solid;
	}
	.isConnected {
		background-color : green;
	}
	.isDisConnected {
		background-color : red;
	}.isWarnig {
		background-color : yellow;
	}
</style>

<html>
	<head>
	</head>
	<body>
		<h1>MES COORDONNEES  </h1>
		
		<table style="">
			<thead>
				<tr>
					<th>Matricule</th>
					<th>Lat</th>
					<th>Lng</th>
				</tr>
			</thead>
			<tbody>
				
				<?php
					echo $htm_table_res;
				?>
				
				
				
			</tbody>
		</table>
		<h1>IMPORT  </h1>
		
		<table style="">
			<thead>
				<tr>
					<th>Process</th>
					<th>params</th>
					<th>action</th>
				</tr>
			</thead>
			<tbody>
				
				
				<tr>
					<form action="index.php?action=import" method="POST" enctype="multipart/form-data">
					<td>Ajouter un document kml</td>
					<td><input type="file" name="file"/></td>
					<td><input name="btn" type="submit" value="telecharger le fichier"/><input name="btn" type="submit" value="telecharger le fichier(ecraser les existant)"/></td>
					</form>
				</tr>
				
				
			</tbody>
		</table>
		
		
		
	</body>
</html>
<script>
	
</script>
