<?php

interface IThirdPartiesManager {
     /**
       * 
       * Restituisce lista delle terze parti relative ad un utente
       * @param string $IDCliente indica il codice fiscale con il quale ricercare l'utente e le relative terze parti
       * @return array $row lista delle terze parti di un utente
       */
       public function getTerzeParti($IDCliente);



    /**
       * 
       * Restituisce il numero delle tipologie dei canali presenti
       * @param void
       * @return int Totale tipologie canali
       */
    public function getNumeroTipologieCanali();



      /**
       * 
       * Creazione di una terza parte
       *
       * @param array $post  Array che contiene le informazioni di una terza parte che verrano inserite nel database
       * @param string $codicefiscale  Indica il codice fiscale con il quale ricercare l'utente e i relativi impianti
       *
       * @return array con error=1 se i campi non sono stati compilati
       * @return array con error=2 se sono stati selezionati canali senza averli valorizzati
       * @return void se è tutto ok
       */
       public function aggiungiTerzaParte($post, $codicefiscale);



       /**
       * 
       * Elimina una terza parte
       * @param int $id  id della terza parte da eliminare
       * @return void
       */
    public function eliminaTerzaParte($id);




    /**
       * 
       * Restituisce una lista delle tipologie dei canali
       * @return array  contiene la lista delle tipologie dei canali
       */
       public function getTipologieCanali();



    
    /**
       * 
       * Restituisce i dati di una terza parte
       * @param int $id  ID della terza parte
       * @return array  vettore contenente le informazioni di una terza parte
       */
       public function trovaTerzaParte($id);


    
     /**
    * 
    * Restituisce lista dei canali di una terza parte
    * @param int $id  ID della terza parte
    * @return array  contiene le informazioni di tutti i canali di una terza parte
    */
    public function getCanaliTerzaParte($id);




    /**
       * 
       * Durante la modifica, prendiamo tutti i canali di una terza parte ma ovviamente mancano quelli che non sono stati memorizzati. Questa funzione quindi, ricerca i canali di una terza parte che non sono stati selezionati in fase di registrazione della terza parte e li visualizza
       * @param array $canali Contiene id e valori dei canali che sono già stati memorizzati relativamente ad una terza parte
       * @return array contiene i dati relativi ai canali non selezionati durante la registrazione di una terza parte
       */
       public function getTipologieCanaliMancanti($canali);

    
    
     /**
       * 
       * Modifica di una terza parte
       * @param array $post  contiene i dati relativi ad una terza parte con eventuali modifiche
       * @param int $idterzaparte  ID della terza parte
       * @return array  con error=1 se non sono stati compilati dei campi importanti
       * @return int $idterzaparte  ID della terza parte
       */
       public function modificaTerzaParte($post, $idterzaparte);



    
       
}