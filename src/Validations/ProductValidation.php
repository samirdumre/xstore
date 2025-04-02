<?php

namespace Hazesoft\Backend\Validations;

require(__DIR__ . '/../../vendor/autoload.php');

use Exception;
use Hazesoft\Backend\Validations\Validation;
//use Hazesoft\Backend\Validations\Exception as Exception;

class ProductValidation extends Validation{
    public function validateUserInput(array $inputArray){
        [$productName, $productPrice, $productQuantity] = $inputArray;

        try{
            // validation status
            $isValidationOk = 0;

            $isValidationOk += $this->validateName($productName);
            $isValidationOk += $this->validateNumber($productPrice, "Product price");
            $isValidationOk += $this->validateNumber($productQuantity, "Product quantity");

            if($isValidationOk == 3){
                return true;
            } else {
                return false;
            }
        } catch (Exception $exception){
            throw new Exception($exception->getMessage());
        }
    }

    public function validateName(string $name)
    { 
        $name = $this->sanitizeData($name);
        if (empty($name)) {
            throw new Exception("Product name is required");
        }
        if (!preg_match("/^[a-zA-Z\s]+$/", $name)) {
            throw new Exception("Product name can contain only letters and spaces.");
        }
        return 1; // No error
    }

    public function validateNumber(float $number, string $type)
    { 
        $number = $this->sanitizeData($number);
        if (empty($number)) {
            throw new Exception("{$type} is required");
        }
        if($number <= 0){
            throw new Exception("{$type} should be greater than 0");
        }
        if(!is_numeric($number)){
            throw new Exception("{$type} should be a valid number");
        }
        return 1; // No error
    }
}