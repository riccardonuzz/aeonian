<?php

interface IDashboardManager {

       /**
       * 
       * registra una regola notifica per un sensore
       *
       * @param int $idImpianto  ID dell'impianto del quale prendere i dati
       * @return array $json_response  Contiene i dati, per ogni ambiente di un impianto, di tutti i sensori (min, max, media) e di tutte le rilevazioni
       */
       public function getDatiDashboard($idImpianto);



        /**
        * 
        * Controlla che controlla che la proprietà dell'impianto sia dell'utente
        *
        * @param int $idImpianto  ID dell'impianto del quale prendere i dati
        * @param string $codicefiscale  Codice fiscale del cliente
        * @return boolean 0 se l'impianto non appartiene al cliente, 1 se appartiene
        */
        public function checkProperty($idimpianto, $codicefiscale);

}