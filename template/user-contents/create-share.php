<?php
require_once '../../config.php'; 
require '../../classes/SharesManager.php';
require '../../classes/ThirdPartiesManager.php';

session_start();

//se la sessione non è presente, allora effettua il login
if(!isset($_SESSION['is_logged_in'])) {
  header('Location: '.ROOT_URL.'/template/login.php');
}

if(isset($_SESSION['user_data']) && $_SESSION['user_data']['ruolo']!=2) {
  header('Location: '.ROOT_URL.'/index.php');
}

$sharesManager = new SharesManager();



//Gestore terze parti
$thirdPartiesManager = new ThirdPartiesManager();
$terzeparti = $thirdPartiesManager->getTerzeParti($_SESSION['user_data']['codicefiscale']);

$get = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);


if(isset($_GET['chlist'])){
    echo htmlspecialchars(json_encode($thirdPartiesManager->getCanaliTerzaParte($_GET['chlist']),JSON_UNESCAPED_SLASHES, JSON_HEX_APOS));
	return;
}

if(!$sharesManager->checkProperty($_GET['id'], $_SESSION['user_data']['codicefiscale'])) {
  header('Location: '.ROOT_URL.'/403.php');
}

//quando ricevo un POST sulla pagina
if(isset($_POST['submit'])) {
  $id = rawurlencode($_GET['id']);
  $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
  $checkValue = $sharesManager->creaCondivisione($post, $_GET['id']);
  
  $idsensore = rawurlencode($checkValue['idsensore']);

  if($checkValue['error']==1){
    $_SESSION['message'] = 'Ci sono dei campi che non sono stati compilati.';
    header('Location: create-share.php?id='.$idsensore);
    return;
  }

  if($checkValue['error']==2){
    $_SESSION['message'] = 'Stai già condividendo le rilevazioni con questo canale! Scegline un altro.';
    header('Location: create-share.php?id='.$idsensore);
    return;
  }


  else {
	  if(isset($id)===true){
		header('Location: sensor-details.php?id='.$id);
	  }
	  else{
		  echo "Errore.";
	  }
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
              <h5 class="breadcrumbs-title">Crea condivisione</h5>
              <ol class="breadcrumbs">
              <li><a href="<?php echo ROOT_URL.TEMPLATE_PATH?>user-contents/userhome.php">Dashboard</a></li>
              <li><a href="<?php echo ROOT_URL.TEMPLATE_PATH?>user-contents/shares-management.php">Gestione condivisioni</a></li>
              <li><a href="#">Crea condivisione</a></li>
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
                    
                      
                        <form class="col s12" method="POST" action="<?php echo $_SERVER['PHP_SELF']."?id=".$_GET['id']; ?>">

                          <div class="row">
                            <div class="col s6">
                                <br>
                                <p class="caption">Seleziona terze parti</p>
                            </div>
                          </div>

                          <div class="row">
                                <div class="input-field col s6">
                                <select id="terzaparte" name="terzaparte">
                                        <option value="0" selected>Seleziona terza parte</option>
                                    
                                    <?php foreach($terzeparti as $terzaparte): ?>
                                        <option value="<?php echo $terzaparte['IDTerzaParte'] ?>"><?php echo $terzaparte['Nome'] ?></option>
                                    <?php endforeach;?>
                                </select>
                            </div>
                          </div>

                          <div class="row">
                                <div class="input-field col s6">
                                    <div id="channels"></div>
                                </div>
                          </div>
                          
                          <br><br>
                          <div class="row">
                          <div class="input-field col s6">
                            <a href="sensor-details.php?id=<?php echo $_GET['id'];?>" class="btn waves-effect orange-style white-text admin-create-user">Annulla</a>
                            </div>
                            <div class="input-field col s6">
                                <button class="btn cyan waves-effect waves-light right" type="submit" name="submit">Crea condivisione
                                  <i class="mdi-content-send right"></i>
                                </button>
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
      
      
<script>
 $('#terzaparte').change(function(){
	var chlist=$(this).val();
	// $.getJSON( "http://localhost/aeonian/template/user-contents/create-share.php?chlist="+chlist, function( data ) {
		// var content='<p class="caption">Seleziona canale</p>';
		
		// for(var i=0; i<data.length; i++){
			// content=content+'<p><input value="'+data[i].IDCanale+'" name="canale" type="radio" id="test'+(i+1)+'"><label for="test'+(i+1)+'">'+data[i].Nome+": "+data[i].Valore+'</label></p>';
		// }

		// $("#channels").html(content);

	// });
	
	$.ajax({
		type: "GET",
		url: "http://localhost/aeonian/template/user-contents/create-share.php?chlist="+chlist,
		// contentType: "application/json; charset=utf-8",
		//dataType: "json",
		success: function(data) {
				data = JSON.parse(data.replace(/&quot;/g,'"'));
			
			console.log(data);
			var content='<p class="caption">Seleziona canale</p>';
		
		    for(var i=0; i<data.length; i++){
			   content=content+'<p><input value="'+data[i].IDCanale+'" name="canale" type="radio" id="test'+(i+1)+'"><label for="test'+(i+1)+'">'+data[i].Nome+": "+data[i].Valore+'</label></p>';
		    }

		    $("#channels").html(content);
		},
		error: function (xhr, textStatus, errorThrown) {
			alert(textStatus);
		}
	});
})
</script>
