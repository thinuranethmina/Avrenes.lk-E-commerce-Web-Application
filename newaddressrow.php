<?php

session_set_cookie_params(60 * 60 * 24 * 30);
session_start();

if (isset($_SESSION["user"])) {
?>
    <!DOCTYPE html>
    <html>

    <head>
    </head>

    <body>
        <?php
        require "connection.php";
        $addnum = $_POST["addnum"];
        ?>
        <div class="row">
            <div class="col-sm-3">
                <h6 class="mb-0">Address <?php echo $addnum; ?></h6>
            </div>
            <div class="col-sm-9 text-secondary">
                <div id="PFaddress<?php echo $addnum; ?>" class="row gy-1">
                    <div class="col-12 col-lg-4">
                        <input class="form-control addressline" id="addressline1_<?php echo $addnum; ?>" placeholder="Enter Address Line 1 Here" type="text" style="height: 25px;" />
                    </div>
                    <div class="col-12 col-lg-4">
                        <input class="form-control addressline" id="addressline2_<?php echo $addnum; ?>" placeholder="Enter Address Line 2 Here" type="text" style="height: 25px;" />
                    </div>
                    <div class="col-12 col-lg-4 text-center">
                        Postal Code:
                        <span id="postalCode<?php echo $addnum; ?>">------</span>
                    </div>
                    <div class="col-12 col-lg-4">
                        <select id="province<?php echo $addnum; ?>" onchange="setDistrict<?php echo $addnum; ?>();" class="form-select form-select-sm">
                            <option value="0">-- Province --</option>
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
                        <select id="district<?php echo $addnum; ?>" onchange="setCity<?php echo $addnum; ?>();" class="form-select form-select-sm">
                            <option value="0">-- District --</option>
                        </select>
                    </div>
                    <div class="col-12 col-lg-4">
                        <select id="city<?php echo $addnum; ?>" onchange="setPCode<?php echo $addnum; ?>();" class="form-select form-select-sm">
                            <option value="0">-- City --</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <hr />
    </body>

    </html>
<?php
} else {
    echo "Please Sign In or Register.";
}
