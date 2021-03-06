<?php
require_once '../../config.php'; 
require '../../classes/SensorsManager.php';

session_start();

//se la sessione non è presente, allora effettua il login
if(!isset($_SESSION['is_logged_in'])) {
  header('Location: '.ROOT_URL.'/template/login.php');
}

if(isset($_SESSION['user_data']) && $_SESSION['user_data']['ruolo']!=3) {
    header('Location: '.ROOT_URL.'/index.php');
}

//Gestore sensori
$sensorsManager = new SensorsManager();
$tipi = $sensorsManager->getTipi();
$sensore = $sensorsManager->trovaSensore($_GET['id']);

//quando ricevo un POST sulla pagina
if( isset($_POST['submit']) === true && isset($_GET) === true ){
	$get = filter_input_array( INPUT_GET, FILTER_SANITIZE_STRING );
	$sensId = rawurlencode($get['id'] );

  $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
  $checkValue = $sensorsManager->modificaSensore($post, $sensId);

  if($checkValue['error'] === SENSOR_EMPTYFIELD){
    $_SESSION['message'] = 'Ci sono dei campi che non sono stati compilati.';
    $_SESSION['values'] = $checkValue['values'];
    header('Location: sensor-edit.php?id='.$sensId);
    return;
  }
  if( $checkValue['error'] === SENSOR_INVALID_RANGE ){
    $_SESSION['message'] = "Il valore per l'attributo MINORE deve essere più piccolo di quello per l'attributo MASSIMO.";
    $_SESSION['values'] = $checkValue['values'];
    header('Location: sensor-edit.php?id='.$sensId);
    return;
  }
  else{
    header('Location: sensor-details.php?id='.$sensId);
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
              <h5 class="breadcrumbs-title">Modifica sensore</h5>
              <ol class="breadcrumbs">
                  <li><a href="<?php echo ROOT_URL.TEMPLATE_PATH?>installer-contents/installerhome.php">Dashboard</a></li>
                  <li><a href="<?php echo ROOT_URL.TEMPLATE_PATH?>installer-contents/systems-management.php">Gestione impianti</a></li>
                  <li><a href="<?php echo ROOT_URL.TEMPLATE_PATH?>installer-contents/system-details.php?id=<?php echo $sensore['IDImpianto']?>">Dettagli impianto</a></li>
                  <li><a href="<?php echo ROOT_URL.TEMPLATE_PATH?>installer-contents/environment-details.php?id=<?php echo $sensore['Ambiente']?>">Dettagli ambiente</a></li>
                  <li><a href="<?php echo ROOT_URL.TEMPLATE_PATH?>installer-contents/sensor-details.php?id=<?php echo $sensore['IDSensore']?>">Dettagli sensore</a></li>
                  <li><a href="<?php echo ROOT_URL.TEMPLATE_PATH?>installer-contents/sensor-details.php?id=<?php echo $sensore['IDSensore']?>">Dettagli sensore</a></li>
                  <li><a href="#">Modifica sensore</a></li>
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
                            <div class="input-field col s6">
                              <input readonly id="sensor_id" type="text" name="idsensore" value="<?php echo $sensore['IDSensore'] ?>" >
                              <label for="sensor_id">Codice Sensore</label>
                            </div>

                             <div class="input-field col s6">
                              <input id="sensor_name" type="text" name="nomesensore"
                              value="<?php echo $sensore['sensNome'] ?>" >
                              <label for="sensor_name">Nome Sensore</label>
                            </div>
                          </div>

                          <div class="row">
                            <div class="input-field col s6">
                              <input id="brand" type="text" name="marca"
                              value="<?php echo $sensore['Marca'] ?>">
                              <label for="brand">Marca</label>
                            </div>

                            <div class="input-field col s3">
                              <input id="minimum" type="number" step="0.01" name="minimo"
                                value="<?php echo $sensore['Minimo'];?>">
                              <label for="minimum">Minimo</label>
                            </div>

                            <div class="input-field col s3">
                              <input id="maximum" type="number" step="0.01" name="massimo"
                                value="<?php echo $sensore['Massimo'];?>">
                              <label for="maximum">Massimo</label>
                            </div>
                          </div>
                          
                        
                          <br><br>
                          
                          <!-- START TABLE HERE -->
                          <!--DataTables example-->
                          <div id="table-datatables">

                              <div class="col s12 m8 l12">
                                <table id="data-table-simple" class="responsive-table display" cellspacing="0">
                                  <thead>
                                      <tr>
                                          <th>Tipologia</th>
                                          <th>Unità di Misura</th>
                                      </tr>
                                  </thead>
                               
                                  <tfoot>
                                      <tr>
                                          <th>Tipologia</th>
                                          <th>Unità di Misura</th>
                                      </tr>
                                  </tfoot>
                               
                                  <tbody>
                                  <?php $index = 0; ?>
                                  <?php foreach ($tipi as $tipo) :?>
                                      <tr>
                                          <td>
                                          <?php
                                            if($tipo['IDTipologiaSensore'] == $sensore['TipologiaSensore']){
				
											$str = <<<HTML
<input type='radio' id='radio_btn$index' value='$tipo[IDTipologiaSensore]' name = 'tipo' checked='checked'><label style='color:black' for='radio_btn$index'>$tipo[Nome]</label>
HTML;
											  echo $str;
                                            }
                                            else{
									
											$str = <<<HTML
<input type='radio' id='radio_btn$index' value='$tipo[IDTipologiaSensore]' name = 'tipo'><label style='color:black' for='radio_btn$index'>$tipo[Nome]</label>
HTML;
											  echo $str;
                                            }
                                          ?>


                                          </td>
                                          <td><?php echo $tipo['UnitaMisura'] ?></td>

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

                          <div class="row">
                            <div class="input-field col s12">
                              <a href="sensor-details.php?id=<?php echo $_GET['id']; ?>" class="btn waves-effect orange-style white-text admin-create-user">Annulla</a>

                              <button class="btn dingy-dungeon waves-effect waves-light right" type="submit" name="submit">Modifica sensore
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
      
      
    
