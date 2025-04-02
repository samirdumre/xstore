<?php

namespace Hazesoft\Backend\ValidationControllers;

require(__DIR__ . '/../../vendor/autoload.php');

use Exception;
use Hazesoft\Backend\Validations\LoginValidation;
//use Hazesoft\Backend\Validations\Exception as Exception;

if ($_SERVER["REQUEST_METHOD"] === 'POST') {
    // Capture form data
    $inputArray = [
        $_POST['email'] ?? '',
        $_POST['password'] ?? ''
    ];

    // Initialize validation
    try{
        $loginValidator = new LoginValidation();
    } catch (Exception $exception){
        throw new Exception($exception->getMessage());
    }


    try {
        $isLoginValid = $loginValidator->validateUserInput($inputArray);

        if ($isLoginValid) {
            echo "Login validation successful";

            // send data to db

        } else {
            throw new Exception("Signin validation error");
        }
    } catch (Exception $exception) {
        throw new Exception("Signin validation error: " . $exception->getMessage());
    }
}
