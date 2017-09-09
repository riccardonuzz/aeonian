<!DOCTYPE html>
<?php
require_once("../../classes/NotifyManager.php");

//inizia la sessione se non è già iniziata
if (!isset($_SESSION)) {
    session_start();
}

//se la sessione non è presente, allora effettua il login
if(!isset($_SESSION['is_logged_in'])) {
  header('Location: '.ROOT_URL.TEMPLATE_PATH.'login.php');
}

$notifyManager = new NotifyManager();

$numeroNotifiche = $notifyManager->getNumeroNotifiche($_SESSION['user_data']['codicefiscale']);
$ultimeNotifiche = $notifyManager->getUltimeNotifiche($_SESSION['user_data']['codicefiscale']);

?>

<html lang="it">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="msapplication-tap-highlight" content="no">

  <title>Dashboard cliente | AEONIAN SYSTEM</title>

  <!-- Favicons-->
  <link rel="icon" href="images/favicon/favicon-32x32.png" sizes="32x32">
  <!-- Favicons-->
  <link rel="apple-touch-icon-precomposed" href="images/favicon/apple-touch-icon-152x152.png">
  <!-- For iPhone -->
  <meta name="msapplication-TileColor" content="#00bcd4">
  <meta name="msapplication-TileImage" content="images/favicon/mstile-144x144.png">
  <!-- For Windows Phone -->


 <!-- CORE CSS-->
 <link href="<?php echo ROOT_URL.STYLE_PATH; ?>materialize.css" type="text/css" rel="stylesheet" media="screen,projection">
 <link href="<?php echo ROOT_URL.STYLE_PATH; ?>style.css" type="text/css" rel="stylesheet" media="screen,projection">
 <link href="<?php echo ROOT_URL.STYLE_PATH; ?>custom/custom.min.css" type="text/css" rel="stylesheet" media="screen,projection">
 <link href="<?php echo ROOT_URL.STYLE_PATH; ?>custom/custom.css" type="text/css" rel="stylesheet" media="screen,projection">


 <!-- INCLUDED PLUGIN CSS ON THIS PAGE -->
 <link href="<?php echo ROOT_URL.SCRIPT_PATH; ?>plugins/prism/prism.css" type="text/css" rel="stylesheet" media="screen,projection">  
 <link href="<?php echo ROOT_URL.SCRIPT_PATH; ?>plugins/perfect-scrollbar/perfect-scrollbar.css" type="text/css" rel="stylesheet" media="screen,projection">
 <link href="<?php echo ROOT_URL.SCRIPT_PATH; ?>plugins/data-tables/css/jquery.dataTables.min.css" type="text/css" rel="stylesheet" media="screen,projection">
 <link href="<?php echo ROOT_URL.SCRIPT_PATH; ?>plugins/sweetalert/sweetalert.css" type="text/css" rel="stylesheet" media="screen,projection">


    

</head>

<body>


  <!-- //////////////////////////////////////////////////////////////////////////// -->

  
  <header id="header" class="page-topbar">
        <!-- start header nav-->
        <div class="navbar-fixed">
            <nav class="space-cadet">
                <div class="nav-wrapper">
                    <h1 class="logo-wrapper"><a href="<?php echo ROOT_URL?>/index.php" class="brand-logo darken-1"><img src="<?php echo ROOT_URL.IMAGES_PATH; ?>aeonian-title.png" alt="materialize logo"></a> <span class="logo-text">Materialize</span></h1>
                    <ul class="right hide-on-med-and-down">
                        <li><a href="javascript:void(0);" class="waves-effect waves-block waves-light notification-button" data-activates="notifications-dropdown"><i class="mdi-social-notifications"><small class="notification-badge orange-style"><?php echo $numeroNotifiche['Totale']; ?></small></i>
                        </a>
                        </li> 
                        <li><a class="waves-effect waves-block waves-light toggle-fullscreen"><i class="mdi-action-settings-overscan"></i></a>
                        </li>  
                    </ul>
                    <!-- notifications-dropdown -->
                    <ul id="notifications-dropdown" class="dropdown-content">
                      <li>
                        <h5>NOTIFICHE</h5>
                      </li>
                      <li class="divider"></li>
                      <?php foreach($ultimeNotifiche as $notifica): ?>
                        <?php if($notifica['Letta']): ?>
                          <li>
                            <a href="notification-details.php?id=<?php echo $notifica['IDNotifica']; ?>"><i class="mdi-alert-error"></i> <?php echo "Errore sensore ".$notifica['Sensore']; ?></a>
                            <!--<time class="media-meta" datetime="2015-06-12T20:50:48+08:00">6 days ago</time>-->
                          </li>
                        <?php else: ?>
                        <li>
                            <a href="notification-details.php?id=<?php echo $notifica['IDNotifica']; ?>"><i class="mdi-alert-error"></i> <?php echo "Errore sensore ".$notifica['Sensore']; ?><span class="new badge"></span></a>
                            <!--<time class="media-meta" datetime="2015-06-12T20:50:48+08:00">6 days ago</time>-->
                          </li>
                        <?php endif;?>
                      <?php endforeach; ?>
                      <li class="divider"></li>
                      <li>
                        <a href="<?php echo ROOT_URL.TEMPLATE_PATH."user-contents/notifications-management.php?utente=".$_SESSION['user_data']['codicefiscale']; ?>"><i class="mdi-action-announcement"></i> Visualizza tutte le notifiche</a>
                      </li>
                    </ul>
                </div>
            </nav>
        </div>
        <!-- end header nav-->
  </header>
