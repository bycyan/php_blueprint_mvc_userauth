<?php
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

////


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
        //Instantiate errorMessages
        //todo: display messages
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
                $this->userModel->createUser($username, $email, $password);
                //todo: Check if the username or email already exists
                }
            }
        }
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

      // Check if the username or email already exists
                // if ($this->userModel->readUser($name)) {
                //     $errorMessages[] = "Username already exists.";
                // } elseif ($this->userModel->readUser($email)) {
                //     $errorMessages[] = "Email already exists.";
                // } else {
                //     // Create the user

                // }