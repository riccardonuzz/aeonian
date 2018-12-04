<?php

interface ISenderManager {

    /**
    * 
    * Per ogni condivisione, prende i canali, e tutte le ultime 20 rilevazioni del sensore condiviso e le invia
    * @param void
    * @return void
    */
    public function inviaDati();




    /**
    * 
    * Effettua una richiesta di tipo POST
    * @param int $url  url al quale effettuare la richiesta POST
    * @param array $dati array contenente i dati da inviare tramite richiesta
    * @return int  numero di bytes inviati
    */
    public function inviaPOST($url, $dati);




    /**
    * 
    * Crea un file CSV da inviare via mail
    * @param int $url  url al quale effettuare la richiesta POST
    * @param array $dati array contenente i dati da inviare tramite richiesta
    * @return string  se il file viene creato con successo (viene quindi restituito)
    * @return boolean (FALSE) se l'operazione non va a buon fine
    */
    public function create_csv_string($data);





    /**
    * 
    * Invia una mail
    * @param int $csvData  file csv da inviare tramite mail
    * @param string $bodys  corpo del messaggio
    * @param string $to  indirizzo del destinatario
    * @param string $subject  oggetto della mail
    * @param string $from  indirizzo dal quale inviare la mail
    * @return int  numero di bytes inviati
    */
    public function inviaMail($csvData, $bodys, $to, $subject, $from);
    
    

}