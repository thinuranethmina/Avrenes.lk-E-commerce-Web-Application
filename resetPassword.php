<?php

session_set_cookie_params(60 * 60 * 24 * 30);
session_start();
require "connection.php";

if (isset($_SESSION["user"])) {
    $e = $_POST["e"];
    $np = $_POST["np"];
    $rnp = $_POST["rnp"];
    $vc = $_POST["vc"];

    if (empty($e)) {
        echo "Missing Email Address";
    } else if (strlen($np) < 7 || strlen($np) > 50) {
        echo "Please enter your new password length  between 7 to 50.";
    } else if (!preg_match("/(?=.*\d)(?=.*[a-z])(?=.*[!|@|#|$|%|^|&|*)(?=.*[A-Z])(?=.*[a-zA-Z]).{8,}/", $np)) {
        echo "Invalid password";
    } else if (empty($rnp)) {
        echo "Please re-enter your new password.";
    } else if ($np != $rnp) {
        echo "Password & Re-type password does not match.";
    } else if (empty($vc)) {
        echo "Please enter your verification code.";
    } else {

        $rs = Database::search("SELECT * FROM `user` WHERE `email`= '" . $e . "' AND `verification_code`='" . $vc . "' ");

        if ($rs->num_rows == 1) {

            Database::iud("UPDATE `user` SET `password`='" . $np . "' WHERE `email`='" . $e . "' ;");
            echo "Success";

            session_start();
            if (isset($_SESSION["user"])) {
                $_SESSION["user"]["password"] = $np;
            }
        } else {
            echo "Password reset failed";
        }
    }
} else {
    echo "Please Sign In or Register.";
}
