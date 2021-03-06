<?php

class DBManager {

    public $dbh;
    public $error;
    public $stmt;

    public function __construct(){
        //Set DSN
        $dsn = "mysql:host=".DB_HOST.";dbname=".DB_NAME;

        //Set options
        $options = array(
            PDO::ATTR_PERSISTENT     => true,
            PDO::ATTR_ERRMODE        => PDO::ERRMODE_EXCEPTION,
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
        );

        try{
            $this->dbh = new PDO($dsn, DB_USER, DB_PASS, $options);
        } catch (PDOEcepetion $e) {
            $this->error = $e->getMessage();
        }

    }

    public function query($query) {
        $this->stmt = $this->dbh->prepare($query);
    }

    public function bind($param, $value, $type = null) {

        if(is_null($type)) {
            switch(true) {
                case is_int($value):
                    $type = PDO::PARAM_INT;
                    break;
                
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                    break;
                
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;
                
                 default:
                    $type = PDO::PARAM_STR;
            
            }
        }

        $this->stmt->bindValue($param, $value, $type);
    }

    public function execute() {
        return $this->stmt->execute();
    }

    public function lastInsertId() {
        return $this->dbh->lastInsertId();
    }

    public function resultSet() {
        $check = $this->execute();
		if(!empty($check))
		{
			return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
		}
    }

    public function singleResultSet() {
        $check = $this->execute();
		if(!empty($check))
		{
			return $this->stmt->fetch(PDO::FETCH_ASSOC);
		}
        
    }

}