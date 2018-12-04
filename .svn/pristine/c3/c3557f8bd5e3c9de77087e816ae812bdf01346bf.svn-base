<?php
require_once "../../config.php"; 

 //Inizio sessione
 session_start();

if(!isset($_SESSION['is_logged_in'])) {
    header('Location: '.ROOT_URL.TEMPLATE_PATH.'login.php');
}

if(isset($_SESSION['user_data']) && $_SESSION['user_data']['ruolo']!=3) {
    header('Location: '.ROOT_URL.'/index.php');
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
                          <img src="<?php echo ROOT_URL,IMAGES_PATH; ?>blueprint.jpg" alt="system">
                          <span class="card-title">Gestione Impianti</span>
                        </div>
                        <div class="card-content">
                          <p>"Gestione impianti" consente di visualizzare tutti gli impianti registrati (in forma tabellare) e crearne uno nuovo. Consente inoltre di eliminare gli impianti con estrema facilità grazie ad una ricerca rapida ed efficiente.</p>
                        </div>
                      </div>
                    </div>
                    <div class="col s12 m6 l6" style="margin-bottom: 10px">
                      <div class="card medium">
                        <div class="card-image">
                          <img src="<?php echo ROOT_URL,IMAGES_PATH; ?>industria.jpg" alt="environment">
                          <span class="card-title">Panoramica Ambienti</span>
                        </div>
                        <div class="card-content">
                          <p>"Panoramica ambienti" consente di visualizzare tutti gli ambienti registrati (in forma tabellare) e visualizzarne gli eventuali dettagli. Consente inoltre di eliminare gli ambienti con estrema facilità grazie ad una ricerca rapida ed efficiente.</p>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col s12 m6 l6" style="margin-bottom: 10px">
                      <div class="card medium">
                        <div class="card-image">
                          <img src="<?php echo ROOT_URL,IMAGES_PATH; ?>sensori.jpg" alt="sensor">
                          <span class="card-title">Panoramica Sensori</span>
                        </div>
                        <div class="card-content">
                          <p>"Panoramica sensori" consente di visualizzare tutti i sensori registrati (in forma tabellare) e visualizzarne i relativi dettagli. Consente inoltre di eliminare i sensori con estrema facilità grazie ad una ricerca rapida ed efficiente.</p>
                        </div>
                      </div>
                    </div>
                    <div class="col s12 m6 l6" style="margin-bottom: 10px">
                      <div class="card medium">
                        <div class="card-image">
                          <img src="<?php echo ROOT_URL,IMAGES_PATH; ?>notifica.jpg" alt="notification">
                          <span class="card-title">Configura Notifica</span>
                        </div>
                        <div class="card-content">
                          <p>"Configura notifica" consente, una volta selezionato il sensore desiderato, di stabilire il valore soglia per suddetto sensore.</p>
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
  <?php require "./includes/footer.php"; ?>