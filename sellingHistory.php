<!DOCTYPE html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>avrence | Selling History</title>

    <link rel="icon" href="resources/icon.png" />
    <link rel="stylesheet" href="bootstrap.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.6.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <div class="container-fluid">
        <div class="row">

            <div class="col-12 bg-light text-center mb-3">
                <label class="form-label fs-1 fw-bold text-primary">Selling History</label>
            </div>

            <div class="col-12">
                <div class="row">

                    <div class="col-2 bg-secondary text-end">
                        <label class="form-label fs-5 fw-bold text-white">Invoice ID</label>
                    </div>
                    <div class="col-3 bg-body text-end">
                        <label class="form-label fs-5 fw-bold text-black">Product</label>
                    </div>
                    <div class="col-2 bg-secondary text-end">
                        <label class="form-label fs-5 fw-bold text-white">Buyer</label>
                    </div>
                    <div class="col-2 bg-body text-end">
                        <label class="form-label fs-5 fw-bold text-black">Quantity</label>
                    </div>
                    <div class="col-3 bg-secondary text-end">
                        <label class="form-label fs-5 fw-bold text-white">Amount</label>
                    </div>
                    <div class="col-2 bg-white"></div>

                </div>
            </div>

            <div class="col-12 mt-1">
                <div class="row">
                    <div class="col-12" id="loadResults">

                        <?php
                        session_start();
                        require "connection.php";
                        $history_rs = Database::search("SELECT `invoice`.`order_id`,`invoice`.`price`,`invoice`.`user_email`,`invoice`.`qty`,`product`.`title`  From `invoice`
                            INNER JOIN `product` ON `product`.`id` = `invoice`.`product_id`;");

                        $history_num = $history_rs->num_rows;

                        for ($x = 0; $x < $history_num; $x++) {
                            $history = $history_rs->fetch_assoc();
                        ?>
                            <div class="row">

                                <div class="col-2 bg-secondary text-end">
                                    <label class="form-label fs-5 fw-bold text-white"><?= $history['order_id'] ?></label>
                                </div>
                                <div class="col-3 bg-body text-end">
                                    <label class="form-label fs-5 fw-bold text-black"><?= $history['title'] ?></label>
                                </div>
                                <div class="col-2 bg-body text-end">
                                    <label class="form-label fs-5 fw-bold text-black"><?= $history['user_email'] ?></label>
                                </div>
                                <div class="col-2 bg-body text-end">
                                    <label class="form-label fs-5 fw-bold text-black"><?= $history['qty'] ?></label>
                                </div>
                                <div class="col-3 bg-body text-end">
                                    <label class="form-label fs-5 fw-bold text-black">Rs.<?= $history['price'] ?></label>
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

    <script src="script.js"></script>
</body>

</html>