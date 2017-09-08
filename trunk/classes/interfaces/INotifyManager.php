<?php

interface INotifyManager {

     /**
       * 
       * registra una regola notifica per un sensore
       *
       * @param array $post Contiene le informazioni della regola notifica che vengono "postate"
       * @return array con i valori della post e l'eventuale errore verificatosi (1-"ci sono ancora campi da compilare")
       */
       public function creaRegolaNotifica($post, $sensore, $min, $max);

       
    /**
       * 
       * Recupera le regole notifica relative ad un determinato sensore
       *
       * @param $idsensore che specifica il sensore di cui si vogliono recuperare le regole
       */
    public function getRegoleNotificaSensore($idsensore);


    /**
      *
      * Elimina la regola notifica il cui id è stato specificato come parametro
      *
      * @param $idregola che specifica la regola che si vuole eliminare
      */
      public function eliminaRegola($idregola);




       /**
       * 
       * Restituisce il numero totale di notifiche non lette dall'utente
       * @param int $utente  Codice fiscale dell'utente
       * @return array['Totale']  restituisce quindi un vettore contenente solo la voce 'Totale' cioè un intero corrispondente al totale delle notifiche non lette
       */
    public function getNumeroNotifiche($utente);
    



    
    /**
       * 
       * Restituisce le ultime 5 notifiche di un utente dato
       * @param int $utente  Codice fiscale dell'utente
       * @return array  restituisce un vettore contenente i dati relativi alle ultime notifiche 5 notifiche
       */
    public function getUltimeNotifiche($utente);
    




     /**
       * 
       * Restituisce tutte le notifiche di un utente dato
       * @param int $utente  Codice fiscale dell'utente
       * @return array  restituisce un vettore contenente i dati relativi a tutte le notifiche di un utente
       */
    public function getNotifiche($utente);




    public function trovaNotifica($idnotifica);




    /**
    * 
    * Controlla proprietà di una notifica
    *
    * @param int $idnotifica  ID della notifica
    * @param string $codicefiscale  Codice fiscale del cliente
    * @return boolean 0 se la notifica non appartiene al cliente, 1 se appartiene
    */
    public function checkNotifyProperty($idnotifica, $codicefiscale);




     /**
      * 
      * Controlla proprietà accesso alla schermata di creazione regola notifica
      *
      * @param int $idsensore  ID del sensore
      * @param string $codicefiscale  Codice fiscale del cliente
      * @return boolean 0 se il sensore non appartiene al cliente, 1 se appartiene
      */
      public function checkRuleProperty($idsensore, $codicefiscale);
}