<?php

session_set_cookie_params(60 * 60 * 24 * 30);
session_start();
require "connection.php";

if (isset($_SESSION["user"])) {
?>

    <!DOCTYPE html>

    <html>

    <head>
        <title>avrenes | Wishlist</title>

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

                $uemail = $_SESSION["user"]["email"];

                $total = 0;
                $subTotal = 0;
                $shipping = 0;

                ?>

                <div class="col-12 pt-2">

                    <?php

                    $cart_rs = Database::search("SELECT * FROM `wishlist` WHERE `user_email`='" . $uemail . "'");
                    $cart_num = $cart_rs->num_rows;

                    if ($cart_num == 0) {

                    ?>

                        <!-- empty -->
                        <div class="row">
                            <div class="col-12" style="height: 350px; margin-top: 200px;">
                                <div class="row">
                                    <div class="col-12 emptycart"></div>
                                    <div class="col-12 text-center mb-2">
                                        <label class="form-label fs-1">You have no items in your wishlist.</label>
                                    </div>
                                    <div class="offset-0 offset-lg-4 col-12 col-lg-4 d-grid mb-4">
                                        <a href="home.php" class="btn btn-primary fs-3">Start Shopping</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- empty -->

                    <?php

                    } else {

                    ?>

                        <div class="row">
                            <div class="col-12 p-3">

                                <?php
                                for ($x = 0; $x < $cart_num; $x++) {
                                    $wishlist_data = $cart_rs->fetch_assoc();

                                    $product_rs = Database::search("SELECT product.id,product.warranty,product.discount,product.category_id,product.model_has_brand_id,product.title,
                                    color.name AS `color`,product.price,product.qty,product.description,condition.name AS pcondition,
                                    product.status_id,product.user_email,product.datetime_added,product.delivery_fee_colombo,
                                    product.delivery_fee_other,model.name AS `mname`,brand.name AS `bname` 
                                    FROM product INNER JOIN model_has_brand ON model_has_brand.id = product.model_has_brand_id 
                                    INNER JOIN brand ON brand.id=model_has_brand.brand_id 
                                    INNER JOIN model ON model_has_brand.model_id = model.id 
                                    INNER JOIN color ON color.id = product.color_id 
                                    INNER JOIN `condition` ON `condition`.id = product.condition_id 
                                    WHERE product.id = '" . $wishlist_data["product_id"] . "'  AND `status_id` = '1' ; ");

                                    $product_data = $product_rs->fetch_assoc();

                                    $total = $total + ($product_data["price"] * $wishlist_data["qty"]);

                                    $address_rs = Database::search("SELECT * FROM `user_has_address` WHERE `email`='" . $uemail . "'");
                                    $address_data = $address_rs->fetch_assoc();
                                    $city_id = $address_data["city_id"];

                                    $district_rs = Database::search("SELECT * FROM `city` WHERE `id`='" . $city_id . "'");
                                    $district_data = $district_rs->fetch_assoc();
                                    $district_id = $district_data["district_id"];

                                    $ship = 0;

                                    if ($district_id == 5) {
                                        $ship = $product_data["delivery_fee_colombo"];
                                        $shipping = $shipping + $product_data["delivery_fee_colombo"];
                                    } else {
                                        $ship = $product_data["delivery_fee_other"];
                                        $shipping = $shipping + $product_data["delivery_fee_other"];
                                    }

                                    $user_rs = Database::search("SELECT * FROM `user` WHERE   `email`='" . $product_data["user_email"] . "'");
                                    $user_data = $user_rs->fetch_assoc();

                                ?>

                                    <!-- have products -->

                                    <div class="row">
                                        <div class="col-12 p-2 px-4">
                                            <div class="row">

                                                <div class="card-content col-12">
                                                    <div class="row g-0">
                                                        <div class="col-6 offset-3 offset-lg-0 col-lg-5 col-xl-3 p-3 text-center">

                                                            <?php

                                                            $img_rs = Database::search("SELECT * FROM `images` WHERE  `product_id`='" . $product_data["id"] . "'");
                                                            $img_data = $img_rs->fetch_assoc();

                                                            ?>

                                                            <span class="d-inline-block" tabindex="0" data-bs-toggle="popover" data-bs-trigger="hover focus" data-bs-content="<?php echo $product_data["description"]; ?>" title="Product Description">
                                                                <img src="<?php echo $img_data["code"]; ?>" class="img-fluid rounded-start" style="max-width: 200px;">
                                                            </span>

                                                        </div>
                                                        <div class="col-12 col-lg-7 col-xl-6">
                                                            <div class="card-body text-center text-lg-start">

                                                                <h3 class="card-title"><?php echo $product_data["title"]; ?></h3>

                                                                <span class="fw-bold text-black-50">Colour : <?= $product_data["color"] ?></span> &nbsp; |

                                                                &nbsp; <span class="fw-bold text-black-50">Condition : <?= $product_data["pcondition"] ?></span>
                                                                <br>
                                                                <span class="fw-bold text-black-50 fs-5">Price :</span>&nbsp;
                                                                <?php
                                                                $afterDiscountPrice = $product_data["price"];
                                                                $discount = $product_data["discount"];


                                                                if ($discount == 0) {
                                                                    $trueprice = number_format($product_data["price"], 2);
                                                                ?>
                                                                    <label class="fw-bold fs-4 mt-1">Rs. <?php echo $trueprice; ?></label>
                                                                <?php
                                                                } else {
                                                                    $trueprice = number_format($afterDiscountPrice, 2);
                                                                    $beforeDiscountPrice = number_format(($afterDiscountPrice * 100) / (100 - $discount)) . ".00";
                                                                ?>
                                                                    <label class="fw-bold fs-4 mt-1">Rs. <?php echo $trueprice; ?></label>
                                                                    <label class="fw-bold fs-6 mt-1 text-danger"><del>Rs. <?php echo $beforeDiscountPrice; ?></del>&nbsp;-<?php echo $discount; ?>%</label>
                                                                <?php
                                                                }
                                                                ?>
                                                                <br>

                                                                <?php

                                                                if ($product_data['qty'] < 1) {
                                                                ?>
                                                                    <span class="fw-bold text-danger fs-5">Out Of Stock</span>
                                                                <?php
                                                                } else {
                                                                ?>
                                                                    <span class="fw-bold text-black-50 fs-5">Quantity :</span>&nbsp;

                                                                    <button class="btn  btn-light border border-1 rounded rounded-3" onclick="qty_dec(<?= $pd['qty'] ?>);">-</button>
                                                                    <input id="qtyinput" type="text" class="border-0 fs-6 fw-bold text-center" readonly style="outline: none; width: 50px;" pattern="[0-9]" value="<?= $wishlist_data["qty"] ?>" />
                                                                    <button class="btn btn-light border border-1 rounded rounded-3" onclick="qty_inc(<?= $pd['qty'] ?>);">+</button>

                                                                <?php
                                                                }

                                                                ?>

                                                                <br><br>
                                                                <span class="fw-bold text-black-50 fs-5">Delivery Fee :</span>&nbsp;
                                                                <span class="fw-bold text-black fs-5">Rs.<?= $ship ?>.00</span>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-xl-3">
                                                            <div class="card-body d-grid">
                                                                <button onclick="loadIndex();" class="buyNow mb-2" style="height: 40px;"><img src="https://img.icons8.com/external-itim2101-fill-itim2101/64/000000/external-pay-currency-and-money-itim2101-fill-itim2101.png" style="height: 20px;" /> Buy Now</button>
                                                                <button class="remove mb-2" onclick="removeWishlist(<?php echo $wishlist_data['product_id']; ?>);"><img src="https://img.icons8.com/ios/512/delete-forever.png" style="height: 20px;" /> Remove</button>
                                                                <button class="addToCart mb-2" onclick="removeWishlistAddCart(<?php echo $wishlist_data['product_id']; ?>);"><img src="https://img.icons8.com/ios-glyphs/30/000000/buy--v2.png" style="height: 20px;" /> Add to cart</button>

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

} else {
    echo "Please Sign In first";
}

?>