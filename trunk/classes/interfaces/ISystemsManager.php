<?php

interface ISystemsManager {

      /**
        * 
        * Registra un impianto (system) nel DB
        *
        * @param array $post  Contiene le informazioni dell'impianto che vengono "postate" (al momento della compilazione
        * del form)
        * @return array con i valori della post e l'eventuale errore verificatosi (1-"ci sono ancora campi da compilare")
        *                                                                         (2-"il formato del CAP non è valido")
        */
      public function registraImpianto($post);



       
      /**
        * 
        * Permette di modificare le informazioni relative ad un impianto, compresi i responsabili dell'impianto stesso
        *
        * @param array $post  Contiene le informazioni dell'impianto che vengono "postate" (al momento della compilazione
        * del form)
        * @param int $idimpianto  Specifica l'identificativo dell'impainto che si sta modificando
        *
        * @return array con i valori della post e l'eventuale errore verificatosi (1-"ci sono ancora campi da compilare")
        *                                                                         (2-"il formato del CAP non è valido")
        */
      public function modificaImpianto($post, $idimpianto);




      /**
        * 
        * Restituisce la lista di tutti gli impianti registrati
        *
        * @return array $row  lista di tutti gli impianti
        */
      public function getImpianti();




      /**
        * 
        * Restituisce la lista degli impianti relativi ad un utente
        *
        * @param string $utente  Indica il codice fiscale con il quale ricercare l'utente e i relativi impianti
        *
        * @return array $row  lista degli impianti di un utente
        */
      public function getImpiantiUtente($utente);




      /**
        *
        * Restituisce il singolo impianto in base all'id passatole
        *
        * @param int $idimpianto  Specifica l'impianto del quale si volgiono recuperare le informazioni
        *
        * @return array $row  contiene le informazioni sul singolo impianto
        */
      public function trovaImpianto($idimpianto);




      /**
        *
        * Restituisce la lista dei responsabili dell'impianto specificato dal parametro in entrata alla funzione
        *
        * @param int $idimpianto  Specifica l'identificativo dell'impianto del quale si vogliono recuperare i responsabili
        *
        * @return array $row  lista di tutti i responsabili di quell'impianto
        */
      public function respFromImpianto($idimpianto);




      /**
        *
        * Verifica che un certo cliente sia responsabile di un certo impianto
        *
        * @param string $idutente  Specifica il cliente del quale si vuole verificare lo status di "responsabile impianto"
        * @param int $idimpianto  Specifica l'impianto del quale si vuole verificare che $idutente sia responsabile
        *
        * @return True  $idutente è responsabile di $idimpianto
        * @return False  $idutente non è responsabile di $idimpianto
        */
      public function isResponsabile($idutente, $idimpianto);




      /**
        * 
        * Permette di eliminare un impianto. Il CASCADE elimina, inoltre, tutti gli ambienti associati a quell'impianto e tutti i sensori associati ai sopracitati ambienti
        *
        * @param int $idimpianto  Specifica l'identificativo dell'impianto che si intende eliminare
        */
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