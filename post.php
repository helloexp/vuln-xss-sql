<?php
session_start();
$servername = "localhost";
$db_username = "shoutbox";
$db_password = "redacted";
$dbname = "shoutbox";
// Create connection
$conn = mysqli_connect($servername, $db_username, $db_password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if(!isset($_SESSION['login_username'])){
	echo "You must log in to make posts.";
}
else{
	$postcontent = mysqli_real_escape_string($conn,$_POST['postcontent']);
	if(strlen(trim($postcontent)) == 0){
		echo "You must type a message to post.";
		echo $postcontent;
		exit;
	}
	$sql = "INSERT INTO shouts (shout_author,shout_content,submission_date) VALUES ('".$_SESSION['login_username']."','".$postcontent."','".date("Y-m-d")."');";
	//$sql = "INSERT INTO shouts (shout_author, short_content,submission_date) VALUES (?, ?, ?);"
	
	if(mysqli_query($conn, $sql)){
		
		echo "Post created successfully. Click <a href='/'>here</a> to return home.";
	}
	else{
		echo "Post failed. Try again later.";
		echo mysqli_error($conn);
	}
}
mysqli_close($conn);
?>
