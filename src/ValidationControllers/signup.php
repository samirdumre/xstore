<?php

namespace Hazesoft\Backend\ValidationControllers;

require(__DIR__ . '/../../vendor/autoload.php');

use Exception;
use Hazesoft\Backend\Validations\SignupValidation;
//use Hazesoft\Backend\Validations\Exception as Exception;

echo "Signup called";

if((isset($_SERVER['REQUEST_METHOD'])) && ($_SERVER['REQUEST_METHOD'] == 'POST')) {

    // Capture form data
    $inputArray = [
        $_POST['firstName'] ?? '',
        $_POST['middleName'] ?? 'null',
        $_POST['lastName'] ?? '',
        $_POST['address'] ?? '',
        $_POST['email'] ?? '',
        $_POST['password'] ?? '',
        $_POST['confirmPassword'] ?? ''
    ];

    var_dump(class_exists('Hazesoft\Backend\Validations\SignupValidation'));
    // Initialize validation
    $signUpValidator = new SignupValidation();

    try {
        $isSignUpValid = $signUpValidator->validateUserInput($inputArray);

        if ($isSignUpValid) {
            echo "Signup validation successful";

            // send data to db

        } else {
            throw new Exception("Signup validation error");
        }
    } catch (Exception $exception) {
        throw new Exception("Signup validation error: " . $exception->getMessage());
    }
}
