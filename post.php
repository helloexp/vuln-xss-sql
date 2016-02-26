

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

if(!isset($_SESSION['login_username'])){
	echo "You must log in to make posts.";
}
else{
	$postcontent = mysqli_real_escape_string($conn,$_GET['postcontent']);
	if(strlen(trim($postcontent)) == 0){
		echo "You must type a message to post.";
		echo $postcontent;
		exit;
	}
	$sql = "INSERT INTO shouts (shout_author,shout_content,submission_date) VALUES ('".$_SESSION['login_username']."','".$postcontent."','".date("Y-m-d")."');";
	//$sql = "INSERT INTO shouts (shout_author, short_content,submission_date) VALUES (?, ?, ?);"
	
	if(mysqli_query($conn, $sql)){
		
		echo "<div class='alert alert-success'><strong>Post created successfully!</strong> Click <a href='/'>here</a> to return home.</div>";
	}
	else{
		echo "<div class='alert alert-danger'><strong>Post failed!</strong> Try again later.</div>";
		echo mysqli_error($conn);
	}
}
mysqli_close($conn);
?>
</div>
</body>
</html>


