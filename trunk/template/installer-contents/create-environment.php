<?php
require_once("../../config.php"); 
require("../../classes/SystemsManager.php");
require("../../classes/EnvironmentsManager.php");

session_start();

//se la sessione non è presente, allora effettua il login
if(!isset($_SESSION['is_logged_in'])) {
  header('Location: '.ROOT_URL.'/template/login.php');
}

//Gestore ambienti
$environmentManager = new EnvironmentsManager();
$systemsManager= new SystemsManager();



// quando ricevo un POST sulla pagina
if(isset($_POST['submit'])){
  $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
  $checkValue = $environmentManager->registraAmbiente($post,$_GET['id']);

  if($checkValue['error']==1){
    $_SESSION['message'] = 'Ci sono dei campi che non sono stati compilati.';
    $_SESSION['values'] = $checkValue['values'];
    header('Location: create-environment.php');
    exit;
  }
  else{
    // ritorna alla pagina dei dettagli impianto (così è più facile inserire più ambienti di fila)
    header("Location: system-details.php?id=".$_GET['id']);
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
              <h5 class="breadcrumbs-title">Crea ambiente</h5>
              <ol class="breadcrumbs">
                  <li><a href="<?php echo ROOT_URL.TEMPLATE_PATH?>installer-contents/installerhome.php">Dashboard</a></li>
                  <li><a href="<?php echo ROOT_URL.TEMPLATE_PATH?>installer-contents/systems-management.php">Gestione impianti
                  <li><a href="<?php echo ROOT_URL.TEMPLATE_PATH?>installer-contents/system-details.php?id=<?php 
                   echo $_GET['id']?>">Dettagli impianto

                  </a></li>
                  <li><a href="#">Crea ambiente</a></li>
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
                    
                        <form class="col s12" method="POST" action="<?php echo $_SERVER['PHP_SELF']."?id=".$_GET['id']; ?>">
  
                          <div class="row">
                            <div class="input-field col s12">
                              <input id="env_name" type="text" name="nomeAmbiente"
                              value="<?php if (isset($_SESSION['values'])): ?><?php echo $_SESSION['values']['nomeAmbiente']; ?><?php endif; ?>" >
                              <label for="env_name">Nome ambiente</label>
                            </div>
                          </div>
                          
                          <div class="row">
                            <div class="input-field col s12">
                              <input id="desc" type="text" name="descrizione"
                              value="<?php if (isset($_SESSION['values'])): ?><?php echo $_SESSION['values']['descrizione']; ?><?php endif; ?>" >
                              <label for="desc">Descrizione</label>
                            </div>
                          </div>


                         
                                     
                 
                          <div class="row">
                              <div class="input-field col s4">
                                <?php
                                  if (isset($_SESSION['message']))
                                  {
                                      echo "<p class='red-text text-darken-2'>".$_SESSION['message']."</p>";
                                      unset($_SESSION['message']);
                                      unset($_SESSION['values']);
                                  }
                                ?>
                              </div>
                          </div>

                          <div class="row">
                            <div class="input-field col s12">
                              <button class="btn cyan waves-effect waves-light right" type="submit" name="submit">Crea ambiente
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
      
      
    