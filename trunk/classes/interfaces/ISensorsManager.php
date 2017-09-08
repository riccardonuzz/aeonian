<?php

interface ISensorsManager {
    /**
       * 
       * registra un sensore (sensor)
       *
       * @param array $post Contiene le informazioni del sensore che vengono "postate"
       * @return array con i valori della post e l'eventuale errore verificatosi (1-"ci sono ancora campi da compilare")
       */
       public function registraSensore($post,$idambiente);


       public function sensorAlreadyExists($idsensore);

       public function modificaSensore($post, $idsens);



    /**
    *
    * Restituisce la lista con tutte le tipologie di sensori
    *
    * @return array $row  lista delle tipologie di sensori
    */
    public function getTipi();


    /**
    *
    * Trova un singolo sensore a partire dal sui id e restituisce una serie di informazioni relativi ad esso
    *
    * @return array $row  informazioni su un singolo sensore
    */
    public function trovaSensore($idsensore);



    /**
       * 
       * Restituisce lista dei sensori
       *
       * @return array $row  lista di tutti i sensori con i relativi impianti e i relativi ambienti
       */
       public function getSensori();



     /**
    *
    * Restituisce la lista dei sensori relativi all'ambiente, il cui id viene passato come input alla funzione
    *
    * @return array $row  lista di tutti i sensori relativi all'ambiente
    */
    public function getSensoriAmbiente($idambiente);



    /*
    *
    * Elimina il sensore il cui id è stato specificato come parametro
    */
    public function eliminaSensore($idsensore);




    /**
    * 
    * Controlla che il sensore sia effettivamente dell'utente
    *
    * @param int $idsensore  ID del sensore
    * @param string $codicefiscale  Codice fiscale del cliente
    * @return boolean 0 se il sensore non appartiene al cliente, 1 se appartiene
    */
    public function checkProperty($idsensore, $codicefiscale);
}