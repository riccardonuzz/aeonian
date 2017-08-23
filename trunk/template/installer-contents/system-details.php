<?php
require_once("../../config.php"); 
require("../../classes/SystemsManager.php");

session_start();

if(!isset($_SESSION['is_logged_in'])) {
  header('Location: '.ROOT_URL.'/template/login.php');
}

if(isset($_SESSION['user_data']) && $_SESSION['user_data']['ruolo']!=3) {
    header('Location: '.ROOT_URL.'/index.php');
}

//Gestore Utenti
$systemsManager = new SystemsManager();
$systemDetails = $systemsManager->trovaImpianto($_GET['id']);

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
                    <h5 class="breadcrumbs-title">Dettagli impianto</h5>
                    <ol class="breadcrumbs">
                        <li><a href="<?php echo ROOT_URL.TEMPLATE_PATH?>installer-contents/installerhome.php">Dashboard</a></li>
                        <li><a href="<?php echo ROOT_URL.TEMPLATE_PATH?>installer-contents/systems-management.php">Gestione impianti</a></li>
                        <li><a href="#">Dettagli impianto</a></li>
                    </ol>
                </div>
            </div>
            </div>
        </div>
        <!--breadcrumbs end-->

        <div class="container">
          <div class="section">
        
            
            <div class="divider"></div>
            <br><br>

            <div class="row">
                <div class="input-field col s6">
                    <input readonly value="<?php echo $systemDetails['Nome']; ?>" id="disabled" type="text" class="validate">
                    <label for="disabled">Nome</label>
                </div>
                <div class="input-field col s6">
                    <input readonly value="<?php echo $systemDetails['Nazione']; ?>" id="disabled" type="text" class="validate">
                    <label for="disabled">Nazione</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s6">
                    <input readonly value="<?php echo $systemDetails['Provincia']; ?>" id="disabled" type="text" class="validate">
                    <label for="disabled">Provincia</label>
                </div>
                <div class="input-field col s6">
                    <input readonly value="<?php echo $systemDetails['Indirizzo']; ?>" id="disabled" type="text" class="validate">
                    <label for="disabled">Indirizzo</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s6">
                    <input readonly value="<?php echo $systemDetails['CAP']; ?>" id="disabled" type="text" class="validate">
                    <label for="disabled">CAP</label>
                </div>
            </div>
           <div class="row">
                <div class="input-field col s6">
                    <input readonly value="<?php echo $systemDetails['Citta']; ?>" id="disabled" type="text" class="validate">
                    <label for="disabled">Città</label>
                </div>
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