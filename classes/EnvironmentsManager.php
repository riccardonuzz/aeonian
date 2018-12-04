<?php
require_once 'DBManager.php';
require_once 'interfaces/IEnvironmentsManager.php';

class EnvironmentsManager implements IEnvironmentsManager {
    public $database;

    /*
     * Crea l'oggetto del Gestore Dababase
     */
    public function __construct(){
        $this->database = new DBManager();
    }

    

    public function registraAmbiente($post,$idimpianto){

    	define( 'ENVIRONMENT_EMPTYFIELD', 1 );
	
		
      //Insert into MySql
      if( empty($post['nomeAmbiente']) === true || empty($post['descrizione']) === true ) {

        return array(
            'error' => ENVIRONMENT_EMPTYFIELD,
            'values' => array (
            'nomeAmbiente' => $post['nomeAmbiente'],
            'descrizione' => $post['descrizione']   
          )
        );
      }

      $this->database->query('INSERT INTO ambiente (Nome, Descrizione, Impianto) VALUES (:nome, :descrizione, :impianto)');
      $this->database->bind(':nome', $post['nomeAmbiente']);
      $this->database->bind(':descrizione', $post['descrizione']);
      $this->database->bind(':impianto', $idimpianto);
   
      $this->database->execute();
	 

    } // fine registraAmbiente()
    

    
    public function getAmbienti(){
        //Prendo le info dell'utente
        $this->database->query('SELECT IDAmbiente, ambiente.Impianto AS idimpianto, impianto.Nome AS impNome, ambiente.Nome AS ambNome, Descrizione FROM ambiente JOIN impianto ON Impianto = IDImpianto');
        $row = $this->database->resultSet();
        return $row;
    }



    public function getAmbientiImpianto($idimpianto){
      $this->database->query('SELECT impianto.Nome AS ImpNome, IDAmbiente, ambiente.Nome, Descrizione FROM ambiente JOIN impianto ON Impianto = IDImpianto WHERE Impianto = :imp');
      $this->database->bind(':imp', $idimpianto);
      $row = $this->database->resultSet();
      return $row;      
    }

   
    
    public function trovaAmbiente($idambiente){
      $this->database->query('SELECT IDAmbiente, ambiente.Nome AS ambNome, Descrizione, Impianto, impianto.Nome AS impNome FROM ambiente JOIN impianto ON Impianto = IDImpianto WHERE IDAmbiente = :idamb');
      $this->database->bind(':idamb', $idambiente);
      $row = $this->database->singleResultSet();
      return $row;
    }


    public function modificaAmbiente($post, $idamb){
     
      //Insert into MySql
      if(empty($post['nomeAmbiente']) === true || empty($post['descrizione']) === true) {

        return array(
            'error' => ENVIRONMENT_EMPTYFIELD,
            'values' => array (
            'nomeAmbiente' => $post['nomeAmbiente'],
            'descrizione' => $post['descrizione']   
          )
        );
      }

	  //print_r($post);
	  //print_r($idamb);

      $this->database->query('UPDATE ambiente SET Nome = :nomeamb,  Descrizione = :descr WHERE IDAmbiente = :idamb ');
      $this->database->bind(':nomeamb', $post['nomeAmbiente']);
      $this->database->bind(':descr', $post['descrizione']);
      $this->database->bind(':idamb', $idamb);
      $this->database->execute();
	  
	  //return $idamb;
    }



    public function eliminaAmbiente($idambiente){

      $this->database->query('DELETE FROM ambiente WHERE IDAmbiente = :idamb');
      $this->database->bind(':idamb', $idambiente);
      $this->database->execute();

    }


    
    
    public function checkProperty($idambiente, $codicefiscale) {
      $this->database->query('SELECT * FROM gestione JOIN ambiente ON gestione.Impianto = ambiente.Impianto WHERE IDAmbiente = :idambiente AND Utente = :codicefiscale');
      $this->database->bind(':codicefiscale', $codicefiscale);
      $this->database->bind(':idambiente', $idambiente);
      $row = $this->database->singleResultSet();
  
      if(empty($row)===false){
        return 1;
      }
  
      return 0;
      
    }

}
