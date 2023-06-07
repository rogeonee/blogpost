<?php
session_start();

if ($_SESSION['loggedin'] === false) {
    header("location: blog_unlogged.php?id=".$_GET['id']);
}
?>

<!DOCTYPE html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Viewblog</title>
    
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="../css/viewblog.css">
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

    <div>
        <img src='<?php echo $pic; ?>' id="banner" alt="">
    </div>

    <div class="blog">
        <div class="row">
            <div class="col-xs-11">
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

    <!--Comments Sidebar---->
    <div class="navbar navbar-fixed-right">
        <h2>Comments</h2>

        <!--Form-->
        <div class="comment-form">
            <form>
                <p><label for="comment">Leave a comment below:</label></p>
                <input type="hidden" id="post_id" name="post_id" value="<?php echo $_GET["id"]; ?>">
                <textarea id="comment-form" name="comment-form" rows="4" cols="45" placeholder="Cool post!" required></textarea>
                <br>
                <button type="submit" class="btn btn-primary">Send</button>
            </form>
        </div>
        <hr class="rounded">

        <!--Load comments-->
        <div id="comments-container"></div>
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <script>
            // Load comments from the server and display
            function loadComments() {
                var post_id = $('#post_id').val();
                var url = 'server/get_comments.php?post_id=' + post_id + '&t=' + new Date().getTime();
                $.getJSON(url, function(data) {
                    console.log("in get json");
                    var commentsHtml = '';
                    $.each(data, function(index, comment) {
                        commentsHtml += '<div class="comment-section">';
                        commentsHtml += '<div class="comment">';
                        commentsHtml += '<div class="author">';
                        commentsHtml += '<p class="auth-info"><strong>' + comment.name + '</strong> at ' + comment.time_posted + '</p>';
                        commentsHtml += '</div>';
                        commentsHtml += '<div class="comment-body">';
                        commentsHtml += '<p>' + comment.comment_text + '</p>';
                        commentsHtml += '</div>';
                        commentsHtml += '<hr class="rounded">';
                        commentsHtml += '</div>';
                        commentsHtml += '</div>';
                    });
                    $('#comments-container').html(commentsHtml);
                });
            }

            $(document).ready(function() {
                // Load comments on page load
                loadComments();
                console.log("after load comment");

                // Submit comments asynchronously
                $('.comment-form form').submit(function(event) {
                    event.preventDefault();
                    var commentText = $('#comment-form').val();
                    var post_id = $('#post_id').val();

                    if (commentText.trim() !== '') {
                        $.post('server/add_comment.php', { 'comment-form': commentText, 'post_id': post_id }, function(data) {
                            //alert(data);
                            loadComments();
                            $('#comment-form').val('');
                        });
                    }
                });
            });
            </script>

    </div>
</body>
</html>