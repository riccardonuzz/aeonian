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
         return $this->database->resultSet();
    }

    public function getNumeroTipologieCanali(){
        $this->database->query("SELECT COUNT(*) AS Totale FROM tipologiacanale");        
        $row = $this->database->SingleResultSet();
        return $row['Totale'];
    }


    public function aggiungiTerzaParte($post, $codicefiscale){
        if(empty($post['nome']) || empty($post['canali'])) {
            return array (
                "error" => 1,
                "codicefiscale" => $codicefiscale
            );
        }

        for($i=0; $i<$this->getNumeroTipologieCanali(); $i++) {
            if(isset($post['canali'][$i]) && empty($post['valori'][$i])) {
                return array (
                    "error" => 1,
                    "nome" => $post['nome']
                );
            }
        }


         //Inserisco la terza parte nel DB
         $this->database->query("INSERT INTO terzaparte(Nome, Utente) VALUES(:nome, :codicefiscale)");
         $this->database->bind(":nome", $post['nome']);        
         $this->database->bind(":codicefiscale", $codicefiscale);
         $this->database->execute();

         $lastID = $this->database->lastInsertId();


        for($i=0; $i<$this->getNumeroTipologieCanali(); $i++) {
            if(isset($post['canali'][$i])) {
                // echo "IDterzaParte: ".$lastID." IDTipologiaCanale".$post['canali'][$i]." Valore".$post['valori'][$i]."<br>";
                $this->database->query("INSERT INTO canale(TerzaParte, TipologiaCanale, Valore) VALUES (:terzaparte, :tipologiacanale, :valore)");
                $this->database->bind(":terzaparte", $lastID);
                $this->database->bind(":tipologiacanale", $post['canali'][$i]);
                $this->database->bind(":valore", $post['valori'][$i]);                
                $this->database->execute();
            }
        }

    }

    public function eliminaTerzaParte($id){
        //eliminazione di una terza parte
        $this->database->query("DELETE FROM terzaparte WHERE IDTerzaParte= :idterzaparte");
        $this->database->bind(":idterzaparte", $id); 
        $this->database->execute();
    }

    public function getTipologieCanali(){
        //prendo dal DB tutte le tipologie dei canali supportate dal sistema
        $this->database->query("SELECT * FROM tipologiacanale");
        $row = $this->database->resultSet();
        return $row;
    }

    public function trovaTerzaParte($id){
         $this->database->query("SELECT * FROM terzaparte WHERE IDTerzaParte = :idterzaparte");
         $this->database->bind(":idterzaparte", $id);          
         return $this->database->singleResultSet();
    }

    public function getCanaliTerzaParte($id){
        $this->database->query("SELECT * FROM canale JOIN tipologiacanale ON canale.TipologiaCanale=tipologiacanale.IDTipologiaCanale WHERE TerzaParte = :idterzaparte");
        $this->database->bind(":idterzaparte", $id);          
        return $this->database->resultSet();
    }

}