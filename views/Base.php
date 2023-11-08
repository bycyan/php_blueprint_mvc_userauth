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
        echo "<meta charset='UTF-8'>";
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
