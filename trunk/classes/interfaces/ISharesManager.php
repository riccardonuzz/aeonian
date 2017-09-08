<?php

interface ISharesManager {

    /**
    * 
    * Crea una condivisione
    *
    * @param array $post  Contiene le informazioni della condivisione
    * @param string $codicefiscale  ID dell'utente al quale verrà assegnata la condivisione
    * @param int $idsensore  Codice del sensore
    *
    * @return array con "error = 1" se il form non è stato compilato correttamente,
    * @return array con "error = 2" se la condivisione esiste già,
    * @return int 0 se l'operazione va a buon fine
    */
    public function creaCondivisione($post, $codicefiscale, $idsensore);


    /**
    * 
    * Restituisce tutte le condivisioni di un ambiente
    *
    * @param int $idambiente  Codice univoco dell'ambiente
    * @return array  Contiente le informazioni di tutte le condivisioni di un ambiente
    */
    public function getCondivisioni($idambiente);



    /**
    * 
    * Controlla che una condivisione non esista già
    *
    * @param int $idterzaparte  Codice univoco della terzaparte
    * @param int $idsensore  Codice univoco del sensore
    * @param int $idcanale Codice univoco del canale
    *
    * @return int 0  Se la condivisione NON è presente nel sistema
    * @return int 1  Se la condivisone è già presente nel sistema
    */
    public function shareAlreadyExists($idterzaparte, $idsensore, $idcanale);




     /**
    * 
    * Elimina una condivisione
    *
    * @param int $id  Codice univoco di una condivisione
    * @return void
    */
    public function eliminaCondivisione($id);




    
    /**
    * 
    * Restituisce i dati di una singola condivisione
    *
    * @param int $id  Codice univoco di una condivisione
    * @return array restituisce tutte le informazioni di una singola condivisione
    */
    public function trovaCondivisione($id);




    /**
    * 
    * Controlla che il sensore sia effettivamente dell'utente
    *
    * @param int $idsensore  ID del sensore
    * @param string $codicefiscale  Codice fiscale del cliente
    * @return boolean 0 se il sensore non appartiene al cliente, 1 se appartiene
    */
    public function checkProperty($idsensore, $codicefiscale);




    /**
    * 
    * Controlla che la condivisione sia effettivamente dell'utente
    *
    * @param int $idcondivisione  ID della condivisione
    * @param string $codicefiscale  Codice fiscale del cliente
    * @return boolean 0 se il sensore non appartiene al cliente, 1 se appartiene
    */
    public function checkShareProperty($idcondivisione, $codicefiscale);

    
}