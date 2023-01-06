<?php

session_set_cookie_params(60 * 60 * 24 * 30);
session_start();
require "connection.php";

if (isset($_SESSION["user"])) {
    if (isset($_GET["id"])) {

        $pid = $_GET["id"];

        //     Database::iud("INSERT INTO `recent` (`product_id`,`users_email`) VALUES 
        // ('" . $product_id . "','" . $user_email . "')");

        Database::iud("DELETE FROM `cart` WHERE `product_id`='" . $pid . "' AND `user_email` = '" . $_SESSION["user"]["email"] . "'");

        echo ("success");
    } else {
        echo "Something went wrong.";
    }
} else {
    echo "Please Log In or Sign Up";
}
