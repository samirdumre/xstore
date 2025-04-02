<?php

namespace Hazesoft\Backend\ValidationControllers;

require(__DIR__ . '/../../vendor/autoload.php');

use Exception;
use Hazesoft\Backend\Validations\ProductValidation;
use Hazesoft\Backend\Validations\ValidationException;
use Hazesoft\Backend\Models\InsertProduct;

if ($_SERVER["REQUEST_METHOD"] === 'POST') {
    try {
        // Capture form data
        $inputArray = [
            $_POST['productName'] ?? '',
            $_POST['productPrice'] ?? '',
            $_POST['productQuantity'] ?? ''
        ];
    } catch (Exception $exception) {
        throw new ValidationException($exception->getMessage());
    }

    try {
        // Initialize validation
        $productValidator = new ProductValidation();

        // Sanitization of inputArray
        $sanitizedInputArray = $productValidator->sanitizeArray($inputArray);
        $isProductValid = $productValidator->validateUserInput($sanitizedInputArray);

        if ($isProductValid) {
            echo "Product validation successful";

            // send data to db
            $insertProductObject = new InsertProduct();
            $result = $insertProductObject->insertProductDetails($inputArray);
            if ($result) {
                echo "Product added successfully";
            } else {
                echo "Product addition failed";
            }
            
        } else {
            throw new ValidationException("Product validation error");
        }
    } catch (Exception $exception) {
        throw new ValidationException("Product validation error: " . $exception->getMessage());
    }
}
