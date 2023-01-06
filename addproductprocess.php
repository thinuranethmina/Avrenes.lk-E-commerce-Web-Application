<?php

session_start();

require "connection.php";

if (isset($_SESSION["user"]) && $_SESSION["user"]["user_type_id"] == '1') {

    $seller_email = $_SESSION["user"]["email"];

    $category = $_POST["c"];
    $brand = $_POST["b"];
    $model = $_POST["m"];
    $title = $_POST["t"];
    $condition = $_POST["co"];
    $color = $_POST["col"];
    $qty = $_POST["qty"];
    $price = $_POST["p"];
    $warranty = $_POST["warranty"];
    $discount = $_POST["discount"];
    $dwc = $_POST["dwc"];
    $doc = $_POST["doc"];
    $description = $_POST["desc"];

    // echo var_dump((int)$price);

    $d = new DateTime();
    $tz = new DateTimeZone("Asia/Colombo");
    $d->setTimezone($tz);
    $date = $d->format("Y-m-d H:i:s");

    $status = 1;

    if ($category == "0") {
        echo "Please select the Category";
    } else if ($brand == "0") {
        echo "Please select the Brand";
    } else if ($model == "0") {
        echo "Please select the Model";
    } else if (empty($title)) {
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

        $mhb_rs = Database::search("SELECT * FROM `model_has_brand` WHERE 
        `model_id`='" . $model . "' && `brand_id`='" . $brand . "'");

        $model_has_brand_id;

        if ($mhb_rs->num_rows == 1) {

            $mhb_data = $mhb_rs->fetch_assoc();
            $model_has_brand_id = $mhb_data["id"];
        } else {

            Database::iud("INSERT INTO `model_has_brand`(`model_id`,`brand_id`) VALUES 
            ('" . $model . "','" . $brand . "')");
            $model_has_brand_id = Database::$connection->insert_id;
        }

        Database::iud("INSERT INTO `product`(`price`,`qty`,`description`,`title`,
        `datetime_added`,`delivery_fee_colombo`,`delivery_fee_other`,`category_id`,
        `model_has_brand_id`,`color_id`,`status_id`,`condition_id`,`user_email`,`discount`,`warranty`) VALUES 
        ('" . $price . "','" . $qty . "','" . $description . "','" . $title . "','" . $date . "',
        '" . $dwc . "','" . $doc . "','" . $category . "','" . $model_has_brand_id . "','" . $color . "',
        '" . $status . "','" . $condition . "','" . $seller_email . "','" . $discount . "','" . $warranty . "')");

        echo "Product added successfully";

        $product_id = Database::$connection->insert_id;

        $allowed_image_extentions = array("image/jpg", "image/jpeg", "image/png", "image/svg+xml");

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

                Database::iud("INSERT INTO `images` (`code`,`product_id`) VALUES 
                ('" . $file_name . "','" . $product_id . "')");

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

                Database::iud("INSERT INTO `images` (`code`,`product_id`) VALUES 
                ('" . $file_name . "','" . $product_id . "')");

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

                $file_name = "resources//product_img//" . uniqid() . $new_img_extention;
                move_uploaded_file($imagefile3["tmp_name"], $file_name);

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
