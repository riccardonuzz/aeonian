<?php
require_once 'DBManager.php';
require_once 'interfaces/ISharesManager.php';

class SharesManager implements ISharesManager{
    public $database;

    /*
     * Crea l'oggetto del Gestore Dababase
     */
    public function __construct(){
        $this->database = new DBManager();
    }





    public function creaCondivisione($post, $idsensore) {
        if($post['terzaparte']==0 || !isset($post['canale'])) {
            return array (
                'error' => 1,
                'idsensore' => $idsensore
            );
        }

        if($this->shareAlreadyExists($post['terzaparte'], $idsensore, $post['canale'])) {
            return array (
                'error' => 2,
                'idsensore' => $idsensore
            );
        }

        $this->database->query('INSERT INTO condivisione(Sensore, Canale, TerzaParte) VALUES (:sensore, :canale, :terzaparte)');
        $this->database->bind(':sensore', $idsensore);
        $this->database->bind(':canale', $post['canale']);
        $this->database->bind(':terzaparte', $post['terzaparte']);
        $this->database->execute();
    }




    public function getCondivisioni($idambiente){
        $this->database->query('SELECT IDCondivisione, sensore.Nome AS NomeSensore, terzaparte.Nome AS NomeTerzaParte, tipologiacanale.Nome AS NomeTipologiaCanale FROM condivisione JOIN sensore JOIN canale JOIN terzaparte JOIN tipologiacanale ON condivisione.Sensore = sensore.IDSensore AND condivisione.Canale = canale.IDCanale AND condivisione.TerzaParte = terzaparte.IDTerzaParte AND canale.TipologiaCanale = tipologiacanale.IDTipologiaCanale WHERE sensore.Ambiente = :idambiente');
        $this->database->bind(':idambiente', $idambiente);
        return $this->database->resultSet();
    }




    public function shareAlreadyExists($idterzaparte, $idsensore, $idcanale){
        $this->database->query('SELECT * FROM condivisione WHERE TerzaParte = :terzaparte AND Canale = :canale AND Sensore = :sensore');
        $this->database->bind(':terzaparte', $idterzaparte);
        $this->database->bind(':canale', $idcanale);
        $this->database->bind(':sensore', $idsensore);
        $row = $this->database->singleResultSet();

        if(empty($row)===false){
            return 1;
        }

        return 0;
    }



    public function eliminaCondivisione($id) {
        //eliminazione di una terza parte
        $this->database->query('DELETE FROM condivisione WHERE IDCondivisione= :idcondivisione');
        $this->database->bind(':idcondivisione', $id); 
        $this->database->execute();
    }





    public function trovaCondivisione($id) {
        $this->database->query('SELECT IDCondivisione, ambiente.Impianto AS Impianto, sensore.Ambiente AS Ambiente, Valore, sensore.Nome AS NomeSensore, terzaparte.Nome AS NomeTerzaParte, tipologiacanale.Nome AS NomeTipologiaCanale FROM condivisione JOIN sensore JOIN canale JOIN terzaparte JOIN tipologiacanale JOIN ambiente ON condivisione.Sensore = sensore.IDSensore AND condivisione.Canale = canale.IDCanale AND condivisione.TerzaParte = terzaparte.IDTerzaParte AND canale.TipologiaCanale = tipologiacanale.IDTipologiaCanale AND sensore.Ambiente = ambiente.IDAmbiente WHERE IDCondivisione = :idcondivisione');
        $this->database->bind(':idcondivisione', $id);
        return $this->database->singleResultSet();
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



    
    public function checkShareProperty($idcondivisione, $codicefiscale) {
        $this->database->query('SELECT * FROM condivisione JOIN terzaparte ON condivisione.TerzaParte = terzaparte.IDTerzaParte WHERE condivisione.IDCondivisione = :idcondivisione AND terzaparte.Utente = :codicefiscale');
        $this->database->bind(':codicefiscale', $codicefiscale);
        $this->database->bind(':idcondivisione', $idcondivisione);
        $row = $this->database->singleResultSet();
  
        if(empty($row)===false){
          return 1;
        }
  
        return 0;
      
    }



}