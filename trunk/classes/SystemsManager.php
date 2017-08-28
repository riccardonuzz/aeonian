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
       * @param Array $post Contiene le informazioni dell'impianto che vengono "postate" (al momento della compilazione
       * del form)
       * @return Array con i valori della post e l'eventuale errore verificatosi (1-"ci sono ancora campi da compilare")
       */
    public function registraImpianto($post){

      //Insert into MySql
      if(empty($post['nomeimpianto']) || empty($post['nazione']) || empty($post['provincia']) || empty($post['indirizzo']) || empty($post['cap']) || empty($post['citta'])|| empty($post['responsabile'])) {

        return Array(
            "error" => 1,
            "values" => Array (
                "nomeimpianto" => $post['nomeimpianto'],
                "nazione" => $post['nazione'],
                "provincia" => $post['provincia'],
                "indirizzo" => $post['indirizzo'],
                "cap" => $post['cap'],
                "citta" => $post['citta']
            )
        );
      }

         // Controllo che il CAP sia di esattamente 5 caratteri
      if(strlen($post['cap']) != 5 || !ctype_digit($post['cap'])){
        return Array(
            "error" => 2,
            "values" => Array (
                "nomeimpianto" => $post['nomeimpianto'],
                "nazione" => $post['nazione'],
                "provincia" => $post['provincia'],
                "indirizzo" => $post['indirizzo'],
                "cap" => $post['cap'],
                "citta" => $post['citta']
            )
        );
      }

      $this->database->query("INSERT INTO impianto (Nome, Nazione, Provincia, Indirizzo, CAP, Citta) VALUES (:nome, :nazione, :provincia, :indirizzo, :CAP, :citta)");
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

      //Inserimento all'interno della tabella gestione di tutti i responsabili dell'impianto appena registrato
      $responsabili = isset($_POST['responsabile']) ? $_POST['responsabile'] : array();
      foreach ($responsabili as $resp) {
        //Inserisco una nuova tupla nella tabella gestione
        $this->database->query("INSERT INTO gestione VALUES (:impianto, :utente)");
        $this->database->bind(":impianto", $idimpianto);
        $this->database->bind(":utente", $resp);
        $this->database->execute();
      }
      
      
    } // fine di registraImpianto
    

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
        $this->database->query("SELECT * from  gestione JOIN utente WHERE Utente=CodiceFiscale and Impianto = :id");
        $this->database->bind(":id", $idimpianto);
        $row = $this->database->resultSet();
        return $row;

   }

   public function isResponsabile($idcliente,$idimpianto){

        $this->database->query("SELECT * from  gestione JOIN utente WHERE Utente=:$idcliente and Impianto = :id");
        $this->database->bind(":id", $idimpianto);
        $this->database->bind(":idcliente", $idimpianto);
        $row = $this->database->resultSet();
        if($row!= null){
          return True;
        }
        else{
          return False;
        }

      
   }

}
