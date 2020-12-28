<?php
include AB_DB_SSITE."/includes/SOAP/soap_param.php";

try{
	if(!isset($_SESSION['projects']))
	{
		$info_project = $soapClient->GetProjects(); 
		$_SESSION['projects'] = $info_project ;
	}
	//header('Location: process.php');
		
}catch(SoapFault $fault) { 
		$error = 1; 
		echo("Sorry, blah returned the following ERROR: ".$fault->faultcode."-".$fault->faultstring."--We will now take you back to our home page.'"); exit;
} 

if(isset($_GET['action'])){
	switch($_GET['action']){
		case "loadproject":
			try{
				$guid = '48968721-755E-4125-8564-B8F267AE14C5';
				if(isset($_GET['Guid'])){
					$guid = $_GET['Guid'];
				}
					
					$ap_param_forproject = array( 
						'sessionId'     =>    $_SESSION['sessId'],
						'projectNameOrGuid'     =>    $guid
						); 
					$info_project = $soapClient->OpenProject($ap_param_forproject); 
					//print_r($info_project);exit;
					$_SESSION['projectObject']= $info_project;
					$_SESSION['projectID']= $info_project->projectId;
					header('Location: process.php');
					
			}catch(SoapFault $fault) { 
					$error = 1; 
					echo("Sorry, blah returned the following ERROR: ".$fault->faultcode."-".$fault->faultstring."--We will now take you back to our home page.'"); exit;
			} 
		break;
		case "closeproject":
			try{
					$ap_param_forproject = array( 
						'sessionId'     =>    $_SESSION['sessId'],
						'projectId '     =>    $_SESSION['projectID'],
						); 
					$info_project = $soapClient->CloseProject($ap_param_forproject); 
					unset($_SESSION['projectID']);
					header('Location: process.php');
					
			}catch(SoapFault $fault) { 
					$error = 1; 
					echo("Sorry, blah returned the following ERROR: ".$fault->faultcode."-".$fault->faultstring."--We will now take you back to our home page.'"); exit;
			} 
		break;

		default:
			
		break;
	}
}
