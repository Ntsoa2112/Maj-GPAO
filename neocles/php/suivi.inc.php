<?php

function GetAllTicket(){
	$helpdesk = GetTicketMaha();
	$supervision = GetTicketMahaSup();

	return array array_merge ($helpdesk, $supervision);
}
/*
function GetMatricul(){
	
}
*/
?>

