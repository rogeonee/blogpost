<?php
session_start();

if ($_SESSION['loggedin'] === true) {
    header("location: viewblog.php?=id".$_GET['id']);
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
    <link rel="stylesheet" href="../css/blog_unlogged.css">
</head>

<body>

    <?php
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            // Check if all parameters are set
            if (isset($_GET["id"])) {

                // values
                $post_id = $_GET["id"];

                // connection
                include "server/db_connection.php";

                if ($error != null) {
                    $output = "<p>Unable to connect to database!</p>";
                    exit($output);
                } else {
                    $sql = "SELECT posts.title, posts.picture, posts.tags, users.name AS author_name, posts.post_text
                            FROM posts
                            JOIN users ON posts.author_id = users.userId
                            WHERE posts.id = $post_id;";
                    $result = mysqli_query($connection, $sql);

                    if ($result -> num_rows > 0) {
                        $arr = $result -> fetch_all();
                        $result -> free();
        
                        foreach ($arr as $row) {
                            $title = $row[0];
                            $pic = $row[1];
                            $tag = $row[2];
                            $author = $row[3];
                            $text = $row[4];
                        }
                    } else {
                        echo "<p>empty set</p>";
                    }
                }
                mysqli_close($connection);
        } else {
            echo "<p>No data sent!</p>";
        }
    } else {
        echo "<p>Wrong request!</p>";
    }
    ?>

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
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <div class="container" id="blog">
        <div>
            <img src='<?php echo $pic; ?>' id="banner" alt="">
        </div>
        <div class="row">
            <div class="col-xs-10">
                <h1 id="title"><?php echo $title; ?></h1>
            </div>
            <div class="buttons">
                <div class="col-xs-1">
                    <img src="../assets/icons/Share.png" class="pull-left" alt="" onclick="copy()">
                    <p id="copyAddress" hidden>
                        <?php echo "https://cosc360.ok.ubc.ca/".$_SERVER['PHP_SELF']; ?>
                    </p>
                </div>
            </div>
            <div class="col-xs-12">
                <h3 id="author">By <?php echo $author; ?></h3>
            </div>
            <div class="col-xs-12">
                <p class="tag"><?php echo $tag; ?></p>
            </div>
        </div>
        <div class="content">
            <p><?php echo $text; ?></p>
        </div>
    </div>

    <script>
        // share button copies address to clipboard
        let text = document.getElementById('copyAddress').innerHTML;
        const copy = async () => {
            try {
                await navigator.clipboard.writeText(text);
                console.log('Content copied to clipboard');
            } catch (err) {
                console.error('Failed to copy: ', err);
            }
        }
    </script>

</body>
</html>
