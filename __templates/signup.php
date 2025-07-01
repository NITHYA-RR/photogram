<?php
$signup = false;
if( isset($_POST['username']) and isset($_POST['password']) and isset($_POST['email']) and isset($_POST['phone'])){
$username = $_POST['username'];
$password = $_POST['password'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$error = User::signup($username , $password , $email , $phone);
$signup = true;
 }
 ?>
 <?php
 if($signup) {
  if (!$error) {
  ?>
  <center>
  <h1><b>Signup Successfull</b></h1>
  <P>You can login form <a href="login.php">Here</a></P>
  </center>
  <?php
  }
 else{
  ?>
  <h1>signup Failed..!</h1>
  <P>No You can't Successfull..!</P>
<?php
  }
}
else { 
?>
<body class="text-center">
  <main class="form-signup">
  <form method="POST" action="signup.php">
    <img class="mb-4" src="/home/sathis/Downloads/phplogo" alt="" width="72" height="50">
    <h1 class="h3 mb-3 fw-normal"> <b>SIGNUP</b></h1>
    <div class="form-floating">
      <input name="username" type="text" class="form-control" id="floatingInputUsername" placeholder="name@example.com">
      <label for="floatingInput">Username</label>
    </div>
    <div class="form-floating">
      <input name="phone" type="text" class="form-control" id="floatingInputPhone" placeholder="name@example.com">
      <label for="floatingInput">Phone</label>
    </div>
    <div class="form-floating">
      <input name="email" type="email" class="form-control" id="floatingInput" placeholder="name@example.com">
      <label for="floatingInput">Email</label>
    </div>
    <div class="form-floating">
      <input name="password" type="password" class="form-control" id="floatingPassword" placeholder="Password">
      <label for="floatingPassword">Password</label>
    </div>
    <button class="w-100 btn btn-lg btn-primary" type="submit">Sign up</button>
   
  </form>
</main>
</body>
<?php
}
 
?>

