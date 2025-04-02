<?php

namespace Hazesoft\Backend\Controllers;

require(__DIR__ . '/../../vendor/autoload.php');

class Sanitization
{
    public function sanitizeData($data)
    {
        $data = trim($data);
        $data = htmlspecialchars($data);
        return $data;
    }
}



