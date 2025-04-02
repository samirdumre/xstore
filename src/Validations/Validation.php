<?php

namespace Hazesoft\Backend\Validations;

require(__DIR__ . '/../../vendor/autoload.php');

abstract class Validation
{
    private $sanitize;

    public function sanitizeData($data): string
    {
        $data = trim($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    abstract function validateUserInput(array $inputArray);
}
