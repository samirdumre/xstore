<?php

namespace Hazesoft\Backend\Models;

use Exception;
use Hazesoft\Backend\Services\Connection;
use Hazesoft\Backend\Services\Session;

class User
{
    private $conn;
    private $hashedPassword;
    public function __construct()
    {
        $connection = new Connection();
        $this->conn = $connection->connect();
    }
    public function checkUser($inputArray): bool
    {
        try {
            [$email, $password] = $inputArray;

            $stmt = $this->conn->prepare("SELECT `id`, `first_name`, `email`, `password` FROM users WHERE `email`= ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();

            $userData = $stmt->get_result();
            // $sql = "SELECT `id`, `first_name`, `email`, `password` FROM users WHERE `email`='$email'";
            // $userData = $this->conn->query($sql);

            $row = $userData->fetch_assoc();
            $hashed_password = $row["password"];

            if (password_verify($password, $hashed_password)) {
                $session = Session::getInstance();
                $session->setSession("userId" , (int)$row["id"]);
                $session->setSession("firstName" , $row["first_name"]);
                $session->setSession("isLoggedIn" , true);
                return true;
            } else {
                echo ("Invalid password");
                return false;
            }
        } catch (Exception $exception) {
            echo ("Invalid email or password " . $exception->getMessage());
            return false;
        }
    }
    public function insertUser($inputArray): bool
    {
        try {
            [$firstName, $middleName, $lastName, $address, $email, $password, $confirmPassword] = $inputArray; // destructuring of array

            $created_at = date('Y-m-d H:i:s');
            $updated_at = date('Y-m-d H:i:s');

            // password hashing before inserting to db
            $this->hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Preventing SQL injection
            $stmt = $this->conn->prepare("INSERT INTO `users` (`first_name`, `middle_name`, `last_name`, `address`, `email`, `password`, `created_at`, `updated_at`) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssssss", $firstName, $middleName, $lastName, $address, $email, $this->hashedPassword, $created_at, $updated_at);

            $result = $stmt->execute();

            // $sql = "INSERT INTO `users` (`first_name`, `middle_name`, `last_name`, `address`, `email`, `password`, `created_at`, `updated_at`) VALUES ('$firstName', '$middleName', '$lastName', '$address', '$email', '$this->hashedPassword', '$created_at', '$updated_at')";
            // $result = $this->conn->query($sql);

            $stmt->close();
            $this->conn->close();
            return $result;
        } catch (Exception $exception) {
            throw new Exception("Error inserting userdata into database " . $exception->getMessage());
        }
    }
    public function doesEmailExists($email): bool
    {
        try {
            $stmt = $this->conn->prepare("SELECT `email` FROM users WHERE `email`= ?");
            $stmt->bind_param("s", $email);

            $stmt->execute();
            $userData = $stmt->get_result();

            $row = $userData->fetch_assoc();

            // var_dump($row);
            $userEmail = $row["email"] ?? false;
            // var_dump($userEmail);

            if ($userEmail) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage());
        }
    }
}
