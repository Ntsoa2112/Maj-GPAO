<?php
include AB_DB_SSITE."/includes/SOAP/soap_param.php";
try{
	$ap_param_forbatch_op = array( 
			'sessionId'     =>   $_SESSION['sessId'],
			'batchId'     =>    $_SESSION['batchID']
		); 
	$info_batch_op = $soapClient->CloseBatch ($ap_param_forbatch_op); 
	$info_process_op = $soapClient->ProcessBatch ($ap_param_forbatch_op); 
	$_SESSION['isProcess'] = true;
	
	header('Location: process.php');
}catch (SoapFault $fault) { 
	$error = 1; 
	print_r($fault);
	echo("Sorry, blah returned the following ERROR: ".$fault->faultcode."-".$fault->faultstring."--We will now take you back to our home page.'"); 
} 