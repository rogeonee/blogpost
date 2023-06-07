<?php
session_start();

if ($_SESSION['loggedin'] === false) {
    header("location: index.php");
}

if (isset($_GET['search_text']) && $_GET['search_text'] !== "") {
    $search = true;
    $a = $_GET['search_text'];
} else {
    $search = false;
    $a = "Tags, keywords";
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
    <link rel="stylesheet" href="../css/index_logged.css">
</head>

<body>
<!--Sidebar-->
<div class="navbar navbar-fixed-left">
    <a href="#"><img src="../assets/icons/logo.png" id="logo"></a>
    <a href="index_logged.php"><img src="../assets/icons/home.svg" id="home"></a>
    <a href="dashboard.php"><img src="../assets/icons/profile.svg" class="icon"></a>
    <a href="settings.php"><img src="../assets/icons/settings.png" class="icon"></a>
    <a href="logout.php"><img src="../assets/icons/logout.svg" id="logout"></a>
</div>

<!--Body-->
<div class="container">

    <!--Header-->
    <div class="header">
        <div class="row">
            <form method="get" action="" class="form-inline">
                <div class="col-sm-7">
                    <input type="text" class="form-control" placeholder="<?php echo $a; ?>" id="search_bar" name="search_text">
                </div>
                <div class="col-sm-1">
                    <button type="submit" class="btn btn-primary">Search</button>
                </div>
                <div class="col-sm-1">
                    <button type="reset" class="btn btn-default">Clear</button>
                </div>
            </form>
            <div class="col-sm-3" id="profile">
                <a href="dashboard.php" id="pfp"><img src="../assets/icons/profile_icon.svg" alt=""></a>
                <p><a href="dashboard.php" id="pname"><?php echo $_SESSION['username']; ?></a></p>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="buttons">
            <div class="offset-sm-9 col-sm-3">
                <a href="createblog.php"><img src="../assets/icons/create_b.svg" id="create_b" alt=""></a>
            </div>
        </div>
    </div>

    <?php include 'server/db_connection.php';
    if (!$search) {

        if ($error != null) {
            $output = "<p>Unable to connect to database!</p>";
            exit($output);
        } else {
            $sql = "SELECT posts.id, posts.title, posts.picture, posts.tags, users.name AS author_name, posts.created_at
                    FROM posts
                    JOIN users ON posts.author_id = users.userId
                    ORDER BY posts.created_at DESC;";

            $result = mysqli_query($connection, $sql);

            if ($result -> num_rows > 0) {
                $arr = $result -> fetch_all();
                $result -> free();

                $count_1 = 0;
                echo "<h2>Browse all:</h2>";
                echo "<div class='row'>";
                foreach ($arr as $row) {
                    if ($count_1 % 4 == 0) {
                        echo "</div>";
                        echo "<div class='row'>";
                    }
                    echo "<div class='col-sm-3'>
                            <div class='panel panel-body' onclick=\"location.href='viewblog.php?id=$row[0]';\" style='cursor:pointer;'>
                                <div>
                                    <img src='$row[2]' class='img-responsive'>
                                </div>
                                    <p class='title'>$row[1]</p>
                                    <p class='author'>$row[4]</p>
                                    <p class='tag'>$row[3]</p>
                            </div>
                        </div>";
                    $count_1 += 1;
                }
                echo "</div>";
            } else {
                echo "<p>empty set</p>";
            }
        }
        mysqli_close($connection);
    }
    ?>

    <?php include 'server/db_connection.php';
    if ($search) {

        if ($error != null) {
            $output = "<p>Unable to connect to database!</p>";
            exit($output);
        } else {
            $sql = "SELECT posts.id, posts.title, posts.picture, posts.tags, users.name AS author_name, posts.created_at
                    FROM posts
                    JOIN users ON posts.author_id = users.userId
                    ORDER BY posts.created_at;";
            
            if (isset($_GET['search_text'])) {
                $search = true;
                $search_text = $_GET['search_text'];
                $sql = "SELECT posts.id, posts.title, posts.picture, posts.tags, users.name AS author_name, posts.created_at
                        FROM posts
                        JOIN users ON posts.author_id = users.userId
                        WHERE posts.title LIKE '%$search_text%' OR posts.tags LIKE '%$search_text%' OR users.name LIKE '%$search_text%'
                        ORDER BY posts.created_at;";
            }

            $result = mysqli_query($connection, $sql);

            if ($result -> num_rows > 0) {
                $arr = $result -> fetch_all();
                $result -> free();

                if(count($arr) > 1) {
                    $r = count($arr)." results found:";
                } elseif (count($arr) == 1) {
                    $r = count($arr)." result found:";
                } else {
                    $r = "No results found :(";
                }

                $count_2 = 0;
                echo "<h2>$r</h2>";
                echo "<div class='row'>";
                foreach ($arr as $row) {
                    if ($count_2 % 4 == 0) {
                        echo "</div>";
                        echo "<div class='row'>";
                    }
                    echo "<div class='col-sm-3'>
                            <div class='panel panel-body' onclick=\"location.href='viewblog.php?id=$row[0]';\" style='cursor:pointer;'>
                                <div>
                                    <img src='$row[2]' class='img-responsive'>
                                </div>
                                    <p class='title'>$row[1]</p>
                                    <p class='author'>$row[4]</p>
                                    <p class='tag'>$row[3]</p>
                            </div>
                        </div>";
                        $count_2 += 1;
                }
                echo "</div>";
            } else {
                echo "<p>empty set</p>";
            }
        }
        mysqli_close($connection);
    }
    ?>
</div>

</body>
</html>