<?php
require_once "../../config.php"; 
require "../../classes/UsersManager.php";

session_start();

//se la sessione non è presente, allora effettua il login
if(!isset($_SESSION['is_logged_in'])) {
  header('Location: '.ROOT_URL.'/template/login.php');
}

if(isset($_SESSION['user_data']) && $_SESSION['user_data']['ruolo']!=1) {
  header('Location: '.ROOT_URL.'/index.php');
}

//Gestore Utenti
$usersManager = new UsersManager();

//ruoli da visualizzare nel menu dropdown
$roles_options = $usersManager->getRuoli();


//quando ricevo un POST sulla pagina
if(isset($_POST['submit'])) {
  $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
  $checkValue = $usersManager->registraUtente($post);

  if($checkValue['error']==1){
    $_SESSION['message'] = 'Ci sono dei campi che non sono stati compilati.';
    $_SESSION['values'] = $checkValue['values'];
    header('Location: create-user.php');
    return;
  }

  if($checkValue['error']==2){
    $_SESSION['message'] = 'Le regole per la creazione della password sono le seguenti:<br>
    <ul>
      <li>Deve avere almeno una lettera MAIUSCOLA;</li>
      <li>Deve avere ameno una lettere MINUSCOLA;</li>
      <li>Deve avere almeno 1 NUMERO o un CARATTERE SPECIALE;</li>
      <li>Deve avere dagli 8 ai 100 CARATTERI.</li>
    </ul>';
    $_SESSION['values'] = $checkValue['values'];
    header('Location: create-user.php');
    return;
  }

  if($checkValue['error']==3){
    $_SESSION['message'] = 'Utente non registrato. Codice fiscale o email già presenti nel sistema.';
    $_SESSION['values'] = $checkValue['values'];
    header('Location: create-user.php');
    return;
  }

  if($checkValue['error']==4){
    $_SESSION['message'] = 'Utente non registrato. Uno o più numeri di telefono sono già presenti nel sistema.';
    $_SESSION['values'] = $checkValue['values'];
    header('Location: create-user.php');
    return;
  }


  else {
    header('Location: users-management.php');
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
              <h5 class="breadcrumbs-title">Crea utente</h5>
              <ol class="breadcrumbs">
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
                              <input id="first_name" type="text" name="nome" 
                              value="<?php if (isset($_SESSION['values'])): ?><?php echo $_SESSION['values']['nome']; ?><?php endif; ?>">
                              <label for="first_name">Nome</label>
                            </div>
                          
                            <div class="input-field col s6">
                              <input id="last_name" type="text" name="cognome" 
                                value="<?php if (isset($_SESSION['values'])): ?><?php echo $_SESSION['values']['cognome']; ?><?php endif; ?>">
                              <label for="last_name">Cognome</label>
                            </div>
                          </div>
                          <div class="row">
                            <div class="input-field col s12">
                              <input id="email5" type="email" name="email" 
                                value="<?php if (isset($_SESSION['values'])): ?><?php echo $_SESSION['values']['email']; ?><?php endif; ?>">
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
                                      <?php if (isset($_SESSION['values']) && strcmp($_SESSION['values']['ruolo'], $role['IDRuolo'])): ?>
                                        <option value="0">Seleziona ruolo</option>
                                      <?php else: ?>
                                        <option value="0" selected>Seleziona ruolo</option>
                                      <?php endif; ?>
                                      
                                      <?php foreach($roles_options as $role): ?>
                                        <?php if (isset($_SESSION['values']) && ($_SESSION['values']['ruolo']==$role['IDRuolo'])): ?>
                                          <option value="<?php echo $role['IDRuolo'] ?>" selected><?php echo $role['Nome'] ?></option>
                                        <?php else: ?>
                                          <option value="<?php echo $role['IDRuolo'] ?>"><?php echo $role['Nome'] ?></option>
                                        <?php endif; ?>
                                      <?php endforeach;?>
                                  </select>
                              </div>
                                        
                            <div class="input-field col s6">
                              <input id="codicefiscale" type="text" name="codicefiscale"
                                value="<?php if (isset($_SESSION['values'])): ?><?php echo $_SESSION['values']['codicefiscale']; ?><?php endif; ?>">
                              <label for="codicefiscale">Codice fiscale</label>
                            </div>
                            
                          </div>

                          <div class="row phonenumber">
                            <div class="input-field col s8">
                              <input id="numerotelefono" type="number" name="numerotelefono"
                                value="<?php if (isset($_SESSION['values'])): ?><?php echo $_SESSION['values']['numerotelefono']; ?><?php endif; ?>">
                              <label for="numerotelefono">Numero di telefono</label>
                            </div>

                            <div class="input-field col s4">
                              <a onClick="addNumber();" class="btn waves-effect queen-blue white-text admin-add-number"><i class="mdi-content-add right"></i>Aggiungi numero</a>
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
                              <div class="input-field col s8">
                                <button class="btn dingy-dungeon waves-effect waves-light right" type="submit" name="submit">Crea utente
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
      
      
    
