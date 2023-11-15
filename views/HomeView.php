<?php
require_once "BodyView.php";
class HomeView extends BodyView
{
    function showMainContent()
    {
        if (isset($_SESSION['user']) && is_array($_SESSION['user'])) {
            $name = htmlspecialchars($_SESSION['user']['name']);
            $nameParts = explode(' ', $name);
            $firstName = $nameParts[0];
            $lastName = isset($nameParts[1]) ? $nameParts[1] : '';

            echo '<h1>Hey ' . $name . ' !</h1>';
        }
    }
}
