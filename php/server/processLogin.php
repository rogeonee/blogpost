<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Check if all parameters are set
        if (isset($_POST["email"]) && isset($_POST["password"])) {

            // values
            $email = $_POST["email"];
            $pass = $_POST["password"];

            // connection
            include "db_connection.php";

            if ($error != null) {
                $output = "<p>Unable to connect to database!</p>";
                exit($output);
            } else {
                $sql = "SELECT email, password, name, userId FROM users WHERE email = '$email';";

                $results = mysqli_query($connection, $sql);

                //and fetch requsults
                while ($row = mysqli_fetch_assoc($results)) {
                    $db_email = $row['email'];
                    $db_pass = $row['password'];
                    $db_name = $row['name'];
                    $db_id = $row['userId'];
                }

                if ($results->num_rows === 0) {
                    echo "<p>email is invalid</p>";
                } else {
                    if (strcmp($pass, $db_pass) === 0) {
                        session_start();
                        $_SESSION['loggedin'] = true;
                        $_SESSION['username'] = $db_name;
                        $_SESSION['userId'] = $db_id;
                        header("location: ../index_logged.php");
                    } else {
                        header("location: ../login.php");
                    }
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
