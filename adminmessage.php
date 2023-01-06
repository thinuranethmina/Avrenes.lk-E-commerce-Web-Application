<?php

session_set_cookie_params(60 * 60 * 24 * 30);
session_start();
require "connection.php";

if (isset($_SESSION["user"])) {
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

    <body>

        <div class="container-fluid">
            <div class="row">

                <?php
                require "header.php";
                $email = $_SESSION["user"]["email"];

                $message_rs = Database::search("SELECT DISTINCT `from` FROM `message` WHERE `to`='" . $email . "' ORDER BY `date_time` DESC");

                $message_num = $message_rs->num_rows;
                ?>

                <div class="col-12 py-5 px-4">

                    <div class="row border border-4 border-primary rounded rounded-2">
                        <div class="col-4 bg-light">
                            <div class="row overflow-auto p-2 gy-2" style="max-height: 400px;">
                                <?php
                                for ($x = 0; $x < $message_num; $x++) {
                                    $message_data = $message_rs->fetch_assoc();

                                    $message_rs2 = Database::search("SELECT * FROM `message` WHERE `to`='" . $message_data["from"] . "' OR `from`='" . $message_data["from"] . "' ORDER BY `date_time` DESC");

                                    $message_data2 = $message_rs2->fetch_assoc();
                                    $sendData = 0;
                                    if ($message_data2["from"] == 'thinura.dias@gmail.com') {
                                        $sendData = $message_data2["to"];
                                        $user_rs = Database::search("SELECT * FROM `user`  WHERE `email`='" . $message_data2["to"] . "'");
                                    } else {
                                        $sendData = $message_data2["from"];
                                        $user_rs = Database::search("SELECT * FROM `user`  WHERE `email`='" . $message_data2["from"] . "'");
                                    }


                                    $user_data = $user_rs->fetch_assoc();

                                ?>

                                    <div class="col-12 border border-1 bg-white p-3 " onclick="loadInbox('<?= $sendData ?>');" style="cursor: pointer;">
                                        <div class="row">
                                            <div class="col-1 my-auto">
                                                <img src="<?php echo $user_data["profile_img"]; ?>" width="30px" class="rounded-circle" />
                                            </div>
                                            <div class="col-11 ps-4">
                                                <h6 class=""><?php echo $user_data["fname"] . " " . $user_data["lname"]; ?></h6>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="row">
                                                    <div class="col-8 p-2">
                                                        <p class="d-inline-block mb-0 text-start"><?php echo $message_data2["content"]; ?></p>
                                                    </div>
                                                    <div class="col-4 text-end">
                                                        <span class="small fw-bold"><?php echo $message_data2["date_time"]; ?></span>
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
                        <div class="col-8 border border-1 align-items-end" id="inbox">
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
