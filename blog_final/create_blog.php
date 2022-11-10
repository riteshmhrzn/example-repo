<?php
    // Include connect_database file
require_once "connect_database.php";
    session_start();
    
    $fname = $lname = $session_username = '';
    //check user session
        if ($_SESSION["firstname"] && $_SESSION["lastname"] && $_SESSION["username"]) {
            $fname = $_SESSION["firstname"];
            $lname = $_SESSION["lastname"];
            $session_username = $_SESSION["username"];
        }

    // Define variables and initialize with empty values
        $title = $content = $filename = $tempname = $folder = "";
        $title_err = $content_err = "";
 
    // Processing form data when form is submitted
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            //logout session
                if (isset($_POST['logout']) == 'logout') {
                    // Destroying session
                        session_start();
                        session_destroy();
                        header("location:/dashboard.php");
                }

            // Validate title
            $input_title = trim($_POST["title"]);
            if(empty($input_title)){
                $title_err = "Please enter the title.";
            } else{
                $title = $input_title;
            }
            
            // Validate content
            $input_content = trim($_POST["content"]);

            // print_r($input_content);
            if(empty($input_content)){
                $content_err = "Please enter the content.";
            } else{
                $content = $input_content;
            }

            //validate file
            $file = $_FILES['uploadfile']['name']; 

            if(!empty($file)){
                $tempname = $_FILES["uploadfile"]["tmp_name"];
                $folder = dirname(__FILE__)."/uploads/".$file;
                
                if (!empty($file)) {
                    if (move_uploaded_file($tempname, $folder)) {
                        //Check input errors before inserting in database
                        if(empty($title_err) && empty($content_err)){           
                                        
                            $sql = "INSERT INTO blogs (title, file, content) VALUES (?, ?, ?)";
                            
                            // Prepare an insert statement
                                if($stmt = mysqli_prepare($link, $sql)){
                                    $stmt->bind_param("sss", $title, $file, $content);
                                    // Attempt to execute the prepared statement
                                        if(mysqli_stmt_execute($stmt)){
                                            header("location: dashboard.php?blog=posted");
                                        } else{
                                            header("location: dashboard.php?blog=failed");
                                        }
                                } else {
                                    header("location: dashboard.php?blog=failed");
                                }
                            // Close statement
                                mysqli_stmt_close($stmt);
                        }
                    }
                } else{
                    header("location: dashboard.php?blog=failed");
                }
                // Close connection
                mysqli_close($link);
            } else {
                if(empty($title_err) && empty($content_err)){          
                        
                    $sql = "INSERT INTO blogs (title, file, content) VALUES (?, ?, ?)";
                    $file = NULL;
                    // Prepare an insert statement
                        if($stmt = mysqli_prepare($link, $sql)){
                            $stmt->bind_param("sss", $title, $file, $content);
                            // Attempt to execute the prepared statement
                                if(mysqli_stmt_execute($stmt)){
                                    header("location: dashboard.php?blog=posted");
                                } else{
                                    header("location: dashboard.php?blog=failed");
                                }
                        } else {
                            header("location: dashboard.php?blog=failed");
                        }
                    // Close statement
                        mysqli_stmt_close($stmt);
                }
            }
        }
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Blog</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .wrapper{
            width: 600px;
            margin: 0 auto;
        }
        .container-fluid {
            background-color: #EEEBEB;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 pl-0 pr-0">
                <nav class="navbar navbar-expand-lg navbar-dark bg-info">
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarText">
                        <ul class="navbar-nav mr-auto">
                            <li class="nav-item">
                                <a class="nav-link" href="dashboard.php">Home</a>
                            </li>
                            <?php if ($session_username == 'admin') { ?>
                                <li class="nav-item active">
                                    <a class="nav-link" href="create_blog.php">Create Blog <span class="sr-only">(current)</span></a>
                                </li>
                            <?php } ?>
                            <li class="nav-item">
                                <a class="nav-link" href="contact_us.php">Contact Us</a>
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
                            <a href="login.php" class="btn btn-primary">Login</a>    
                        <?php } ?>

                    </div>
                </nav>

                <div class="wrapper">
                    <h2 class="mt-5">Create Blog</h2>
                    <p>Please fill the following form to create a blog</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data"> 
                    
                        <div class="form-group">
                            <label>Title</label>
                            <input type="text" name="title" class="form-control <?php echo (!empty($title_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $title; ?>">
                            <span class="invalid-feedback"><?php echo $title_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Image</label>
                            <input class="form-control" type="file" name="uploadfile" value="" />
                        </div>
                        <div class="form-group">
                            <label>Content</label>
                            <textarea name="content" rows="10" class="form-control <?php echo (!empty($content_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $content; ?>"></textarea>
                            <span class="invalid-feedback"><?php echo $content_err;?></span>
                        </div>
                        <input type="submit" class="btn btn-success" value="Create Blog">
                        <a href="dashboard.php" class="btn btn-danger ml-2">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>