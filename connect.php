<?php

$servername = "localhost";
$db_username = "";
$db_password = "";
$dbname = "shoutbox";

// Create connection
$conn = mysqli_connect($servername, $db_username, $db_password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

?>
