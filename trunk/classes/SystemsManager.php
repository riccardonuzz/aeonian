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
       * modifica un impianto (system)
       *
       * @param Array $post Contiene le informazioni dell'impianto che vengono "postate" (al momento della compilazione
       * del form)
       * @return Array con i valori della post e l'eventuale errore verificatosi (1-"ci sono ancora campi da compilare")
       */
    public function modificaImpianto($post, $idimpianto){

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

      $this->database->query("UPDATE impianto SET Nome = :nome, Nazione = :nazione, Provincia = :provincia, Indirizzo = :indirizzo, CAP = :cap, Citta = :citta WHERE IDImpianto = :idimp");
      $this->database->bind(":nome", $post['nomeimpianto']);
      $this->database->bind(":nazione", $post['nazione']);
      $this->database->bind(":provincia", $post['provincia']);
      $this->database->bind(":indirizzo", $post['indirizzo']);
      $this->database->bind(":cap", $post['cap']);
      $this->database->bind(":citta", $post['citta']);
      $this->database->bind(":idimp", $idimpianto);
      $this->database->execute();

      $responsabili = isset($_POST['responsabile']) ? $_POST['responsabile'] : array();
      $vecchiResponsabili = $this->respFromImpianto($idimpianto);

      foreach ($vecchiResponsabili as $vResp) {
        if(!in_array($vResp['CodiceFiscale'], $responsabili)) {
          $this->database->query("DELETE FROM gestione WHERE Utente = :user AND Impianto = :imp" );
          $this->database->bind(":imp", $idimpianto);
          $this->database->bind(":user", $vResp['CodiceFiscale']);
          $this->database->execute();
        }
      }

      foreach ($responsabili as $nResp) {
        if(!($this->isResponsabile($nResp, $idimpianto))) {
          $this->database->query("INSERT INTO gestione VALUES(:impianto, :utente)");
          $this->database->bind(":impianto", $idimpianto);
          $this->database->bind(":utente", $nResp);
          $this->database->execute();
        }
      }    
    } // fine di modificaImpianto

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

   public function isResponsabile($idutente, $idimpianto){

        $this->database->query("SELECT * from  gestione WHERE Utente = :idcliente and Impianto = :idimp");
        $this->database->bind(":idimp", $idimpianto);
        $this->database->bind(":idcliente", $idutente);
        $row = $this->database->resultSet();
        if($row != null){
          return True;
        }
        else{
          return False;
        }      
   }

}
