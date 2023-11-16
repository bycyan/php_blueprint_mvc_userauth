<?php
require_once "database/Database.php";
class UserModel extends Database
{
    //CREATE
    public function createUser($name, $email, $password)
    {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        try {
            $sqlQuery = "INSERT INTO users (name, email, password) VALUES (:name, :email, :password)";
            $data = [
                ':name' => $name,
                ':email' => $email,
                ':password' => $hashedPassword
            ];
            $stmt = $this->createData($sqlQuery, $data);
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            throw new Exception("Error: " . $e->getMessage());
        }
    }

    //READ
    public function readUser($email)
    {
        try {
            $sqlQuery = "SELECT * FROM users WHERE email = :email";
            $data = [':email' => $email];
            $stmt = $this->readData($sqlQuery, $data);
            return $stmt;
        } catch (PDOException $e) {
            throw new Exception("Error: " . $e->getMessage());
        }
    }

    //UPDATE
    public function updateUser($userId, $name, $email, $password)
    {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        try {
            $sqlQuery = "UPDATE users SET name = :name, email = :email, password = :password WHERE id = :id";
            $data = [
                ':id' => $userId,
                ':name' => $name,
                ':email' => $email,
                ':password' => $hashedPassword
            ];
            $stmt = $this->updateData($sqlQuery, $data);
            return $stmt;
        } catch (PDOException $e) {
            throw new Exception("Error: " . $e->getMessage());
        }
    }

    //DELETE
    public function deleteUser($userId)
    {
        try {
            $sqlQuery = "DELETE FROM users WHERE id = :id";
            $data = [':id' => $userId];
            $stmt = $this->deleteData($sqlQuery, $data);
            // return $stmt->rowCount() > 0;
            return $stmt;
        } catch (PDOException $e) {
            throw new Exception("Error: " . $e->getMessage());
        }
    }
}
