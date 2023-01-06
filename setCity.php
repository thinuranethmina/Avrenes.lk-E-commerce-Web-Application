<?php

session_set_cookie_params(60 * 60 * 24 * 30);
session_start();
require "connection.php";

if (isset($_SESSION["user"])) {
    $district = $_POST["district"];

    if ($district == '0') {
        echo "<option value='0'>-- City --</option>";
    } else {

        $resultsetCity = Database::search("SELECT * FROM `city` WHERE `district_id`= '" . $district . "'   ORDER BY `name_en` ASC ;");
        $rowCity = $resultsetCity->num_rows;

        for ($p = 0; $p < $rowCity; $p++) {
            $datasetCity = $resultsetCity->fetch_assoc();
?>
            <option value="<?php echo $datasetCity["id"]; ?>"><?php echo $datasetCity["name_en"]; ?></option>
<?php
        }
    }
} else {
    echo "Please Sign In or Register.";
}
