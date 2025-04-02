<?php

namespace Hazesoft\Backend\Models;

require(__DIR__ . '/../../vendor/autoload.php');

use Exception;
use Hazesoft\Backend\Config\Connection;
use Hazesoft\Backend\Controllers\Product;

// $product = new Product();
// $product->setProductDetails();

class InsertProduct
{
    private $conn;

    public function __construct()
    {
        $connection = new Connection();
        $this->conn = $connection->connect();
    }
    public function insertProductDetails($name, $price, $quantity)
    {
        try {
            session_start();
            $created_at = date('Y-m-d H:i:s');
            $updated_at = date('Y-m-d H:i:s');
            $user_id = (int)$_SESSION['user_id'];

            $sql = "INSERT INTO `products` (`user_id`, `name`, `price`, `quantity`, `created_at`, `updated_at`) VALUES ('$user_id', '$name', '$price', '$quantity', '$created_at', '$updated_at')";
            $result = $this->conn->query($sql);

            if ($result == true) {
                echo "Product added successfully <br>";
                return true;
            } else {
                echo "Error inserting product <br>";
                return false;
            }
        } catch (Exception $exception) {
            die("Error inserting product " . $exception->getMessage());
        }
    }
}
