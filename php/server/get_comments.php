<?php
// Connect
include 'db_connection.php';
$connection = mysqli_connect($host, $user, $password, $database);

if ($connection->connect_error) {
    die('Connection failed: ' . $connection->connect_error);
}

// Check for post_id
if (isset($_GET['post_id'])) {
    $post_id = $_GET['post_id'];
} else {
    $post_id = null;
}

// Retrieve comments
if ($post_id) {
    // If post_id is specified, retrieve comments for that post only
    $sql = "SELECT comments.*, users.name FROM comments INNER JOIN users ON comments.user_id = users.userId WHERE comments.post_id = $post_id ORDER BY time_posted DESC";
} else {
    // If post_id is not specified, retrieve all comments (idk)
    $sql = "SELECT comments.*, users.name FROM comments INNER JOIN users ON comments.user_id = users.userId ORDER BY time_posted DESC";
}
$result = mysqli_query($connection, $sql);

// Store comments in an array
$comments = array();
while ($row = mysqli_fetch_assoc($result)) {
    $comments[] = $row;
}

// Return comments as JSON
header('Content-Type: application/json');
echo json_encode($comments);

// Close database connection
mysqli_close($connection);
