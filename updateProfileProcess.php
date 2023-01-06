<?php

session_start();

require "connection.php";

if (isset($_SESSION["user"])) {
    $fname = $_POST["fname"];
    $lname = $_POST["lname"];


    if (empty($_POST["fname"])) {
        echo "Please Enter Your First name";
    } else if (empty($_POST["lname"])) {
        echo "Please Enter Your Last name";
    } else if (!empty($_POST["mobile"]) && !preg_match("/[0|0094|94|+94][7][1|2|4|5|6|7|8][0-9]{7}$/", $_POST["mobile"])) {
        echo "Invalid mobile number";
    } else if (isset($_POST["addressline1_1"]) && !empty($_POST["addressline1_1"]) && $_POST["city1"] == 0) {
        echo "Complete Your Address 1";
    } else if (isset($_POST["addressline1_2"]) && !empty($_POST["addressline1_2"]) && $_POST["city2"] == 0) {
        echo "Complete Your Address 2";
    } else if (isset($_POST["addressline1_3"]) && !empty($_POST["addressline1_3"]) && $_POST["city3"] == 0) {
        echo "Complete Your Address 3";
    } else {

        $resultset1 = Database::search("SELECT * FROM `user_has_address` WHERE `email`= '" . $_SESSION["user"]["email"] . "';");
        $rows1 = $resultset1->num_rows;

        $addressId1 = null;
        $addressId2 = null;
        $addressId3 = null;

        for ($y = 0; $y < $rows1; $y++) {
            $dataset1 = $resultset1->fetch_assoc();
            if ($y == 0) {
                $addressId1 = $dataset1["id"];
            } else if ($y == 1) {
                $addressId2 = $dataset1["id"];
            } else if ($y == 2) {
                $addressId3 = $dataset1["id"];
            }
        }

        if ($y == 0) {
            if (isset($_POST["addressline1_1"]) && !empty($_POST["addressline1_1"]) && $_POST["city1"] != 0) {
                $addressline1_1 = $_POST["addressline1_1"];
                if (empty($_POST["addressline2_1"])) {
                    $city1 = $_POST["city1"];
                    Database::iud("INSERT INTO `user_has_address`(`email`,`line1`,`city_id`) VALUES ('" . $_SESSION["user"]["email"] . "','" . $addressline1_1 . "','" . $city1 . "');");
                } else {
                    $addressline2_1 = $_POST["addressline2_1"];
                    $city1 = $_POST["city1"];
                    Database::iud("INSERT INTO `user_has_address`(`email`,`line1`,`line2`,`city_id`) VALUES ('" . $_SESSION["user"]["email"] . "','" . $addressline1_1 . "','" . $addressline2_1 . "','" . $city1 . "');");
                }
            }
            if (isset($_POST["addressline1_2"]) && !empty($_POST["addressline1_2"]) && $_POST["city2"] != 0) {
                $addressline1_2 = $_POST["addressline1_2"];
                if (empty($_POST["addressline2_2"])) {
                    $city2 = $_POST["city2"];
                    Database::iud("INSERT INTO `user_has_address`(`email`,`line1`,`city_id`) VALUES ('" . $_SESSION["user"]["email"] . "','" . $addressline1_2 . "','" . $city2 . "');");
                } else {
                    $addressline2_2 = $_POST["addressline2_2"];
                    $city2 = $_POST["city2"];
                    Database::iud("INSERT INTO `user_has_address`(`email`,`line1`,`line2`,`city_id`) VALUES ('" . $_SESSION["user"]["email"] . "','" . $addressline1_2 . "','" . $addressline2_2 . "','" . $city2 . "');");
                }
            }
            if (isset($_POST["addressline1_3"]) && !empty($_POST["addressline1_3"]) && $_POST["city3"] != 0) {
                $addressline1_3 = $_POST["addressline1_3"];
                if (empty($_POST["addressline2_3"])) {
                    $city3 = $_POST["city3"];
                    Database::iud("INSERT INTO `user_has_address`(`email`,`line1`,`city_id`) VALUES ('" . $_SESSION["user"]["email"] . "','" . $addressline1_3 . "','" . $city3 . "');");
                } else {
                    $addressline2_3 = $_POST["addressline2_3"];
                    $city3 = $_POST["city3"];
                    Database::iud("INSERT INTO `user_has_address`(`email`,`line1`,`line2`,`city_id`) VALUES ('" . $_SESSION["user"]["email"] . "','" . $addressline1_3 . "','" . $addressline2_3 . "','" . $city3 . "');");
                }
            }
        } else if ($y == 1) {
            if (isset($_POST["addressline1_1"]) && !empty($_POST["addressline1_1"]) && $_POST["city1"] != 0) {
                $addressline1_1 = $_POST["addressline1_1"];
                if (empty($_POST["addressline2_1"])) {
                    $city1 = $_POST["city1"];
                    Database::iud("UPDATE `user_has_address` SET `email`='" . $_SESSION["user"]["email"] . "',`line1`='" . $addressline1_1 . "',`city_id`='" . $city1 . "' WHERE `id`='" . $addressId1 . "';");
                } else {
                    $addressline2_1 = $_POST["addressline2_1"];
                    $city1 = $_POST["city1"];
                    Database::iud("UPDATE `user_has_address` SET `email`='" . $_SESSION["user"]["email"] . "',`line1`='" . $addressline1_1 . "',`line2`='" . $addressline2_1 . "',`city_id`='" . $city1 . "' WHERE `id`='" . $addressId1 . "';");
                }
            } else {
                Database::iud("DElETE FROM `user_has_address` WHERE `id`='" . $addressId1 . "';");
            }
            if (isset($_POST["addressline1_2"]) && !empty($_POST["addressline1_2"]) && $_POST["city2"] != 0) {
                $addressline1_2 = $_POST["addressline1_2"];
                if (empty($_POST["addressline2_2"])) {
                    $city2 = $_POST["city2"];
                    Database::iud("INSERT INTO `user_has_address`(`email`,`line1`,`city_id`) VALUES ('" . $_SESSION["user"]["email"] . "','" . $addressline1_2 . "','" . $city2 . "');");
                } else {
                    $addressline2_2 = $_POST["addressline2_2"];
                    $city2 = $_POST["city2"];
                    Database::iud("INSERT INTO `user_has_address`(`email`,`line1`,`line2`,`city_id`) VALUES ('" . $_SESSION["user"]["email"] . "','" . $addressline1_2 . "','" . $addressline2_2 . "','" . $city2 . "');");
                }
            }
            if (isset($_POST["addressline1_3"]) && !empty($_POST["addressline1_3"]) && $_POST["city3"] != 0) {
                $addressline1_3 = $_POST["addressline1_3"];
                if (empty($_POST["addressline2_3"])) {
                    $city3 = $_POST["city3"];
                    Database::iud("INSERT INTO `user_has_address`(`email`,`line1`,`city_id`) VALUES ('" . $_SESSION["user"]["email"] . "','" . $addressline1_3 . "','" . $city3 . "');");
                } else {
                    $addressline2_3 = $_POST["addressline2_3"];
                    $city3 = $_POST["city3"];
                    Database::iud("INSERT INTO `user_has_address`(`email`,`line1`,`line2`,`city_id`) VALUES ('" . $_SESSION["user"]["email"] . "','" . $addressline1_3 . "','" . $addressline2_3 . "','" . $city3 . "');");
                }
            }
        } else if ($y == 2) {
            if (isset($_POST["addressline1_1"]) && !empty($_POST["addressline1_1"]) && $_POST["city1"] != 0) {
                $addressline1_1 = $_POST["addressline1_1"];
                if (empty($_POST["addressline2_1"])) {
                    $city1 = $_POST["city1"];
                    Database::iud("UPDATE `user_has_address` SET `email`='" . $_SESSION["user"]["email"] . "',`line1`='" . $addressline1_1 . "',`city_id`='" . $city1 . "' WHERE `id`='" . $addressId1 . "';");
                } else {
                    $addressline2_1 = $_POST["addressline2_1"];
                    $city1 = $_POST["city1"];
                    Database::iud("UPDATE `user_has_address` SET `email`='" . $_SESSION["user"]["email"] . "',`line1`='" . $addressline1_1 . "',`line2`='" . $addressline2_1 . "',`city_id`='" . $city1 . "' WHERE `id`='" . $addressId1 . "';");
                }
            } else {
                Database::iud("DElETE FROM `user_has_address` WHERE `id`='" . $addressId1 . "';");
            }
            if (isset($_POST["addressline1_2"]) && !empty($_POST["addressline1_2"]) && $_POST["city2"] != 0) {
                $addressline1_2 = $_POST["addressline1_2"];
                if (empty($_POST["addressline2_2"])) {
                    $city2 = $_POST["city2"];
                    Database::iud("UPDATE `user_has_address` SET `email`='" . $_SESSION["user"]["email"] . "',`line1`='" . $addressline1_2 . "',`city_id`='" . $city2 . "' WHERE `id`='" . $addressId2 . "';");
                } else {
                    $addressline2_2 = $_POST["addressline2_2"];
                    $city2 = $_POST["city2"];
                    Database::iud("UPDATE `user_has_address` SET `email`='" . $_SESSION["user"]["email"] . "',`line1`='" . $addressline1_2 . "',`line2`='" . $addressline2_2 . "',`city_id`='" . $city2 . "' WHERE `id`='" . $addressId2 . "';");
                }
            } else {
                Database::iud("DElETE FROM `user_has_address` WHERE `id`='" . $addressId2 . "';");
            }
            if (isset($_POST["addressline1_3"]) && !empty($_POST["addressline1_3"]) && $_POST["city3"] != 0) {
                $addressline1_3 = $_POST["addressline1_3"];
                if (empty($_POST["addressline2_3"])) {
                    $city3 = $_POST["city3"];
                    Database::iud("INSERT INTO `user_has_address`(`email`,`line1`,`city_id`) VALUES ('" . $_SESSION["user"]["email"] . "','" . $addressline1_3 . "','" . $city3 . "');");
                } else {
                    $addressline2_3 = $_POST["addressline2_3"];
                    $city3 = $_POST["city3"];
                    Database::iud("INSERT INTO `user_has_address`(`email`,`line1`,`line2`,`city_id`) VALUES ('" . $_SESSION["user"]["email"] . "','" . $addressline1_3 . "','" . $addressline2_3 . "','" . $city3 . "');");
                }
            }
        } else if ($y == 3) {
            if (isset($_POST["addressline1_1"]) && !empty($_POST["addressline1_1"]) && $_POST["city1"] != 0) {
                $addressline1_1 = $_POST["addressline1_1"];
                if (empty($_POST["addressline2_1"])) {
                    $city1 = $_POST["city1"];
                    Database::iud("UPDATE `user_has_address` SET `email`='" . $_SESSION["user"]["email"] . "',`line1`='" . $addressline1_1 . "',`city_id`='" . $city1 . "' WHERE `id`='" . $addressId1 . "';");
                } else {
                    $addressline2_1 = $_POST["addressline2_1"];
                    $city1 = $_POST["city1"];
                    Database::iud("UPDATE `user_has_address` SET `email`='" . $_SESSION["user"]["email"] . "',`line1`='" . $addressline1_1 . "',`line2`='" . $addressline2_1 . "',`city_id`='" . $city1 . "' WHERE `id`='" . $addressId1 . "';");
                }
            } else {
                Database::iud("DElETE FROM `user_has_address` WHERE `id`='" . $addressId1 . "';");
            }
            if (isset($_POST["addressline1_2"]) && !empty($_POST["addressline1_2"]) && $_POST["city2"] != 0) {
                $addressline1_2 = $_POST["addressline1_2"];
                if (empty($_POST["addressline2_2"])) {
                    $city2 = $_POST["city2"];
                    Database::iud("UPDATE `user_has_address` SET `email`='" . $_SESSION["user"]["email"] . "',`line1`='" . $addressline1_2 . "',`city_id`='" . $city2 . "' WHERE `id`='" . $addressId2 . "';");
                } else {
                    $addressline2_2 = $_POST["addressline2_2"];
                    $city2 = $_POST["city2"];
                    Database::iud("UPDATE `user_has_address` SET `email`='" . $_SESSION["user"]["email"] . "',`line1`='" . $addressline1_2 . "',`line2`='" . $addressline2_2 . "',`city_id`='" . $city2 . "' WHERE `id`='" . $addressId2 . "';");
                }
            } else {
                Database::iud("DElETE FROM `user_has_address` WHERE `id`='" . $addressId2 . "';");
            }
            if (isset($_POST["addressline1_3"]) && !empty($_POST["addressline1_3"]) && $_POST["city3"] != 0) {
                $addressline1_3 = $_POST["addressline1_3"];
                if (empty($_POST["addressline2_3"])) {
                    $city3 = $_POST["city3"];
                    Database::iud("UPDATE `user_has_address` SET `email`='" . $_SESSION["user"]["email"] . "',`line1`='" . $addressline1_3 . "',`city_id`='" . $city3 . "' WHERE `id`='" . $addressId3 . "';");
                } else {
                    $addressline2_3 = $_POST["addressline2_3"];
                    $city3 = $_POST["city3"];
                    Database::iud("UPDATE `user_has_address` SET `email`='" . $_SESSION["user"]["email"] . "',`line1`='" . $addressline1_3 . "',`line2`='" . $addressline2_3 . "',`city_id`='" . $city3 . "' WHERE `id`='" . $addressId3 . "';");
                }
            } else {
                Database::iud("DElETE FROM `user_has_address` WHERE `id`='" . $addressId3 . "';");
            }
        }


        if (!empty($_POST["mobile"])) {
            Database::iud("UPDATE `user` SET `mobile`='" . $_POST["mobile"] . "' WHERE `email`='" . $_SESSION["user"]["email"] . "' ;");
            $_SESSION["user"]["mobile"] = $_POST["mobile"];
        }
        if (isset($_POST["gender"]) && $_POST["gender"] != 0) {
            Database::iud("UPDATE `user` SET `gender`='" . $_POST["gender"] . "' WHERE `email`='" . $_SESSION["user"]["email"] . "' ;");
            $_SESSION["user"]["gender"] = $_POST["gender"];
        }

        Database::iud("UPDATE `user` SET `fname`='" . $fname . "', `lname`='" . $lname . "' WHERE `email`='" . $_SESSION["user"]["email"] . "' ;");

        echo "success";

        $_SESSION["user"]["fname"] = $fname;
        $_SESSION["user"]["lname"] = $lname;
    }
} else {
    echo "error";
}


// if (isset($_SESSION["user"])) {
//     $fname = $_POST["fname"];
//     $lname = $_POST["lname"];

//     Database::iud("DELETE FROM `user_has_address` WHERE `email`= '" . $_SESSION["user"]["email"] . "';");

//     if (empty($_POST["fname"])) {
//         echo "Please Enter Your First name";
//     } else if (empty($_POST["lname"])) {
//         echo "Please Enter Your Last name";
//     } else if (!empty($_POST["mobile"]) && !preg_match("/[0|0094|94|+94][7][1|2|4|5|6|7|8][0-9]{7}$/", $_POST["mobile"])) {
//         echo "Invalid mobile number";
//     } else if (isset($_POST["addressline1_1"]) && !empty($_POST["addressline1_1"]) && $_POST["city1"] == 0) {
//         echo "Complete Your Address 1";
//     } else if (isset($_POST["addressline1_2"]) && !empty($_POST["addressline1_2"]) && $_POST["city2"] == 0) {
//         echo "Complete Your Address 2";
//     } else if (isset($_POST["addressline1_3"]) && !empty($_POST["addressline1_3"]) && $_POST["city3"] == 0) {
//         echo "Complete Your Address 3";
//     } else {
//         if (isset($_POST["addressline1_1"]) && !empty($_POST["addressline1_1"]) && $_POST["city1"] != 0) {
//             $addressline1_1 = $_POST["addressline1_1"];
//             if (empty($_POST["addressline2_1"])) {
//                 $city1 = $_POST["city1"];
//                 Database::iud("INSERT INTO `user_has_address`(`email`,`line1`,`city_id`) VALUES ('" . $_SESSION["user"]["email"] . "','" . $addressline1_1 . "','" . $city1 . "');");
//             } else {
//                 $addressline2_1 = $_POST["addressline2_1"];
//                 $city1 = $_POST["city1"];
//                 Database::iud("INSERT INTO `user_has_address`(`email`,`line1`,`line2`,`city_id`) VALUES ('" . $_SESSION["user"]["email"] . "','" . $addressline1_1 . "','" . $addressline2_1 . "','" . $city1 . "');");
//             }
//         }
//         if (isset($_POST["addressline1_2"]) && !empty($_POST["addressline1_2"]) && $_POST["city2"] != 0) {
//             $addressline1_2 = $_POST["addressline1_2"];
//             if (empty($_POST["addressline2_2"])) {
//                 $city2 = $_POST["city2"];
//                 Database::iud("INSERT INTO `user_has_address`(`email`,`line1`,`city_id`) VALUES ('" . $_SESSION["user"]["email"] . "','" . $addressline1_2 . "','" . $city2 . "');");
//             } else {
//                 $addressline2_2 = $_POST["addressline2_2"];
//                 $city2 = $_POST["city2"];
//                 Database::iud("INSERT INTO `user_has_address`(`email`,`line1`,`line2`,`city_id`) VALUES ('" . $_SESSION["user"]["email"] . "','" . $addressline1_2 . "','" . $addressline2_2 . "','" . $city2 . "');");
//             }
//         }
//         if (isset($_POST["addressline1_3"]) && !empty($_POST["addressline1_3"]) && $_POST["city3"] != 0) {
//             $addressline1_3 = $_POST["addressline1_3"];
//             if (empty($_POST["addressline2_3"])) {
//                 $city3 = $_POST["city3"];
//                 Database::iud("INSERT INTO `user_has_address`(`email`,`line1`,`city_id`) VALUES ('" . $_SESSION["user"]["email"] . "','" . $addressline1_3 . "','" . $city3 . "');");
//             } else {
//                 $addressline2_3 = $_POST["addressline2_3"];
//                 $city3 = $_POST["city3"];
//                 Database::iud("INSERT INTO `user_has_address`(`email`,`line1`,`line2`,`city_id`) VALUES ('" . $_SESSION["user"]["email"] . "','" . $addressline1_3 . "','" . $addressline2_3 . "','" . $city3 . "');");
//             }
//         }
//         if (!empty($_POST["mobile"])) {
//             Database::iud("UPDATE `user` SET `mobile`='" . $_POST["mobile"] . "' WHERE `email`='" . $_SESSION["user"]["email"] . "' ;");
//             $_SESSION["user"]["mobile"] = $_POST["mobile"];
//         }
//         if (isset($_POST["gender"]) && $_POST["gender"] != 0) {
//             Database::iud("UPDATE `user` SET `gender`='" . $_POST["gender"] . "' WHERE `email`='" . $_SESSION["user"]["email"] . "' ;");
//             $_SESSION["user"]["gender"] = $_POST["gender"];
//         }

//         Database::iud("UPDATE `user` SET `fname`='" . $fname . "', `lname`='" . $lname . "' WHERE `email`='" . $_SESSION["user"]["email"] . "' ;");

//         echo "success";

//         $_SESSION["user"]["fname"] = $fname;
//         $_SESSION["user"]["lname"] = $lname;
//     }
// } else {
//     echo "error";
// }
