<?php
require_once "../../config.php"; 

 //Inizio sessione
 session_start();

if(!isset($_SESSION['is_logged_in'])) {
    header('Location: '.ROOT_URL.TEMPLATE_PATH.'login.php');
}

if(isset($_SESSION['user_data']) && $_SESSION['user_data']['ruolo']!=2) {
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
                        <span class="card-title">I miei impianti</span>
                      </div>
                      <div class="card-content">
                        <p>Nella sezione "I miei impianti" è possibile trovare la lista degli impianti associati al cliente. Da lì sarà poi possibile muoversi da un impianto all'altro senza problemi e rapidamente.</p>
                      </div>
                    </div>
                  </div>
                  <div class="col s12 m6 l6" style="margin-bottom: 10px">
                    <div class="card medium">
                      <div class="card-image">
                        <img src="<?php echo ROOT_URL,IMAGES_PATH; ?>dashboard.jpg" alt="dashboard">
                        <span class="card-title">Dashboard Impianto</span>
                      </div>
                      <div class="card-content">
                        <p>Per ogni impianto viene messa a disposizione una dashboard. Dal numero di ambienti/sensori ai grafici delle rilevazioni per ciascun sensore, la dashboard consente di monitorare il proprio impianto in maniera intuitiva.</p>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col s12 m6 l6" style="margin-bottom: 10px">
                      <div class="card medium">
                        <div class="card-image">
                          <img src="<?php echo ROOT_URL,IMAGES_PATH; ?>notifica.jpg" alt="notification">
                          <span class="card-title">Notifiche</span>
                        </div>
                        <div class="card-content">
                          <p>In "Notifiche" è presente la lista delle notifiche, lette e non lette. Per comodità del cliente, è anche possibile controllare l'eventuale presenza di nuove notifiche dall'opportuna icona in alto a destra. Il cliente ha anche la possibilità di gestire le regole notifica per ciascun sensore.</p>
                        </div>
                      </div>
                    </div>
                  <div class="col s12 m6 l6" style="margin-bottom: 10px">
                    <div class="card medium">
                      <div class="card-image">
                        <img src="<?php echo ROOT_URL,IMAGES_PATH; ?>terzeparti.jpg" alt="dashboard">
                        <span class="card-title">Terze Parti</span>
                      </div>
                      <div class="card-content">
                        <p>Il sistema permette la comunicazione di dati (purché dietro consenso del cliente) a terze parti. Il cliente ha la possibilità di gestire le terze parti come meglio crede.</p>
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