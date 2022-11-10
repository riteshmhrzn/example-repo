<?php
/* Attempt MySQL server connection. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
// Include connect_database file
require_once "connect_database.php";

//echo "Connected successfully";
// Attempt create table query execution
$sql = "CREATE TABLE blog_comments (
    id INT(6) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    user_id INT(6) NOT NULL,
    blog_id INT(6) NOT NULL,
    comment TEXT(300) NOT NULL,
    added_on DATETIME NOT NULL,
    CONSTRAINT FK_CommentUser FOREIGN KEY (user_id)
    REFERENCES users(id),
    CONSTRAINT FK_BlogComment FOREIGN KEY (blog_id)
    REFERENCES blogs(id)
)";
if (mysqli_query($link, $sql))  {
    echo "Blog comment table  created successfully.";
} else{
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
}

// Close connection
mysqli_close($link);
?>