<?php
require_once '../../config.php'; 
require '../../classes/OutputsManager.php';

$api = 'cc5d37435e84b7b46a7963f53393eb40';

$get = filter_input_array(INPUT_GET, FILTER_SANITIZE_URL); 

$rilevazione = $get['rilevazione'];
$key = $get['key'];

if( $rilevazione !== null && $key == $api )
{
	$outputs = new OutputsManager();
	$outputs->elaboraStringa( $rilevazione );
	echo 'Acquisizione effettuata';
	return true;
} else {
	echo 'Chiave non valida';
	return false;
}

