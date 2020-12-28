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
<br>

<input type="text" ng-model="filterTask" class="form-control search header-elements-margin" placeholder="Sivana">

 
<table>
<head>
			<th>ID</th>
			<th>SAT</th>
			<th>CQ</th>
			<th>POLE</th>
    </head>
	
<div></div>
	
<tr data-ng-repeat="Dossier in Dossiers | filter:filterTask" class="{{Dossier.class}}">
<td>{{Dossier.sat}}</td>
			<td>{{Dossier.matricule}}</td>
			
			<td><span data-ng-click="editID(Dossier)">{{Dossier.id_cq}}	</span>		
			<select  data-ng-options="user.id_cq for user in Dossiers | unique:'id_cq' "   ng-model="new_id" data-ng-change="hideID(new_id, Dossier.id)" ng-show="Dossier.showCq"></select></td>
			<td><span data-ng-click="editPole(Dossier)">{{Dossier.pole}}</span><select data-ng-options="poles.pole for poles in Dossiers | unique:'pole' "   ng-model="new_idpole" data-ng-change="hidePole(new_idpole, Dossier.id)" ng-show="Dossier.showPole"></select></td>
</tr>
</table>   


		
 </div> </div>

</body>

<script type="text/javascript">

var app = angular.module('DossierApp', []);

app.controller('lstDossier', function($scope, $http) {
	$scope.editorEnabled = false;
	getDossier(); // Load all available tasks 

	function getDossier(){  
	$http.post("getUser.php").success(function(data){
		$scope.Dossiers = data;	
		//elt.html('<p>');
	   });
	};
	
	$scope.editID = function(id) {
		id.showCq = true;
	};
	
	$scope.hideID = function(new_id, id) {
		new_id.showCq = false;
		$http.post("ng/modifCq.php?id="+id+"&id_cq="+new_id.id_cq+"&id_pole=").success(function(data){
		
			getDossier(); 
		});
	};
	
	$scope.editPole = function(id) {
		id.showPole = true;
	};
	
	$scope.hidePole = function(new_idpole, id) {
		new_idpole.showPole = false;
		//alert(new_idpole.id_pole);
		$http.post("ng/modifCq.php?id="+id+"&id_cq=&id_pole="+new_idpole.id_pole).success(function(data){
		//alert(data);
			getDossier(); 
		  });
	};
  
	$scope.modifControler = function (id, id_cq) {
	//alert(angular.element('#appBusyIndicator').val());
    $http.post("ng/modifCq.php?id="+id+"&id_cq="+id_cq).success(function(data){
        //alert(task);
		alert(angular.element('newcq').scope());
		getDossier(); 
      });
  };
  });
  
  app.filter('unique', function() {
    return function(input, key) {
        var unique = {};
        var uniqueList = [];
        for(var i = 0; i < input.length; i++){
            if(typeof unique[input[i][key]] == "undefined"){
                unique[input[i][key]] = "";
                uniqueList.push(input[i]);
            }
        }
        return uniqueList;
    };
});
  

</script>

</html>

