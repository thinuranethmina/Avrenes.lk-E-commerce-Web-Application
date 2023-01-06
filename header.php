<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="bootstrap.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <!------ Include the above in your HEAD tag ---------->

    <link href="font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="header.css">
    <!-- Navigation -->

</head>
<?php
require "loading.php";
?>

<body onload="loaderEnd();" style="margin: 0;">

    <header class="topbar">
        <div class="row" style="width: 100%;">
            <div class="col-12 text01 mt-1">
                <marquee direction="left">
                    <?php

                    if (!isset($_COOKIE["PHPSESSID"])) {
                        session_set_cookie_params(60 * 60 * 24 * 30);
                        session_start();
                        if (isset($_SESSION["user"])) {
                            $data = $_SESSION["user"];
                            echo "<b>Hi, </b>" . $data["fname"] . " " . $data["lname"] . " Welcome to our eStore.";
                        } else {
                            echo "<b>Welcome</b> to our eStore.";
                        }
                    } else {

                        if (isset($_SESSION["user"])) {
                            $data = $_SESSION["user"];
                            echo "<b>Hi, </b>" . $data["fname"] . " " . $data["lname"] . " Welcome to our eStore.";
                        } else {
                            echo "<b>Welcome</b> to our eStore.";
                        }
                    }

                    ?>
                </marquee>
            </div>

        </div>
    </header>
    <nav class="navbar navbar-expand-lg navbar-dark mx-background-top-linear">
        <div class="container">
            <a class="navbar-brand" rel=" nofollow" href="index.php" style="font-family: Masque; font-size: 25px;">avrence.lk
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="text-lg-end col-12 col-lg-auto">
                <div class="collapse navbar-collapse" id="navbarResponsive">

                    <ul class="navbar-nav ml-auto">

                        <li class="nav-item text-center">
                            <!-- <a class="nav-link text-light" target="_blank" href="#" onMouseOver="this.style.fontWeight='bold'" onMouseOut="this.style.fontWeight='normal'"><img class="mb-1  d-none d-lg-inline-block" src="https://img.icons8.com/ios-glyphs/30/ffffff/money-bag.png" style="height: 20px;" /> Sell</a> -->
                        </li>

                        <li class="nav-item text-center">
                            <a class="nav-link text-light" target="_blank" href="./wishlist.php" onMouseOver="this.style.fontWeight='bold'" onMouseOut="this.style.fontWeight='normal'"><img class="mb-1  d-none d-lg-inline-block" src="https://img.icons8.com/material-sharp/24/ffffff/like--v1.png" style="height: 20px;" /> Wishlist</a>
                        </li>

                        <li class="nav-item text-center">
                            <a class="nav-link text-light" target="_blank" href="./cart.php" onMouseOver="this.style.fontWeight='bold'" onMouseOut="this.style.fontWeight='normal'"> <img class="mb-1 d-none d-lg-inline-block" src="https://img.icons8.com/glyph-neue/64/ffffff/shopping-cart.png" style="height: 20px;" /> My Cart </a>
                        </li>

                        <li class="nav-item d-lg-none text-center">
                            <a class="nav-link text-light" href="#" onclick="startModal();" onMouseOver="this.style.fontWeight='bold'" onMouseOut="this.style.fontWeight='normal'"> My AVRENCE</a>
                        </li>

                        <li class="nav-item d-none d-lg-block">
                            <div class="col-2 dropdown">

                                <a class="nav-link text-light dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false" onMouseOver="this.style.fontWeight='bold'" onMouseOut="this.style.fontWeight='normal'">
                                    My AVRENCE
                                </a>

                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                    <li><a class="dropdown-item" target="_blank" href="./myorders.php">My Orders</a></li>
                                    <li><a class="dropdown-item" target="_blank" href="./message.php">Messages</a></li>
                                    <li><a class="dropdown-item" target="_blank" href="./wishlist.php">Wish List</a></li>
                                    <li><a class="dropdown-item" target="_blank" href="./userProfile.php" target="_blank">My profile</a></li>
                                </ul>

                            </div>
                        </li>


                        <?php

                        if (isset($_SESSION["user"])) {
                        ?>

                            <li class="nav-item text-center">
                                <a class="nav-link text-warning" href="#" onclick="signOut();" onMouseOver="this.style.fontWeight='bold'" onMouseOut="this.style.fontWeight='normal'"> Sign Out</a>
                            </li>

                        <?php
                        } else {
                        ?>
                            <li class="nav-item text-center">
                                <a class="nav-link" href="index.php"> <b style="color: #00ccff;" onMouseOver="this.style.fontWeight='normal'" onMouseOut="this.style.fontWeight='bold'">Sign In</b></a>
                            </li>
                        <?php
                        }
                        ?>

                    </ul>
                </div>
            </div>
            <div id="modal" class="modal d-lg-none">

                <div class="modal-content">
                    <div class="modal-body">
                        <div class="row gy-2 pt-2 pb-2">

                            <!-- Modal -->
                            <div class="col-12"><a class="dropdown-item" target="_blank" href="./myorders.php">My Orders</a></div>
                            <div class="col-12"><a class="dropdown-item" target="_blank" href="./message.php">Messages</a></div>
                            <!-- <div class="col-12"><a class="dropdown-item" target="_blank" href="#">My Selling</a></div> -->
                            <div class="col-12"><a class="dropdown-item" target="_blank" href="./myProduct.php">My Product</a></div>
                            <div class="col-12"><a class="dropdown-item" target="_blank" href="./wishlist.php">Wish List</a></div>
                            <div class="col-12"><a class="dropdown-item" target="_blank" href="./userProfile.php">My profile</a></div>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </nav>
    <!-- </div> -->

    <script src="jquery-1.11.1.min.js"></script>
    <script src="bootstrap4.0.min.js"></script>
    <script src="bootstrap.bundle.js"></script>
    <script>
        function startModal() {
            document.getElementById("modal").style.display = "block";
        }

        function area(event) {
            if (event.target == modal) {
                document.getElementById("modal").style.display = "none";
            }
        }
    </script>
    <script src="script.js"></script>
</body>

</html>