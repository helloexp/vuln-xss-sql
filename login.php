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

if(isset($_SESSION['login_username'])){
	echo "You are already logged in.";
}
else{
	$username=trim($_POST['username']);
	$password=$_POST['password'];
	$sql = "SELECT * FROM users WHERE user_name='".$username."' AND user_pass='".md5($password)."';";
	$result = mysqli_query($conn, $sql);
	if (mysqli_num_rows($result) > 0){
		$_SESSION['login_username']=$username;
		echo "Login successful. Click <a href='/'>here</a> to return home.";
	}
	else{
		echo "Incorrect login. Click <a href='/'>here</a> to return home.";
	}
}
?>
