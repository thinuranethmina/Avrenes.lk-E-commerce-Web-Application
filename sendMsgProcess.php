<?php

session_set_cookie_params(60 * 60 * 24 * 30);
session_start();
require "connection.php";

$sender = $_SESSION["user"]["email"];
$receiver = $_POST["receiver"];

$msg = $_POST["msg"];

$d = new DateTime();
$tz = new DateTimeZone("Asia/Colombo");
$d->setTimezone($tz);
$date = $d->format("Y-m-d H:i:s");

Database::iud("INSERT INTO `message` (`from`,`to`,`content`,`date_time`,`status`) 
VALUES ('" . $sender . "','" . $receiver . "','" . $msg . "','" . $date . "','0')");

echo ("success");
