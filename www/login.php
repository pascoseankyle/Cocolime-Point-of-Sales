<?php
?>
<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../styles/styles.css">
        <link rel="stylesheet" href="../styles/fontawesome/css/all.css">
    </head>
    <body class="no-scroll">
        <div class="div-login">
            <div class="login-card">
                <form method="POST" action="auth.php">
                    <h3>Cocolime</h3>
                    <br>
                    <p><i class="fas fa-user-lock"></i>&nbspLogin</p>
                    <br>
                    <hr>
                    <br>
                    <br>
                    <label for="username"><i class="fas fa-signature"></i>&nbsp<b>username</b></label>
                    <input type="text" name="username" id="username" required>
                    <br>
                    <br>
                    <label for="password"><i class="fas fa-key"></i>&nbsp<b>password</b></label>
                    <input type="password" name="password" id="password" required>
                    <br>
                    <br>
                    <button type="submit"><i class="fas fa-sign-in-alt"></i>&nbsp<b>Login<b></button>
                </form>
            </div> 
        </div>
    </body>
</html>