<?php
    // Include connect_database file
require_once "connect_database.php";
    $username = $password = $temp= "";
    $username_err = $password_err= "";
    

    if($_SERVER["REQUEST_METHOD"] == "POST"){
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
            } else { 
                $password = $input_password;
            }
        
        if ($username && $password) {
            
            // Define variables and initialize with empty values
                $full_name =  $email = $comment = "";
                $sql = "SELECT id, first_name, last_name, username, password FROM users";
                $result = $link->query($sql);
      
                if ($result->num_rows > 0) {
                    // output data of each row
                    while($row = $result->fetch_assoc()) {
                        if ($row["username"] == $username){
                            $temp = $username;
                            if($row["password"]==$password){
                                echo "User logged in successfully";
                                session_start();
                                // Starting session
                                //session_start();
                                
                                // Storing session data
                                    $_SESSION["firstname"] = $row["first_name"];
                                    $_SESSION["lastname"] = $row["last_name"];
                                    $_SESSION["username"] = $row["username"];
                                    $_SESSION["user_id"] = $row["id"];

                                header("location: dashboard.php");
                            } else{
                                $password_err = "Incorrect password";
                            }
                        } 
                    }
                    if ($temp != $username){
                        $username_err="Invalid user";
                        
                    }
                } else {
                    // echo "0 results";
                }
                $link->close();
        }
    }
?>



<html>
<head>
    <meta charset="UTF-8">
    <title>login page</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .wrapper{
            width: 600px;
            margin: 40 auto;
            background-color: #EEEBEB;
        }
    </style>
</head>
<body>
<div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">                   
                <?php if (isset($_REQUEST['submit'])) { ?>
                        <div class="alert alert-success text-center" role="alert">
                            <?php if ($_REQUEST['submit'] == 'posted') { ?>
                                User created successfully
                            <?php } else { ?>
                                Failed to create user
                            <?php } ?>
                        </div>
                        <?php } ?>
                <h2 class="mt-5">Sign in</h2><br>
                    
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"> 
                    <div class="form-group">
                        <label>Username</label>
                        <input type="text" name="username"  class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                        <span class="invalid-feedback"><?php echo $username_err;?></span>
                    </div>

                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>">
                        <span class="invalid-feedback"><?php echo $password_err;?></span>
                    </div>
                    
                    <input type="submit" class="btn btn-success" value="Sign in">
                    
                    <a href="registration.php" class="btn btn-primary ml-2">Sign Up</a>
                </form>
            </div>
        </div>        
   </div>
 </div>
</body>
</html>