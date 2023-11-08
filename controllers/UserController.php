<?php
require_once "models/UserModel.php";
class UserController
{

    protected $userModel;

    public function __construct(UserModel $userModel)
    {
        $this->userModel = $userModel;
    }

    public function register($name, $email, $password)
    {
        $errorMessages = [];

        // Check if the form has been submitted
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Retrieve form data
            $name = $_POST['name'];
            $email = $_POST['email'];
            $password = $_POST['password'];

            // // Validate form data
            // if (empty($name)) {
            //     $errorMessages[] = "Username is required.";
            // }

            // if (empty($email)) {
            //     $errorMessages[] = "Email is required.";
            // } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            //     $errorMessages[] = "Invalid email format.";
            // }

            // if (empty($password)) {
            //     $errorMessages[] = "Password is required.";
            // } elseif (strlen($password) < 6) {
            //     $errorMessages[] = "Password must be at least 6 characters long.";
            // }

            //Check if the user exists
            if (empty($errorMessages)) {
                if ($this->userModel->createUser($name, $email, $password)) {
                    return true;
                }
                //todo: else show error message
            }
        }
    }

    public function loginUser($email)
    {
        $userData = $this->userModel->readUser($email);
        if ($userData) {
            $_SESSION['user'] = $userData[0];
        } else {
            throw new Exception("No user found");
        }
    }

    public function unsetUser()
    {
        unset($_SESSION['user']);
        $result['page'] = 'home';
        return $result;
    }
}
