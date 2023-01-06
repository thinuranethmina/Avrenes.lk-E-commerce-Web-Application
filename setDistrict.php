<?php

session_set_cookie_params(60 * 60 * 24 * 30);
session_start();
require "connection.php";

if (isset($_SESSION["user"])) {
    $province = $_POST["province"];

    if ($province == '0') {
        echo "<option value='0'>-- District --</option>";
    } else {

        $resultsetDistrict = Database::search("SELECT * FROM `district` WHERE `province_id`= '" . $province . "'   ORDER BY `name_en` ASC ;");
        $rowDistrict = $resultsetDistrict->num_rows;

        for ($p = 0; $p < $rowDistrict; $p++) {
            $datasetDistrict = $resultsetDistrict->fetch_assoc();
?>
            <option value="<?php echo $datasetDistrict["id"]; ?>"><?php echo $datasetDistrict["name_en"] . " " . "District"; ?></option>
<?php
        }
    }
} else {
    echo "Please Sign In or Register.";
}
