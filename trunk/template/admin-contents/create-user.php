<?php
require_once("../../config.php"); 
require("../../classes/UsersManager.php");

session_start();

//se la sessione non è presente, allora effettua il login
if(!isset($_SESSION['is_logged_in'])) {
  header('Location: '.ROOT_URL.'/template/login.php');
}

//Gestore Utenti
$usersManager = new UsersManager();

//ruoli da visualizzare nel menu dropdown
$roles_options = $usersManager->getRuoli();


//quando ricevo un POST sulla pagina
if(isset($_POST['submit'])){
  $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
  $usersManager->registraUtente($post);
  header('Location: users-management.php');
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
              <h5 class="breadcrumbs-title">Crea utente</h5>
              <ol class="breadcrumb">
                  <li><a href="<?php echo ROOT_URL.TEMPLATE_PATH?>admin-contents/adminhome.php">Dashboard</a></li>
                  <li><a href="<?php echo ROOT_URL.TEMPLATE_PATH?>admin-contents/users-management.php">Gestione utenti</a></li>
                  <li><a href="#">Crea utente</a></li>
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
                    
                      
                        <form class="col s12" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                          <div class="row">
                            <div class="input-field col s6">
                              <input id="first_name" type="text" name="nome">
                              <label for="first_name">Nome</label>
                            </div>
                          
                            <div class="input-field col s6">
                              <input id="last_name" type="text" name="cognome">
                              <label for="last_name">Cognome</label>
                            </div>
                          </div>
                          <div class="row">
                            <div class="input-field col s12">
                              <input id="email5" type="email" name="email">
                              <label for="email">Email</label>
                            </div>
                          </div>
                          <div class="row">
                            <div class="input-field col s12">
                              <input id="password6" type="password" name="password">
                              <label for="password">Password</label>
                            </div>
                          </div>

                          <div class="row">
                          
                              <div class="input-field col s6">
                                  <select id="ruolo" name="ruolo">
                                      <option value="" disabled selected>Seleziona ruolo</option>
                                      <?php foreach($roles_options as $role): ?>
                                        <option value="<?php echo $role['IDRuolo'] ?>"><?php echo $role['Nome'] ?></option>
                                      <?php endforeach;?>
                                  </select>
                              </div>
                                        
                            <div class="input-field col s6">
                              <input id="codicefiscale" type="text" name="codicefiscale">
                              <label for="codicefiscale">Codice fiscale</label>
                            </div>
                            
                          </div>

                          <div class="row phonenumber">
                            <div class="input-field col s8">
                              <input id="numerotelefono" type="text" name="numerotelefono">
                              <label for="numerotelefono">Numero di telefono</label>
                            </div>

                            <div class="input-field col s4">
                              <a onClick="parent.addNumber();" class="btn waves-effect pink white-text admin-add-number"><i class="mdi-content-add right"></i>Aggiungi numero</a>
                            </div>
                            
                          </div>
                          
      
                            
                            <div class="row">
                              <div class="input-field col s12">
                                <button class="btn cyan waves-effect waves-light right" type="submit" name="submit">Crea utente
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
      
      
    