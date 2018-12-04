<?php
require_once 'DBManager.php';
require_once 'interfaces/ISensorsManager.php';


class SensorsManager implements ISensorsManager{
    public $database;

    /*
     * Crea l'oggetto del Gestore Dababase
     */
    public function __construct(){
        $this->database = new DBManager();
    }
    
    public function registraSensore($post,$idambiente){

		define( 'SENSOR_EMPTYFIELD', 1 );
		define( 'SENSOR_BADID', 2 );
		define( 'SENSOR_DOUBLEID', 3 );
    define( 'SENSOR_INVALID_RANGE', 4 );
    
      //Insert into MySql
      if(empty($post['nomesensore']) || empty($post['tipo']) || empty($post['marca'])|| empty($post['idsensore']) || $post['minimo'] == null || $post['massimo'] == null) {

        return array(
            'error' => SENSOR_EMPTYFIELD,
            'values' => array (
            'nomesensore' => $post['nomesensore'],
            'tipo' => $post['tipo'],
            'marca' => $post['marca'],
            'idsensore' => $post['idsensore'],
            'minimo' => $post['minimo'],
            'massimo' => $post['massimo']
          )
        );
      }

      if(!preg_match('/[A-Z0-9]{10}/',$post['idsensore'])){

        return array(
            'error' => SENSOR_BADID,
            'values' => array (
            'nomesensore' => $post['nomesensore'],
            'tipo' => $post['tipo'],
            'marca' => $post['marca'],
            'idsensore' => $post['idsensore'],
            'minimo' => $post['minimo'],
            'massimo' => $post['massimo']
          )
        );
      }

      if($this->sensorAlreadyExists($post['idsensore'])){

        return array(
            'error' => SENSOR_DOUBLEID,
            'values' => array (
            'nomesensore' => $post['nomesensore'],
            'tipo' => $post['tipo'],
            'marca' => $post['marca'],
            'idsensore' => $post['idsensore'],
            'minimo' => $post['minimo'],
            'massimo' => $post['massimo']
          )
        );
      }

      if($post['minimo'] > $post['massimo']) {

        return array(
            'error' => SENSOR_INVALID_RANGE,
            'values' => array (
            'nomesensore' => $post['nomesensore'],
            'tipo' => $post['tipo'],
            'marca' => $post['marca'],
            'idsensore' => $post['idsensore'],
            'minimo' => $post['minimo'],
            'massimo' => $post['massimo']
          )
        );
      }

      $this->database->query('INSERT INTO sensore(IDSensore,Nome, Ambiente, TipologiaSensore, Marca, Minimo, Massimo) VALUES (:id,:nome, :ambiente, :tipologia, :marca, :min, :max)');
      $this->database->bind(':id', $post['idsensore']);
      $this->database->bind(':nome', $post['nomesensore']);
      $this->database->bind(':ambiente', $idambiente);
      $this->database->bind(':tipologia', $post['tipo']);
      $this->database->bind(':marca', $post['marca']);
      $this->database->bind(':min', $post['minimo']);
      $this->database->bind(':max', $post['massimo']);
      $this->database->execute();

    } // fine registraSensore()
    
    
    
    public function sensorAlreadyExists($idsensore){
      $this->database->query('SELECT * FROM sensore WHERE IDSensore = :idsensore');
      $this->database->bind(':idsensore', $idsensore);
      $row = $this->database->resultSet();

      if($row != null){
        return true;
      }else{
        return false;
      }
    }

    
     
    public function modificaSensore($post, $idsens){
      //Insert into MySql
      if(empty($post['nomesensore']) || empty($post['tipo']) || empty($post['marca']) || $post['minimo'] == null || $post['massimo'] == null) {

        return array(
            'error' => SENSOR_EMPTYFIELD,
            'values' => array (
            'nomesensore' => $post['nomesensore'],
            'tipo' => $post['tipo'],
            'marca' => $post['marca'],
            'idsensore' => $post['idsensore'],
            'minimo' => $post['minimo'],
            'massimo' => $post['massimo']
		      )
	      );
      }

      if($post['minimo'] > $post['massimo']) {

        return array(
            'error' => SENSOR_INVALID_RANGE,
            'values' => array (
            'nomesensore' => $post['nomesensore'],
            'tipo' => $post['tipo'],
            'marca' => $post['marca'],
            'minimo' => $post['minimo'],
            'massimo' => $post['massimo']
          )
        );
      }


      $this->database->query('UPDATE sensore SET Nome = :nomesens, TipologiaSensore = :tipo, Marca = :marca, Minimo = :min, Massimo = :max WHERE IDSensore = :idsens ');
      $this->database->bind(':nomesens', $post['nomesensore']);
      $this->database->bind(':tipo', $post['tipo']);
      $this->database->bind(':marca', $post['marca']);
      $this->database->bind(':idsens', $idsens);
      $this->database->bind(':min', $post['minimo']);
      $this->database->bind(':max', $post['massimo']);
      $this->database->execute();
    }


    public function getTipi(){
      $this->database->query('SELECT * FROM tipologiasensore');
      return $this->database->resultSet();
    }

    public function trovaSensore($idsensore){
      $this->database->query('SELECT Minimo, Massimo, TipologiaSensore, UnitaMisura, Marca, Ambiente, IDImpianto, IDSensore, sensore.Nome AS sensNome, tipologiasensore.Nome AS tipoNome, ambiente.Nome AS ambNome, impianto.Nome AS impNome FROM sensore JOIN tipologiasensore JOIN ambiente JOIN impianto ON TipologiaSensore = IDTipologiaSensore AND sensore.Ambiente = ambiente.IDAmbiente AND ambiente.Impianto = impianto.IDImpianto WHERE IDSensore = :idsens');
      $this->database->bind(':idsens', $idsensore);
      return $this->database->singleResultSet();
    }

    public function getSensori(){
        //Prendo le info dell'utente
        $this->database->query('SELECT sensore.Ambiente AS sensAmb, ambiente.Impianto AS sensImp, IDSensore, sensore.Nome AS sensNome, tipologiasensore.Nome AS tipoNome, ambiente.Nome AS ambNome, impianto.Nome AS impNome FROM sensore JOIN tipologiasensore JOIN ambiente JOIN impianto ON TipologiaSensore = IDTipologiaSensore AND sensore.Ambiente = ambiente.IDAmbiente AND ambiente.Impianto = impianto.IDImpianto');
        return $this->database->resultSet();
    }

    public function getSensoriAmbiente($idambiente){
      $this->database->query('SELECT IDSensore, sensore.Nome AS sensNome, tipologiasensore.Nome AS tipoNome, UnitaMisura FROM sensore JOIN tipologiasensore ON TipologiaSensore = IDTipologiaSensore WHERE Ambiente = :amb');
      $this->database->bind(':amb', $idambiente);
      return $this->database->resultSet();    
    }

    public function eliminaSensore($idsensore){
      
      $this->database->query('DELETE FROM sensore WHERE IDSensore = :idsens');
      $this->database->bind(':idsens', $idsensore);
      $this->database->execute();
  
   }
 
   public function checkProperty($idsensore, $codicefiscale) {
      $this->database->query('SELECT * FROM gestione JOIN ambiente JOIN sensore ON gestione.Impianto = ambiente.Impianto AND ambiente.IDAmbiente = sensore.Ambiente WHERE IDSensore = :idsensore AND Utente = :codicefiscale');
      $this->database->bind(':codicefiscale', $codicefiscale);
      $this->database->bind(':idsensore', $idsensore);
      $row = $this->database->singleResultSet();

      if(empty($row)===false){
        return 1;
      }

      return 0;
    
  }
    

}
