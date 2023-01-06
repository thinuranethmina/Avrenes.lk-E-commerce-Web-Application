<?php

session_set_cookie_params(60 * 60 * 24 * 30);
session_start();
require "connection.php";

if (isset($_SESSION["user"])) {
    $productId = $_GET["p"];
    $statusId = $_GET["s"];

    $statusrs = Database::search("SELECT * FROM `product` WHERE `id`='" . $productId . "';");
    $sn = $statusrs->num_rows;

    if ($sn == 1) {
        $sd = $statusrs->fetch_assoc();
        $statusId = $sd["status_id"];

        if ($statusId == 1) {
            Database::iud("UPDATE `product` SET `status_id`='2' WHERE `id`='" . $productId . "'; ");
            echo "Deactivated";
        } else if ($statusId == 2) {
            Database::iud("UPDATE `product` SET `status_id`='1' WHERE `id`='" . $productId . "'; ");
            echo "Activated";
        }
    } else {
        echo "Somthing when wrong";
    }
} else {
    echo "Please Sign In or Register.";
}
