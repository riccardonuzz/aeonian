<?php

require_once("DBManager.php");
require_once("interfaces/IDashboardManager.php");

class DashboardManager implements IDashboardManager{
    private $database;

    /*
     * Crea l'oggetto del Gestore Dababase
     */
    public function __construct(){
        $this->database = new DBManager();
    }



    public function getDatiDashboard($idImpianto){

      $this->database->query("SELECT * FROM Impianto WHERE IDImpianto = :idimpianto");
      $this->database->bind(":idimpianto", $idImpianto);
      $impianti = $this->database->resultSet();

      $json_response = Array();

      foreach ($impianti as $impianto){

            $row_array = array();
        
            $row_array['IDImpianto'] = intval($impianto['IDImpianto']);        
            $row_array['Nome'] = $impianto['Nome'];
            $row_array['Ambienti'] = Array();
            $temp_IdImpianto = intval($impianto['IDImpianto']);  

            $this->database->query("SELECT * FROM Ambiente WHERE Impianto = :idimpianto");
            $this->database->bind(":idimpianto", $temp_IdImpianto);
            $ambienti = $this->database->resultSet();

            $i=0; 
            foreach ($ambienti as $ambiente){
                
                array_push($row_array['Ambienti'], Array(
                    "IDAmbiente" => intval($ambiente['IDAmbiente']),
                    "Nome" => $ambiente['Nome'],
                    "Sensori" => Array()
                ));

                $temp_IdAmbiente = intval($ambiente['IDAmbiente']); 

                $this->database->query("SELECT IDSensore, Sensore.Nome AS Nome, Ambiente, UnitaMisura FROM Sensore JOIN Tipologiasensore ON Sensore.TipologiaSensore=Tipologiasensore.IDTipologiaSensore WHERE Ambiente = :idambiente");
                $this->database->bind(":idambiente", $temp_IdAmbiente);
                $sensori = $this->database->resultSet();

                $k=0;      
                foreach ($sensori as $sensore) {
                    

                    $temp_IdSensore = $sensore['IDSensore'];

                    $this->database->query("SELECT CAST(AVG(Valore) AS DECIMAL(6, 2)) AS Media FROM rilevazione WHERE Sensore = :idsensore");
                    $this->database->bind(":idsensore", $temp_IdSensore);
                    $media = $this->database->singleResultSet();

                    $this->database->query("SELECT CAST(MIN(Valore) AS DECIMAL(6, 2)) AS Min FROM rilevazione WHERE Sensore = :idsensore");
                    $this->database->bind(":idsensore", $temp_IdSensore);
                    $min = $this->database->singleResultSet();

                    $this->database->query("SELECT CAST(MAX(Valore) AS DECIMAL(6, 2)) AS Max FROM rilevazione WHERE Sensore = :idsensore");
                    $this->database->bind(":idsensore", $temp_IdSensore);
                    $max = $this->database->singleResultSet();

                    array_push($row_array['Ambienti'][$i]['Sensori'], Array(
                        "IDSensore" => $sensore['IDSensore'],
                        "Nome" => $sensore['Nome'],
                        "UnitaMisura" => $sensore['UnitaMisura'],
                        "Ambiente" => $sensore['Ambiente'],
                        "Max" => $max['Max'],
                        "Min" => $min['Min'],
                        "Media" => $media['Media'],
                        "Rilevazioni" => Array()
                    ));

                    

                    $this->database->query("SELECT * FROM Rilevazione WHERE Sensore = :idsensore ORDER BY Data LIMIT 15");
                    $this->database->bind(":idsensore", $temp_IdSensore);
                    $rilevazioni = $this->database->resultSet();

                    
                    foreach ($rilevazioni as $rilevazione) {
                        array_push($row_array['Ambienti'][$i]['Sensori'][$k]['Rilevazioni'], Array(
                            "value" => floatval($rilevazione['Valore']),
                            "Data" => $rilevazione['Data']
                        ));

                        
                    }

                    $k++;
                }
                $i++;
            }

            array_push($json_response, $row_array); //push the values in the array
      }
       
    //   print "<pre>";
    //   print_r($json_response);
    //   print "</pre>";
    //   exit;

      return $json_response;
      

    }



    
    
    public function checkProperty($idimpianto, $codicefiscale) {
        $this->database->query("SELECT * FROM gestione WHERE Impianto = :idimpianto AND Utente = :codicefiscale");
        $this->database->bind(":codicefiscale", $codicefiscale);
        $this->database->bind(":idimpianto", $idimpianto);
        $row = $this->database->singleResultSet();
    
        if($row){
          return 1;
        }
    
        return 0;
        
      }

}

?>