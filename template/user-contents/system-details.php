<?php
require_once "../../config.php"; 
require "../../classes/SystemsManager.php";
require "../../classes/EnvironmentsManager.php";

session_start();

if(!isset($_SESSION['is_logged_in'])) {
  header('Location: '.ROOT_URL.'/template/login.php');
}

if(isset($_SESSION['user_data']) && $_SESSION['user_data']['ruolo']!=2) {
    header('Location: '.ROOT_URL.'/index.php');
}

//Gestore Utenti
$systemsManager = new SystemsManager();

if(!$systemsManager->checkProperty($_GET['id'], $_SESSION['user_data']['codicefiscale'])) {
    header('Location: '.ROOT_URL.'/403.php');
}


$environmentsManager = new EnvironmentsManager();

$systemDetails = $systemsManager->trovaImpianto($_GET['id']);
$systemResponsabili =$systemsManager->respFromImpianto($_GET['id']);
$systemAmbienti = $environmentsManager->getAmbientiImpianto($_GET['id']); 
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
                    <h5 class="breadcrumbs-title">Dettagli impianto</h5>
                    <ol class="breadcrumbs">
                        <li><a href="<?php echo ROOT_URL.TEMPLATE_PATH?>user-contents/userhome.php">Dashboard</a></li>
                        <li><a href="<?php echo ROOT_URL.TEMPLATE_PATH?>user-contents/system-dashboard.php?id=<?php echo $_GET['id'];?>">Il mio impianto</a></li>
                        <li><a href="#">Dettagli impianto</a></li>
                    </ol>
                </div>
            </div>
            </div>
        </div>
        <!--breadcrumbs end-->

        <div class="container">
          <div class="section">
          <p class="caption">Ambienti disponibili</p>

            <!-- START TABLE HERE -->
              <!--DataTables example-->
              <!-- Tabella degli ambienti -->
              <div id="table-datatables">

                <div class="col s12 m8 l12">
                  <table id="data-table-simple" class="responsive-table display" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Nome Ambiente</th>
                            <th>Descrizione</th>
                        </tr>
                    </thead>
                 
                    <tfoot>
                        <tr>
                            <th>Nome Ambiente</th>
                            <th>Descrizione</th>
                        </tr>
                    </tfoot>
                 
                    <tbody>
                        <?php foreach ($systemAmbienti as $ambiente) :?>
                        <tr>
                            <td><a href="environment-details.php?id=<?php echo $ambiente['IDAmbiente']?>"><?php echo $ambiente['Nome'] ?></a></td>
                            <td><?php echo $ambiente['Descrizione'] ?></td>
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

                       
            <br>

            <p class="caption">Informazioni impianto</p>
            <div class="row">
                <div class="input-field col s12">
                    <input readonly value="<?php echo $systemDetails['Nome']; ?>" id="disabled" type="text" >
                    <label for="disabled">Nome Impianto</label>
                </div>               
            </div>
            <div class = "row">
                <div class="input-field col s12">
                    <input readonly value="<?php echo $systemDetails['Indirizzo']; ?>" id="disabled" type="text" >
                    <label for="disabled">Indirizzo</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s4">
                    <input readonly value="<?php echo $systemDetails['Citta']; ?>" id="disabled" type="text">
                    <label for="disabled">Città</label>
                </div>
                <div class="input-field col s4">
                    <input readonly value="<?php echo $systemDetails['CAP']; ?>" id="disabled" type="text" >
                    <label for="disabled">CAP</label>
                </div>
                <div class="input-field col s4">
                    <input readonly value="<?php echo $systemDetails['Provincia']; ?>" id="disabled" type="text" >
                    <label for="disabled">Provincia</label>
                </div>                
            </div>
            <div class="row">
                <div class="input-field col s6">
                    <input readonly value="<?php echo $systemDetails['Nazione']; ?>" id="disabled" type="text" >
                    <label for="disabled">Nazione</label>
                </div>             
            </div>

            <?php $index = 1 ?>
            <?php foreach ($systemResponsabili as $resp): ?>
                <div class="row">
                    <div class="input-field col s6">
                        <input readonly value="<?php echo $resp['Nome']."  ".$resp['Cognome']; ?>" id="disabled" type="text" >
                        <label for="disabled">Responsabile<?php echo ' ',$index; ?></label>
                    </div>
                </div>
            <?php $index++ ?>
            <?php endforeach?>

            <br>
            

            <br><br><br>

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