<?php

interface IUsersManager {


     /**
       * 
       * registra un utente
       *
       * @param array $post Contiene le informazioni dell'utente che vengono "postate"
       *
       * @return array  con error=1 se ci sono campi vuoti
       * @return array  con error=2 se la password non rispetta lo standard definito
       * @return array  con error=3 se la mail esiste già
       * @return array  con error=4 se i numeri di telefono inseriti sono già presenti nel sistema
       * @return array  con error=0 se è tutto ok
       */
       public function registraUtente($post);


        /**
    * 
    * Modifica un utente pre-registrato
    *
    * @param array $post  Contiene le informazioni dell'utente che si andranno a modificare (escluso il CodiceFiscale che è una primary key, ed il ruolo)
    *
    * @return array ("codicefiscale" => $post['codicefiscale'], "error" => 1); se ci sono campi vuoti
    * @return array ("codicefiscale" => $post['codicefiscale'], "error" => 2); se la password non rispetta l'espressione regolare
    * @return string $post['codicefiscale'] se l'operazione va a buon fine (Utilizzato per reindirizzare alla pagina dei dettagli)
    */
    public function modificaUtente($post);


     /**
       * 
       * Trova un utente
       *
       * @param string $userId  indica il codice fiscale con il quale ricercare l'utente
       * @return array $row  contiene le informazioni dell'utente
       */
       public function trovaUtente($userId);

    

      /**
       * 
       * Restituisce lista di utenti
       *
       * @return array $row  lista di tutti gli utenti
       */
       public function getUtenti();



    
       /**
       * 
       * Restituisce lista dei clienti
       *
       * @return array $row  lista di tutti i clienti
       */
      public function getClienti();




      /**
       * 
       * Restituisce lista di utenti
       *
       * @return array $row  lista di tutti gli utenti
       */
      public function getRuoli();




       /**
       * 
       * Prende numeri di telefono di un utente
       * @param string $userId  indica il codice fiscale con il quale ricercare l'utente
       * @return array $row  lista di tutti i numeri di telefono di un utente
       */
       public function getNumeriTelefono($userId);




      /**
       * 
       * Controlla che un utente esista o meno prima di essere inserito
       * @param string $email  indica la mail dell'utente
       * @param string $codiceficale  indica il codice fiscale con il quale ricercare l'utente
       * @param boolean $editFlag  se è uguale ad 1, controlla che un utente con codice fiscale diverso da quello corrente, non abbia la stessa mail
       *
       * @return boolean 1 se l'utente esiste già, 0 se non esiste
       */
       public function userAlreadyExists($email, $codicefiscale, $editFlag);




        /**
       * 
       * Controlla che un utente esista o meno prima di essere inserito
       * @param Array $post  Contiene le informazioni dell'utente
       * @param boolean $editFlag  se è uguale ad 1, controlla che un utente con codice fiscale diverso da quello corrente, non abbia la stesso numero di telefono
       * @return boolean 1 se uno o più numeri di telefono sono già presenti nel sistema, 0 se non sono presenti
       */
    public function phoneNumberAlreadyExists($post, $editFlag);
}