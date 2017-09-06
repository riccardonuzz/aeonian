<?php

require_once("DBManager.php");

class SharesManager {
    private $database;

    /*
     * Crea l'oggetto del Gestore Dababase
     */
    public function __construct(){
        $this->database = new DBManager();
    }

    public function creaCondivisione($post, $codicefiscale, $idsensore) {
        if($post['terzaparte']==0 || !isset($post['canale'])) {
            return array (
                "error" => 1,
                "idsensore" => $idsensore
            );
        }

        if($this->shareAlreadyExists($post['terzaparte'], $idsensore, $post['canale'])) {
            return array (
                "error" => 2,
                "idsensore" => $idsensore
            );
        }

        $this->database->query("INSERT INTO condivisione(Sensore, Canale, TerzaParte) VALUES (:sensore, :canale, :terzaparte)");
        $this->database->bind(":sensore", $idsensore);
        $this->database->bind(":canale", $post['canale']);
        $this->database->bind(":terzaparte", $post['terzaparte']);
        $this->database->execute();
    }


    public function getCondivisioni($idutente){
        $this->database->query("SELECT * FROM condivisione WHERE TerzaParte = :terzaparte AND Canale = :canale AND Sensore = :sensore");
        $this->database->bind(":terzaparte", $idterzaparte);
        $this->database->bind(":canale", $idcanale);
        $this->database->bind(":sensore", $idsensore);
        $row = $this->database->singleResultSet();
    }


    private function shareAlreadyExists($idterzaparte, $idsensore, $idcanale){
        $this->database->query("SELECT * FROM condivisione WHERE TerzaParte = :terzaparte AND Canale = :canale AND Sensore = :sensore");
        $this->database->bind(":terzaparte", $idterzaparte);
        $this->database->bind(":canale", $idcanale);
        $this->database->bind(":sensore", $idsensore);
        $row = $this->database->singleResultSet();

        if($row){
            return 1;
        }

        return 0;
    }

}