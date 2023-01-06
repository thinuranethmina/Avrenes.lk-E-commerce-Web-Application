<?php

session_set_cookie_params(60 * 60 * 24 * 30);
session_start();

require "connection.php";

if (isset($_SESSION["user"])) {

?>
    <!DOCTYPE html>
    <html>

    <head>
        <style>
            .hr1 {
                border-style: solid;
                border-width: 0 0 1px;
                border-color: red;
            }
        </style>
    </head>
    <?php
    $fname = $_SESSION["user"]["fname"];
    $lname = $_SESSION["user"]["lname"];
    $email = $_SESSION["user"]["email"];

    $resultset1 = Database::search("SELECT * FROM `user_has_address` WHERE `email`='" . $email . "';");
    $row1 = $resultset1->num_rows;

    ?>

    <body>
        <div class="card-body">

            <div class="row">
                <div class="col-sm-3">
                    <h6 class="mb-0">Full Name</h6>
                </div>
                <br class="d-sm-none" />
                <div class="col-sm-9 text-secondary">
                    <span class="" id="PFVfullname"><?php echo $fname . " " . $lname; ?></span>
                    <div class="row d-none gy-1" id="PFfullname">
                        <div class="col-12 col-lg-6">
                            <input class="form-control" id="fname" style="height: 28px;" spellcheck="false" id="PFfname" value="<?php echo $fname; ?>" type="text" placeholder="Enter Your First Name Here" />
                        </div>
                        <div class="col-12 col-lg-6">
                            <input class="form-control" id="lname" style="height: 28px;" spellcheck="false" id="PFlname" value="<?php echo $lname; ?>" type="text" placeholder="Enter Your Last Name Here" />
                        </div>
                    </div>
                </div>
            </div>
            <hr />
            <div class="row">
                <div class="col-sm-3">
                    <h6 class="mb-0">Email</h6>
                </div>
                <br class="d-sm-none" />
                <div class="col-sm-9 text-secondary">
                    <span id="PFVemail"><?php echo $email; ?></span>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-sm-3">
                    <h6 class="mb-0">Mobile</h6>
                </div>
                <br class="d-sm-none" />
                <?php

                $resultset6 = Database::search("SELECT * FROM `user` WHERE `email` = '" . $email . "' ;");
                $dataset6 = $resultset6->fetch_assoc();

                if ($dataset6["mobile"] == '') {
                ?>
                    <div class="col-sm-9 text-secondary">
                        <span id="PFVmobile">Not Entered</span>
                        <input class="form-control d-none" style="height: 28px;" spellcheck="false" oninput="process(this);" placeholder="Enter Your Mobile Here" id="PFmobile" type="text" />
                    </div>
                <?php
                } else {
                ?>
                    <div class="col-sm-9 text-secondary">
                        <span id="PFVmobile"><?php echo $dataset6["mobile"]; ?></span>
                        <input class="form-control d-none" value="<?php echo $dataset6["mobile"]; ?>" oninput="process(this);" style="height: 28px;" placeholder="Enter Your Mobile Here" id="PFmobile" type="text" />
                    </div>
                <?php
                }
                ?>
            </div>
            <hr />
            <?php

            if (isset($_SESSION["user"]["password"])) {
            ?>
                <div class="row">
                    <div class="col-sm-3">
                        <h6 class="mb-0">Password</h6>
                    </div>
                    <br class="d-sm-none" />
                    <div class="col-sm-9 text-secondary">
                        <input readonly id="password5" style="letter-spacing: 3px;" class="password5" type="password" value="<?php echo $_SESSION["user"]["password"]; ?>">
                        <button class="showpaassword3btn" style="min-width: 70px;" id="passwordSHbtn" onclick="showPassword5();">Show</button>
                        <label class="btn text-primary fw-bold d-none" id="changePWbtn" onclick="changePassword();">Change Password</label>
                    </div>
                </div>
                <hr />
            <?php
            }
            ?>
            <div class="row">
                <div class="col-sm-3">
                    <h6 class="mb-0">Gender</h6>
                </div>
                <br class="d-sm-none" />
                <?php
                if (isset($_SESSION["user"]["gender"])) {
                    $resultset5 = Database::search("SELECT * FROM `gender` WHERE   `id` = '" . $_SESSION["user"]["gender"] . "';");
                    $dataset5 = $resultset5->fetch_assoc();
                ?>

                    <div class="col-sm-9 text-secondary">
                        <span><?php echo $dataset5["name"]; ?></span>
                    </div>
                <?php
                } else {
                ?>

                    <div class="col-sm-9 text-secondary">
                        <span id="PFVgender">Not Entered</span>
                        <select class="d-none form-select form-select-sm" id="PFgender">
                            <option value="0">Select Your Gender(You have only one chance to enter your gender)</option>
                            <?php
                            $resultset8 = Database::search("SELECT * FROM `gender` ;");
                            $row8 = $resultset8->num_rows;

                            for ($y = 0; $y < $row8; $y++) {
                                $dataset8 = $resultset8->fetch_assoc();
                            ?>
                                <option value="<?php echo $dataset8["id"] ?>"><?php echo $dataset8["name"] ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>

                <?php
                }
                ?>
            </div>
            <hr />

            <div class="row">
                <div class="col-12">
                    <table style="width: 100%;" id="addresstable">

                        <?php
                        if ($row1 > 0) {

                        ?>

                            <?php
                            for ($x = 0; $x < $row1; $x++) {

                                $dataset1 = $resultset1->fetch_assoc();
                                $resultset2 = Database::search("SELECT * FROM `city` WHERE `id`='" . $dataset1["city_id"] . "';");
                                $dataset2 = $resultset2->fetch_assoc();
                                $resultset3 = Database::search("SELECT * FROM `district` WHERE `id`='" . $dataset2["district_id"] . "';");
                                $dataset3 = $resultset3->fetch_assoc();
                                $resultset4 = Database::search("SELECT * FROM `province` WHERE `id`='" . $dataset3["province_id"] . "';");
                                $dataset4 = $resultset4->fetch_assoc();

                            ?>

                                <tr>
                                    <td>
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <h6 class="mb-0">Address <?php echo $x + 1; ?></h6>
                                            </div>
                                            <br class="d-sm-none" />
                                            <div class="col-sm-9 text-secondary">
                                                <span id="PFVaddress<?php echo $x + 1; ?>">
                                                    <?php echo $dataset1["line1"] . ", ";
                                                    if ($dataset1["line2"] == null) {
                                                    } else {
                                                        echo $dataset1["line2"] . ", ";
                                                    }
                                                    echo $dataset2["name_en"] . ", " . $dataset3["name_en"] . ", " . $dataset4["name_en"];
                                                    if ($dataset2["postal_code"] == null) {
                                                        echo ".";
                                                    } else {
                                                        echo ", " . $dataset2["postal_code"] . ".";
                                                    }
                                                    ?>
                                                </span>
                                                <div id="PFaddress<?php echo $x + 1; ?>" class="row d-none gy-1">
                                                    <div class="col-12 col-lg-4">
                                                        <input class="form-control addressline" id="addressline1_<?php echo $x + 1; ?>" value="<?php echo $dataset1["line1"] ?>" placeholder="Enter Address Line 1 Here" spellcheck="false" type="text" style="height: 25px;" />
                                                    </div>
                                                    <div class="col-12 col-lg-4">
                                                        <input class="form-control addressline" id="addressline2_<?php echo $x + 1; ?>" value="<?php echo $dataset1["line2"] ?>" placeholder="Enter Address Line 2 Here" spellcheck="false" type="text" style="height: 25px;" />
                                                    </div>
                                                    <div class="col-12 col-lg-4 text-center">
                                                        Postal Code:
                                                        <span id="postalCode<?php echo $x + 1; ?>">
                                                            <?php
                                                            if ($dataset2["postal_code"] == '') {
                                                                echo "------";
                                                            } else {
                                                                echo $dataset2["postal_code"];
                                                            }
                                                            ?>
                                                        </span>
                                                    </div>
                                                    <div class="col-12 col-lg-4">
                                                        <select id="province<?php echo $x + 1; ?>" onchange="setDistrict<?php echo $x + 1; ?>();" class="form-select form-select-sm">
                                                            <option value="<?php echo $dataset4["id"]; ?>"><?php echo $dataset4["name_en"] . " Province";; ?></option>
                                                            <?php

                                                            $resultsetProvince = Database::search("SELECT * FROM `province` WHERE `id`!= '" . $dataset4["id"] . "' ORDER BY `name_en` ASC ;");
                                                            $rowProvince = $resultsetProvince->num_rows;

                                                            for ($p = 0; $p < $rowProvince; $p++) {
                                                                $datasetProvince = $resultsetProvince->fetch_assoc();
                                                            ?>
                                                                <option value="<?php echo $datasetProvince["id"]; ?>"><?php echo $datasetProvince["name_en"] . " Province"; ?></option>
                                                            <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-12 col-lg-4">
                                                        <select id="district<?php echo $x + 1; ?>" onchange="setCity<?php echo $x + 1; ?>();" class="form-select form-select-sm">
                                                            <option value="<?php echo $dataset3["id"]; ?>"><?php echo $dataset3["name_en"] . " District"; ?></option>
                                                            <?php

                                                            $resultsetProvince = Database::search("SELECT * FROM `district` WHERE `id`!= '" . $dataset3["id"] . "' AND `province_id` = '" . $dataset4["id"] . "' ORDER BY `name_en` ASC ;");
                                                            $rowProvince = $resultsetProvince->num_rows;

                                                            for ($p = 0; $p < $rowProvince; $p++) {
                                                                $datasetProvince = $resultsetProvince->fetch_assoc();
                                                            ?>
                                                                <option value="<?php echo $datasetProvince["id"]; ?>"><?php echo $datasetProvince["name_en"] . " District"; ?></option>
                                                            <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-12 col-lg-4">
                                                        <select id="city<?php echo $x + 1; ?>" onchange="setPCode<?php echo $x + 1; ?>();" class="form-select form-select-sm">
                                                            <option value="<?php echo $dataset2["id"]; ?>"><?php echo $dataset2["name_en"]; ?></option>
                                                            <?php

                                                            $resultsetProvince = Database::search("SELECT * FROM `city` WHERE `id`!= '" . $dataset2["id"] . "' AND `district_id` = '" . $dataset3["id"] . "' ORDER BY `name_en` ASC ;");
                                                            $rowProvince = $resultsetProvince->num_rows;

                                                            for ($p = 0; $p < $rowProvince; $p++) {
                                                                $datasetProvince = $resultsetProvince->fetch_assoc();
                                                            ?>
                                                                <option value="<?php echo $datasetProvince["id"]; ?>"><?php echo $datasetProvince["name_en"]; ?></option>
                                                            <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>


                                                </div>
                                            </div>
                                        </div>
                                        <hr />

                                    </td>
                                </tr>
                            <?php
                            }
                        } else {
                            ?>

                            <tr>
                                <td>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Address 1</h6>
                                        </div>
                                        <br class="d-sm-none" />
                                        <div class="col-sm-9 text-secondary">
                                            <span id="PFVaddress1">Not Entered</span>
                                            <div id="PFaddress1" class="row d-none gy-1">
                                                <div class="col-12 col-lg-4">
                                                    <input class="form-control addressline" id="addressline1_1" placeholder="Enter Address Line 1 Here" type="text" style="height: 25px;" />
                                                </div>
                                                <div class="col-12 col-lg-4">
                                                    <input class="form-control addressline" id="addressline2_1" placeholder="Enter Address Line 2 Here" type="text" style="height: 25px;" />
                                                </div>
                                                <div class="col-12 col-lg-4 text-center">
                                                    Postal Code:
                                                    <span id="postalCode1">------</span>
                                                </div>
                                                <div class="col-12 col-lg-4">
                                                    <select id="province1" onchange="setDistrict1();" class="form-select form-select-sm">
                                                        <option value="0" id="defaultprovince">-- Province --</option>
                                                        <?php

                                                        $resultsetProvince = Database::search("SELECT * FROM `province` ;");
                                                        $rowProvince = $resultsetProvince->num_rows;

                                                        for ($p = 0; $p < $rowProvince; $p++) {
                                                            $datasetProvince = $resultsetProvince->fetch_assoc();
                                                        ?>
                                                            <option value="<?php echo $datasetProvince["id"]; ?>"><?php echo $datasetProvince["name_en"]; ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="col-12 col-lg-4">
                                                    <select id="district1" onchange="setCity1();" class="form-select form-select-sm">
                                                        <option value="0">-- District --</option>
                                                    </select>
                                                </div>
                                                <div class="col-12 col-lg-4">
                                                    <select id="city1" onchange="setPCode1();" class="form-select form-select-sm">
                                                        <option value="0">-- City --</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr />
                                </td>
                            </tr>
                        <?php
                        }

                        ?>
                    </table>
                </div>

            </div>

            <div class="row">
                <div class="col-sm-12">
                    <div class="row gy-2">
                        <div class="col-12 col-sm-6 d-flex justify-content-center justify-content-sm-start">
                            <a class="btn btn-info d-flex align-items-center" id="PFedit" onclick="editPF();" href="#">Edit My Details</a>
                            <a class="btn btn-info d-none d-flex align-items-center" id="PFupdate" onclick="updateProfile();" href="#">Save changed</a>
                        </div>
                        <div id="addressrowset" class="col-12 col-sm-6 d-none d-flex justify-content-center justify-content-sm-end">
                            <button class="btn btn-sm btn-outline-primary me-1" id="PFaddaddress" onclick="addnewaddress();">Add new address</button>
                            <button class="btn btn-sm btn-outline-danger ms-1" id="PFdeleteaddress" onclick="deletenewaddress();">delete address</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>

    </html>
<?php

} else {
    echo "error";
}

?>