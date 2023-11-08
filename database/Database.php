<?php
class Database
{
    private $host = "localhost";
    private $db_username = "root";
    private $db_password = "";
    private $database = "mydb";
    public $conn;

    function __construct()
    {
        try {
            $this->conn = new PDO("mysql:host=$this->host;dbname=$this->database", $this->db_username, $this->db_password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    public function prepare($sql)
    {
        return $this->conn->prepare($sql);
    }

    private function handleException($e)
    {
        throw new Exception("Error: " . $e->getMessage());
    }

    //CREATE
    public function createData($sqlQuery, $data)
    {
        try {
            $stmt = $this->conn->prepare($sqlQuery);
            $stmt->execute($data);
            return $stmt;
        } catch (PDOException $e) {
            $this->handleException($e);
        }
    }

    //READ
    public function readData($sqlQuery, $data)
    {
        try {
            $stmt = $this->conn->prepare($sqlQuery);
            $stmt->execute($data);
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $rows;
        } catch (PDOException $e) {
            $this->handleException($e);
        }
    }

    //UPDATE
    public function updateData($sqlQuery, $data)
    {
    }

    //DELETE
    public function deleteData($sqlQuery, $data)
    {
    }
}
