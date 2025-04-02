<?php

namespace Hazesoft\Backend\Models;

require(__DIR__ . '/../../vendor/autoload.php');

use Exception;
use Hazesoft\Backend\Config\Connection;

$connection = new Connection('127.0.0.1', 'root', '', 'mydb');
$conn = $connection->connect();

class InsertUser{
    public function insertUser ($fname, $mname, $lname, $address, $email, $hashed_password){
        try {
            global $conn;
            global $connection;
            $created_at = date('Y-m-d H:i:s');
            $updated_at = date('Y-m-d H:i:s');

            $sql = "INSERT INTO `users` (`first_name`, `middle_name`, `last_name`, `address`, `email`, `password`, `created_at`, `updated_at`) VALUES ('$fname', '$mname', '$lname', '$address', '$email', '$hashed_password', '$created_at', '$updated_at')";
            $result = $conn->query($sql);
            $connection->disconnect();
            return $result;
        } catch (Exception $exception){
            throw new Exception("Error inserting userdata into database ". $exception->getMessage());
        }

    }
}