<?php

session_start();

require "connection.php";

$fname = $_POST["fname"];
$lname = $_POST["lname"];
$email = $_POST["email"];
$code = $_POST["mypic"];


$resultset1 = Database::search("SELECT * FROM `user` WHERE `email`='" . $email . "';");
$rows1 = $resultset1->num_rows;

if ($rows1 == 1) {
    $resultset2 = Database::search("SELECT * FROM `user` WHERE `email`='" . $email . "' AND`login_with_id`='2' ;");
    $rows2 = $resultset2->num_rows;
    if ($rows2 == 1) {
        echo "success";
        $d = $resultset2->fetch_assoc();
        $_SESSION["user"] = $d;
    } else {
        echo "This email registered with another sign in option.";
    }
} else {

    $d = new DateTime();
    $tz = new DateTimeZone("Asia/Colombo");
    $d->setTimezone($tz);
    $date = $d->format("Y-m-d H:i:s");

    Database::iud("INSERT INTO `user`(`email`,`fname`,`lname`,`register_date`,`login_with_id`) VALUES ('" . $email . "','" . $fname . "','" . $lname . "','" . $date . "','2');");
    Database::iud("INSERT INTO `user_has_profile_img`(`code`,`user_email`) VALUES ('" . $code . "','" . $email . "');");

    $d = array();
    $d["fname"] = $fname;
    $d["lname"] = $lname;
    $d["email"] = $email;
    $d["register_date"] = $date;
    $d["login_with_id"] = '2';

    $_SESSION["user"] = $d;

    echo "success";
}
