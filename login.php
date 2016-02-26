

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
session_start();
include('connect.php');

if(isset($_SESSION['login_username'])){
	echo "<div class='alert alert-warning'>You are already logged in.</div>";
}
else{
	$username=trim($_POST['username']);
	$password=$_POST['password'];
	$sql = "SELECT * FROM users WHERE user_name='".$username."' AND user_pass='".md5($password)."';";
	
	$result = mysqli_query($conn, $sql);
	if(!$result){
		echo "An unexpected database error occurred while logging in. Please try again later. <br><br>";
		echo "Message from SQL: ".mysqli_error($conn);
		echo "<br><br>";
	}
	if (mysqli_num_rows($result) > 0){
		$row=mysqli_fetch_assoc($result);
		$_SESSION['login_username']=$row['user_name'];
		echo "<div class='alert alert-success'><strong>Login successful.</strong> Click <a href='/'>here</a> to return home.</div>";
	}
	else{
		echo "<div class='alert alert-danger'><strong>Incorrect login!</strong> Click <a href='/'>here</a> to return home.</div>";
	}
}
?>
</div>
</body>
</html>
