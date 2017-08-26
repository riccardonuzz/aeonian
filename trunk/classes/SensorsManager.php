<?php
require_once("DBManager.php");

class SensorsManager {
    private $database;

    /*
     * Crea l'oggetto del Gestore Dababase
     */
    public function __construct(){
        $this->database = new DBManager();
    }

    /**
       * 
       * registra un sensore (sensor)
       *
       * @param Array $post Contiene le informazioni del sensore che vengono "postate"
       * @return Array con i valori della post e l'eventuale errore verificatosi (1-"ci sono ancora campi da compilare")
       */
    public function registraSensore($post,$idambiente){

    
      //Insert into MySql
      if(empty($post['nomesensore']) || empty($post['tipo']) || empty($post['marca'])) {

        return Array(
            "error" => 1,
            "values" => Array (
            "nomesensore" => $post['nomesensore'],
            "tipo" => $post['tipo'],
            "marca" => $post['marca']
          )
        );
      }

      $this->database->query("INSERT INTO sensore(Nome, Ambiente, TipologiaSensore, Marca) VALUES (:nome, :ambiente, :tipologia, :marca)");
      $this->database->bind(":nome", $post['nomesensore']);
      $this->database->bind(":ambiente", $idambiente);
      $this->database->bind(":tipologia", $post['tipo']);
      $this->database->bind(":marca", $post['marca']);
      $this->database->execute();

    } // fine registraSensore()
    
    /**
    *
    * Restituisce la lista con tutte le tipologie di sensori
    *
    * @return Array $row  lista delle tipologie di sensori
    */
    public function getTipi(){
      $this->database->query("SELECT * FROM tipologiasensore");
      $row = $this->database->resultSet();
      return $row;
    }


    public function trovaSensore($idsensore){
      $this->database->query("SELECT UnitaMisura, Marca, Ambiente, IDImpianto, IDSensore, sensore.Nome AS sensNome, tipologiasensore.Nome AS tipoNome, ambiente.Nome AS ambNome, impianto.Nome AS impNome FROM sensore JOIN tipologiasensore JOIN ambiente JOIN impianto ON TipologiaSensore = IDTipologiaSensore AND sensore.Ambiente = ambiente.IDAmbiente AND ambiente.Impianto = impianto.IDImpianto WHERE IDSensore = :idsens");
      $this->database->bind(":idsens", $idsensore);
      $row = $this->database->singleResultSet();
      return $row;
    }


    /**
       * 
       * Restituisce lista dei sensori
       *
       * @return Array $row  lista di tutti i sensori con i relativi impianti e i relativi ambienti
       */
    public function getSensori(){
        //Prendo le info dell'utente
        $this->database->query("SELECT IDSensore, sensore.Nome AS sensNome, tipologiasensore.Nome AS tipoNome, ambiente.Nome AS ambNome, impianto.Nome AS impNome FROM sensore JOIN tipologiasensore JOIN ambiente JOIN impianto ON TipologiaSensore = IDTipologiaSensore AND sensore.Ambiente = ambiente.IDAmbiente AND ambiente.Impianto = impianto.IDImpianto");
        $row = $this->database->resultSet();
        return $row;
    }


    /**
    *
    * Restituisce la lista dei sensori relativi all'ambiente, il cui id viene passato come input alla funzione
    *
    * @return Array $row  lista di tutti i sensori relativi all'ambiente
    */
    public function getSensoriAmbiente($idambiente){
      $this->database->query("SELECT IDSensore, sensore.Nome AS sensNome, tipologiasensore.Nome AS tipoNome, UnitaMisura FROM sensore JOIN tipologiasensore ON TipologiaSensore = IDTipologiaSensore WHERE Ambiente = :amb");
      $this->database->bind(":amb", $idambiente);
      $row = $this->database->resultSet();
      return $row;      
    }

}
