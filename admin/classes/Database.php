<?php

class Database {

    public function __construct() {
        $this->isConnected = true;

        try {

            $dbhost = $_SERVER['HOSTS']; 
            $dbname = $_SERVER['DB'];
            $username = $_SERVER['USER'];
            $password = $_SERVER['PWD'];

            $charset = 'utf8';
            $dbport = "3306";

            $dsn = "mysql:host={$dbhost};port={$dbport};dbname={$dbname};charset={$charset}";
            
            $this->datab = new PDO($dsn, $username, $password);
            $this->datab->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->datab->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            $this->isConnected = false;
            throw new Exception($e->getMessage());
        }

    }

    public function Disconnect() {
        $this->datab = null;
        $this->isConnected = false;
    }

    public function getRow($query, $values = array()) {
        try {
            $stmt = $this->datab->prepare($query);

            $stmt->execute($values);
            return $stmt->fetch();
        } catch (PDOException $e) {
            throw new Exception($e->getMessage() . ". The get row query is $query");
        }
    }

    public function getRows($query, $values = array()) {
        try {
            $stmt = $this->datab->prepare($query);
            $stmt->execute($values);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            throw new Exception($e->getMessage()  . ". The getRows query is $query");
        }
    }

    public function insertRow($query, $values, $action = null) {
        
        try {
            $stmt = $this->datab->prepare($query);
            $stmt->execute($values);
            
            if($action == null){
                return $this->datab->lastInsertId();
            }
            return true;

        } catch (PDOException $e) {
        	if ($action == null) $action = "insert";
            throw new Exception($e->getMessage()  . ". The $action query is $query");
        }
    }

    public function updateRow($query, $values) {
        return $this->insertRow($query, $values, $action = 'update');
    }

    public function deleteRow($query, $values) {
        return $this->insertRow($query, $values, $action = 'delete');
    }
    
}