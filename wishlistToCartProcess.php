<?php

session_set_cookie_params(60 * 60 * 24 * 30);
session_start();
require "connection.php";

if (isset($_SESSION["user"])) {
    if (isset($_POST["id"])) {

        $pid = $_POST["id"];

        $wish_rs = Database::search("SELECT * FROM `wishlist` WHERE `product_id`='" . $pid . "' AND `user_email` =  '" . $_SESSION["user"]["email"] . "' ");
        $wish_num = $wish_rs->num_rows;

        if ($wish_num == 0) {
            echo "Something went wrong. Please try again later.";
        } else {

            $wishlist = $wish_rs->fetch_assoc();

            Database::iud("INSERT INTO `cart` (`product_id`,`user_email`,`qty`) VALUES('" . $pid . "','" . $_SESSION["user"]["email"]  . "','" . $wishlist['qty'] . "')");

            Database::iud("DELETE FROM `wishlist` WHERE `product_id`='" . $pid . "' AND `user_email` =  '" . $_SESSION["user"]["email"] . "' ");

            echo "Move Product to the cart";
        }
    } else {
        echo "Please select a product.";
    }
} else {
    echo "Please Sign In or Register.";
}
