<?php
$username = trim($_POST['username']);
$password = $_POST['password'];
$passwordconfirm = $_POST['passwordconfirm'];
if(strlen($username) <= 0 ){
	echo "Please enter a username.";
	exit;
}
if(strlen($password) <= 5){
	echo "Your password must be at least five characters long.";
	exit;
}
if($password != $passwordconfirm){
	echo "The passwords you typed do not match.";
	exit;
}
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
$sql = "SELECT * FROM users WHERE user_name='".$username."';";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0){
	echo "This username is already taken. Pick a different username.";
	exit;
}
else{
	$sql = "INSERT INTO users (user_name, user_pass) VALUES ('".$username."','".md5($password)."');";
	if(mysqli_query($conn, $sql)){
		session_start();
		$_SESSION['login_username']=$username;
		echo "New user account created. Click <a href='/'>here</a> to return home.";
	}
	else{
		echo "Account creation failed. Try again later.";
		echo mysqli_error($conn);
	}
}
mysqli_close($conn);
?>
