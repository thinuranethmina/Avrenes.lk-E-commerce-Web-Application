<?php

session_set_cookie_params(60 * 60 * 24 * 30);
session_start();
require "connection.php";

if (isset($_SESSION["user"])) {

    $reciver = $_POST["reciver"];

    $email = $_SESSION["user"]["email"];

    $message_rs = Database::search("SELECT `to`,`from`,`content`,`date_time`,`status` FROM `message` WHERE `to`='" . $reciver . "' OR `from`='" . $reciver . "' ORDER BY `date_time` ASC");

    $message_num = $message_rs->num_rows;


    for ($x = 0; $x < $message_num; $x++) {
        $message_data = $message_rs->fetch_assoc();

        if ($message_data['to'] == $email) {
?>
            <div class="col-12 text-start p-3">
                <div class="border border-1 p-2">
                    <?= $message_data['content'] ?>
                    <div class="small text-black-50"><?= $message_data['date_time']; ?></div>
                </div>
            </div>
        <?php
        } else {
        ?>
            <div class="col-12 text-end p-2">
                <div class="border border-1 p-2">
                    <?= $message_data['content'] ?>
                    <div class="small text-black-50"><?= $message_data['date_time'] ?></div>
                </div>
            </div>
<?php
        }
    }
} else {
    echo "Please Sign In first";
}

?>