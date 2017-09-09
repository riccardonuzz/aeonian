<?php
require_once("../../config.php"); 

 //Inizio sessione
 session_start();

if(!isset($_SESSION['is_logged_in'])) {
    header('Location: '.ROOT_URL.TEMPLATE_PATH.'login.php');
}

if(isset($_SESSION['user_data']) && $_SESSION['user_data']['ruolo']!=1) {
    header('Location: '.ROOT_URL.'/index.php');
}
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
                    <h5 class="breadcrumbs-title">Homepage</h5>
                    <ol class="breadcrumbs">
                        <li><a href="#">Dashboard</a></li>
                        <li><a href="#">Homepage</a></li>
                    </ol>
                </div>
                </div>
            </div>
            </div>
            <!--breadcrumbs end-->


            <!--start container-->
            <div class="container">
              <div class="section">
              <br>
                 <div class="row">
                    <div class="col s12 m6 l6" style="margin-bottom: 10px">
                      <div class="card medium">
                        <div class="card-image">
                          <img src="<?php echo ROOT_URL.IMAGES_PATH; ?>users.jpg" alt="users">
                          <span class="card-title">Gestione Utenti</span>
                        </div>
                        <div class="card-content">
                          <p>"Gestione Utenti" consente di visualizzare tutti gli utenti registrati (in forma tabellare) e crearne uno nuovo. Consente inoltre di modificare gli utenti con estrema facilità grazie ad una ricerca rapida ed efficiente.</p>
                        </div>
                      </div>
                    </div>
                  </div>
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
  <?php require("./includes/footer.php"); ?>