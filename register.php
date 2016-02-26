<html>
<head>
<title>Hello</title>

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</head>
<body>
<div class="container">
<?php
$username = trim($_POST['username']);
$password = $_POST['password'];
$passwordconfirm = $_POST['passwordconfirm'];
if(strlen($username) <= 0 ){
	echo "<div class='alert alert-danger'>Please enter a username. <a href='/'>Go back</a></div>";
	exit;
}
if(strlen($password) <= 5){
	echo "<div class='alert alert-danger'>Your password must be at least five characters long. <a href='/'>Go back</a></div>";
	exit;
}
if($password != $passwordconfirm){
	echo "<div class='alert alert-danger'>The passwords you typed do not match. <a href='/'>Go back</a></div>";
	exit;
}
include('connect.php');
$sql = "SELECT * FROM users WHERE user_name='".$username."';";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0){
	echo "<div class='alert alert-danger'>This username is already taken. Pick a different username. <a href='/'>Go back</a></div>";
	exit;
}
else{
	$sql = "INSERT INTO users (user_name, user_pass) VALUES ('".$username."','".md5($password)."');";
	if(mysqli_query($conn, $sql)){
		session_start();
		$_SESSION['login_username']=$username;
		echo "<div class='alert alert-success'>New user account created. Click <a href='/'>here</a> to return home.</div>";
	}
	else{
		echo "<div class='alert alert-danger'>Account creation failed. Try again later. <a href='/'>Go back</a></div>";
		echo mysqli_error($conn);
	}
}
mysqli_close($conn);
?>

</div>
</body>
</html>

