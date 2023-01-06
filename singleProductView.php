<?php

require "connection.php";
session_set_cookie_params(60 * 60 * 24 * 30);
session_start();

if (isset($_GET["id"])) {
    $pid = $_GET["id"];

    $productrs = Database::search("SELECT product.id,product.warranty,product.discount,product.category_id,product.model_has_brand_id,product.title,
    color.name AS color,product.price,product.qty,product.description,product.condition_id,
    product.status_id,product.user_email,product.datetime_added,product.delivery_fee_colombo,
    product.delivery_fee_other,model.name AS `mname`,brand.name AS `bname` 
    FROM product INNER JOIN model_has_brand ON model_has_brand.id = product.model_has_brand_id 
    INNER JOIN brand ON brand.id=model_has_brand.brand_id 
    INNER JOIN model ON model_has_brand.model_id = model.id 
    INNER JOIN color ON color.id = product.color_id 
    WHERE product.id = '" . $pid . "' AND `status_id` = '1' ; ");

    $pn  = $productrs->num_rows;

    if ($pn == 1) {
        $pd = $productrs->fetch_assoc();

?>

        <!DOCTYPE html>
        <html lang="en">

        <head>

            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title><?php echo $pd["title"]; ?></title>

            <link rel="stylesheet" href="style.css" />
            <link rel="stylesheet" href="bootstrap.css" />
            <link rel="icon" href="resources/icon.png" />

            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" />
            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css" />
            <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" />

            <style>
                .zoomImg .mainImg {
                    transition: transform .5s ease;
                }

                .zoomImg:hover .mainImg {
                    transform: scale(1.1);
                }
            </style>
        </head>

        <body>

            <div class="container-fluid">
                <div class="row">

                    <?php
                    require "header.php";

                    ?>
                    <div class="col-12">
                        <div class="row singleproduct">
                            <div class="bg-white p-3">
                                <div class="row">

                                    <div class="col-12 col-lg-6 px-5">
                                        <div class="row">
                                            <?php

                                            $title = $pd["title"];
                                            $imagers = Database::search("SELECT * FROM images INNER JOIN product ON product.id = images.product_id WHERE product.id= '" . $pid . "' ");

                                            $in = $imagers->num_rows;
                                            $img;

                                            for ($x = 0; $x < $in; $x++) {
                                                $d = $imagers->fetch_assoc();

                                                if ($x == 0) {
                                            ?>
                                                    <div class=" d-none d-lg-flex flex-column justify-content-center align-items-center mb-1  zoomImg" style="z-index: 1;">
                                                        <img src="<?php echo $d["code"]; ?>" height="400px" class="mt-1 mb-1 mainImg " id="mainImg" />
                                                    </div>
                                                    <div class="row mt-2" style="z-index: 2;">
                                                        <div class="col-4 d-none d-lg-block">
                                                            <div class="d-flex flex-column justify-content-center align-items-center border border-3 rounded rounded-3 mb-1 bg-white" id="loadImg<?php echo $x; ?>" onclick="selectImg(<?php echo $x; ?>);" onMouseOver="selectImg(<?php echo $x; ?>);" onmouseout="this.classList.remove('border-secondary');">
                                                                <img src="<?php echo $d["code"]; ?>" height="130px" class="mt-1 mb-1" id="pimg<?php echo $x; ?>" />
                                                            </div>
                                                        </div>
                                                        <div class="d-flex d-lg-none flex-column justify-content-center align-items-center mb-1">
                                                            <img src="<?php echo $d["code"]; ?>" height="450px" class="mt-1 mb-1" id="" />
                                                        </div>
                                                    <?php

                                                } else {
                                                    ?>
                                                        <div class="col-4 d-none d-lg-block">
                                                            <div class="d-flex flex-column justify-content-center align-items-center border border-3 rounded rounded-3 mb-1 bg-white" id="loadImg<?php echo $x; ?>" onclick="selectImg(<?php echo $x; ?>);" onMouseOver="selectImg(<?php echo $x; ?>);" onmouseout="this.classList.remove('border-secondary');">
                                                                <img src="<?php echo $d["code"]; ?>" height="130px" class="mt-1 mb-1" id="pimg<?php echo $x; ?>" />
                                                            </div>
                                                        </div>
                                                        <div class="d-flex d-lg-none flex-column justify-content-center align-items-center mb-1">
                                                            <img src="<?php echo $d["code"]; ?>" height="450px" class="mt-1 mb-1" id="" />
                                                        </div>

                                                <?php
                                                }
                                            }
                                                ?>
                                                    </div>
                                        </div>
                                    </div>


                                    <div class="col-12 col-lg-6">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <label class="form-label fs-4 fw-bold mt-0"><?php echo $pd["title"]; ?></label>
                                                    </div>
                                                </div>

                                                <div class="col-12 mt-1">
                                                    <span class="badge">
                                                        <img src="resources/star2.png" class="mb-2" width="20px" />
                                                        <img src="resources/star2.png" class="mb-2" width="20px" />
                                                        <img src="resources/star2.png" class="mb-2" width="20px" />
                                                        <img src="resources/star2.png" class="mb-2" width="20px" />
                                                        <img src="resources/star2.png" class="mb-2" width="20px" />

                                                        <label class="text-dark fs-6"> 5.0</label>
                                                    </span>
                                                </div>

                                                <div class="col-12 d-inline-block">
                                                    <?php
                                                    $afterDiscountPrice = $pd["price"];
                                                    $discount = $pd["discount"];


                                                    if ($discount == 0) {
                                                        $trueprice = number_format($pd["price"], 2);
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
                                                </div>

                                                <hr class="hr-break-1" />

                                                <div class="col-12">
                                                    <?php
                                                    if ($pd["warranty"] == 0) {
                                                    ?>
                                                        <label class="text-primary fs-6 fw-bold">Warranty: Only 7 day return policy</label><br />
                                                    <?php
                                                    } else {
                                                    ?>
                                                        <label class="text-primary fs-6 fw-bold">Warranty: <?= $pd["warranty"] ?> months warranty</label><br />
                                                        <label class="text-primary fs-6"><b>Return Policy: </b>7 day return policy</label><br />
                                                    <?php
                                                    }
                                                    ?>
                                                    <?php
                                                    if ($pd["qty"] < 1) {
                                                    ?>
                                                        <label class="text-danger fs-6">Out of stock</label>
                                                    <?php
                                                    } else {
                                                    ?>
                                                        <label class="text-primary fs-6"><b>In stock: </b><?php echo $pd["qty"]; ?> items Available</label>

                                                    <?php
                                                    }
                                                    ?>
                                                </div>

                                                <hr class="hr-break-1" />

                                                <div class="col-12">
                                                    <div class="row">
                                                        <div class="col-md-8" style="margin-top: 15px;">
                                                            <div class="row">
                                                                <div class="col-12 mb-3">
                                                                    <span>Qty : </span>
                                                                    <?php
                                                                    if ($pd["qty"] < 1) {
                                                                    ?>
                                                                        <button class="btn  btn-light border border-1 rounded rounded-3" disabled>-</button>
                                                                        <input id="qtyinput" type="text" class="border-0 fs-6 fw-bold text-center" readonly style="outline: none;" pattern="[0-9]" value="0" />
                                                                        <button class="btn btn-light border border-1 rounded rounded-3" disabled>+</button>
                                                                    <?php
                                                                    } else {
                                                                    ?>
                                                                        <button class="btn  btn-light border border-1 rounded rounded-3" onclick="qty_dec(<?= $pd['qty'] ?>);">-</button>
                                                                        <input id="qtyinput" type="text" class="border-0 fs-6 fw-bold text-center" readonly style="outline: none; width: 50px;" pattern="[0-9]" value="1" />
                                                                        <button class="btn btn-light border border-1 rounded rounded-3" onclick="qty_inc(<?= $pd['qty'] ?>);">+</button>
                                                                    <?php
                                                                    }
                                                                    ?>

                                                                </div>

                                                                <div class="col-12 mt-1">
                                                                    <?php
                                                                    if (isset($_SESSION["user"])) {
                                                                    ?>
                                                                        <div class="row">
                                                                            <div class="col-4 col-lg-4 d-grid">
                                                                                <button onclick="addtoCart(<?= $pid ?>);" class="addToCart" style="height: 50px;"><img src="https://img.icons8.com/ios-glyphs/30/000000/buy--v2.png" style="height: 20px;" /> Add to cart</button>
                                                                            </div>
                                                                            <div class="col-4 col-lg-4 d-grid">
                                                                                <button onclick="buyNow(<?= $pid ?>);" class="buyNow" style="height: 50px;"><img src="https://img.icons8.com/external-itim2101-fill-itim2101/64/000000/external-pay-currency-and-money-itim2101-fill-itim2101.png" style="height: 20px;" /> Buy Now</button>
                                                                            </div>
                                                                            <div class="col-4 col-lg-4 my-auto">
                                                                                <?php
                                                                                $resultset10 = Database::search("SELECT `id` FROM `wishlist` WHERE `product_id` = '" . $pid . "';");
                                                                                $row10 = $resultset10->num_rows;

                                                                                $resultset11 = Database::search("SELECT `id` FROM `wishlist` WHERE `product_id` = '" . $pid . "' AND `user_email` = '" . $_SESSION["user"]["email"] . "'  ;");
                                                                                $row11 = $resultset11->num_rows;
                                                                                if ($row11 == 1) {
                                                                                ?>
                                                                                    <img class="btn p-0 mt-0" onclick="removeWishlist(<?= $pid ?>);" src="https://img.icons8.com/color/48/000000/--broken-heart--v1.png" style="height: 30px;" />
                                                                                <?php
                                                                                } else {
                                                                                ?>
                                                                                    <img class="btn p-0 mt-0" onclick="addWishlist(<?= $pid ?>);" src="https://img.icons8.com/color/48/000000/like.png" style="height: 30px;" />
                                                                                <?php
                                                                                }
                                                                                ?>

                                                                                <label>
                                                                                    <?= $row10 ?>
                                                                                </label>

                                                                            </div>
                                                                        </div>
                                                                    <?php
                                                                    } else {
                                                                    ?>
                                                                        <div class="row">
                                                                            <div class="col-4 col-lg-4 d-grid">
                                                                                <button onclick="loadIndex();" class="addToCart" style="height: 50px;"><img src="https://img.icons8.com/ios-glyphs/30/000000/buy--v2.png" style="height: 20px;" /> Add to cart</button>
                                                                            </div>
                                                                            <div class="col-4 col-lg-4 d-grid">
                                                                                <button onclick="loadIndex();" class="buyNow" style="height: 50px;"><img src="https://img.icons8.com/external-itim2101-fill-itim2101/64/000000/external-pay-currency-and-money-itim2101-fill-itim2101.png" style="height: 20px;" /> Buy Now</button>
                                                                            </div>
                                                                            <div class="col-4 col-lg-4 my-auto">
                                                                                <?php
                                                                                $resultset10 = Database::search("SELECT `id` FROM `wishlist` WHERE `product_id` = '" . $pid . "';");
                                                                                $row10 = $resultset10->num_rows;

                                                                                ?>
                                                                                <img class="btn p-0 mt-0  d-none " onclick="loadIndex();" src="https://img.icons8.com/color/48/000000/--broken-heart--v1.png" style="height: 30px;" />
                                                                                <img class="btn p-0 mt-0" onclick="loadIndex();" src="https://img.icons8.com/color/48/000000/like.png" style="height: 30px;" />

                                                                                <label>
                                                                                    <?= $row10 ?>
                                                                                </label>

                                                                            </div>
                                                                        </div>
                                                                    <?php
                                                                    }
                                                                    ?>

                                                                </div>

                                                            </div>


                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div class="col-12 bg-white">
                                    <div class="row d-block me-0 mt-4 mb-3">
                                        <div class="col-md-6">
                                            <span class="fs-3 fw-bold">Products Details</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="row card-content m-3 p-3">
                                    <div class="col-12 bg-white">
                                        <div class="row">
                                            <div class="col-12 ">
                                                <div class="row">
                                                    <div class="col-12 col-md-2">
                                                        <label class="form-label fw-bold">Brand</label>
                                                    </div>
                                                    <div class="col-12 col-md-10">
                                                        <label class="form-label"><?php echo $pd["bname"]; ?></label>
                                                    </div>
                                                </div>
                                                <hr class="d-md-none" />
                                                <div class="row">
                                                    <div class="col-12 col-md-2">
                                                        <label class="form-label fw-bold">Model</label>
                                                    </div>
                                                    <div class="col-12 col-md-10">
                                                        <label class="form-label"><?php echo $pd["mname"]; ?></label>
                                                    </div>
                                                </div>
                                                <hr class="d-md-none" />
                                                <div class="row">
                                                    <div class="col-12 col-md-2">
                                                        <label class="form-label fw-bold">Color</label>
                                                    </div>
                                                    <div class="col-12 col-md-10">
                                                        <label class="form-label"><?php echo $pd["color"]; ?></label>
                                                    </div>
                                                </div>
                                                <hr class="d-md-none" />
                                                <div class="row">
                                                    <div class="col-12 col-md-2">
                                                        <label class="form-label fw-bold">Description</label>
                                                    </div>
                                                    <div class="col-12 col-md-10">
                                                        <p disabled><?php echo $pd["description"]; ?></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="col-12 bg-white">
                                    <div class="row d-block me-0 mt-4 mb-3">
                                        <div class="col-md-6">
                                            <span class="fs-3 fw-bold">Related items</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="row m-3 p-3 card-content">
                                    <div class="col-12 bg-white">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="row mx-md-4 p-2" style="text-align: justify;">

                                                    <?php
                                                    $prod = Database::search("SELECT * FROM `product` WHERE `model_has_brand_id` = '" . $pd["model_has_brand_id"] . "' AND `status_id` = '1' LIMIT 4");

                                                    $bds = $prod->num_rows;

                                                    for ($y = 0; $y < $bds; $y++) {
                                                        $dataset5 = $prod->fetch_assoc();

                                                        $resultset6 = Database::search("SELECT * FROM `condition` WHERE `id`='" . $dataset5["condition_id"] . "';");
                                                        $dataset6 = $resultset6->fetch_assoc();

                                                        $pimgrs = Database::search("SELECT * FROM images WHERE `product_id` = '" . $dataset5["id"] . "'");
                                                        $dataset7 = $pimgrs->fetch_assoc();


                                                    ?>

                                                        <div class="col-12 col-sm-6 col-lg-3 my-3">
                                                            <div class="flip-card" style="height: 380px;">
                                                                <div class="flip-card-inner">
                                                                    <div class="flip-card-front">
                                                                        <?php
                                                                        $delivery_fee_colombo = $dataset5["delivery_fee_colombo"];
                                                                        if ($delivery_fee_colombo == 0) {
                                                                        ?>
                                                                            <span class="text-black-50 deliveryStatement" style="margin-top: 350px;">Free delivery</span>
                                                                        <?php
                                                                        }
                                                                        ?>
                                                                        <?php
                                                                        $afterDiscountPrice = $dataset5["price"];
                                                                        $discount = $dataset5["discount"];


                                                                        if ($discount == 0) {
                                                                            $trueprice = number_format($dataset5["price"], 2);
                                                                        } else {
                                                                            $trueprice = number_format($afterDiscountPrice, 2);
                                                                            $beforeDiscountPrice = number_format(($afterDiscountPrice * 100) / (100 - $discount)) . ".00";
                                                                        ?>
                                                                            <span class="discount" style="margin-top: 350px;"><del class="text-black-50 discountprice">Rs.<?php echo $beforeDiscountPrice; ?></del>&nbsp;-<?php echo $discount; ?>%</span>
                                                                        <?php
                                                                        }

                                                                        ?>
                                                                        <h5>
                                                                            <?php
                                                                            if ($dataset6["name"] == 'New') {
                                                                            ?>
                                                                                <span class="badge badge-front bg-info text-dark"><?php echo $dataset6["name"]; ?></span>
                                                                            <?php
                                                                            } else {
                                                                            ?>
                                                                                <span class="badge badge-front bg-warning text-dark"><?php echo $dataset6["name"]; ?></span>
                                                                            <?php
                                                                            }
                                                                            ?>
                                                                        </h5>
                                                                        <div class="align-text-top">
                                                                            <div class="card-img" style="background-image: url('<?php echo $dataset7["code"]; ?>');"></div>
                                                                        </div>
                                                                        <div class="m-2" style="text-align: left;">
                                                                            <h5 class="title-4  fw-bold" style="text-align: center;"><?php echo $dataset5["title"]; ?></h5>
                                                                            <div class="text-center">
                                                                                <span class="fw-bold text-danger">Rs.<?php echo $trueprice; ?>/=</span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="flip-card-back">
                                                                        <div class="row">
                                                                            <div class="col-12 mt-4">
                                                                                <div class="row gy-1 p-2">
                                                                                    <h5 class="fw-bold">
                                                                                        <?php
                                                                                        $title = $dataset5["title"];
                                                                                        $titlelen = strlen($title);
                                                                                        if ($titlelen > 35) {
                                                                                            for ($t = 0; $t < 35; $t++) {
                                                                                                echo $title[$t];
                                                                                            }
                                                                                            echo "...";
                                                                                        } else {
                                                                                            echo $title;
                                                                                        }
                                                                                        ?>
                                                                                        <?php
                                                                                        if ($dataset6["name"] == 'New') {
                                                                                        ?>
                                                                                            <span class="badge bg-info text-dark"><?php echo $dataset6["name"]; ?></span>
                                                                                        <?php
                                                                                        } else {
                                                                                        ?>
                                                                                            <span class="badge bg-warning text-dark"><?php echo $dataset6["name"]; ?></span>
                                                                                        <?php
                                                                                        }
                                                                                        ?>
                                                                                    </h5>
                                                                                    <?php
                                                                                    if ($discount == 0) {
                                                                                    } else {

                                                                                    ?>
                                                                                        <span class="mt-0 mb-0 p-0"><del class="text-black-50 discountprice">Rs.<?php echo $beforeDiscountPrice; ?></del>&nbsp;-<?php echo $discount; ?>%</span>
                                                                                    <?php
                                                                                    }

                                                                                    ?>
                                                                                    <span class="fw-bold" style="color: rgb(37, 0, 0);">Rs.<?php echo $trueprice; ?>/=</span>
                                                                                    <?php
                                                                                    $delivery_fee_colombo = $dataset5["delivery_fee_colombo"];
                                                                                    if ($delivery_fee_colombo == 0) {
                                                                                    ?>
                                                                                        <span class="text-black-50">Free delivery</span>
                                                                                    <?php
                                                                                    }

                                                                                    ?>
                                                                                    <?php

                                                                                    if ($dataset5["qty"] > 0) {
                                                                                    ?>
                                                                                        <span class="fw-bold" style="color: black;">In Stock</span>
                                                                                    <?php
                                                                                    } else {
                                                                                    ?>
                                                                                        <span class="fw-bold text-danger">Out of Stock</span>
                                                                                    <?php
                                                                                    }

                                                                                    ?>

                                                                                    <div class="col-11 mx-auto d-grid"><button class="viewItem"><img src="https://img.icons8.com/ios-filled/30/000000/search--v1.png" style="height: 20px;" /> <a class="text-decoration-none text-dark" target="_blank" href='./singleProductView.php?id=<?= $dataset5['id'] ?>'>View Item</a></button></div>
                                                                                    <?php
                                                                                    if (isset($_SESSION["user"])) {
                                                                                        $resultset12 = Database::search("SELECT `id` FROM `wishlist` WHERE `product_id` = '" . $dataset5["id"] . "';");
                                                                                        $row12 = $resultset12->num_rows;

                                                                                        $resultset13 = Database::search("SELECT `id` FROM `wishlist` WHERE `product_id` = '" . $dataset5["id"] . "' AND `user_email` = '" . $_SESSION["user"]["email"] . "'  ;");
                                                                                        $row13 = $resultset13->num_rows;
                                                                                        if ($row13 == 1) {
                                                                                    ?>

                                                                                            <label class="mx-auto"><img class="btn p-0" onclick="removeWishlist(<?= $dataset5['id'] ?>);" src="https://img.icons8.com/color/48/000000/--broken-heart--v1.png" style="height: 30px;" />&nbsp;<?= $row12 ?></label>
                                                                                        <?php
                                                                                        } else {
                                                                                        ?>
                                                                                            <label class="mx-auto"><img class="btn p-0" onclick="addWishlistHome(<?= $dataset5['id'] ?>);" src="https://img.icons8.com/color/48/000000/like.png" style="height: 30px;" />&nbsp;<?= $row12 ?></label>

                                                                                        <?php
                                                                                        }
                                                                                        ?>


                                                                                    <?php
                                                                                    } else {
                                                                                        $resultset12 = Database::search("SELECT `id` FROM `wishlist` WHERE `product_id` = '" . $dataset5['id'] . "';");
                                                                                        $row12 = $resultset12->num_rows;

                                                                                    ?>
                                                                                        <label class="mx-auto"><img class="btn p-0" onclick="loadIndex();" src="https://img.icons8.com/color/48/000000/like.png" style="height: 30px;" />&nbsp;<?= $row12 ?></label>
                                                                                    <?php
                                                                                    }
                                                                                    ?>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    <?php
                                                    }
                                                    ?>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-center">
                        <div id="snackbar">Some text message..</div>
                    </div>
                    <div class="d-flex justify-content-center">
                        <div id="snackbarbtn">
                            <span id="snackbarmsg">Some text message..</span>
                            <div class="text-center">
                                <button class="btn btn-outline-light pt-0 pb-0 ps-3 pe-3" id="ok">Yes</button>
                                <button class="btn btn-outline-light pt-0 pb-0 ps-3 pe-3" id="cancel">No</button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

            <script src="script.js"></script>
            <script>
                var num = document.getElementById('qtyinput');

                num.addEventListener('keydown', function(e) {

                    var charCode = (e.which) ? e.which : e.keyCode;
                    if ((charCode > 47 && charCode < 58) || (charCode > 95 && charCode < 105) || charCode == 8) {
                        return true;
                    }
                    e.preventDefault();
                    return false;
                }, true);
            </script>
        </body>

        </html>


    <?php

    }
} else {

    ?>
    <script>
        window.location = "home.php";
    </script>
<?php

}

?>