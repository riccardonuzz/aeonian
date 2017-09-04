<?php
require_once("../../config.php"); 
require("../../classes/OutputsManager.php");

if( isset( $_GET['rilevazione'] ) )
{
	$outputs = new OutputsManager();
	$outputs->elaboraStringa( $_GET['rilevazione'] );
}

?>