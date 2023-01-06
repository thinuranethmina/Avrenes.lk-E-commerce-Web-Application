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

        $query = "SELECT  product.id,product.warranty,product.discount,product.category_id,product.model_has_brand_id,product.title,
    color.name AS color,product.price,product.qty,product.description,product.condition_id,
    product.status_id,product.user_email,product.datetime_added,product.delivery_fee_colombo,
    product.delivery_fee_other,model.name AS `mname`,brand.name AS `bname` , `condition`.`name` AS `pcondition`
    FROM product INNER JOIN model_has_brand ON model_has_brand.id = product.model_has_brand_id 
    INNER JOIN brand ON brand.id=model_has_brand.brand_id 
    INNER JOIN model ON model_has_brand.model_id = model.id 
    INNER JOIN `condition` ON `condition`.id = product.condition_id 
    INNER JOIN color ON color.id = product.color_id  WHERE `user_email` = '" . $_SESSION["user"]["email"] . "'";

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
                                        <div class="col-12 p-2 px-4">
                                            <div class="row">

                                                <div class="card-content col-12">
                                                    <div class="row g-0">
                                                        <div class="col-6 offset-3 offset-lg-0 col-lg-5 col-xl-3 p-3 text-center">

                                                            <?php

                                                            $img_rs = Database::search("SELECT * FROM `images` WHERE  `product_id`='" . $dataset1["id"] . "'");
                                                            $img_data = $img_rs->fetch_assoc();

                                                            ?>

                                                            <span class="d-inline-block" tabindex="0" data-bs-toggle="popover" data-bs-trigger="hover focus" data-bs-content="<?php echo $dataset1["description"]; ?>" title="Product Description">
                                                                <img src="<?php echo $img_data["code"]; ?>" class="img-fluid rounded-start" style="max-width: 200px;">
                                                            </span>

                                                        </div>
                                                        <div class="col-12 col-lg-7 col-xl-6">
                                                            <div class="card-body text-center text-lg-start">

                                                                <h3 class="card-title"><a target="_blank" class="text-decoration-none fs-2 text-dark" href="singleProductView.php?id=<?= $dataset1["id"] ?>"><?php echo $dataset1["title"]; ?></a></h3>

                                                                <span class="fw-bold text-black-50">Colour : <?= $dataset1["color"] ?></span> &nbsp; |

                                                                &nbsp; <span class="fw-bold text-black-50">Condition : <?= $dataset1["pcondition"] ?></span>
                                                                <br>
                                                                <span class="fw-bold text-black-50 fs-5">Price :</span>&nbsp;
                                                                <?php
                                                                $afterDiscountPrice = $dataset1["price"];
                                                                $discount = $dataset1["discount"];


                                                                if ($discount == 0) {
                                                                    $trueprice = number_format($dataset1["price"], 2);
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

                                                                if ($dataset1['qty'] < 1) {
                                                                ?>
                                                                    <span class="fw-bold text-danger fs-5">Out Of Stock</span>
                                                                <?php
                                                                } else {
                                                                ?>

                                                                    <span class="fw-bold text-dark fs-5">In Stock</span>
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
                    <td class="text-center" colspan="<?php echo $columns; ?>">
                        <div class="row">
                            <div class="col-12 col-lg-4 offset-lg-4">
                                <div class="pagination text-center">
                                    <?php
                                    $resultset2 = Database::search($query);

                                    $number_of_products = $resultset2->num_rows;

                                    $pages = ceil($number_of_products / $products_per_page);

                                    if ($start != 0) {
                                    ?>
                                        <a onclick="loadproducts2(<?php echo $start - $products_per_page; ?>);scrolToMyProducts();">&laquo;</a>
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
                                            <a onclick="loadproducts2(<?php echo ($t - 1) * $products_per_page; ?>);scrolToMyProducts();"><?php echo $t; ?></a>
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
                            </div>
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
