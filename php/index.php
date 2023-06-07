<?php
session_start();

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    header("location: index_logged.php");
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
    <title>Blogpost</title>
    
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="../css/index.css">
</head>

<body>

<header>
    <nav class="navbar">
        <div class="container-fluid">
            <ul class="nav navbar-nav navbar-right">
                <li><a href="index.php">Home</a></li>
                <li><a href="about.html">About</a></li>
                <li><a href="signUp.php">Sign Up</a></li>
                <li><a href="login.php">Log In</a></li>
            </ul>

            <div class="container">
                <div class="jumbotron">
                    <h1 class="text-center">BLOGPOST</h1>
                    <form method="get" action="" class="form-inline">
                        <div class="col-sm-10">
                            <input type="text" class="form-control" placeholder="<?php echo $a; ?>" id="search_bar" name="search_text">
                        </div>
                        <div class="col-sm-1">
                            <button type="submit" class="btn btn-primary">Search</button>
                        </div>
                        <div class="col-sm-1">
                            <button type="reset" class="btn btn-default">Clear</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
      </nav>
</header>

<div class="container">

    <!--No search-->
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
                echo "<h2>Newly added:</h2>";
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

    <!--Search-->
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
</div><!--container-->

</body>
</html>
