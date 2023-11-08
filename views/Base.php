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
        //todo: toevoegen dynamisch css, page title
        echo '<style>
        body {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            gap: 50px;
            height: 100vh;
            margin: 0;
            text-align: center;
        }

        nav ul{
            display: flex;
            gap: 30px;
            list-style: none;
        }
        </style>';
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
