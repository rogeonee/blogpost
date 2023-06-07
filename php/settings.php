<?php
session_start();

if ($_SESSION['loggedin'] === false) {
    header("location: login.php");
}
?>

<!DOCTYPE html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Logged In</title>
    
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="../css/settings.css">
</head>

<body>
<!--Sidebar-->
<div class="navbar navbar-fixed-left">
    <a href="#"><img src="../assets/icons/logo.png" id="logo"></a>
    <a href="index_logged.php"><img src="../assets/icons/home.svg" id="home"></a>
    <a href="dashboard.php"><img src="../assets/icons/profile.svg" class="icon"></a>
    <a href="#"><img src="../assets/icons/favorite.svg" class="icon"></a>
    <a href="settings.php"><img src="../assets/icons/settings.png" class="icon"></a>
    <a href="logout.php"><img src="../assets/icons/logout.svg" id="logout"></a>
</div>

<div class="container">

    <h1><a href="dashboard.php" id="pname"><?php echo $_SESSION['username']; ?></a>'s Profile Settings</h1>

    <form action="server/updateProfile.php" method="POST">
        <div class="form-group">
            <h3>New name:</h3>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <button type="submit" class="btn btn-primary">Update name</button>
    </form>

    <form action="server/updateProfile.php" method="POST">
        <div class="form-group">
            <h3>New password:</h3>
            <label for="password">(think twice, you won't see it again)</label>
            <input type="text" class="form-control" id="password" name="password" required>
        </div>
        <button type="submit" class="btn btn-primary">Update password</button>
    </form>

    <form action="server/updateProfile.php" method="POST">
        <div class="form-group">
            <h3>New gender:</h3>
            <input type="text" class="form-control" id="gender" name="gender" required>
        </div>
        <button type="submit" class="btn btn-primary">Update gender</button>
    </form>

    <form action="#" method="POST">
        <div class="form-group">
            <h3>New profile picture:</h3>
            <input type="file" class="form-control" id="pfp" name="pfp" disabled>
        </div>
        <button type="submit" class="btn btn-primary" disabled>Update picture</button>
    </form>
</div>

</body>
</html>