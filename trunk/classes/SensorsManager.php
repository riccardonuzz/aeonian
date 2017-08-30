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
      if(empty($post['nomesensore']) || empty($post['tipo']) || empty($post['marca'])|| empty($post['idsensore'])) {

        return Array(
            "error" => 1,
            "values" => Array (
            "nomesensore" => $post['nomesensore'],
            "tipo" => $post['tipo'],
            "marca" => $post['marca'],
            "idsensore" => $post['idsensore']
          )
        );
      }

      if(!preg_match('/[A-Z0-9]{10}/',$post['idsensore'])){

        return Array(
            "error" => 2,
            "values" => Array (
            "nomesensore" => $post['nomesensore'],
            "tipo" => $post['tipo'],
            "marca" => $post['marca'],
            "idsensore" => $post['idsensore']
          )
        );
      }

      if($this->sensorAlreadyExists($post['idsensore'])){

        return Array(
            "error" => 3,
            "values" => Array (
            "nomesensore" => $post['nomesensore'],
            "tipo" => $post['tipo'],
            "marca" => $post['marca'],
            "idsensore" => $post['idsensore']
          )
        );
      }

      $this->database->query("INSERT INTO sensore(IDSensore,Nome, Ambiente, TipologiaSensore, Marca) VALUES (:id,:nome, :ambiente, :tipologia, :marca)");
      $this->database->bind(":id", $post['idsensore']);
      $this->database->bind(":nome", $post['nomesensore']);
      $this->database->bind(":ambiente", $idambiente);
      $this->database->bind(":tipologia", $post['tipo']);
      $this->database->bind(":marca", $post['marca']);
      $this->database->execute();

    } // fine registraSensore()
    
    
    public function sensorAlreadyExists($idsensore){
      $this->database->query("SELECT * FROM sensore WHERE IDSensore = :idsensore");
      $this->database->bind(":idsensore", $idsensore);
      $row = $this->database->resultSet();

      if($row != null){
        return True;
      }else{
        return False;
      }
    }

    /**
    *
    */ 
    public function modificaSensore($post, $idsens){
      //Insert into MySql
      if(empty($post['nomesensore']) || empty($post['tipo']) || empty($post['marca'])) {

        return Array(
            "error" => 1,
            "values" => Array (
            "nomesensore" => $post['nomesensore'],
            "tipo" => $post['tipo'],
            "marca" => $post['marca'],
            "idsensore" => $post['idsensore']
          )
        );
      }


      $this->database->query("UPDATE sensore SET Nome = :nomesens, TipologiaSensore = :tipo, Marca = :marca WHERE IDSensore = :idsens ");
      $this->database->bind(":nomesens", $post['nomesensore']);
      $this->database->bind(":tipo", $post['tipo']);
      $this->database->bind(":marca", $post['marca']);
      $this->database->bind(":idsens", $idsens);
      $this->database->execute();
    }


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


    /**
    *
    * Trova un singolo sensore a partire dal sui id e restituisce una serie di informazioni relativi ad esso
    *
    * @return Array $row  informazioni su un singolo sensore
    */
    public function trovaSensore($idsensore){
      $this->database->query("SELECT TipologiaSensore, UnitaMisura, Marca, Ambiente, IDImpianto, IDSensore, sensore.Nome AS sensNome, tipologiasensore.Nome AS tipoNome, ambiente.Nome AS ambNome, impianto.Nome AS impNome FROM sensore JOIN tipologiasensore JOIN ambiente JOIN impianto ON TipologiaSensore = IDTipologiaSensore AND sensore.Ambiente = ambiente.IDAmbiente AND ambiente.Impianto = impianto.IDImpianto WHERE IDSensore = :idsens");
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
        $this->database->query("SELECT sensore.Ambiente AS sensAmb, ambiente.Impianto AS sensImp, IDSensore, sensore.Nome AS sensNome, tipologiasensore.Nome AS tipoNome, ambiente.Nome AS ambNome, impianto.Nome AS impNome FROM sensore JOIN tipologiasensore JOIN ambiente JOIN impianto ON TipologiaSensore = IDTipologiaSensore AND sensore.Ambiente = ambiente.IDAmbiente AND ambiente.Impianto = impianto.IDImpianto");
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

    /*
    *
    * Elimina il sensore il cui id è stato specificato come parametro
    */
    public function eliminaSensore($idsensore){
      
      $this->database->query("DELETE FROM sensore WHERE IDSensore = :idsens");
      $this->database->bind(":idsens", $idsensore);
      $this->database->execute();
  
   }
    

}
