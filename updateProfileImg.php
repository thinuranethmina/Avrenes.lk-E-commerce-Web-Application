<?php

session_set_cookie_params(60 * 60 * 24 * 30);
session_start();
require "connection.php";

if (isset($_SESSION["user"])) {

    if (isset($_FILES["profileImg"])) {
        $image = $_FILES["profileImg"];

        $allowed_image_extention = array("image/jpg", "image/jpeg", "image/png", "image/svg+xml");
        $fileex = $image["type"];

        if (!in_array($fileex, $allowed_image_extention)) {
            echo "Please select a valid image.";
        } else {
            $newImageExtention;
            if ($fileex == "image/jpg") {
                $newImageExtention = ".jpg";
            } else if ($fileex == "image/jpeg") {
                $newImageExtention = ".jpg";
            } else if ($fileex == "image/png") {
                $newImageExtention = ".png";
            } else if ($fileex == "image/svg+xml") {
                $newImageExtention = ".svg";
            }

            $file_name = "resources//profile_img//" . uniqid($prefix = "productImg_") . $newImageExtention;


            $resultset1 = Database::search("SELECT * FROM `user` WHERE `email` = '" . $_SESSION["user"]["email"] . "';");
            $row1 = $resultset1->num_rows;
            if ($row1 == 1) {
                $dataset1 = $resultset1->fetch_assoc();
                if (file_exists($dataset1["profile_img"])) {
                    unlink($dataset1["profile_img"]);
                }
                $_SESSION["user"]["profile_img"] = $file_name;
                move_uploaded_file($image["tmp_name"], $file_name);
                Database::iud("UPDATE `user` set `profile_img`='" . $file_name . "' WHERE `email` = '" . $_SESSION["user"]["email"] . "';");
                echo "success";
            } else {
                echo "Error";
            }
        }
    } else {
        echo "Profile picture has'nt been set.";
    }
} else {
    echo "Error";
}
