<?php
// Include connect_database file
require_once "connect_database.php";
    session_start();
    
    $fname = $lname = $session_username = '';
    //check user session
        if (isset($_SESSION["firstname"]) && isset($_SESSION["lastname"]) && isset($_SESSION["username"])) {
            $fname = $_SESSION["firstname"];
            $lname = $_SESSION["lastname"];
            $session_username = $_SESSION["username"];
        }

    //logout session
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            //logout session
            if (isset($_POST['logout']) == 'logout') {
                // Destroying session
                    //session_start();
                    session_destroy();
                    header("location:/dashboard.php");
            }
        } 
    
    $blog = "SELECT * FROM blogs";
    $result = $link->query($blog);

    $id = $title = $file = $content = '';

    // Close connection
    mysqli_close($link);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Blog Spot</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .wrapper{
            width: 100%;
            margin: 0 auto;
        }
        #user_detail{
            color: #FFFFFF;
        }

        body {
            background-color: #EEEBEB;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 pl-0 pr-0">
                    <?php if (isset($_REQUEST['blog'])) { ?>
                        <div class="alert alert-success text-center" role="alert">
                            <?php if ($_REQUEST['blog'] == 'posted') { ?>
                                Blog posted successfully
                            <?php } else { ?>
                                Failed to post blog
                            <?php } ?>
                        </div>
                    <?php } ?>
                    <?php if (isset($_REQUEST['contactus'])) { ?>
                        <div class="alert alert-success text-center" role="alert">
                            <?php if ($_REQUEST['contactus'] == 'posted') { ?>
                                message posted successfully
                            <?php } else { ?>
                                Failed to post message
                            <?php } ?>
                        </div>
                    <?php } ?>
                    <nav class="navbar navbar-expand-lg navbar-dark bg-info">
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarText">
                            <ul class="navbar-nav mr-auto">
                                <li class="nav-item active">
                                    <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                                </li>
                                <?php if ($session_username == 'admin') { ?>
                                    <li class="nav-item">
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
                </div>
                <div class="col-md-12">
                    <h2 class="mt-5 text-center">Welcome to Apache Cassandra Blog Spot</h2>
                    <div class="row" style="padding-top: 20px;">
                        <?php 
                            if ($result->num_rows > 0) {
                                while($row = $result->fetch_assoc()) { ?>
                                    <div class="col-md-4 mb-20" style="height: 495px;">
                                        <div class="card">
                                            <div class="card-body">
                                                <h5 class="card-title"><?php echo $row['title']?></h5>
                                                <p class="card-text">
                                                    <?php
                                                        $content = substr($row['content'], 0, 100);
                                                        echo $content;

                                                        if (strlen($row['content']) > 100) { ?>
                                                            ... <a href="content.php/?id=<?php echo $row['id'] ?>" class="btn btn-primary" role="button" target="_blank">Read More</a>
                                                        <?php } ?>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                }
                            }
                        ?>  
                    </div>                      
                </div>
            </div>        
        </div>
    </div>
</body>
</html>