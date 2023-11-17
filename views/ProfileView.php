<?php
require_once "BodyView.php";
require_once "FormView.php"; // Import FormView if it's not autoloaded

class ProfileView extends BodyView
{
    public function showMainContent()
    {
        if (isset($_SESSION['user'])) {
            echo '<div>';
            echo $_SESSION['user']['name'];
            echo '<br>';
            echo $_SESSION['user']['email'];
            echo '</div>';
        }

        //todo:
        //Edit Mode
        //Instantiate Edit Form
    }
}
