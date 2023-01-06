<?php

session_set_cookie_params(60 * 60 * 24 * 30);
session_start();

require "connection.php";

if (isset($_SESSION["user"])) {

    $width = "<script>document.write(screen.width);</script>";

    if ($width > 600) {
        $rowValue = "2";
    } else {
        $rowValue = "1";
    }
?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="bootstrap.css">
        <link rel="stylesheet" href="style.css">
        <link rel="stylesheet" href="myproducts.css">
        <link rel="icon" href="resources/icon.png">
        <title>avrence | My Products</title>

    </head>

    <body class="myproductbody" onload="loadproducts2(0);">
        <div class="container-fluid">
            <div class="row">

                <div class="col-12 mt-3">
                    <div class="row m-3">

                        <!-- filter -->
                        <div class="col-12" id="filter">
                            <div class="row pb-3 gx-5 gy-3 ps-2 pe-2 filter">
                                <h3 class="fw-bold ">Filters</h3>

                                <div class="col-12 col-sm-6 col-lg-4">
                                    <div class="row">
                                        <div class="col-12 filter-card">
                                            <span class="fw-bold">Select Category</span>
                                            <p class="filter-text" style="line-height: normal;">Choose what to display on product quantity.</p>
                                            <?php
                                            $resultset1 = Database::search("SELECT * FROM `category`;");
                                            $rows1 = $resultset1->num_rows;
                                            ?>
                                            <select id="category" class="form-control" onchange="loadproducts2(0);">
                                                <option value="0">All</option>
                                                <?php
                                                for ($x = 0; $x < $rows1; $x++) {
                                                    $dataset = $resultset1->fetch_assoc();
                                                ?>
                                                    <option value="<?php echo $dataset["id"]; ?>"><?php echo $dataset["name"]; ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6 col-lg-4">
                                    <div class="row">
                                        <div class="col-12 filter-card">
                                            <span class="fw-bold">By Activated time</span>
                                            <p class="filter-text" style="line-height: normal;">Choose what to display on product status.</p>
                                            <div class="form-check">
                                                <input type="radio" checked name="sort1" class="form-check-input" id="ntoo" onclick="loadproducts2(0);">
                                                <label for="ntoo" class="form-check-label">
                                                    Newest to Oldest
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input type="radio" name="sort1" class="form-check-input" id="oton" onclick="loadproducts2(0);">
                                                <label for="oton" class="form-check-label">
                                                    Oldest to Newest
                                                </label>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6 col-lg-4">
                                    <div class="row">
                                        <div class="col-12 filter-card">
                                            <span class="fw-bold">By Stock</span>
                                            <p class="filter-text" style="line-height: normal;">Select sorting options to display.</p>
                                            <div class="form-check">
                                                <input type="radio" checked name="sort2" class="form-check-input" id="avblstock" onclick="loadproducts2(0);">
                                                <label for="avblstock" class="form-check-label">
                                                    Available Stock
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input type="radio" name="sort2" class="form-check-input" id="uavblstock" onclick="loadproducts2(0);">
                                                <label for="uavblstock" class="form-check-label">
                                                    Unavailable Stock
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6 col-lg-4">
                                    <div class="row">
                                        <div class="col-12 filter-card">
                                            <span class="fw-bold">By Quantity</span>
                                            <p class="filter-text" style="line-height: normal;">Choose what to display on product quantity.</p>
                                            <div class="form-check">
                                                <input type="radio" name="sort1" class="form-check-input" id="ltoh" onclick="loadproducts2(0);">
                                                <label for="ltoh" class="form-check-label">
                                                    Low to High
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input type="radio" name="sort1" class="form-check-input" id="htol" onclick="loadproducts2(0);">
                                                <label for="htol" class="form-check-label">
                                                    High to Low
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6 col-lg-4">
                                    <div class="row">
                                        <div class="col-12 filter-card">
                                            <span class="fw-bold">By Condition</span>
                                            <p class="filter-text">Choose what to display on product status.</p>
                                            <div class="form-check">
                                                <input type="radio" name="condition" class="form-check-input" id="new" onclick="loadproducts2(0);">
                                                <label for="new" class="form-check-label">
                                                    Brand new
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input type="radio" name="condition" class="form-check-input" id="used" onclick="loadproducts2(0);">
                                                <label for="used" class="form-check-label">
                                                    Used
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6 col-lg-4">
                                    <div class="row">
                                        <div class="col-12 filter-card">
                                            <span class="fw-bold">By sorting</span>
                                            <p class="filter-text">Choose what to display on product status.</p>
                                            <div class="form-check">
                                                <input type="radio" name="sort1" class="form-check-input" id="atoz" onclick="loadproducts2(0);">
                                                <label for="atoz" class="form-check-label">
                                                    A to Z (Title)
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input type="radio" name="sort1" class="form-check-input" id="ztoa" onclick="loadproducts2(0);">
                                                <label for="ztoa" class="form-check-label">
                                                    Z to A (Title)
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- filter -->
                        <!-- body -->

                        <div class="col-12 mt-5" id="myproducts">
                            <!-- Products table -->
                        </div>

                        <!-- body -->
                    </div>
                </div>

            </div>
        </div>


        <script src="script.js"></script>
    </body>

    </html>

<?php
} else {
    echo "Error";
}
