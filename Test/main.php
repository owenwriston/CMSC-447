<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Punch List Software</title>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="style.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    </head>

    <body style="display: flex; justify-content: center; padding: 50px">
        <!-- LOGIN SCREEN -->
        <div class="loginScreen" id="loginScreen">
            <h1>Login</h1>
            <form id="loginForm">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required><br><br>

                <label for="pwd">Password:</label>
                <input type="password" id="pwd" name="pwd" minlength="8" required><br><br>

                <input type="submit" value="Login">
            </form>
            <p id="loginStatus"></p>

            <p>
                No account?
                <a href="main.php?screen=createUser">Create account here</a>
            </p>
        </div>

        <!-- CREATE ACCOUNT SCREEN -->
        <div class="createAccScreen" id="createAccScreen" style="display: none;">
            <h1>Create Account</h1>
            <form id="createAccForm">
                <label for="ca_fname">First name:</label>
                <input type="text" id="ca_fname" name="fname" required><br><br>

                <label for="ca_lname">Last name:</label>
                <input type="text" id="ca_lname" name="lname" required><br><br>

                <label for="ca_email">Email:</label>
                <input type="email" id="ca_email" name="email" required><br><br>

                <label for="ca_pwd">Password:</label>
                <input type="password" id="ca_pwd" name="pwd" minlength="8" required><br><br>

                <label for="ca_company">Company:</label>
                <input type="text" id="ca_company" name="company" required><br><br>

                <label for="ca_role">Role:</label>
                <input type="text" id="ca_role" name="role" required><br><br>

                <input type="submit" value="Create Account">
            </form>
            <p id="createAccStatus"></p>
            <p><a href="main.php">Back to login</a></p> // return to login screen
        </div>

        <!-- PROJECT DASHBOARD SCREEN -->
        <div class="projDashboardScreen" id="projDashboardScreen" style="display: none;">
            <p class="introText">project dashboard here!</p>
        </div>

        <!-- PROJECT DISPLAY SCREEN -->
        <div class="projDisplayScreen" id="projDisplayScreen" style="display: none;">
            <p class="introText">project display here!</p>
        </div>

        <script>


            // Show the right screen based on ?screen= in the URL
            function showScreen() {
                const params = new URLSearchParams(window.location.search);
                const screen = params.get('screen');

                $('#loginScreen, #createAccScreen, #projDashboardScreen, #projDisplayScreen').hide();

                if (screen === 'createUser') {
                    $('#createAccScreen').show();
                } else if (screen === 'dashboard') {
                    $('#projDashboardScreen').show();
                } else if (screen === 'project') {
                    $('#projDisplayScreen').show();
                } else {
                    $('#loginScreen').show();
                }
            }
            showScreen();

            $('#loginForm').on('submit', function (e) {
                e.preventDefault(); // stop normal page reload / PHP submission

                const email = $('#email').val();
                const pwd = $('#pwd').val();

                fetch('http://localhost:8080/login', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ email: email, pwd: pwd })
                })
                .then(res => res.json())
                .then(data => {
                    $('#loginStatus').text('Server says: ' + data.status);
                })
                .catch(err => {
                    $('#loginStatus').text('Could not reach backend: ' + err);
                });
            });

            $('#createAccForm').on('submit', function (e) {
                e.preventDefault();

                const payload = {
                    fname: $('#ca_fname').val(),
                    lname: $('#ca_lname').val(),
                    email: $('#ca_email').val(),
                    pwd: $('#ca_pwd').val(),
                    company: $('#ca_company').val(),
                    role: $('#ca_role').val()
                };

                fetch('http://localhost:8080/createAccount', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(payload)
                })
                .then(res => res.json())
                .then(data => {
                    $('#createAccStatus').text('Server says: ' + data.status);
                })
                .catch(err => {
                    $('#createAccStatus').text('Could not reach backend: ' + err);
                });
            });
        </script>
    </body>
</html>
