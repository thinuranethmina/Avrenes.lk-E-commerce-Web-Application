<?php

require "loading.php";

session_start();


if (isset($_SESSION["user"]) && $_SESSION["user"]["user_type_id"] == "1") {
?>
    <script>
        window.location = "adminpanel.php";
    </script>
<?php
} else {

?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>avrenes</title>
        <link rel="stylesheet" href="style.css" />
        <link rel="stylesheet" href="bootstrap.css" />
        <link rel="icon" href="resources/icon.png" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" />

        <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet" type="text/css" />
        <script src="https://apis.google.com/js/api:client.js"></script>


    </head>

    <body onload="loaderEnd();" class="bg">

        <div class="container-fluid vh-100 d-flex justify-content-center">
            <div class="row align-content-center">

                <div class="col-12 mb-5 mt-3">
                    <div class="row">

                        <!-- left -->

                        <div class="col-4 offset-2 d-none d-lg-block background">
                            <div class="row">
                                <div class="col-12 mt-5 logo"></div>
                                <div class="col-12">
                                    <h1 class="text-center mt-5 title01">Hello, Friend!</h1>
                                    <p class="text-center mt-3 title03">Enter your details and start journy with us</p>
                                </div>
                                <img src="resources/logo.png" alt="avrenes" height="70px" />
                            </div>
                        </div>

                        <!-- left -->
                        <!-- right -->


                        <div class="col-12 col-lg-4 box pt-4 pb-4" style="height: 400px;" id="">
                            <div class="row mt-3 gx-2 gy-4 mb-3">

                                <div class="col-12 d-lg-none logo"></div>

                                <div class="col-12">
                                    <p class="title02">Admin Signin</p>
                                    <span class="text-danger" id="amsg">
                                        <?php
                                        // echo "MSG";

                                        ?>
                                    </span>
                                </div>


                                <div class="col-12 col-lg-11">
                                    <label class="form-label">Email</label>
                                    <input class="form-control" type="text" value="" id="adminEmail" placeholder="E n t e r   H e r e" />
                                </div>


                                <div class="col-12 col-lg-11 d-grid">
                                    <button class="btn btn-primary" onclick="adminSignIn();">Send Verification Code</button>
                                </div>

                            </div>

                        </div>

                        <!-- right -->

                    </div>
                </div>

                <!-- footer -->

                <div class="col-12 fixed-bottom d-none d-lg-block">
                    <p class="text-center">
                        &copy;2023 avrenes.lk All Rights Reserved
                    </p>
                </div>

                <!-- footer -->
                <!-- Modal -->
                <div id="adminmodal" class="modal1">
                    <!-- <div> -->
                    <div class="col-12 col-md-6 offset-md-3 modal--content">
                        <div class="row">
                            <div class="modal--header">
                                <span class="close d-none d-lg-block" onclick="closeAdminModel();">&times;</span>
                                <h2>Password Reset</h2>
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
                                        <label class="form-label">Verification Code</label>
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control" id="vc" />
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" onclick="closeAdminModel();" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary" onclick="adminLogin();">Login</button>
                            </div>
                        </div>
                    </div>
                    <!-- </div> -->
                </div>

            </div>
        </div>


        <script src="script.js"></script>

    </body>

    </html>

<?php
}
?>