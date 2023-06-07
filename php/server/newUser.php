<?php
// Check if POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Check parameters
  if (isset($_POST["name"])  &&  isset($_POST["email"]) &&
        isset($_POST["confirm-password"])) {

    // values
    $name = $_POST["name"];
    $email = $_POST["email"];
    $pass = $_POST["confirm-password"];
    $gender = strcmp($_POST["gender"], "") == 0 ? "unknown" : $_POST["gender"];

    // connection
    include 'db_connection.php';

    if ($error != null) {
        $output = "<p>Unable to connect to database!</p>";
        exit($output);
    } else {
        $sql = "SELECT name, email FROM users WHERE name = '".$name."' OR email = '".$email."';";

        $results = mysqli_query($connection, $sql);

        if ($results->num_rows === 0) {
            insertUser($email, $name, $pass, $gender);
            
            $sql_id = "SELECT name, userId FROM users WHERE email = '$email';";
            $results = mysqli_query($connection, $sql_id);
            while ($row = mysqli_fetch_assoc($results)) {
              $db_name = $row['name'];
              $db_id = $row['userId'];
          }
            session_start();
            $_SESSION['loggedin'] = true;
            $_SESSION['userId'] = $db_id;
            $_SESSION['username'] = $db_name;

            header("location: ../index_logged.php");
        } else {
            header("location: ../login.php");
        }

      }
      mysqli_free_result($results);
      mysqli_close($connection);
  } else {
    header("location: ../login.php");
  }
} else {
  header("location: ../login.php");
}

function insertUser($email, $name, $pass, $gender) {
  include "db_connection.php";

  if ($error != null) {
      $output = "<p>Unable to connect to database!</p>";
      exit($output);
  } else {
      //$pass_hash = md5($pass);
      $sql = "INSERT INTO users (email, name, password, gender) VALUES ('$email', '$name', '$pass', '$gender')";

      if ($connection->query($sql) === false){
          echo "Error: " . $sql . "<br>" . $connection->error;
      }

      mysqli_close($connection);
  }
}
