function statusChangeCallback(response) { // Called with the results from FB.getLoginStatus().
    console.log('statusChangeCallback');
    console.log(response); // The current login status of the person.
    if (response.status === 'connected') { // Logged into your webpage and Facebook.
        testAPI();
    } else if (response.status === 'not_authorized') {
        document.getElementById("amsg").innerHTML = "SignIn error. Try again...";
        // The user hasn't authorized your application.  They
        // must click the Login button, or you must call FB.login
        // in response to a user gesture, to launch a login dialog.
    } else { // Not logged into your webpage or we are unable to tell.

    }
}


function checkLoginState() { // Called when a person is finished with the Login Button.
    FB.getLoginStatus(function(response) { // See the onlogin handler
        statusChangeCallback(response);
    });
}


window.fbAsyncInit = function() {
    FB.init({
        appId: '811113213283750',
        cookie: true, // Enable cookies to allow the server to access the session.
        xfbml: true, // Parse social plugins on this webpage.
        version: 'v12.0' // Use this Graph API version for this call.
    });


    FB.getLoginStatus(function(response) { // Called after the JS SDK has been initialized.
        statusChangeCallback(response); // Returns the login status.
    });
};

function testAPI() { // Testing Graph API after login.  See statusChangeCallback() for when this call is made.
    FB.api('/me?fields=first_name,last_name,email,gender,picture.type(large)',
        function(response) {

            var fname = response.first_name;
            var lname = response.last_name;
            var mypic = response.picture["data"]["url"];
            var gender = response.gender;
            var email = response.email;

            var form = new FormData();
            form.append("fname", fname);
            form.append("lname", lname);
            form.append("email", email);
            form.append("gender", gender);
            form.append("mypic", mypic);

            var r = new XMLHttpRequest();

            r.onreadystatechange = function() {
                if (r.readyState == 4) {
                    loaderEnd();
                    var text = r.responseText;
                    if (text == "success") {
                        window.location = "home.php";

                    } else {
                        document.getElementById("amsg").innerHTML = text;
                    }
                } else {
                    loader();
                }
            }

            r.open("POST", "SignInFacebook.php", true);
            r.send(form);

        });
}