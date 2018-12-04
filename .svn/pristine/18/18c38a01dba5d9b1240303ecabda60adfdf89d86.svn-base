<?php

interface INotifyManager {

     /**
       * 
       * Registra una regola notifica per un sensore nel DB
       * Viene anche effettuato un controllo sulla validità della regola in base alla "tolleranza" (massimo/minimo valore
       * rilevabile dal sensore)
       * Un ulteriore controllo viene fatto sul simbolo logico immesso (deve essere necessariamente <, > o =)
       *
       * @param array $post  Contiene le informazioni della regola notifica che vengono "postate",
       * @param string $sensore  ID del sensore
       * @param float $min  Minimo valore rilevabile
       * @param float $max  Massimo valore rilevabile
       *
       * @return array con i valori della post e l'eventuale errore verificatosi (1-"ci sono ancora campi da compilare")
       *                                                                         (2-"valori non ammissibili")
       */
       public function creaRegolaNotifica($post, $sensore, $min, $max);

       
    /**
       * 
       * Recupera le regole notifica relative ad un determinato sensore
       *
       * @param string $idsensore  Specifica il sensore di cui si vogliono recuperare le regole
       *
       * @return array $row  con le informazioni sulle regole notifica del sensore specificato dal paramentro in entrata
       */
    public function getRegoleNotificaSensore($idsensore);


    /**
      *
      * Elimina la regola notifica il cui id è stato specificato come parametro
      *
      * @param int $idregola  Specifica la regola che si vuole eliminare
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
      * @return array restituisce un vettore contenente i dati relativi alle ultime notifiche 5 notifiche
      */
    public function getUltimeNotifiche($utente);
    



    /**
      * 
      * Restituisce tutte le notifiche di un utente dato
      * @param int $utente  Codice fiscale dell'utente
      * @return array restituisce un vettore contenente i dati relativi a tutte le notifiche di un utente
      */
    public function getNotifiche($utente);



    /**
      * Restituisce la singola notifica (con tutte le info relative) in base all'id specificato nel parametro in entrata
      *
      * @param int $idnotifica  Identificativo della notifica che si vuole visualizzare
      *
      * @return array $row  con le informazioni sulla notifica specificata
      */
    public function trovaNotifica($idnotifica);



     /**
      * Cambia il flag "Letta" ad 1
      *
      * @param int $idnotifica  Identificativo della notifica che si vuole visualizzare
      *
      * @return void
      */
    public function leggi($idnotifica);


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