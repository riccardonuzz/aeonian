<?php
require_once("DBManager.php");
require_once("NotifyManager.php");

class OutputsManager {
    private $database;

    /*
     * Crea l'oggetto del Gestore Dababase
     */
	 
    public function __construct()
	{
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
	
	public function elaboraStringa( $stringa )
	{
		list ( $slice1, $slice3 ) = explode("-", $stringa );
		
		$sensor = $slice1;
		$value = str_replace( ',', '.', $slice3 );
		
		/*
		*	Interfaccia con il gestore delle notifiche e controllo della presenza di regole di notifica relative al sensore sorgente.
		*/		

		$notifyManager = new NotifyManager();
		$notifyRules = $notifyManager->getRegoleNotificaSensore( $sensor );

		if( isset( $notifyRules ) )
		{		
			foreach( $notifyRules as $notifyRule ) 
			{
				$response = $this->controlloNotifica( $value, $notifyRule );
				
				if( $response == true )
				{
					$this->creaNotifica( $value, $notifyRule );
				}
			}
		}
		
		/*
		*	Generazione della rilevazione.
		*/
		
		$this->database->query( "INSERT INTO rilevazione ( Sensore, Valore) VALUES ( :sensore, :valore ) " );
		$this->database->bind( ":sensore", $sensor );
		$this->database->bind( ":valore", $value ); 
		$this->database->execute();
	}

	public function creaNotifica( $value, $notifyRule )
	{
		$this->database->query( "INSERT INTO notifica ( Regola, Messaggio ) VALUES ( :regola, :messaggio ) " );
		$this->database->bind( ":regola", $notifyRule['IDRegola'] );
		$this->database->bind( ":messaggio", $value . " " . $notifyRule['Operazione'] . " " . $notifyRule['Valore'] );   
		$this->database->execute();			
	}

    public function getRilevazioni($IDSensore)
	{
        $this->database->query("SELECT * FROM rilevazione JOIN tipologiasensore JOIN sensore ON sensore.IDSensore = rilevazione.Sensore AND sensore.TipologiaSensore = tipologiasensore.IDTipologiaSensore WHERE Sensore = :idsensore ORDER BY Data ASC");
        $this->database->bind(":idsensore", $IDSensore);
        $row = $this->database->resultSet();
		
        return $row;
    }
	
	/*
	*	Verifica la corrispondenza dei valori rilevati con le regole di notifica imposte.
	*	Restituisce TRUE se la regola di notifica è verificata e deve essere generata una notifica.
	*/
	
	public function controlloNotifica( $value, $notifyRule )
	{
		switch ( $notifyRule['Operazione'] )
		{
			case '<': if( $value < $notifyRule['Valore'] ) return true;
				break;
			case '>': if( $value > $notifyRule['Valore'] ) return true;
				break;
			case '=': if( $value = $notifyRule['Valore'] ) return true;
				break;
			default: return false;
				break;
		}	
	}
	
	public function trovaRilevazione ( $parametri )
	{
		
	}

	public function getNumeroNotifiche($utente) {
		$this->database->query("SELECT COUNT(*) AS Totale FROM notifica JOIN regolanotifica JOIN sensore JOIN ambiente JOIN impianto JOIN gestione ON notifica.Regola = regolanotifica.IDRegola AND regolanotifica.Sensore = sensore.IDSensore AND sensore.Ambiente = ambiente.IDAmbiente AND ambiente.Impianto = impianto.IDImpianto AND impianto.IDImpianto = gestione.Impianto WHERE Utente = :utente AND Letta = 0");
        $this->database->bind(":utente", $utente);
		return $this->database->SingleResultSet();
	}

	public function getUltimeNotifiche($utente) {
		$this->database->query("SELECT * FROM notifica JOIN regolanotifica JOIN sensore JOIN ambiente JOIN impianto JOIN gestione ON notifica.Regola = regolanotifica.IDRegola AND regolanotifica.Sensore = sensore.IDSensore AND sensore.Ambiente = ambiente.IDAmbiente AND ambiente.Impianto = impianto.IDImpianto AND impianto.IDImpianto = gestione.Impianto WHERE Utente = :utente ORDER BY IDNotifica DESC LIMIT 5");
        $this->database->bind(":utente", $utente);
		return $this->database->resultSet();
	}

	public function getNotifiche($utente) {
		$this->database->query("SELECT * FROM notifica JOIN regolanotifica JOIN sensore JOIN ambiente JOIN impianto JOIN gestione ON notifica.Regola = regolanotifica.IDRegola AND regolanotifica.Sensore = sensore.IDSensore AND sensore.Ambiente = ambiente.IDAmbiente AND ambiente.Impianto = impianto.IDImpianto AND impianto.IDImpianto = gestione.Impianto WHERE Utente = :utente ORDER BY IDNotifica DESC");
        $this->database->bind(":utente", $utente);
		return $this->database->resultSet();
	}
	
}