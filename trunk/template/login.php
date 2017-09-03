<?php
  require_once("../config.php");
  require("../classes/LoginManager.php");

  //Inizio sessione
  session_start();   

  $loginManager = new LoginManager();

  if(isset($_GET['logout'])){
    if($_GET['logout']==1){
      $loginManager->logout();
    }
  }


  if(isset($_POST['submit'])){
    $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
    $role = $loginManager->login($post);
    
    if($role==0) {
          $_SESSION['message'] = 'Username o password errati.';
          header('Location: '.ROOT_URL.'/index.php');
          exit;
    } else if($role==1) {
          header('Location: '.ROOT_URL.TEMPLATE_PATH.'admin-contents/adminhome.php');
    } else if ($role==2) {
          header('Location: '.ROOT_URL.TEMPLATE_PATH.'user-contents/userhome.php');
    } else if ($role==3) {
          header('Location: '.ROOT_URL.TEMPLATE_PATH.'installer-contents/installerhome.php');
    }

  }
      
  else{

      if(isset($_SESSION['is_logged_in'])) {
        if(isset($_SESSION['user_data']) && $_SESSION['user_data']['ruolo']==1) {
            header('Location: '.ROOT_URL.TEMPLATE_PATH.'admin-contents/adminhome.php');
      } else if (isset($_SESSION['user_data']) && $_SESSION['user_data']['ruolo']==2) {
            header('Location: '.ROOT_URL.TEMPLATE_PATH.'user-contents/userhome.php');
      } else if (isset($_SESSION['user_data']) && $_SESSION['user_data']['ruolo']==3) {
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
  <link rel="icon" href="images/favicon/favicon-32x32.png" sizes="32x32">
  <!-- Favicons-->
  <link rel="apple-touch-icon-precomposed" href="images/favicon/apple-touch-icon-152x152.png">
  <!-- For iPhone -->
  <meta name="msapplication-TileColor" content="#00bcd4">
  <meta name="msapplication-TileImage" content="images/favicon/mstile-144x144.png">
  <!-- For Windows Phone -->


  <!-- CORE CSS-->
  
  <link href="<?php echo ROOT_URL.STYLE_PATH; ?>materialize.css" type="text/css" rel="stylesheet" media="screen,projection">
  <link href="<?php echo ROOT_URL.STYLE_PATH; ?>style.css" type="text/css" rel="stylesheet" media="screen,projection">
  <link href="<?php echo ROOT_URL.STYLE_PATH; ?>layouts/page-center.css" type="text/css" rel="stylesheet" media="screen,projection">
  <link href="<?php echo ROOT_URL.STYLE_PATH; ?>custom/custom.min.css" type="text/css" rel="stylesheet" media="screen,projection">
   <link href="<?php echo ROOT_URL.STYLE_PATH; ?>custom/custom.css" type="text/css" rel="stylesheet" media="screen,projection">

  <!-- INCLUDED PLUGIN CSS ON THIS PAGE -->
  <link href="<?php echo ROOT_URL.SCRIPT_PATH; ?>plugins/prism/prism.css" type="text/css" rel="stylesheet" media="screen,projection">
</head>

<body class="space-cadet">
  
  <div id="login-page" class="row">

    <div class="col s12 z-depth-4 card-panel">

      <form class="login-form" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <div class="row">
          <div class="input-field col s12 center">
            <img src="images/login-logo.png" alt="" class="circle responsive-img valign profile-image-login">
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
                  if (isset($_SESSION['message']))
                  {
                      echo "<br><p class='red-text text-darken-2'>".$_SESSION['message']."</p>";
                      unset($_SESSION['message']);
                      unset($_SESSION['values']);
                  }
                ?>
              </div>
        </div>
        <div class="row">
          <div class="input-field col s12">
            <button class="btn queen-blue waves-effect waves-light login-button col s12" type="submit" name="submit">Login</button>
          </div>
        </div>
        <div class="row ">
          <div class="input-field col s12 custom-forgotten-div">
              <img id="logo-ae" src="<?php echo ROOT_URL.IMAGES_PATH; ?>aeonian-logo.png" alt="aeonian logo small">
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
  <script type="text/javascript" src="<?php echo ROOT_URL.SCRIPT_PATH; ?>plugins/jquery-1.11.2.min.js"></script>
  <!--materialize js-->
  <script type="text/javascript" src="<?php echo ROOT_URL.SCRIPT_PATH; ?>materialize.min.js"></script>
  <!--prism-->
  <script type="text/javascript" src="<?php echo ROOT_URL.SCRIPT_PATH; ?>plugins/prism/prism.js"></script>
  <!--scrollbar-->
  <script type="text/javascript" src="<?php echo ROOT_URL.SCRIPT_PATH; ?>plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>
  <!-- chartist -->
  <script type="text/javascript" src="<?php echo ROOT_URL.SCRIPT_PATH; ?>plugins/chartist-js/chartist.min.js"></script>   

  <!--plugins.js - Some Specific JS codes for Plugin Settings-->
  <script type="text/javascript" src="<?php echo ROOT_URL.SCRIPT_PATH; ?>plugins.min.js"></script>

  <script type="text/javascript" src="<?php echo ROOT_URL.SCRIPT_PATH; ?>custom-script.js"></script>

</body>

</html>