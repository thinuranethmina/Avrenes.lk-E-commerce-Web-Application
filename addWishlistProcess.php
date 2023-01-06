<?php

session_set_cookie_params(60 * 60 * 24 * 30);
session_start();
require "connection.php";

if (isset($_SESSION["user"])) {
    if (isset($_POST["id"])) {

        $pid = $_POST["id"];
        $qty = $_POST["qty"];
        $uemail = $_SESSION["user"]["email"];

        $wishlist_rs = Database::search("SELECT * FROM `wishlist` WHERE  `product_id`='" . $pid . "' AND `user_email`='" . $uemail . "'");
        $wishlist_num = $wishlist_rs->num_rows;

        if ($wishlist_num == 1) {
            echo "Something went wrong.";
        } else {

            Database::iud("INSERT INTO `wishlist` (`product_id`,`user_email`,`qty`) VALUES('" . $pid . "','" . $uemail . "','" . $qty . "')");
            echo "success";
        }
    } else {
        echo "Something went wrong.";
    }
} else {
    echo "Please Sign In or Register.";
}
