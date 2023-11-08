<?php
require_once "database/Database.php";
/*Model:
Interacts with the database or external data sources.
Performs CRUD operations (Create, Read, Update, Delete) on data.
Applies data validation and business logic.
Manages the application's data structure and relationships.
Enforces data integrity and security.
Handles data manipulation and transformation.
Encapsulates data-related functionality.
Contains application-specific data and business rules.*/

class UserModel extends Database
{


    //CREATE
    public function createUser($name, $email, $password)
    {
        try {
            //Hash the password (en deze meegeven)
            $sqlQuery = "INSERT INTO users (name, email, password) VALUES (:name, :email, :password)";
            $data = [
                ':name' => $name,
                ':email' => $email,
                ':password' => $password
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
            $rows = $this->readData($sqlQuery, $data);
            return $rows;
        } catch (PDOException $e) {
            throw new Exception("Error: " . $e->getMessage());
        }
    }

    //todo: UPDATE
    //todo: DELETE

    //todo: Error handlers
}



//EXAMPLE
class UserModelExample
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    // Create a new user
    public function createUser($username, $email, $password)
    {
        // Perform necessary data validation
        if (empty($username) || empty($email) || empty($password)) {
            // Handle the error appropriately, such as throwing an exception or returning an error message
            throw new Exception("Username, email, and password are required.");
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            // Handle the error appropriately, such as throwing an exception or returning an error message
            throw new Exception("Invalid email format.");
        }

        // Hash the password before storing it
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Prepare the SQL query
        $query = $this->db->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");

        // Execute the query
        $query->execute([$username, $email, $hashedPassword]);
    }

    // Retrieve a user by their ID
    public function getUserById($userId)
    {
        // Prepare the SQL query
        $query = $this->db->prepare("SELECT * FROM users WHERE id = ?");

        // Execute the query
        $query->execute([$userId]);

        // Return the fetched user data
        return $query->fetch();
    }

    // Update a user's information
    public function updateUser($userId, $newUsername, $newEmail)
    {
        // Prepare the SQL query
        $query = $this->db->prepare("UPDATE users SET username = ?, email = ? WHERE id = ?");

        // Execute the query
        $query->execute([$newUsername, $newEmail, $userId]);
    }

    // Delete a user by their ID
    public function deleteUser($userId)
    {
        // Prepare the SQL query
        $query = $this->db->prepare("DELETE FROM users WHERE id = ?");

        // Execute the query
        $query->execute([$userId]);
    }
}
