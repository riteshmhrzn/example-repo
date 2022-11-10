<?php
 // Include connect_database file
require_once "connect_database.php";
// Define variables and initialize with empty values
$full_name = $email = $message = "";
$fullname_err = $email_err = $message_err = "";

session_start();
    
    $fname = $lname = $session_username = $cur_user_id = '';
    //check user session
        if ($_SESSION["firstname"] && $_SESSION["lastname"] && $_SESSION["username"] && $_SESSION["user_id"]) {
            $fname = $_SESSION["firstname"];
            $lname = $_SESSION["lastname"];
            $session_username = $_SESSION["username"];
            $cur_user_id = $_SESSION["user_id"];
        }
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            //logout session
            if (isset($_POST['logout']) == 'logout') {
                // Destroying session
                    session_start();
                    session_destroy();
                    header("location:/dashboard.php");
            }
        } 
     

    if($_SERVER["REQUEST_METHOD"] == "POST"){
                // Validate full name
        
        $input_fullname = trim($_POST["fullname"]);
        if(empty($input_fullname)){
            $fullname_err = "Please enter a full name.";
        } else{
            $full_name = $input_fullname;
        }
        // Validate comment
        $input_message = trim($_POST["message"]);
        if(empty($input_message)){
            $message_err = "please enter message";     
        } else{
            $message = $input_message;
        }
        
        // Validate email
        $input_email = trim($_POST["email"]);
        if(empty($input_email)){
            $email_err = "Please enter the email address";}
        elseif (!filter_var($input_email, FILTER_VALIDATE_EMAIL)) {
                $email_err = "Invalid email format";     
        } else{
            $email = $input_email;
        }
       
        if(empty($fullname_err) && empty($email_err) && empty($message_err) ){
            
            $sql = "INSERT INTO contactus (full_name, email, remarks ) VALUES (?, ?, ?)";
            if($stmt = mysqli_prepare($link, $sql)){
                // Bind variables to the prepared statement as parameters
                $stmt->bind_param("sss", $full_name, $email, $message);
                
                if(mysqli_stmt_execute($stmt)){
                    // message submitted. Redirect to landing page
                    header("location: dashboard.php?contactus=posted");               
                } else{
                    //echo "Oops! Something went wrong. Please try again later.";
                    header("location: dashboard.php?contactus=failed");
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
    <title>Contact Us</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #EEEBEB;
        }

        .wrapper{
            width: 600px;
            margin: 0 auto;
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
                            <li class="nav-item active">
                                <a class="nav-link" href="contact_us.php">Contact Us <span class="sr-only">(current)</span></a>
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
            <div class="wrapper">
                <div class="col-md-12">
                    <h2 class="mt-5">Contact Us form</h2>
                    <p>Please fill this form to Contact Us</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"> 
                    
                        <div class="form-group">
                            <label>Full Name</label>
                            <input type="text" name="fullname" class="form-control <?php echo (!empty($fullname_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $full_name; ?>">
                            <span class="invalid-feedback"><?php echo $fullname_err;?></span>
                        </div>

                        <div class="form-group">
                            <label>Email</label>
                            <input type="text" name="email" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>">
                            <span class="invalid-feedback"><?php echo $email_err;?></span>
                        </div>

                        <div class="form-group">
                            <label>Message</label>
                            <input type="text" name="message" class="form-control <?php echo (!empty($message_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $message; ?>">
                            <span class="invalid-feedback"><?php echo $message_err;?></span>
                        </div>
                        <input type="submit" class="btn btn-success" value="Submit">
                        <a href="dashboard.php" class="btn btn-danger ml-2">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>