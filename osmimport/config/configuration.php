<?php
session_start();
//define ("AB_LOCAL_PROD" , "Local");
define ("AB_LOCAL_PROD" , "prod");
if(AB_LOCAL_PROD!='prod')
{
	define ("AB_DB_SSITE" , $_SERVER['DOCUMENT_ROOT']);
	define ("AB_DB_HOST" , "localhost");
	define ("AB_DB_USER" , "postgres");
	define ("AB_DB_PWD" , "postgres");
	define ("AB_DB_DATABASE" , "easy");
}else{
	define ("AB_DB_SSITE" , $_SERVER['DOCUMENT_ROOT']."/osmimport");
	define ("AB_DB_HOST" , "db1.easytech.mg");
	define ("AB_DB_USER" , "postgres");
	define ("AB_DB_PWD" , "postgres");
	define ("AB_DB_DATABASE" , "easy");
}