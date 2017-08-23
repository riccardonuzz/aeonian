<?php
require_once("../../config.php"); 
require("../../classes/SystemsManager.php");
require("../../classes/UsersManager.php");
session_start();

//se la sessione non è presente, allora effettua il login
if(!isset($_SESSION['is_logged_in'])) {
  header('Location: '.ROOT_URL.'/template/login.php');
}

//Gestore Impianti
$systemsManager = new SystemsManager();
//Istanza del gestore Utenti
$usersManager = new UsersManager();
$users = $usersManager->getUtenti();

//quando ricevo un POST sulla pagina
if(isset($_POST['submit'])){
  $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
  $systemsManager->registraImpianto($post);
  header('Location: systems-management.php');
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
              <h5 class="breadcrumbs-title">Crea impianto</h5>
              <ol class="breadcrumbs">
                  <li><a href="<?php echo ROOT_URL.TEMPLATE_PATH?>installer-contents/installerhome.php">Dashboard</a></li>
                  <li><a href="<?php echo ROOT_URL.TEMPLATE_PATH?>installer-contents/systems-management.php">Gestione impianti</a></li>
                  <li><a href="#">Crea impianto</a></li>
              </ol>
            </div>
          </div>
        </div>
      </div>
      <!--breadcrumbs end-->


      <!--start container-->
      <div class="container">
        <div class="section">
          
          <div class="divider"></div>

          <!--Form Advance-->          
         
                  <div class="col s12 m12 l12">
                    
                        <form class="col s12" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
  
                          <div class="row">
                            <div class="input-field col s12">
                              <input id="system_name" type="text" name="nomeimpianto" required>
                              <label for="system_name">Nome Impianto</label>
                            </div>
                          </div>
                          
                          <div class="row">
                            <div class="input-field col s6">
                              <input id="country" type="text" name="nazione" required>
                              <label for="country">Nazione</label>
                            </div>
                            <div class="input-field col s6">
                              <input id="province" type="text" name="provincia">
                              <label for="province">Provincia</label>
                            </div>
                          </div>

                          <div class="row">
                            <div class="input-field col s12">
                              <input id="address" type="text" name="indirizzo">
                              <label for="address">Indirizzo</label>
                            </div>
                          </div>

                           <div class="row">
                            <div class="input-field col s6">
                              <input id="cap" type="text" name="cap">
                              <label for="cap">CAP</label>
                            </div>
                            <div class="input-field col s6">
                              <input id="city" type="text" name="citta">
                              <label for="city">Città</label>
                            </div>
                          </div>
                          
                                         <!-- START TABLE HERE -->
                          <!--DataTables example-->
                          <div id="table-datatables">

                              <div class="col s12 m8 l12">
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
                                     <?php $index = 0; ?>
                                      <?php foreach ($users as $user) :?>
                                      <tr>
                                          <td>
                                          <?php
                                            echo '<input type="radio" id="radio_btn'.$index.'" value="'.$user['CodiceFiscale'].'" name = "responsabile">';
                                            echo '<label for="radio_btn'.$index.'"><a href="user-details.php?id='.$user['CodiceFiscale'].'">'.$user['CodiceFiscale'].'</a></label>';
                                          ?>
                                          


                                          </td>
                                          <td><?php echo $user['Nome'] ?></td>
                                          <td><?php echo $user['Cognome'] ?></td>

                                      </tr>
                                      <?php $index++; ?>
                                    <?php endforeach;?>
                                  </tbody>
                                </table>
                              </div>
                            </div>
                          </div> 
                          <br>
                          <div class="divider"></div> 
                          <!-- END TABLE HERE -->
                 
                          
                          <div class="row">
                            <div class="input-field col s12">
                              <button class="btn cyan waves-effect waves-light right" type="submit" name="submit">Crea impianto
                                <i class="mdi-content-send right"></i>
                              </button>
                            </div>
                          </div>
                      
                        </form>
             
                </div>
        </div>

        <br><br><br><br><br><br>
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
      
      
    