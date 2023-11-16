<?php
require_once "BodyView.php";
require_once "FormView.php"; // Import FormView if it's not autoloaded

class ProfileView extends BodyView
{
    private $userEmail;

    public function __construct($response, $userEmail)
    {
        parent::__construct($response);
        $this->userEmail = $userEmail;
    }

    public function showMainContent()
    {
        if (isset($_SESSION['user'])) {
            echo '<div>';
            echo $_SESSION['user']['name'];
            echo '<br>';
            echo $_SESSION['user']['email'];
            echo '</div>';

            echo '<br>';
            echo $this->userEmail; // Use the dynamically injected email here
            echo '</div>';

            // Display edit button
            echo '<form method="post">';
            echo '<button type="submit" name="editButton">Edit</button>';
            echo '</form>';
        }

        // Check if the edit button was clicked
        if (isset($_POST['editButton'])) {
            return true;
        }
        return false;
    }
}
