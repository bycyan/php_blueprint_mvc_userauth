<?php
require_once "BodyView.php";
class DashboardView extends BodyView
{
    function showMainContent()
    {

        if (isset($_SESSION['user']) && is_array($_SESSION['user'])) {
            $name = htmlspecialchars($_SESSION['user']['name']);
            $nameParts = explode(' ', $name);
            $firstName = $nameParts[0];
            $lastName = isset($nameParts[1]) ? $nameParts[1] : '';

            if ($_SESSION['user']['role'] === 'admin') {
                if (isset($this->response['users'])) {
                    $userList = $this->response['users'];

                    if (!empty($userList)) {
                        echo '<h3>'  . $firstName . '\'s Team Members </h3>';

                        echo '<table class="order center">
                        <tr class="order-item"><th>ID</th><th>Name</th><th>Email</th><th>Role</th><th></th></tr>';

                        foreach ($userList as $user) {
                            echo '<tr class="order-item">';
                            echo '<td>' . $user['id'] . '<br></td>';
                            echo '<td>' . htmlspecialchars($user['name']) . '</td>';
                            echo '<td>' . htmlspecialchars($user['email']) . '</td>';
                            echo '<td>' . htmlspecialchars($user['role']) . '</td>';
                            echo '<td><a href="edit_profile.php?email=' . urlencode($user['email']) . '">Edit</a></td>';
                            echo '</tr>';
                        }
                        echo '</table>';

                        echo '<button>Add new user</button>';
                    } else {
                        echo 'No users found.';
                    }
                }
            } else {
                echo '<h3> Hey '  . $name . ' !</h3>';
            }
        }
    }
}
