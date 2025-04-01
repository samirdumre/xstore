<?php

namespace Hazesoft\Backend\Models;

use Exception;
use Hazesoft\Backend\Config\Connection;

$connection = new Connection('127.0.0.1', 'root', '', 'mydb');
$conn = $connection->connect();

class CheckUser
{
    public function checkUser($email, $password)
    {
        try {
            global $conn;
            $sql = "SELECT `id`, `first_name`, email`, `password` FROM users WHERE `email`='$email'";
            $userData = $conn->query($sql);

            $row = $userData->fetch_assoc();
            $hashed_password = $row["password"];

            if (password_verify($password, $hashed_password)) {
                session_start();
                $_SESSION["user_id"] = (int)$row["id"];
                $_SESSION["first_name"] = $row["first_name"];
                $_SESSION["user_email"] = $row["email"];
                $_SESSION["isLoggedIn"] = true;
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
}
