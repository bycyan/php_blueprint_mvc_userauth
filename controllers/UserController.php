<?php
require_once "models/UserModel.php";
require_once "helpers/FormHandler.php";
class UserController
{

    protected $userModel;
    private $errors = array();
    private $fields;
    private $formHandler;

    public function __construct(UserModel $userModel)
    {
        $this->userModel = $userModel;
        $this->fields = [];
        $this->formHandler = new FormHandler($this->fields, $this->errors);
    }

    public function register($name, $email, $password)
    {
        $errorMessages = [];

        // Check if the form has been submitted
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $password = $_POST['password'];

            // Validate form data
            if (empty($name)) {
                throw new Exception("Username is required.");
            }

            if (empty($email)) {
                throw new Exception("Email is required.");
                $errorMessages[] = "Email is required.";
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errorMessages[] = "Invalid email format.";
            }

            if (empty($password)) {
                $errorMessages[] = "Password is required.";
            } elseif (strlen($password) < 6) {
                $errorMessages[] = "Password must be at least 6 characters long.";
            }

            // Check if the user exists
            if (empty($errorMessages)) {
                if ($this->userModel->createUser($name, $email, $password)) {
                    return true;
                } else {
                    throw new Exception("An error occurred during registration. Please try again later.");
                }
            } else {
                throw new Exception(implode("<br>", $errorMessages));
            }
        }
    }

    public function loginUser()
    {
        $email = isset($_POST['email']) ? $_POST['email'] : '';
        $password = isset($_POST['password']) ? $_POST['password'] : '';

        try {
            if (empty($email)) {
                throw new Exception("Email is required!");
            }

            $userData = $this->userModel->readUser($email);

            if ($userData) {
                $hashedPassword = $userData[0]['password'];

                if (password_verify($password, $hashedPassword)) {
                    $_SESSION['user'] = $userData[0];
                    return true;
                } else {
                    throw new Exception("Incorrect password");
                }
            }
        } catch (Exception $e) {
            $this->errors[] = $e->getMessage();
            // $this->formHandler->showForm('login');
        }
    }


    public function unsetUser()
    {
        unset($_SESSION['user']);
        $result['page'] = 'home';
        return $result;
    }
}
