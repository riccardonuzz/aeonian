<?php
require_once 'DBManager.php' ;
require_once 'interfaces/IUsersManager.php';


class UsersManager implements IUsersManager{
    public $database;
    /*
     * Crea l'oggetto del Gestore Dababase
     */
    public function __construct(){
        $this->database = new DBManager();
    }
   
    public function registraUtente($post){
        //controllo se uno di questi campi è vuoto
        if(empty($post['nome']) || empty($post['cognome']) || empty($post['email']) || empty($post['password']) || empty($post['numerotelefono']) || $post['ruolo']===0 || empty($post['codicefiscale'])) {
            return array(
                'error' => 1,
                'values' => array (
                    'nome' => $post['nome'],
                    'cognome' => $post['cognome'],
                    'email' => $post['email'],
                    'ruolo' => $post['ruolo'],
                    'numerotelefono' => $post['numerotelefono'],
                    'codicefiscale' => $post['codicefiscale']
                )
            );
        }
		
        //controllo che la password rispetti l'espressione regolare
        if(preg_match('#(?=.*[\d\W])(?=.*[a-z])(?=.*[A-Z]).{8,100}#', $post['password'])===0){
            return array(
                'error' => 2,
                'values' => array (
                    'nome' => $post['nome'],
                    'cognome' => $post['cognome'],
                    'email' => $post['email'],
                    'ruolo' => $post['ruolo'],
                    'numerotelefono' => $post['numerotelefono'],
                    'codicefiscale' => $post['codicefiscale']
                )
            );
        }
       $password = password_hash($post['password'], PASSWORD_BCRYPT, array('cost' => 13));
       //controllo che l'utente esista in base ad email e codice fiscale
       if($this->userAlreadyExists($post['email'], $post['codicefiscale'], 0)===true){
            return array(
                'error' => 3,
                'values' => array (
                    'nome' => $post['nome'],
                    'cognome' => $post['cognome'],
                    'email' => $post['email'],
                    'ruolo' => $post['ruolo'],
                    'numerotelefono' => $post['numerotelefono'],
                    'codicefiscale' => $post['codicefiscale']
                )
            );
       }
       //controllo che il numero di telefono non sia stato inserito
       if($this->phoneNumberAlreadyExists($post, 0)===true){
            return array(
                'error' => 4,
                'values' => array (
                    'nome' => $post['nome'],
                    'cognome' => $post['cognome'],
                    'email' => $post['email'],
                    'ruolo' => $post['ruolo'],
                    'numerotelefono' => $post['numerotelefono'],
                    'codicefiscale' => $post['codicefiscale']
                )
            );
       }
       //Inserto into MySql
       $this->database->query('INSERT INTO utente VALUES (:codicefiscale, :email, :password, :nome, :cognome, :ruolo)');
       $this->database->bind(':codicefiscale', $post['codicefiscale']);
       $this->database->bind(':email', $post['email']);
       $this->database->bind(':password', $password);
       $this->database->bind(':nome', $post['nome']);
       $this->database->bind(':cognome', $post['cognome']);
       $this->database->bind(':ruolo', $post['ruolo']);
       $this->database->execute();
       $this->database->query('INSERT INTO telefono VALUES (:numerotelefono, :utente)');
       $this->database->bind(':numerotelefono', $post['numerotelefono']);
       $this->database->bind(':utente', $post['codicefiscale']);
       $this->database->execute();
       for($i=0; $i<20; $i++){
           if(isset($post['numerotelefono'.$i]) && !empty($post['numerotelefono'.$i])){
            $this->database->query('INSERT INTO telefono VALUES (:numerotelefono, :utente)');
            $this->database->bind(':numerotelefono', $post['numerotelefono'.$i]);
            $this->database->bind(':utente', $post['codicefiscale']);
            $this->database->execute();
           }
       }
       return array(
        'error' => 0
        );
    }
    
    
   
    public function modificaUtente($post){
        if(empty($post['nome']) || empty($post['cognome']) || empty($post['email']) || empty($post['numerotelefono100'])) {
            return array (
                'error' => 1,
                'codicefiscale' => $post['codicefiscale']
            );
        }
        //controllo che l'utente esista in base ad email e codice fiscale
        if($this->userAlreadyExists($post['email'], $post['codicefiscale'], 1)===true){
            return array(
                'error' => 3,
                'values' => array (
                    'nome' => $post['nome'],
                    'cognome' => $post['cognome'],
                    'email' => $post['email'],
                    'ruolo' => $post['ruolo'],
                    'numerotelefono' => $post['numerotelefono'],
                    'codicefiscale' => $post['codicefiscale']
                )
            );
        }
        //controllo che il numero di telefono non sia stato inserito
        if($this->phoneNumberAlreadyExists($post, 1)===true){
            return array(
                'error' => 4,
                'values' => array (
                    'nome' => $post['nome'],
                    'cognome' => $post['cognome'],
                    'email' => $post['email'],
                    'ruolo' => $post['ruolo'],
                    'numerotelefono' => $post['numerotelefono'],
                    'codicefiscale' => $post['codicefiscale']
                )
            );
        }
        if(empty($post['password'])===true){
            //Inserto into MySql
            $this->database->query('UPDATE utente SET Email=:email, Nome=:nome, Cognome=:cognome WHERE CodiceFiscale=:codicefiscale');
        }
        else{
            if(preg_match('#(?=.*[\d\W])(?=.*[a-z])(?=.*[A-Z]).{8,100}#', $post['password'])===0){
                return array(
                    'error' => 2,
                    'codicefiscale' => $post['codicefiscale']
                );
            }
            $password = password_hash($post['password'], PASSWORD_BCRYPT, array('cost' => 13));
            //Inserto into MySql
            $this->database->query('UPDATE utente SET Email=:email, Nome=:nome, Cognome=:cognome, Password=:password WHERE CodiceFiscale=:codicefiscale');
            $this->database->bind(':password', $password);
        }
        $this->database->bind(':codicefiscale', $post['codicefiscale']);
        $this->database->bind(':email', $post['email']);
        $this->database->bind(':nome', $post['nome']);
        $this->database->bind(':cognome', $post['cognome']);
        $this->database->execute();
        //vengono prima eliminati i numeri e poi reinseriti. Troppo complicato verificare quali numeri ci sono già e quali modificare
        $this->database->query('DELETE FROM telefono WHERE Utente=:codicefiscale');
        $this->database->bind(':codicefiscale', $post['codicefiscale']);
        $this->database->execute();
        /* I numeri di telefono vengono presi dal DB e visualizzati nella pagina user-edit.php. ogni numero di telefono ha un campo name='numerotelefonoN' dove N va da 100 in poi. Perchè parte da 100? (Solo nella pagina user-edit.php) Perchè nel caso in cui si scelga di aggiungere un ulteriore numero di telefono rispetto a quelli già presenti, avremmo altrimenti due campi con name='numerotelefono0'. Il ciclo quindi inserisce tutti i numeri di telefono con id che va da 0 a 200 (da 100 in poi sono quelli che erano già stati impostati, da 0 in poi ci sono quelli aggiungi durante la modifica) */
 
        for($i=0; $i<200; $i++){
            if(isset($post['numerotelefono'.$i]) && !empty($post['numerotelefono'.$i])){
                $this->database->query('INSERT INTO telefono VALUES (:numerotelefono, :utente)');
                $this->database->bind(':numerotelefono', $post['numerotelefono'.$i]);
                $this->database->bind(':utente', $post['codicefiscale']);
                $this->database->execute();
            }
        }
        
        
        return $post['codicefiscale'];
    }
    
    public function trovaUtente($userId){
        //Cerco l'utente e prendo i dati dal database
        $this->database->query('SELECT utente.CodiceFiscale AS CodiceFiscale, utente.Nome AS Nome, Cognome, Email, ruolo.Nome AS Ruolo FROM utente JOIN ruolo ON utente.Ruolo=ruolo.IDRuolo WHERE CodiceFiscale = :codicefiscale');
        $this->database->bind(':codicefiscale', $userId);
        $row = $this->database->SingleResultSet();
        return $row;
    }
   
    public function getUtenti(){
        //Prendo le info dell'utente
        $this->database->query('SELECT CodiceFiscale, Cognome, Nome FROM utente');
        $row = $this->database->resultSet();
        return $row;
    }
   
    public function getClienti(){
        //Prendo le info dell'utente
        $this->database->query('SELECT CodiceFiscale, Cognome, Nome FROM utente WHERE Ruolo = 2');
        $row = $this->database->resultSet();
        return $row;
    }
    
   
    public function getRuoli(){
        //Ritorna i ruoli
        $this->database->query('SELECT * FROM ruolo');
        $row = $this->database->resultSet();
        return $row;
    }
    
    public function getNumeriTelefono($userId){
        //Cerco l'utente e prendo i dati dal database
        $this->database->query('SELECT * from telefono WHERE Utente = :codicefiscale');
        $this->database->bind(':codicefiscale', $userId);
        $row = $this->database->resultSet();
        return $row;
    }
    
    public function userAlreadyExists($email, $codicefiscale, $editFlag){
        if($editFlag===true){
            $this->database->query('SELECT * FROM utente WHERE CodiceFiscale <> :codicefiscale AND Email = :email');
        }
        else {
            $this->database->query('SELECT * FROM utente WHERE CodiceFiscale = :codicefiscale OR Email = :email');
        }
        $this->database->bind(':codicefiscale', $codicefiscale);
        $this->database->bind(':email', $email);
        $row = $this->database->resultSet();
        if(empty($row)===false) {
            return 1;
        }
        else {
            return 0;
        }
    }
    
    public function phoneNumberAlreadyExists($post, $editFlag) {
        $found=0;
        if($editFlag===true){
            $this->database->query('SELECT * FROM telefono WHERE Utente <> :codicefiscale AND Numero = :numerotelefono');
            $this->database->bind(':codicefiscale', $post['codicefiscale']);
            $this->database->bind(':numerotelefono', $post['numerotelefono100']);  
            //echo 'Codice fiscale: '.$post['codicefiscale'].'<br>Numero telefono 100: '.$post['numerotelefono100'].'<br>';   
        }
        else {
            $this->database->query('SELECT * FROM telefono WHERE Numero = :numerotelefono');
            $this->database->bind(':numerotelefono', $post['numerotelefono']);
        }
        $row = $this->database->resultSet();
        if(empty($row)===false) {
            return 1;
        }
		
        //print_r($row);
        for($i=0; $i<200; $i++){
            if(isset($post['numerotelefono'.$i])===true && empty($post['numerotelefono'.$i])===false){
                if($editFlag===true){
                    $this->database->query('SELECT * FROM telefono WHERE Utente <> :codicefiscale AND Numero = :numerotelefono');
                    $this->database->bind(':codicefiscale', $post['codicefiscale']);                                
                }
                else {
                    $this->database->query('SELECT * FROM telefono WHERE Numero = :numerotelefono');
                }
                $this->database->bind(':numerotelefono', $post['numerotelefono'.$i]);    
                $row = $this->database->resultSet();
				
                if(empty($row)===false){
                    $found = 1;
                }
            }
        }
        return $found;
    }

	
}

