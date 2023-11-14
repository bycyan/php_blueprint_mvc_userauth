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
        <nav>
            <div class="menu-items">
                <ul>
                    <li><a href="index.php?page=home">Home</a></li>
                    <li><a href="index.php?page=contact">Contact</a></li>';

        if (isset($_SESSION['user']) && is_array($_SESSION['user'])) {
            $name = htmlspecialchars($_SESSION['user']['name']);
            $nameParts = explode(' ', $name);
            $firstName = $nameParts[0];
            $lastName = isset($nameParts[1]) ? $nameParts[1] : '';

            echo '<li><a href="index.php?page=logout">logout: ' . $firstName . '</a></li>';
        } else {
            echo '
                    <li><a href="index.php?page=login">Login</a></li>
                    <li><a href="index.php?page=register">Register</a></li>';
        }

        echo '
                </ul>
            </div>
        </nav>';
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
        echo '<a href="https://github.com/bycyan/php_blueprint_mvc_userauth" target="blank">Go to GitHub repository</a>';;
    }
}
