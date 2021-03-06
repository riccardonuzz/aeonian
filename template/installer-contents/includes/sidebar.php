<?php
//inizia la sessione se non è già iniziata
if (!isset($_SESSION)) {
    session_start();
  }
  
  //se la sessione non è presente, allora effettua il login
  if(!isset($_SESSION['is_logged_in'])) {
    header('Location: '.ROOT_URL.TEMPLATE_PATH.'login.php');
  }

?>
<!--CUSTOM CSS-->
<link href="<?php echo ROOT_URL,STYLE_PATH; ?>custom/custom.css" type="text/css" rel="stylesheet" media="screen,projection">

<aside id="left-sidebar-nav">
    <ul id="slide-out" class="side-nav fixed leftside-navigation custom-side-nav">
        <li id="bg-user" class="user-details cyan darken-2">
            <div class="row">
                <div class="col col s8 m8 l12">                        
                    <a class="btn-flat dropdown-button waves-effect waves-light white-text profile-btn" href="#" data-activates="profile-dropdown"><?php echo htmlspecialchars($_SESSION['user_data']['nome'], ENT_QUOTES)," "; ?></a>
                    <p class="user-roal">Installatore</p>
                </div>
            </div>
        </li>
        <li class="bold"><a href="installerhome.php" class="waves-effect waves-cyan admin-homepage"><i class="mdi-action-home"></i> Homepage</a>
        </li>
        <li class="bold"><a href="systems-management.php" class="waves-effect waves-cyan admin-users-management"><i class="mdi-communication-business"></i> Gestione impianti</a>
        </li>
        <li class="bold"><a href="environments-management.php" class="waves-effect waves-cyan admin-users-management"><i class="mdi-action-store"></i> Panoramica ambienti</a>
        </li>
        <li class="bold"><a href="sensors-management.php" class="waves-effect waves-cyan admin-users-management"><i class="mdi-hardware-memory"></i> Panoramica sensori</a>
        </li>
        <li class="bold"><a href="<?php echo ROOT_URL,TEMPLATE_PATH,"login.php?logout=1"; ?>"><i class="mdi-hardware-keyboard-tab"></i> Logout</a>
        </li>
    </ul>
    <a href="#" data-activates="slide-out" class="sidebar-collapse btn-floating btn-medium waves-effect waves-light hide-on-large-only orange-style"><i class="mdi-navigation-menu" ></i></a>
</aside>
      
