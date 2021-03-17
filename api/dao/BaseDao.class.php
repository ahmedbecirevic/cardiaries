<?php

require_once dirname(__FILE__) . "/../config.php";

class BaseDao
{

    protected $connection;

    public function __construct()
    {

        try {
            $this->connection = new PDO("mysql:host=" . Config::DB_HOST . ";dbname=" . Config::DB_SCHEME, Config::DB_USERNAME, Config::DB_PASSWORD);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }

    }

    public function insert($table, $entity)
    {
        $query = "INSERT INTO $table (";

        foreach ($entity as $column => $value) {
            $query .= "$column, ";
        }
        $query = substr($query, 0, -2) . ") VALUES (";

        foreach ($entity as $column => $value) {
            $query .= ":$column, ";
        }
        $query = substr($query, 0, -2) . ")";

        $stmt= $this->connection->prepare($query);
        $stmt->execute($entity);         //prevent sql injection
        $entity["id"] = $this->connection->lastInsertId();
        return $entity;
    }

    public function update($table, $id, $entity, $id_column = "id")
    {
        //generating automated query
        $query = "UPDATE $table SET ";
        
        foreach ($entity as $column => $value) {
            $query.= $column." = :".$column.", ";
        }
        
        $query = mb_substr($query, 0, -2);
        $query .= " WHERE ${id_column} = :id";

        //executing the query
        $stmt= $this->connection->prepare($query);
        $entity['id'] = $id;
        $stmt->execute($entity);
    }


    public function query($query, $params)
    {
        $stmt = $this->connection->prepare($query);
        $stmt->execute($params);

        return $stmt->fetchAll(PDO::FETCH_ASSOC); // PDO::FETCH_ASSOC used to ensure no duplicate elements 
    }

    public function query_unique($query, $params) 
    {
        $result = $this->query($query, $params);
        return reset($result); // reset - returns first element of array, checks if null etc. 

    }
}
