<?php
/* Attempt MySQL server connection. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
// Include connect_database file
require_once "connect_database.php";
//echo "Connected successfully";
// Attempt create table query execution
$sql = "CREATE TABLE blogs (
    id INT(6) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(100) NOT NULL,
    file VARCHAR(70) NULL,
    content LONGTEXT NOT NULL
)";
if (mysqli_query($link, $sql))  {
    echo "Blog table created successfully.";
} else{
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
}

// Close connection
mysqli_close($link);
?>