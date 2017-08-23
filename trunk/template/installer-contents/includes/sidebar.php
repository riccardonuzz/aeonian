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
<aside id="left-sidebar-nav">
          <ul id="slide-out" class="side-nav fixed leftside-navigation">
              <li class="user-details cyan darken-2">
                  <div class="row">
                      <div class="col col s8 m8 l12">
                          <ul id="profile-dropdown" class="dropdown-content">
                              <li><a href="user-details.php?id=<?php echo $_SESSION['user_data']['codicefiscale']; ?>"><i class="mdi-action-face-unlock"></i> Profilo</a>
                              </li>
                              <li><a href="#"><i class="mdi-communication-live-help"></i> Aiuto</a>
                              </li>
                          </ul>
                          <a class="btn-flat dropdown-button waves-effect waves-light white-text profile-btn" href="#" data-activates="profile-dropdown"><?php echo $_SESSION['user_data']['nome']." " ?><i class="mdi-navigation-arrow-drop-down right"></i></a>
                          <p class="user-roal">Installatore</p>
                      </div>
                  </div>
              </li>
              <li class="bold"><a href="installerhome.php" class="waves-effect waves-cyan admin-homepage"><i class="mdi-action-home"></i> Homepage</a>
              </li>
              <li class="bold"><a href="systems-management.php" class="waves-effect waves-cyan admin-users-management"><i class="mdi-social-people"></i> Gestisci impianti</a>
              </li>
              <li class="bold"><a href="<?php echo ROOT_URL.TEMPLATE_PATH."login.php?logout=1"; ?>"><i class="mdi-hardware-keyboard-tab"></i> Logout</a>
              </li>
          </ul>
          <a href="#" data-activates="slide-out" class="sidebar-collapse btn-floating btn-medium waves-effect waves-light hide-on-large-only darken-2"><i class="mdi-navigation-menu" ></i></a>
      </aside>
      