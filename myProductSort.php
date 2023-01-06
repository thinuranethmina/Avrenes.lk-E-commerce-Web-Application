<?php

session_set_cookie_params(60 * 60 * 24 * 30);
session_start();

if (isset($_SESSION["user"])) {
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <style>
            .pagination {
                display: inline-block;
            }

            .pagination a {
                color: black;
                float: left;
                padding: 8px 16px;
                text-decoration: none;
                border: 1px solid #ddd;
                cursor: pointer;
            }

            .pagination a.active {
                background-color: blue;
                color: white;
                border: 1px solid blue;
            }

            .pagination a:hover:not(.active) {
                background-color: #ddd;
            }

            .pagination a:first-child {
                border-top-left-radius: 5px;
                border-bottom-left-radius: 5px;
            }

            .pagination a:last-child {
                border-top-right-radius: 5px;
                border-bottom-right-radius: 5px;
            }
        </style>
    </head>

    <body style="margin: 0; padding: 0;">
        <?php

        require "connection.php";

        $columns = $_POST["columns"];
        $rows = $_POST["rows"];
        $start = $_POST["start"];
        $age = $_POST["age"];
        $status = $_POST["status"];
        $stock = $_POST["stock"];
        $sort = $_POST["sort"];
        $qty = $_POST["qty"];
        $condition = $_POST["condition"];
        $search = rtrim(ltrim($_POST["search"]));
        $category = $_POST["category"];

        $query = "SELECT * FROM `product` WHERE `user_email` = '" . $_SESSION["user"]["email"] . "'";

        if ($condition == "1") {
            $query .= " AND `condition_id`='1'";
        } else if ($condition == "2") {
            $query .= " AND `condition_id`='2'";
        }
        if ($status == "1") {
            $query .= " AND `status_id`='1'";
        } else if ($status == "2") {
            $query .= " AND `status_id`='2'";
        }
        if ($stock == "1") {
            $query .= " AND `qty`>'0'";
        } else if ($stock == "2") {
            $query .= " AND `qty`='0'";
        }

        if (!empty($search)) {
            $query .= "AND `title` LIKE '%" . $search . "%'";
            // $query .= " AND `title` LIKE '%" . $search . "%' OR SOUNDEX(`title`) = SOUNDEX('" . $search . "')";
        }

        if ($category != '0') {
            $query .= " AND `category_id` = '" . $category . "'";
        }

        if ($qty == "1") {
            $query .= " ORDER BY `qty` ASC";
        } else if ($qty == "2") {
            $query .= " ORDER BY `qty` DESC";
        } else if ($age == "1") {
            $query .= " ORDER BY `datetime_added` DESC";
        } else if ($age == "2") {
            $query .= " ORDER BY `datetime_added` ASC";
        } else if ($sort == "1") {
            $query .= " ORDER BY `title` ASC";
        } else if ($sort == "2") {
            $query .= " ORDER BY `title` DESC";
        }
        // echo $query;
        ?>
        <table style="text-align: center; width: 100%; margin: 0; padding: 0;">

            <?php
            $products_per_page = $columns * $rows;
            $resultset1 = Database::search($query . " LIMIT " . $start . "," . $products_per_page . "");
            $rows1 = $resultset1->num_rows;
            if ($rows1 != 0) {
                $displaiedItems = 0;

                for ($x = 0; $x < $rows; $x++) {
            ?><tr><?php
                    for ($y = 0; $y < $columns; $y++) {
                        $dataset1 = $resultset1->fetch_assoc();

                        if ($rows1 > $displaiedItems) {
                    ?>
                                <td>
                                    <div class="row">
                                        <?php

                                        $resultset2 = Database::search("SELECT * FROM `condition` WHERE `id`='" . $dataset1["condition_id"] . "';");
                                        $dataset2 = $resultset2->fetch_assoc();

                                        $resultset3 = Database::search("SELECT * FROM `images` WHERE `product_id`='" . $dataset1["id"] . "';");
                                        $dataset3 = $resultset3->fetch_assoc();
                                        ?>
                                        <div class="col-12">
                                            <div class="m-3">
                                                <div class="flip-card-nontransform" id="flip-card-nontransform<?php echo $dataset1["id"]; ?>" style="<?php
                                                                                                                                                        if ($dataset1["qty"] < 3 && $dataset1["status_id"] == 1) {
                                                                                                                                                            echo "box-shadow: 0 10px 16px 0 rgba(255, 0, 0, 0.2);border:solid red 3px;";
                                                                                                                                                        } else {
                                                                                                                                                            echo "box-shadow: 0 6px 10px 0 rgba(0, 0, 0, 0.2);";
                                                                                                                                                        } ?>">
                                                    <div id="content1<?php echo $dataset1["id"]; ?>" style="<?php if ($dataset1["status_id"] != 1) {
                                                                                                                echo "opacity:0.5;";
                                                                                                            } ?>">
                                                        <?php
                                                        $afterDiscountPrice = $dataset1["price"];
                                                        $discount = $dataset1["discount"];
                                                        ?>
                                                        <h5>
                                                            <?php
                                                            if ($dataset2["name"] == 'New') {
                                                            ?>
                                                                <span class="badge badge-front bg-info text-dark"><?php echo $dataset2["name"]; ?></span><br />
                                                            <?php
                                                            } else {
                                                            ?>
                                                                <span class="badge badge-front bg-warning text-dark"><?php echo $dataset2["name"]; ?></span><br />
                                                            <?php
                                                            }
                                                            ?>
                                                        </h5>

                                                        <div class="m-2 mt-3" style="text-align: left; height: 50px;">
                                                            <h5 class="title-4 fw-bold" style="text-align: center;"><?php
                                                                                                                    if ($dataset1["qty"] < 3 && $dataset1["status_id"] == 1) {
                                                                                                                    ?>
                                                                    <img src="resources/pulse.gif" id="warningIcon<?php echo $dataset1["id"]; ?>" class="pb-1" width="35px">
                                                                <?php
                                                                                                                    } else {
                                                                ?>
                                                                    <img src="resources/pulse.gif" id="warningIcon<?php echo $dataset1["id"]; ?>" class="pb-1 d-none" width="35px">
                                                                <?php
                                                                                                                    } ?>
                                                                <?php echo $dataset1["title"]; ?>
                                                            </h5>
                                                        </div>
                                                        <div class="row d-flex justify-content-center mb-1">
                                                            <div class="my-auto d-inline-block" style="height: auto; width: 200px;">
                                                                <div class="card-img-nontransform" style="background-image: url('<?php echo $dataset3["code"]; ?>');"></div>
                                                            </div>
                                                            <div class="ps-2 my-auto d-inline-block" style="height: auto; width: 200px;">
                                                                <div class="align-content-center" style="min-height: 110px; height: auto; vertical-align: bottom;">
                                                                    <?php
                                                                    if ($discount == 0) {
                                                                        $trueprice = number_format($dataset1["price"], 2);
                                                                    } else {
                                                                        $trueprice = number_format($afterDiscountPrice, 2);
                                                                        $beforeDiscountPrice = number_format(($afterDiscountPrice * 100) / (100 - $discount)) . ".00";
                                                                    ?>
                                                                        <div class=" mb-1">
                                                                            <span><del class="text-black-50 discountprice">Rs.<?php echo $beforeDiscountPrice; ?></del>&nbsp;-<?php echo $discount; ?>%</span>
                                                                        </div>
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                    <span class="fw-bold fs-5 text-danger">Rs.<?php echo $trueprice; ?>/=</span>
                                                                    <br />
                                                                    <div class="mt-1">
                                                                        <?php
                                                                        if ($dataset1["qty"] == 0) {
                                                                        ?>
                                                                            <span class="fw-bold text-success ">Stock Unavailable</span>
                                                                        <?php
                                                                        } else {
                                                                        ?>
                                                                            <span class="fw-bold text-success"><?php echo $dataset1["qty"]; ?> Stock Available</span>
                                                                        <?php
                                                                        }
                                                                        ?>
                                                                        <br />
                                                                        <span class="fw-bold"><img src="resources/star1.png" class="my-auto" width="20px" /><span class="my-auto mt-5"> 4.6</span></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex justify-content-center mb-3" style="opacity: 1;">
                                                        <div class="form-switch ps-0 my-auto">
                                                            <label class="checkbox-ios">
                                                                <input id="toggle<?php echo $dataset1["id"]; ?>" onclick="changeStatus(<?php echo $dataset1['id']; ?>,<?php echo $dataset1['qty']; ?>);" type="checkbox" <?php
                                                                                                                                                                                                                            if ($dataset1["status_id"] == 1) {
                                                                                                                                                                                                                                echo "checked";
                                                                                                                                                                                                                            } else {
                                                                                                                                                                                                                            }
                                                                                                                                                                                                                            ?> />
                                                                <span class="checkbox-ios-switch"></span>
                                                            </label>
                                                            <label for="toggle<?php echo $dataset1["id"]; ?>"><span class="fw-bold text-dark" id="statusLable<?php echo $dataset1['id']; ?>" style="cursor: pointer;">Make Your Product <?php
                                                                                                                                                                                                                                        if ($dataset1["status_id"] == 1) {
                                                                                                                                                                                                                                            echo "Deactive";
                                                                                                                                                                                                                                        } else {
                                                                                                                                                                                                                                            echo "Active";
                                                                                                                                                                                                                                        }
                                                                                                                                                                                                                                        ?></span></label>
                                                        </div>
                                                    </div>
                                                    <div class="mb-3" id="content2<?php echo $dataset1["id"]; ?>" style="<?php if ($dataset1["status_id"] != 1) {
                                                                                                                                echo "opacity:0.5;";
                                                                                                                            } ?>">
                                                        <button class="btn btn-warning m-1" onclick="updateProduct('<?= $dataset1['id'] ?>');" style="width: 120px;">Update</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            <?php
                            $displaiedItems++;
                        } else {
                            ?>
                                <!-- <td></td> -->
                        <?php
                        }
                    }
                        ?>
                    </tr><?php

                        }

                            ?>

                <tr>
                    <td colspan="<?php echo $columns; ?>">
                        <div class="pagination">
                            <?php
                            $resultset2 = Database::search($query);

                            $number_of_products = $resultset2->num_rows;

                            $pages = ceil($number_of_products / $products_per_page);

                            if ($start != 0) {
                            ?>
                                <a onclick="loadproducts(<?php echo $start - $products_per_page; ?>);scrolToMyProducts();">&laquo;</a>
                            <?php
                            } else {
                            ?>
                                <a readonly>&laquo;</a>
                                <?php
                            }

                            if ($start  <= $products_per_page) {
                                $startno = 1;
                            } else {
                                $startno = ($start / $products_per_page) - 1;
                            }

                            if ($pages <= $start / $products_per_page + 3) {
                                $endno = $pages;
                            } else {
                                $endno = $start / $products_per_page + 3;
                            }

                            for ($t = $startno; $t <= $endno; $t++) {

                                if ($start == ($t - 1) * $products_per_page) {

                                ?>
                                    <a class="active" onclick="scrolToMyProducts();"><?php echo $t; ?></a>
                                <?php
                                } else {

                                ?>
                                    <a onclick="loadproducts(<?php echo ($t - 1) * $products_per_page; ?>);scrolToMyProducts();"><?php echo $t; ?></a>
                            <?php
                                }
                            }
                            ?>
                            <?php
                            if ($start != (floor($pages) - 1) * $products_per_page) {
                            ?>
                                <a onclick="loadproducts(<?php echo $start + $products_per_page; ?>);scrolToMyProducts();">&raquo;</a>
                            <?php
                            } else {
                            ?>
                                <a readonly>&raquo;</a>
                            <?php
                            }
                            ?>
                        </div>
                    </td>

                </tr>
            <?php
            } else {
            ?>
                <div class="d-flex justify-content-center">
                    <h6>Not Found!</h6>
                </div>
            <?php
            }
            ?>

        </table>
    </body>

    </html>

<?php
} else {
    echo "Please Sign In or Register.";
}
