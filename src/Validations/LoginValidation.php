<?php

namespace Hazesoft\Backend\Validations;

use Exception;
use Hazesoft\Backend\Validations\Validation;
use Hazesoft\Backend\Validations\ValidationException as ValidationException;

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
            throw new ValidationException($exception->getMessage());
        }
    }

    public function validateEmail(string $email)
    {
        $email = $this->sanitizeData($email);
        if (empty($email)) {
            throw new ValidationException("Email is required.");
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new ValidationException("Invalid email format.");
        }
        return 1;
    }

    public function validatePassword(string $password)
    {
        $password = $this->sanitizeData($password);

        if (empty($password)) {
            throw new ValidationException("Password is required.");
        }
        if (strlen($password) < 8) {
            throw new ValidationException("Password must be at least 8 characters long.");
        }
        return 1;
    }
}
