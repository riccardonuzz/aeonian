<?php
//inizia la sessione se non è già iniziata
if (!isset($_SESSION)) {
 session_start();
}

//se la sessione non è presente, allora effettua il login
if(!isset($_SESSION['is_logged_in'])) {
 header('Location: '.ROOT_URL.TEMPLATE_PATH.'login.php');
}

if(isset($_SESSION['user_data']) && $_SESSION['user_data']['ruolo']!=1) {
 header('Location: '.ROOT_URL.'/index.php');
}

?>
<!--CUSTOM CSS-->
<link href="<?php echo ROOT_URL,STYLE_PATH; ?>custom/custom.css" type="text/css" rel="stylesheet" media="screen,projection">

<aside id="left-sidebar-nav">
    <ul id="slide-out" class="side-nav fixed leftside-navigation">
        <li class="user-details cyan darken-2">
            <div class="row">
                <div class="col col s8 m8 l12">
                    <a class="btn-flat waves-effect waves-light white-text profile-btn" href="#"><?php echo htmlspecialchars($_SESSION['user_data']['nome'], ENT_QUOTES)," "; ?></a>
                    <p class="user-roal">Amministratore</p>
                </div>
            </div>
        </li>
        <li class="bold"><a href="adminhome.php" class="waves-effect waves-cyan admin-homepage"><i class="mdi-action-home"></i> Homepage</a>
        </li>
        <li class="bold"><a href="users-management.php" class="waves-effect waves-cyan admin-users-management"><i class="mdi-social-people"></i> Gestisci utenti</a>
        </li> 
        <li class="bold"><a href="<?php echo ROOT_URL,TEMPLATE_PATH,"login.php?logout=1"; ?>"><i class="mdi-hardware-keyboard-tab"></i> Logout</a>
        </li>
    </ul>
    <a href="#" data-activates="slide-out" class="sidebar-collapse btn-floating btn-medium waves-effect waves-light hide-on-large-only orange-style"><i class="mdi-navigation-menu" ></i></a>
</aside>
      
