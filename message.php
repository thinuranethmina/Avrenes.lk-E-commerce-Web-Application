<?php

session_set_cookie_params(60 * 60 * 24 * 30);
session_start();
require "connection.php";

if (isset($_SESSION["user"]) && $_SESSION["user"]["user_type_id"] != '1') {
?>

    <!DOCTYPE html>

    <html>

    <head>

        <title>Messages</title>

        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1" />

        <link rel="icon" href="resources/icon.png" />
        <link rel="stylesheet" href="bootstrap.css" />
        <link rel="stylesheet" href="style.css" />

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css" />
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" />

    </head>

    <?php
    $email = $_SESSION["user"]["email"];

    $message_rs = Database::search("SELECT DISTINCT `to` FROM `message` WHERE `from`='" . $email . "' ORDER BY `date_time` DESC");

    $message_num = $message_rs->num_rows;
    $message_data = $message_rs->fetch_assoc();


    ?>

    <body onload="loadInbox('thinura.dias@gmail.com'); loaderEnd();">

        <div class="container-fluid">
            <div class="row">

                <?php
                require "header.php";
                ?>

                <div class="col-12 py-5 px-4">

                    <div class="row">

                        <div class="col-12 border border-1 align-items-end" id="inbox">
                            <div class="row">
                                <div class="col-12" style="height: 200px; margin-top: 250px;">
                                    <div class="row">
                                        <div class="col-12"></div>
                                        <div class="col-12 text-center mb-2">
                                            <label class="form-label fs-1">Message Box.</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>


                </div>
                <?php require "footer.php"; ?>
            </div>

            <script src="script.js"></script>
    </body>

    </html>
<?php

} else {
    echo "Please Sign In first";
}
