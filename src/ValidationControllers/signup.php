<?php

namespace Hazesoft\Backend\ValidationControllers;

require(__DIR__ . '/../../vendor/autoload.php');

use Exception;
use Hazesoft\Backend\Validations\SignupValidation;
use Hazesoft\Backend\Validations\ValidationException;
use Hazesoft\Backend\Models\InsertUser; // Ensure this is the correct namespace for InsertUser

if ((isset($_SERVER['REQUEST_METHOD'])) && ($_SERVER['REQUEST_METHOD'] == 'POST')) {
    try {
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
    } catch (Exception $exception) {
        throw new ValidationException($exception->getMessage());
    }

    try {
        // Initialize validation
        $signUpValidator = new SignupValidation();
        $isSignUpValid = $signUpValidator->validateUserInput($inputArray);

        if ($isSignUpValid) {
            echo "Signup validation successful";

            // send data to db
            $insertUserObject = new InsertUser();
            $result = $insertUserObject->insertUser($inputArray);

            if($result){
                echo"User created successfully";
            } else {
                echo "User creation failed";
            }

        } else {
            throw new ValidationException("Signup validation error");
        }
    } catch (Exception $exception) {
        throw new ValidationException("Signup validation error: " . $exception->getMessage());
    }
}
