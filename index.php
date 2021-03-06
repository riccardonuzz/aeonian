<?php

require_once 'config.php';

/* Disables cache */

header('Content-Type: text/html; charset=UTF-8');
header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
header('Cache-Control: no-cache, no-store, must-revalidate'); // HTTP 1.1.
header('Pragma: no-cache'); // HTTP 1.0.
header('Cache-Control: post-check=0, pre-check=0', false);
header('Expires: 0'); // Proxies.

//Inizio sessione
session_start();

//Controllo che la sessione esista, se è presente allora in base al ruolo effettuo un redirect
if( isset($_SESSION['is_logged_in']) === true ) {
    if( isset($_SESSION['user_data']) ===true && (int)$_SESSION['user_data']['ruolo'] === 1 ) {
        header('Location: ./template/admin-contents/adminhome.php');
   } else if ( isset($_SESSION['user_data'] ) === true && (int)$_SESSION['user_data']['ruolo'] === 2) {
        header('Location: ./template/user-contents/userhome.php');
   } else {
        header('Location: ./template/installer-contents/installerhome.php');
   }  
}

//Altrimenti se non sono presenti sessioni reindirizzo al login
else {
    header('Location: ./template/login.php');
}
