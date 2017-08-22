<?php
require_once("DBManager.php");

class SystemsManager {
    private $database;

    /*
     * Crea l'oggetto del Gestore Dababase
     */
    public function __construct(){
        $this->database = new DBManager();
    }

    /**
       * 
       * registra un impianto (system)
       *
       * @param Array $post Contiene le informazioni dell'impianto che vengono "postate"
       * @return void
       */
    public function registraImpianto($post){

      /*
      private function controlloCF($post['responsabile']){
        $this->database->query("SELECT CodiceFiscale FROM utenti WHERE CodiceFiscale = :codicefiscale AND Ruolo = 2");
        $this->database->bind(":codicefiscale", $post['responsabile']);
        $row = $this->database->resultSet();
        return $row;
      }
      */
      //Insert into MySql
      $this->database->query("INSERT INTO impianto VALUES (:id, :nome, :nazione, :provincia, :indirizzo, :CAP, :citta)");
      $this->database->bind(":id", '');
      $this->database->bind(":nome", $post['nomeimpianto']);
      $this->database->bind(":nazione", $post['nazione']);
      $this->database->bind(":provincia", $post['provincia']);
      $this->database->bind(":indirizzo", $post['indirizzo']);
      $this->database->bind(":CAP", $post['cap']);
      $this->database->bind(":citta", $post['citta']);
      $this->database->execute();

      
      //Seleziono l'id dell'ultimo impianto inserito
      $this->database->query("SELECT IDImpianto FROM impianto ORDER BY IDImpianto DESC LIMIT 1");
      $row = $this->database->resultSet();
      $idimpianto = 0;
      foreach ($row as $result) {
        $idimpianto = $result['IDImpianto'];
      }

      
      //$idimpianto = $row->fetchColumn(0);
      //Inserisco una nuova tupla nella tabella gestione
      $this->database->query("INSERT INTO gestione VALUES (:impianto, :utente)");
      $this->database->bind(":impianto", $idimpianto);
      $this->database->bind(":utente", $post['responsabile']);
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
        $this->database->query("SELECT Nome, Indirizzo, Citta FROM impianto");
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

}
