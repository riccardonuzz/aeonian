<?php
require_once("../../config.php"); 
require("../../classes/UsersManager.php");

session_start();

if(!isset($_SESSION['is_logged_in'])) {
  header('Location: '.ROOT_URL.'/template/login.php');
}

//Gestore Utenti
$usersManager = new UsersManager();
$userDetails = $usersManager->trovaUtente($_GET['id']);
$userPhoneNumbers = $usersManager->getNumeriTelefono($_GET['id']);
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
                    <h5 class="breadcrumbs-title">Dettagli utente</h5>
                    <ol class="breadcrumb">
                        <li><a href="<?php echo ROOT_URL.TEMPLATE_PATH?>admin-contents/adminhome.php">Dashboard</a></li>
                        <li><a href="<?php echo ROOT_URL.TEMPLATE_PATH?>admin-contents/users-management.php">Gestione utenti</a></li>
                        <li><a href="#">Dettagli utente</a></li>
                    </ol>
                </div>
            </div>
            </div>
        </div>
        <!--breadcrumbs end-->

        <div class="container">
          <div class="section">
            <div class="row">
                <a href="user-edit.php?id=<?php echo $userDetails['CodiceFiscale']; ?>" class="btn waves-effect pink white-text admin-create-user"><i class="mdi-editor-border-color right"></i>Modifica utente</a>
            </div>
            <br>
            
            <div class="divider"></div>
            <br><br>

            <div class="row">
                <div class="input-field col s6">
                    <input readonly value="<?php echo $userDetails['Nome']; ?>" id="disabled" type="text" class="validate">
                    <label for="disabled">Nome</label>
                </div>
                <div class="input-field col s6">
                    <input readonly value="<?php echo $userDetails['Cognome']; ?>" id="disabled" type="text" class="validate">
                    <label for="disabled">Cognome</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s6">
                    <input readonly value="<?php echo $userDetails['CodiceFiscale']; ?>" id="disabled" type="text" class="validate">
                    <label for="disabled">Codice fiscale</label>
                </div>
                <div class="input-field col s6">
                    <input readonly value="<?php echo $userDetails['Email']; ?>" id="disabled" type="text" class="validate">
                    <label for="disabled">Email</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s6">
                    <input readonly value="<?php echo $userDetails['Ruolo']; ?>" id="disabled" type="text" class="validate">
                    <label for="disabled">Ruolo</label>
                </div>
            </div>
            <?php foreach ($userPhoneNumbers as $number): ?>
                <div class="row">
                    <div class="input-field col s6">
                        <input readonly value="<?php echo $number['Numero']; ?>" id="disabled" type="text" class="validate">
                        <label for="disabled">Numero telefonico</label>
                    </div>
                </div>
            <?php endforeach; ?>
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
      
      