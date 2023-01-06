<?php

session_start();
require "connection.php";

if (isset($_SESSION["user"])) {

    $product_id = $_POST["id"];

    $title = $_POST["t"];
    $qty = $_POST["qty"];
    $price = $_POST["p"];
    $warranty = $_POST["warranty"];
    $discount = $_POST["discount"];
    $dwc = $_POST["dwc"];
    $doc = $_POST["doc"];
    $description = $_POST["desc"];

    if (empty($title)) {
        echo "Please enter the title of your product";
    } else if (strlen($title) > 100) {
        echo "Your title should have 100 or less character length.";
    } else if (empty($qty)) {
        echo "Please add a quantity";
    } else if ($qty == "0" | $qty == "e" | $qty < 0) {
        echo "Please enter a valid quantity";
    } else if ($warranty < 0) {
        echo "Please enter valid warranty of your product";
    } else if (empty($price)) {
        echo "Please enter the unit price of your product";
    } else if ($discount < 0 || $discount > 100) {
        echo "Please enter valid discount of your product";
    } else if (!is_numeric($price)) {
        echo "please enter a valid price";
    } else if (empty($dwc)) {
        echo "Please enter the delivery price in Colombo";
    } else if (!is_numeric($dwc)) {
        echo "please enter a valid delivery price";
    } else if (empty($doc)) {
        echo "Please enter the delivery price out of Colombo";
    } else if (!is_numeric($doc)) {
        echo "please enter a valid delivery price";
    } else if (empty($description)) {
        echo "Please enter a description";
    } else {
        Database::iud("UPDATE `product` SET `title`='" . $title . "',`qty`='" . $qty . "',`price`='" . $price . "',
    `delivery_fee_colombo`='" . $dwc . "',`delivery_fee_other`='" . $doc . "', `description`= '" . $description . "'
    , `warranty`='" . $warranty . "',`discount`='" . $discount . "' WHERE `id`= '" . $product_id . "' ");

        echo "Product Updated Successfully.";

        $allowed_img_extentions = array("image/jpg", "image/jpeg", "image/png", "image/svg+xml");

        if (isset($_FILES["img1"])) {
            $imagefile1 = $_FILES["img1"];

            $file_extention = $imagefile1["type"];

            if (in_array($file_extention, $allowed_image_extentions)) {

                $new_img_extention;

                if ($file_extention == "image/jpg") {
                    $new_img_extention = ".jpg";
                } else if ($file_extention == "image/jpeg") {
                    $new_img_extention = ".jpeg";
                } else if ($file_extention == "image/png") {
                    $new_img_extention = ".png";
                } else if ($file_extention == "image/svg+xml") {
                    $new_img_extention = ".svg";
                }

                $file_name = "resources//product_img//" . uniqid() . $new_img_extention;
                move_uploaded_file($imagefile1["tmp_name"], $file_name);

                Database::iud("UPDATE `images` SET `code`='" . $file_name . "' WHERE 
            `product_id`='" . $product_id . "'");

                // echo "Produt image saved successfully";
            } else {
                echo "Invalid image type.";
            }
        } else {
            echo "Please add an image1.";
        }

        if (isset($_FILES["img2"])) {
            $imagefile2 = $_FILES["img2"];

            $file_extention = $imagefile2["type"];

            if (in_array($file_extention, $allowed_image_extentions)) {

                $new_img_extention;

                if ($file_extention == "image/jpg") {
                    $new_img_extention = ".jpg";
                } else if ($file_extention == "image/jpeg") {
                    $new_img_extention = ".jpeg";
                } else if ($file_extention == "image/png") {
                    $new_img_extention = ".png";
                } else if ($file_extention == "image/svg+xml") {
                    $new_img_extention = ".svg";
                }

                $file_name = "resources//product_img//" . uniqid() . $new_img_extention;
                move_uploaded_file($imagefile2["tmp_name"], $file_name);

                Database::iud("UPDATE `images` SET `code`='" . $file_name . "' WHERE 
            `product_id`='" . $product_id . "'");

                // echo "Produt image saved successfully";
            } else {
                echo "Invalid image type.";
            }
        } else {
            echo "Please add an image2.";
        }
        if (isset($_FILES["img3"])) {
            $imagefile3 = $_FILES["img3"];

            $file_extention = $imagefile3["type"];

            if (in_array($file_extention, $allowed_image_extentions)) {

                $new_img_extention;

                if ($file_extention == "image/jpg") {
                    $new_img_extention = ".jpg";
                } else if ($file_extention == "image/jpeg") {
                    $new_img_extention = ".jpeg";
                } else if ($file_extention == "image/png") {
                    $new_img_extention = ".png";
                } else if ($file_extention == "image/svg+xml") {
                    $new_img_extention = ".svg";
                }

                Database::iud("UPDATE `images` SET `code`='" . $file_name . "' WHERE 
            `product_id`='" . $product_id . "'");

                Database::iud("INSERT INTO `images` (`code`,`product_id`) VALUES 
                ('" . $file_name . "','" . $product_id . "')");

                // echo "Produt image saved successfully";
            } else {
                echo "Invalid image type.";
            }
        } else {
            echo "Please add an image3.";
        }
    }
}
