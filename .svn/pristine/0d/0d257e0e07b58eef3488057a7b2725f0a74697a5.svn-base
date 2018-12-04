<?php
require_once "../../config.php"; 
require "../../classes/DashboardManager.php";


 //Inizio sessione
 session_start();

if(!isset($_SESSION['is_logged_in'])) {
    header('Location: '.ROOT_URL.TEMPLATE_PATH.'login.php');
}

if(isset($_SESSION['user_data']) && $_SESSION['user_data']['ruolo']!=2) {
    header('Location: '.ROOT_URL.'/index.php');
}


$dashboardManager = new DashboardManager();

if(!$dashboardManager->checkProperty($_GET['id'], $_SESSION['user_data']['codicefiscale'])) {
    header('Location: '.ROOT_URL.'/403.php');
}


$response = $dashboardManager->getDatiDashboard($_GET['id']);

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
                    <h5 class="breadcrumbs-title">Impianto</h5>
                    <ol class="breadcrumbs">
                        <li><a href="#">Dashboard</a></li>
                        <li><a href="#">Il mio impianto</a></li>
                    </ol>
                </div>
                </div>
            </div>
            </div>
            <!--breadcrumbs end-->

            <div class="row">
                <div class="col s12 m8 l9">
                    <h2><?php echo htmlspecialchars($response[0]['Nome'], ENT_QUOTES); ?></h2>
                </div>
                <div class="col s12 m4 l3">
                    <a style="margin-top: 40px;" href="system-details.php?id=<?php echo htmlspecialchars($_GET['id'], ENT_QUOTES); ?>" class="btn waves-effect dingy-dungeon white-text admin-add-number right"><i class="mdi-action-list right"></i>Dettagli impianto</a>
                </div>
            </div>

            

            <!--start container-->
            <div class="container" id="dashboard-content">
            
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
  <script type="text/javascript" src="<?php echo ROOT_URL,SCRIPT_PATH; ?>custom-script.js"></script>
  <script>
  window.onload = function() {
        getDashboard('<?php echo htmlspecialchars(json_encode($response), ENT_QUOTES, 'UTF-8'); ?>');
  }
  </script>

</body>

</html>
