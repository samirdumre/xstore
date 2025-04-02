<?php

namespace Hazesoft\Backend\ValidationControllers;

require(__DIR__ . '/../../vendor/autoload.php');

use Exception;
use Hazesoft\Backend\Validations\ProductValidation;
//use Hazesoft\Backend\Validations\Exception as Exception;

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
            throw new Exception("Product validation error");
        }
    } catch (Exception $exception) {
        throw new Exception("Product validation error: " . $exception->getMessage());
    }
}
