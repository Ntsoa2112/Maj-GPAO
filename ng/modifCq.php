<?php

	include_once('../php/common.php');	
	$c = new Cnx();
	
	$id = $_REQUEST['id'] ;

	if ($_REQUEST['id_cq'] != '')
	{
		$rs=$c->cnx->exec("update almerys_user set id_cq=".$_REQUEST['id_cq']."  where id=$id");
	}
	elseif ($_REQUEST['id_pole'] != '') $rs=$c->cnx->exec("update almerys_user set id_pole=".$_REQUEST['id_pole']."  where id=$id");

	//echo "update almerys_user set id_cq=".$id_cq."  where id=$id";
?>