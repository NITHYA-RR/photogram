<?php
include_once __DIR__ . "/../libs/includes/Session.class.php";
include_once __DIR__ . "/../libs/includes/User.class.php";
include_once __DIR__ . "/../libs/includes/UserSession.class.php";


//Check if session is already active before calling session_start()
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Handle logout request
if (isset($_GET['logout'])) {
    // Destroy the session
    session_unset();
    session_destroy();

    // Redirect to login.php with a logout message
    header("Location: login.php?message=logout");
    exit();
}

// If the user is already logged in, show "Welcome back"
if (isset($_SESSION['is_loggedin']) && $_SESSION['is_loggedin'] === true) {
    header("Location: index.php");
    exit();
}

// Handle login form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    $token = UserSession::authenticate($username, $password); // ✅ This does login & returns token
    if ($token) {
        Session::set('is_loggedin', true);
        Session::set('session_username', $username);
        Session::set('session_token', $token); // Optional - already done in authenticate

        Session::setUserSession(new UserSession($token)); // ✅ This now works

        header("Location: index.php");
        exit();
    }
    // Attempt login
    else {
?>
        <main class="container">
            <div style="background-color: #d1ecf1; color: #0c5460; padding: 15px; border-radius: 5px; border: 1px solid #bee5eb;">
                Please enter your username and password.
            </div>
        </main>
    <?php

    }
} else {
    ?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login</title>
        <link rel="stylesheet" href="styles.css">
    </head>

    <body>
        <main class="form-signin">
            <form method="post" action="login.php">

                <h1 class="h3 mb-3 fw-normal"><b>LOGIN</b></h1>

                <?php if (isset($_GET['error'])) { ?>

                    <div class="alert alert-danger" role="alert">
                        Invalid username or password.
                    </div>
                <?php } ?>
                <div class="form-floating">
                    <input name="username" type="text" class="form-control" id="floatingInput" placeholder="Username" required>
                    <label for="floatingInput">Username</label>
                </div>
                <div class="form-floating">
                    <input name="password" type="password" class="form-control" id="floatingPassword" placeholder="Password" required>
                    <label for="floatingPassword">Password</label>
                </div>

                <div class="checkbox mb-3">
                    <label>
                        <input type="checkbox" value="remember-me"> Remember me
                    </label>
                </div>
                <button class="w-100 btn btn-lg btn-primary" type="submit">Sign in</button>
                <a href="signup.php" class="w-100 btn btn-link">Not Rgistered yet? Sign up</a>
            </form>
        </main>
    </body>

    </html>

<?php
}
