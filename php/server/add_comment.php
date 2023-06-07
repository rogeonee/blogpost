<?php
// Connect
include 'db_connection.php';
$connection = mysqli_connect($host, $user, $password, $database);

if ($connection->connect_error) {
    die('Connection failed: ' . $connection->connect_error);
}

session_start();

// Get the user id, post id, and comment text
$user_id = $_SESSION['userId'];
$post_id = $_POST['post_id'];
$comment_text = $_POST['comment-form'];

// Prepare the SQL statement to insert the comment
$stmt = $connection -> prepare("INSERT INTO comments (user_id, post_id, comment_text) VALUES (?, ?, ?)");
$stmt->bind_param("iis", $user_id, $post_id, $comment_text);

// Execute the SQL statement and check for errors
if (!$stmt -> execute()) {
    die("Error inserting comment: " . $connection->error);
}

// Close the connection and return a success message
$stmt->close();
$connection->close();
echo "Comment added successfully";
