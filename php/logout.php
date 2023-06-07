<?php
session_start();
$_SESSION['loggedin'] = false;
$_SESSION['username'] = null;
$_SESSION['userId'] = null;
header("location: index.php");
