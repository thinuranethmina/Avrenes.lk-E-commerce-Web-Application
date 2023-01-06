<?php

session_set_cookie_params(60 * 60 * 24 * 30);
session_start();
require "connection.php";

if (isset($_SESSION["user"])) {
    if (isset($_GET["id"])) {

        $pid = $_GET["id"];

        $watch_rs = Database::search("SELECT * FROM `wishlist` WHERE `product_id`='" . $pid . "' AND `user_email` =  '" . $_SESSION["user"]["email"] . "' ");
        $watch_num = $watch_rs->num_rows;

        if ($watch_num == 0) {
            echo "Something went wrong. Please try again later.";
        } else {

            Database::iud("DELETE FROM `wishlist` WHERE `product_id`='" . $pid . "' AND `user_email` =  '" . $_SESSION["user"]["email"] . "' ");
            echo "success";
        }
    } else {
        echo "Please select a product.";
    }
} else {
    echo "Please Sign In or Register.";
}
