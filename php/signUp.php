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
    <title>Blogpost-SignUp</title>
    
    <script type="text/javascript" src="../scripts/validate.js"></script>
    <script>
      function checkPasswordMatch(e) {
            // Get the password and re-entered password fields
            var password = document.getElementById("password").value;
            var passwordCheck = document.getElementById("confirm-password").value;
    
            // Check if the passwords match
            if (password !== passwordCheck) {
              makeRed(document.getElementById("confirm-password"));
              alert("The passwords do not match. Please try again.");
    
              // Prevent the form submission
              //console.log("prevent from submission");
              e.preventDefault();
            }
          }
    </script>
  </head>

  <body>
    <div class="container">
      <div class="image">
        <p class="image-text"> BlogPost</p>
      </div>
      <div class="form">
        <h1 class="form-title">Sign Up</h1>
        <form method="post" action="server/newUser.php" id="mainForm">
          <label for="name" class="form-label">Name:</label>
          <input type="text" id="name" name="name" required>
          <label for="email" class="form-label">Email:</label>
          <input type="email" id="email" name="email" required>
          <label for="gender" class="form-label">Gender:</label>
          <input type="text" id="gender" name="gender">
          <label for="password"  class="form-label">Password:</label>
          <input type="password" id="password" name="password" required>
          <label for="confirm-password"  class="form-label">Confirm Password:</label>
          <input type="password" id="confirm-password" name="confirm-password" required>
          <input type="checkbox" id="terms" name="terms" value="terms">
          <label for="terms"> I accept the <a href="#" class="form-link__button">terms and conditions</a></label><br>
          <button type="submit">Sign Up</button>
        </form>
        <div class="form-link__return">
          <p>Return to  <a href="index.html" class="form-link__button">Home</a></p>
        </div>
      </div>
    </div>
  </body>
</html>