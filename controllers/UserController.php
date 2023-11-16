<?php
require_once "models/UserModel.php";

class UserController
{

    protected $userModel;
    public $fieldErrors = [];
    private $userData;


    public function __construct(UserModel $userModel)
    {
        $this->userModel = $userModel;
    }

    public function getUserModel()
    {
        return $this->userModel;
    }

    public function getFieldErrors()
    {
        return $this->fieldErrors;
    }

    public function getUserData()
    {
        return $this->userData;
    }

    public function loginUser()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $email = isset($_POST['email']) ? $_POST['email'] : '';
            $password = isset($_POST['password']) ? $_POST['password'] : '';

            //Validate Form Fields
            if (empty($email)) {
                $this->fieldErrors['email'] = "Email is required.";
            }
            if (empty($password)) {
                $this->fieldErrors['password'] = "Password is required.";
            }

            //Als fieldErrors leeg zijn, lees de users
            //todo: fieldErrors empty scheiden van gegevens validatie errors
            if (empty($this->fieldErrors)) {
                $user = $this->userModel->readUser($email);

                if (!$user) {
                    $this->fieldErrors['email'] = "User not found";
                } else {
                    $hashedPassword = $user[0]['password'];
                    if (password_verify($password, $hashedPassword)) {
                        $_SESSION['user'] = $user[0];
                        return true;
                    } else {
                        $this->fieldErrors['password'] = "Incorrect password";
                    }
                }
            }
            if (!empty($this->fieldErrors)) {
                throw new Exception();
            }
        }
        return false;
    }


    public function registerUser($name, $email, $password)
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $name = isset($_POST['name']) ? $_POST['name'] : '';
            $email = isset($_POST['email']) ? $_POST['email'] : '';
            $password = isset($_POST['password']) ? $_POST['password'] : '';

            if (empty($name)) {
                $this->fieldErrors['name'] = "Username is required.";
            }

            if (empty($email)) {
                $this->fieldErrors['email'] = "Email is required.";
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $this->fieldErrors['email'] = "Invalid email format.";
            }

            if (empty($password)) {
                $this->fieldErrors['password'] = "Password is required.";
            } elseif (strlen($password) < 6) {
                $this->fieldErrors['password'] = "Password must be at least 6 characters long.";
            }

            if (empty($this->fieldErrors)) {
                $doesUserExist = $this->userModel->readUser($email);

                if ($doesUserExist) {
                    $this->fieldErrors['email'] = "Email already registered. Please choose a different email.";
                }

                if ($this->userModel->createUser($name, $email, $password)) {
                    return true;
                } else {
                    //todo: deze error als algemene error tonen
                    $this->fieldErrors['email'] = "An error occurred during registration. Please try again later.";
                }
            }
            if (!empty($this->fieldErrors)) {
                throw new Exception();
            }
        }
        return false;
    }

    public function updateProfile($userData)
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $userId = isset($userData['id']) ? $userData['id'] : '';
            $name = isset($userData['name']) ? $userData['name'] : '';
            $email = isset($userData['email']) ? $userData['email'] : '';
            $password = isset($userData['password']) ? $userData['password'] : '';

            // if (!empty($password) && strlen($password) < 6) {
            //     $this->fieldErrors['password'] = "Password must be at least 6 characters long.";
            // }

            if (empty($this->fieldErrors)) {
                try {

                    $this->userModel->updateUser($userId, $name, $email, $password);
                    // // Check if the provided email exists in the database
                    // $existingUser = $this->userModel->readUser($email);

                    // // If user exists and it's not the current user being updated
                    // if ($existingUser && $existingUser[0]['id'] !== $userId) {
                    //     $this->fieldErrors['email'] = "Email already registered. Please choose a different email.";
                    // } else {
                    //     // Update user details
                    //     $result = $this->userModel->updateUser($userId, $name, $email, $password);
                    //     if ($result) {
                    //         return true;
                    //     } else {
                    //         // Handle update failure
                    //         // todo: Handle failure scenario appropriately
                    //     }
                    // }
                } catch (Exception) {
                    // throw new Exception("Error: " . $e->getMessage());
                    throw new Exception();
                }
            }
        }
        return false;
    }

    public function getAllUsers()
    {
        try {
            $users = $this->userModel->readAllUsers();
            return $users;
        } catch (Exception $errors) {
            // Handle error scenario
            return [];
        }
        return false;
    }

    public function unsetUser()
    {
        unset($_SESSION['user']);
        $result['page'] = 'login';
        return $result;
    }
}
