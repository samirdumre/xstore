<?php

namespace Hazesoft\Backend\Validations;

require(__DIR__ . '/../../vendor/autoload.php');

use Exception;
use Hazesoft\Backend\Validations\Validation;
//use Hazesoft\Backend\Validations\Exception as Exception;

class LoginValidation extends Validation
{
    public function validateUserInput(array $inputArray)
    {
        [$email, $password] = $inputArray;

        try {
            // validation status
            $isValidationOk = 0;

            $isValidationOk += $this->validateEmail($email);
            $isValidationOk += $this->validatePassword($password);

            if ($isValidationOk == 2) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage());
        }
    }

    public function validateEmail(string $email)
    {
        $email = $this->sanitizeData($email);
        if (empty($email)) {
            throw new Exception("Email is required.");
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("Invalid email format.");
        }
        return 1;
    }

    public function validatePassword(string $password)
    {
        $password = $this->sanitizeData($password);

        if (empty($password)) {
            throw new Exception("Password is required.");
        }
        if (strlen($password) < 8) {
            throw new Exception("Password must be at least 8 characters long.");
        }
        return 1;
    }
}


