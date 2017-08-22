<?php
require_once("../../config.php"); 

 //Inizio sessione
 session_start();

if(!isset($_SESSION['is_logged_in'])) {
    header('Location: '.ROOT_URL.TEMPLATE_PATH.'login.php');
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
                    <ol class="breadcrumb">
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

                <p class="caption">A Simple Blank Page to use it for your custome design and elements.</p>
                <div class="divider"></div>
                <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
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