<?php
    session_start();
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Check if all parameters are set
        if (isset($_POST["title"]) && isset($_POST["post_text"])) {

            // values
            $title = $_POST["title"];
            $text = $_POST["post_text"];
            $tag = $_POST["tag"];
            $author_id = $_SESSION["userId"];

            $text_clean = str_replace("'", "''", $text);
            // file

            // connection
            include "db_connection.php";

            if ($error != null) {
                $output = "<p>Unable to connect to database!</p>";
                exit($output);
            } else {
                $sql = "INSERT INTO posts (title, author_id, post_text, tags, picture) VALUES
                                            ('$title', $author_id, '$text_clean', '$tag', '../blog/img/ph.jpg');";

                if ($connection -> query($sql) === true) {
                    header("location: ../index_logged.php");
                } else {
                    header("location: ../index_logged.php");
                }
            }

            mysqli_close($connection);
    } else {
        header("location: ../index_logged.php");
    }
} else {
    header("location: ../index_logged.php");
}
