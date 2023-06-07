<?php
session_start();

if ($_SESSION['loggedin'] === false) {
    header("location: login.php");
    exit();
}

// include the database connection file
include('server/db_connection.php');

// retrieve user information
$user_id = $_SESSION['userId'];
$user_query = "SELECT name, email, gender FROM users WHERE userId = $user_id";
$user_result = mysqli_query($connection, $user_query);

if (mysqli_num_rows($user_result) > 0) {
    $user_row = mysqli_fetch_assoc($user_result);
    $user_name = $user_row['name'];
    $user_email = $user_row['email'];
    $user_gender = $user_row['gender'];
}

// retrieve user interests
$interests_query = "SELECT tags FROM posts WHERE author_id = $user_id";
$interests_result = mysqli_query($connection, $interests_query);

$interests = array();
if (mysqli_num_rows($interests_result) > 0) {
    while ($interest_row = mysqli_fetch_assoc($interests_result)) {
        $interests[] = $interest_row['tags'];
    }
}

// retrieve user stats
$stats_query = "SELECT count(posts.id) AS num_post, TIMESTAMPDIFF(HOUR, joined_at, NOW()) AS hours_since_join
                FROM users JOIN posts ON users.userId = posts.author_id
                WHERE users.userId = $user_id
                GROUP BY users.userId;";
$stats_result = mysqli_query($connection, $stats_query);

if (mysqli_num_rows($stats_result) > 0) {
    $stats_row = mysqli_fetch_assoc($stats_result);
    $num_posts = $stats_row['num_post'];
    $hours_since_join = $stats_row['hours_since_join'];
}

$stats_query = "SELECT count(comments.id) AS num_comm
                FROM users JOIN comments ON users.userId = comments.user_id
                WHERE users.userId = $user_id
                GROUP BY users.userId;";
$stats_result = mysqli_query($connection, $stats_query);

if (mysqli_num_rows($stats_result) > 0) {
    $stats_row = mysqli_fetch_assoc($stats_result);
    $num_comments = $stats_row['num_comm'];
}

// retrieve user posts
$posts_query = "SELECT posts.id, title, tags, created_at, count(comments.id)
                FROM posts JOIN comments ON posts.id = comments.post_id
                WHERE author_id = $user_id
                GROUP BY posts.id;";
$posts_result = mysqli_query($connection, $posts_query);
?>

<!DOCTYPE html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard</title>
    
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="../css/dashboard.css">
</head>

<body>
<!--Sidebar-->
<div class="navbar navbar-fixed-left">
    <a href="index_logged.php"><img src="../assets/icons/logo.png" id="logo"></a>
    <a href="index_logged.php"><img src="../assets/icons/home.svg" id="home"></a>
    <a href="dashboard.php"><img src="../assets/icons/profile.svg" class="icon"></a>
    <a href="settings.php"><img src="../assets/icons/settings.png" class="icon"></a>
    <a href="logout.php"><img src="../assets/icons/logout.svg" id="logout"></a>
</div>

<div class="container" id="main">
    <h1>Welcome, <?php echo $_SESSION['username']; ?>!</h1>
    
    <div class="row">
        <div class="col-sm-4">
            <div class="panel panel-body">
                <h2 id="basic_h">Basic</h2>
                <div class="info">
                    <p>Name: <?php echo $_SESSION['username']; ?></p>
                    <p>Email: <?php echo $user_email; ?></p>
                    <p>Gender: <?php echo $user_gender; ?></p>
                </div>
            </div>
        </div>

        <div class="col-sm-4">
            <div class="panel panel-body">
                <h2>Your interests</h2>
                <div class="info">
                    <?php
                    foreach ($interests as $row) {
                        echo "<p class='tag'>$row</p>";
                    }
                    ?>
                </div>
            </div>
        </div>

        <div class="col-sm-4">
            <div class="panel panel-body">
                <h2>Your stats</h2>
                <div class="info">
                    <p>With us for <?php echo $hours_since_join; ?> hours!</p>
                    <p>Total posts: <?php echo $num_posts; ?></p>
                    <p>Total comments: <?php echo $num_comments; ?></p>
                </div>
            </div>
        </div>
    </div><!--row-->

    <h1>Your posts:</h1>
    <table id="posts" class="table-hover">
        <thead>
          <tr>
            <th>Title</th>
            <th>Tags</th>
            <th>Comments</th>
            <th>Date</th>
          </tr>
        </thead>
        <tbody>
            <?php
                if ($posts_result -> num_rows > 0) {
                    $arr = $posts_result -> fetch_all();
                    $posts_result -> free();
                    foreach ($arr as $post) {
                        echo "<tr><td><a href='viewblog.php?id=$post[0]'>$post[1]</a></td>
                        <td>$post[2]</td>
                        <td>$post[4]</td>
                        <td>$post[3]</td></tr>";
                    }
                }
            ?>
        </tbody>
      </table>
      
</div>

</body>
</html>