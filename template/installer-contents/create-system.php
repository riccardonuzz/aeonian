<?php
require_once "../../config.php"; 
require "../../classes/SystemsManager.php";
require "../../classes/UsersManager.php";
session_start();

//se la sessione non è presente, allora effettua il login
if(!isset($_SESSION['is_logged_in'])) {
  header('Location: '.ROOT_URL.'/template/login.php');
}

if(isset($_SESSION['user_data']) && $_SESSION['user_data']['ruolo']!=3) {
    header('Location: '.ROOT_URL.'/index.php');
}

//Gestore Impianti
$systemsManager = new SystemsManager();
//Istanza del gestore Utenti
$usersManager = new UsersManager();
$clients = $usersManager->getClienti();

//quando ricevo un POST sulla pagina
if(isset($_POST['submit'])){
  $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
  $checkValue = $systemsManager->registraImpianto($post);

  if($checkValue['error']==1){
    $_SESSION['message'] = 'Ci sono dei campi che non sono stati compilati.';
    $_SESSION['values'] = $checkValue['values'];
    header('Location: create-system.php');
    return;
  }
  if($checkValue['error']==2){
    $_SESSION['message'] = 'Il CAP può contenere solo cifre ed ha una lunghezza fissa di 5 caratteri.';
    $_SESSION['values'] = $checkValue['values'];
    header('Location: create-system.php');
    return;
  }
  else{
    header('Location: systems-management.php');
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
                              <input id="system_name" type="text" name="nomeimpianto"
                              value="<?php if (isset($_SESSION['values'])): ?><?php echo $_SESSION['values']['nomeimpianto']; ?><?php endif; ?>" >
                              <label for="system_name">Nome Impianto</label>
                            </div>
                          </div>

                          <div class="row">
                            <div class="input-field col s12">
                              <input id="address" type="text" name="indirizzo"
                              value="<?php if (isset($_SESSION['values'])): ?><?php echo $_SESSION['values']['indirizzo']; ?><?php endif; ?>">
                              <label for="address">Indirizzo</label>
                            </div>
                          </div>

                          <div class="row">
                            <div class="input-field col s4">
                              <input id="city" type="text" name="citta"
                              value="<?php if (isset($_SESSION['values'])): ?><?php echo $_SESSION['values']['citta']; ?><?php endif; ?>">
                              <label for="city">Città</label>
                            </div>
                            <div class="input-field col s4">
                              <input id="cap" type="text" name="cap" maxlength="5" onkeypress='return event.charCode >= 48 && event.charCode <= 57' value="<?php if (isset($_SESSION['values'])): ?><?php echo $_SESSION['values']['cap']; ?><?php endif; ?>">
                              <label for="cap">CAP</label>
                            </div>
                            <div class="input-field col s4">
                              <input id="province" type="text" name="provincia"
                              value="<?php if (isset($_SESSION['values'])): ?><?php echo $_SESSION['values']['provincia']; ?><?php endif; ?>">
                              <label for="province">Provincia</label>
                            </div>
                          </div>
                          
                          <div class="row">
                            <div class="input-field col s6">
                              <input id="country" type="text" name="nazione"
                              value="<?php if (isset($_SESSION['values'])): ?><?php echo $_SESSION['values']['nazione']; ?><?php endif; ?>" >
                              <label for="country">Nazione</label>
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
                                  <?php foreach ($clients as $client) :?>
                                      <tr>
                                          <td>
                                          <?php
											
										    $str = <<<HTML
<input type='checkbox' id='check_btn$index' value='$client[CodiceFiscale]' name = 'responsabile[]'><label style='color:black' for='check_btn$index'>$client[CodiceFiscale]</label>
HTML;
										    echo $str;
                                          ?>


                                          </td>
                                          <td><?php echo $client['Nome'] ?></td>
                                          <td><?php echo $client['Cognome'] ?></td>

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
                              <div class="input-field col s6">
                                <?php
                                  if (isset($_SESSION['message']))
                                  {
                                        $escaped = htmlspecialchars($_SESSION['message'], ENT_QUOTES);
									  $str = <<<HTML
<p class='red-text text-darken-2'>$escaped</p>
HTML;
									  echo $str;
                                      unset($_SESSION['message']);
                                      unset($_SESSION['values']);
                                  }
                                ?>
                              </div>
                          </div>

                          <div class="row">
                            <div class="input-field col s12">
                              <a href="systems-management.php" class="btn waves-effect orange-style white-text admin-create-user">Annulla</a>

                              <button class="btn dingy-dungeon waves-effect waves-light right" type="submit" name="submit">Crea impianto
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
  <?php require "./includes/footer.php"; ?>
      
      
    
