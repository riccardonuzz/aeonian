<?php
require_once("DBManager.php");

class OutputsManager {
    private $database;

    /*
     * Crea l'oggetto del Gestore Dababase
     */
	 
    public function __construct(){
        $this->database = new DBManager();
    }
	
	/*
	*	Scompone, verifica e acquisisce le stringhe fornite in input dai sensori
	*
	*	Slice1 - sensore, 
	*	Slice2 - timestamp,
	*	Slice3 - valore della rilevazione
	*
	*/
	
	public function elaboraStringa( $stringa ) {
		
		list ( $slice1, $slice3 ) = explode("-", $stringa );
		
		$sensor = $slice1;
		$value = str_replace( ',', '.', $slice3 );
	
		echo "Sensore: " . $sensor . " - Valore: " . $value . "<br>";
		
		$this->database->query( "INSERT INTO rilevazione ( Sensore, Valore) VALUES ( :sensore, :valore ) " );
		$this->database->bind( ":sensore", $sensor );
		$this->database->bind( ":valore", $value );
   
		$this->database->execute();
	}

	public function creaNotifica( $notifica ) {
		
	}

    public function getRilevazioni($IDSensore){
        $this->database->query("SELECT * FROM rilevazione JOIN tipologiasensore JOIN sensore ON sensore.IDSensore = rilevazione.Sensore AND sensore.TipologiaSensore = tipologiasensore.IDTipologiaSensore WHERE Sensore = :idsensore ORDER BY Data ASC");
        $this->database->bind(":idsensore", $IDSensore);
        $row = $this->database->resultSet();
        return $row;
    }
	
	public function controlloNotifica( $rilevazione ) {
		
	}
	
	public function trovaRilevazione ( $parametri ) {
		
	}

}