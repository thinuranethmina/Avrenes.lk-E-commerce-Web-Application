<?php
require "connection.php";

$fname = $_POST["fname"];
$lname = $_POST["lname"];
$email = $_POST["email"];
$password = $_POST["password"];
$mobile = $_POST["mobile"];
$gender = $_POST["gender"];

if (empty($fname)) {
    echo "Please enter your First Name.";
} else if (strlen($fname) > 50) {
    echo "First Name must be less than 50 characters.";
} else if (empty($lname)) {
    echo "Please enter your Last Name.";
} else if (strlen($lname) > 50) {
    echo "Last Name must be less than 50 characters.";
} else if (empty($email)) {
    echo "Please enter your Email Address.";
} else if (strlen($email) >= 50) {
    echo "Email Address must be less than 50 characters.";
} else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "Invalid Email address";
} else if (empty($password)) {
    echo "Please enter your Password.";
} else if (strlen($password) < 7 || strlen($password) > 50) {
    echo "Password Length Should be between 7 to 50.";
} else if (!preg_match("/(?=.*\d)(?=.*[a-z])(?=.*[!|@|#|$|%|^|&|*)(?=.*[A-Z])(?=.*[a-zA-Z]).{8,}/", $password)) {
    echo "Invalid password";
} else if (empty($mobile)) {
    echo "Please enter your Mobile.";
} else if (strlen($mobile) != 10) {
    echo "Mobile number shouls contain 10 characters.";
} else if (!preg_match("/[0|0094|94|+94][7][1|2|4|5|6|7|8][0-9]{7}$/", $mobile)) {
    echo "Invalid Mobile Number.";
} else {
    $r = Database::search("SELECT * FROM `user` WHERE `email`='" . $email . "' OR `mobile`='" . $mobile . "';");
    $n = $r->num_rows;
    if ($n > 0) {
        echo "User with the same Email or Phone Number already exist.";
    } else {
        $d = new DateTime();
        $tz = new DateTimeZone("Asia/Colombo");
        $d->setTimezone($tz);
        $date = $d->format("Y-m-d H:i:s");

        Database::iud("INSERT INTO `user`(`fname`,`lname`,`email`,`password`,`mobile`,`gender`,`login_with_id`,`register_date`) VALUES ('" . $fname . "','" . $lname . "','" . $email . "','" . $password . "','" . $mobile . "','" . $gender . "','1','" . $date . "');");

        echo "success";
    }
}
