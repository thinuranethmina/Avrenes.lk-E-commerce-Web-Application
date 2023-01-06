<?php

session_set_cookie_params(60 * 60 * 24 * 30);
session_start();
require "connection.php";

if (isset($_SESSION["user"])) {

    $reciver = $_POST["from"];

?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>

    <body onload="chatLoad('<?= $reciver ?>');">
        <div class="row overflow-auto " id="chat" style="height: 400px;">

        </div>
        <div class="row align-content-end">
            <div class="input-group col-12">
                <input type="text" placeholder="Type your message..." aria-describedby="sendbtn" class="form-control rounded-0 border-0 py-3 bg-light" id="msg" />
                <button id="sendbtn" class="btn btn-link fs-2 border border-2 rounded rounded-1" onclick="sendMsg('<?= $reciver ?>');">
                    <img src="https://img.icons8.com/fluency/512/sent.png" style="height: 20px;" />
                </button>
            </div>
        </div>
        <script src="script.js"></script>
    </body>

    </html>
<?php
} else {
    echo "Please Sign In first";
}

?>