<?php

abstract class Base
{
    //stappenplan om te tonen
    final public function renderHTML()
    {
        $this->beginDoc();
        $this->beginHead();
        $this->headContent();
        $this->endHead();
        $this->beginBody();
        $this->bodyContent();
        $this->endBody();
        $this->endDoc();
    }

    //////////////////////////////////////////////////////////
    protected function beginDoc()
    {
        echo "<!DOCTYPE html>\n<html>";
    }

    protected function beginHead()
    {
        echo "<head>";
    }

    protected function headContent()
    {
        echo '<meta charset=UTF - 8>';
        echo '<meta name="viewport" content="width=device-width, initial-scale=1.0">';
        echo '<link rel="stylesheet" href="assets/index.css">';
        echo '<link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@1,900&display=swap" rel="stylesheet">';
        //todo: toevoegen dynamisch css, page title
    }

    protected function endHead()
    {
        echo "</head>";
    }

    protected function beginBody()
    {
        echo "<body>";
    }

    abstract protected function bodyContent();

    protected function endBody()
    {
        echo "</body>";
    }

    protected function endDoc()
    {
        echo "</html>";
    }
}
