<?php

namespace Hazesoft\Backend\Validations;

require(__DIR__ . '/../../vendor/autoload.php');

use Exception;
use Hazesoft\Backend\Validations\Validation;
//use Hazesoft\Backend\Validations\Exception as Exception;

class SignupValidation extends Validation{
    public function validateUserInput(array $inputArray): bool
    {
        [$firstName, $middleName, $lastName, $address, $email, $password, $confirmPassword] = $inputArray; // destructuring of array
        
        try {
            // validation status
            $isValidationOk = 0;

            $isValidationOk += $this->validateName($firstName, "First Name");
            $isValidationOk += $this->validateName($middleName, "Middle Name");
            $isValidationOk += $this->validateName($lastName, "Last Name");
            $isValidationOk += $this->validateAddress($address);
            $isValidationOk += $this->validateEmail($email);
            $isValidationOk += $this->validatePassword($password, $confirmPassword);

            if ($isValidationOk == 6) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage());
        }
        
    }

    public function validateName(string $name, string $type): int
    {  // type = first name, midlle name or last name
        $name = $this->sanitizeData($name);
        if (empty($name)) {
            throw new Exception("{$type} is required");
        }
        if (!preg_match("/^[a-zA-Z\s]+$/", $name)) {
            throw new Exception("{$type} can contain only letters and spaces.");
        }
        return 1; // No error
    }

    public function validateAddress(string $address): int
    {
        $address = $this->sanitizeData($address);
        if (empty($address)) {
            throw new Exception("Address is required.");
        }
        if (strlen($address) < 5) {
            throw new Exception("Address must be at least 5 characters long.");
        }
        return 1;
    }

    public function validateEmail(string $email): int
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

    public function validatePassword(string $password, string $confirmPassword): int
    {
        $password = $this->sanitizeData($password);
        $confirmPassword = $this->sanitizeData($confirmPassword);

        if (empty($password) || empty($confirmPassword)) {
            throw new Exception("Password and confirmation are required.");
        }
        if ($password !== $confirmPassword) {
            throw new Exception("Passwords do not match.");
        }
        if (strlen($password) < 8) {
            throw new Exception("Password must be at least 8 characters long.");
        }
        return 1;
    }
}
