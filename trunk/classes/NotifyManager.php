<?php
require_once("DBManager.php");


class NotifyManager {
    private $database;

    /*
     * Crea l'oggetto del Gestore Dababase
     */
    public function __construct(){
        $this->database = new DBManager();
    }
    
    /**
       * 
       * registra una regola notifica per un sensore
       *
       * @param Array $post Contiene le informazioni della regola notifica che vengono "postate"
       * @return Array con i valori della post e l'eventuale errore verificatosi (1-"ci sono ancora campi da compilare")
       */
    public function creaRegolaNotifica($post, $sensore, $min, $max){

       //Insert into MySql
      if (!preg_match('/[<>=]/', $post['operatore'])) {
        return Array(
            "error" => 2,
            "values" => Array (
              "operatore" => $post['operatore'],
              "valore_soglia" => $post['valore_soglia']
          )
        );
      }

      if($post['valore_soglia'] == null) {

        return Array(
            "error" => 1,
            "values" => Array (
              "operatore" => $post['operatore'],
              "valore_soglia" => $post['valore_soglia']
          )
        );
      }
      
      if($post['valore_soglia'] < $min || $post['valore_soglia'] > $max){
         return Array(
            "error" => 2,
            "values" => Array (
              "operatore" => $post['operatore'],
              "valore_soglia" => $post['valore_soglia']
          )
        );
      }
      

      $this->database->query("INSERT INTO regolanotifica(Sensore, Operazione, Valore) VALUES (:sens, :op, :val)");
      $this->database->bind(":sens", $sensore);
      $this->database->bind(":op", $post['operatore']);
      $this->database->bind(":val", $post['valore_soglia']);
      $this->database->execute();         
    } // fine creaRegolaNotifica()

    /**
       * 
       * Recupera le regole notifica relative ad un determinato sensore
       *
       * @param $idsensore che specifica il sensore di cui si vogliono recuperare le regole
       */
    public function getRegoleNotificaSensore($idsensore){
      $this->database->query("SELECT * FROM regolanotifica WHERE Sensore = :idsens");
      $this->database->bind(":idsens", $idsensore);
      $row = $this->database->resultSet();
      return $row;

    }

    /**
      *
      * Elimina la regola notifica il cui id è stato specificato come parametro
      *
      * @param $idregola che specifica la regola che si vuole eliminare
      */
    public function eliminaRegola($idregola){     
      $this->database->query("DELETE FROM regolanotifica WHERE IDRegola = :idrule");
      $this->database->bind(":idrule", $idregola);
      $this->database->execute(); 
   }

}