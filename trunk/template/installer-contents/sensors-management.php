<?php
require_once("../../config.php"); 
require("../../classes/SensorsManager.php");

session_start();

if(!isset($_SESSION['is_logged_in'])) {
  header('Location: '.ROOT_URL.'/template/login.php');
}

if(isset($_SESSION['user_data']) && $_SESSION['user_data']['ruolo']!=3) {
    header('Location: '.ROOT_URL.'/index.php');
}

//Gestore Sensori
$sensorsManager = new SensorsManager();
//prendo la lista con tutti i sensori presenti del database
$sensori = $sensorsManager->getSensori();

if(isset($_POST['action'])) {
    $action = $_POST['action'];
    $var = $_POST['id'];
    switch($action) {
      case 'delete':
        $sensorsManager->eliminaSensore($var);
        break;
    }
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
                <h5 class="breadcrumbs-title">Panoramica sensori</h5>
                <ol class="breadcrumbs">
                    <li><a href="<?php echo ROOT_URL.TEMPLATE_PATH?>installer-contents/installerhome.php">Dashboard</a></li>
                    <li><a href="#">Panoramica sensori</a></li>
                </ol>
              </div>
            </div>
          </div>
        </div>
        <!--breadcrumbs end-->


        <!--start container-->
        <div class="container">
          <div class="section">

            <!-- START TABLE HERE -->
              <!--DataTables example-->
              <!-- Tabella degli ambienti -->
              <div id="table-datatables">

                <div class="col s12 m8 l12">
                  <table id="data-table-simple" class="responsive-table display" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Nome Sensore</th>
                            <th>Tipologia</th>
                            <th>Nome Impianto</th>
                            <th>Nome Ambiente</th>
                        </tr>
                    </thead>
                 
                    <tfoot>
                        <tr>
                            <th>Nome Sensore</th>
                            <th>Tipologia</th>
                            <th>Nome Impianto</th>
                            <th>Nome Ambiente</th>
                        </tr>
                    </tfoot>
                 
                    <tbody>
                        <?php foreach ($sensori as $sensore) :?>
                        <tr>
                            <td><a href="sensor-details.php?id=<?php echo $sensore['IDSensore']; ?>""><?php echo $sensore['sensNome'] ?></a></td>
                            <td><?php echo $sensore['tipoNome'] ?></td>
                            <td><a href="system-details.php?id=<?php echo $sensore['sensImp']; ?>"><?php echo $sensore['impNome'] ?></a></td>
                            <td>
                              <a href="environment-details.php?id=<?php echo $sensore['sensAmb']?>"><?php echo $sensore['ambNome'] ?></a>
                              <i onclick="elimina('<?php echo ROOT_URL.TEMPLATE_PATH.'installer-contents/sensors-management.php';?>', '<?php echo $sensore['IDSensore'];?>')" class="custom-icon mdi-action-delete right"></i>
                             
                            </td>
                        </tr>
                        <?php endforeach;?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div> 
            <br>
            <div class="divider"></div> 
            <!-- END TABLE HERE -->

          
        </div>
              <!--end container-->
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
      
      