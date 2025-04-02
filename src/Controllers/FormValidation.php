<?php

namespace Hazesoft\Backend\Controllers;

require(__DIR__ . '/../../vendor/autoload.php');

use Hazesoft\Backend\Models\InsertUser;
use Hazesoft\Backend\Controllers\Sanitization;
use Exception;

// $sanitize = new Sanitization();
// $insertUser = new InsertUser();

class FormValidation
{
    private $fname;
    private $mname;
    private $lname;
    private $address;
    private $email;
    private $create_password;
    private $confirm_password;
    private $hashed_password;
    public $fnameErr;
    public $mnameErr;
    public $lnameErr;
    public $addressErr;
    public $emailErr;
    public $passwordErr;
    private $sanitize;
    private $insertUser;

    public function __construct()
    {
        $this->fnameErr = $this->mnameErr = $this->lnameErr = $this->addressErr = $this->passwordErr = $this->emailErr = '';
        $this->sanitize = new Sanitization();
        $this->insertUser = new InsertUser();
    }

    public function getFormData()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Validate first name
            if (empty($_POST["fname"])) {
                $this->fnameErr = "First Name is required";
            } else {
                $this->fname = $this->sanitize->sanitizeData($_POST["fname"]);
                if (!preg_match("/^[a-zA-Z]+$/", $this->fname)) {
                    $this->fnameErr = "Only alphabets are allowed as First Name";
                }
            }

            // Validate middle name
            if (!empty($_POST["mname"])) {
                $this->mname = $this->sanitize->sanitizeData($_POST["mname"]);
                if (!preg_match("/^[a-zA-Z\s]+$/", $this->mname)) {
                    $this->mnameErr = "Only alphabets are allowed as Middle Name";
                }
            }

            // Validate last name
            if (empty($_POST["lname"])) {
                $this->lnameErr = "Last Name is required";
            } else {
                $this->lname = $this->sanitize->sanitizeData($_POST["lname"]);
                if (!preg_match("/^[a-zA-Z]+$/", $this->lname)) {
                    $this->lnameErr = "Only alphabets are allowed as Last Name";
                }
            }

            // Validate address
            if (empty($_POST["address"])) {
                $this->addressErr = "Address is required";
            } else {
                $this->address = $this->sanitize->sanitizeData($_POST["address"]);
                if (strlen($this->address) < 5) {
                    $this->addressErr = "Address must be at least 5 characters long";
                }
            }

            // Validate email
            if (empty($_POST["email"])) {
                $this->emailErr = "Email is required";
            } else {
                $this->email = $this->sanitize->sanitizeData($_POST["email"]);
                if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
                    $this->emailErr = "Please provide a valid email address";
                }
            }

            // Validate password
            if (empty($_POST["create_password"])) {
                $this->passwordErr = "Password is required";
            } else {
                $this->create_password = $this->sanitize->sanitizeData($_POST["create_password"]);
            }

            // Confirm password
            if (empty($_POST["confirm_password"])) {
                $this->passwordErr = "Password confirmation is required";
            } else {
                $this->confirm_password = $this->sanitize->sanitizeData($_POST["confirm_password"]);
                if ($this->confirm_password !== $this->create_password) {
                    $this->passwordErr = "Passwords do not match";
                } else {
                    $this->hashed_password = password_hash($this->confirm_password, PASSWORD_DEFAULT);
                }
            }

            // Stop further processing if there are errors
            if (!empty($this->fnameErr) || !empty($this->lnameErr) || !empty($this->emailErr) || !empty($this->passwordErr)) {
                return;
            }
        }
    }

    // public function insertFormData()
    // {
    //     // global $insertUser;
    //     if ($this->fnameErr == "" && $this->mnameErr == "" && $this->lnameErr == "" && $this->addressErr == "" && $this->emailErr == "" && $this->passwordErr == "") {
    //         $result = $this->insertUser->insertUser($this->fname, $this->mname, $this->lname, $this->address, $this->email, $this->hashed_password);

    //         if ($result == false) {
    //             die("Error inserting data into database");
    //         } else {
    //             if (isset($_POST["submit"])) {
    //                 header("Location: login.html");
    //             }
    //         }
    //     }
    // }
    public function insertFormData()
    {
        // Stop if there are validation errors
        if (!empty($this->fnameErr) || !empty($this->lnameErr) || !empty($this->emailErr) || !empty($this->passwordErr)) {
            return;
        }

        try {
            $result = $this->insertUser->insertUser($this->fname, $this->mname, $this->lname, $this->address, $this->email, $this->hashed_password);

            if (!$result) {
                throw new Exception("Database insertion failed");
            }
        } catch (Exception $e) {
            error_log($e->getMessage());
            $this->fnameErr = "An error occurred while saving your data. Please try again.";
            return;
        }
    }

    public function resetErrors()
    {
        try {
            // Reset form data variables
            $this->fname = $this->mname = $this->lname = $this->address = $this->email = $this->create_password = $this->confirm_password = $this->hashed_password = '';

            // Reset error variables
            $this->fnameErr = $this->mnameErr = $this->lnameErr = $this->addressErr = $this->passwordErr = $this->emailErr = '';
        } catch (Exception $e) {
            error_log("Error resetting form data: " . $e->getMessage());
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    echo '<pre>';
    print_r($_POST);
    echo '</pre>';
    // Add your form handling logic here
}

// $formData = new FormValidation();
// $formValidation = new FormValidation();
// $formValidation->getFormData();
// $formValidation->insertFormData();
echo "Loaded";
$formValidation = new FormValidation();
$formValidation->getFormData();

if (!empty($formValidation->fnameErr) || !empty($formValidation->lnameErr) || !empty($formValidation->emailErr) || !empty($formValidation->passwordErr)) {
    echo "Validation errors occurred.";
    print_r([
        'fnameErr' => $formValidation->fnameErr,
        'lnameErr' => $formValidation->lnameErr,
        'emailErr' => $formValidation->emailErr,
        'passwordErr' => $formValidation->passwordErr,
    ]);
    exit();
}

$formValidation->insertFormData();
