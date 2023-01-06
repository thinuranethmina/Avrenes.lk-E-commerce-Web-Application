<?php

session_start();

require "connection.php";

if (isset($_GET["id"])) {

    $id = $_GET["id"];

    $admin_rs = Database::search("SELECT * FROM `user` WHERE `verification_code` = '" . $id . "' AND `user_type_id` ='1' ;");
    $admin_num = $admin_rs->num_rows;

    if ($admin_num == 1) {

        $admin_data = $admin_rs->fetch_assoc();
        $_SESSION["user"] = $admin_data;

        echo "success";
    } else {
        echo "Verification code is not valid.";
    }
} else {
    echo "Please enter your verification code.";
}
