<?php
class FormHelper
{

    protected $fields;
    protected $errors;

    public function __construct(array $fields, array $errors)
    {
        $this->fields = $fields;
        $this->errors = $errors;
    }

    public function showForm(string $page = '')
    {
        $postResult = isset($this->errors['postResult']) ? $this->errors['postResult'] : [];
        $this->openForm($page, '');
        $this->showFields($postResult);
        $this->closeForm();
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
            $currentValue = isset($postResult[$fieldName]) ? $postResult[$fieldName] : '';

            if ($fieldInfo['type'] === 'textarea') {
                echo '<textarea name="' . $fieldName . '" placeholder="' . $fieldInfo['placeholder'] . '">' . $currentValue . '</textarea>' . PHP_EOL;
            } else {
                echo '<input name="' . $fieldName . '" type="' . $fieldInfo['type'] . '" placeholder="' . $fieldInfo['placeholder'] . '" value="' . $currentValue . '">' . PHP_EOL;
            }

            if (isset($this->errors[$fieldName])) {
                // Convert the error to an array if it's a string
                $errorsForField = is_array($this->errors[$fieldName]) ? $this->errors[$fieldName] : [$this->errors[$fieldName]];

                foreach ($errorsForField as $error) {
                    echo $error . '<br>';
                }
            }
        }
    }


    private function closeForm(string $submitCaption = "Submit")
    {
        echo '<button type="submit" value="submit">' . $submitCaption . '</button>'
            . PHP_EOL
            . '	</form>'
            . PHP_EOL;
    }
}
