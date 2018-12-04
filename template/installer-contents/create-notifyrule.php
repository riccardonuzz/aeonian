<?php
require_once '../../config.php'; 
require_once '../../classes/NotifyManager.php';
require_once '../../classes/SensorsManager.php';

session_start();

//se la sessione non è presente, allora effettua il login
if(!isset($_SESSION['is_logged_in'])) {
  header('Location: '.ROOT_URL.'/template/login.php');
}

if( $_SESSION['user_data']['ruolo'] != INSTALLATORE ) {
	header('Location: '.ROOT_URL.'/index.php');
}

//Gestore notifiche
$notifyManager = new NotifyManager();

//Gestore sensori
$sensorsManager = new SensorsManager();
$get = filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING);  

$sensore = $sensorsManager->trovaSensore($get['id']);
$operations = array(
	'greater' => '&gt;',
	'less' => '&lt;',
	'equal' => '&#61;'
);

//quando ricevo un POST sulla pagina
if( isset( $_POST['submit'] ) === true ){

  $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_URL);  
  $checkValue = $notifyManager->creaRegolaNotifica($post, $sensore['IDSensore'], $sensore['Minimo'], $sensore['Massimo']);

  if( $checkValue['error']=== NOTIFY_EMPTYFIELD ){
    $_SESSION['message'] = 'Ci sono dei campi che non sono stati compilati.';
    $_SESSION['values'] = $checkValue['values'];
    
      header('Location: create-notifyrule.php?id='.$sensore['IDSensore']);
      return;

  }
  if( $checkValue['error']=== NOTIFY_BADRANGE ){
    $_SESSION['message'] = 'I valori sono in un range non accettabile.';
    $_SESSION['values'] = $checkValue['values'];

      header('Location: create-notifyrule.php?id='.$sensore['IDSensore']);
      return;

    }else{

	 header("Location: sensor-details.php?id=".$sensore['IDSensore']);
      return;

    }
}

?>

<!-- START HEADER -->
<?php require './includes/header.php'; ?>
    <!-- END HEADER -->

  <!-- //////////////////////////////////////////////////////////////////////////// -->

  <!-- START MAIN -->
  <div id="main">
    <!-- START WRAPPER -->
    <div class="wrapper">

    <!-- START LEFT SIDEBAR NAV-->
        <?php require './includes/sidebar.php'; ?>
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
                  <li><a href="<?php echo ROOT_URL.TEMPLATE_PATH?>installer-contents/installerhome.php">Dashboard</a></li>
                  <li><a href="<?php echo ROOT_URL.TEMPLATE_PATH?>installer-contents/systems-management.php">Gestione impianti</a></li>
                  <li><a href="<?php echo ROOT_URL.TEMPLATE_PATH?>installer-contents/system-details.php?id=<?php echo $sensore['IDImpianto']?>">Dettagli impianto</a></li>
                  <li><a href="<?php echo ROOT_URL.TEMPLATE_PATH?>installer-contents/environment-details.php?id=<?php echo $sensore['Ambiente']?>">Dettagli ambiente</a></li>
                  <li><a href="<?php echo ROOT_URL.TEMPLATE_PATH?>installer-contents/sensor-details.php?id=<?php echo $sensore['IDSensore']?>">Dettagli sensore</a></li>
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
                    
                        <form class="col s12" method="POST" action="<?php echo $_SERVER['PHP_SELF']."?id=".$sensore['IDSensore']; ?>">
  
                          <div class="row">
                              <div class="input-field col s2">                                
                                <select id="operations" name="operatore">
                                  <option  value="<?php echo $operations['greater']; ?>" selected><?php echo $operations['greater']; ?></option>
                                  <option  value="<?php echo $operations['less']; ?>"><?php echo $operations['less']; ?></option>
                                  <option  value="<?php echo $operations['equal']; ?>"><?php echo $operations['equal']; ?></option>
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
                                  if (isset($_SESSION['message'])){
								
								  $escaped = htmlspecialchars($_SESSION['message'], ENT_QUOTES);
								  unset($_SESSION['message']);
                                  unset($_SESSION['values']);
								?>
								  <p class='red-text text-darken-2'><?php echo $escaped; } ?></p>								

                              </div>
                          </div>
                  
                          <div class="row">
                            <div class="input-field col s12">
                              <a href="sensor-details.php?id=<?php echo $sensore['IDSensore']; ?>" class="btn waves-effect orange-style white-text admin-create-user">Annulla</a>
                              
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
  <?php require './includes/footer.php'; ?>