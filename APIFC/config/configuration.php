<?php
session_start();
define ("AB_LOCAL_PROD" , "Local");
define ("AB_SOAP_FC_LOCATION" , "http://flexicap.inovcom.fr/FlexiCapture12/Server/API/v1/Soap");
define ("AB_SOAP_FC_LOGIN" , "flexicap");
define ("AB_SOAP_FC_PWD" , "2U:4|eVc:HIQ");
define ("AB_SOAP_FC_WSDL" , "http://".AB_SOAP_FC_LOGIN.":".AB_SOAP_FC_PWD."@flexicap.inovcom.fr/FlexiCapture12/Server/API/v1/WSDL");
define ("AB_SOAP_FC_ROLETYPE" , 1);
define ("AB_SOAP_FC_STATIONTYPE" , 1);
if(AB_LOCAL_PROD!='prod')
{
	define ("AB_DB_SSITE" , $_SERVER['DOCUMENT_ROOT']."/APIFC");
	define ("AB_DB_HOST" , "localhost");
	define ("AB_DB_USER" , "root");
	define ("AB_DB_PWD" , "");
	define ("AB_DB_DATABASE" , "flexicapture");
}else{
	
}