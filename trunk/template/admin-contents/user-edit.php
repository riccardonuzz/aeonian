<?php
require_once("../../config.php"); 
require("../../classes/UsersManager.php");

session_start();

//se la sessione non è presente, allora effettua il login
if(!isset($_SESSION['is_logged_in'])) {
  header('Location: '.ROOT_URL.'/template/login.php');
}

if(isset($_SESSION['user_data']) && $_SESSION['user_data']['ruolo']!=1) {
  header('Location: '.ROOT_URL.'/index.php');
}

//Instanza del gestore Utenti
$usersManager = new UsersManager();

//Se ho ricevuto una richiesta GET allora prendo l'id come parametro ed effetturo la ricerca per ritrovare le info sull'utente
if(isset($_GET['id'])){
  $userDetails = $usersManager->trovaUtente($_GET['id']);
  $userPhoneNumbers = $usersManager->getNumeriTelefono($_GET['id']);
}


//quando ricevo un POST sulla pagina
if(isset($_POST['submit'])){
  $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
  $checkValue=$usersManager->modificaUtente($post);

  //se errore=1 allora vuol dire che i campi non sono stai compilati tutti e visualizzo un messaggio di errore
  if($checkValue['error']==1){
    $_SESSION['message'] = 'Ci sono dei campi che non sono stati compilati.';
    header('Location: user-edit.php?id='.$checkValue['codicefiscale']);
    exit;
  }

  //se errore=2 allora vuol dire che l'utente ha inserito una password non valida e visualizzo info su creazione password
  if($checkValue['error']==2){
    $_SESSION['message'] = 'Le regole per la creazione della password sono le seguenti:<br>
    <ul>
      <li>Deve avere almeno una lettera MAIUSCOLA;</li>
      <li>Deve avere ameno una lettere MINUSCOLA;</li>
      <li>Deve avere almeno 1 NUMERO o un CARATTERE SPECIALE;</li>
      <li>Deve avere dagli 8 ai 100 CARATTERI.</li>
    </ul>';
    header('Location: user-edit.php?id='.$checkValue['codicefiscale']);
    exit;
  }

  //altrimenti se è tutto ok, reindirizzo alle info dell'utente, così da poter vedere quanto modificato
  else{
    header('Location: user-details.php?id='.$checkValue);
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
              <h5 class="breadcrumbs-title">Modifica utente</h5>
              <ol class="breadcrumb">
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
          
          <div class="divider"></div>
          <br>
          <!--Form Advance-->          
         
                  <div class="col s12 m12 l12">
                    
                      
                        <form class="col s12" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                          <div class="row">
                            <div class="input-field col s6">
                              <input id="first_name" type="text" name="nome" value="<?php echo $userDetails['Nome']; ?>">
                              <label for="first_name">Nome</label>
                            </div>
                          
                            <div class="input-field col s6">
                              <input id="last_name" type="text" name="cognome" value="<?php echo $userDetails['Cognome']; ?>">
                              <label for="last_name">Cognome</label>
                            </div>
                          </div>
                          <div class="row">
                            <div class="input-field col s12">
                              <input id="email5" type="email" name="email" value="<?php echo $userDetails['Email']; ?>">
                              <label for="email">Email</label>
                            </div>
                          </div>
                          <div class="row">
                            <div class="input-field col s12">
                              <input id="password6" type="password" name="password">
                              <label for="password">Nuova password</label>
                            </div>
                          </div>

                          <div class="row">
                          
                              <div class="input-field col s6">
                                  <select id="ruolo" disabled>
                                        <option value="<?php echo $role['Ruolo'] ?>" disabled selected><?php echo $userDetails['Ruolo'] ?></option>
                                  </select>
                              </div>
                                        
                            <div class="input-field col s6">
                              <input id="codicefiscale" type="text" name="codicefiscale" value="<?php echo $userDetails['CodiceFiscale']; ?>" readonly>
                              <label for="codicefiscale">Codice fiscale</label>
                            </div>
                            
                          </div>
            
                          <div class="row phonenumber">
                          <?php 
                          $i=100;
                          foreach ($userPhoneNumbers as $number): ?>
                            <div class="input-field col s8">
                              <input id="numerotelefono" type="number" name="numerotelefono<?php echo $i;?>" value="<?php echo $number['Numero']; ?>">
                              <label for="numerotelefono">Numero di telefono</label>
                            </div>
                            <?php $i++;?>
                            <?php endforeach; ?>

                            <div class="input-field col s4">
                              <a onClick="addNumber();" class="btn waves-effect pink white-text admin-add-number"><i class="mdi-content-add right"></i>Aggiungi numero</a>
                            </div>
                            
                          </div>
                          
                          
                            
                          <div class="row">
                            <div class="input-field col s4">
                              <?php
                                if (isset($_SESSION['message']))
                                {
                                    echo "<p class='red-text text-darken-2'>".$_SESSION['message']."</p>";
                                    unset($_SESSION['message']);
                                }
                              ?>
                            </div>
                              <div class="input-field col s8">
                                <button class="btn cyan waves-effect waves-light right" type="submit" name="submit">Modifica
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
      
      
    