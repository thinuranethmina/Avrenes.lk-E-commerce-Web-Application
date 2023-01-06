<?php

session_set_cookie_params(60 * 60 * 24 * 30);
session_start();
require "connection.php";

if (isset($_SESSION["user"])) {
    $city = $_POST["city"];

    if ($city == '0') {
        echo "-----";
    } else {
        $resultsetCity = Database::search("SELECT * FROM `city` WHERE `id`='" . $city . "';");
        $dataCity = $resultsetCity->fetch_assoc();

        if ($dataCity["postal_code"] == '') {
            echo "-----";
        } else {
            echo $dataCity["postal_code"];
        }
    }
} else {
    echo "Please Sign In or Register.";
}
