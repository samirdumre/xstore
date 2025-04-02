<?php

namespace Hazesoft\Backend\Validations;

abstract class Validation
{
    private $sanitize;

    protected function sanitizeData($data)
    {
        $data = trim($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    abstract function validateUserInput(array $inputArray);
}
