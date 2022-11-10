<?php
/* Attempt MySQL server connection. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
// Include connect_database file
require_once "connect_database.php";
// Attempt create table query execution
$sql = "CREATE TABLE users (
    id INT(6) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    first_name VARCHAR(30) NOT NULL,
    last_name VARCHAR(30) NOT NULL,
    address VARCHAR(30) NOT NULL,
    contact_number VARCHAR(30) NOT NULL,
    email VARCHAR(70) NULL,
    username VARCHAR(70) NULL,
    password VARCHAR(70) NULL
)";
if (mysqli_query($link, $sql))  {
    echo "User Table created successfully.";
} else{
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
}

// Close connection
mysqli_close($link);
?>
