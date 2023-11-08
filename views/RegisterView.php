<?php
require_once "BodyView.php";
class RegisterView extends BodyView
{
    protected function showMainContent()
    {
        echo '
        <div class="outer-container center">
        <div class="inner-container center">
        <h4>Register your account</h4>
        <form method="post">
        <input type="hidden" name="page" value="register">
        <input type="text" id="name" name="name" placeholder="Name" required><br>
        <input type="email" id="email" name="email" placeholder="Email" required><br>
        <input type="password" id="password" name="password" placeholder="Password" required><br>
        <button type="submit" class="bttn-primary">Register</button>
        <a href="index.php?page=home">Go back</a>
        </div>
        </div>';
    }
}
