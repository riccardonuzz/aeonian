<?php
require_once "../../config.php"; 
require "../../classes/ThirdPartiesManager.php";

session_start();

//se la sessione non è presente, allora effettua il login
if(!isset($_SESSION['is_logged_in'])) {
  header('Location: '.ROOT_URL.'/template/login.php');
}

if(isset($_SESSION['user_data']) && $_SESSION['user_data']['ruolo']!=2) {
  header('Location: '.ROOT_URL.'/index.php');
}

//Gestore Ambienti
$thirdPartiesManager = new ThirdPartiesManager();
$canali = $thirdPartiesManager->getTipologieCanali();

//quando ricevo un POST sulla pagina
if(isset($_POST['submit'])) {
  $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
  $checkValue = $thirdPartiesManager->aggiungiTerzaParte($post, $_SESSION['user_data']['codicefiscale']);

  if($checkValue['error']==1){
    $_SESSION['message'] = 'Ci sono dei campi che non sono stati compilati.';
    $_SESSION['values']['nome'] = $checkValue['nome'];
    header('Location: create-thirdparty.php');
    return;
  }

  if($checkValue['error']==2){
    $_SESSION['message'] = 'Se selezioni un canale devi compilare il campo.';
    $_SESSION['values']['nome'] = $checkValue['nome'];
    header('Location: create-thirdparty.php');
    return;
  }


  else {
    header('Location: thirdparties-management.php');
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
              <h5 class="breadcrumbs-title">Aggiungi terza parte</h5>
              <ol class="breadcrumbs">
                  <li><a href="<?php echo ROOT_URL.TEMPLATE_PATH?>user-contents/userhome.php">Dashboard</a></li>
                  <li><a href="<?php echo ROOT_URL.TEMPLATE_PATH?>user-contents/thirdparties-management.php">Gestione terze parti</a></li>
                  <li><a href="#">Aggiungi terza parte</a></li>
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
                    
                      
                        <form id="form" class="col s12" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                          <div class="row">
                            <div class="input-field col s6">
                              <input id="first_name" type="text" name="nome" 
                              value="<?php if (isset($_SESSION['values'])): ?><?php echo $_SESSION['values']['nome']; ?><?php endif; ?>">
                              <label for="first_name">Nome</label>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col s6">
                                <br>
                                <p class="caption">Seleziona canali</p>
                            </div>
                          </div>

                          <?php $index=0;
                                foreach($canali as $canale):?>
                            <div class="row">
                              <div class="input-field col s4">
                                  <?php 
								  
								  $str =  <<<HTML
<input type='hidden' value='' name='canali[$index]'><input type='checkbox' id='check_btn$index' value='$canale[IDTipologiaCanale]' name = 'canali[$index]'><label style='color:black' for='check_btn$index'>$canale[Nome]</label>
HTML;
                                  echo $str;
                                  ?>
                              </div>
                            </div>
                            <br>
                            <div class="row">
                              <div class="input-field col s12">
                                  <input id="valore_canale" type="text" name="valori[]"><label for="valore">Valore</label>            
                              </div>
                            </div>
                          <?php $index++; 
                                endforeach; ?>


                          <div class="row">
                            <div class="input-field col s12">
                                <button class="btn dingy-dungeon waves-effect waves-light right" type="submit" name="submit">Crea terza parte
                                  <i class="mdi-content-send right"></i>
                                </button>
                            </div>

                            </div>
                          
                          
                          
      
                            
                            <div class="row">
                              <div class="input-field col s4">
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
    
