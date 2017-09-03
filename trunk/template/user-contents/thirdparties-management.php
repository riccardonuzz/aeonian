<?php
require_once("../../config.php"); 
require("../../classes/ThirdPartiesManager.php");

session_start();

if(!isset($_SESSION['is_logged_in'])) {
  header('Location: '.ROOT_URL.'/template/login.php');
}

if(isset($_SESSION['user_data']) && $_SESSION['user_data']['ruolo']!=2) {
    header('Location: '.ROOT_URL.'/index.php');
}

//Gestore Ambienti
$thirdPartiesManager = new ThirdPartiesManager();
$terzeparti = $thirdPartiesManager->getTerzeParti($_SESSION['user_data']['codicefiscale']);



if(isset($_POST['action'])) {
    $action = $_POST['action'];
    $var = $_POST['id'];
    switch($action) {
      case 'delete':
        $thirdPartiesManager->eliminaTerzaParte($var);
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
                <h5 class="breadcrumbs-title">Gestione terze parti</h5>
                <ol class="breadcrumbs">
                    <li><a href="<?php echo ROOT_URL.TEMPLATE_PATH?>user-contents/userhome.php">Dashboard</a></li>
                    <li><a href="#">Gestione terze parti</a></li>
                </ol>
              </div>
            </div>
          </div>
        </div>
        <!--breadcrumbs end-->


        <!--start container-->
        <div class="container">
          <div class="section">

           <!-- <p class="caption">Utenti </p> -->
           <a href="create-thirdparty.php" class="btn waves-effect pink white-text"><i class="mdi-editor-border-color right"></i>Aggiungi terza parte</a>
            <br><br>
            
            <div class="divider"></div>
            <br><br>

            <!-- START TABLE HERE -->
              <!--DataTables example-->
              <!-- Tabella delle terze parti -->
              <div id="table-datatables">

                <div class="col s12 m8 l12">
                  <table id="data-table-simple" class="responsive-table display" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                        </tr>
                    </thead>
                 
                    <tfoot>
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                        </tr>
                    </tfoot>
                 
                    <tbody>
                        <?php foreach ($terzeparti as $terzaparte) :?>
                        <tr>
                            <td><a href="thirdparty-details.php?id=<?php echo $terzaparte['IDTerzaParte']?>"><?php echo $terzaparte['IDTerzaParte'] ?></a></td> 
                            <td><a href="thirdparty-details.php?id=<?php echo $terzaparte['IDTerzaParte']; ?>"><?php echo $terzaparte['Nome'] ?>
                              <i onclick="elimina('<?php echo ROOT_URL.TEMPLATE_PATH.'user-contents/thirdparties-management.php';?>', '<?php echo $terzaparte['IDTerzaParte'];?>')" class="custom-icon mdi-action-delete right"></i>
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
      
      