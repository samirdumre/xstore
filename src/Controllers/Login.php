<?php

namespace Hazesoft\Backend\Controllers;

require(__DIR__ . '/../../vendor/autoload.php');

use Hazesoft\Backend\Controllers\Sanitization;
use Hazesoft\Backend\Models\CheckUser;
use Exception;

$sanitize = new Sanitization();
$checkUser = new CheckUser();

class Login
{
    private $id;
    private $email;
    private $password;
    public $emailErr;
    public $passwordErr;

    public function setUser()
    {
        try {
            global $sanitize;
            if ($_SERVER["REQUEST_METHOD"] == "POST") {

                // for email
                if (empty($_POST["email"])) {
                    $this->emailErr = "Email is required";
                } else {
                    $this->email = $sanitize->sanitizeData($_POST["email"]);
                }

                // for password
                if (empty($_POST["password"])) {
                    $this->passwordErr = "Password is required";
                } else {
                    $this->password = $sanitize->sanitizeData($_POST["password"]);
                }
            }
        } catch (Exception $exception) {
            echo 'Message: ' . $exception->getMessage();
        }
    }
    public function checkUser()
    {
        try{
            global $checkUser;
            $doesUserExists = $checkUser->checkUser($this->email, $this->password);
            
            if($doesUserExists == false){
                die("Invalid email or password");
            } else {
                header("Location: product.html");
            }

        } catch (Exception $exception){
            die("Invalid email or password ".$exception->getMessage());
        }
    }

}

$userlogin = new Login();
$userlogin->setUser();
$userlogin->checkUser();
