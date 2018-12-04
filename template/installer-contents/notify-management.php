<?php
require_once "../../config.php"; 
require "../../classes/NotifyManager.php";

session_start();

if(!isset($_SESSION['is_logged_in'])) {
  header('Location: '.ROOT_URL.'/template/login.php');
}

if(isset($_SESSION['user_data']) && $_SESSION['user_data']['ruolo']!=3) {
    header('Location: '.ROOT_URL.'/index.php');
}

//Gestore Notifiche
$notifyManager = new NotifyManager();


if(isset($_POST['action'])) {
    $action = $_POST['action'];
    $var = $_POST['id'];
    switch($action) {
      case 'delete':
        $notifyManager->eliminaRegola($var);
        break;
	  
	   default:
		echo "Errore.";
    }
}