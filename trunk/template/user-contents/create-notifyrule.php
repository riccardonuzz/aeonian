<?php
require_once("../../config.php"); 
require("../../classes/NotifyManager.php");
require("../../classes/SensorsManager.php");


session_start();

//se la sessione non è presente, allora effettua il login
if(!isset($_SESSION['is_logged_in'])) {
  header('Location: '.ROOT_URL.'/template/login.php');
}

if(isset($_SESSION['user_data']) && $_SESSION['user_data']['ruolo']!=2) {
    header('Location: '.ROOT_URL.'/index.php');
}

//Gestore notifiche
$notifyManager = new NotifyManager();

//Gestore sensori
$sensorsManager = new SensorsManager();

$sensore = $sensorsManager->trovaSensore($_GET['id']);
$operations = array('&gt;', '&lt;', '&#61;');
$min = $sensore['Minimo'];
$max = $sensore['Massimo'];

//quando ricevo un POST sulla pagina
if(isset($_POST['submit'])){

  $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_URL);  
  $checkValue = $notifyManager->creaRegolaNotifica($post, $_GET['id'], $min, $max);

  if($checkValue['error']==1){
    $_SESSION['message'] = 'Ci sono dei campi che non sono stati compilati.';
    $_SESSION['values'] = $checkValue['values'];
    header('Location: create-notifyrule.php?id='.$_GET['id']);
    exit;
  }
  if($checkValue['error']==2){
    $_SESSION['message'] = 'I valori sono in un range non accettabile.';
    $_SESSION['values'] = $checkValue['values'];
    header('Location: create-notifyrule.php?id='.$_GET['id']);
    exit;
  }
  else{
    header("Location: sensor-details.php?id=".$_GET['id']);
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
              <h5 class="breadcrumbs-title">Configura notifica</h5>
              <ol class="breadcrumbs">
                  <li><a href="<?php echo ROOT_URL.TEMPLATE_PATH?>user-contents/userhome.php">Dashboard</a></li>
                  <li><a href="<?php echo ROOT_URL.TEMPLATE_PATH?>user-contents/system-details.php?id=<?php echo $sensore['IDImpianto']?>">Dettagli impianto</a></li>
                  <li><a href="<?php echo ROOT_URL.TEMPLATE_PATH?>user-contents/environment-details.php?id=<?php echo $sensore['Ambiente']?>">Dettagli ambiente</a></li>
                  <li><a href="<?php echo ROOT_URL.TEMPLATE_PATH?>user-contents/sensor-details.php?id=<?php echo $sensore['IDSensore']?>">Dettagli sensore</a></li>
                  <li><a href="#">Configura notifica</a></li>
              </ol>
            </div>
          </div>
        </div>
      </div>
      <!--breadcrumbs end-->

      
      <!--start container-->
      <div class="container">
        <div class="section">
          
          <!--Form Advance-->          
         
                  <div class="col s12 m12 l12">
                    
                        <form class="col s12" method="POST" action="<?php echo $_SERVER['PHP_SELF']."?id=".$_GET['id']; ?>">
  
                          <div class="row">
                              <div class="input-field col s2">                                
                                <select id="operations" name="operatore">
                                  <option  value="<?php echo $operations[0]; ?>" selected><?php echo $operations[0]; ?></option>
                                  <option  value="<?php echo $operations[1]; ?>"><?php echo $operations[1]; ?></option>
                                  <option  value="<?php echo $operations[2]; ?>"><?php echo $operations[2]; ?></option>
                                </select>
                                <label for="operations">Selezione operatore</label>
                              </div>

                              
                              <div class="input-field col s3">                                       
                                  <input value="<?php if (isset($_SESSION['values'])): ?><?php echo $_SESSION['values']['valore_soglia']; ?><?php endif; ?>" type="number" step="0.01" id="valore_soglia" name="valore_soglia" min="<?php echo $min; ?>" max="<?php echo $max; ?>" />  
                                  <label for="valore_soglia">Selezione valore soglia</label>
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
                              <a href="sensor-details.php?id=<?php echo $_GET['id']; ?>" class="btn waves-effect orange-style white-text admin-create-user">Annulla</a>
                              
                              <button class="btn dingy-dungeon waves-effect waves-light right" type="submit" name="submit">Configura notifica
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