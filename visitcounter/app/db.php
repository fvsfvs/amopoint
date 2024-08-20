<?php

Class DB 
{
    private $connection;

    function __construct(){
        $this->connection = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USER, DB_PASS,
                [PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]);    
        $this->connection->exec('SET NAMES UTF8');
    }

    function query($sql, $params = []) {
        $query = $this->connection->prepare($sql);
        $query->execute($params);
        return $query;
    }
    
    function select($sql, $params = []) {
        $query = $this->query($sql, $params);
        $res = $query->fetchAll();
        return $res;
    }

}