<?php
require_once "../../config.php"; 
require "../../classes/SensorsManager.php";
require_once "../../classes/OutputsManager.php";

session_start();

if(!isset($_SESSION['is_logged_in'])) {
  header('Location: '.ROOT_URL.'/template/login.php');
}

if(isset($_SESSION['user_data']) && $_SESSION['user_data']['ruolo']!=2) {
    header('Location: '.ROOT_URL.'/index.php');
}


//Gestore Sensori
$sensorsManager = new SensorsManager();

if(!$sensorsManager->checkProperty($_GET['id'], $_SESSION['user_data']['codicefiscale'])) {
    header('Location: '.ROOT_URL.'/403.php');
}

$sensore = $sensorsManager->trovaSensore($_GET['id']);

$outputsManager = new OutputsManager();
$rilevazioni = $outputsManager->getRilevazioni($_GET['id']);

$notifyManager = new NotifyManager();
$regoleSensore = $notifyManager->getRegoleNotificaSensore($_GET['id']);
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
                    <h5 class="breadcrumbs-title">Dettagli sensore</h5>
                    <ol class="breadcrumbs">
                        <li><a href="<?php echo ROOT_URL.TEMPLATE_PATH?>user-contents/userhome.php">Dashboard</a></li>
                        <li><a href="<?php echo ROOT_URL.TEMPLATE_PATH?>user-contents/system-dashboard.php?id=<?php echo $sensore['IDImpianto']?>">Il mio impianto</a></li>
                        <li><a href="<?php echo ROOT_URL.TEMPLATE_PATH?>user-contents/system-details.php?id=<?php echo $sensore['IDImpianto']?>">Dettagli impianto</a></li>
                        <li><a href="<?php echo ROOT_URL.TEMPLATE_PATH?>user-contents/environment-details.php?id=<?php echo $sensore['Ambiente']?>">Dettagli ambiente</a></li>
                        <li><a href="#">Dettagli sensore</a></li>
                    </ol>
                </div>
            </div>
            </div>
        </div>
        <!--breadcrumbs end-->

        <div class="container">
          <div class="section">

            <a href="create-notifyrule.php?id=<?php echo $sensore['IDSensore']; ?>" style="margin-left: 10px; margin-bottom: 10px;" class="btn waves-effect queen-blue white-text admin-create-user right"><i class="mdi-social-notifications-on right"></i>Configura notifica</a>
            <a href="create-share.php?id=<?php echo $sensore['IDSensore']; ?>" class="btn waves-effect queen-blue white-text admin-create-user right"><i class="mdi-social-share right"></i>Condividi con terza parte</a>

            
                <p class="caption">Informazioni sensore</p>            


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
                    <div class="input-field col s6">
                        <input readonly value="<?php echo $sensore['UnitaMisura']; ?>" id="disabled" type="text" >
                        <label for="disabled">Unità di Misura</label>
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



                <p class="caption">Regole notifiche create per questo sensore</p>            

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
                                <td><?php echo $rule['Valore'] ?>
                                <i class="custom-icon mdi-action-delete right" onclick="elimina('<?php echo ROOT_URL.TEMPLATE_PATH.'user-contents/notifyrule-management.php';?>', '<?php echo $rule['IDRegola']; ?>', '<?php echo ROOT_URL.TEMPLATE_PATH.'user-contents/sensor-details.php?id='.$sensore['IDSensore'];?>')"  class="custom-icon btn-warning-confirm mdi-action-delete"></i>
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


                <p class="caption">Rilevazioni effettuate dal sensore</p>            
          
                <!-- START TABLE HERE -->
                <!--DataTables example-->
                <!-- Tabella degli ambienti -->
                <div id="table-datatables">

                    <div class="col s12 m8 l12">
                    <table id="data-table-simple-rilevazioni" class="responsive-table display" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Data</th>
                                <th>Valore rilevazione</th>
                            </tr>
                        </thead>
                    
                        <tfoot>
                            <tr>
                                <th>Data</th>
                                <th>Valore rilevazione</th> 
                            </tr>
                        </tfoot>
                    
                        <tbody>
                            <?php foreach ($rilevazioni as $rilevazione) :?>
                            <tr>
                                <td><?php echo $rilevazione['Data'] ?></td>
                                <td><?php echo $rilevazione['Valore']," ",$rilevazione['UnitaMisura']; ?></a></td>
                            </tr>
                            <?php endforeach;?>
                        </tbody>
                    </table>
                    </div>
                </div>
            </div> 
            <br>
            <div class="divider"></div> 
            <br>
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
  <?php require "./includes/footer.php"; ?>