<?php

namespace Hazesoft\Backend\Controllers\Frontend;

class HomePageController
{
    public function getHomepage()
    {
        return require_once __DIR__ . '/../../Views/homepage.php';
    }
}