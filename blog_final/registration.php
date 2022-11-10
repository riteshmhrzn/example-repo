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

    //logout session
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            // Destroying session
                //session_start();
                session_destroy();
        }

    // Define variables and initialize with empty values
        $first_name = $last_name = $username = $password = $repassword =$address = $email =$contact = "";
        $firstname_err = $lastname_err = $username_err = $password_err = $address_err = $email_err =$contact_err = "";
        
    // Processing form data when form is submitted
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            // Validate first name
            $input_firstname = trim($_POST["firstname"]);
            if(empty($input_firstname)){
                $firstname_err = "Please enter a name.";
            } elseif(!filter_var($input_firstname, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
                $firstname_err = "Please enter a valid name.";
            } else{
                $first_name = $input_firstname;
            }
            
            // Validate lastname
            $input_lastname = trim($_POST["lastname"]);
            if(empty($input_lastname)){
                $lastname_err = "Please enter a name.";
            } elseif(!filter_var($input_lastname, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
                $lastname_err = "Please enter a valid name.";
            } else{
                $last_name = $input_lastname;
            }
            //validate username
            $input_username = trim($_POST["username"]);
            if(empty($input_username)){
                $username_err = "Please enter an username.";     
            } else{
                $username = $input_username;
            }
        
            //validate password
            $input_password = trim($_POST["password"]);
            if(empty($input_password)){
                $password_err = "Please enter an password.";     
            }
            //Password confirmation
            $input_repassword = trim($_POST["repassword"]);
            if(empty($input_repassword)){
                $password_err = "Please enter an password.";     
            } elseif($input_repassword !=$input_password){
                $password_err = "password doesnt match.";}
            else
            { 
                $repassword = $input_repassword;
            }
            
            // Validate address
            $input_address = trim($_POST["address"]);
            if(empty($input_address)){
                $address_err = "Please enter an address.";     
            } else{
                $address = $input_address;
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
            
            // Validate contact
            $input_contact = trim($_POST["contact"]);
            if(empty($input_contact)){
                $contact_err = "Please enter the contact no";     
            } elseif(!ctype_digit($input_contact)){
                $contact_err = "Please enter a positive integer value.";
            } else{
                $contact = $input_contact;
            }
            //Check input errors before inserting in database
            if(empty($firstname_err) && empty($lastname_err) && empty($username_err) && empty($password_err) && empty($email_err) &&empty($address_err) && empty($contact_err)){
                
                // Prepare an insert statement
                $sql = "INSERT INTO users (first_name, last_name, address, contact_number, email, username, password ) VALUES (?, ?, ?, ?, ?, ?, ?)";
            
                if($stmt = mysqli_prepare($link, $sql)){
                    // Bind variables to the prepared statement as parameters
                    $stmt->bind_param("sssssss", $first_name, $last_name, $address, $contact, $email, $username, $repassword);
                                        
                    // Attempt to execute the prepared statement
                    if(mysqli_stmt_execute($stmt)){
                        // Records created successfully. Redirect to landing page
                        //echo "User created successfully";
                        header("location: login.php?submit=posted");
                        exit();
                    } else{
                        header("location: login.php?submit=failed");
                        //echo "Oops! Something went wrong. Please try again later.";
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
    <title>Registration</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #EEEBEB;
        }
        /* .container-fluid {
            background-color: #EEEBEB;
        } */
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
                                <a class="nav-link" href="create_blog.php">Register <span class="sr-only">(current)</span></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="contact_us.php">Contact Us</a>
                            </li>
                        </ul>
                        
                        <?php if ($session_username) { ?>
                            <span class="navbar-text" id="user_detail">
                                <?php echo $fname.' '.$lname; ?>
                                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                                    <input type="hidden" value="<?php echo $session_username; ?>">
                                    <input type="submit" class="btn btn-danger" value="Logout">
                                </form>
                            </span>
                        <?php } else { ?>
                            <a href="login.php" class="btn btn-primary">Login</a>    
                        <?php } ?>
                    </div>
                </nav>

                <div class="wrapper">
                    <h2 class="mt-5">Sign up form</h2>
                    <p>Please fill this form and submit to sign up</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"> 
                    
                        <div class="form-group">
                            <label>Firstname</label>
                            <input type="text" name="firstname" class="form-control <?php echo (!empty($firstname_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $first_name; ?>">
                            <span class="invalid-feedback"><?php echo $firstname_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Lastname</label>
                            <input type="text" name="lastname" class="form-control <?php echo (!empty($lastname_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $last_name; ?>">
                            <span class="invalid-feedback"><?php echo $lastname_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Username</label>
                            <input type="text" name="username"  class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                            <span class="invalid-feedback"><?php echo $username_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="text" name="email" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>">
                            <span class="invalid-feedback"><?php echo $email_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>">
                            <span class="invalid-feedback"><?php echo $password_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Re-Password</label>
                            <input type="password" name="repassword" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $repassword; ?>">
                            <span class="invalid-feedback"><?php echo $password_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Address</label>
                            <textarea name="address" class="form-control <?php echo (!empty($address_err)) ? 'is-invalid' : ''; ?>"><?php echo $address; ?></textarea>
                            <span class="invalid-feedback"><?php echo $address_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Contact</label>
                            <input type="text" name="contact" class="form-control <?php echo (!empty($contact_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $contact; ?>">
                            <span class="invalid-feedback"><?php echo $contact_err;?></span>
                        </div>
                        <input type="submit" name="submit"class="btn btn-success" value="Submit">
                        <a href="dashboard.php" class="btn btn-danger ml-2">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>