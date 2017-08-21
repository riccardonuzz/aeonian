<?php
require_once("DBManager.php");

class LoginManager {
    private $database;


     /*
     * Crea l'oggetto del Gestore Dababase
     */
    function __construct(){
        $this->database = new DBManager();
    }




       /**
       * 
       * consente di effettuare il login
       *
       * @param Array $post Contiene le informazioni dell'utente che vengono "postate"
       * @return int  0 se username e/o password sono errati, 1 se è un amministratore, 2 se è un cliente, 3 se è un installatore
       */
    function login($post){
        $password = md5($post['password']);
           
        //compare Login
        if($post) {
           //Insert into MySql
           $this->database->query("SELECT * FROM utente WHERE email = :email AND password = :password");
           $this->database->bind(":email", $post['email']);
           $this->database->bind(":password", $password);
           $row = $this->database->singleResultSet();
            
           if($row){
               $_SESSION['is_logged_in'] = true;
               $_SESSION['user_data'] = array (
                   "nome" => $row['Nome'],
                   "cognome" => $row['Cognome'],
                   "email" => $row['Email'],
                   "codicefiscale" => $row['CodiceFiscale'],
                   "ruolo" => $row['Ruolo']
               );
    
               if($row['Ruolo']==1) {
                    return 1;
               } else if ($row['Ruolo']==2) {
                    return 2;
               } else if ($row['Ruolo']==3) {
                    return 3;
               }
           }
    
           else {
               return 0;
           }
        }
    
    }




    /**
       * 
       * consente di eseguire il logout distruggendo la sessione
       *
       * @return void
       */
    function logout(){
        session_destroy();
        header('Location: '.ROOT_URL.'/index.php');
    }


}
