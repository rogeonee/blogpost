<?php
session_start();

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    header("location: index_logged.php");
}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../css/login.css">
    <title>Blogpost-SignIn</title>
  </head>

  <body>
    <div class="container">
      <div class="image">
        <p class="image-text"> BlogPost</p>
      </div>
      <div class="form">
        <h1 class="form-title">Member login</h1>
        <form method="post" action="server/processLogin.php">
          <label for="email" class="form-label">Email:</label>
          <input type="email" id="email" name="email" required>
          <label for="password"  class="form-label">Password:</label>
          <input type="password" id="password" name="password" required>
          <button type="submit">Log in</button>
        </form>
        <div class="form-link">
          <p>Forgot Password? <a href="forgotPassword.php" class="form-link__button">Click here</a></p>
          <p>Dont have an account? <a href="signUp.php" class="form-link__button">Sign up</a></p>
        </div>
        <div class="form-link__return">
          <p>Return to  <a href="index.php" class="form-link__button">Home</a></p>
        </div>
      </div>
    </div>
  </body>
</html>