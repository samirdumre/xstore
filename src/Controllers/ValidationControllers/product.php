<?php

namespace Hazesoft\Backend\Controllers\ValidationControllers;

use Exception;
use Hazesoft\Backend\Validations\ProductValidation;
use Hazesoft\Backend\Validations\ValidationException as ValidationException;

if ($_SERVER["REQUEST_METHOD"] === 'POST') {
    // Capture form data
    $inputArray = [
        $_POST['productName'] ?? '',
        $_POST['productPrice'] ?? '',
        $_POST['productQuantity'] ?? ''
    ];

    // Initialize validation
    $productValidator = new ProductValidation();

    try {
        $isProductValid = $productValidator->validateUserInput($inputArray);

        if ($isProductValid) {
            echo "Product validation successful";

            // send data to db

        } else {
            throw new ValidationException("Product validation error");
        }
    } catch (Exception $exception) {
        throw new ValidationException("Product validation error: " . $exception->getMessage());
    }
}
