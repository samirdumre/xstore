<?php

use Hazesoft\Backend\Validations\SignupValidation;
use Hazesoft\Backend\Validations\ValidationException as ValidationException;

if($_SERVER["REQUEST_METHOD"] === 'POST') {
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

    // Initialize validation
    $signUpValidator = new SignupValidation();

    try{
        $isSignUpValid = $signUpValidator->validateUserInput($inputArray);

        if($isSignUpValid){
            echo "Signup successful";

            // send data to db

        } else {
            throw new ValidationException("Signup validation error");
        }
    } catch (Exception $exception){
        throw new ValidationException("Signup validation error: " . $exception->getMessage());
    }
}