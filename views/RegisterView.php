<?php
require_once "BodyView.php";
require_once "helpers/FormHandler.php";

class RegisterView extends BodyView
{
    private $formHandler;

    public function __construct()
    {
        $postResult  = array(
            'name' =>  array(
                'type' => 'name',
                'label' => 'Your Name',
                'placeholder' => 'Enter your name',
                'check_func' => 'validName'
            ),
            'email' =>  array(
                'type' => 'email',
                'label' => 'Your email',
                'placeholder' => 'Enter your email address',
                'check_func' => 'validEmail'
            ),
            'password' =>  array(
                'type' => 'password',
                'label' => 'Your password',
                'placeholder' => 'Enter your password',
            ),
        );

        $this->formHandler = new FormHandler($postResult);
    }

    public function showMainContent()
    {
        echo '<h3>Register your account</h3>';
        $this->formHandler->showForm();
    }
}
