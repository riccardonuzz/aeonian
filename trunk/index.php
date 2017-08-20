<?php

require("config.php");

//Inizio sessione
session_start();

if(isset($_SESSION['is_logged_in'])) {
    if(isset($_SESSION['user_data']['ruolo'])==1) {
        header('Location: ./template/admin-contents/adminhome.php');
   } else if (isset($_SESSION['user_data']['ruolo'])==2) {
        header('Location: ./template/userhome.php');
   } else if (isset($_SESSION['user_data']['ruolo'])==3) {
        header('Location: ./template/installerhome.php');
   }  
}

else {
    header('Location: ./template/login.php');
}
