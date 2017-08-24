<?php
require_once("../../config.php"); 
require("../../classes/EnvironmentsManager.php");

session_start();

if(!isset($_SESSION['is_logged_in'])) {
  header('Location: '.ROOT_URL.'/template/login.php');
}

if(isset($_SESSION['user_data']) && $_SESSION['user_data']['ruolo']!=3) {
    header('Location: '.ROOT_URL.'/index.php');
}

//Gestore Ambienti
$environmentsManager = new EnvironmentsManager();
$ambiente = $environmentsManager->trovaAmbiente($_GET['id']); 
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
                        <li><a href="<?php echo ROOT_URL.TEMPLATE_PATH?>installer-contents/system-details.php?id=<?php echo $ambiente['Impianto']?>">Dettagli impianto</a></li>
                        <li><a href="#">Dettagli ambiente</a></li>
                    </ol>
                </div>
            </div>
            </div>
        </div>
        <!--breadcrumbs end-->

        <div class="container">
          <div class="section">
        

            <div class="row">
                <div class="input-field col s6">
                    <input readonly value="<?php echo $ambiente['impNome']; ?>" id="disabled" type="text" >
                    <label for="disabled">Nome Impianto</label>
                </div>
                <div class="input-field col s6">
                    <input readonly value="<?php echo $ambiente['ambNome']; ?>" id="disabled" type="text" >
                    <label for="disabled">Nome Ambiente</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s12">
                    <input readonly value="<?php echo $ambiente['Descrizione']; ?>" id="disabled" type="text" >
                    <label for="disabled">Descrizione</label>
                </div>
            </div>
        

            <br>
            <a href="create-environment.php?id=<?php echo $ambiente['IDAmbiente']; ?>" class="btn waves-effect pink white-text admin-create-user"><i class="mdi-editor-border-color right"></i>Aggiungi sensore</a>
            

            <br><br><br>

              <!-- START TABLE HERE -->
              <!--DataTables example-->
              <!-- Tabella degli ambienti -->
              <div id="table-datatables">

                <div class="col s12 m8 l12">
                  <table id="data-table-simple" class="responsive-table display" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Nome Impianto</th>
                            <th>Nome Ambiente</th>
                            <th>Descrizione</th>
                        </tr>
                    </thead>
                 
                    <tfoot>
                        <tr>
                            <th>Nome Impianto</th>
                            <th>Nome Ambiente</th>
                            <th>Descrizione</th>
                        </tr>
                    </tfoot>
                 
                    <tbody>
                        

                    </tbody>
                  </table>
                </div>
              </div>
            </div> 
            <br>
            <div class="divider"></div> 
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
  <?php require("./includes/footer.php"); ?>