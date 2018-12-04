<?php
require_once 'DBManager.php';
require_once 'interfaces/ISenderManager.php';

class SenderManager implements ISenderManager{
    public $database;

    /*
     * Crea l'oggetto del Gestore Dababase
     */
    public function __construct(){
        $this->database = new DBManager();
    }


    public function inviaDati(){
        $this->database->query('SELECT IDCondivisione, Sensore, Canale, Valore, TipologiaCanale FROM Condivisione JOIN Canale ON Condivisione.Canale = Canale.IDCanale');
        $condivisioni = $this->database->resultSet();


        foreach ($condivisioni as $condivisione){
           
            $this->database->query('SELECT Data, Valore FROM Sensore JOIN Rilevazione ON IDSensore = Sensore WHERE IDSensore = :idsensore ORDER BY Data DESC LIMIT 20');
            $this->database->bind(':idsensore', $condivisione['Sensore']);
            $rilevazioni = $this->database->resultSet();


            if((int)$condivisione['TipologiaCanale']===1){
                 $this->inviaMail($rilevazioni, "Report rilevazioni sensore ".$condivisione['Sensore'], $condivisione['Valore'], "Report rilevazioni", SENDER_MAIL);
            }

            else {
                $this->inviaPOST($condivisione['Valore'], $rilevazioni);
            }   
            


        }
    }



    public function inviaPOST($url, $dati){
        // use key 'http' even if you send the request to https://...
        $options = array(
            'http' => array(
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => http_build_query($dati)
            )
        );
        $context  = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        if ($result === false) { /* Handle error */ }
    }



    public function create_csv_string($data) {
    
        // Open temp file pointer
        if (!$fp = fopen('php://temp', 'w+')) return false;
        
        fputcsv($fp, array('Data', 'Valore'));

        foreach($data as $dato) {
            fputcsv($fp, $dato);
        }
        
        // Place stream pointer at beginning
        rewind($fp);

        return stream_get_contents($fp);
    
    }
    


    
    public function inviaMail($csvData, $bodys, $to, $subject, $from) {
    
        // This will provide plenty adequate entropy
        $multipartSep = '-----'.password_hash(time(), PASSWORD_BCRYPT, array('cost' => 1));.'-----';
    
        // Arrays are much more readable
        $headers = array(
            "From: $from",
            "Reply-To: $from",
            "Content-Type: multipart/mixed; boundary=".$multipartSep
        );
    
        // Make the attachment
        $attachment = chunk_split(base64_encode($this->create_csv_string($csvData))); 
    
        // Make the body of the message
        $body = "--".$multipartSep."\r\n"
            . "Content-Type: text/plain; charset=ISO-8859-1; format=flowed\r\n"
            . "Content-Transfer-Encoding: 7bit\r\n"
            . "\r\n"
            . $bodys."\r\n"
            . "--".$multipartSep."\r\n"
            . "Content-Type: text/csv\r\n"
            . "Content-Transfer-Encoding: base64\r\n"
            . "Content-Disposition: attachment; filename=Report-rilevazioni-" . date("F-j-Y") . ".csv\r\n"
            . "\r\n"
            . $attachment."\r\n"
            . "--$multipartSep--";
    
        // Send the email, return the result
        mail($to, $subject, $body, implode("\r\n", $headers)); 
    
    }
    


}