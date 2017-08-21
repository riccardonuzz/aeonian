<?php
require_once("DBManager.php");

class UsersManager {
    private $database;

    /*
     * Crea l'oggetto del Gestore Dababase
     */
    public function __construct(){
        $this->database = new DBManager();
    }




    /**
       * 
       * registra un utente
       *
       * @param Array $post Contiene le informazioni dell'utente che vengono "postate"
       * @return void
       */
    public function registraUtente($post){

       $password = md5($post['password']);
       //Inserto into MySql
       $this->database->query("INSERT INTO utente VALUES (:codicefiscale, :email, :password, :nome, :cognome, :ruolo)");
       $this->database->bind(":codicefiscale", $post['codicefiscale']);
       $this->database->bind(":email", $post['email']);
       $this->database->bind(":password", $password);
       $this->database->bind(":nome", $post['nome']);
       $this->database->bind(":cognome", $post['cognome']);
       $this->database->bind(":ruolo", $post['ruolo']);
       $this->database->execute();

       $this->database->query("INSERT INTO telefono VALUES (:numerotelefono, :utente)");
       $this->database->bind(":numerotelefono", $post['numerotelefono']);
       $this->database->bind(":utente", $post['codicefiscale']);
       $this->database->execute();

       for($i=0; $i<20; $i++){
           if(isset($post['numerotelefono'.$i])){
            $this->database->query("INSERT INTO telefono VALUES (:numerotelefono, :utente)");
            $this->database->bind(":numerotelefono", $post['numerotelefono'.$i]);
            $this->database->bind(":utente", $post['codicefiscale']);
            $this->database->execute();
           }
       }


    }
    



    /**
       * 
       * Modifica un utente pre-registrato
       *
       * @param Array $post  Contiene le informazioni dell'utente che si andranno a modificare (escluso il CodiceFiscale che è una primary key, ed il ruolo)
       * @return Array ("codicefiscale" => $post['codicefiscale'], "error" => 1); se ci sono campi vuoti
       * @return string $post['codicefiscale'] se l'operazione va a buon fine (Utilizzato per reindirizzare alla pagina dei dettagli)
       */
    public function modificaUtente($post){
        if(empty($post['nome']) || empty($post['cognome']) || empty($post['email']) || empty($post['numerotelefono100'])) {
            return array (
                "codicefiscale" => $post['codicefiscale'],
                "error" => 1
            );
        }

        if(empty($post['password'])){
            //Inserto into MySql
            $this->database->query("UPDATE utente SET Email=:email, Nome=:nome, Cognome=:cognome WHERE CodiceFiscale=:codicefiscale");
        }

        else{
            $password = md5($post['password']);
            //Inserto into MySql
            $this->database->query("UPDATE utente SET Email=:email, Nome=:nome, Cognome=:cognome, Password=:password WHERE CodiceFiscale=:codicefiscale");
            $this->database->bind(":password", $password);
        }

        $this->database->bind(":codicefiscale", $post['codicefiscale']);
        $this->database->bind(":email", $post['email']);
        $this->database->bind(":nome", $post['nome']);
        $this->database->bind(":cognome", $post['cognome']);
        $this->database->execute();


        //vengono prima eliminati i numeri e poi reinseriti. Troppo complicato verificare quali numeri ci sono già e quali modificare
        $this->database->query("DELETE FROM telefono WHERE Utente=:codicefiscale");
        $this->database->bind(":codicefiscale", $post['codicefiscale']);
        $this->database->execute();

        /* I numeri di telefono vengono presi dal DB e visualizzati nella pagina user-edit.php. ogni numero di telefono ha un campo name="numerotelefonoN" dove N va da 100 in poi. Perchè parte da 100? (Solo nella pagina user-edit.php) Perchè nel caso in cui si scelga di aggiungere un ulteriore numero di telefono rispetto a quelli già presenti, avremmo altrimenti due campi con name="numerotelefono0". Il ciclo quindi inserisce tutti i numeri di telefono con id che va da 0 a 200 (da 100 in poi sono quelli che erano già stati impostati, da 0 in poi ci sono quelli aggiungi durante la modifica) */
 
        for($i=0; $i<200; $i++){
            if(isset($post['numerotelefono'.$i]) && !empty($post['numerotelefono'.$i])){
                $this->database->query("INSERT INTO telefono VALUES (:numerotelefono, :utente)");
                $this->database->bind(":numerotelefono", $post['numerotelefono'.$i]);
                $this->database->bind(":utente", $post['codicefiscale']);
                $this->database->execute();
            }
        }
        
        
        return $post['codicefiscale'];
    }




    /**
       * 
       * Trova un utente
       *
       * @param string $userId  indica il codice fiscale con il quale ricercare l'utente
       * @return Array $row  contiene le informazioni dell'utente
       */
    public function trovaUtente($userId){
        //Cerco l'utente e prendo i dati dal database
        $this->database->query("SELECT utente.CodiceFiscale AS CodiceFiscale, utente.Nome AS Nome, Cognome, Email, ruolo.Nome AS Ruolo FROM utente JOIN ruolo ON utente.Ruolo=ruolo.IDRuolo WHERE CodiceFiscale = :codicefiscale");
        $this->database->bind(":codicefiscale", $userId);
        $row = $this->database->SingleResultSet();
        return $row;
    }



    /**
       * 
       * Restituisce lista di utenti
       *
       * @return Array $row  lista di tutti gli utenti
       */
    public function getUtenti(){
        //Prendo le info dell'utente
        $this->database->query("SELECT CodiceFiscale, Cognome, Nome FROM utente");
        $row = $this->database->resultSet();
        return $row;
    }

    
    /**
       * 
       * Restituisce lista di utenti
       *
       * @return Array $row  lista di tutti gli utenti
       */
    public function getRuoli(){
        //Ritorna i ruoli
        $this->database->query("SELECT * FROM ruolo");
        $row = $this->database->resultSet();
        return $row;
    }



    
     /**
       * 
       * Prende numeri di telefono di un utente
       * @param string $userId  indica il codice fiscale con il quale ricercare l'utente
       * @return Array $row  lista di tutti i numeri di telefono di un utente
       */
    public function getNumeriTelefono($userId){
        //Cerco l'utente e prendo i dati dal database
        $this->database->query("SELECT * from telefono WHERE Utente = :codicefiscale");
        $this->database->bind(":codicefiscale", $userId);
        $row = $this->database->resultSet();
        return $row;
    }
}