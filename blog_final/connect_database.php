<?php
/* Attempt MySQL server connection. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
$link = new mysqli("localhost", "root", "", 'blog');
 
// Check connection
if (!$link) {
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>