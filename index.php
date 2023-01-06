<?php


session_set_cookie_params(60 * 60 * 24 * 30);
session_start();


require "loading.php";
if (isset($_SESSION["user"])) {
?>
    <script>
        window.location = "home.php";
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
        <link rel="icon" href="resources/icon.png" />
        <link rel="stylesheet" href="style.css" />
        <link rel="stylesheet" href="bootstrap.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" />

        <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet" type="text/css" />
        <script src="https://apis.google.com/js/api:client.js"></script>
        <script src="logWithGoogle.js"></script>
        <style type="text/css">
            .Gicon:hover {
                cursor: pointer;
                box-shadow: 0px 5px 10px #000000;
            }

            .Gicon {
                background: url("https://img.icons8.com/external-justicon-lineal-color-justicon/64/000000/external-google-social-media-justicon-lineal-color-justicon.png");
                background-repeat: no-repeat;
                background-size: cover;
                margin-left: 0px;
                width: 60px;
                height: 60px;
                border-radius: 7px;
                transition: .2s;
                box-shadow: 0px 5px 5px #000000;
            }


            .fb_iframe_widget iframe {
                margin-top: 20px;
                opacity: 0;
            }

            .fb_iframe_widget {
                background: url("https://img.icons8.com/external-justicon-lineal-color-justicon/64/000000/external-facebook-social-media-justicon-lineal-color-justicon.png");
                background-repeat: no-repeat;
                background-size: cover;
                margin-left: 0px;
                width: 60px;
                height: 60px;
                border-radius: 7px;
                transition: .2s;
                box-shadow: 0px 5px 5px #000000;
            }

            .fb_iframe_widget:hover {
                cursor: pointer;
                box-shadow: 0px 5px 10px #000000;
            }
        </style>


    </head>

    <body onload="loaderEnd();startApp();" onkeyup="pagekeyup(event);" onclick="area(event);" class="bg">

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
                                <div class="col-12 text-center mt-5">
                                    <label class="switch">
                                        <input type="checkbox" id="toggle" onclick="changeView();">
                                        <span class="slider round pt-1 ps-3 text-start" id="slider" style="font-weight: bold;">
                                            <span class="me-1 ms-1">Sign In</span>
                                            <span class="ms-5">Sign Up</span>
                                        </span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- left -->
                        <!-- right -->

                        <div class="col-12 col-lg-4 pt-3 d-none box" id="signUpBox">
                            <div class="row g-2 mb-5">

                                <div class="col-12 d-lg-none logo"></div>

                                <div class="col-12">
                                    <p class="title02">Create New Account</p>
                                    <span class="text-danger" id="msg"></span>
                                </div>

                                <div class="col-12 col-lg-11">
                                    <label class="form-label">First Name</label>
                                    <input class="form-control" id="fname" type="text" />
                                </div>

                                <div class="col-12 col-lg-11">
                                    <label class="form-label">Last Name</label>
                                    <input class="form-control" id="lname" type="text" />
                                </div>

                                <div class="col-12 col-lg-11">
                                    <label class="form-label">Email</label>
                                    <input class="form-control" id="email" type="text" />
                                </div>

                                <div class="col-12 col-lg-11 tip">
                                    <label class="form-label">Password</label>
                                    <span class="tooltipText  ms-2" style="margin-top: -135px; text-align: left; font-family: verdana;">
                                        <h4 style="font-family: verdana;">Password Must</h4>

                                        &#0149; Be at least 8 characters.<br>
                                        &#0149; Have at least one capital letter.<br>
                                        &#0149; Have at least one simple letter.<br>
                                        &#0149; Have at least one number.<br>
                                        &#0149; Have at least one symbol.

                                    </span>
                                    <div class="new"></div>
                                    <input class="form-control" id="password" type="Password" />
                                    <div class="form-check">
                                        <input type="checkbox" value="1" id="showPassword1" onclick="showPassword1();" class="form-check-input" />
                                        <label class="form-check-label" for="showPassword1">Show Password</label>
                                    </div>
                                </div>

                                <div class="col-12 col-lg-11 tip">
                                    <label class="form-label">Mobile</label>
                                    <span class="tooltipText ms-2">Not allow for Landphone Number.</span>
                                    <input class="form-control" id="mobile" type="text" maxlength="13" />
                                </div>

                                <div class="col-12 col-lg-11">
                                    <label class="form-label">Gender</label>
                                    <select class="form-select" id="gender">
                                        <?php

                                        require "connection.php";

                                        $r = Database::search("SELECT * FROM `gender`;");

                                        $n = $r->num_rows;
                                        for ($x = 0; $x < $n; $x++) {
                                            $d = $r->fetch_assoc();
                                        ?>

                                            <option value="<?php echo $d["id"]; ?>"><?php echo $d["name"]; ?></option>

                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="col-12 col-lg-11 d-grid mt-3">
                                    <button class="btn btn-primary" onclick="signUp();">Sign Up</button>
                                </div>

                                <div class="col-12 d-lg-none d-grid">
                                    <button class="btn btn-dark" onclick="changeView();">Already have an Account? Sign In</button>
                                </div>

                            </div>
                        </div>
                        <div class="col-12 col-lg-4 box pt-4 pb-4" id="signInBox">
                            <div class="row  gx-2 gy-4 mb-3">

                                <div class="col-12 d-lg-none logo"></div>

                                <div class="col-12">
                                    <p class="title02">Sign In to Your Account</p>
                                    <span class="text-danger" id="amsg">
                                        <?php
                                        if (isset($_GET["msg"]) && $_GET["msg"] == "ChbnzV4sHaj") {
                                            echo "Your account has been created successfully.";
                                        }
                                        ?>
                                    </span>
                                </div>

                                <?php

                                $email = "";
                                $password = "";
                                $rememberMe = "";

                                if (isset($_COOKIE["email"])) {
                                    $email = $_COOKIE["email"];
                                    $rememberMe = "checked";
                                }

                                if (isset($_COOKIE["password"])) {
                                    $password = $_COOKIE["password"];
                                    $rememberMe = "checked";
                                }

                                ?>


                                <div class="col-12 col-lg-11">
                                    <label class="form-label">Email</label>
                                    <input class="form-control" type="text" value="<?php echo $email ?>" id="email2" placeholder="E n t e r   H e r e" />
                                </div>

                                <div class="col-12 col-lg-11">
                                    <label class="form-label">Password</label>
                                    <input class="form-control" type="Password" value="<?php echo $password ?>" id="password2" placeholder="E n t e r   H e r e" /><br />
                                    <div class="form-check">
                                        <input type="checkbox" value="1" id="showPassword2" onclick="showPassword2();" class="form-check-input" />
                                        <label class="form-check-label" for="showPassword2">Show Password</label>
                                    </div>
                                </div>

                                <div class="col-12 col-lg-6">
                                    <div class="form-check">
                                        <input type="checkbox" value="1" id="rememberMe" <?php echo $rememberMe ?> class="form-check-input" />
                                        <label class="form-check-label" for="rememberMe">Remember Me</label>
                                    </div>
                                </div>

                                <div class="col-12 col-lg-11 d-grid">
                                    <button class="btn btn-primary" onclick="signIn();">Sign In</button>
                                </div>

                                <div class="col-12 d-lg-none d-grid mt-3">
                                    <button class="btn btn-danger" onclick="changeView();">New to avrenes? Join Now</button>
                                </div>

                                <div class="col-12 col-lg-6">
                                    <a href="#" class="link" onclick="forgotPassword();" style="text-decoration: none; font-weight: bold;">Forgot Password?</a>
                                </div>

                                <hr />
                                <!-- In the callback, you would hide the gSignInWrapper element on a successful sign in -->
                                <div class="col-6" id="gSignInWrapper">
                                    <div id="customBtn" class="customGPlusSignIn Gicon  mx-auto">
                                    </div>
                                </div>

                                <div class="col-6">
                                    <!-- The JS SDK Login Button -->
                                    <div>
                                        <div data-width="60px" class="fb-login-button" data-width="60px" data-size="large" scope="public_profile,email" onlogin="checkLoginState();">
                                        </div>
                                    </div>
                                    <script src="logWithFacebook.js"></script>
                                    <!-- Load the JS SDK asynchronously -->
                                    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js"></script>
                                </div>
                            </div>

                        </div>

                        <!-- right -->

                    </div>
                </div>

                <!-- footer -->

                <div class="col-12 fixed-bottom d-none d-lg-block">
                    <p class="text-center">
                        &copy;2021 avrenes.lk All Rights Reserved
                    </p>
                </div>

                <!-- footer -->
                <!-- Modal -->
                <div id="modal" class="modal1">
                    <!-- <div> -->
                    <div class="col-12 col-md-6 offset-md-3 modal--content">
                        <div class="row">
                            <div class="modal--header">
                                <span class="close d-none d-lg-block" onclick="closeModel();">&times;</span>
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
                                        <label class="form-label">Email</label>
                                        <div class="input-group mb-3">
                                            <input type="text" id="email3" class="form-control" />
                                            <button class="btn btn-outline-secondary" id="sendVcode" type="button" onclick="sendVcode();">Send verification Code</button>
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
                                            <input type="text" class="form-control" id="vc" disabled />
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" onclick="closeModel();" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary" onclick="resetPassword();">Reset</button>
                            </div>
                        </div>
                    </div>
                    <!-- </div> -->
                </div>

            </div>
        </div>


        <script src="script.js"></script>

        <script>
            var num = document.getElementById('mobile');

            num.addEventListener('keydown', function(e) {

                var charCode = (e.which) ? e.which : e.keyCode;
                if ((charCode > 47 && charCode < 58) || (charCode > 95 && charCode < 105) || charCode == 8) {
                    return true;
                }
                e.preventDefault();
                return false;
            }, true);
        </script>

    </body>

    </html>

<?php
}
?>