<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap.css">
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="resources/icon.png">
    <title>avrence | Home</title>

</head>

<body>
    <?php

    require "connection.php";

    session_set_cookie_params(60 * 60 * 24 * 30);
    session_start();
    ?>
    <div class="container-fluid">
        <div class="row">
            <?php
            require  "header.php";
            ?>
            <div class="col-4 col-lg-2 offset-4 offset-lg-1 logo-img my-auto"></div>


            <div class="col-8 d-grid gap-2">

                <div class="input-group pt-3 pb-3">
                    <input type="text" id="search" onclick="scrolToSearch();" onkeyup="loadproducts2(0);scrolToSearch();" class="form-control d-grid border-2 my-auto" placeholder="Type Here to Search . . .">
                    <span class="input-group-text btn btn-primary" id="basic-addon2" style="cursor: pointer;" onclick="search();" onclick="loadproducts2(0);scrolToSearch2();">Search</span>
                </div>
            </div>

            <hr class="hr-break-1" />
            <div class="row">
                <div class="col-12" id="serchproduct">
                    <div class="col-8 offset-2 d-none d-lg-block pt-3 pb-3">
                        <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-indicators">
                                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
                                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="3" aria-label="Slide 4"></button>
                            </div>
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <img src="resources/carousel5.jpg" class="d-block w-100 poster" alt="...">
                                </div>
                                <div class="carousel-item">
                                    <img src="resources/carousel2.jpg" class="d-block w-100 poster" alt="...">
                                </div>
                                <div class="carousel-item">
                                    <img src="resources/carousel4.jpg" class="d-block w-100 poster" alt="...">
                                </div>
                                <div class="carousel-item">
                                    <img src="resources/carousel1.jpg" class="d-block w-100 poster" alt="...">
                                </div>
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-md" id="allproduct">
            <h3 class="mt-5">
                &#x25BA;&#x25BA;&#x25BA;New Arrivals
            </h3>
            <hr class="hr-1" />
            <?php

            $resultset1 = Database::search("SELECT * FROM `category`;");
            $loop1 = $resultset1->num_rows;

            for ($x = 0; $x < $loop1; $x++) {
                $dataset1 = $resultset1->fetch_assoc();

            ?>

                <div class="card-content pt-3 pb-4 ps-lg-5 pe-lg-5 mb-3">
                    <div class="col-12">
                        <div class="row">
                            <div class="col-6 ps-5 text-start my-auto">
                                <a class="text-decoration-none category-title-1" href="#"><?php echo $dataset1["name"]; ?></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="row justify-content-center mt-1 ms-5 me-5">

                            <?php

                            $resultset2 = Database::search("SELECT * FROM `product` WHERE `category_id`='" . $dataset1["id"] . "' AND `qty`!= '0' AND `status_id` = '1' ORDER BY `datetime_added` DESC LIMIT 4 OFFSET 0 ;");
                            $loop2 = $resultset2->num_rows;

                            for ($y = 0; $y < $loop2; $y++) {
                                $dataset2 = $resultset2->fetch_assoc();

                                $resultset3 = Database::search("SELECT * FROM `condition` WHERE `id`='" . $dataset2["condition_id"] . "';");
                                $dataset3 = $resultset3->fetch_assoc();

                                $resultset4 = Database::search("SELECT * FROM `images` WHERE `product_id`='" . $dataset2["id"] . "';");
                                $dataset4 = $resultset4->fetch_assoc();

                            ?>

                                <div class="col-12 col-sm-6 col-lg-3 mt-2 mb-1">
                                    <div class="flip-card">
                                        <div class="flip-card-inner">
                                            <div class="flip-card-front">
                                                <?php
                                                $delivery_fee_colombo = $dataset2["delivery_fee_colombo"];
                                                if ($delivery_fee_colombo == 0) {
                                                ?>
                                                    <span class="text-black-50 deliveryStatement">Free delivery</span>
                                                <?php
                                                }
                                                ?>
                                                <?php
                                                $afterDiscountPrice = $dataset2["price"];
                                                $discount = $dataset2["discount"];


                                                if ($discount == 0) {
                                                    $trueprice = number_format($dataset2["price"], 2);
                                                } else {
                                                    $trueprice = number_format($afterDiscountPrice, 2);
                                                    $beforeDiscountPrice = number_format(($afterDiscountPrice * 100) / (100 - $discount)) . ".00";
                                                ?>
                                                    <span class="discount"><del class="text-black-50 discountprice">Rs.<?php echo $beforeDiscountPrice; ?></del>&nbsp;-<?php echo $discount; ?>%</span>
                                                <?php
                                                }

                                                ?>

                                                <h5>
                                                    <?php
                                                    if ($dataset3["name"] == 'New') {
                                                    ?>
                                                        <span class="badge badge-front bg-info text-dark"><?php echo $dataset3["name"]; ?></span>
                                                    <?php
                                                    } else {
                                                    ?>
                                                        <span class="badge badge-front bg-warning text-dark"><?php echo $dataset3["name"]; ?></span>
                                                    <?php
                                                    }
                                                    ?>
                                                </h5>
                                                <div class="align-text-top">
                                                    <div class="card-img" style="background-image: url('<?php echo $dataset4["code"]; ?>');"></div>
                                                </div>
                                                <div class="m-2" style="text-align: left;">
                                                    <h5 class="title-4 fw-bold" style="text-align: center;"><?php echo $dataset2["title"]; ?></h5>
                                                    <div class="text-center">
                                                        <span class="fw-bold text-danger">Rs.<?php echo $trueprice; ?>/=</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="flip-card-back">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="row gy-1 p-1 my-auto">
                                                            <div style="text-align: justify;">
                                                                <h5 class="fw-bold">
                                                                    <?php
                                                                    $title = $dataset2["title"];
                                                                    $titlelen = strlen($title);
                                                                    if ($titlelen > 25) {
                                                                        for ($t = 0; $t < 25; $t++) {
                                                                            echo $title[$t];
                                                                        }
                                                                        echo "...";
                                                                    } else {
                                                                        echo $title;
                                                                    }
                                                                    ?>
                                                                    <?php
                                                                    if ($dataset3["name"] == 'New') {
                                                                    ?>
                                                                        <span class="badge bg-info text-dark"><?php echo $dataset3["name"]; ?></span>
                                                                    <?php
                                                                    } else {
                                                                    ?>
                                                                        <span class="badge bg-warning text-dark"><?php echo $dataset3["name"]; ?></span>
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                </h5>
                                                            </div>
                                                            <?php
                                                            if ($discount == 0) {
                                                            } else {
                                                            ?>
                                                                <span class="mt-0 mb-0 p-0"><del class="text-black-50 discountprice">Rs.<?php echo $beforeDiscountPrice; ?></del>&nbsp;-<?php echo $discount; ?>%</span>
                                                            <?php
                                                            }

                                                            ?>
                                                            <span class="fw-bold" style="color: rgb(46, 0, 0);">Rs.<?php echo $trueprice; ?>/=</span>
                                                            <?php
                                                            $delivery_fee_colombo = $dataset2["delivery_fee_colombo"];
                                                            if ($delivery_fee_colombo == 0) {
                                                            ?>
                                                                <span class="text-black-50">Free delivery</span>
                                                            <?php
                                                            }

                                                            ?>
                                                            <?php

                                                            if ($dataset2["qty"] > 0) {
                                                            ?>
                                                                <span class="fw-bold" style="color: black;">In Stock</span>
                                                                <div class="col-11 mx-auto d-grid"><button class="viewItem"><img src="https://img.icons8.com/ios-filled/30/000000/search--v1.png" style="height: 20px;" /> <a class="text-decoration-none text-dark" target="_blank" href='./singleProductView.php?id=<?= $dataset2['id'] ?>'>View Item</a></button></div>
                                                                <?php
                                                                if (isset($_SESSION["user"])) {
                                                                ?>
                                                                    <div class="col-11 mx-auto d-grid"><button onclick="buyNowH(<?= $dataset2['id'] ?>);" class="buyNow2"><img src="https://img.icons8.com/external-itim2101-fill-itim2101/64/000000/external-pay-currency-and-money-itim2101-fill-itim2101.png" style="height: 20px;" /> Buy Now</button></div>
                                                                    <div class="col-11 mx-auto d-grid"><button onclick="addtoCartH(<?= $dataset2['id'] ?>);" class="addToCart2"><img src="https://img.icons8.com/ios-glyphs/30/000000/buy--v2.png" style="height: 20px;" /> Add to Cart</button></div>

                                                                <?php
                                                                } else {
                                                                ?>
                                                                    <div class="col-11 mx-auto d-grid"><button onclick="loadIndex();" class="buyNow2"><img src="https://img.icons8.com/external-itim2101-fill-itim2101/64/000000/external-pay-currency-and-money-itim2101-fill-itim2101.png" style="height: 20px;" /> Buy Now</button></div>
                                                                    <div class="col-11 mx-auto d-grid"><button onclick="loadIndex();" class="addToCart2"><img src="https://img.icons8.com/ios-glyphs/30/000000/buy--v2.png" style="height: 20px;" /> Add to Cart</button></div>
                                                                <?php
                                                                }
                                                            } else {
                                                                ?>
                                                                <span class="fw-bold text-danger">Out of Stock</span>
                                                                <div class="col-11 mx-auto d-grid"><button class="viewItem"><img src=" https://img.icons8.com/ios-filled/30/000000/search--v1.png" style="height: 20px;" /> <a class="text-decoration-none text-dark" target="_blank" href='./singleProductView.php?id=<?= $dataset2['id'] ?>'>View Item</a></button></div>
                                                                <div class="col-11 mx-auto d-grid"><button disabled class="buyNow2" style="opacity: 0.4;outline: none;"><img src=" https://img.icons8.com/external-itim2101-fill-itim2101/64/000000/external-pay-currency-and-money-itim2101-fill-itim2101.png" style="height: 20px;" /> Buy Now</button></div>
                                                                <div class="col-11 mx-auto d-grid"><button disabled class="addToCart2" style="opacity: 0.4;outline: none;"><img src=" https://img.icons8.com/ios-glyphs/30/000000/buy--v2.png" style="height: 20px;" /> Add to Cart</button></div>
                                                            <?php
                                                            }

                                                            ?>
                                                            <?php
                                                            if (isset($_SESSION["user"])) {
                                                                $resultset10 = Database::search("SELECT `id` FROM `wishlist` WHERE `product_id` = '" . $dataset2["id"] . "';");
                                                                $row10 = $resultset10->num_rows;

                                                                $resultset11 = Database::search("SELECT `id` FROM `wishlist` WHERE `product_id` = '" . $dataset2["id"] . "' AND `user_email` = '" . $_SESSION["user"]["email"] . "'  ;");
                                                                $row11 = $resultset11->num_rows;
                                                                if ($row11 == 1) {
                                                            ?>

                                                                    <label class="mx-auto"><img class="btn p-0" onclick="removeWishlist(<?= $dataset2['id'] ?>);" src="https://img.icons8.com/color/48/000000/--broken-heart--v1.png" style="height: 30px;" />&nbsp;<?= $row10 ?></label>
                                                                <?php
                                                                } else {
                                                                ?>
                                                                    <label class="mx-auto"><img class="btn p-0" onclick="addWishlistHome(<?= $dataset2['id'] ?>);" src="https://img.icons8.com/color/48/000000/like.png" style="height: 30px;" />&nbsp;<?= $row10 ?></label>

                                                                <?php
                                                                }
                                                                ?>


                                                            <?php
                                                            } else {
                                                                $resultset10 = Database::search("SELECT `id` FROM `wishlist` WHERE `product_id` = '" . $dataset2['id'] . "';");
                                                                $row10 = $resultset10->num_rows;

                                                            ?>
                                                                <label class="mx-auto"><img class="btn p-0" onclick="loadIndex();" src="https://img.icons8.com/color/48/000000/like.png" style="height: 30px;" />&nbsp;<?= $row10 ?></label>
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

            <?php
            }

            ?>
            <h2 class="mt-5">
                &#x25BA;&#x25BA;&#x25BA;Just For you
            </h2>
            <div class="row cards-content justify-content-center">
                <hr class="hr-1" />
                <div class="pt-3 pb-4 ps-lg-5 pe-lg-5 mb-3">
                    <div class="col-12">
                        <div class="row justify-content-center mt-1 ms-5 me-5">

                            <?php

                            $resultset5 = Database::search("SELECT * FROM `product` WHERE `status_id` = '1' ORDER BY `datetime_added` DESC ;");
                            $loop5 = $resultset5->num_rows;

                            for ($y = 0; $y < $loop5; $y++) {
                                $dataset5 = $resultset5->fetch_assoc();

                                $resultset6 = Database::search("SELECT * FROM `condition` WHERE `id`='" . $dataset5["condition_id"] . "';");
                                $dataset6 = $resultset6->fetch_assoc();

                                $resultset7 = Database::search("SELECT * FROM `images` WHERE `product_id`='" . $dataset5["id"] . "';");
                                $dataset7 = $resultset7->fetch_assoc();
                            ?>

                                <div class="col-12 col-sm-6 col-lg-3 mb-3">
                                    <div class="flip-card">
                                        <div class="flip-card-inner">
                                            <div class="flip-card-front">
                                                <?php
                                                $delivery_fee_colombo = $dataset5["delivery_fee_colombo"];
                                                if ($delivery_fee_colombo == 0) {
                                                ?>
                                                    <span class="text-black-50 deliveryStatement">Free delivery</span>
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
                                                    <span class="discount"><del class="text-black-50 discountprice">Rs.<?php echo $beforeDiscountPrice; ?></del>&nbsp;-<?php echo $discount; ?>%</span>
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
        <div class="row">
            <?php
            require "footer.php";
            ?>
        </div>
    </div>
    <script src="script.js"></script>
</body>

</html>