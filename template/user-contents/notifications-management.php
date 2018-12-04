<?php
require_once '../../config.php'; 
require_once '../../classes/NotifyManager.php';


 //Inizio sessione
 session_start();

if(!isset($_SESSION['is_logged_in'])) {
    header('Location: '.ROOT_URL.TEMPLATE_PATH.'login.php');
}

if(isset($_SESSION['user_data']) && $_SESSION['user_data']['ruolo']!=2) {
    header('Location: '.ROOT_URL.'/index.php');
}


// if($_GET['utente'] != $_SESSION['user_data']['codicefiscale']) {
//     header('Location: '.ROOT_URL."/403.php");
// }


$notifyManager = new NotifyManager();
$notifiche = $notifyManager -> getNotifiche($_SESSION['user_data']['codicefiscale']);

if(empty($notifiche)===true) {
	$_SESSION['message'] = 'Attualmente non ci sono notifiche.';
}



?>
  
    <!-- START HEADER -->
        <?php require "./includes/header.php"; ?>
    <!-- END HEADER -->

  <!-- //////////////////////////////////////////////////////////////////////////// -->

  <!-- START MAIN -->
  <div id="main">
    <!-- START WRAPPER -->
    <div class="wrapper">

    <!-- START LEFT SIDEBAR NAV-->
        <?php require "./includes/sidebar.php"; ?>
    <!-- END LEFT SIDEBAR NAV-->


      <!-- //////////////////////////////////////////////////////////////////////////// -->

      <!-- START CONTENT -->
      <section id="content">
            <!--breadcrumbs start-->
            <div id="breadcrumbs-wrapper" class=" grey lighten-3">
            <div class="container">
                <div class="row">
                <div class="col s12 m12 l12">
                    <h5 class="breadcrumbs-title">Notifiche</h5>
                    <ol class="breadcrumbs">
                        <li><a href="#">Dashboard</a></li>
                        <li><a href="#">Notifiche</a></li>
                    </ol>
                </div>
                </div>
            </div>
            </div>
            <!--breadcrumbs end-->


            <!--start container-->
            <div class="container">
            <div class="section">

			<?php if (isset($_SESSION['message'])===false): ?>
            <div id="email-list" class="col s10 m4 l4 card-panel z-depth-1">
                <ul class="collection">
				 
                    <?php foreach ($notifiche as $notifica): ?>
                        <?php if ($notifica['Letta']==true): ?>
                            <li class="collection-item avatar">
                        <?php else: ?>
                            <li class="collection-item avatar selected">
                        <?php endif; ?>
                        <img src="<?php echo ROOT_URL.IMAGES_PATH; ?>error.png" alt="" class="circle">
                        <span class="title">Errore sensore <a href="sensor-details.php?id=<?php echo $notifica['Sensore'];?>"><?php echo $notifica['Sensore'];?></a></span>
                        <p>Eccezione rilevata</p>
                        <a href="notification-details.php?id=<?php echo $notifica['IDNotifica'] ?>" class="secondary-content"><span class="unread"><i style="margin-left: -50px; font-size: 35px; margin-top: 20px;" class="mdi-navigation-arrow-forward"></i></span></a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
			<?php else: ?>
					<?php 
									  $escaped = htmlspecialchars($_SESSION['message'], ENT_QUOTES);
									  $str = <<<HTML
<p class='red-text text-darken-2'>$escaped</p>
HTML;
									  echo $str;
						  unset($_SESSION['message']);
				    ?>
				<?php endif; ?>

            </div>
            </div>
            <!--end container-->
      </section>
        <!-- END CONTENT -->

    </div>
    <!-- END WRAPPER -->

  </div>
  <!-- END MAIN -->



  <!-- //////////////////////////////////////////////////////////////////////////// -->

  <!-- START FOOTER -->
  <?php require "./includes/footer.php"; ?>