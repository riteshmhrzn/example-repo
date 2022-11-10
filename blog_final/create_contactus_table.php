<?php
/* Attempt MySQL server connection. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
// Include connect_database file
require_once "connect_database.php";
// Attempt create table query execution
$sql = "CREATE TABLE contactus (
    id INT(6) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    full_name VARCHAR(30) NOT NULL,
    email VARCHAR(70) NOT NULL UNIQUE,
    remarks VARCHAR(150) NOT NULL
)";
if (mysqli_query($link, $sql))  {
    echo "Contact us table created successfully.";
} else{
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
}

// Close connection
mysqli_close($link);
?>