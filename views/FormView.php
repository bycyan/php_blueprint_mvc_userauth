<?php
require_once "BodyView.php";
require_once "helpers/FormHelper.php";

class FormView extends BodyView
{
    protected $formHelper;
    protected $page;
    protected $errors;

    public function __construct($page, array $errors)
    {
        $this->page = $page;
        $this->errors = $errors;
        $postResult = $this->getFormFieldsByPage($page);
        $this->formHelper = new FormHelper($postResult, $this->errors);
    }

    public function showMainContent()
    {
        $this->renderForm();
    }

    private function getFormFieldsByPage($page)
    {
        switch ($page) {
            case 'login':
                $fields = [
                    'email' =>  array(
                        'type' => 'email',
                        'placeholder' => 'Enter your email address',
                    ),
                    'password' =>  array(
                        'type' => 'password',
                        'placeholder' => 'Enter your password',
                    ),
                ];
                return $fields;
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
            case 'profile':
                return [
                    'name' =>  array(
                        'type' => 'name',
                        'placeholder' => 'Enter your new name',
                    ),
                    'email' =>  array(
                        'type' => 'email',
                        'placeholder' => 'Enter your new email',
                    ),
                    'password' =>  array(
                        'type' => 'password',
                        'placeholder' => 'Enter your new password',
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
                $this->formHelper->showForm('login');
                break;
            case 'register':
                echo '<h3>Register your account</h3>';
                $this->formHelper->showForm('register');
                break;
            case 'contact':
                echo '<h3>Ask your question</h3>';
                $this->formHelper->showForm('contact');
                break;
            case 'profile':
                echo '<h3>Profile</h3>';
                var_dump($_SESSION['user']);
                $this->formHelper->showForm('profile');
                break;
            default:
                break;
        }
    }
}
