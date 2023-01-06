<?php

session_set_cookie_params(60 * 60 * 24 * 30);
session_start();
require "connection.php";

$uemail = $_SESSION["user"]["email"];
$address = Database::search("SELECT * FROM `user_has_address` WHERE `email`='" . $uemail . "'");
$address_row = $address->num_rows;


if (isset($_SESSION["user"])) {
    $d = new DateTime();
    $tz = new DateTimeZone("Asia/Colombo");
    $d->setTimezone($tz);
    $date = $d->format("Y-m-d H:i:s");
    $order_id = uniqid();

    $cart_rs = Database::search("SELECT * FROM `cart` WHERE `user_email`='" . $uemail . "'AND `qty` != 0 ");
    $cart_num = $cart_rs->num_rows;
    for ($x = 0; $x < $cart_num; $x++) {
        $cart_data = $cart_rs->fetch_assoc();

        $product_rs = Database::search("SELECT product.id,product.warranty,product.discount,product.category_id,product.model_has_brand_id,product.title,
                                    color.name AS `color`,product.price,product.qty,product.description,condition.name AS pcondition,
                                    product.status_id,product.user_email,product.datetime_added,product.delivery_fee_colombo,
                                    product.delivery_fee_other,model.name AS `mname`,brand.name AS `bname` 
                                    FROM product INNER JOIN model_has_brand ON model_has_brand.id = product.model_has_brand_id 
                                    INNER JOIN brand ON brand.id=model_has_brand.brand_id 
                                    INNER JOIN model ON model_has_brand.model_id = model.id 
                                    INNER JOIN color ON color.id = product.color_id 
                                    INNER JOIN `condition` ON `condition`.id = product.condition_id 
                                    WHERE product.id = '" . $cart_data["product_id"] . "' AND `status_id` = '1'  ; ");

        $product_data = $product_rs->fetch_assoc();

        $address_rs = Database::search("SELECT * FROM `user_has_address` WHERE `email`='" . $uemail . "'");
        $address_row = $address_rs->num_rows;

        $address_data = $address_rs->fetch_assoc();
        $city_id = $address_data["city_id"];

        $district_rs = Database::search("SELECT * FROM `city` WHERE `id`='" . $city_id . "'");
        $district_data = $district_rs->fetch_assoc();
        $district_id = $district_data["district_id"];

        $ship = 0;
        $total = 0;

        if ($district_id == 5) {
            $ship = $product_data["delivery_fee_colombo"];
        } else {
            $ship = $product_data["delivery_fee_other"];
        }

        if ($product_data["qty"] < 1) {
        } elseif ($product_data["qty"] < $cart_data["qty"]) {

            $total = $total + ($product_data["price"] * $product_data["qty"]);
        } else {
            $total = $total + ($product_data["price"] * $cart_data["qty"]);
        }

        Database::iud("INSERT INTO `invoice` (`order_id`,`date_time`,`qty`,`product_id`,`user_email`,`delivery_charges`,`price`) VALUES
    ('" . $order_id . "','" . $date . "','" . $product_data["qty"] . "','" . $product_data['id'] . "','" . $_SESSION["user"]["email"] . "','" . $ship . "','" . $total . "')");

        echo "success";
    }
} else {
    echo "Please Sign In first";
}
