<?php


session_set_cookie_params(60 * 60 * 24 * 30);
session_start();
if (isset($_SESSION["user"])) {
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="bootstrap.css">
        <link rel="stylesheet" href="style.css">
        <link rel="stylesheet" href="userprofile.css">
        <link rel="icon" href="resources/icon.png">
        <title>avrence | Profile</title>
    </head>

    <body class="userProfilebody" id="UPbody" onkeyup="pagekeyup2(event);" onload="loaderEnd(); userDetailsLoader();" onclick="area2(event);">
        <?php

        require "connection.php";
        require  "header.php";

        ?>
        <div class="container-fluid">
            <div class="row">
                <div class="container">

                    <div class="main-body">
                        <?php
                        $fname = $_SESSION["user"]["fname"];
                        $lname = $_SESSION["user"]["lname"];
                        $email = $_SESSION["user"]["email"];

                        $resultset1 = Database::search("SELECT * FROM `user_has_address` WHERE `email`='" . $email . "';");
                        $row1 = $resultset1->num_rows;

                        ?>
                        <div class="row gutters-sm">
                            <div class="col-md-4 mb-3">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex flex-column align-items-center text-center">

                                            <?php
                                            if ($_SESSION["user"]["profile_img"] == ' ') {

                                            ?>
                                                <label for="imgchooser" style="cursor: pointer;">
                                                    <div class="profilepic">
                                                        <div class="profileImg rounded-circle" id="profileImg" style="background-image: url('resources/profile_img/user.png');"></div>
                                                        <div class="profileImgEdit rounded-circle" onclick="changeProfileImg();"></div>
                                                    </div>
                                                </label>
                                            <?php
                                            } else {
                                            ?>
                                                <label for="imgchooser" style="cursor: pointer;">
                                                    <div class="profilepic">
                                                        <div class="profileImg rounded-circle" id="profileImg" style="background-image: url('<?php echo $_SESSION["user"]["profile_img"]; ?>');"></div>
                                                        <div class="profileImgEdit rounded-circle" onclick="changeProfileImg();"></div>
                                                    </div>
                                                </label>
                                            <?php
                                            }
                                            ?>
                                            <input type="file" class="d-none" id="imgchooser" accept="img/*" />
                                            <div class="mt-3">
                                                <h4><?php echo $_SESSION["user"]["fname"] . " " . $_SESSION["user"]["lname"]; ?></h4>
                                                <p class="text-secondary mb-1"><?php echo $_SESSION["user"]["email"]; ?></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- <div class="card mt-3">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                            <h6 class="mb-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-globe mr-2 icon-inline">
                                                    <circle cx="12" cy="12" r="10"></circle>
                                                    <line x1="2" y1="12" x2="22" y2="12"></line>
                                                    <path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path>
                                                </svg> Website</h6>
                                            <span class="text-secondary">https://bootdey.com</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                            <h6 class="mb-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-github mr-2 icon-inline">
                                                    <path d="M9 19c-5 1.5-5-2.5-7-3m14 6v-3.87a3.37 3.37 0 0 0-.94-2.61c3.14-.35 6.44-1.54 6.44-7A5.44 5.44 0 0 0 20 4.77 5.07 5.07 0 0 0 19.91 1S18.73.65 16 2.48a13.38 13.38 0 0 0-7 0C6.27.65 5.09 1 5.09 1A5.07 5.07 0 0 0 5 4.77a5.44 5.44 0 0 0-1.5 3.78c0 5.42 3.3 6.61 6.44 7A3.37 3.37 0 0 0 9 18.13V22"></path>
                                                </svg> Github</h6>
                                            <span class="text-secondary">bootdey</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                            <h6 class="mb-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-twitter mr-2 icon-inline text-info">
                                                    <path d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z"></path>
                                                </svg> Twitter</h6>
                                            <span class="text-secondary">@bootdey</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                            <h6 class="mb-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-instagram mr-2 icon-inline text-danger">
                                                    <rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect>
                                                    <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path>
                                                    <line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line>
                                                </svg> Instagram</h6>
                                            <span class="text-secondary">bootdey</span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                            <h6 class="mb-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-facebook mr-2 icon-inline text-primary">
                                                    <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path>
                                                </svg> Facebook</h6>
                                            <span class="text-secondary">bootdey</span>
                                        </li>
                                    </ul>
                                </div> -->
                            </div>

                            <div class="col-md-8">
                                <div class="card mb-3" id="userDetails">

                                </div>

                                <!-- <div class="row gutters-sm">
                                    <div class="col-sm-6 mb-3">
                                        <div class="card h-100">
                                            <div class="card-body">
                                                <h6 class="d-flex align-items-center mb-3"><i class="material-icons text-info mr-2">assignment</i>Project Status</h6>
                                                <small>Web Design</small>
                                                <div class="progress mb-3" style="height: 5px">
                                                    <div class="progress-bar bg-primary" role="progressbar" style="width: 80%" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                                <small>Website Markup</small>
                                                <div class="progress mb-3" style="height: 5px">
                                                    <div class="progress-bar bg-primary" role="progressbar" style="width: 72%" aria-valuenow="72" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                                <small>One Page</small>
                                                <div class="progress mb-3" style="height: 5px">
                                                    <div class="progress-bar bg-primary" role="progressbar" style="width: 89%" aria-valuenow="89" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                                <small>Mobile Template</small>
                                                <div class="progress mb-3" style="height: 5px">
                                                    <div class="progress-bar bg-primary" role="progressbar" style="width: 55%" aria-valuenow="55" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                                <small>Backend API</small>
                                                <div class="progress mb-3" style="height: 5px">
                                                    <div class="progress-bar bg-primary" role="progressbar" style="width: 66%" aria-valuenow="66" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 mb-3">
                                        <div class="card h-100">
                                            <div class="card-body">
                                                <h6 class="d-flex align-items-center mb-3"><i class="material-icons text-info mr-2">assignment</i>Project Status</h6>
                                                <small>Web Design</small>
                                                <div class="progress mb-3" style="height: 5px">
                                                    <div class="progress-bar bg-primary" role="progressbar" style="width: 80%" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                                <small>Website Markup</small>
                                                <div class="progress mb-3" style="height: 5px">
                                                    <div class="progress-bar bg-primary" role="progressbar" style="width: 72%" aria-valuenow="72" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                                <small>One Page</small>
                                                <div class="progress mb-3" style="height: 5px">
                                                    <div class="progress-bar bg-primary" role="progressbar" style="width: 89%" aria-valuenow="89" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                                <small>Mobile Template</small>
                                                <div class="progress mb-3" style="height: 5px">
                                                    <div class="progress-bar bg-primary" role="progressbar" style="width: 55%" aria-valuenow="55" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                                <small>Backend API</small>
                                                <div class="progress mb-3" style="height: 5px">
                                                    <div class="progress-bar bg-primary" role="progressbar" style="width: 66%" aria-valuenow="66" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div> -->


                                <div id="modal2" class="modal1">
                                    <div class="col-12 col-md-6 offset-md-3 modal--content">
                                        <div class="row">
                                            <div class="modal--header">
                                                <span class="close d-none d-lg-block" onclick="closeModel2();">&times;</span>
                                                <h2>Change Password</h2>
                                            </div>
                                            <div class="modal--body">
                                                <div class="row d-3 p-lg-5">

                                                    <div class="col-12">
                                                        <span class="d-none text-center text-warning" id="timer"></span>
                                                        <span class="text-danger" id="Mmsg"></span>
                                                        <h3 class="text-center" style="text-shadow: 0 0 3px rgb(136, 255, 0);" id="h3msg"></h3>
                                                    </div>

                                                    <!-- Modal -->

                                                    <div class="col-12">
                                                        <label class="form-label">Your Email</label>
                                                        <div class="input-group mb-3">
                                                            <input type="text" disabled value="<?php echo $_SESSION["user"]["email"]; ?>" id="email6" class="form-control" />
                                                            <button class="btn btn-outline-secondary" id="sendVcode" type="button" onclick="sendVcode2();">Send verification Code</button>
                                                        </div>
                                                    </div>

                                                    <div class="col-12 col-lg-6">
                                                        <label class="form-label">New Password</label>
                                                        <div class="input-group mb-3">
                                                            <input type="password" id="np" class="form-control" disabled />
                                                            <button disabled class="btn btn-outline-secondary" type="button" id="npb" onclick="showPassword3();">Show</button>
                                                        </div>
                                                    </div>

                                                    <div class="col-12 col-lg-6">
                                                        <label class="form-label">Re-type Password</label>
                                                        <div class="input-group mb-3">
                                                            <input type="password" id="rnp" class="form-control" disabled />
                                                            <button disabled class="btn btn-outline-secondary" type="button" id="rnpb" onclick="showPassword4();">Show</button>
                                                        </div>
                                                    </div>

                                                    <div class="col-12">
                                                        <label class="form-label">Verification Code</label>
                                                        <div class="input-group mb-3">
                                                            <input type="number" class="form-control num2" id="vc" disabled />
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" onclick="closeModel2();" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                <button type="button" class="btn btn-primary" onclick="savechangePassword();">Change Password</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                            </div>

                            <div class="d-flex justify-content-center">
                                <div id="snackbar">Some text message..</div>
                            </div>
                            <div class="d-flex justify-content-center">
                                <div id="snackbarbtn">
                                    <span id="snackbarmsg">Some text message..</span>
                                    <div class="text-center">
                                        <button class="btn btn-outline-light pt-0 pb-0 ps-3 pe-3" id="ok">Yes</button>
                                        <button class="btn btn-outline-light pt-0 pb-0 ps-3 pe-3" id="cancel">No</button>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
                <?php
                require "footer.php";
                ?>
            </div>
            <script src="script.js"></script>
    </body>


    </html>
<?php
} else {
?>
    <script>
        window.location = "index.php";
    </script>
<?php
}
