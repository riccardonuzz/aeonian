<?php
require_once("../../config.php"); 
require("../../classes/SharesManager.php");

session_start();

if(!isset($_SESSION['is_logged_in'])) {
  header('Location: '.ROOT_URL.'/template/login.php');
}

if(isset($_SESSION['user_data']) && $_SESSION['user_data']['ruolo']!=2) {
    header('Location: '.ROOT_URL.'/index.php');
}

//Gestore Utenti
$sharesManager = new SharesManager();

if(!$sharesManager->checkShareProperty($_GET['id'], $_SESSION['user_data']['codicefiscale'])) {
    header('Location: '.ROOT_URL.'/403.php');
  }

$condivisione = $sharesManager->trovaCondivisione($_GET['id']);
?>

 <!-- START HEADER -->
 <?php require("./includes/header.php"); ?>
 
<!-- END HEADER -->

  <!-- //////////////////////////////////////////////////////////////////////////// -->

<!-- START MAIN -->
<div id="main">
<!-- START WRAPPER -->
<div class="wrapper">

<!-- START LEFT SIDEBAR NAV-->
    <?php require("./includes/sidebar.php"); ?>
<!-- END LEFT SIDEBAR NAV-->


    <!-- //////////////////////////////////////////////////////////////////////////// -->

    <!-- START CONTENT -->
    <section id="content">
        <!--breadcrumbs start-->
        <div id="breadcrumbs-wrapper" class=" grey lighten-3">
            <div class="container">
            <div class="row">
                <div class="col s12 m12 l12">
                    <h5 class="breadcrumbs-title">Dettagli condivisione</h5>
                    <ol class="breadcrumbs">
                        <li><a href="<?php echo ROOT_URL.TEMPLATE_PATH?>user-contents/userhome.php">Dashboard</a></li>
                        <li><a href="<?php echo ROOT_URL.TEMPLATE_PATH?>user-contents/system-details.php?id=<?php echo $condivisione['Impianto'];?>">Dettagli impianto</a></li>
                        <li><a href="<?php echo ROOT_URL.TEMPLATE_PATH?>user-contents/environment-details.php?id=<?php echo $condivisione['Ambiente'];?>">Dettagli amiente</a></li>
                        <li><a href="#">Dettagli condivisione</a></li>
                    </ol>
                </div>
            </div>
            </div>
        </div>
        <!--breadcrumbs end-->

        <div class="container">
          <div class="section">
          <p class="caption"><?php echo "Condivisione ".$condivisione['IDCondivisione']?></p>

            <div class="row">
                <div class="input-field col s12">
                    <input readonly value="<?php echo $condivisione['NomeTerzaParte']; ?>" id="disabled" type="text" >
                    <label for="disabled">Nome terza parte</label>
                </div>               
            </div>
            <div class="row">
                <div class="input-field col s6">
                    <input readonly value="<?php echo $condivisione['NomeTipologiaCanale']; ?>" id="disabled" type="text">
                    <label for="disabled">Tipologia canale</label>
                </div>
                <div class="input-field col s6">
                    <input readonly value="<?php echo $condivisione['Valore']; ?>" id="disabled" type="text" >
                    <label for="disabled">Canale</label>
                </div>           
            </div>
            <div class="row">
                <div class="input-field col s6">
                    <input readonly value="<?php echo $condivisione['NomeSensore']; ?>" id="disabled" type="text" >
                    <label for="disabled">Nome sensore</label>
                </div>             
            </div>

            <br>
            

            <br><br><br>

            </div>
          </div>
        </div>
    
    </section>
    <!-- END CONTENT -->

</div>
<!-- END WRAPPER -->

</div>
<!-- END MAIN -->
<br>
<br>
<br>


  <!-- //////////////////////////////////////////////////////////////////////////// -->

  <!-- START FOOTER -->
  <?php require("./includes/footer.php"); ?>