<?php
//inizia la sessione se non è già iniziata
if (!isset($_SESSION)) {
    session_start();
}
  
//se la sessione non è presente, allora effettua il login
if(!isset($_SESSION['is_logged_in'])) {
    header('Location: '.ROOT_URL.TEMPLATE_PATH.'login.php');
}

if(isset($_SESSION['user_data']) && $_SESSION['user_data']['ruolo']!=1) {
    header('Location: '.ROOT_URL.'/index.php');
}

?>

<html lang="it">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="msapplication-tap-highlight" content="no">

  <title>Dashboard amministratore | AEONIAN SYSTEM</title>

  <!-- Favicons-->
  <link rel="icon" href="<?php echo ROOT_URL,IMAGES_PATH; ?>aeonian-logo.png" sizes="32x32">
  <!-- Favicons-->
  <link rel="apple-touch-icon-precomposed" href="<?php echo ROOT_URL,IMAGES_PATH; ?>aeonian-logo.png" sizes="152x152">
  <!-- For iPhone -->
  <meta name="msapplication-TileColor" content="#00bcd4">
  <meta name="msapplication-TileImage" content="<?php echo ROOT_URL,IMAGES_PATH; ?>aeonian-logo.png" sizes="144x144">
  <!-- For Windows Phone -->


  <!-- CORE CSS-->
  <link href="<?php echo ROOT_URL,STYLE_PATH; ?>materialize.css" type="text/css" rel="stylesheet" media="screen,projection">
  <link href="<?php echo ROOT_URL,STYLE_PATH; ?>style.css" type="text/css" rel="stylesheet" media="screen,projection">
  <link href="<?php echo ROOT_URL,STYLE_PATH; ?>custom/custom.min.css" type="text/css" rel="stylesheet" media="screen,projection">
  <link href="<?php echo ROOT_URL,STYLE_PATH; ?>custom/custom.css" type="text/css" rel="stylesheet" media="screen,projection">

  <!-- INCLUDED PLUGIN CSS ON THIS PAGE -->
  <link href="<?php echo ROOT_URL,SCRIPT_PATH; ?>plugins/prism/prism.css" type="text/css" rel="stylesheet" media="screen,projection">  
  <link href="<?php echo ROOT_URL,SCRIPT_PATH; ?>plugins/perfect-scrollbar/perfect-scrollbar.css" type="text/css" rel="stylesheet" media="screen,projection">
  <link href="<?php echo ROOT_URL,SCRIPT_PATH; ?>plugins/data-tables/css/jquery.dataTables.min.css" type="text/css" rel="stylesheet" media="screen,projection">


    

</head>

<body>


  <!-- //////////////////////////////////////////////////////////////////////////// -->

  
  <header id="header" class="page-topbar">
        <!-- start header nav-->
        <div class="navbar-fixed">
            <nav class="space-cadet">
                <div class="nav-wrapper">
                    <h1 class="logo-wrapper"><a href="<?php echo ROOT_URL?>/index.php" class="brand-logo darken-1"><img src="<?php echo ROOT_URL,IMAGES_PATH; ?>aeonian-title.png" alt="aeonian logo"></a> <span class="logo-text">Aeonian</span></h1>
                    <ul class="right hide-on-med-and-down">
                        <li><a class="waves-effect waves-block waves-light toggle-fullscreen"><i class="mdi-action-settings-overscan"></i></a>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
        <!-- end header nav-->
  </header>
