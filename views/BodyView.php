<?php
require_once "Base.php";
abstract class BodyView extends Base
{
    protected array $response;

    public function __construct(array $response)
    {
        $this->response = $response;
    }

    final protected function bodyContent()
    {
        $this->showNav();
        $this->beginMainContent();
        $this->showMainContent();
        $this->endMainContent();
        $this->showFooter();
    }

    protected function showNav()
    {

        echo '
            <div class="outer-container navbar-outer center">
                <nav class="inner-container navbar">
                    <div class="company-name">
                        <a href="index.php?page=home">php_blueprint_mvc_user_auth</a>
                    </div>
                    <div class="menu-items">
                        <ul>
                            <li><a href="index.php?page=home">Home</a></li>';

        if (isset($_SESSION['user']) && is_array($_SESSION['user'])) {
            $name = htmlspecialchars($_SESSION['user'][0]['name']);
            $nameParts = explode(' ', $name);
            $firstName = $nameParts[0];
            $lastName = isset($nameParts[1]) ? $nameParts[1] : '';

            echo '<li><a href="index.php?page=logout">logout: ' . $firstName . '</a></li>';
        } else
            echo '
                            <li><a href="index.php?page=login">Login</a></li>
                            <li><a href="index.php?page=register">Register</a></li>
                        </ul>
                    </div>
                </nav>
            </div>';
    }

    protected function beginMainContent()
    {
        echo "<main>";
    }

    abstract protected function showMainContent();

    protected function endMainContent()
    {
        echo "</main>";
    }

    protected function showFooter()
    {
        echo '<a href="google.com" target="blank">Go to GitHub repository</a>';;
    }
}
