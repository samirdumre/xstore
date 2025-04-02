<?php

namespace Hazesoft\Backend\Models;

require(__DIR__ . '/../../vendor/autoload.php');

use Exception;
use Hazesoft\Backend\Config\Connection;

class InsertUser
{
    private $conn;
    private $hashedPassword;
    public function __construct()
    {
        $connection = new Connection();
        $this->conn = $connection->connect();
    }
    public function insertUser($inputArray)
    {
        try {
            [$firstName, $middleName, $lastName, $address, $email, $password, $confirmPassword] = $inputArray; // destructuring of array

            $created_at = date('Y-m-d H:i:s');
            $updated_at = date('Y-m-d H:i:s');

            // password hashing before inserting to db
            $this->hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $sql = "INSERT INTO `users` (`first_name`, `middle_name`, `last_name`, `address`, `email`, `password`, `created_at`, `updated_at`) VALUES ('$firstName', '$middleName', '$lastName', '$address', '$email', '$this->hashedPassword', '$created_at', '$updated_at')";
            $result = $this->conn->query($sql);
            $this->conn->close();
            return $result;
        } catch (Exception $exception) {
            throw new Exception("Error inserting userdata into database " . $exception->getMessage());
        }
    }
}
