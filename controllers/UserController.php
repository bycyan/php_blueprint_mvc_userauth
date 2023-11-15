<?php
require_once "models/UserModel.php";

class UserController
{

    protected $userModel;
    private $fieldErrors = [];

    public function __construct(UserModel $userModel)
    {
        $this->userModel = $userModel;
    }

    public function getUserModel()
    {
        return $this->userModel;
    }

    public function registerUser($name, $email, $password)
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $name = isset($_POST['name']) ? $_POST['name'] : '';
            $email = isset($_POST['email']) ? $_POST['email'] : '';
            $password = isset($_POST['password']) ? $_POST['password'] : '';

            if (empty($name)) {
                throw new Exception("Username is required.");
            }

            if (empty($email)) {
                throw new Exception("Email is required.");
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                throw new Exception("Invalid email format.");
            }

            $doesUserExist = $this->userModel->readUser($email);

            if ($doesUserExist) {
                throw new Exception("Email already registered. Please choose a different email.");
            }

            if (empty($password)) {
                throw new Exception("Password is required.");
            } elseif (strlen($password) < 6) {
                throw new Exception("Password must be at least 6 characters long.");
            }

            if ($this->userModel->createUser($name, $email, $password)) {
                return true;
            } else {
                throw new Exception("An error occurred during registration. Please try again later.");
            }
        }
    }

    public function loginUser()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $email = isset($_POST['email']) ? $_POST['email'] : '';
            $password = isset($_POST['password']) ? $_POST['password'] : '';

            if (empty($email)) {
                throw new Exception("Email is required!");
                $this->fieldErrors['email'] = "Email is required.";
            }

            if (empty($password)) {
                throw new Exception("Password is required!");
                $this->fieldErrors['password'] = "Password is required.";
            }

            if (!empty($this->fieldErrors)) {
                return false;
            }

            $user = $this->userModel->readUser($email);

            if (!$user) {
                throw new Exception("User not found!");
            }

            $hashedPassword = $user[0]['password'];
            if (password_verify($password, $hashedPassword)) {
                $_SESSION['user'] = $user[0];
                return true;
            } else {
                throw new Exception("Incorrect password");
            }
        }
    }

    public function getFieldErrors()
    {
        return $this->fieldErrors;
    }

    public function unsetUser()
    {
        unset($_SESSION['user']);
        $result['page'] = 'home';
        return $result;
    }
}
