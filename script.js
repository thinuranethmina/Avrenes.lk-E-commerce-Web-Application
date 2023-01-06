function pagekeyup(event) {
    var key = event.which;

    var nowSignIn = document.getElementById("signInBox").classList.contains('d-none');
    var nowSignUp = document.getElementById("signUpBox").classList.contains('d-none');
    if (key == 13) {
        if (nowSignIn == false) {
            var email2 = document.getElementById("email2").value;
            var password2 = document.getElementById("password2").value;

            if (email2 == "") {
                document.getElementById("email2").focus();
                signIn();
            } else if (password2 == "") {
                document.getElementById("password2").focus();
            } else {
                signIn();
            }

        } else if (nowSignUp == false) {
            var fname = document.getElementById("fname").value;
            var lname = document.getElementById("lname").value;
            var email = document.getElementById("email").value;
            var password = document.getElementById("password").value;
            var mobile = document.getElementById("mobile").value;

            if (fname == "") {
                document.getElementById("fname").focus();
                signUp();
            } else if (lname == "") {
                document.getElementById("lname").focus();
            } else if (email == "") {
                document.getElementById("email").focus();
            } else if (password == "") {
                document.getElementById("password").focus();
            } else if (mobile == "") {
                document.getElementById("mobile").focus();
            } else {
                signUp();
            }

        }
    }

}

function changeView() {
    var signUpBox = document.getElementById("signUpBox");
    var signInBox = document.getElementById("signInBox");

    signUpBox.classList.toggle("d-none");
    signInBox.classList.toggle("d-none");

}

function signUp() {

    var fname = document.getElementById("fname");
    var lname = document.getElementById("lname");
    var email = document.getElementById("email");
    var password = document.getElementById("password");
    var mobile = document.getElementById("mobile");
    var gender = document.getElementById("gender");

    var form = new FormData();
    form.append("fname", fname.value);
    form.append("lname", lname.value);
    form.append("email", email.value);
    form.append("password", password.value);
    form.append("mobile", mobile.value);
    form.append("gender", gender.value);

    var r = new XMLHttpRequest();

    r.onreadystatechange = function() {
        if (r.readyState == 4) {
            loaderEnd();
            var text = r.responseText;
            if (text == "success") {
                fname.value = "";
                lname.value = "";
                email.value = "";
                password.value = "";
                mobile.value = "";
                document.getElementById("msg").innerHTML = "";
                window.location = "index.php?msg=" + "ChbnzV4sHaj";

            } else {
                document.getElementById("msg").innerHTML = text;
            }
        } else {
            loader();
        }
    }

    r.open("POST", "SignUpProcess.php", true);
    r.send(form);
}

function process(input) {
    let value = input.value;
    let numbers = value.replace(/[^0-9]/g, "");
    input.value = numbers;
}

function togglebtnSlider() {
    alert("ok");
    document.getElementById("slider").before = "true";
    document.getElementById("toggle").checked = "true";
}

function showPassword1() {
    var pw = document.getElementById("password");
    if (pw.type == "password") {
        pw.type = "text";
    } else {
        pw.type = "password";
    }

}

function showPassword2() {
    var pw = document.getElementById("password2");
    if (pw.type == "password") {
        pw.type = "text";
    } else {
        pw.type = "password";
    }

}

function signIn() {

    var email = document.getElementById("email2");
    var password = document.getElementById("password2");
    var rememberMe = document.getElementById("rememberMe");

    var form = new FormData();
    form.append("email", email.value);
    form.append("password", password.value);
    form.append("rememberMe", rememberMe.checked);

    var r = new XMLHttpRequest();

    r.onreadystatechange = function() {
        if (r.readyState == 4) {
            loaderEnd();
            var text = r.responseText;
            if (text == "success") {
                email.value = "";
                password.value = "";
                document.getElementById("amsg").innerHTML = text;
                window.location = "home.php";
            } else {
                document.getElementById("amsg").innerHTML = text;
            }
        } else {
            loader();
        }
    }

    r.open("POST", "signInProcess.php", true);
    r.send(form);
}

function forgotPassword() {
    document.getElementById("modal").style.display = "block";

}

function closeModel() {
    document.getElementById("modal").style.display = "none";
}

function area(event) {
    if (event.target == modal) {
        document.getElementById("modal").style.display = "none";
    }
}

function sendVcode() {
    var email = document.getElementById("email3");

    var r = new XMLHttpRequest();

    r.onreadystatechange = function() {
        if (r.readyState == 4) {
            loaderEnd();
            var text = r.responseText;
            if (text == "Success") {
                count();
                document.getElementById("Mmsg").innerHTML = "Verification Code Sent to your Email.Please Chek the inbox.";
            } else {
                document.getElementById("Mmsg").innerHTML = text;
            }
        } else {
            loader();
        }
    };
    r.open("GET", "forgotPasswordProcess.php?e=" + email.value, true);
    r.send();
}

function showPassword3() {

    var np = document.getElementById("np");
    var npb = document.getElementById("npb");

    if (npb.innerHTML == "Show") {

        np.type = "text";
        npb.innerHTML = "Hide";

    } else {

        np.type = "password";
        npb.innerHTML = "Show";

    }

}

function showPassword4() {

    var rnp = document.getElementById("rnp");
    var rnpb = document.getElementById("rnpb");

    if (rnpb.innerHTML == "Show") {

        rnp.type = "text";
        rnpb.innerHTML = "Hide";

    } else {

        rnp.type = "password";
        rnpb.innerHTML = "Show";

    }

}

function resetPassword() {

    var e = document.getElementById("email3");
    var np = document.getElementById("np");
    var rnp = document.getElementById("rnp");
    var vc = document.getElementById("vc");

    var form = new FormData();
    form.append("e", e.value);
    form.append("np", np.value);
    form.append("rnp", rnp.value);
    form.append("vc", vc.value);

    var r = new XMLHttpRequest();

    r.onreadystatechange = function() {
        if (r.readyState == 4) {
            loaderEnd();
            var text = r.responseText;
            if (text == "Success") {
                document.getElementById("timer").classList.toggle("d-none");
                document.getElementById("Mmsg").innerHTML = "";
                txt = "Password Reset Sucess.";
                element = document.getElementById("h3msg");
                typeWriter();
                setTimeout(closeModel, 8000);
            } else {
                document.getElementById("Mmsg").innerHTML = text;
            }
        } else {
            loader();
        }
    };
    r.open("POST", "resetPassword.php", true);
    r.send(form);

}

function showPassword5() {
    var btn = document.getElementById("passwordSHbtn");
    if (btn.innerHTML == "Show") {
        document.getElementById("password5").type = "text";
        document.getElementById("password5").style.letterSpacing = "0px";
        btn.innerHTML = "Hide";
    } else {
        document.getElementById("password5").type = "password";
        document.getElementById("password5").style.letterSpacing = "3px";
        btn.innerHTML = "Show";
    }
}

var i = 0;
var speed = 270;
var element = "";

function typeWriter() {
    if (i < txt.length) {
        element.innerHTML += txt.charAt(i);
        i++;
        setTimeout(typeWriter, speed);
    }
}

function loader() {
    document.getElementById("loader").style.display = "block";
}

function loaderEnd() {
    document.getElementById("loader").style.display = "none";
}

var countID = 1;

function count() {
    if (countID == 1) {
        document.getElementById("timer").classList.toggle("d-none");
        countID = setInterval(timer, 1000);
        document.getElementById("sendVcode").disabled = true;
        document.getElementById("np").disabled = false;
        document.getElementById("npb").disabled = false;
        document.getElementById("rnp").disabled = false;
        document.getElementById("rnpb").disabled = false;
        document.getElementById("vc").disabled = false;
        timeS = 30;
        timeM = 1;
    }
}


function timer() {
    var t = document.getElementById("timer");

    if (timeS == 0 && timeM == 0) {
        document.getElementById("sendVcode").disabled = false;
        document.getElementById("np").disabled = true;
        document.getElementById("npb").disabled = true;
        document.getElementById("rnp").disabled = true;
        document.getElementById("rnpb").disabled = true;
        document.getElementById("vc").disabled = true;
        document.getElementById("timer").classList.toggle("d-none");
        clearInterval(countID);
        countID = 1;
    }

    if (timeS < 10) {
        if (timeM < 10) {
            t.innerHTML = "0" + timeM + ":0" + timeS;
        } else {
            t.innerHTML = timeM + ":0" + timeS;
        }
    } else {
        if (timeM < 10) {
            t.innerHTML = "0" + timeM + ":" + timeS;
        } else {
            t.innerHTML = timeM + ":" + timeS;
        }
    }
    timeS = timeS - 01;
    if (timeS == -1) {
        timeS = 59
        timeM = timeM - 01;
    }

}

function signOut() {
    var r = new XMLHttpRequest();

    r.onreadystatechange = function() {
        if (r.readyState == 4) {
            var t = r.responseText;
            if (t == "success") {
                window.location = "home.php";
                loaderEnd();
            }
        } else {
            loader();
        }
    }
    r.open("GET", "signOutProcess.php", true);
    r.send();
}

function editPF() {

    var editbtn = document.getElementById("PFedit");
    var updatebtn = document.getElementById("PFupdate");

    editbtn.classList.toggle("d-none");
    updatebtn.classList.toggle("d-none");

    var Vfullname = document.getElementById("PFVfullname");
    var fullname = document.getElementById("PFfullname");
    fullname.classList.toggle("d-none");
    Vfullname.classList.toggle("d-none");

    var addressrowset = document.getElementById("addressrowset");
    addressrowset.classList.toggle("d-none");

    if (document.getElementById("changePWbtn") != null) {
        document.getElementById("changePWbtn").classList.toggle("d-none");
    }

    if (document.getElementById("PFVmobile") != null) {
        var Vmobile = document.getElementById("PFVmobile");
        var mobile = document.getElementById("PFmobile");

        mobile.classList.toggle("d-none");
        Vmobile.classList.toggle("d-none");
    }

    if (document.getElementById("PFVgender") != null) {
        var Vgender = document.getElementById("PFVgender");
        var gender = document.getElementById("PFgender");
        gender.classList.toggle("d-none");
        Vgender.classList.toggle("d-none");
    }

    var address1 = document.getElementById("PFaddress1");
    var Vaddress1 = document.getElementById("PFVaddress1");
    address1.classList.toggle("d-none");
    Vaddress1.classList.toggle("d-none");


    if (document.getElementById("PFVaddress2") != null) {
        var address2 = document.getElementById("PFaddress2");
        var Vaddress2 = document.getElementById("PFVaddress2");
        address2.classList.toggle("d-none");
        Vaddress2.classList.toggle("d-none");
    }

    if (document.getElementById("PFVaddress3") != null) {
        var address3 = document.getElementById("PFaddress3");
        var Vaddress3 = document.getElementById("PFVaddress3");
        address3.classList.toggle("d-none");
        Vaddress3.classList.toggle("d-none");
    }


}

function setDistrict1() {

    var province = document.getElementById("province1");

    var r = new XMLHttpRequest();

    var form = new FormData();
    form.append("province", province.value);

    r.onreadystatechange = function() {

        if (r.readyState == 4) {
            var text = r.responseText;
            document.getElementById("district1").innerHTML = text;
            setCity1();
        }

    }
    r.open("POST", "setDistrict.php", true);
    r.send(form);

}

function setCity1() {

    var district = document.getElementById("district1");

    var r = new XMLHttpRequest();

    var form = new FormData();
    form.append("district", district.value);

    r.onreadystatechange = function() {

        if (r.readyState == 4) {
            var text = r.responseText;
            document.getElementById("city1").innerHTML = text;
            setPCode1();
        } else {}

    }
    r.open("POST", "setCity.php", true);
    r.send(form);
}

function setPCode1() {
    var city = document.getElementById("city1");

    var r = new XMLHttpRequest();

    var form = new FormData();
    form.append("city", city.value);

    r.onreadystatechange = function() {

        if (r.readyState == 4) {
            var text = r.responseText;
            document.getElementById("postalCode1").innerHTML = text;
        } else {}

    }
    r.open("POST", "setPCode.php", true);
    r.send(form);
}


function setDistrict2() {

    var province = document.getElementById("province2");

    var r = new XMLHttpRequest();

    var form = new FormData();
    form.append("province", province.value);

    r.onreadystatechange = function() {

        if (r.readyState == 4) {
            var text = r.responseText;
            document.getElementById("district2").innerHTML = text;
            setCity2();
        }

    }
    r.open("POST", "setDistrict.php", true);
    r.send(form);

}

function setCity2() {

    var district = document.getElementById("district2");

    var r = new XMLHttpRequest();

    var form = new FormData();
    form.append("district", district.value);

    r.onreadystatechange = function() {

        if (r.readyState == 4) {
            var text = r.responseText;
            document.getElementById("city2").innerHTML = text;
            setPCode2();
        } else {}

    }
    r.open("POST", "setCity.php", true);
    r.send(form);
}

function setPCode2() {
    var city = document.getElementById("city2");

    var r = new XMLHttpRequest();

    var form = new FormData();
    form.append("city", city.value);

    r.onreadystatechange = function() {

        if (r.readyState == 4) {
            var text = r.responseText;
            document.getElementById("postalCode2").innerHTML = text;
        } else {}

    }
    r.open("POST", "setPCode.php", true);
    r.send(form);
}

function setDistrict3() {

    var province = document.getElementById("province3");

    var r = new XMLHttpRequest();

    var form = new FormData();
    form.append("province", province.value);

    r.onreadystatechange = function() {

        if (r.readyState == 4) {
            var text = r.responseText;
            document.getElementById("district3").innerHTML = text;
            setCity3();
        }

    }
    r.open("POST", "setDistrict.php", true);
    r.send(form);

}

function setCity3() {

    var district = document.getElementById("district3");

    var r = new XMLHttpRequest();

    var form = new FormData();
    form.append("district", district.value);

    r.onreadystatechange = function() {

        if (r.readyState == 4) {
            var text = r.responseText;
            document.getElementById("city3").innerHTML = text;
            setPCode3();
        } else {}

    }
    r.open("POST", "setCity.php", true);
    r.send(form);
}

function setPCode3() {
    var city = document.getElementById("city3");

    var r = new XMLHttpRequest();

    var form = new FormData();
    form.append("city", city.value);

    r.onreadystatechange = function() {

        if (r.readyState == 4) {
            var text = r.responseText;
            document.getElementById("postalCode3").innerHTML = text;
        } else {}

    }
    r.open("POST", "setPCode.php", true);
    r.send(form);
}

var showSnackBarID = 1;

function showSnackBar() {
    var x = document.getElementById("snackbar");
    x.className = "show";
    if (showSnackBarID == 1) {
        showSnackBarID = setTimeout(function() {
            x.className = x.className.replace("show", "");
            showSnackBarID = 1;
        }, 10000);
    }
}

var showSnackBarBtnID = 1;

function showSnackBarBtn() {
    var x = document.getElementById("snackbarbtn");
    x.className = "show";
    if (showSnackBarBtnID == 1) {
        showSnackBarBtnID = setTimeout(function() {
            x.className = x.className.replace("show", "");
            showSnackBarBtnID = 1;
        }, 10000);
    }
}

function changePassword() {
    document.getElementById("modal2").style.display = "block";

}

function closeModel2() {
    document.getElementById("modal2").style.display = "none";
}

function area2(event) {
    if (event.target == modal2) {
        document.getElementById("modal2").style.display = "none";
    } else {

    }
}

var sendVcodemsg;

function sendVcode2() {
    var email = document.getElementById("email6");

    var r = new XMLHttpRequest();

    r.onreadystatechange = function() {

        if (r.readyState == 4) {
            loaderEnd();
            var text = r.responseText;
            sendVcodemsg = text;
            if (text == "Success") {
                count();
                document.getElementById("Mmsg").innerHTML = "Verification Code Sent to your Email.Please Chek the inbox.";
            } else {
                document.getElementById("Mmsg").innerHTML = text;
            }
        } else {
            loader();
        }
    };
    r.open("GET", "forgotPasswordProcess.php?e=" + email.value, true);
    r.send();
}

function savechangePassword() {

    var e = document.getElementById("email6");
    var np = document.getElementById("np");
    var rnp = document.getElementById("rnp");
    var vc = document.getElementById("vc");

    var form = new FormData();
    form.append("e", e.value);
    form.append("np", np.value);
    form.append("rnp", rnp.value);
    form.append("vc", vc.value);

    var r = new XMLHttpRequest();

    r.onreadystatechange = function() {
        if (r.readyState == 4) {
            loaderEnd();
            var text = r.responseText;
            if (text == "Success") {
                document.getElementById("timer").classList.toggle("d-none");
                document.getElementById("Mmsg").innerHTML = "";
                txt = "Password Reset Sucess.";
                element = document.getElementById("h3msg");
                typeWriter();
                setTimeout(function() {
                    closeModel2();
                    window.location = "userProfile.php";
                }, 6000);
            } else {
                if ((sendVcodemsg != "Success" || countID == 1) && vc.value == '') {
                    document.getElementById("Mmsg").innerHTML = "Please Click ''Send Verification Code'' button.";
                } else {
                    document.getElementById("Mmsg").innerHTML = text;
                }

            }
        } else {
            loader();
        }
    };
    r.open("POST", "resetPassword.php", true);
    r.send(form);

}

var addnum = 0;

function addnewaddress() {
    var table = document.getElementById("addresstable");
    var addnum = table.rows.length;

    var form = new FormData();
    form.append("addnum", addnum + 1);

    if (addnum <= 2) {
        document.getElementById("PFdeleteaddress").disabled = false;

        var r = new XMLHttpRequest();

        r.onreadystatechange = function() {
            if (r.readyState == 4) {
                var text = r.responseText;
                var row = table.insertRow(addnum);
                var cell1 = row.insertCell(0);
                cell1.innerHTML = text;
                addnum++
            }
        };
        r.open("POST", "newaddressrow.php", true);
        r.send(form);
    } else {
        document.getElementById("PFaddaddress").disabled = true;

        var msg1 = document.getElementById("snackbar");
        var msg2 = document.getElementById("snackbarbtn");
        if (msg1.classList.contains("show")) {
            msg1.className = "hide";
            setTimeout(function() {
                msg1.className = msg1.className.replace("hide", "");
                document.getElementById("snackbar").innerHTML = "You can add  maximum of three addresses only.";
                showSnackBar();
            }, 500);
        } else if (msg2.classList.contains("show")) {
            msg2.className = "hide";
            setTimeout(function() {
                msg2.className = msg2.className.replace("hide", "");
                document.getElementById("snackbar").innerHTML = "You can add  maximum of three addresses only.";
                showSnackBar();
            }, 500);
        } else {
            document.getElementById("snackbar").innerHTML = "You can add  maximum of three addresses only.";
            showSnackBar();
        }


    }


}

function deletenewaddress() {
    var table = document.getElementById("addresstable");
    var addnum = table.rows.length - 1;
    if (addnum >= 1) {

        var msg1 = document.getElementById("snackbar");
        var msg2 = document.getElementById("snackbarbtn");
        if (msg1.classList.contains("show")) {
            msg1.className = "hide";
            setTimeout(function() {
                msg1.className = msg1.className.replace("hide", "");
                document.getElementById("snackbarmsg").innerHTML = "Are you sure? Do you want to delete your address?";
                showSnackBarBtn();
            }, 500);
        } else if (msg2.classList.contains("show")) {
            msg2.className = "hide";
            setTimeout(function() {
                msg2.className = msg2.className.replace("hide", "");
                document.getElementById("snackbarmsg").innerHTML = "Are you sure? Do you want to delete your address?";
                showSnackBarBtn();
            }, 500);
        } else {
            document.getElementById("snackbarmsg").innerHTML = "Are you sure? Do you want to delete your address?";
            showSnackBarBtn();
        }

        document.getElementById("ok").onclick = function() {
            document.getElementById("PFaddaddress").disabled = false;
            document.getElementById("addresstable").deleteRow(addnum);
            var y = document.getElementById("snackbarbtn");
            y.className = "hide";
            setTimeout(function() {
                y.className = y.className.replace("hide", "");
            }, 500);
        }
        document.getElementById("cancel").onclick = function() {
            var y = document.getElementById("snackbarbtn");
            y.className = "hide";
            setTimeout(function() {
                y.className = y.className.replace("hide", "");
            }, 500);
        }

    } else {

        document.getElementById("PFdeleteaddress").disabled = true;

        var msg1 = document.getElementById("snackbar");
        var msg2 = document.getElementById("snackbarbtn");
        if (msg1.classList.contains("show")) {
            msg1.className = "hide";
            setTimeout(function() {
                msg1.className = msg1.className.replace("hide", "");
                document.getElementById("snackbar").innerHTML = "At least one address is required to distribute your items.";
                showSnackBar();
            }, 500);
        } else if (msg2.classList.contains("show")) {
            msg2.className = "hide";
            setTimeout(function() {
                msg2.className = msg2.className.replace("hide", "");
                document.getElementById("snackbar").innerHTML = "At least one address is required to distribute your items.";
                showSnackBar();
            }, 500);
        } else {
            document.getElementById("snackbar").innerHTML = "At least one address is required to distribute your items.";
            showSnackBar();
        }
    }

}

function changeProfileImg() {
    var newImg = document.getElementById("imgchooser"); //file chooser
    var profileImg = document.getElementById("profileImg"); //image tag


    newImg.onchange = function() {

        var file0 = this.files[0];
        var url0 = window.URL.createObjectURL(file0);

        var r = new XMLHttpRequest();

        var form = new FormData();
        form.append("profileImg", newImg.files[0]);

        r.onreadystatechange = function() {

            if (r.readyState == 4) {
                var text = r.responseText;
                if (text == "success") {
                    profileImg.style.backgroundImage = 'url(' + url0 + ')';
                    var msg1 = document.getElementById("snackbar");
                    var msg2 = document.getElementById("snackbarbtn");
                    if (msg1.classList.contains("show")) {
                        msg1.className = "hide";
                        setTimeout(function() {
                            msg1.className = msg1.className.replace("hide", "");
                            document.getElementById("snackbar").innerHTML = "Profile picture has been update.";
                            showSnackBar();
                        }, 500);
                    } else if (msg2.classList.contains("show")) {
                        msg2.className = "hide";
                        setTimeout(function() {
                            msg2.className = msg2.className.replace("hide", "");
                            document.getElementById("snackbar").innerHTML = "Profile picture has been update.";
                            showSnackBar();
                        }, 500);
                    } else {
                        document.getElementById("snackbar").innerHTML = "Profile picture has been update.";
                        showSnackBar();
                    }
                } else {
                    var msg1 = document.getElementById("snackbar");
                    var msg2 = document.getElementById("snackbarbtn");
                    if (msg1.classList.contains("show")) {
                        msg1.className = "hide";
                        setTimeout(function() {
                            msg1.className = msg1.className.replace("hide", "");
                            document.getElementById("snackbar").innerHTML = text;
                            showSnackBar();
                        }, 500);
                    } else if (msg2.classList.contains("show")) {
                        msg2.className = "hide";
                        setTimeout(function() {
                            msg2.className = msg2.className.replace("hide", "");
                            document.getElementById("snackbar").innerHTML = text;
                            showSnackBar();
                        }, 500);
                    } else {
                        document.getElementById("snackbar").innerHTML = text;
                        showSnackBar();
                    }

                }
            }

        }
        r.open("POST", "updateProfileImg.php", true);
        r.send(form);

    }
}

function userDetailsLoader() {
    var r = new XMLHttpRequest();

    r.onreadystatechange = function() {
        if (r.readyState == 4) {
            loaderEnd();
            var text = r.responseText;
            document.getElementById("userDetails").innerHTML = text;
        } else {
            loader();
        }
    };
    r.open("POST", "userDetails.php", true);
    r.send();
}

function pagekeyup2(event) {
    var key = event.which;

    if (key == 13) {
        var editbtn = document.getElementById("PFedit");
        var updatebtn = document.getElementById("PFupdate")

        if (editbtn.classList.contains("d-none")) {
            if (document.getElementById("fname") == document.activeElement) {
                document.getElementById("lname").focus();
            } else if (document.getElementById("lname") == document.activeElement) {
                document.getElementById("PFmobile").focus();
            } else if (document.getElementById("PFmobile") == document.activeElement) {
                if (document.getElementById("PFgender") != null) {
                    document.getElementById("PFgender").focus();
                } else {
                    updateProfile();
                }
            } else {
                updateProfile();
            }

        } else if (updatebtn.classList.contains("d-none")) {
            editPF();
        }
    }

}

function updateProfile() {


    var form = new FormData();

    var fname = document.getElementById("fname");
    var lname = document.getElementById("lname");
    var mobile = document.getElementById("PFmobile");
    form.append("fname", fname.value);
    form.append("lname", lname.value);
    form.append("mobile", mobile.value);

    if (document.getElementById("PFVgender") != null) {
        var gender = document.getElementById("PFgender");
        form.append("gender", gender.value);
    }


    var addressline1_1 = document.getElementById("addressline1_1");
    var addressline2_1 = document.getElementById("addressline2_1");
    var city1 = document.getElementById("city1");
    form.append("addressline1_1", addressline1_1.value);
    form.append("addressline2_1", addressline2_1.value);
    form.append("city1", city1.value);

    if (document.getElementById("PFaddress2") != null) {
        var addressline1_2 = document.getElementById("addressline1_2");
        var addressline2_2 = document.getElementById("addressline2_2");
        var city1 = document.getElementById("city2");
        form.append("addressline1_2", addressline1_2.value);
        form.append("addressline2_2", addressline2_2.value);
        form.append("city2", city2.value);
    }

    if (document.getElementById("PFaddress3") != null) {
        var addressline1_3 = document.getElementById("addressline1_3");
        var addressline2_3 = document.getElementById("addressline2_3");
        var city1 = document.getElementById("city3");
        form.append("addressline1_3", addressline1_3.value);
        form.append("addressline2_3", addressline2_3.value);
        form.append("city3", city3.value);
    }

    var r = new XMLHttpRequest();

    r.onreadystatechange = function() {

        if (r.readyState == 4) {
            var text = r.responseText;
            if (text == "success") {
                userDetailsLoader();
                var msg1 = document.getElementById("snackbar");
                var msg2 = document.getElementById("snackbarbtn");
                if (msg1.classList.contains("show")) {
                    msg1.className = "hide";
                    setTimeout(function() {
                        msg1.className = msg1.className.replace("hide", "");
                        document.getElementById("snackbar").innerHTML = "Your profile has been update.";
                        showSnackBar();
                    }, 500);
                } else if (msg2.classList.contains("show")) {
                    msg2.className = "hide";
                    setTimeout(function() {
                        msg2.className = msg2.className.replace("hide", "");
                        document.getElementById("snackbar").innerHTML = "Your profile has been update.";
                        showSnackBar();
                    }, 500);
                } else {
                    document.getElementById("snackbar").innerHTML = "Your profile has been update.";
                    showSnackBar();
                }

            } else {
                var msg1 = document.getElementById("snackbar");
                var msg2 = document.getElementById("snackbarbtn");
                if (msg1.classList.contains("show")) {
                    msg1.className = "hide";
                    setTimeout(function() {
                        msg1.className = msg1.className.replace("hide", "");
                        document.getElementById("snackbar").innerHTML = text;
                        showSnackBar();
                    }, 500);
                } else if (msg2.classList.contains("show")) {
                    msg2.className = "hide";
                    setTimeout(function() {
                        msg2.className = msg2.className.replace("hide", "");
                        document.getElementById("snackbar").innerHTML = text;
                        showSnackBar();
                    }, 500);
                } else {
                    document.getElementById("snackbar").innerHTML = text;
                    showSnackBar();
                }
            }
        }
    };
    r.open("POST", "updateProfileProcess.php", true);
    r.send(form);

}

function loadproducts(start) {
    var productdiv = document.getElementById("myproducts");
    var num_columns = document.getElementById("columns").value;
    var num_rows = document.getElementById("rows").value;
    var category = document.getElementById("category");
    var search = document.getElementById("search");

    var rows = num_rows;
    var columns = num_columns;

    if (rows == '0') {
        document.getElementById("rows").value = '3';
        rows = '3';
    }

    if (rows == '') {
        rows = '3';
        document.getElementById("rows").placeholder = "3";
    }

    if (columns == '0') {
        document.getElementById("columns").value = '2';
        columns = '2';
    }

    if (columns > '4') {
        document.getElementById("columns").value = '4';
        columns = '4';
    }

    if (columns == '') {
        columns = '2';
        document.getElementById("columns").placeholder = "2";
    }

    var age;

    if (document.getElementById("ntoo").checked) {
        age = 1;
    } else if (document.getElementById("oton").checked) {
        age = 2;
    } else {
        age = 0;
    }

    var status;

    if (document.getElementById("active").checked) {
        status = 1;
    } else if (document.getElementById("deactive").checked) {
        status = 2;
    } else {
        status = 0;
    }

    var stock;

    if (document.getElementById("avblstock").checked) {
        stock = 1;
    } else if (document.getElementById("uavblstock").checked) {
        stock = 2;
    } else {
        stock = 0;
    }

    var sort;

    if (document.getElementById("atoz").checked) {
        sort = 1;
    } else if (document.getElementById("ztoa").checked) {
        sort = 2;
    } else {
        sort = 0;
    }

    var qty;

    if (document.getElementById("ltoh").checked) {
        qty = 1;
    } else if (document.getElementById("htol").checked) {
        qty = 2;
    } else {
        qty = 0;
    }

    var condition;

    if (document.getElementById("new").checked) {
        condition = 1;
    } else if (document.getElementById("used").checked) {
        condition = 2;
    } else {
        condition = 0;
    }


    var form = new FormData();
    form.append("columns", columns);
    form.append("rows", rows);
    form.append("start", start);
    form.append("age", age);
    form.append("status", status);
    form.append("stock", stock);
    form.append("sort", sort);
    form.append("qty", qty);
    form.append("condition", condition);
    form.append("search", search.value);
    form.append("category", category.value);

    var r = new XMLHttpRequest();

    r.onreadystatechange = function() {
        if (r.readyState == 4) {
            var text = r.responseText;
            productdiv.innerHTML = text;
        }
    };
    r.open("POST", "myProductSort.php", true);
    r.send(form);

}

function scrolToMyProducts() {
    document.getElementById('clearFilters').scrollIntoView({
        block: 'start',
        behavior: 'smooth',
    });
}

function scrolToSearch() {
    document.getElementById('rows').scrollIntoView({
        block: 'start',
        behavior: 'smooth',
    });
}

function scrolToSearch2() {
    document.getElementById('search').scrollIntoView({
        block: 'start',
        behavior: 'smooth',
    });
}


function changeStatus(id, qty) {

    var productId = id;
    var statusChange = document.getElementById("toggle" + productId);
    var statusLable = document.getElementById("statusLable" + productId);
    var warningIcon = document.getElementById("warningIcon" + productId);
    var flipCard = document.getElementById("flip-card-nontransform" + productId);
    var content1 = document.getElementById("content1" + productId);
    var content2 = document.getElementById("content2" + productId);

    var status;
    if (statusChange.checked) {
        status = 1;
    } else {
        status = 0;
    }

    var r = new XMLHttpRequest();
    r.onreadystatechange = function() {
        if (r.readyState == 4) {
            var text = r.responseText;
            if (text == 'Deactivated') {
                statusLable.innerHTML = "Make Your Product Active";
                content1.style.opacity = "0.5";
                content2.style.opacity = "0.5";
                if (qty < 3) {
                    warningIcon.classList.toggle("d-none");
                    flipCard.style.boxShadow = "0 6px 10px 0 rgba(0, 0, 0, 0.2)";
                    flipCard.style.border = "none";
                }
            } else if (text == 'Activated') {
                statusLable.innerHTML = "Make Your Product Deactive";
                content1.style.opacity = "1";
                content2.style.opacity = "1";
                if (qty < 3) {
                    warningIcon.classList.toggle("d-none");
                    flipCard.style.boxShadow = "0 10px 16px 0 rgba(255, 0, 0, 0.2)";
                    flipCard.style.border = "solid red 3px";
                }
            }
        }
    }

    r.open("GET", "statusChangeProcess.php?p=" + productId + "&s=" + status, true);
    r.send();

}

function clearfilters() {
    window.location = "myProducts.php";
    document.getElementById('clearFilters').scrollIntoView({
        block: 'start',
        behavior: 'smooth',
    });
}

function selectImg(id) {
    var mydiv = document.getElementById("loadImg" + id);
    mydiv.classList.add("border-secondary");
    document.getElementById("mainImg").src = document.getElementById("pimg" + id).src;
}

function qty_inc(max) {
    var qty = document.getElementById("qtyinput");
    if (qty.value == '' || qty.value == '0') {
        qty.value = 1;
    } else if (qty.value < max) {
        var newValue = parseInt(qty.value) + 1;
        qty.value = newValue.toString();
    } else {
        var msg1 = document.getElementById("snackbar");
        var msg2 = document.getElementById("snackbarbtn");
        if (msg1.classList.contains("show")) {
            msg1.className = "hide";
            setTimeout(function() {
                msg1.className = msg1.className.replace("hide", "");
                document.getElementById("snackbar").innerHTML = "Maximum quantity has achieved.";
                showSnackBar();
            }, 500);
        } else if (msg2.classList.contains("show")) {
            msg2.className = "hide";
            setTimeout(function() {
                msg2.className = msg2.className.replace("hide", "");
                document.getElementById("snackbar").innerHTML = "Maximum quantity has achieved.";
                showSnackBar();
            }, 500);
        } else {
            document.getElementById("snackbar").innerHTML = "Maximum quantity has achieved.";
            showSnackBar();
        }
    }

}

function qty_dec(max) {
    var qty = document.getElementById("qtyinput");
    if (qty.value == '' || qty.value == '0') {
        qty.value = 1;
    } else if (qty.value > 1) {
        var newValue = parseInt(qty.value) - 1;
        qty.value = newValue.toString();
    } else {
        var msg1 = document.getElementById("snackbar");
        var msg2 = document.getElementById("snackbarbtn");
        if (msg1.classList.contains("show")) {
            msg1.className = "hide";
            setTimeout(function() {
                msg1.className = msg1.className.replace("hide", "");
                document.getElementById("snackbar").innerHTML = "Minimum quantity has achieved.";
                showSnackBar();
            }, 500);
        } else if (msg2.classList.contains("show")) {
            msg2.className = "hide";
            setTimeout(function() {
                msg2.className = msg2.className.replace("hide", "");
                document.getElementById("snackbar").innerHTML = "Minimum quantity has achieved.";
                showSnackBar();
            }, 500);
        } else {
            document.getElementById("snackbar").innerHTML = "Minimum quantity has achieved.";
            showSnackBar();
        }
    }

}

function addWishlistHome(id) {
    var r = new XMLHttpRequest();

    var form = new FormData();

    form.append("id", id);
    form.append("qty", '1');

    r.onreadystatechange = function() {
        if (r.readyState == 4) {
            var text = r.responseText;

            if (text == "success") {
                window.location.reload();
            } else {
                var msg1 = document.getElementById("snackbar");
                var msg2 = document.getElementById("snackbarbtn");
                if (msg1.classList.contains("show")) {
                    msg1.className = "hide";
                    setTimeout(function() {
                        msg1.className = msg1.className.replace("hide", "");
                        document.getElementById("snackbar").innerHTML = text;
                        showSnackBar();
                    }, 500);
                } else if (msg2.classList.contains("show")) {
                    msg2.className = "hide";
                    setTimeout(function() {
                        msg2.className = msg2.className.replace("hide", "");
                        document.getElementById("snackbar").innerHTML = text;
                        showSnackBar();
                    }, 500);
                } else {
                    document.getElementById("snackbar").innerHTML = text;
                    showSnackBar();
                }
            }

        }
    }

    r.open("POST", "addWishlistProcess.php", true);
    r.send(form);
}

function addWishlist(id) {
    var r = new XMLHttpRequest();

    var qty = document.getElementById("qtyinput");

    var form = new FormData();

    form.append("id", id);
    form.append("qty", qty.value);

    r.onreadystatechange = function() {
        if (r.readyState == 4) {
            var text = r.responseText;

            if (text == "success") {
                window.location.reload();
            } else {
                var msg1 = document.getElementById("snackbar");
                var msg2 = document.getElementById("snackbarbtn");
                if (msg1.classList.contains("show")) {
                    msg1.className = "hide";
                    setTimeout(function() {
                        msg1.className = msg1.className.replace("hide", "");
                        document.getElementById("snackbar").innerHTML = text;
                        showSnackBar();
                    }, 500);
                } else if (msg2.classList.contains("show")) {
                    msg2.className = "hide";
                    setTimeout(function() {
                        msg2.className = msg2.className.replace("hide", "");
                        document.getElementById("snackbar").innerHTML = text;
                        showSnackBar();
                    }, 500);
                } else {
                    document.getElementById("snackbar").innerHTML = text;
                    showSnackBar();
                }
            }

        }
    }

    r.open("POST", "addWishlistProcess.php", true);
    r.send(form);
}

function removeWishlist(id) {
    var r = new XMLHttpRequest();

    r.onreadystatechange = function() {
        if (r.readyState == 4) {
            var text = r.responseText;

            if (text == "success") {
                window.location.reload();
            } else {
                var msg1 = document.getElementById("snackbar");
                var msg2 = document.getElementById("snackbarbtn");
                if (msg1.classList.contains("show")) {
                    msg1.className = "hide";
                    setTimeout(function() {
                        msg1.className = msg1.className.replace("hide", "");
                        document.getElementById("snackbar").innerHTML = text;
                        showSnackBar();
                    }, 500);
                } else if (msg2.classList.contains("show")) {
                    msg2.className = "hide";
                    setTimeout(function() {
                        msg2.className = msg2.className.replace("hide", "");
                        document.getElementById("snackbar").innerHTML = text;
                        showSnackBar();
                    }, 500);
                } else {
                    document.getElementById("snackbar").innerHTML = text;
                    showSnackBar();
                }
            }

        }
    }

    r.open("GET", "removeWishlistProcess.php?id=" + id, true);
    r.send();
}

function loadIndex() {
    var msg1 = document.getElementById("snackbar");
    var msg2 = document.getElementById("snackbarbtn");
    if (msg1.classList.contains("show")) {
        msg1.className = "hide";
        setTimeout(function() {
            msg1.className = msg1.className.replace("hide", "");
            document.getElementById("snackbarmsg").innerHTML = "Please SignIn first. Do you want to signIn?";
            showSnackBarBtn();
        }, 500);
    } else if (msg2.classList.contains("show")) {
        msg2.className = "hide";
        setTimeout(function() {
            msg2.className = msg2.className.replace("hide", "");
            document.getElementById("snackbarmsg").innerHTML = "Please SignIn first. Do you want to signIn?";
            showSnackBarBtn();
        }, 500);
    } else {
        document.getElementById("snackbarmsg").innerHTML = "Please SignIn first. Do you want to signIn?";
        showSnackBarBtn();
    }

    document.getElementById("ok").onclick = function() {
        window.location = "Index.php";
        var y = document.getElementById("snackbarbtn");
        y.className = "hide";
        setTimeout(function() {
            y.className = y.className.replace("hide", "");
        }, 500);
    }
    document.getElementById("cancel").onclick = function() {
        var y = document.getElementById("snackbarbtn");
        y.className = "hide";
        setTimeout(function() {
            y.className = y.className.replace("hide", "");
        }, 500);
    }
}

function addtoCart(id) {
    var r = new XMLHttpRequest();

    var qty = document.getElementById("qtyinput");

    var form = new FormData();

    form.append("id", id);
    form.append("qty", qty.value);

    r.onreadystatechange = function() {
        if (r.readyState == 4) {
            var text = r.responseText;

            var msg1 = document.getElementById("snackbar");
            var msg2 = document.getElementById("snackbarbtn");
            if (msg1.classList.contains("show")) {
                msg1.className = "hide";
                setTimeout(function() {
                    msg1.className = msg1.className.replace("hide", "");
                    document.getElementById("snackbar").innerHTML = text;
                    showSnackBar();
                }, 500);
            } else if (msg2.classList.contains("show")) {
                msg2.className = "hide";
                setTimeout(function() {
                    msg2.className = msg2.className.replace("hide", "");
                    document.getElementById("snackbar").innerHTML = text;
                    showSnackBar();
                }, 500);
            } else {
                document.getElementById("snackbar").innerHTML = text;
                showSnackBar();
            }


        }
    }

    r.open("POST", "addToCartProcess.php", true);
    r.send(form);
}

function addtoCartH(id) {
    var r = new XMLHttpRequest();

    var qty = document.getElementById("qtyinput");

    var form = new FormData();

    form.append("id", id);
    form.append("qty", '1');

    r.onreadystatechange = function() {
        if (r.readyState == 4) {
            var text = r.responseText;

            var msg1 = document.getElementById("snackbar");
            var msg2 = document.getElementById("snackbarbtn");
            if (msg1.classList.contains("show")) {
                msg1.className = "hide";
                setTimeout(function() {
                    msg1.className = msg1.className.replace("hide", "");
                    document.getElementById("snackbar").innerHTML = text;
                    showSnackBar();
                }, 500);
            } else if (msg2.classList.contains("show")) {
                msg2.className = "hide";
                setTimeout(function() {
                    msg2.className = msg2.className.replace("hide", "");
                    document.getElementById("snackbar").innerHTML = text;
                    showSnackBar();
                }, 500);
            } else {
                document.getElementById("snackbar").innerHTML = text;
                showSnackBar();
            }


        }
    }

    r.open("POST", "addToCartProcess.php", true);
    r.send(form);
}

function removeCart(id) {
    var r = new XMLHttpRequest();

    r.onreadystatechange = function() {
        if (r.readyState == 4) {
            var text = r.responseText;

            if (text == "success") {
                window.location.reload();
            } else {
                var msg1 = document.getElementById("snackbar");
                var msg2 = document.getElementById("snackbarbtn");
                if (msg1.classList.contains("show")) {
                    msg1.className = "hide";
                    setTimeout(function() {
                        msg1.className = msg1.className.replace("hide", "");
                        document.getElementById("snackbar").innerHTML = text;
                        showSnackBar();
                    }, 500);
                } else if (msg2.classList.contains("show")) {
                    msg2.className = "hide";
                    setTimeout(function() {
                        msg2.className = msg2.className.replace("hide", "");
                        document.getElementById("snackbar").innerHTML = text;
                        showSnackBar();
                    }, 500);
                } else {
                    document.getElementById("snackbar").innerHTML = text;
                    showSnackBar();
                }
            }

        }
    }

    r.open("GET", "removeCartProcess.php?id=" + id, true);
    r.send();
}

function removeWishlistAddCart(id) {
    var r = new XMLHttpRequest();

    var form = new FormData();

    form.append("id", id);

    r.onreadystatechange = function() {
        if (r.readyState == 4) {
            var text = r.responseText;

            if (text == 'Move Product to the cart') {
                window.location.reload();
            } else {

                var msg1 = document.getElementById("snackbar");
                var msg2 = document.getElementById("snackbarbtn");
                if (msg1.classList.contains("show")) {
                    msg1.className = "hide";
                    setTimeout(function() {
                        msg1.className = msg1.className.replace("hide", "");
                        document.getElementById("snackbar").innerHTML = text;
                        showSnackBar();
                    }, 500);
                } else if (msg2.classList.contains("show")) {
                    msg2.className = "hide";
                    setTimeout(function() {
                        msg2.className = msg2.className.replace("hide", "");
                        document.getElementById("snackbar").innerHTML = text;
                        showSnackBar();
                    }, 500);
                } else {
                    document.getElementById("snackbar").innerHTML = text;
                    showSnackBar();
                }

            }

        }
    }

    r.open("POST", "wishlistToCartProcess.php", true);
    r.send(form);
}

function loadInbox(from) {

    if (refreshChat != 0) {
        clearInterval(refreshChat);
    }
    chatLoad(from);
    var form = new FormData();
    form.append("from", from);

    var r = new XMLHttpRequest();

    r.onreadystatechange = function() {
        if (r.readyState == 4) {
            var text = r.responseText;
            document.getElementById('inbox').innerHTML = text;
        }
    };
    r.open("POST", "inbox.php", true);
    r.send(form);
}

var refreshChat = 0;

function chatLoad(reciver) {

    refreshChat = setInterval(function() {
        var form = new FormData();
        form.append("reciver", reciver);

        var r = new XMLHttpRequest();

        r.onreadystatechange = function() {
            if (r.readyState == 4) {
                var text = r.responseText;
                document.getElementById('chat').innerHTML = text;
            }
        };
        r.open("POST", "chatContent.php", true);
        r.send(form);
    }, 50);
}


function sendMsg(receiver) {

    var msg = document.getElementById("msg");

    var f = new FormData();
    f.append("receiver", receiver);
    f.append("msg", msg.value);

    var r = new XMLHttpRequest();

    r.onreadystatechange = function() {
        if (r.readyState == 4) {
            var t = r.responseText;
            if (t == "success") {
                loadInbox(receiver);
            } else {
                alert(t);
            }

        }
    }

    r.open("POST", "sendMsgProcess.php", true);
    r.send(f);

}

function buyNow(id) {
    var qty = document.getElementById("qtyinput").value;
    window.location = "buynow.php?id=" + id + "&qty=" + qty;
}

function buyNowH(id) {
    window.location = "buynow.php?id=" + id + "&qty=" + 1;
}

function adminSignIn() {
    var email = document.getElementById("adminEmail");

    var r = new XMLHttpRequest();

    r.onreadystatechange = function() {
        if (r.readyState == 4) {
            loaderEnd();
            var text = r.responseText;
            if (text == "Success") {
                document.getElementById("adminmodal").style.display = "block";
            } else {
                document.getElementById("amsg").innerHTML = text;
            }
        } else {
            loader();
        }
    };
    r.open("GET", "adminVerificationProcess.php?email=" + email.value, true);
    r.send();
}

function closeAdminModel() {
    document.getElementById("adminmodal").style.display = "none";
}

function adminLogin() {

    var id = document.getElementById("vc").value;

    var r = new XMLHttpRequest();

    r.onreadystatechange = function() {
        if (r.readyState == 4) {
            loaderEnd();
            var text = r.responseText;
            if (text == "success") {
                window.location = "adminpanel.php";
            } else {
                alert(text);
            }
        } else {
            loader();
        }
    };
    r.open("GET", "verifyProcess.php?id=" + id, true);
    r.send();
}

function printInvoice() {

    var page = document.getElementById("Invoicepage").innerHTML;
    var restorePage = document.body.innerHTML;
    document.body.innerHTML = page;
    window.print();
    document.body.innerHTML = restorePage;

}


function addproduct() {
    var category = document.getElementById("category");
    var brand = document.getElementById("brand");
    var model = document.getElementById("model");
    var title = document.getElementById("title");

    var condition = 0;

    if (document.getElementById("bn").checked) {
        condition = 1;
    } else if (document.getElementById("us").checked) {
        condition = 2;
    }

    var color = 0;

    if (document.getElementById("c1").checked) {
        color = 1;
    } else if (document.getElementById("c2").checked) {
        color = 2;
    } else if (document.getElementById("c3").checked) {
        color = 3;
    } else if (document.getElementById("c4").checked) {
        color = 4;
    } else if (document.getElementById("c5").checked) {
        color = 5;
    } else if (document.getElementById("c6").checked) {
        color = 6;
    }

    var qty = document.getElementById("qty");
    var price = document.getElementById("cost");
    var delivery_within_colombo = document.getElementById("dwc");
    var delivery_outof_colombo = document.getElementById("doc");
    var description = document.getElementById("description");
    var warranty = document.getElementById("warranty");
    var discount = document.getElementById("discount");
    var image1 = document.getElementById("imageUploder1");
    var image2 = document.getElementById("imageUploder2");
    var image3 = document.getElementById("imageUploder3");

    var f = new FormData();
    f.append("c", category.value);
    f.append("b", brand.value);
    f.append("m", model.value);
    f.append("t", title.value);
    f.append("co", condition);
    f.append("col", color);
    f.append("qty", qty.value);
    f.append("warranty", warranty.value);
    f.append("p", price.value);
    f.append("discount", discount.value);
    f.append("dwc", delivery_within_colombo.value);
    f.append("doc", delivery_outof_colombo.value);
    f.append("desc", description.value);
    f.append("img1", image1.files[0]);
    f.append("img2", image2.files[0]);
    f.append("img3", image3.files[0]);

    var r = new XMLHttpRequest();
    r.onreadystatechange = function() {
        if (r.readyState == 4) {
            var text = r.responseText;
            if (text == "Product added successfully") {
                window.location.reload();
            } else {
                var msg1 = document.getElementById("snackbar");
                var msg2 = document.getElementById("snackbarbtn");
                if (msg1.classList.contains("show")) {
                    msg1.className = "hide";
                    setTimeout(function() {
                        msg1.className = msg1.className.replace("hide", "");
                        document.getElementById("snackbar").innerHTML = text;
                        showSnackBar();
                    }, 500);
                } else if (msg2.classList.contains("show")) {
                    msg2.className = "hide";
                    setTimeout(function() {
                        msg2.className = msg2.className.replace("hide", "");
                        document.getElementById("snackbar").innerHTML = text;
                        showSnackBar();
                    }, 500);
                } else {
                    document.getElementById("snackbar").innerHTML = text;
                    showSnackBar();
                }

            }

        } else {

        }
    }

    r.open("POST", "addproductprocess.php", true);
    r.send(f);

}

function changeProductImg1() {

    var image = document.getElementById("imageUploder1");
    var view = document.getElementById("preview0");

    image.onchange = function() {


        var file = this.files[0];
        var url = window.URL.createObjectURL(file);
        view.src = url;

    }

}

function changeProductImg2() {

    var image = document.getElementById("imageUploder2");
    var view = document.getElementById("preview1");

    image.onchange = function() {


        var file = this.files[0];
        var url = window.URL.createObjectURL(file);
        view.src = url;

    }

}

function changeProductImg3() {

    var image = document.getElementById("imageUploder3");
    var view = document.getElementById("preview2");

    image.onchange = function() {


        var file = this.files[0];
        var url = window.URL.createObjectURL(file);
        view.src = url;

    }

}

function payNow(id) {
    // alert(id);

    var qty = document.getElementById("qtyinput").value;
    // alert(qty);

    var r = new XMLHttpRequest();

    r.onreadystatechange = function() {
        if (r.readyState == 4) {
            var t = r.responseText;
            var obj = JSON.parse(t);

            var mail = obj["mail"];
            var amount = obj["amount"];

            if (t == "1") {

                alert("Please log in or sign up");
                window.location = "index.php";

            } else if (t == "2") {

                alert("Please update your profile first");
                window.location = "myProfile.php";

            } else {

                // Payment completed. It can be a successful failure.
                payhere.onCompleted = function onCompleted(orderId) {

                    saveInvoice(orderId, id, qty);
                    console.log("Payment completed. OrderID:" + orderId);
                    // Note: validate the payment and show success or failure page to the customer
                };

                // Payment window closed
                payhere.onDismissed = function onDismissed() {
                    // Note: Prompt user to pay again or show an error page
                    console.log("Payment dismissed");
                };

                // Error occurred
                payhere.onError = function onError(error) {
                    // Note: show an error page
                    console.log("Error:" + error);
                };

                // Put the payment variables here
                var payment = {
                    "sandbox": true,
                    "merchant_id": "1221409", // Replace your Merchant ID
                    "return_url": "http://localhost/avrenes.lk/singleProductView.php?id" + id, // Important
                    "cancel_url": "http://localhost/avrenes.lk/singleProductView.php?id" + id, // Important
                    "notify_url": "http://sample.com/notify",
                    "order_id": obj["id"],
                    "items": obj["item"],
                    "amount": amount,
                    "currency": "LKR",
                    "first_name": obj["fname"],
                    "last_name": obj["lname"],
                    "email": mail,
                    "phone": obj["mobile"],
                    "address": obj["address"],
                    "city": obj["city"],
                    "country": "Sri Lanka",
                    "delivery_address": obj["address"],
                    "delivery_city": obj["city"],
                    "delivery_country": "Sri Lanka",
                    "custom_1": "",
                    "custom_2": ""
                };

                // Show the payhere.js popup, when "PayHere Pay" is clicked
                // document.getElementById('payhere-payment').onclick = function(e) {
                payhere.startPayment(payment);

                // };
            }

        }
    };

    r.open("GET", "buyNowProcess.php?id=" + id + "&qty=" + qty, true);
    r.send();

}

function saveInvoice(orderId, id, qty) {

    window.location = "buynowinvoice.php?id=" + id + "&qty=" + qty + "&orderId=" + orderId;

}

function updateProduct(id) {
    window.location = "updateproduct.php?id=" + id;
}

function changeProduct(id) {

    var category = document.getElementById("category");
    var brand = document.getElementById("brand");
    var model = document.getElementById("model");
    var title = document.getElementById("title");

    var condition = 0;

    if (document.getElementById("bn").checked) {
        condition = 1;
    } else if (document.getElementById("us").checked) {
        condition = 2;
    }

    var color = 0;

    if (document.getElementById("c1").checked) {
        color = 1;
    } else if (document.getElementById("c2").checked) {
        color = 2;
    } else if (document.getElementById("c3").checked) {
        color = 3;
    } else if (document.getElementById("c4").checked) {
        color = 4;
    } else if (document.getElementById("c5").checked) {
        color = 5;
    } else if (document.getElementById("c6").checked) {
        color = 6;
    }

    var qty = document.getElementById("qty");
    var price = document.getElementById("cost");
    var delivery_within_colombo = document.getElementById("dwc");
    var delivery_outof_colombo = document.getElementById("doc");
    var description = document.getElementById("description");
    var warranty = document.getElementById("warranty");
    var discount = document.getElementById("discount");
    var image1 = document.getElementById("imageUploder1");
    var image2 = document.getElementById("imageUploder2");
    var image3 = document.getElementById("imageUploder3");

    var f = new FormData();
    f.append("id", id);
    f.append("c", category.value);
    f.append("b", brand.value);
    f.append("m", model.value);
    f.append("t", title.value);
    f.append("co", condition);
    f.append("col", color);
    f.append("qty", qty.value);
    f.append("warranty", warranty.value);
    f.append("p", price.value);
    f.append("discount", discount.value);
    f.append("dwc", delivery_within_colombo.value);
    f.append("doc", delivery_outof_colombo.value);
    f.append("desc", description.value);
    f.append("img1", image1.files[0]);
    f.append("img2", image2.files[0]);
    f.append("img3", image3.files[0]);

    var r = new XMLHttpRequest();

    r.onreadystatechange = function() {
        if (r.readyState == 4) {
            var text = r.responseText;

            var msg1 = document.getElementById("snackbar");
            var msg2 = document.getElementById("snackbarbtn");
            if (msg1.classList.contains("show")) {
                msg1.className = "hide";
                setTimeout(function() {
                    msg1.className = msg1.className.replace("hide", "");
                    document.getElementById("snackbar").innerHTML = text;
                    showSnackBar();
                }, 500);
            } else if (msg2.classList.contains("show")) {
                msg2.className = "hide";
                setTimeout(function() {
                    msg2.className = msg2.className.replace("hide", "");
                    document.getElementById("snackbar").innerHTML = text;
                    showSnackBar();
                }, 500);
            } else {
                document.getElementById("snackbar").innerHTML = text;
                showSnackBar();
            }
        }
    }

    r.open("POST", "updateProcess.php", true);
    r.send(f);

}

function search() {
    document.getElementById("allproduct").classList.add("d-none");

    var r = new XMLHttpRequest();

    r.onreadystatechange = function() {
        if (r.readyState == 4) {
            loaderEnd();
            var text = r.responseText;
            document.getElementById("serchproduct").innerHTML = text;
        } else {
            loader();
        }
    };
    r.open("POST", "searchContent.php", true);
    r.send();

}

function loadproducts2(start) {
    var productdiv = document.getElementById("myproducts");
    var category = document.getElementById("category");
    var search = document.getElementById("search");

    var rows = 10;
    var columns = 1;


    var age;

    if (document.getElementById("ntoo").checked) {
        age = 1;
    } else if (document.getElementById("oton").checked) {
        age = 2;
    } else {
        age = 0;
    }

    var status;
    status = 1;

    var stock;

    if (document.getElementById("avblstock").checked) {
        stock = 1;
    } else if (document.getElementById("uavblstock").checked) {
        stock = 2;
    } else {
        stock = 0;
    }

    var sort;

    if (document.getElementById("atoz").checked) {
        sort = 1;
    } else if (document.getElementById("ztoa").checked) {
        sort = 2;
    } else {
        sort = 0;
    }

    var qty;

    if (document.getElementById("ltoh").checked) {
        qty = 1;
    } else if (document.getElementById("htol").checked) {
        qty = 2;
    } else {
        qty = 0;
    }

    var condition;

    if (document.getElementById("new").checked) {
        condition = 1;
    } else if (document.getElementById("used").checked) {
        condition = 2;
    } else {
        condition = 0;
    }


    var form = new FormData();
    form.append("columns", columns);
    form.append("rows", rows);
    form.append("start", start);
    form.append("age", age);
    form.append("status", status);
    form.append("stock", stock);
    form.append("sort", sort);
    form.append("qty", qty);
    form.append("condition", condition);
    form.append("search", search.value);
    form.append("category", category.value);

    var r = new XMLHttpRequest();

    r.onreadystatechange = function() {
        if (r.readyState == 4) {
            var text = r.responseText;
            productdiv.innerHTML = text;
        }
    };
    r.open("POST", "myProductSort2.php", true);
    r.send(form);

}

function checkout() {

    var r = new XMLHttpRequest();

    r.onreadystatechange = function() {
        if (r.readyState == 4) {
            loaderEnd();
            var text = r.responseText;
            if (text == "success") {
                window.location = "invoice.php";
            } else {
                alert(text);
            }
        } else {
            loader();
        }
    };
    r.open("GET", "checkoutprocess.php", true);
    r.send();
}