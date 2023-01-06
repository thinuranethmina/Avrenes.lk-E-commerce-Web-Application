var googleUser = {};
var startApp = function() {
    gapi.load('auth2', function() {
        // Retrieve the singleton for the GoogleAuth library and set up the client.
        auth2 = gapi.auth2.init({
            client_id: '543021838547-nvq779knrg05ncodg28niggkfcat84us.apps.googleusercontent.com',
            cookiepolicy: 'single_host_origin',
            // Request scopes in addition to 'profile' and 'email'
            //scope: 'additional_scope'
        });
        attachSignin(document.getElementById('customBtn'));
    });
};

function attachSignin(element) {
    console.log(element.id);
    auth2.attachClickHandler(element, {},
        function(googleUser) {

            var profile = googleUser.getBasicProfile();

            var ID = profile.getId(); // Do not send to your backend! Use an ID token instead.
            var fname = profile.getGivenName();
            var mypic = profile.getImageUrl();
            var lname = profile.getFamilyName();
            var email = profile.getEmail(); // This is null if the 'email' scope is not present.

            var form = new FormData();
            form.append("fname", fname);
            form.append("lname", lname);
            form.append("email", email);
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

            r.open("POST", "SignInGoogle.php", true);
            r.send(form);

        },
        function(error) {
            document.getElementById("amsg").innerHTML = "SignIn error. Try again...";
            // document.getElementById("amsg").innerHTML = JSON.stringify(error, undefined, 2);
        });
}