<?php
require_once "../../config.php"; 
require "../../classes/NotifyManager.php";

session_start();

if(!isset($_SESSION['is_logged_in'])) {
  header('Location: '.ROOT_URL.'/template/login.php');
}

if(isset($_SESSION['user_data']) && $_SESSION['user_data']['ruolo']!=2) {
    header('Location: '.ROOT_URL.'/index.php');
}


$notifyManager = new NotifyManager();


if(!$notifyManager->checkNotifyProperty($_GET['id'], $_SESSION['user_data']['codicefiscale'])) {
    header('Location: '.ROOT_URL.'/403.php');
}

$notifica = $notifyManager->trovaNotifica($_GET['id']);
$nome = $notifica['NomeSensore'];
$unitamisura = $notifica['UnitaMisura'];
$ambiente = $notifica['NomeAmbiente'];
$messaggio = $notifica['Messaggio'];


    //   print "<pre>";
    //   print_r($notifica);
    //   print "</pre>";
    //   exit;

$notifyManager->leggi($_GET['id']);
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
                    <h5 class="breadcrumbs-title">Dettagli notifica</h5>
                    <ol class="breadcrumbs">
                        <li><a href="<?php echo ROOT_URL,TEMPLATE_PATH?>user-contents/userhome.php">Dashboard</a></li>
                        <li><a href="<?php echo ROOT_URL,TEMPLATE_PATH?>user-contents/notifications-management.php?utente=<?php echo htmlspecialchars($_SESSION['user_data']['codicefiscale'], ENT_QUOTES); ?>">Notifiche</a></li>
                        <li><a href="#">Dettagli notifica</a></li>
                    </ol>
                </div>
            </div>
            </div>
        </div>
        <!--breadcrumbs end-->

        <div class="container">
          <div class="section">


                <p class="caption"><?php echo "Notifica #",htmlspecialchars($_GET['id'], ENT_QUOTES); ?></p>            


                <div class="row">
                    <div class="input-field col s4">
                        <input readonly value="<?php echo htmlspecialchars($notifica['IDSensore'], ENT_QUOTES); ?>" id="disabled" type="text" >
                        <label for="disabled">Codice Sensore</label>
                    </div>
                    <div class="input-field col s4">
                        <input readonly value="<?php echo htmlspecialchars($nome, ENT_QUOTES); ?>" id="disabled" type="text" >
                        <label for="disabled">Nome Sensore</label>
                    </div>
                    <div class="input-field col s4">
                        <input readonly value="<?php echo htmlspecialchars($ambiente, ENT_QUOTES); ?>" id="disabled" type="text" >
                        <label for="disabled">Nome ambiente</label>
                    </div>
                </div>

                <div class="row">
                    <div class="input-field col s6">
                        <input readonly value="<?php echo htmlspecialchars("Eccezione rilevata: ", ENT_QUOTES),htmlspecialchars($messaggio, ENT_QUOTES)," ",htmlspecialchars($unitamisura, ENT_QUOTES); ?>" id="disabled" type="text" >
                        <label for="disabled">Messaggio</label>
                    </div>
                    <div class="input-field col s6">
                        <input readonly value="<?php echo htmlspecialchars($notifica['IDSensore'], ENT_QUOTES)," ",htmlspecialchars($notifica['Operazione'], ENT_QUOTES)," ",htmlspecialchars($notifica['Valore'], ENT_QUOTES); ?>" id="disabled" type="text" >
                        <label for="disabled">Regola applicata</label>
                    </div>
                </div>


               
            </div> 
            <br>
            <div class="divider"></div> 
            <br>
            <!-- END TABLE HERE -->
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
  <?php require "./includes/footer.php"; ?>
