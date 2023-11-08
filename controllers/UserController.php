<?php
require_once "models/UserModel.php";
/*Controller:
    Handles user requests and input.
    Interacts with the model to retrieve data.
    Updates the view with data received from the model.
    Performs input validation and sanitization.
    Orchestrates the flow of data between the model and the view.
    Implements application logic and business rules.
    Manages session data and user authentication.
    Controls the overall application behavior and flow.
    
    register(): Handles user registration, validates input data, and creates a new user in the system.
    login(): Manages user authentication by verifying login credentials and setting up user sessions upon successful authentication.
    logout(): Terminates the user session and logs the user out of the system.
    profile(): Retrieves and displays the user's profile information, allowing the user to view and update their profile data.
    editProfile(): Handles requests to update the user's profile information, including data validation and storage in the database.
    changePassword(): Manages the process of allowing users to change their passwords, including password validation and storage.
    deleteAccount(): Handles requests to delete a user account, including confirmation and the removal of associated data from the database.
    forgotPassword(): Facilitates the process for users to reset their forgotten passwords by sending password reset links or codes to their registered email addresses.
    resetPassword(): Manages the process of resetting a user's password based on a valid password reset token, ensuring proper validation and security measures.
    listUsers(): Retrieves and displays a list of users, often used for administrative purposes, with appropriate access control.
    searchUsers(): Implements the functionality to search for users based on specific criteria, providing search results to the user interface.*/

class UserController
{

    protected $userModel;

    public function __construct(UserModel $userModel)
    {
        $this->userModel = $userModel;
    }

    public function register($name, $email, $password)
    {
        // Check if the form has been submitted
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Retrieve form data
            $name = $_POST['name'];
            $email = $_POST['email'];
            $password = $_POST['password'];

            //Check if the user exists
            if (empty($errorMessages)) {
                // Check if the username or email already exists
                if ($this->userModel->getUserByUsername($name)) {
                    $errorMessages[] = "Username already exists.";
                } elseif ($this->userModel->getUserByEmail($email)) {
                    $errorMessages[] = "Email already exists.";
                } else {
                    // Create the user
                    $this->userModel->createUser($name, $email, $password);
                    $result['page'] = 'login';
                }
            }
        }

        //Als de gebruiker nog niet bestaat dan createUser en page naar home
        //Anders een error

        //geen try en catch
        try {
            return $this->userModel->createUser($name, $email, $password);
            $result['page'] = 'login';
        } catch (Exception $e) {
            throw new Exception("Error: " . $e->getMessage());
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


//EXAMPLE
class UserControllerExample
{
    private $userModel;

    public function __construct($userModel)
    {
        $this->userModel = $userModel;
    }

    public function register()
    {
        $errorMessages = [];

        // Check if the form has been submitted
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Retrieve form data
            $username = $_POST['username'];
            $email = $_POST['email'];
            $password = $_POST['password'];

            // Validate form data
            if (empty($username)) {
                $errorMessages[] = "Username is required.";
            }

            if (empty($email)) {
                $errorMessages[] = "Email is required.";
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errorMessages[] = "Invalid email format.";
            }

            if (empty($password)) {
                $errorMessages[] = "Password is required.";
            } elseif (strlen($password) < 6) {
                $errorMessages[] = "Password must be at least 6 characters long.";
            }

            // Check if there are any validation errors
            if (empty($errorMessages)) {
                // Check if the username or email already exists
                if ($this->userModel->getUserByUsername($username)) {
                    $errorMessages[] = "Username already exists.";
                } elseif ($this->userModel->getUserByEmail($email)) {
                    $errorMessages[] = "Email already exists.";
                } else {
                    // Create the user
                    $this->userModel->createUser($username, $email, $password);
                    // Redirect the user to the login page or another appropriate page
                }
            }
        }
        // Render the registration form view, passing any error messages for display
    }


    public function login()
    {
        // Handle user login logic
        // Example: $this->userModel->loginUser($username, $password);
    }

    public function logout()
    {
        // Handle user logout logic
        // Example: $this->userModel->logoutUser();
    }

    public function profile($userId)
    {
        // Retrieve user profile information
        // Example: $userProfile = $this->userModel->getUserById($userId);
        // Render view with user profile data
    }

    public function editProfile($userId, $newUsername, $newEmail)
    {
        // Handle user profile edit logic
        // Example: $this->userModel->updateUser($userId, $newUsername, $newEmail);
    }

    public function changePassword($userId, $newPassword)
    {
        // Handle password change logic
        // Example: $this->userModel->updatePassword($userId, $newPassword);
    }

    public function deleteAccount($userId)
    {
        // Handle account deletion logic
        // Example: $this->userModel->deleteUser($userId);
    }

    // Other controller functions

}
