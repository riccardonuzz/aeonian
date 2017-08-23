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
       * registra un'ambiente (enviroment)
       *
       * @param Array $post Contiene le informazioni dell'ambiente che vengono "postate"
       * @return void
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

      $this->database->query("INSERT INTO ambiente VALUES (:id, :nome, :descrizione, :impianto )");
      $this->database->bind(":id", '');
      $this->database->bind(":nome", $post['nomeAmbiente']);
      $this->database->bind(":descrizione", $post['descrizione']);
      $this->database->bind(":impianto", $idimpianto);
   
      $this->database->execute();


      
     
      

      
    
   

    }
    

    /**
       * 
       * Restituisce lista degli
       *
       * @return Array $row  lista di tutti gli impianti
       */
    public function getImpianti(){
        //Prendo le info dell'utente
        $this->database->query("SELECT * FROM impianto");
        $row = $this->database->resultSet();
        return $row;
    }

    
    /**
       * 
       * Restituisce lista degli impianti relativi ad un utente
       * @param string $utente indica il codice fiscale con il quale ricercare l'utente e i relativi impianti
       * @return Array $row lista degli impianti di un utente
       */
    public function getImpiantiUtente($utente){
        
        $this->database->query("SELECT * from gestione JOIN impianto ON Impianto = IDImpianto WHERE Utente = :codicefiscale");
        $this->database->bind(":codicefiscale", $utente);
        $row = $this->database->resultSet();
        return $row;
    }



   public function trovaImpianto($idimpianto){
        $this->database->query("SELECT * from impianto WHERE IDImpianto = :id");
        $this->database->bind(":id", $idimpianto);
        $row = $this->database->singleResultSet();
        return $row;

   }
   
   public function respFromImpianto($idimpianto){
        $this->database->query("SELECT * from  gestione JOIN utente WHERE Utente=CodiceFiscale  and Impianto = :id");
        $this->database->bind(":id", $idimpianto);
        $row = $this->database->singleResultSet();
        return $row;

   }

}