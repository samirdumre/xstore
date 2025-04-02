<?php

namespace Hazesoft\Backend\Controllers\ValidationControllers;

use Exception;
use Hazesoft\Backend\Validations\SignupValidation;
use Hazesoft\Backend\Validations\ValidationException as ValidationException;

echo "Signup called";

if ($_SERVER["REQUEST_METHOD"] === 'POST') {

    // Capture form data
    $inputArray = [
        $_POST['firstName'] ?? '',
        $_POST['middleName'] ?? '',
        $_POST['lastName'] ?? '',
        $_POST['address'] ?? '',
        $_POST['email'] ?? '',
        $_POST['password'] ?? '',
        $_POST['confirmPassword'] ?? ''
    ];


    var_dump(class_exists('Hazesoft\Backend\Validations\SignupValidation'));
    // Initialize validation
    $signUpValidator = new SignupValidation();
    echo "Validaiotn error";

    try {
        $isSignUpValid = $signUpValidator->validateUserInput($inputArray);

        if ($isSignUpValid) {
            echo "Signup validation successful";

            // send data to db

        } else {
            echo "Validaiotn error";
            throw new ValidationException("Signup validation error");
        }
    } catch (Exception $exception) {
        echo "Validaiotn error";
        throw new ValidationException("Signup validation error: " . $exception->getMessage());
    }
}
