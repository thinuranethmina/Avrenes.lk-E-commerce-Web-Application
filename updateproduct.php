<?php

session_set_cookie_params(60 * 60 * 24 * 30);
session_start();
require "connection.php";

if (isset($_SESSION["user"]) && $_SESSION["user"]["user_type_id"] == '1') {

    $productrs = Database::search("SELECT product.id,product.warranty,product.discount,product.category_id,product.model_has_brand_id,product.title,
    color.name AS color,product.price,product.qty,product.description,product.condition_id,
    product.status_id,product.user_email,product.datetime_added,product.delivery_fee_colombo,
    product.delivery_fee_other,model.name AS `mname`,brand.name AS `bname`
    FROM product INNER JOIN model_has_brand ON model_has_brand.id = product.model_has_brand_id 
    INNER JOIN brand ON brand.id=model_has_brand.brand_id 
    INNER JOIN model ON model_has_brand.model_id = model.id 
    INNER JOIN color ON color.id = product.color_id 
    WHERE product.id = '" . $_GET["id"] . "'");

    $product = $productrs->fetch_assoc();
?>
    <!DOCTYPE html>

    <html>

    <head>
        <title>avrence | Add Product</title>

        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1" />

        <link rel="icon" href="resources/icon.png" />
        <link rel="stylesheet" href="bootstrap.css" />
        <link rel="stylesheet" href="style.css" />

    </head>

    <body>

        <div class="container-fluid">
            <div class="row gy-3">

                <div class="col-12 mt-5">
                    <div class="row">

                        <div class="col-12 text-center">
                            <h2 class="h2 text-primary m-3 fw-bold">Add New Product</h2>
                        </div>

                        <div class="col-lg-12">
                            <div class="row p-3">

                                <div class="card-content round rounded-4 border-4 p-3 my-2 col-12 col-lg-4">
                                    <div class="row">
                                        <div class="col-12">
                                            <label class="form-label fw-bold lbl1">Select Product Category</label>
                                        </div>
                                        <div class="col-12 mb-3">
                                            <select class="form-select" id="category" disabled>
                                                <option value="0">Select Category</option>

                                                <?php

                                                $category_rs = Database::search("SELECT * FROM `category`");
                                                $category_num = $category_rs->num_rows;

                                                for ($x = 0; $x < $category_num; $x++) {
                                                    $category_data = $category_rs->fetch_assoc();

                                                ?>

                                                    <option value="<?php echo $category_data["id"] ?>" <?php if ($product["category_id"] == $category_data["id"]) {
                                                                                                            echo "selected";
                                                                                                        } ?>><?php echo $category_data["name"]; ?></option>

                                                <?php

                                                }

                                                ?>

                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-content round rounded-4 border-4 my-2 p-3 col-12 col-lg-4">
                                    <div class="row">
                                        <div class="col-12">
                                            <label class="form-label fw-bold lbl1">Select Product Brand</label>
                                        </div>
                                        <div class="col-12 mb-3">
                                            <select class="form-select" id="brand" disabled>
                                                <option value="0">Select Brand</option>

                                                <?php
                                                $brand_rs = Database::search("SELECT * FROM `brand`");
                                                $brand_num = $brand_rs->num_rows;

                                                for ($y = 0; $y < $brand_num; $y++) {
                                                    $brand_data = $brand_rs->fetch_assoc();

                                                ?>
                                                    <option value="<?php echo $brand_data["id"]; ?>" <?php if ($product["bname"] == $brand_data["name"]) {
                                                                                                            echo "selected";
                                                                                                        } ?>><?php echo $brand_data["name"]; ?></option>
                                                <?php

                                                }

                                                ?>

                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class=" card-content round rounded-4 my-2 border-4 p-3 col-12 col-lg-4">
                                    <div class="row">
                                        <div class="col-12">
                                            <label class="form-label fw-bold lbl1">Select Product Model</label>
                                        </div>
                                        <div class="col-12 mb-3">
                                            <select class="form-select" id="model" disabled>
                                                <option value="0">Select Model</option>

                                                <?php

                                                $model_rs = Database::search("SELECT * FROM `model`");
                                                $model_num = $model_rs->num_rows;

                                                for ($z = 0; $z < $model_num; $z++) {
                                                    $model_data = $model_rs->fetch_assoc();

                                                ?>
                                                    <option value="<?php echo $model_data["id"]; ?>" <?php if ($product["mname"] == $model_data["name"]) {
                                                                                                            echo "selected";
                                                                                                        } ?>><?php echo $model_data["name"]; ?></option>
                                                <?php

                                                }

                                                ?>

                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 mb-3 mt-3">
                                    <div class="card-content round rounded-4  border-4 p-3 row pb-4">
                                        <div class="col-12 d-grid">
                                            <b>Title</b>
                                            <input type="text" class="form-control" value="<?= $product['title'] ?>" id="title" />
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="row">

                                        <div class="card-content round rounded-4 my-2 border-4 p-3 col-12 col-lg-4">
                                            <div class="row">
                                                <div class="col-12">
                                                    <label class="form-label fw-bold lbl1">Select Product Condition</label>
                                                </div>
                                                <div class="offset-1 col-11 col-lg-3 ms-5 form-check">
                                                    <input disabled class="form-check-input" type="radio" name="condition" id="bn" <?php if ($product['condition_id'] == '1') {
                                                                                                                                        echo "checked";
                                                                                                                                    } ?> />
                                                    <label class="form-check-label" for="bn">
                                                        Brand new
                                                    </label>
                                                </div>
                                                <div class="offset-1 col-11 col-lg-3 ms-5 form-check">
                                                    <input disabled class="form-check-input" type="radio" name="condition" id="us" <?php if ($product['condition_id'] == '2') {
                                                                                                                                        echo "checked";
                                                                                                                                    } ?> />
                                                    <label class="form-check-label" for="us">
                                                        Used
                                                    </label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="card-content round rounded-4 my-2 border-4 p-3 col-12 col-lg-4">
                                            <div class="row">

                                                <div class="col-12">
                                                    <label class="form-label lbl1 fw-bold">Select Product Colour</label>
                                                </div>
                                                <div class="col-12">
                                                    <div class="row">
                                                        <?php

                                                        $color_rs = Database::search("SELECT * FROM `color`");
                                                        $color_num = $color_rs->num_rows;

                                                        for ($z = 0; $z < $color_num; $z++) {
                                                            $color_data = $color_rs->fetch_assoc();

                                                        ?>
                                                            <div class="form-check offset-1 offset-lg-0 col-5 col-lg-4">
                                                                <input disabled class="form-check-input" type="radio" name="clrradio" id="c<?= $color_data["id"] ?>" <?php if ($color_data['name'] == $product["color"]) {
                                                                                                                                                                            echo "checked";
                                                                                                                                                                        } ?>>
                                                                <label class="form-check-label" for="c<?= $color_data["id"] ?>">
                                                                    <?= $color_data["name"] ?>
                                                                </label>
                                                            </div>
                                                        <?php

                                                        }

                                                        ?>

                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                        <div class="card-content round rounded-4 my-2 border-4 p-3 col-12 col-lg-2">
                                            <div class="row">

                                                <label class="form-label fw-bold lbl1">Add Product Quantity</label>
                                                <input type="number" class="form-control" value="<?= $product['qty'] ?>" min="0" id="qty" />

                                            </div>
                                        </div>

                                        <div class="card-content round rounded-4 my-2 border-4 p-3 col-12 col-lg-2">
                                            <div class="row">

                                                <label class="form-label fw-bold lbl1">Warranty</label>
                                                <input type="number" class="form-control" value="<?= $product['warranty'] ?>" min="0" id="warranty" />

                                            </div>
                                        </div>

                                    </div>
                                </div>

                            </div>

                            <div class="col-12">
                                <div class="row p-3">

                                    <div class="card-content round rounded-4 my-2 border-4 p-3 col-12 col-lg-3">
                                        <div class="row">

                                            <div class="col-12">
                                                <label class="form-label fw-bold">After discount Price</label>
                                            </div>
                                            <div class="input-group mb-3">
                                                <span class="input-group-text">Rs.</span>
                                                <input type="text" class="form-control" aria-label="Amount (to the nearest rupee)" value="<?= $product['price'] ?>" id="cost">
                                            </div>

                                        </div>
                                    </div>

                                    <div class="card-content round rounded-4 my-2 border-4 p-3 col-12 col-lg-3">
                                        <div class="row">

                                            <div class="col-12">
                                                <label class="form-label fw-bold">Discount</label>
                                            </div>
                                            <div class="input-group mb-3">
                                                <input type="number" value="<?= $product['discount'] ?>" min="0" max="100" class="form-control" aria-label="Amount (to the nearest rupee)" id="discount">
                                                <span class="input-group-text">%</span>
                                            </div>

                                        </div>
                                    </div>


                                    <div class="card-content round rounded-4 my-2 border-4 p-3 col-12 col-lg-3">
                                        <div class="row">

                                            <div class="col-12 form-label fw-bold">
                                                <label>Delivery Cost Within Colombo</label>
                                            </div>
                                            <div class="col-12 ">
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text">Rs.</span>
                                                    <input type="text" class="form-control" aria-label="Amount (to the nearest rupee)" id="dwc" value="<?= $product['delivery_fee_colombo'] ?>">
                                                </div>
                                            </div>


                                        </div>
                                    </div>

                                    <div class="card-content round rounded-4 my-2 border-4 p-3 col-12 col-lg-3">
                                        <div class="row">

                                            <div class="col-12 form-label fw-bold">
                                                <label>Delivery Cost Out Of Colombo</label>
                                            </div>
                                            <div class="col-12">
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text">Rs.</span>
                                                    <input type="text" class="form-control" aria-label="Amount (to the nearest rupee)" value="<?= $product['delivery_fee_other'] ?>" id="doc">
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="col-12 p-3">
                                <div class="card-content round rounded-4 border-4 p-3 pb-4 row">

                                    <div class="col-12">
                                        <label class="form-label fw-bold lbl1">Product Description</label>
                                    </div>
                                    <div class="col-12">
                                        <textarea class="form-control" cols="30" rows="10" id="description"><?= $product['description'] ?></textarea>
                                    </div>

                                </div>
                            </div>

                            <div class="col-12 p-3">
                                <div class="card-content round rounded-4  border-4 p-3 row">

                                    <div class="col-12">
                                        <label class="form-label fw-bold lbl1">Add Product Images</label>
                                    </div>
                                    <div class="offset-lg-3 col-12 col-lg-6">
                                        <div class="row">
                                            <?php
                                            $imagers = Database::search("SELECT * FROM images INNER JOIN product ON product.id = images.product_id WHERE product.id= '" . $_GET["id"] . "' ");

                                            $in = $imagers->num_rows;
                                            $img;

                                            for ($x = 0; $x < $in; $x++) {
                                                $d = $imagers->fetch_assoc();
                                            ?>
                                                <div class="col-4 border border-primary rounded">
                                                    <img class="img-fluid" src="<?= $d["code"] ?>" id="preview<?= $x ?>" style="width: 250px;" />
                                                </div>
                                            <?php
                                            }
                                            ?>
                                        </div>
                                    </div>

                                    <div class="col-12 offset-lg-3 col-lg-6 d-grid mt-3">

                                        <div class="row">
                                            <div class="col-4">
                                                <input type="file" accept="img/*" class="d-none" id="imageUploder1" />
                                                <label for="imageUploder1" class="col-12 btn btn-primary" onclick="changeProductImg1();">Upload Image1</label>
                                            </div>
                                            <div class="col-4">
                                                <input type="file" accept="img/*" class="d-none" id="imageUploder2" />
                                                <label for="imageUploder2" class="col-12 btn btn-primary" onclick="changeProductImg2();">Upload Image2</label>
                                            </div>
                                            <div class="col-4">
                                                <input type="file" accept="img/*" class="d-none" id="imageUploder3" />
                                                <label for="imageUploder3" class="col-12 btn btn-primary" onclick="changeProductImg3();">Upload Image3</label>
                                            </div>
                                        </div>

                                    </div>

                                </div>
                            </div>

                            <hr class="hr-break-1" />

                            <div class="offset-lg-4 col-12 col-lg-4 d-grid mb-3 mt-2">
                                <button class="btn btn-success fw-bold" onclick="changeProduct('<?= $_GET['id'] ?>');">Update Product</button>
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

                <?php require "footer.php"; ?>

            </div>
        </div>

        <script src="script.js"></script>
    </body>

    </html>

<?php

} else {

    header("location:index.php");
}

?>