<?php

require_once("DBManager.php");

class ThirdPartiesManager {
    private $database;

    /*
     * Crea l'oggetto del Gestore Dababase
     */
    public function __construct(){
        $this->database = new DBManager();
    }

    public function getTerzeParti($IDCliente){
         //Prendo le info dell'utente
         $this->database->query("SELECT * FROM terzaparte WHERE Utente = :idcliente");
         $this->database->bind(":idcliente", $IDCliente);         
         $row = $this->database->resultSet();
         return $row;
    }

    public function aggiungiTerzaParte($post, $codicefiscale){
        if(empty($post['nome'])) {
            return array (
                "error" => 1,
                "codicefiscale" => $post['codicefiscale']
            );
        }

        //vengono prima eliminati i numeri e poi reinseriti. Troppo complicato verificare quali numeri ci sono già e quali modificare
        $this->database->query("INSERT INTO terzaparte(Nome, Utente) VALUES(:nome, :codicefiscale)");
        $this->database->bind(":nome", $post['nome']);        
        $this->database->bind(":codicefiscale", $codicefiscale);
        $this->database->execute();

    }

}