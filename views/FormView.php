<?php
require_once "BodyView.php";
require_once "helpers/FormHandler.php";

class FormView extends BodyView
{
    private $formHandler;
    private $page;

    public function __construct($page)
    {
        $this->page = $page;
        $postResult = $this->getFormFieldsByPage($page);
        $this->formHandler = new FormHandler($postResult, $errors);
    }

    public function showMainContent()
    {
        $this->renderForm();
    }

    private function getFormFieldsByPage($page)
    {
        switch ($page) {
            case 'login':
                return [
                    'email' =>  array(
                        'type' => 'email',
                        'placeholder' => 'Enter your email address',
                    ),
                    'password' =>  array(
                        'type' => 'password',
                        'placeholder' => 'Enter your password',
                    ),
                ];
            case 'register':
                return [
                    'name' =>  array(
                        'type' => 'name',
                        'placeholder' => 'Enter your name',
                    ),
                    'email' =>  array(
                        'type' => 'email',
                        'placeholder' => 'Enter your email address',
                    ),
                    'password' =>  array(
                        'type' => 'password',
                        'placeholder' => 'Enter your password',
                    ),
                ];
            case 'contact':
                return [
                    'name' =>  array(
                        'type' => 'name',
                        'placeholder' => 'Enter your name',
                    ),
                    'email' =>  array(
                        'type' => 'email',
                        'placeholder' => 'Enter your email',
                    ),
                    'message' =>  array(
                        'type' => 'textarea',
                        'placeholder' => 'Enter your message',
                    ),
                ];
            default:
                return [];
        }
    }

    private function renderForm()
    {
        switch ($this->page) {
            case 'login':
                echo '<h3>Login to your account</h3>';
                $this->formHandler->showForm('login');
                break;
            case 'register':
                echo '<h3>Register your account</h3>';
                $this->formHandler->showForm('register');
                break;
            case 'contact':
                echo '<h3>Ask your question</h3>';
                $this->formHandler->showForm('contact');
                break;
            default:
                break;
        }
    }
}
