<?php

session_set_cookie_params(60 * 60 * 24 * 30);
session_start();

require "connection.php";

$email = $_POST["email"];
$password = $_POST["password"];
$rememberMe = $_POST["rememberMe"];

if (empty($email)) {
    echo "Please enter your Email Address.";
} else if (empty($password)) {
    echo "Please enter your Password.";
} else {

    $resultset = Database::search("SELECT * FROM `user` WHERE `email`='" . $email . "' AND `password`='" . $password . "';");
    $n = $resultset->num_rows;

    if ($n == 1) {

        echo "success";
        $d = $resultset->fetch_assoc();
        $_SESSION["user"] = $d;
        if ($rememberMe == "true") {
            setcookie("email", $email, time() + (60 * 60 * 24 * 365));
            setcookie("password", $password, time() + (60 * 60 * 24 * 365));
        } else {
            setcookie("email", "", -1);
            setcookie("password", "", -1);
        }
    } else {

        echo "Invalid Email or Password";
    }
}
