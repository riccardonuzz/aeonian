<?php
require_once("DBManager.php");
require_once("interfaces/ILoginManager.php");

class LoginManager implements ILoginManager{
    private $database;


     /*
     * Crea l'oggetto del Gestore Dababase
     */
    function __construct(){
        $this->database = new DBManager();
    }



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




   
    function logout(){
        session_destroy();
        header('Location: '.ROOT_URL.'/index.php');
    }


}
