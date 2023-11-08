<?php

class FormHandler
{
    private $fields;

    public function __construct(array $fields)
    {
        $this->fields = $fields;
    }

    public function showForm()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $postResult = [];
            if ($this->checkFields($postResult)) {
                $this->showResult($postResult);
            } else {
                $this->openForm('login', '');
                $this->showFields($postResult);
                $this->closeForm();
            }
        } else {
            $this->openForm('login', '');
            $this->showFields();
            $this->closeForm();
        }
    }

    private function openForm(string $page, string $action, string $method = "POST")
    {
        echo '<form action="' . $action . '" method="' . $method . '" >'
            . PHP_EOL
            . '		<input type="hidden" name="page" value="' . $page . '" />'
            . PHP_EOL;
    }

    private function showFields(array $postResult = [])
    {
        foreach ($this->fields as $fieldName => $fieldInfo) {
            $currentValue = (isset($postResult[$fieldName]) ? $postResult[$fieldName] : '');
            echo '<input name=' . $fieldName . ' placeholder="' . $fieldInfo['placeholder'] . '">'  . PHP_EOL;
        }
    }

    private function closeForm(string $submitCaption = "Submit")
    {
        echo '		<button type="submit" value="submit">' . $submitCaption . '</button>'
            . PHP_EOL
            . '	</form>'
            . PHP_EOL;
    }

    private function checkFields(array &$postResult)
    {
        // ... (existing checkFields function remains unchanged)
    }

    private function showResult(array $postResult)
    {
        // ... (existing showResult function remains unchanged)
    }
}
