<?php

namespace Hazesoft\Backend\Controllers\ValidationControllers;

use Exception;
use Hazesoft\Backend\Validations\LoginValidation;
use Hazesoft\Backend\Validations\ValidationException as ValidationException;

if ($_SERVER["REQUEST_METHOD"] === 'POST') {
    // Capture form data
    $inputArray = [
        $_POST['email'] ?? '',
        $_POST['password'] ?? ''
    ];

    // Initialize validation
    $loginValidator = new LoginValidation();

    try {
        $isLoginValid = $loginValidator->validateUserInput($inputArray);

        if ($isLoginValid) {
            echo "Login validation successful";

            // send data to db

        } else {
            throw new ValidationException("Signin validation error");
        }
    } catch (Exception $exception) {
        throw new ValidationException("Signin validation error: " . $exception->getMessage());
    }
}
