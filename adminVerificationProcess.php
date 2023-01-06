<?php

require "connection.php";

require "SMTP.php";
require "Exception.php";
require "PHPMailer.php";

use PHPMailer\PHPMailer\PHPMailer;


if (!isset($_GET["email"]) && empty($email)) {
    echo "Please enter email";
} else {
    $email = $_GET["email"];
    $rs = Database::search("SELECT * FROM `user` WHERE `email`='" . $email . "';");
    if ($rs->num_rows == 1) {

        $code = mt_rand($min = 10000, $max = 100000000);

        $rs = Database::iud("UPDATE `user` SET `verification_code`='" . $code . "' WHERE  `email`='" . $email . "';");

        $mail = new PHPMailer;
        $mail->IsSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = '2001thinura.dias@gmail.com';
        $mail->Password = 'gpxnntldbywyhwlu';
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;
        $mail->setFrom('2001thinura.dias@gmail.com', 'avrenes');
        $mail->addReplyTo('2001thinura.dias@gmail.com', 'avrenes');
        $mail->addAddress($email);
        $mail->isHTML(true);
        $mail->Subject = 'avrenes Admin Verification Code.';
        $bodyContent = '<h1 style="color:red">Your Vetification code is : ' . $code . '</h1><p>Submit it.</p>';
        $mail->Body    = $bodyContent;

        if (!$mail->send()) {
            echo 'Verification code sending failed. Please try againg...';
        } else {
            echo 'Success';
        }
    } else {
        echo "Email Address not found";
    }
}
