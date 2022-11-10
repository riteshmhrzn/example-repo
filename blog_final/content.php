<?php
// Include connect_database file
require_once "connect_database.php";
    session_start();
    
    $id = $fname = $lname = $session_username = $blog_id = $user_id = $content = $comment = $res = $cur_user_id = '';
    //check user session
        if ($_SESSION["firstname"] && $_SESSION["lastname"] && $_SESSION["username"] && $_SESSION["user_id"]) {
            $fname = $_SESSION["firstname"];
            $lname = $_SESSION["lastname"];
            $session_username = $_SESSION["username"];
            $cur_user_id = $_SESSION["user_id"];
        }
    
    if(array_key_exists('id', $_REQUEST)){
        $id = $_REQUEST['id'];
        
        if ($id == '') header("dashboard.php/?failed=0");

        $blog = "SELECT * FROM blogs WHERE id=$id";
        $result = $link->query($blog);

        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                $id = $row["id"];
                $title = $row["title"];
                $file = $row["file"];
                $content = $row["content"];
            } 
        } else {
            $res = "No content found. Please create a blog";
        }

        $blog_comments = "SELECT bc.blog_id, bc.comment, bc.added_on, u.first_name, u.last_name FROM blog_comments as bc
                            LEFT JOIN users AS u ON u.id = bc.user_id 
                            where blog_id = $id";
        $comment_result = $link->query($blog_comments);
    

        $comment_id = $date = $user_name = '';
        
        // Close connection
        mysqli_close($link);
    }

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        //logout session
            if (isset($_POST['logout']) == 'logout') {
                // Destroying session
                     session_start();
                    session_destroy();
                    header("location:/dashboard.php");
            }        
    
        // Validate title
            $input_comment = trim($_POST["comment"]);
            if (empty($input_comment)) $comment_err = "Please enter the comment.";
            else $comment = $input_comment;
        
        $blog_id = $_POST['blog_id'];
        $user_id = $_POST['user_id'];
    
        //Check input errors before inserting in database
        if(empty($comment_err)){
            // Prepare an insert statement
            $sql = "INSERT INTO blog_comments (user_id, blog_id, comment, added_on) VALUES (?, ?, ?, ?)";
            $added_on = date('Y-m-d H:i:s');
           
            
            if($stmt = mysqli_prepare($link, $sql)){
                $stmt->bind_param("iiss", $user_id, $blog_id, $comment, $added_on);
                // Attempt to execute the prepared statement
                if(mysqli_stmt_execute($stmt)){
                    // $msg = "Blog posted successfully";
                    header("location: ".$_SERVER["PHP_SELF"]."?id=".$blog_id."&comment=posted");
                } else{
                    echo "Unable to post comment. Please try again later.";
                    header("location: ".$_SERVER["PHP_SELF"]."?id=".$blog_id."&comment=failed");
                }
            } 
            // Close statement
            mysqli_stmt_close($stmt);
    
            // Close connection
            mysqli_close($link);
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Blog Spot</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #EEEBEB;
        }

        .wrapper{
            width: 100%;
            margin: 0 auto;
            height: auto;
        }

        .comment{
            background-color: #DCD6D6;
            float: left;
            border-radius: 5px;
            padding-left: 40px;
            padding-right: 30px;
            padding-top: 10px;
            width: 100%;
        }
        
        .comment h5 {
            display: inline;
        }

        .content_img {
            margin: 20px 0px 20px 20px;
        }

        .comment_display {
            margin-bottom: 30px;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 pl-0 pr-0">
                    <?php if (isset($_REQUEST['comment'])) { ?>
                        <div class="alert alert-success text-center" role="alert">
                            <?php if ($_REQUEST['comment'] == 'posted') { ?>
                                Comment posted successfully
                            <?php } else { ?>
                                Failed to post comment
                            <?php } ?>
                        </div>
                    <?php } ?>
                    <nav class="navbar navbar-expand-lg navbar-dark bg-info">
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarText">
                            <ul class="navbar-nav mr-auto">
                                <li class="nav-item">
                                    <a class="nav-link" href="/dashboard.php">Home <span class="sr-only">(current)</span></a>
                                </li>
                                <?php if ($session_username == 'admin') { ?>
                                    <li class="nav-item">
                                        <a class="nav-link" href="/create_blog.php">Create Blog <span class="sr-only">(current)</span></a>
                                    </li>
                                <?php } ?>
                                <li class="nav-item active">
                                    <a class="nav-link" href="#">Content</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="/contact_us.php">Contact Us</a>
                                </li>
                            </ul>
                           
                            <?php if ($session_username) { ?>
                                <span class="navbar-text" id="user_detail">
                                    <?php echo $fname.' '.$lname; ?>
                                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                                        <input type="hidden" value="<?php echo $session_username; ?>">
                                        <input type="hidden" name="logout" value="logout">
                                        <input type="submit" class="btn btn-danger" value="Logout">
                                    </form>
                                </span>
                            <?php } else { ?>
                                <a href="/login.php" class="btn btn-primary">Login</a>    
                            <?php } ?>

                        </div>
                    </nav>
                </div>
                <div class="col-md-12">
                    <?php if ($file != "") { ?>
                        <div class="row">
                            <div class="col-md-9"><h1 class="mt-5 text-center"> <?php echo $title; ?> </h1></div>
                            <div class="col-md-3"><img src="../uploads/<?php echo $file; ?>" class="content_img" width="auto" height="auto" title="<?php echo $title; ?>"></div>
                        </div>
                    <?php } else { ?>
                        <h1 class="mt-5 text-center"> <?php echo $title; ?> </h1>
                    <?php } ?>
                    
                    <div class="card">
                        <div class="card-body">
                            <p class="card-text text-justify">
                                <?php echo $content; ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="card mt-5 comment_display">
                        <div class="card-body">
                            <h2>Comments</h2>
                            <?php 
                                if ($comment_result->num_rows > 0) {
                                    while($row = $comment_result->fetch_assoc()) { ?>
                                        <div class="comment mt-4 text-justify float-left">
                                            <img src="https://i.imgur.com/yTFUilP.jpg" alt="" class="rounded-circle" width="40" height="40">
                                            <h5><?php echo $row['first_name'].' '.$row['last_name']; ?></h5>
                                            <span> <?php echo $row['added_on']; ?></span>
                                            <br>
                                            <p><?php echo $row['comment']; ?></p>
                                        </div>
                                    <?php
                                    }
                                } else {
                                    echo "No comments";
                                }
                            ?>  
                        </div>
                    </div>
                </div>
                <div class="col-md-6 comment_card comment_display">
                    <div class="card mt-5">
                        <div class="card-body">
                            <h4>Leave your comment</h4>
                            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"> 
                                <input type="hidden" name="blog_id" value="<?php echo $id; ?>">
                                <input type="hidden" name="user_id" value="<?php echo $cur_user_id; ?>">
                                <div class="form-group">
                                    <label>Message</label>
                                    <?php 
                                        $status = '';
                                        $msg = "Leave your comment here";
                                        if (!$session_username) { 
                                            $status = 'readonly';
                                            $msg = "Please login first to post any comments";
                                        } 
                                    ?>
                                    <textarea type="text" name="comment" class="form-control" placeholder="<?php echo $msg; ?>" <?php echo $status; ?> ></textarea>
                                </div>
                                <input type="submit" class="btn btn-success" value="Post Comment">
                            </form>
                        </div>
                    </div>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>