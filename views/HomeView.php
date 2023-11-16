<?php
require_once "BodyView.php";
class HomeView extends BodyView
{
    function showMainContent()
    {
        if (isset($this->response['users'])) {
            $userList = $this->response['users'];

            var_dump($this->response['users']);

            if (!empty($userList)) {
                echo '<h4>All Users (Edit Mode)</h4>';
                echo '<ul>';
                foreach ($userList as $user) {
                    echo '<li>';
                    echo 'User ID: ' . $user['id'] . '<br>';
                    echo 'Name: <input type="text" value="' . htmlspecialchars($user['name']) . '"><br>';
                    echo 'Email: <input type="email" value="' . htmlspecialchars($user['email']) . '"><br>';
                    echo 'Role: <input type="text" value="' . htmlspecialchars($user['role']) . '"><br>';
                    // Add other editable fields as needed
                    echo '</li>';
                }
                echo '</ul>';
            } else {
                echo 'No users found.';
            }
        } else {
            echo 'Users data not available.';
        }

        if (isset($_SESSION['user']) && is_array($_SESSION['user'])) {
            $name = htmlspecialchars($_SESSION['user']['name']);
            $nameParts = explode(' ', $name);
            $firstName = $nameParts[0];
            $lastName = isset($nameParts[1]) ? $nameParts[1] : '';

            echo '<h3>Hey ' . $name . ' </h3>';
            echo '<p>Team Dashboard </p>';

            if ($_SESSION['user']['role'] === 'admin') {
                // Retrieve user data from UserController
                // $userList = $this->userController->getAllUsers(); // Assuming a method getAllUsers() exists

                // Display the user list in an editable format
                if (!empty($userList)) {
                    echo '<h4>All Users (Edit Mode)</h4>';
                    echo '<ul>';
                    foreach ($userList as $user) {
                        echo '<li>';
                        echo 'User ID: ' . $user['id'] . '<br>';
                        echo 'Name: <input type="text" value="' . htmlspecialchars($user['name']) . '"><br>';
                        echo 'Email: <input type="email" value="' . htmlspecialchars($user['email']) . '"><br>';
                        echo 'Role: <input type="text" value="' . htmlspecialchars($user['role']) . '"><br>';
                        // Add other editable fields as needed
                        echo '</li>';
                    }
                    echo '</ul>';
                } else {
                    echo 'No users found.';
                }
            }
        }
    }
}
