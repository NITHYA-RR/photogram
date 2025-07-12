<?php
include_once __DIR__ . "/../libs/includes/Session.class.php";
include_once __DIR__ . "/../libs/includes/User.class.php";

if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

$signup = false;
$error = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = trim($_POST['username']);
  $password = trim($_POST['password']);
  $email = trim($_POST['email']);
  $phone = trim($_POST['phone']);

  // Try signup
  $error = User::signup($username, $password, $email, $phone);
  $signup = true;

  // ✅ Success: redirect to login page
  if (!$error) {
    header("Location: login.php?message=signup");
    exit();
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Signup</title>
  <link rel="stylesheet" href="styles.css">
</head>

<body class="text-center">
  <?php if ($signup && $error): ?>
    <div class="alert alert-danger">
      ❌ Signup failed! Please try again.
    </div>
  <?php endif; ?>

  <main class="form-signup">
    <form method="POST" action="signup.php">
      <img class="mb-4" src="/home/sathis/Downloads/phplogo" alt="" width="72" height="50">
      <h1 class="h3 mb-3 fw-normal"><b>SIGNUP</b></h1>

      <div class="form-floating">
        <input name="username" type="text" class="form-control" id="floatingInputUsername" placeholder="Username" required>
        <label for="floatingInputUsername">Username</label>
      </div>

      <div class="form-floating">
        <input name="phone" type="text" class="form-control" id="floatingInputPhone" placeholder="Phone" required>
        <label for="floatingInputPhone">Phone</label>
      </div>

      <div class="form-floating">
        <input name="email" type="email" class="form-control" id="floatingInputEmail" placeholder="Email" required>
        <label for="floatingInputEmail">Email</label>
      </div>

      <div class="form-floating">
        <input name="password" type="password" class="form-control" id="floatingPassword" placeholder="Password" required>
        <label for="floatingPassword">Password</label>
      </div>

      <button class="w-100 btn btn-lg btn-primary" type="submit">Sign up</button>
      <p class="mt-3">Already registered? <a href="login.php">Login here</a></p>
    </form>
  </main>
</body>

</html>