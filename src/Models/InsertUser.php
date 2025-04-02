<?php

namespace Hazesoft\Backend\Models;

require(__DIR__ . '/../../vendor/autoload.php');

use Exception;
use Hazesoft\Backend\Config\Connection;


class InsertUser
{
    private $conn;
    public function __construct()
    {
        $connection = new Connection();
        $conn = $connection->connect();
    }
    public function insertUser($fname, $mname, $lname, $address, $email, $hashed_password)
    {
        try {
            global $connection;
            $created_at = date('Y-m-d H:i:s');
            $updated_at = date('Y-m-d H:i:s');

            $sql = "INSERT INTO `users` (`first_name`, `middle_name`, `last_name`, `address`, `email`, `password`, `created_at`, `updated_at`) VALUES ('$fname', '$mname', '$lname', '$address', '$email', '$hashed_password', '$created_at', '$updated_at')";
            $result = $this->conn->query($sql);
            $this->conn->close();
            return $result;
        } catch (Exception $exception) {
            throw new Exception("Error inserting userdata into database " . $exception->getMessage());
        }
    }
}
