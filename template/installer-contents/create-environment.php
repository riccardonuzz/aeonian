<?php
require_once '../../config.php'; 
require '../../classes/EnvironmentsManager.php';

session_start();

//se la sessione non è presente, allora effettua il login
if(!isset($_SESSION['is_logged_in'])) {
  header('Location: '.ROOT_URL.'/template/login.php');
}

if( $_SESSION['user_data']['ruolo'] != INSTALLATORE ) {
	header('Location: '.ROOT_URL.'/index.php');
}

//Gestore ambienti
$environmentManager = new EnvironmentsManager();
$get = filter_input_array(INPUT_GET, FILTER_SANITIZE_NUMBER_INT); 
$impianto = $get['id'];

// quando ricevo un POST sulla pagina
if( isset($_POST['submit']) === true ){
	$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
	$checkValue = $environmentManager->registraAmbiente($post,$impianto);

  if($checkValue['error']===ENVIRONMENT_EMPTYFIELD){
    $_SESSION['message'] = 'Ci sono dei campi che non sono stati compilati.';
    $_SESSION['values'] = $checkValue['values'];
    header('Location: create-environment.php?id='.$impianto);
    return;
  }
  else{
    // ritorna alla pagina dei dettagli impianto (così è più facile inserire più ambienti di fila)
    header('Location: system-details.php?id='.$impianto);
  }
}

?>

<!-- START HEADER -->
<?php require './includes/header.php'; ?>
    <!-- END HEADER -->

  <!-- //////////////////////////////////////////////////////////////////////////// -->

  <!-- START MAIN -->
  <div id='main'>
    <!-- START WRAPPER -->
    <div class='wrapper'>

    <!-- START LEFT SIDEBAR NAV-->
        <?php require './includes/sidebar.php'; ?>
    <!-- END LEFT SIDEBAR NAV-->


      <!-- //////////////////////////////////////////////////////////////////////////// -->

      <!-- START CONTENT -->
      <section id='content'>

      <!--breadcrumbs start-->
      <div id='breadcrumbs-wrapper' class=' grey lighten-3'>
        <div class='container'>
          <div class='row'>
            <div class='col s12 m12 l12'>
              <h5 class='breadcrumbs-title'>Crea ambiente</h5>
              <ol class='breadcrumbs'>
                  <li><a href='<?php echo ROOT_URL,TEMPLATE_PATH?>installer-contents/installerhome.php'>Dashboard</a></li>
                  <li><a href='<?php echo ROOT_URL,TEMPLATE_PATH?>installer-contents/systems-management.php'>Gestione impianti
                  <li><a href='<?php echo ROOT_URL,TEMPLATE_PATH?>installer-contents/system-details.php?id=<?php 
                   echo htmlspecialchars($ambiente, ENT_QUOTES); ?>'>Dettagli impianto

                  </a></li>
                  <li><a href='#'>Crea ambiente</a></li>
              </ol>
            </div>
          </div>
        </div>
      </div>
      <!--breadcrumbs end-->


      <!--start container-->
      <div class='container'>
        <div class='section'>
          
          <div class='divider'></div>

          <!--Form Advance-->          
         
                  <div class='col s12 m12 l12'>
                    
                        <form class='col s12' method='POST' action='<?php echo $_SERVER['PHP_SELF'].'?id='.$impianto; ?>'>
  
                          <div class='row'>
                            <div class='input-field col s12'>
                              <input id='env_name' type='text' name='nomeAmbiente'
                              value='<?php if (isset($_SESSION['values'])): ?><?php echo $_SESSION['values']['nomeAmbiente']; ?><?php endif; ?>' >
                              <label for='env_name'>Nome ambiente</label>
                            </div>
                          </div>
                          
                          <div class='row'>
                            <div class='input-field col s12'>
                              <input id='desc' type='text' name='descrizione'
                              value='<?php if (isset($_SESSION['values'])): ?><?php echo $_SESSION['values']['descrizione']; ?><?php endif; ?>' >
                              <label for='desc'>Descrizione</label>
                            </div>
                          </div>                          
                 
                          <div class='row'>
                              <div class='input-field col s4'>
                                <?php
                                  if (isset($_SESSION['message'])){
								
								  $escaped = htmlspecialchars($_SESSION['message'], ENT_QUOTES);
								  unset($_SESSION['message']);
                                  unset($_SESSION['values']);
								?>
								  <p class='red-text text-darken-2'><?php echo $escaped; } ?></p>								

                              </div>
                          </div>

                          <div class='row'>
                            <div class='input-field col s12'>
                              <a href='system-details.php?id=<?php echo $impianto; ?>' class='btn waves-effect orange-style white-text admin-create-user'>Annulla</a>

                              <button class='btn dingy-dungeon waves-effect waves-light right' type='submit' name='submit'>Crea ambiente
                                <i class='mdi-content-send right'></i>
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
  <?php require './includes/footer.php'; ?>
      
      
    
