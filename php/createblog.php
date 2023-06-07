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
    <title>New Viewblog</title>
    
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="../css/createblog.css">
</head>

<body>
    <!--Sidebar-->
    <div class="navbar navbar-fixed-left">
        <a href="index_logged.php"><img src="../assets/icons/logo.png" id="logo" alt=""></a>
        <a href="index_logged.php"><img src="../assets/icons/home.svg" id="home" alt=""></a>
        <a href="dashboard.php"><img src="../assets/icons/profile.svg" class="icon" alt=""></a>
        <a href="settings.php"><img src="../assets/icons/settings.png" class="icon" alt=""></a>
        <a href="logout.php"><img src="../assets/icons/logout.svg" id="logout" alt=""></a>
    </div>

    <div class="container">
        <h1>Create Blog</h1>
        <form method="post" action="newPost.php">
            <div class="form-group">
              <label for="title">Title:</label>
              <input type="text" class="form-control" id="title" name="title" placeholder="Interesting title" required>
            </div>
            <div class="form-group">
              <label for="tag">Choose tag:</label>
              <input type="text" class="form-control" id="tag" name="tag" placeholder="Cooking">
            </div>
            <div class="form-group">
              <label for="post_text">Write here:</label>
              <textarea class="form-control" id="post_text" name="post_text" rows="13" required></textarea>
            </div>
            <div class="form-group">
                <label for="media">Banner (optional):</label>
                <span class="control-fileupload">
                    <input type="file" id="media" name="media" disabled>
                </span>
            </div>
            <button type="submit">Submit</button>
          </form>
    </div>

</body>
</html>