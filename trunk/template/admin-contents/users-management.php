<?php
require_once("../../config.php"); 
require("../../classes/UsersManager.php");

//inizio la sessione (se non lo faccio non posso leggere le variabili da $_SESSION)
session_start();

//se non è stato effettuato il login, reindirizza alla pagina di login
if(!isset($_SESSION['is_logged_in'])) {
  header('Location: '.ROOT_URL.'/template/login.php');
}

//se il ruolo è != da 1 allora vuol dire che non si è autorizzati e reindirizza alla pagina corretta
if(isset($_SESSION['user_data']) && $_SESSION['user_data']['ruolo']!=1) {
  header('Location: '.ROOT_URL.'/index.php');
}

//Istanza del gestore Utenti
$usersManager = new UsersManager();
$users = $usersManager->getUtenti();

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
                <h5 class="breadcrumbs-title">Gestione utenti</h5>
                <ol class="breadcrumbs">
                    <li><a href="<?php echo ROOT_URL.TEMPLATE_PATH?>admin-contents/adminhome.php">Dashboard</a></li>
                    <li><a href="<?php echo ROOT_URL.TEMPLATE_PATH?>admin-contents/users-management.php">Gestione utenti</a></li>
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
            <a href="create-user.php" class="btn waves-effect pink white-text admin-create-user"><i class="mdi-editor-border-color right"></i>Crea utente</a>
            <br><br>
            
            <div class="divider"></div>
            <br><br>

            <!-- START TABLE HERE -->
            <!--DataTables example-->
            <div id="table-datatables">

                <div class="col s12 m8 l9">
                  <table id="data-table-simple" class="responsive-table display" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Codice fiscale</th>
                            <th>Nome</th>
                            <th>Cognome</th>
                        </tr>
                    </thead>
                 
                    <tfoot>
                        <tr>
                        <th>Codice fiscale</th>
                        <th>Nome</th>
                        <th>Cognome</th>
                        </tr>
                    </tfoot>
                 
                    <tbody>
                        <?php foreach ($users as $user) :?>
                        <tr>
                            <td><a href="user-details.php?id=<?php echo $user['CodiceFiscale']; ?>"><?php echo $user['CodiceFiscale'] ?></a></td>
                            <td><?php echo $user['Nome'] ?></td>
                            <td><?php echo $user['Cognome'] ?></td>

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
      