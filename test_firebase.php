<!DOCTYPE html>
<html>

<head>
    <title>Firebase Phone Auth</title>
    <script src="https://www.gstatic.com/firebasejs/9.0.0/firebase-app.js"></script>
    <script src="https://www.gstatic.com/firebasejs/9.0.0/firebase-auth.js"></script>
</head>

<body>
    <h1>Phone Authentication</h1>
    <input type="text" id="phone-number" placeholder="Enter your phone number" />
    <button id="sign-in-button">Send Verification Code</button>

    <!-- For visible reCAPTCHA -->
    <div id="recaptcha-container"></div>

    <input type="text" id="verification-code" placeholder="Enter verification code" />
    <button id="verify-button">Verify Code</button>

    <script>
        // Your Firebase configuration (same as above)
        const firebaseConfig = {
            apiKey: "AIzaSyDjREJR_gW7yYtyAr1XIcu0rtxPoaNbllA",
            authDomain: "vinufirstfirebasepro1.firebaseapp.com",
            projectId: "vinufirstfirebasepro1",
            storageBucket: "vinufirstfirebasepro1.appspot.com",
            messagingSenderId: "427196152043",
            appId: "1:427196152043:web:dd69e0ac2015d31797e6ae",
            measurementId: "G-WFQJ44F4ZP"
        };
        firebase.initializeApp(firebaseConfig);

        // Setting the language code (optional)
        firebase.auth().languageCode = 'it'; // Set to Italian

        // Setting up the reCAPTCHA verifier
        window.recaptchaVerifier = new firebase.auth.RecaptchaVerifier('recaptcha-container', {
            'size': 'normal',
            'callback': (response) => {
                // reCAPTCHA solved, allow signInWithPhoneNumber.
                onSignInSubmit();
            },
            'expired-callback': () => {
                // Response expired. Ask user to solve reCAPTCHA again.
                console.log("reCAPTCHA expired, please solve again.");
            }
        });

        // Send verification code
        function onSignInSubmit() {
            const phoneNumber = document.getElementById('phone-number').value;
            const appVerifier = window.recaptchaVerifier;

            firebase.auth().signInWithPhoneNumber(phoneNumber, appVerifier)
                .then((confirmationResult) => {
                    window.confirmationResult = confirmationResult;
                    console.log("SMS sent.");
                }).catch((error) => {
                    console.error("Error during signInWithPhoneNumber:", error);
                    grecaptcha.reset(window.recaptchaWidgetId); // Reset reCAPTCHA
                });
        }

        // Verify code
        document.getElementById('verify-button').addEventListener('click', function() {
            const verificationCode = document.getElementById('verification-code').value;

            window.confirmationResult.confirm(verificationCode).then((result) => {
                const user = result.user;
                console.log("User signed in successfully:", user);
            }).catch((error) => {
                console.error("Error verifying code:", error);
            });
        });
    </script>

</body>

</html>