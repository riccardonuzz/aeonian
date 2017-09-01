<?php
require_once("DBManager.php");

class OutputsManager {
    private $database;

    /*
     * Crea l'oggetto del Gestore Dababase
     */
    public function __construct(){
        $this->database = new DBManager();
    }

    public function getRilevazioni($IDSensore){
        $this->database->query("SELECT * FROM rilevazione JOIN tipologiasensore JOIN sensore ON sensore.IDSensore = rilevazione.Sensore AND sensore.TipologiaSensore = tipologiasensore.IDTipologiaSensore WHERE Sensore = :idsensore ORDER BY Data ASC");
        $this->database->bind(":idsensore", $IDSensore);
        $row = $this->database->resultSet();
        return $row;

    }

}