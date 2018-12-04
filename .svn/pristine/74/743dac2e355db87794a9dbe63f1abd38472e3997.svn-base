<?php
require_once "../../config.php"; 
require "../../classes/EnvironmentsManager.php";
session_start();

if(!isset($_SESSION['is_logged_in'])) {
  header('Location: '.ROOT_URL.'/template/login.php');
}

if(isset($_SESSION['user_data']) && $_SESSION['user_data']['ruolo']!=3) {
    header('Location: '.ROOT_URL.'/index.php');
}

//Gestore Ambienti
$environmentsManager = new EnvironmentsManager();

//prendo la lista con tutti gli ambienti presenti del database
$ambienti = $environmentsManager->getAmbienti();


if(isset($_POST['action'])) {
    $action = $_POST['action'];
    $var = $_POST['id'];
    switch($action) {
      case 'delete':
        $environmentsManager->eliminaAmbiente($var);
        break;
		
	  default:
		echo "Errore.";
    }
	
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
                <h5 class="breadcrumbs-title">Panoramica ambienti</h5>
                <ol class="breadcrumbs">
                    <li><a href="<?php echo ROOT_URL.TEMPLATE_PATH?>installer-contents/installerhome.php">Dashboard</a></li>
                    <li><a href="#">Panoramica ambienti</a></li>
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
                  <table id="data-table-simple" class="custom-table responsive-table display" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Nome Ambiente</th>
                            <th>Nome Impianto</th>
                            <th>Descrizione</th>
                        </tr>
                    </thead>
                 
                    <tfoot>
                        <tr>
                            <th>Nome Ambiente</th>
                            <th>Nome Impianto</th>
                            <th>Descrizione</th>
                        </tr>
                    </tfoot>
                 
                    <tbody>
                        <?php foreach ($ambienti as $ambiente) :?>
                        <tr>
                            <td><a href="environment-details.php?id=<?php echo $ambiente['IDAmbiente']?>"><?php echo $ambiente['ambNome'] ?></a></td> 
                            <td><a href="system-details.php?id=<?php echo $ambiente['idimpianto']; ?>"><?php echo $ambiente['impNome'] ?></td>
                            <td class="custom-cell">
                                
                                <p><?php echo $ambiente['Descrizione'] ?></p>
                                <i onclick="elimina('<?php echo ROOT_URL.TEMPLATE_PATH.'installer-contents/environments-management.php';?>', '<?php echo $ambiente['IDAmbiente'];?>', '<?php echo ROOT_URL.TEMPLATE_PATH.'installer-contents/environments-management.php';?>')" class="custom-icon mdi-action-delete"></i>
                              
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
  <?php require "./includes/footer.php"; ?>
      
      