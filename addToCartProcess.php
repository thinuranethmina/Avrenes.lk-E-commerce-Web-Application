<?php

session_set_cookie_params(60 * 60 * 24 * 30);
session_start();
require "connection.php";

if (isset($_SESSION["user"])) {
    if (isset($_POST["id"])) {

        $pid = $_POST["id"];
        $qty = $_POST["qty"];
        $uemail = $_SESSION["user"]["email"];

        $cartProduct_rs = Database::search("SELECT * FROM `cart` WHERE   user_email='" . $uemail . "' AND product_id='" . $pid . "'");
        $cart_product_num = $cartProduct_rs->num_rows;

        $product_qty_rs = Database::search("SELECT `qty` FROM `product` WHERE id='" . $pid . "'");
        $product_qty_data = $product_qty_rs->fetch_assoc();

        $product_qty = $product_qty_data["qty"];

        if ($cart_product_num == 1) {
            $cartProductData = $cartProduct_rs->fetch_assoc();
            $currentQty = $cartProductData["qty"];
            $newQty = (int)$currentQty + (int)$qty;

            if ($product_qty >= $newQty) {
                Database::iud("UPDATE `cart` SET `qty`='" . $newQty . "' 
                WHERE user_email='" . $uemail . "' AND product_id='" . $pid . "'");

                echo "Product quantity Updated";
            } else {
                echo "Invalid Product Quantity";
            }
        } else {

            Database::iud("INSERT INTO `cart` (`product_id`,`user_email`,`qty`) VALUES('" . $pid . "','" . $uemail . "','" . $qty . "')");

            echo "New Product added to the cart";
        }
    } else {
        echo "Sorry For the Inconvenient";
    }
} else {
    echo "Please Log In or Sign Up";
}
