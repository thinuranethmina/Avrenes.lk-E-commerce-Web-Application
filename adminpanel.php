<?php

session_start();

require "connection.php";

if (isset($_SESSION["user"]) && $_SESSION["user"]["user_type_id"] == '1') {
?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>avrence | Admin Pannel</title>
        <link rel="icon" href="resources/icon.png" />
        <link rel="stylesheet" href="style.css">
        <link rel="stylesheet" href="bootstrap.css">
    </head>

    <body>
        <div class="container-fluid">
            <div class="row">

                <div class="col-12 col-lg-2">
                    <div class="row">

                        <div class="align-items-start bg-dark col-12">
                            <div class="row g-1 text-center mb-4">

                                <div class="col-12 mt-5">
                                    <h4 class="text-white">
                                        <?php echo $_SESSION["user"]["fname"] . " " . $_SESSION["user"]["lname"]; ?>
                                    </h4>
                                    <hr class="border border-1 border-white">
                                </div>
                                <div class="nav flex-column nav-pills me-3 mt-4">
                                    <nav class="nav flex-column">
                                        <a class="nav-link fs-5" target="_blank" href="addproduct.php">Add Product</a>
                                        <a class="nav-link fs-5" target="_blank" href="myproducts.php">Manage Product</a>
                                        <a class="nav-link fs-5" target="_blank" href="adminmessage.php">Message</a>
                                        <a class="nav-link fs-5" target="_blank" href="sellingHistory.php">Selling History</a>
                                        <a class="nav-link fs-5" onclick="signOut();"> Sign Out</a>

                                    </nav>
                                </div>

                            </div>
                        </div>

                    </div>

                </div>
                <div class="col-12 col-lg-10">
                    <div class="row">
                        <div class="col-12 col-lg-12">

                            <div class="row">
                                <div class="col-6 mt-2 col-lg-5">
                                    <h2 class="fw-bold"> Dashbord</h2>
                                </div>

                            </div>
                        </div>

                        <div class="col-12">
                            <hr />
                        </div>
                        <div class="col-12">
                            <div class="row g-1">
                                <?php
                                $today = date("Y-m-d");

                                $this_month = date("m");
                                $this_year = date("Y");

                                $a = "0";
                                $b = "0";
                                $c = "0";
                                $d = "0";
                                $e = 0;

                                $mycount = 0;

                                $invoice_rs = Database::search("SELECT * FROM `invoice`");
                                $invoice_num = $invoice_rs->num_rows;

                                for ($x = 0; $x < $invoice_num; $x++) {
                                    $invoice_data =  $invoice_rs->fetch_assoc();

                                    $mycount += intval($invoice_data["qty"]);

                                    $f = $invoice_data["date_time"];

                                    $split_date = explode(" ", $f);
                                    $pdate = $split_date[0];

                                    if ($pdate == $today) {
                                        $a = $a + $invoice_data["price"] * $invoice_data["qty"];
                                        $c = $c + $invoice_data["qty"];
                                    }
                                    $split_result = explode("-", $pdate);

                                    $pyear = $split_result[0];
                                    $pmonth = $split_result[1];



                                    if ($pyear == $this_year) {

                                        if ($pmonth == $this_month) {

                                            $b = $b + $invoice_data["price"] * $invoice_data["qty"];
                                            $d = $d + $invoice_data["qty"];
                                        }
                                    }
                                }

                                ?>


                                <div class="col-6 col-lg-6 px-1 border border-1">
                                    <div class="row g-1">
                                        <div class="col-12 bg-white text-dark text-center rounded " style="height: 100px;">
                                            <br>
                                            <span class="fs-4 fw-bold">Monthly Earnings</span>
                                            <br>
                                            <span class="fs-5">Rs.<?php echo $b ?>.00</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-lg-6 px-1">
                                    <div class="row g-1">
                                        <div class="col-12 bg-dark text-white text-center rounded " style="height: 100px;">
                                            <br>
                                            <span class="fs-4  fw-bold">Total Sellings Earnings</span>
                                            <br>
                                            <span class="fs-5 "><?php echo $c ?> Items</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-6 col-lg-4 px-1">
                                    <div class="row g-1">
                                        <div class="col-12 bg-secondary text-white text-center rounded " style="height: 100px;">
                                            <br>
                                            <span class="fs-4 fw-bold">Monthly Sellings </span>
                                            <br>
                                            <span class="fs-5"><?php echo $d ?> Items</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-lg-4 px-1">
                                    <div class="row g-1">
                                        <div class="col-12 bg-success text-white text-center rounded " style="height: 100px;">
                                            <br>
                                            <span class="fs-4 fw-bold">Total Sellings </span>
                                            <br>
                                            <span class="fs-5"><?php echo $mycount ?> Items</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-6 col-lg-4 px-1">
                                    <div class="row g-1">
                                        <div class="col-12 bg-danger text-white text-center rounded " style="height: 100px;">
                                            <br>
                                            <span class="fs-4 fw-bold">Total Engagements </span>
                                            <br>
                                            <?php
                                            $user_rs =  Database::search("SELECT * FROM `user` where `user_type_id` = '2'");
                                            $user_rsn = $user_rs->num_rows;
                                            ?>
                                            <span class="fs-5"><?php echo $user_rsn ?> members</span>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <hr />


                    </div>
                </div>
                <div class="col-112 mt-3 mb-3 text-center bg-light">

                    <img src="resources/chart.jpg" width="80%" alt="chart">

                </div>


            </div>
        </div>
        <script src="script.js"></script>
    </body>

    </html>


<?php
} else {
?>
    <script>
        alert("Please SignIn first.");
        window.location = "adminsignin.php";
    </script>
<?php
}

?>