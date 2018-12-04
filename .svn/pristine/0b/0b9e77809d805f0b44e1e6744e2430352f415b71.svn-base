<?php
require_once "DBManager.php";
require_once "interfaces/ILoginManager.php";

class LoginManager implements ILoginManager{
    public $database;


     /*
     * Crea l'oggetto del Gestore Dababase
     */
    function __construct(){
        $this->database = new DBManager();
    }

    function login($post){
	           
        //compare Login
        if( empty( $post ) === false ) {
           //Insert into MySql
           $this->database->query("SELECT * FROM utente WHERE email = :email");
           $this->database->bind(":email", $post['email']);
           $row = $this->database->singleResultSet();

			if( empty( $row ) === false  ) {
			
		// Per registrare il primo utente, inserire la stampa della propria password nel db come testo
		/*
		$password = password_hash($post['password'], PASSWORD_BCRYPT, array('cost' => 13));
		echo $password;
		die();		
		*/
					
			if( password_verify( $post['password'], $row['Password'] ) ) {

				   $_SESSION['is_logged_in'] = true;
				   $_SESSION['user_data'] = array (
					   'nome' => $row['Nome'],
					   'cognome' => $row['Cognome'],
					   'email' => $row['Email'],
					   'codicefiscale' => $row['CodiceFiscale'],
					   'ruolo' => $row['Ruolo']
				   );
				   
				   switch( $row['Ruolo'] ) {
					   case '1': return AMMINISTRATORE;
						break;
					   case '2': return CLIENTE;
						break;
					   default: return INSTALLATORE;
						break;
				   }
				   
				//	return $row['Ruolo'];

			   }
			   
			   else {
				   return 0;
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
