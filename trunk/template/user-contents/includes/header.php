<!DOCTYPE html>
<?php
//inizia la sessione se non è già iniziata
if (!isset($_SESSION)) {
    session_start();
  }
  
  //se la sessione non è presente, allora effettua il login
  if(!isset($_SESSION['is_logged_in'])) {
    header('Location: '.ROOT_URL.TEMPLATE_PATH.'login.php');
  }
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

 <!-- INCLUDED PLUGIN CSS ON THIS PAGE -->
 <link href="<?php echo ROOT_URL.SCRIPT_PATH; ?>plugins/prism/prism.css" type="text/css" rel="stylesheet" media="screen,projection">  
 <link href="<?php echo ROOT_URL.SCRIPT_PATH; ?>plugins/perfect-scrollbar/perfect-scrollbar.css" type="text/css" rel="stylesheet" media="screen,projection">
 <link href="<?php echo ROOT_URL.SCRIPT_PATH; ?>plugins/data-tables/css/jquery.dataTables.min.css" type="text/css" rel="stylesheet" media="screen,projection">


    

</head>

<body>


  <!-- //////////////////////////////////////////////////////////////////////////// -->

  
  <header id="header" class="page-topbar">
        <!-- start header nav-->
        <div class="navbar-fixed">
            <nav class="cyan">
                <div class="nav-wrapper">
                    <h1 class="logo-wrapper"><a href="<?php echo ROOT_URL?>/index.php" class="brand-logo darken-1"><img src="<?php echo ROOT_URL.IMAGES_PATH; ?>aeonian-title.png" alt="materialize logo"></a> <span class="logo-text">Materialize</span></h1>
                    <ul class="right hide-on-med-and-down">
                        <li><a href="javascript:void(0);" class="waves-effect waves-block waves-light notification-button" data-activates="notifications-dropdown"><i class="mdi-social-notifications"><small class="notification-badge">5</small></i>
                        </a>
                        </li> 
                        <li><a class="waves-effect waves-block waves-light toggle-fullscreen"><i class="mdi-action-settings-overscan"></i></a>
                        </li>  
                    </ul>
                    <!-- notifications-dropdown -->
                    <ul id="notifications-dropdown" class="dropdown-content">
                      <li>
                        <h5>NOTIFICATIONS <span class="new badge">5</span></h5>
                      </li>
                      <li class="divider"></li>
                      <li>
                        <a href="#!"><i class="mdi-action-add-shopping-cart"></i> A new order has been placed!</a>
                        <time class="media-meta" datetime="2015-06-12T20:50:48+08:00">2 hours ago</time>
                      </li>
                      <li>
                        <a href="#!"><i class="mdi-action-stars"></i> Completed the task</a>
                        <time class="media-meta" datetime="2015-06-12T20:50:48+08:00">3 days ago</time>
                      </li>
                      <li>
                        <a href="#!"><i class="mdi-action-settings"></i> Settings updated</a>
                        <time class="media-meta" datetime="2015-06-12T20:50:48+08:00">4 days ago</time>
                      </li>
                      <li>
                        <a href="#!"><i class="mdi-editor-insert-invitation"></i> Director meeting started</a>
                        <time class="media-meta" datetime="2015-06-12T20:50:48+08:00">6 days ago</time>
                      </li>
                      <li>
                        <a href="#!"><i class="mdi-action-trending-up"></i> Generate monthly report</a>
                        <time class="media-meta" datetime="2015-06-12T20:50:48+08:00">1 week ago</time>
                      </li>
                    </ul>
                </div>
            </nav>
        </div>
        <!-- end header nav-->
  </header>
