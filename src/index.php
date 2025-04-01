<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>xStore</title>
    <link rel="stylesheet" href="styles/styles.css" />
</head>

<body>
    <div class="nav">
        <h1>Welcome to xStore<?php

                                if (isset($_SESSION["isLoggedIn"])) {
                                    echo ", " . $_SESSION["first_name"];
                                }
                                ?>
        </h1>
        <nav>
            <ul class="nav-elements">
                <li class="nav">
                    <a href="/">Home</a>
                </li>
                <li>
                    <a href="Views/productsinfo.php">Products</a>
                </li>

                <?php

                if (!isset($_SESSION["isLoggedIn"])) {
                    echo '<li>
                <a href="Views/login.html">Sign In</a>
            </li>
            <li>
                <a href="Views/signup.html">Sign Up</a>
            </li> ';
                } else {
                    echo '
            <li>
                <a href="Controllers/Logout.php">Logout</a>
            </li> 
                ';
                }
                ?>
            </ul>
        </nav>
    </div>

</body>

</html>