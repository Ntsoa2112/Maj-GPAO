<?php
include AB_DB_SSITE."/includes/SOAP/soap_param.php";
switch($_GET['action']){
	case "loadsession":
		try{
				$info = $soapClient->OpenSession($ap_param_roleType); 
				
				$_SESSION['sessId'] = $info->sessionId;
				header('Location: process.php');
				
		}catch(SoapFault $fault) { 
				$error = 1; 
				echo("Sorry, blah returned the following ERROR: ".$fault->faultcode."-".$fault->faultstring."--We will now take you back to our home page.'"); exit;
		} 
	break;
	case "closesession":
		try{
				$ap_param_sess_close = array("sessionId" => $_SESSION['sessId'] );
				$info = $soapClient->CloseSession($ap_param_sess_close); 
				unset($_SESSION['sessId']);
				header('Location: process.php');
				
		}catch(SoapFault $fault) { 
				$error = 1; 
				echo("Sorry, blah returned the following ERROR: ".$fault->faultcode."-".$fault->faultstring."--We will now take you back to our home page.'"); exit;
		} 
	break;
}
