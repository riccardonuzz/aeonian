<?php
require_once "../../config.php"; 
require "../../classes/ThirdPartiesManager.php";


session_start();

if(!isset($_SESSION['is_logged_in'])) {
  header('Location: '.ROOT_URL.TEMPLATE_URL.'login.php');
}

if(isset($_SESSION['user_data']) && $_SESSION['user_data']['ruolo']!=2) {
    header('Location: '.ROOT_URL.'/index.php');
}

//Gestore Ambienti
$thirdPartiesManager = new ThirdPartiesManager();
$terzaParte = $thirdPartiesManager->trovaTerzaParte($_GET['id']);
$canali = $thirdPartiesManager->getCanaliTerzaParte($_GET['id']);

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
            <h5 class="breadcrumbs-title">Dettagli terza parte</h5>
            <ol class="breadcrumbs">
                <li><a href="<?php echo ROOT_URL.TEMPLATE_PATH?>user-contents/userhome.php">Dashboard</a></li>
                <li><a href="<?php echo ROOT_URL.TEMPLATE_PATH?>user-contents/thirdparties-management.php">Gestione terze parti</a></li>
                <li><a href="#">Dettagli terza parte</a></li>
            </ol>
          </div>
        </div>
      </div>
    </div>
    <!--breadcrumbs end-->

        <div class="container">
          <div class="section">
           
            <a href="thirdparty-edit.php?id=<?php echo $_GET['id']; ?>" class="btn waves-effect orange-style white-text admin-create-user"><i class="mdi-editor-border-color right"></i>Modifica terza parte</a>
            
            <br><br>
            
            <div class="divider"></div>
            <br><br>

            <div class="row">
                <div class="input-field col s6">
                    <input readonly value="<?php echo $terzaParte['Nome']; ?>" id="disabled" type="text" >
                    <label for="disabled">Nome</label>
                </div>
            </div>

            <?php foreach($canali as $canale) : ?>
            <div class="row">
                <div class="input-field col s11">
                    <input readonly value="<?php echo $canale['Valore']; ?>" id="disabled" type="text" >
                    <label for="disabled"><?php echo $canale['Nome']; ?></label>
                </div>
            </div>
            <?php endforeach;?>
        

            <br>        


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