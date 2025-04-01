<?php

namespace Hazesoft\Backend\Controllers;

use Hazesoft\Backend\Models\InsertProduct;
$insertproduct = new InsertProduct();

use Exception;

class Product
{
    private $name;
    private $price;
    private $quantity;
    public $nameErr;
    public $priceErr;
    public $quantityErr;

    public function setProductDetails(){
        try{
            if($_SERVER["REQUEST_METHOD"] == "POST"){
                
                if(empty($_POST["product_name"])){
                    $this->nameErr = "Product name is required";
                } else {
                    $this->name = $_POST["product_name"];
                }

                if (empty($_POST["product_price"])) {
                    $this->priceErr = "Product price is required";
                } else {
                    $this->price = $_POST["product_price"];
                }

                if (empty($_POST["product_quantity"])) {
                    $this->quantityErr = "Product quantity is required";
                } else {
                    $this->quantity = $_POST["product_quantity"];
                }
            }

        } catch(Exception $exception){
            die("Error setting product details ". $exception->getMessage());
        }
    }

    public function getProductDetails(){
        try {
            return [$this->name, $this->price, $this->quantity];
        } catch(Exception $exception){
            die("Error getting product details ". $exception->getMessage());
        }
    }

    public function insertProductDetails(){
        try{
            global $insertproduct;
            $result = $insertproduct->insertProductDetails($this->name, $this->price, $this->quantity);

            if($result == true){
                echo "Successfully inserted product details <br>";
            } else {
                echo "Error inserting product details <br>";
            }
        } catch (Exception $exception){
            die("Error inserting product details ". $exception->getMessage());
        }
    }

}

$newProduct = new Product();
$newProduct->setProductDetails();
$newProduct->insertProductDetails();
