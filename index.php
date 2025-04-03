<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>xStore</title>
    <link rel="stylesheet" href="styles/global.css" />
</head>

<body>
    <div class="nav">
        <h1>Welcome to xStore<?php

                                // require_once(__DIR__ . 'src/Config/SessionHandler.php');

                                use Hazesoft\Backend\Config\SessionHandler;

                                $session = new SessionHandler();

                                if ($session->hasSession("isLoggedIn")) {
                                    echo ", {$session->getSession("firstName")}";
                                }
                                ?>
        </h1>
        <nav>
            <ul class="nav-elements">
                <li class="nav">
                    <a href="/">Home</a>
                </li>
                <li>
                    <a href="src/Views/productsinfo.php">Products</a>
                </li>

                <?php

                if ($session->hasSession("isLoggedIn")) {
                    echo '<li>
                <a href="src/Views/login.html">Sign In</a>
            </li>
            <li>
                <a href="src/Views/signup.html">Sign Up</a>
            </li> ';
                } else {
                    echo '
            <li>
                <a href="src/Controllers/Logout.php">Logout</a>
            </li> 
                ';
                }
                ?>
            </ul>
        </nav>
    </div>

</body>

</html>