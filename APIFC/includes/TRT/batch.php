<?php
include AB_DB_SSITE."/includes/SOAP/soap_param.php";
$idBatch = 10;
switch($_GET['action']){
	case "getbatch":
		try{
				
				
				$ap_param_forbatch_op = array( 
						'sessionId'     =>    $_SESSION['sessId'],
						'onlyPrivateBatches' => false,
						'projectId' => $_SESSION['projectID']
				);  
				
				$info_batch_op = $soapClient->GetBatches ($ap_param_forbatch_op); 
				$_SESSION['batch_list']= $info_batch_op;
				header('Location: process.php');
				
		}catch(SoapFault $fault) { 
				$error = 1; 
				echo("Sorry, blah returned the following ERROR: ".$fault->faultcode."-".$fault->faultstring."--We will now take you back to our home page.'"); exit;
		} 
	break;
	
	case "openbatch":
		$idBatch = $_GET['id'];
		try{
				
				
				$ap_param_forbatch_op = array( 
						'sessionId'     =>    $_SESSION['sessId'],
						'batchId'     =>    $idBatch,
					);  
				$ap_param_forbatch_op_clo = array( 
						'sessionId'     =>    $_SESSION['sessId'],
						'batchId'     =>    $_SESSION['batchID'],
					);  
				if(isset($_SESSION['batchID']))
				{
					$info_batch_op = $soapClient->CloseBatch ($ap_param_forbatch_op_clo); 
				}
				$info_batch_op = $soapClient->OpenBatch ($ap_param_forbatch_op); 
				$_SESSION['batchID']= $idBatch;
				$_SESSION['batchIDOp']= true;
				header('Location: process.php');
				
		}catch(SoapFault $fault) { 
				$error = 1; 
				echo("Sorry, blah returned the following ERROR: ".$fault->faultcode."-".$fault->faultstring."--We will now take you back to our home page.'"); exit;
		} 
	break;
	case "closebatch":
		try{
				$ap_param_forbatch_op = array( 
						'sessionId'     =>    $_SESSION['sessId'],
						'batchId'     =>    $_SESSION['batchID'],
					); 
				$info_batch_op = $soapClient->CloseBatch ($ap_param_forbatch_op); 
				$_SESSION['batchIDOp']= false;
				unset($_SESSION['batchID']);
				header('Location: process.php');
				
		}catch(SoapFault $fault) { 
				$error = 1; 
				echo("Sorry, blah returned the following ERROR: ".$fault->faultcode."-".$fault->faultstring."--We will now take you back to our home page.'"); exit;
		} 
	break;
}