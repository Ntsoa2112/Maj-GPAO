<?php
	include_once('header.inc.php');
	
// AUT Mirah RATAHIRY
// DES page Lot de tous les dossiers
// DAT 2012 03 06
?>

<html xmlns="http//www.w3.org/1999/xhtml" xmllang="en" lang="en"   ng-app="DossierApp">
<head>
  <title>Easytech.mg</title>

</head>
<body>

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


<div data-ng-controller="lstDossier"  id="content">   
<div id="tb_dossier">   
<br />
<br />
<table>
<tr class="tb_header">
			<td>ID</td>
			<td>num_dossier</td>
			<td>Atelier</td>
			<td>Correspondance</td>
			<td>Demarrage</td>
			<td>Delai</td>
			<td>Date_livr</td>
			<td>vitesse_estime</td>
			<td>vitesse_reelle</td>
			<td>volume_prevue</td>
			<td>resource_op</td>
			<td>resource_cp</td>
			<td>id_pers_cp</td>
			<td>id_equipe</td>
			<td>client</td>
			<td>etat</td>
			
    </tr>
	
<tr data-ng-repeat="Dossier in Dossiers" class="{{Dossier.class}}">
			<td>{{Dossier.id_dossier}}</td>
			<td>
				<span ng-click="editing1 = true" ng-hide="editing1">{{Dossier.num_dossier}}</span>
				<input ng-model="Dossier.num_dossier" ng-show="editing1" />
				<button ng-click="editing1 = false" ng-show="editing1"></button>
			</td>
			<td ng-click="editing = true">
				<span ng-hide="editing">{{Dossier.atelier}} </span>
				<input ng-model="Dossier.atelier" ng-show="editing" />
				<button ng-click="editing = false" ng-show="editing"></button>
			</td>
			<td>{{Dossier.corresp}}</td>
			<td>{{Dossier.demarrage}}</td>
			<td>{{Dossier.delai}}</td>
			<td>{{Dossier.date_livr}}</td>
			<td>{{Dossier.vitesse_estime}}</td>
			<td>{{Dossier.vitesse_reelle}}</td>
			<td>{{Dossier.volume_prevue}}</td>
			<td>{{Dossier.resource_op}}</td>
			<td>{{Dossier.resource_cp}}</td>
			<td>{{Dossier.id_pers_cp}}</td>
			<td>{{Dossier.id_equipe}}</td>
			<td>{{Dossier.client}}</td>
			<td>{{Dossier.etat}}</td>
			
    </tr>
</table>   

 <td>
            <button type="submit" data-ng-hide="editMode" data-ng-click="editMode = true; editAppKey(entry)" class="btn btn-default">Edit</button>
            <button type="submit" data-ng-show="editMode" data-ng-click="editMode = false" class="btn btn-default">Save</button>
            <button type="submit" data-ng-show="editMode" data-ng-click="editMode = false; cancel()" class="btn btn-default">Cancel</button>
        </td>
		
 </div> </div>

</body>

<script type="text/javascript">

var app = angular.module('DossierApp', []);

app.controller('lstDossier', function($scope, $http) {
	getDossier(); // Load all available tasks 

	function getDossier(){  
	$http.post("getDossier.php").success(function(data){
		$scope.Dossiers = data;
	   });
	};	
  });
</script>

</html>

