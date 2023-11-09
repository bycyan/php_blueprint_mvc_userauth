<?php
require_once "BodyView.php";
require_once "helpers/FormHandler.php";

class ContactView extends BodyView
{

    private $formHandler;

    public function __construct()
    {
        $postResult  = array(
            'name' =>  array(
                'type' => 'text',
                'placeholder' => 'Enter your name',
            ),
            'email' =>  array(
                'type' => 'text',
                'placeholder' => 'Enter your email',
            ),
            'message' =>  array(
                'type' => 'textarea',
                'placeholder' => 'Enter your message',
            ),
        );

        $this->formHandler = new FormHandler($postResult);
    }

    public function showMainContent()
    {
        echo '<h3>Ask your question</h3>';
        $this->formHandler->showForm('contact');
    }
}
