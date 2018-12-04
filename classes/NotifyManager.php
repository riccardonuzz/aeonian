<?php
require_once 'DBManager.php';
require_once 'interfaces/INotifyManager.php';

class NotifyManager implements INotifyManager{
    public $database;

    /*
     * Crea l'oggetto del Gestore Dababase
     */
    public function __construct(){
        $this->database = new DBManager();
    }
    

    public function creaRegolaNotifica($post, $sensore, $min, $max){
		
		define( 'NOTIFY_EMPTYFIELD', 1 );
		define( 'NOTIFY_BADRANGE', 2 );

       //Insert into MySql
      if (!preg_match('/[<>=]/', $post['operatore'])) {
        return array(
            'error' => NOTIFY_BADRANGE,
            'values' => array (
              'operatore' => $post['operatore'],
              'valore_soglia' => $post['valore_soglia']
          )
        );
      }

      if($post['valore_soglia'] == null) {

        return array(
            'error' => NOTIFY_EMPTYFIELD,
            'values' => array (
              'operatore' => $post['operatore'],
              'valore_soglia' => $post['valore_soglia']
          )
        );
      }
      
      if($post['valore_soglia'] < $min || $post['valore_soglia'] > $max){
         return array(
            'error' => NOTIFY_BADRANGE,
            'values' => array (
              'operatore' => $post['operatore'],
              'valore_soglia' => $post['valore_soglia']
          )
        );
      }
      

      $this->database->query('INSERT INTO regolanotifica(Sensore, Operazione, Valore) VALUES (:sens, :op, :val)');
      $this->database->bind(':sens', $sensore);
      $this->database->bind(':op', $post['operatore']);
      $this->database->bind(':val', $post['valore_soglia']);
      $this->database->execute();         
    } // fine creaRegolaNotifica()

   


    public function getRegoleNotificaSensore($idsensore){
      $this->database->query('SELECT * FROM regolanotifica WHERE Sensore = :idsens');
      $this->database->bind(':idsens', $idsensore);
      $row = $this->database->resultSet();
      return $row;

    }

   

    
    public function eliminaRegola($idregola){     
      $this->database->query('DELETE FROM regolanotifica WHERE IDRegola = :idrule');
      $this->database->bind(':idrule', $idregola);
      $this->database->execute(); 
   }



   public function getNumeroNotifiche($utente) {
		$this->database->query('SELECT COUNT(*) AS Totale FROM notifica JOIN regolanotifica JOIN sensore JOIN ambiente JOIN impianto JOIN gestione ON notifica.Regola = regolanotifica.IDRegola AND regolanotifica.Sensore = sensore.IDSensore AND sensore.Ambiente = ambiente.IDAmbiente AND ambiente.Impianto = impianto.IDImpianto AND impianto.IDImpianto = gestione.Impianto WHERE Utente = :utente AND Letta = 0');
        $this->database->bind(':utente', $utente);
		return $this->database->SingleResultSet();
	}




	public function getUltimeNotifiche($utente) {
		$this->database->query('SELECT * FROM notifica JOIN regolanotifica JOIN sensore JOIN ambiente JOIN impianto JOIN gestione ON notifica.Regola = regolanotifica.IDRegola AND regolanotifica.Sensore = sensore.IDSensore AND sensore.Ambiente = ambiente.IDAmbiente AND ambiente.Impianto = impianto.IDImpianto AND impianto.IDImpianto = gestione.Impianto WHERE Utente = :utente ORDER BY IDNotifica DESC LIMIT 5');
    $this->database->bind(':utente', $utente);
		return $this->database->resultSet();
	}




	public function getNotifiche($utente) {
		$this->database->query('SELECT * FROM notifica JOIN regolanotifica JOIN sensore JOIN ambiente JOIN impianto JOIN gestione ON notifica.Regola = regolanotifica.IDRegola AND regolanotifica.Sensore = sensore.IDSensore AND sensore.Ambiente = ambiente.IDAmbiente AND ambiente.Impianto = impianto.IDImpianto AND impianto.IDImpianto = gestione.Impianto WHERE Utente = :utente ORDER BY IDNotifica DESC');
    $this->database->bind(':utente', $utente);
		return $this->database->resultSet();
  }
  

  public function trovaNotifica($idnotifica){
    $this->database->query('SELECT IDNotifica, sensore.IDSensore AS IDSensore, sensore.Nome AS NomeSensore, regolanotifica.Operazione AS Operazione, regolanotifica.Valore AS Valore, Minimo, Massimo, Marca, Messaggio, UnitaMisura, ambiente.Nome AS NomeAmbiente FROM notifica JOIN regolanotifica JOIN sensore JOIN ambiente JOIN impianto JOIN gestione JOIN tipologiasensore ON tipologiasensore.IDTipologiaSensore = sensore.TipologiaSensore AND notifica.Regola = regolanotifica.IDRegola AND regolanotifica.Sensore = sensore.IDSensore AND sensore.Ambiente = ambiente.IDAmbiente AND ambiente.Impianto = impianto.IDImpianto AND impianto.IDImpianto = gestione.Impianto WHERE IDNotifica = :idnotifica');
    $this->database->bind(':idnotifica', $idnotifica);

    return $this->database->singleResultSet();
  }



  public function leggi($idnotifica){
    $this->database->query('UPDATE notifica SET Letta=1 WHERE IDNotifica = :idnotifica');
    $this->database->bind(':idnotifica', $idnotifica);
    $this->database->execute();
  }





  public function checkNotifyProperty($idnotifica, $codicefiscale){
    $this->database->query('SELECT * FROM notifica JOIN regolanotifica JOIN sensore JOIN ambiente JOIN impianto JOIN gestione ON notifica.Regola = regolanotifica.IDRegola AND regolanotifica.Sensore = sensore.IDSensore AND sensore.Ambiente = ambiente.IDAmbiente AND ambiente.Impianto = impianto.IDImpianto AND impianto.IDImpianto = gestione.Impianto WHERE Utente = :utente AND IDNotifica = :idnotifica');
    $this->database->bind(':utente', $codicefiscale);
    $this->database->bind(':idnotifica', $idnotifica);
    $row = $this->database->singleResultSet();

    if(empty($row)===false){
      return 1;
    }

    return 0;
    
  }

 


  public function checkRuleProperty($idsensore, $codicefiscale) {
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
