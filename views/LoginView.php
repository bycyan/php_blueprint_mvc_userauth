<?php
require_once "BodyView.php";
class LoginView extends BodyView
{
    function showMainContent()
    {
        echo '
        <div class="outer-container center">
        <div class="inner-container center">
            <h4>Login to your account</h4>
            <div class="form-div">
                <form method="post">
                    <input type="hidden" name="page" value="login">
                    <input type="email" id="email" name="email" placeholder="Email" required><br>
                    <input type="password" id="password" name="password" placeholder="Wachtwoord" required><br>
                    <button type="submit" class="bttn-primary">Login</button>
                    <a href="index.php?page=home">Terug naar home</a>
                </form>
            </div>
        </div>
        </div>';
    }
}
