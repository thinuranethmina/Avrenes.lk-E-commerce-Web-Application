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

    <body class="myproductbody" onload="loadproducts(0);">
        <div class="container-fluid">
            <div class="row">
                <!-- header -->

                <div class="col-12">
                    <div class="mb-3 d-md-none">
                        <div class="row">

                            <div class="col-12">
                                <div class="row">
                                    <div class="col-12 d-flex justify-content-center mt-2 mb-2">
                                        <h1 class="fw-bold fs-1 title04">
                                            My Products
                                        </h1>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="row d-flex justify-content-center">

                                </div>

                            </div>
                        </div>

                    </div>
                </div>
                <div class="d-none d-md-block">
                    <div class="row mt-2 mb-2">

                        <div class="col-6 col-lg-5 col-xl-4 my-auto">
                            <div class="row ms-lg-2">


                            </div>
                        </div>

                        <div class="col-6 col-lg-4 my-auto">
                            <div class="text-center me-5 mx-auto">
                                <h1 class="fw-bold fs-1 title04">
                                    My Products
                                </h1>
                            </div>
                        </div>

                        <div class="col-3 col-xl-4 ps-xl-5 d-none d-lg-block my-auto">
                        </div>

                    </div>
                </div>

            </div>

            <!-- header -->

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
                                        <select id="category" class="form-control" onchange="loadproducts(0);">
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
                                            <input type="radio" name="sort1" class="form-check-input" id="ntoo" onclick="loadproducts(0);">
                                            <label for="ntoo" class="form-check-label">
                                                Newest to Oldest
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input type="radio" name="sort1" class="form-check-input" id="oton" onclick="loadproducts(0);">
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
                                        <span class="fw-bold">Status</span>
                                        <p class="filter-text" style="line-height: normal;">Choose what to display on product status.</p>
                                        <div class="form-check">
                                            <input type="radio" name="status" class="form-check-input" id="active" onclick="loadproducts(0);">
                                            <label for="active" class="form-check-label">
                                                Active
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input type="radio" name="status" class="form-check-input" id="deactive" onclick="loadproducts(0);">
                                            <label for="deactive" class="form-check-label">
                                                Deactive
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
                                            <input type="radio" name="sort2" class="form-check-input" id="avblstock" onclick="loadproducts(0);">
                                            <label for="avblstock" class="form-check-label">
                                                Available Stock
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input type="radio" name="sort2" class="form-check-input" id="uavblstock" onclick="loadproducts(0);">
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
                                            <input type="radio" name="sort1" class="form-check-input" id="ltoh" onclick="loadproducts(0);">
                                            <label for="ltoh" class="form-check-label">
                                                Low to High
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input type="radio" name="sort1" class="form-check-input" id="htol" onclick="loadproducts(0);">
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
                                            <input type="radio" name="condition" class="form-check-input" id="new" onclick="loadproducts(0);">
                                            <label for="new" class="form-check-label">
                                                Brand new
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input type="radio" name="condition" class="form-check-input" id="used" onclick="loadproducts(0);">
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
                                            <input type="radio" name="sort1" class="form-check-input" id="atoz" onclick="loadproducts(0);">
                                            <label for="atoz" class="form-check-label">
                                                A to Z (Title)
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input type="radio" name="sort1" class="form-check-input" id="ztoa" onclick="loadproducts(0);">
                                            <label for="ztoa" class="form-check-label">
                                                Z to A (Title)
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 col-lg-4">
                                <div class="row">
                                    <div class="col-12 filter-card">
                                        <span class="fw-bold">Product per row</span>
                                        <p class="filter-text">How many products should be shown per row?</p>
                                        <input type="number" id="columns" class="form-control" oninput="process(this);loadproducts(0);" value="<?php echo $rowValue; ?>" min="1" max="4" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 offset-sm-3 col-lg-4 offset-lg-0">
                                <div class="row">
                                    <div class="col-12  filter-card">
                                        <span class="fw-bold">Rows per page</span>
                                        <p class="filter-text">How many rows of products should be shown per page?</p>
                                        <input type="number" id="rows" class="form-control" value="5" oninput="process(this);loadproducts(0);" min="1" max="10" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-8 offset-sm-2 col-lg-8 offset-lg-0">
                                <div class="input-group pt-3 pb-3">
                                    <input type="text" id="search" onclick="scrolToSearch();" onkeyup="loadproducts(0);scrolToSearch();" class="form-control d-grid border-2 my-auto" placeholder="Type Here to Search . . .">
                                    <span class="input-group-text" id="basic-addon2" style="cursor: pointer;" onclick="loadproducts(0);scrolToSearch2();">Search</span>
                                </div>
                            </div>
                            <div class="col-12 col-sm-8 offset-sm-2 col-lg-4 offset-lg-0">
                                <div class="row pt-3 pb-3">
                                    <button class="btn btn-dark d-grid my-auto" id="clearFilters" type="reset" onclick="clearfilters();">Clear filters</button>
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
