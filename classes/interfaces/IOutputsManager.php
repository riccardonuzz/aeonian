<?php

interface IOutputsManager {

    /*
	*	Scompone, verifica e acquisisce le stringhe fornite in input dai sensori
	*
	*	Slice1 - sensore, 
	*	Slice2 - timestamp,
	*	Slice3 - valore della rilevazione
	*
	*/
    public function elaboraStringa( $stringa );
    

    public function creaNotifica( $value, $notifyRule );


    /**
       * 
       * Prende tutte le rilevazioni di un sensore
       * @param int $IDSensore  Id del sensore del quale vogliamo rilevazioni
       * @return array  Contiene tutte le rilevazioni di un sensore
       */
    public function getRilevazioni($IDSensore);



    /*
	*	Verifica la corrispondenza dei valori rilevati con le regole di notifica imposte.
	*	Restituisce TRUE se la regola di notifica è verificata e deve essere generata una notifica.
	*/
    public function controlloNotifica( $value, $notifyRule );
    
}