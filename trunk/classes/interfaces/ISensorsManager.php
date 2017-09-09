<?php

interface ISensorsManager {

    /**
      * 
      * Registra un sensore (sensor) nel DB
      *
      * @param array $post  Contiene le informazioni del sensore che vengono "postate"
      * @param int $idambiente  Specifica l'id dell'ambiente al quale quel sensore verrà associato
      * @return array con i valori della post e l'eventuale errore verificatosi (1-"ci sono ancora campi da compilare")
      *                                                                         (2-"codice sensore invalido")
      *                                                                         (3-"il sensore con il codice x esiste già")
      */
    public function registraSensore($post,$idambiente);


    /**
    * Controlla se il sensore con il codice $idsensore esiste già all'interno del DB
    *
    * @param string $idsensore  Specifica il codice sensore di cui si vuole verificare l'esistenza
    *
    * @return True  esiste già un sensore con quel codice nel DB
    * @return False  non esiste un sensore con quel codice nel DB
    */
    public function sensorAlreadyExists($idsensore);


    /**
      *
      * Permette di modificare le informazioni relative ad un sensore (nome, tipo, minima tolleranza, massima tolleranza, marca)
      * 
      * @param array $post  Contiene le informazioni del sensore che vengono "postate"
      * @param string $idsens  Specifica di quale sensore verranno modificate le informazioni
      *
      * @return array con i valori della post e l'eventuale errore verificatosi (1-"ci sono ancora campi da compilare")
      */
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
      * Trova un singolo sensore a partire dal suo id e restituisce una serie di informazioni relative ad esso
      * 
      * @param string $idsensore  Specifica l'identificativo del sensore del quale si vogliono recuperare le informazioni
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
      * @param int $idambiente  Specifica l'identificativo dell'ambiente del quale si vogliono recuperare i sensori
      *
      * @return array $row  lista di tutti i sensori relativi all'ambiente
      */
    public function getSensoriAmbiente($idambiente);



    /**
      *
      * Elimina il sensore il cui id è stato specificato come parametro
      *
      * @param string $idsensore  Specifica il sensore che si vuole eliminare. Il CASCADE permette di eliminare anche tutte le regole notifica e le rilevazioni
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