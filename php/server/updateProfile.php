<?php
session_start();

require_once('db_connection.php');

if (!empty($_POST['name'])) {
    $newName = $_POST['name'];
    $userId = $_SESSION['userId'];
    
    $query = "UPDATE users SET name = '$newName' WHERE userId = '$userId'";
    mysqli_query($connection, $query);
    $_SESSION['username'] = $newName;
}

if (!empty($_POST['password'])) {
    $newPassword = $_POST['password'];
    $userId = $_SESSION['userId'];
    
    $query = "UPDATE users SET password = '$newPassword' WHERE userId = '$userId'";
    mysqli_query($connection, $query);
}

if (!empty($_POST['gender'])) {
    $newGender = $_POST['gender'];
    $userId = $_SESSION['userId'];
    
    $query = "UPDATE users SET gender = '$newGender' WHERE userId = '$userId'";
    mysqli_query($connection, $query);
}

mysqli_close($connection);
header("Location: ../dashboard.php");
exit();
