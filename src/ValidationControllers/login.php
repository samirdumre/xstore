<?php

namespace Hazesoft\Backend\ValidationControllers;


require(__DIR__ . '/../../vendor/autoload.php');

use Exception;
use Hazesoft\Backend\Models\InsertUser;
use Hazesoft\Backend\Validations\LoginValidation;
use Hazesoft\Backend\Validations\ValidationException;
use Hazesoft\Backend\Config\Connection;
use Hazesoft\Backend\Models\CheckUser;

if ($_SERVER["REQUEST_METHOD"] === 'POST') {
    try {
        // Capture form data
        $inputArray = [
            $_POST['email'] ?? '',
            $_POST['password'] ?? ''
        ];
    } catch (Exception $exception) {
        throw new ValidationException($exception->getMessage());
    }

    try {
        // Initialize validation
        $loginValidator = new LoginValidation();
        $isLoginValid = $loginValidator->validateUserInput($inputArray);

        if ($isLoginValid) {
            echo ("Login validation successful");

            // send data to db
            $checkUserObject = new CheckUser();
            $result = $checkUserObject->checkUser($inputArray);

            if ($result) {
                echo "Login successful";
            } else {
                echo "Login failed";
            }
        } else {
            echo "Validation error";
            throw new ValidationException("Signin validation error");
        }
    } catch (Exception $exception) {
        throw new ValidationException("Signin validation error: " . $exception->getMessage());
    }
}
