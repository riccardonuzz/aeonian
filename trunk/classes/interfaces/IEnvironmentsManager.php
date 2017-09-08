<?php

interface IEnvironmentsManager {
    /**
       * 
       * registra un ambiente (environment)
       *
       * @param array $post Contiene le informazioni dell'ambiente che vengono "postate"
       * @return array con i valori della post e l'eventuale errore verificatosi (1-"ci sono ancora campi da compilare")
       */
    public function registraAmbiente($post,$idimpianto);



    /**
       * 
       * Restituisce lista degli ambienti
       *
       * @return array $row  lista di tutti gli ambienti con i relativi impianti
       */

    public function getAmbienti();
    
    
    
    /**
    *
    * Restituisce la lista degli ambienti relativi all'impianto, il cui id viene passato come input alla funzione
    *
    * @return array $row  lista di tutti gli ambienti relativi all'impianto
    */
    public function getAmbientiImpianto($idimpianto);



     /**
    *
    * Restituisce il singolo ambiente in base all'id passatole
    *
    * @return array $row  col singolo ambiente e gli attributi utili
    */
    public function trovaAmbiente($idambiente);



    public function modificaAmbiente($post, $idamb);


    public function eliminaAmbiente($idambiente);




    /**
        * 
        * Controlla che controlla che la proprietà dell'impianto sia dell'utente
        *
        * @param int $idImpianto  ID dell'impianto del quale prendere i dati
        * @param string $codicefiscale  Codice fiscale del cliente
        * @return boolean 0 se l'impianto non appartiene al cliente, 1 se appartiene
        */
        public function checkProperty($idambiente, $codicefiscale);
}