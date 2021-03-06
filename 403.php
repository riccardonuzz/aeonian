<?php require_once 'config.php'; ?>
<html lang="it">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="msapplication-tap-highlight" content="no">
  <title>403</title>

  <!-- Favicons-->
  <link rel="icon" href="images/favicon/favicon-32x32.png" sizes="32x32">
  <!-- Favicons-->
  <link rel="apple-touch-icon-precomposed" href="images/favicon/apple-touch-icon-152x152.png">
  <!-- For iPhone -->
  <meta name="msapplication-TileColor" content="#00bcd4">
  <meta name="msapplication-TileImage" content="images/favicon/mstile-144x144.png">
  <!-- For Windows Phone -->


  <!-- CORE CSS-->
  
  <link href="<?php echo ROOT_URL,STYLE_PATH;?>materialize.min.css" type="text/css" rel="stylesheet" media="screen,projection">
  <link href="<?php echo ROOT_URL,STYLE_PATH;?>style.min.css" type="text/css" rel="stylesheet" media="screen,projection">
    <!-- Custome CSS-->    
    <link href="<?php echo ROOT_URL,STYLE_PATH;?>custom/custom.min.css" type="text/css" rel="stylesheet" media="screen,projection">
  <link href="<?php echo ROOT_URL,STYLE_PATH;?>layouts/page-center.css" type="text/css" rel="stylesheet" media="screen,projection">


  <!-- INCLUDED PLUGIN CSS ON THIS PAGE -->
  <link href="<?php echo ROOT_URL,SCRIPT_PATH;?>plugins/prism/prism.css" type="text/css" rel="stylesheet" media="screen,projection">
  <link href="<?php echo ROOT_URL,SCRIPT_PATH;?>plugins/perfect-scrollbar/perfect-scrollbar.css" type="text/css" rel="stylesheet" media="screen,projection">
  
</head>

<body class="cyan">
 



  <div id="error-page">

    <div class="row">
      <div class="col s12">
        <div class="browser-window">
          <div class="top-bar">
            <div class="circles">
              <div id="close-circle" class="circle"></div>
              <div id="minimize-circle" class="circle"></div>
              <div id="maximize-circle" class="circle"></div>
            </div>
          </div>
          <div class="content">
            <div class="row">
              <div id="site-layout-example-top" class="col s12">
                <p class="flat-text-logo center white-text caption-uppercase">Accesso non autorizzato.</p>
              </div>
              <div id="site-layout-example-right" class="col s12 m12 l12">
                <div class="row center">
                  <h1 class="text-long-shadow col s12">403</h1>
                </div>
                <div class="row center">
                  <p class="center white-text col s12">It seems that this page doesn’t exist.</p>
                  <p class="center s12"><button onclick="goBack()" class="btn waves-effect waves-light">Back</button> <a href="index.html" class="btn waves-effect waves-light">Homepage</a>
                    </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>


  <!-- ================================================
    Scripts
    ================================================ -->

  <!-- jQuery Library -->
  <script type="text/javascript" src="<?php echo ROOT_URL,SCRIPT_PATH;?>plugins/jquery-1.11.2.min.js"></script>
  <!--materialize js-->
  <script type="text/javascript" src="<?php echo ROOT_URL,SCRIPT_PATH;?>materialize.min.js"></script>
  <!--prism-->
  <script type="text/javascript" src="<?php echo ROOT_URL,SCRIPT_PATH;?>plugins/prism/prism.js"></script>
  <!--scrollbar-->
  <script type="text/javascript" src="<?php echo ROOT_URL,SCRIPT_PATH;?>plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>

      <!--plugins.js - Some Specific JS codes for Plugin Settings-->
    <script type="text/javascript" src="<?php echo ROOT_URL,SCRIPT_PATH;?>plugins.min.js"></script>
    <!--custom-script.js - Add your own theme custom JS-->
    <script type="text/javascript" src="<?php echo ROOT_URL,SCRIPT_PATH;?>custom-script.js"></script>
  
  <script type="text/javascript">
    function goBack() {
      window.history.back();
    }
  </script>
</body>

</html>