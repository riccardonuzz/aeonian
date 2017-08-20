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
    <script type="text/javascript" src="<?php echo ROOT_URL.SCRIPT_PATH; ?>jquery-1.11.2.min.js"></script>    
    <!--materialize js-->
    <script type="text/javascript" src="<?php echo ROOT_URL.SCRIPT_PATH; ?>materialize.js"></script>
    <!--prism-->
    <script type="text/javascript" src="<?php echo ROOT_URL.SCRIPT_PATH; ?>prism.js"></script>
    <!--scrollbar-->
    <script type="text/javascript" src="<?php echo ROOT_URL.SCRIPT_PATH; ?>plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <!-- chartist -->
    <script type="text/javascript" src="<?php echo ROOT_URL.SCRIPT_PATH; ?>plugins/chartist-js/chartist.min.js"></script>   
    <!-- data-tables -->
    <script type="text/javascript" src="<?php echo ROOT_URL.SCRIPT_PATH; ?>plugins/data-tables/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="<?php echo ROOT_URL.SCRIPT_PATH; ?>plugins/data-tables/data-tables-script.js"></script>
    <!--plugins.js - Some Specific JS codes for Plugin Settings-->
    <script type="text/javascript" src="<?php echo ROOT_URL.SCRIPT_PATH; ?>plugins.js"></script>
 
</body>

</html>