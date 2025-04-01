<?php

namespace Hazesoft\Backend\Controllers;

class Sanitization
{
    public function sanitizeData($data)
    {
        $data = trim($data);
        $data = htmlspecialchars($data);
        return $data;
    }
}



