<?php
$options = array(
	  'cache_wsdl' => 0,
	   'trace' => 1,
	   'location' => AB_SOAP_FC_LOCATION, //5984
	   'login' => AB_SOAP_FC_LOGIN,
		'password' => AB_SOAP_FC_PWD,
		'exceptions' => 1
	);
$soapClient = new SoapClient(AB_SOAP_FC_WSDL,$options); 
$sh_param = array( 
						'Username'    =>    AB_SOAP_FC_LOGIN, 
						'Password'    =>    AB_SOAP_FC_PWD); 
$headers = new SoapHeader(AB_SOAP_FC_LOCATION, 'UserCredentials', $sh_param); 	

$soapClient->__setSoapHeaders(array($headers)); 

$ap_param_roleType = array( 
		'roleType'     =>   AB_SOAP_FC_ROLETYPE,
		'stationType'     =>    AB_SOAP_FC_STATIONTYPE
		); 
		
		
function openSession(){
	
	
	
}