<?php

interface ISystemsManager {

     /**
       * 
       * registra un impianto (system)
       *
       * @param array $post Contiene le informazioni dell'impianto che vengono "postate" (al momento della compilazione
       * del form)
       * @return array con i valori della post e l'eventuale errore verificatosi (1-"ci sono ancora campi da compilare")
       */
       public function registraImpianto($post);



       
        /**
       * 
       * modifica un impianto (system)
       *
       * @param array $post Contiene le informazioni dell'impianto che vengono "postate" (al momento della compilazione
       * del form)
       * @return array con i valori della post e l'eventuale errore verificatosi (1-"ci sono ancora campi da compilare")
       */
       public function modificaImpianto($post, $idimpianto);





        /**
        * 
        * Restituisce lista degli
        *
        * @return array $row  lista di tutti gli impianti
        */
        public function getImpianti();






       /**
       * 
       * Restituisce lista degli impianti relativi ad un utente
       * @param string $utente indica il codice fiscale con il quale ricercare l'utente e i relativi impianti
       * @return array $row lista degli impianti di un utente
       */
       public function getImpiantiUtente($utente);


    
       public function trovaImpianto($idimpianto);


       public function respFromImpianto($idimpianto);


       public function isResponsabile($idutente, $idimpianto);


       public function eliminaImpianto($idimpianto);



    /**
    * 
    * Controlla che l'impianto appartenga al cliente
    *
    * @param int $idimpianto  ID dell'impianto
    * @param string $codicefiscale  Codice fiscale del cliente
    * @return boolean 0 se l'impianto non appartiene al cliente, 1 se appartiene
    */
   public function checkProperty($idimpianto, $codicefiscale);
}