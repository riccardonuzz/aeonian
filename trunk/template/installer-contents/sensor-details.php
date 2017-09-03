<?php
require_once("../../config.php"); 
require("../../classes/SensorsManager.php");
require("../../classes/NotifyManager.php");


session_start();

if(!isset($_SESSION['is_logged_in'])) {
  header('Location: '.ROOT_URL.'/template/login.php');
}

if(isset($_SESSION['user_data']) && $_SESSION['user_data']['ruolo']!=3) {
    header('Location: '.ROOT_URL.'/index.php');
}


//Gestore Sensori
$sensorsManager = new SensorsManager();
//Gestore Notifiche
$notifyManager = new NotifyManager();
$sensore = $sensorsManager->trovaSensore($_GET['id']);
$regoleSensore = $notifyManager->getRegoleNotificaSensore($_GET['id']);

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
                    <h5 class="breadcrumbs-title">Dettagli sensore</h5>
                    <ol class="breadcrumbs">
                        <li><a href="<?php echo ROOT_URL.TEMPLATE_PATH?>installer-contents/installerhome.php">Dashboard</a></li>
                        <li><a href="<?php echo ROOT_URL.TEMPLATE_PATH?>installer-contents/systems-management.php">Gestione impianti</a></li>
                        <li><a href="<?php echo ROOT_URL.TEMPLATE_PATH?>installer-contents/system-details.php?id=<?php echo $sensore['IDImpianto']?>">Dettagli impianto</a></li>
                        <li><a href="<?php echo ROOT_URL.TEMPLATE_PATH?>installer-contents/environment-details.php?id=<?php echo $sensore['Ambiente']?>">Dettagli ambiente</a></li>
                        <li><a href="#">Dettagli sensore</a></li>
                    </ol>
                </div>
            </div>
            </div>
        </div>
        <!--breadcrumbs end-->

        <div class="container">
          <div class="section">

            <a href="sensor-edit.php?id=<?php echo $sensore['IDSensore']; ?>" class="btn waves-effect orange-style white-text admin-create-user"><i class="mdi-editor-border-color right"></i>Modifica sensore</a>

            <a href="create-notifyrule.php?id=<?php echo $sensore['IDSensore']; ?>" class="btn waves-effect queen-blue white-text admin-create-user right"><i class="mdi-social-notifications-on right"></i>Configura notifica</a>
                
            <br><br>
            
            <div class="divider"></div>
            <br><br>

            <div class="row">
                <div class="input-field col s4">
                    <input readonly value="<?php echo $sensore['IDSensore']; ?>" id="disabled" type="text" >
                    <label for="disabled">Codice Sensore</label>
                </div>
                <div class="input-field col s4">
                    <input readonly value="<?php echo $sensore['sensNome']; ?>" id="disabled" type="text" >
                    <label for="disabled">Nome Sensore</label>
                </div>
                <div class="input-field col s4">
                    <input readonly value="<?php echo $sensore['Marca']; ?>" id="disabled" type="text" >
                    <label for="disabled">Marca</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s6">
                    <input readonly value="<?php echo $sensore['tipoNome']; ?>" id="disabled" type="text" >
                    <label for="disabled">Tipologia Sensore</label>
                </div>
                <div class="input-field col s4">
                    <input readonly value="<?php echo $sensore['UnitaMisura']; ?>" id="disabled" type="text" >
                    <label for="disabled">Unità di Misura</label>
                </div>
                <div class="input-field col s1">
                    <input readonly value="<?php echo $sensore['Minimo']; ?>" id="disabled" type="text" >
                    <label for="disabled">Minimo</label>
                </div>
                <div class="input-field col s1">
                    <input readonly value="<?php echo $sensore['Massimo']; ?>" id="disabled" type="text" >
                    <label for="disabled">Massimo</label>
                </div>
            </div>
           
            <div class="row">
                <div class="input-field col s6">
                    <input readonly value="<?php echo $sensore['ambNome']; ?>" id="disabled" type="text" >
                    <label for="disabled">Nome Ambiente</label>
                </div>
                <div class="input-field col s6">
                    <input readonly value="<?php echo $sensore['impNome']; ?>" id="disabled" type="text" >
                    <label for="disabled">Nome Impianto</label>
                </div>
            </div>

              <!-- START TABLE HERE -->
              <!--DataTables example-->
              <div id="table-datatables">

                  <div class="col s12 m8 l12">
                    <table id="data-table-simple" class="responsive-table display" cellspacing="0">
                      <thead>
                          <tr>
                              <th>Operatore</th>
                              <th>Valore Soglia</th>
                          </tr>
                      </thead>
                   
                      <tfoot>
                          <tr>
                              <th>Operatore</th>
                              <th>Valore Soglia</th>
                          </tr>
                      </tfoot>
                   
                      <tbody>
                      
                        <?php foreach ($regoleSensore as $rule) :?>
                          <tr>
                            <td><?php echo $rule['Operazione'] ?></td>
                            <td class="custom-cell">
                              <p><?php echo $rule['Valore'] ?></p>
                              <i onclick="elimina('<?php echo ROOT_URL.TEMPLATE_PATH.'installer-contents/notify-management.php';?>', '<?php echo $rule['IDRegola']; ?>')"  class="custom-icon btn-warning-confirm mdi-action-delete"></i>
                            </td>                            
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
          </div>
        </div>
    
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