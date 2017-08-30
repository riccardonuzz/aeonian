<?php
require_once("DBManager.php");

class EnvironmentsManager {
    private $database;

    /*
     * Crea l'oggetto del Gestore Dababase
     */
    public function __construct(){
        $this->database = new DBManager();
    }

    /**
       * 
       * registra un ambiente (environment)
       *
       * @param Array $post Contiene le informazioni dell'ambiente che vengono "postate"
       * @return Array con i valori della post e l'eventuale errore verificatosi (1-"ci sono ancora campi da compilare")
       */
    public function registraAmbiente($post,$idimpianto){

    
      //Insert into MySql
      if(empty($post['nomeAmbiente']) || empty($post['descrizione'])) {

        return Array(
            "error" => 1,
            "values" => Array (
            "nomeAmbiente" => $post['nomeAmbiente'],
            "descrizione" => $post['descrizione'],   
          )
        );
      }

      $this->database->query("INSERT INTO ambiente (Nome, Descrizione, Impianto) VALUES (:nome, :descrizione, :impianto)");
      $this->database->bind(":nome", $post['nomeAmbiente']);
      $this->database->bind(":descrizione", $post['descrizione']);
      $this->database->bind(":impianto", $idimpianto);
   
      $this->database->execute();

    } // fine registraAmbiente()
    

    /**
       * 
       * Restituisce lista degli ambienti
       *
       * @return Array $row  lista di tutti gli ambienti con i relativi impianti
       */
    public function getAmbienti(){
        //Prendo le info dell'utente
        $this->database->query("SELECT IDAmbiente, ambiente.Impianto AS idimpianto, impianto.Nome AS impNome, ambiente.Nome AS ambNome, Descrizione FROM ambiente JOIN impianto ON Impianto = IDImpianto");
        $row = $this->database->resultSet();
        return $row;
    }


    /**
    *
    * Restituisce la lista degli ambienti relativi all'impianto, il cui id viene passato come input alla funzione
    *
    * @return Array $row  lista di tutti gli ambienti relativi all'impianto
    */
    public function getAmbientiImpianto($idimpianto){
      $this->database->query("SELECT impianto.Nome AS ImpNome, IDAmbiente, ambiente.Nome, Descrizione FROM ambiente JOIN impianto ON Impianto = IDImpianto WHERE Impianto = :imp");
      $this->database->bind(":imp", $idimpianto);
      $row = $this->database->resultSet();
      return $row;      
    }

    /**
    *
    * Restituisce il singolo ambiente in base all'id passatole
    *
    * @return Array $row  col singolo ambiente e gli attributi utili
    */
    public function trovaAmbiente($idambiente){
      $this->database->query("SELECT IDAmbiente, ambiente.Nome AS ambNome, Descrizione, Impianto, impianto.Nome AS impNome FROM ambiente JOIN impianto ON Impianto = IDImpianto WHERE IDAmbiente = :idamb");
      $this->database->bind(":idamb", $idambiente);
      $row = $this->database->singleResultSet();
      return $row;
    }


    public function modificaAmbiente($post, $idamb){
     
      //Insert into MySql
      if(empty($post['nomeAmbiente']) || empty($post['descrizione'])) {

        return Array(
            "error" => 1,
            "values" => Array (
            "nomeAmbiente" => $post['nomeAmbiente'],
            "descrizione" => $post['descrizione'],   
          )
        );
      }


      $this->database->query("UPDATE ambiente SET Nome = :nomeamb,  Descrizione = :descr WHERE IDAmbiente = :idamb ");
      $this->database->bind(":nomeamb", $post['nomeAmbiente']);
      $this->database->bind(":descr", $post['descrizione']);
      $this->database->bind(":idamb", $idamb);
      $this->database->execute();
    }

    public function eliminaAmbiente($idambiente){

      $this->database->query("DELETE FROM ambiente WHERE IDAmbiente = :idamb");
      $this->database->bind(":idamb", $idambiente);
      $this->database->execute();

    }
}
