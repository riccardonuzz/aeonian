<?php
	require_once '../config.php';
	require '../classes/LoginManager.php';


  //Inizio sessione
  session_start();   

  $loginManager = new LoginManager();

  if( empty($_GET['logout']) === false && $_GET['logout']==1 ){
    $loginManager->logout();
  }


  if( isset($_POST['submit'] ) === true ){
    $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
    $role = $loginManager->login($post);
echo $role;

    if( empty( $role ) === true ) {
          $_SESSION['message'] = 'Username o password errati.';
          header('Location: '.ROOT_URL.'/index.php');
          return;
    } else if( $role === AMMINISTRATORE ) {
          header('Location: '.ROOT_URL.TEMPLATE_PATH.'admin-contents/adminhome.php');
    } else if ($role === CLIENTE ) {
          header('Location: '.ROOT_URL.TEMPLATE_PATH.'user-contents/userhome.php');
    } else {
          header('Location: '.ROOT_URL.TEMPLATE_PATH.'installer-contents/installerhome.php');
    }

  }
      
  else{

      if( isset($_SESSION['is_logged_in']) === true ) {
        if( isset($_SESSION['user_data']) === true && $_SESSION['user_data']['ruolo']=== AMMINISTRATORE ) {
            header('Location: '.ROOT_URL.TEMPLATE_PATH.'admin-contents/adminhome.php');
      } else if ( isset($_SESSION['user_data']) === true && $_SESSION['user_data']['ruolo']=== CLIENTE ) {
            header('Location: '.ROOT_URL.TEMPLATE_PATH.'user-contents/userhome.php');
      } else {
            header('Location: '.ROOT_URL.TEMPLATE_PATH.'installer-contents/installerhome.php');
      }
    }

  }

?>

<!DOCTYPE html>
<html lang="it">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="msapplication-tap-highlight" content="no">

  <title>Login | Aeonian</title>

  <!-- Favicons-->
  <link rel="icon" href="<?php echo ROOT_URL,IMAGES_PATH; ?>aeonian-logo.png" sizes="32x32">
  <!-- Favicons-->
  <link rel="apple-touch-icon-precomposed" href="<?php echo ROOT_URL,IMAGES_PATH; ?>aeonian-logo.png" sizes="152x152"">
  <!-- For iPhone -->
  <meta name="msapplication-TileColor" content="#00bcd4">
  <meta name="msapplication-TileImage" content="<?php echo ROOT_URL,IMAGES_PATH; ?>aeonian-logo.png" sizes="144x144">
  <!-- For Windows Phone -->


  <!-- CORE CSS-->
  
  <link href="<?php echo ROOT_URL,STYLE_PATH; ?>materialize.css" type="text/css" rel="stylesheet" media="screen,projection">
  <link href="<?php echo ROOT_URL,STYLE_PATH; ?>style.css" type="text/css" rel="stylesheet" media="screen,projection">
  <link href="<?php echo ROOT_URL,STYLE_PATH; ?>layouts/page-center.css" type="text/css" rel="stylesheet" media="screen,projection">
  <link href="<?php echo ROOT_URL,STYLE_PATH; ?>custom/custom.min.css" type="text/css" rel="stylesheet" media="screen,projection">
   <link href="<?php echo ROOT_URL,STYLE_PATH; ?>custom/custom.css" type="text/css" rel="stylesheet" media="screen,projection">

  <!-- INCLUDED PLUGIN CSS ON THIS PAGE -->
  <link href="<?php echo ROOT_URL,SCRIPT_PATH; ?>plugins/prism/prism.css" type="text/css" rel="stylesheet" media="screen,projection">
</head>

<body class="space-cadet">
  
  <div id="login-page" class="row">

    <div class="col s12 z-depth-4 card-panel">

      <form class="login-form" method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'], ENT_QUOTES); ?>">
        <div class="row">
          <div class="input-field col s12 center">
            <p class="center login-form-text">AEONIAN SYSTEM</p>
          </div>
        </div>
        <div class="row margin">
          <div class="input-field col s12">
            <i class="mdi-social-person-outline prefix"></i>
            <input id="email" type="text" name="email">
            <label for="email" class="center-align">Email</label>
          </div>
        </div>
        <div class="row margin">
          <div class="input-field col s12">
            <i class="mdi-action-lock-outline prefix"></i>
            <input id="password" type="password" name="password">
            <label for="password">Password</label>
          </div>
        </div>
        <div class="row">  
          <!--not implemented        
          <div class="input-field col s12 m12 l12  login-text">
              <input type="checkbox" id="remember-me" name="remember"/>
              <label for="remember-me">Ricorda</label>
          </div>
          -->
          <div class="input-field col s12">
                <?php
                  if ( isset($_SESSION['message']) === true )
                  {
                      $escaped = htmlspecialchars($_SESSION['message'], ENT_QUOTES);
					  ?><br><p class='red-text text-darken-2'>
					  <?php 
						echo $escaped;
						unset($_SESSION['message']);
						unset($_SESSION['values']);						
						?>
					  </p>
				  <?php } ?>
              </div>
        </div>
        <div class="row">
          <div class="input-field col s12">
            <button class="btn queen-blue waves-effect waves-light login-button col s12" type="submit" name="submit">Login</button>
          </div>
        </div>
        <div class="row ">
          <div class="input-field col s12 custom-forgotten-div">
              <img id="logo-ae" src="<?php echo ROOT_URL,IMAGES_PATH; ?>aeonian-logo.png" alt="aeonian logo small">
              <p class="margin right-align medium-small">
                <a id="forgotten-pass" href="page-forgot-password.html">Hai dimenticato la password?</a>
              </p>
          </div>          
        </div>

      </form>
    </div>
  </div>

  <!-- ================================================
    Scripts
    ================================================ -->

  <!-- jQuery Library -->
  <script type="text/javascript" src="<?php echo ROOT_URL,SCRIPT_PATH; ?>plugins/jquery-1.11.2.min.js"></script>
  <!--materialize js-->
  <script type="text/javascript" src="<?php echo ROOT_URL,SCRIPT_PATH; ?>materialize.min.js"></script>
  <!--prism-->
  <script type="text/javascript" src="<?php echo ROOT_URL,SCRIPT_PATH; ?>plugins/prism/prism.js"></script>
  <!--scrollbar-->
  <script type="text/javascript" src="<?php echo ROOT_URL,SCRIPT_PATH; ?>plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>

  <!--plugins.js - Some Specific JS codes for Plugin Settings-->
  <script type="text/javascript" src="<?php echo ROOT_URL,SCRIPT_PATH; ?>plugins.min.js"></script>

  <script type="text/javascript" src="<?php echo ROOT_URL,SCRIPT_PATH; ?>custom-script.js"></script>

</body>

</html>
