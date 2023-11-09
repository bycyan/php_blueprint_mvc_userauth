<?php
require_once "BodyView.php";
require_once "helpers/FormHandler.php";

class LoginView extends BodyView
{

    private $formHandler;

    public function __construct()
    {
        $postResult  = array(
            'email' =>  array(
                'type' => 'email',
                'placeholder' => 'Enter your email address',
                'check_func' => 'validEmail'
            ),
            'password' =>  array(
                'type' => 'password',
                'placeholder' => 'Enter your password',
            ),
        );

        $this->formHandler = new FormHandler($postResult);
    }

    public function showMainContent()
    {
        echo '<h3>Login to your account</h3>';
        $this->formHandler->showForm('login');
    }
}
