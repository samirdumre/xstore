<?php

namespace Hazesoft\Backend\Models;

use Hazesoft\Backend\Config\SessionHandler;

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
    public function insertProductDetails($inputArray)
    {
        try {
            [$productName, $productPrice, $productQuantity] = $inputArray;
            $session = new SessionHandler();
            $created_at = date('Y-m-d H:i:s');
            $updated_at = date('Y-m-d H:i:s');
            $user_id = (int)$session->getSession("userId") ?? '';
            $sql = "INSERT INTO `products` (`user_id`, `name`, `price`, `quantity`, `created_at`, `updated_at`) VALUES ('$user_id', '$productName', '$productPrice', '$productQuantity', '$created_at', '$updated_at')";
            $result = $this->conn->query($sql);
            return $result;
        } catch (Exception $exception) {
            echo("Error inserting product " . $exception->getMessage());
        }
    }
}
