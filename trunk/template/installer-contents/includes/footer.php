<?php
//inizia la sessione se non è già iniziata
if (!isset($_SESSION)) {
  session_start();
}

//se la sessione non è presente, allora effettua il login
if(!isset($_SESSION['is_logged_in'])) {
  header('Location: ../../login.php');
}
?>
<footer class="page-footer">
    <div class="footer-copyright">
      <div class="container">
        <span>Progetto di ingegneria del software. Daniele Monte, Riccardo Nuzzone, Francesco Peragine, Alessandra Semeraro</span>
        </div>
    </div>
  </footer>
  <!-- END FOOTER -->

  <!-- ================================================
    Scripts
    ================================================ -->

  <!-- jQuery Library -->
  <script type="text/javascript" src="<?php echo ROOT_URL.SCRIPT_PATH; ?>plugins/jquery-1.11.2.min.js"></script>
  <!--materialize js-->
  <script type="text/javascript" src="<?php echo ROOT_URL.SCRIPT_PATH; ?>materialize.js"></script>
  <!--prism-->
  <script type="text/javascript" src="<?php echo ROOT_URL.SCRIPT_PATH; ?>plugins/prism/prism.js"></script>
  <!--scrollbar-->
  <script type="text/javascript" src="<?php echo ROOT_URL.SCRIPT_PATH; ?>plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>

  <!-- data-tables -->
  <script type="text/javascript" src="<?php echo ROOT_URL.SCRIPT_PATH; ?>plugins/data-tables/js/jquery.dataTables.js"></script>
  <script type="text/javascript" src="<?php echo ROOT_URL.SCRIPT_PATH; ?>plugins/data-tables/data-tables-script.js"></script>

  <!--plugins.js - Some Specific JS codes for Plugin Settings-->
  <script type="text/javascript" src="<?php echo ROOT_URL.SCRIPT_PATH; ?>plugins.js"></script>
  <script type="text/javascript" src="<?php echo ROOT_URL.SCRIPT_PATH; ?>custom-script.js"></script>
 
  <!-- sweetalert -->
  <script type="text/javascript" src="<?php echo ROOT_URL.SCRIPT_PATH; ?>plugins/sweetalert/sweetalert.min.js"></script>
 
  <script>
      /*Show entries on click hide*/
      $(document).ready(function(){
          $(".dropdown-content.select-dropdown li").on( "click", function() {
              var that = this;
              setTimeout(function(){
              if($(that).parent().hasClass('active')){
                      $(that).parent().removeClass('active');
                      $(that).parent().hide();
              }
              },100);
          });

                   
      });

      /*
      * Questa funzione viene chiamata una volta cliccato sul pulsante "x" in una delle tabelle.
      * Dato l'url della pagina .php che si occupa della chiamata alla funzione che interroga il db
      * e l'id dell'oggetto che si intende eliminare, questa funzione fa comparire una finestra che
      * chiede all'utente se è sicuro dell'azione che sta per compiere.
      */
      function deleteSensor(url, id) {
        swal({
          title: "Sei sicuro?",
          text: "Non sarai in grado di recuperare i dati eliminati!",
          type: "warning",
          showCancelButton: true,
          cancelButtonText: 'Annulla',
          confirmButtonColor: '#DD6B55',
          confirmButtonText: 'Sì, elimina!',
          closeOnConfirm: false

        },
        function(){
          $.ajax({
            url: url,
            type: 'POST',
            data: {id:id, action: 'delete'},
            success: function(data) {
              swal("Eliminato!", "Eliminazione riuscita con successo!", "success");
              $("button.confirm").on("click", function(){
                location.reload();
              });
            }
          });        
        });
      } 

  </script>


</body>

</html>