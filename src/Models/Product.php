<?php

namespace Hazesoft\Backend\Models;

use Hazesoft\Backend\Config\SessionHandler;

require(__DIR__ . '/../../vendor/autoload.php');

use Exception;
use Hazesoft\Backend\Config\Connection;
// use Hazesoft\Backend\Controllers\Product;

// $product = new Product();
// $product->setProductDetails();

class Product
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
            echo ("Error inserting product " . $exception->getMessage());
        }
    }

    public function getAllProducts()
    {
        try {
            $query = "SELECT * from products";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            $result = $stmt->get_result();

            $products = $result->fetch_all(MYSQLI_ASSOC);
            return $products;
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage());
        }
    }

    public function getUserProducts($userId)
    {
        try {
            $query = "SELECT * FROM products WHERE user_id = ?";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("i", $userId);
            $stmt->execute();
            $result = $stmt->get_result();

            $products = $result->fetch_all(MYSQLI_ASSOC);
            return $products;
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage());
        }
    }
    public function getOtherProducts($userId)
    {
        // returns all product except for user's
        try {
            $query = "SELECT * FROM products WHERE user_id != ?";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("i", $userId);
            $stmt->execute();
            $result = $stmt->get_result();

            $products = $result->fetch_all(MYSQLI_ASSOC);
            return $products;
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage());
        }
    }

    public function deleteProduct($productId) {  
        try{
            $query = "DELETE FROM products WHERE id = ?";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("i", $productId);
            $result = $stmt->execute();

            if($result){
                header("Location: ../Views/productsinfo.php");
            } else {
                echo "Product deletion went wrong";
            }

        } catch (Exception $exception){
            throw new Exception($exception->getMessage());
        }
    }

    public function updateProduct($productId, $productName, $productPrice, $productQuantity){
        try{
            $updated_at = date('Y-m-d H:i:s');
            $query = "UPDATE products SET name = ?, price = ?, quantity = ?, updated_at = ? WHERE id = ?";

            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("sdis", $productName, $productPrice, $productQuantity, $updated_at);
            $result = $stmt->execute();
            if($result){
                header("Location: ../Views/productsinfo.php");
            } else {
                echo "Error updating product, Product Name: {$productName}";
            }

        } catch(Exception $exception){
            throw new Exception($exception->getMessage());
        }
    }
}
