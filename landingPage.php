<?php
$get = filter_input_array(INPUT_GET, FILTER_SANITIZE_URL); 
if( isset ( $get['getSensorList'] ) === true ) {
	$landing = new Landing();	
	$sensors = $landing->getListaSensori();
	
	 $json = json_encode( $sensors );
	 echo($json);
}

class Landing {
	public $database;

    /*
     * Crea l'oggetto del Gestore Dababase
     */
    public function __construct() {
		require_once 'config.php';
		require_once 'classes/DBManager.php';
        $this->database = new DBManager();
    }
	public function getListaSensori() {
		$query = 'SELECT s.IDSensore IDSensore, t.Nome TipologiaSensore, s.Minimo Minimo, s.Massimo Massimo ' .
				'FROM sensore s ' . 
				'JOIN ambiente a on s.Ambiente = a.IDAmbiente ' .
				'JOIN impianto i on a.Impianto = i.IDImpianto ' .
				'JOIN tipologiasensore t on s.TipologiaSensore = t.IDTipologiaSensore ' .
				//	'WHERE i.IDImpianto = 1 ' +
				'ORDER BY s.TipologiaSensore';
		$this->database->query( $query );
		$sensors = $this->database->resultSet();
		
		return $sensors;
	}
}