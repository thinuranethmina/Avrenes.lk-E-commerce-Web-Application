<?php

session_set_cookie_params(60 * 60 * 24 * 30);
session_start();
require "connection.php";

$uemail = $_SESSION["user"]["email"];
$address = Database::search("SELECT `user_has_address`.`line1`,`user_has_address`.`line2`,`city`.`name_en` FROM `user_has_address` INNER JOIN `city` ON `city`.`id` =`user_has_address`.`city_id`  WHERE `email`='" . $uemail . "'");
$address_row = $address->num_rows;


if (isset($_SESSION["user"])) {
    if ($address_row == 0) {
?>
        <script>
            alert("Please enter your address");
            window.location = "userProfile.php";
        </script>
    <?php
    } else {
        $useraddress = $address->fetch_assoc();

    ?>

        <!DOCTYPE html>

        <html>

        <head>
            <title>avrenes | Invoice</title>

            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1">

            <link rel="icon" href="resources/icon.png" />
            <link rel="stylesheet" href="bootstrap.css" />
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
            <link rel="stylesheet" href="style.css" />
        </head>

        <body>

            <div class="container-fluid">
                <div class="row">

                    <?php
                    require "header.php";


                    $total = 0;
                    $subTotal = 0;
                    $shipping = 0;
                    $items = 0;

                    ?>

                    <div class="col-12 p-3 text-end">
                        <button class="btn btn-danger" onclick="printInvoice();"> Download Invoice </button>
                    </div>

                    <hr />

                    <div class="col-12 pt-2" id="Invoicepage">

                        <?php

                        $cart_rs = Database::search("SELECT * FROM `cart` WHERE `user_email`='" . $uemail . "'AND `qty` != 0 ");
                        $cart_num = $cart_rs->num_rows;

                        if ($cart_num == 0) {
                        } else {

                            $d = new DateTime();
                            $tz = new DateTimeZone("Asia/Colombo");
                            $d->setTimezone($tz);
                            $date_time = $d->format("Y-m-d H:i:s");
                        ?>

                            <div class="row mb-3">
                                <div class="col-12 col-sm-6 text-start p-3 pb-0">
                                    <img src="resources/logo.png" class="ms-3 mb-2" alt="AVRENES.LK" height="40px">
                                    <div class="ms-4">
                                        <p><i class="bi bi-house-door-fill"></i> Maradhana,Colombo 10,Sri Lanka.</p>
                                        <p><i class="bi bi-envelope-fill"></i> avrence@gmail.com</p>
                                        <p><i class="bi bi-telephone-fill"></i> +94 112 782654</p>
                                        <p><i class="bi bi-printer-fill"></i> +94 112 782654</p>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6 text-end pt-md-2">
                                    <div class="mt-2">To</div>
                                    <div class="mt-2"><?php echo $_SESSION["user"]["fname"] . " " . $_SESSION["user"]["lname"] ?></div>
                                    <div class="mt-2"><?php echo $_SESSION["user"]["mobile"]  ?></div>
                                    <div class="mt-2"><?php echo $_SESSION["user"]["email"]  ?></div>
                                    <div class="mt-2"><?php echo $useraddress["line1"] . " " . $useraddress["line2"] ?></div>
                                    <div class="mt-2"><?php echo $useraddress["name_en"]  ?></div>
                                    <div class="mt-2"><?php echo $date_time; ?></div>
                                </div>
                            </div>

                            <div class="row">


                                <div class="col-12">

                                    <?php
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

                                        if ($district_id == 5) {
                                            $ship = $product_data["delivery_fee_colombo"];
                                        } else {
                                            $ship = $product_data["delivery_fee_other"];
                                        }

                                        if ($product_data["qty"] < 1) {
                                        } elseif ($product_data["qty"] < $cart_data["qty"]) {
                                            $items = $items + 1;

                                            $total = $total + ($product_data["price"] * $product_data["qty"]);


                                            if ($district_id == 5) {
                                                $shipping = $shipping + $product_data["delivery_fee_colombo"];
                                            } else {
                                                $shipping = $shipping + $product_data["delivery_fee_other"];
                                            }
                                        } else {
                                            $items = $items + 1;

                                            $total = $total + ($product_data["price"] * $cart_data["qty"]);


                                            if ($district_id == 5) {
                                                $shipping = $shipping + $product_data["delivery_fee_colombo"];
                                            } else {
                                                $shipping = $shipping + $product_data["delivery_fee_other"];
                                            }
                                        }


                                        // $user_rs = Database::search("SELECT * FROM `user` WHERE   `email`='" . $product_data["user_email"] . "'");
                                        // $user_data = $user_rs->fetch_assoc();



                                    ?>


                                        <!-- have products -->

                                        <div class="row">
                                            <div class="col-12 p-4 py-1">
                                                <div class="row">

                                                    <div class="card-content col-12" style="<?php
                                                                                            if ($product_data["qty"] < 1) {
                                                                                                echo "opacity: 0.4;";
                                                                                            }
                                                                                            ?>">
                                                        <div class="row g-0">
                                                            <div class="col-12">
                                                                <div class="card-body ">

                                                                    <div class="row">
                                                                        <div class="col-12 col-md-4">
                                                                            <h3 class="card-title"><?php echo $product_data["title"]; ?></h3>

                                                                            <span class="fw-bold text-black-50">Colour : <?= $product_data["color"] ?></span> &nbsp; |

                                                                            &nbsp; <span class="fw-bold text-black-50">Condition : <?= $product_data["pcondition"] ?></span>
                                                                        </div>
                                                                        <div class="col-12 col-md-2">
                                                                            <?php
                                                                            if ($product_data["qty"] < 1) {
                                                                            } elseif ($product_data["qty"] < $cart_data["qty"]) {
                                                                            ?>

                                                                                <span class="fw-bold text-black-50 fs-5">Quantity :</span>&nbsp;

                                                                                <input id="qtyinput" type="text" class="border-0 fs-6 fw-bold text-center" readonly style="outline: none; width: 50px;" pattern="[0-9]" value="<?= $product_data["qty"] ?>" />

                                                                            <?php
                                                                            } else {
                                                                            ?>

                                                                                <span class="fw-bold text-black-50 fs-5">Quantity :</span>&nbsp;

                                                                                <input id="qtyinput" type="text" class="border-0 fs-6 fw-bold text-center" readonly style="outline: none; width: 50px;" pattern="[0-9]" value="<?= $cart_data["qty"] ?>" />

                                                                            <?php
                                                                            }
                                                                            ?>
                                                                        </div>
                                                                        <?php
                                                                        $afterDiscountPrice = $product_data["price"];
                                                                        $discount = $product_data["discount"];


                                                                        if ($discount == 0) {
                                                                            $trueprice = number_format($product_data["price"], 2);
                                                                        ?>
                                                                            <div class="col-12 col-md-6 text-end">
                                                                                <span class="fw-bold text-black-50 fs-5">Price :</span>&nbsp;
                                                                                <label class="fw-bold fs-4 mt-1">Rs. <?php echo $trueprice; ?></label>
                                                                            </div>
                                                                        <?php
                                                                        } else {
                                                                            $trueprice = number_format($afterDiscountPrice, 2);
                                                                            $beforeDiscountPrice = number_format(($afterDiscountPrice * 100) / (100 - $discount)) . ".00";
                                                                        ?>

                                                                            <div class="col-12 col-md-2 text-end">
                                                                                <label class="fw-bold fs-6 mt-1 text-danger"><del>Rs. <?php echo $beforeDiscountPrice; ?></del>&nbsp;-<?php echo $discount; ?>%</label>
                                                                            </div>

                                                                            <div class="col-12 col-md-4 text-end">
                                                                                <span class="fw-bold text-black-50 fs-5">Price :</span>&nbsp;
                                                                                <label class="fw-bold fs-4 mt-1">Rs. <?php echo $trueprice; ?></label>
                                                                            </div>
                                                                        <?php
                                                                        }
                                                                        ?>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-12 text-end">
                                                                            <span class="fw-bold text-black-50 fs-5">Delivery Fee :</span>&nbsp;
                                                                            <span class="fw-bold text-black fs-5">Rs.<?= $ship ?>.00</span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>

                                        <!-- have products -->

                                    <?php
                                    }
                                    ?>

                                </div>
                                <div class="col-12">
                                    <div class="row p-3">
                                        <div class="col-12 p-3 card-content">
                                            <div class="row">
                                                <div class="col-12">
                                                    <label class="form-label fs-4 fw-bold">Order Summary</label>
                                                </div>

                                                <div class="col-12">
                                                    <hr />
                                                </div>

                                                <div class="col-6 mb-3">
                                                    <span class="fs-6 fw-bold">items (<?php echo $items; ?>)</span>
                                                </div>

                                                <div class="col-6 text-end mb-3">
                                                    <span class="fs-6 fw-bold">Rs. <?php echo number_format($total, 2); ?></span>
                                                </div>

                                                <div class="col-6">
                                                    <span class="fs-6 fw-bold">Shipping</span>
                                                </div>

                                                <div class="col-6 text-end">
                                                    <span class="fs-6 fw-bold">Rs. <?php echo number_format($shipping, 2); ?></span>
                                                </div>

                                                <div class="col-12 mt-3">
                                                    <hr />
                                                </div>

                                                <div class="col-4 mt-2">
                                                    <span class="fs-5 fw-bold">Total</span>
                                                </div>

                                                <div class="col-8 mt-2 text-end">
                                                    <span class="fs-5 fw-bold">Rs. <?php echo number_format($total + $shipping, 2); ?></span>
                                                </div>

                                            </div>
                                        </div>
                                    </div>


                                </div>
                            </div>
                            <div class="row p-5">
                                <div class="col-12 text-center">
                                    <h1 class="text-primary">Thank You!</h1>
                                </div>
                                <div class="col-12 mt-3 mb-3 border-0 border-start border-5 border-primary rounded" style="background-color: #e7f2ff;">
                                    <div class="row">
                                        <div class="col-12 mt-3 mb-3">
                                            <label class="form-label fw-bold fs-5">NOTICE :</label>
                                            <label class="form-label fs-6">Purchased items can return befor 7 days of Delivery.</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <hr class="border border-1 border-primary" />
                                </div>

                                <div class="col-12 text-center mb-3">
                                    <label class="form-label fs-5 text-black-50 fw-bold">
                                        Invoice was created on a computer and is valid without the Signature and Seal.
                                    </label>
                                </div>
                            </div>

                        <?php
                        }

                        ?>



                    </div>
                    <?php require "footer.php"; ?>
                </div>


            </div>


            <script src="script.js"></script>

            <script>
                var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
                var popoverList = popoverTriggerList.map(function(popoverTriggerEl) {
                    return new bootstrap.Popover(popoverTriggerEl)
                })
            </script>
            <script src="bootstrap.bundle.js"></script>
            <script src="bootstrap.js"></script>
        </body>

        </html>

<?php

    }
} else {
    echo "Please Sign In first";
}

?>