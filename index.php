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

<h1>Shoutbox</h1>
<i>This site is meant to be demonstration of XSS and SQL Injection vulnerabilities, for educational purposes only. All posts are cleared every five minutes.</i>
<br>
<?php
session_start();

if(!isset($_SESSION['login_username'])){
	echo "<p>You are not logged in. You must log in to post.</p>";
}
else{
?>
<p class="bg-success">You are logged in as <font color="green"><b><?php echo $_SESSION['login_username']; ?>.</b></font><br></p>
<a href="logout.php">Log out</a><br><br>

<?php
}
?>
<h1><small>Public shouts:</small></h1>
<br>
<?php
include('connect.php');
$sql = "SELECT shout_id, shout_author, shout_content, submission_date FROM shouts ORDER BY shout_id desc";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0){
	while($row = mysqli_fetch_assoc($result)){
		echo "<blockquote>";		
		echo "<p class='text-muted'><code>".$row["shout_author"]."</code> says...</p>";
		echo $row["shout_content"];
		
		echo "<small>posted on ".$row['submission_date']."</small>";
		echo "</blockquote>";
	}
}
else {
	echo "No public shouts have been posted yet :(";
}
mysqli_close($conn);
?>
<?php
if(isset($_SESSION['login_username'])){

?>

<h2>Post a shoutout:</h2>
<form name="postshout" action="post.php" method="get">
Your message here:<br>
<textarea rows="5" name="postcontent">Enter message...</textarea>

<input type="submit" value="Submit">
</form>
<?php
}
else{

?>
<br>
<h2>Login</h2>
<form name="login" action="login.php" method="post">
Username:<br><input type="text" name="username"><br>
Password:<br><input type="password" name="password"><br>
<input type="submit" value="Login">
</form>

<h2>Register</h2>
<form name="login" action="register.php" method="post">
Username:<br><input type="text" name="username"><br>
Password:<br><input type="password" name="password"><br>
Confirm Password:<br><input type="password" name="passwordconfirm"><br>
<input type="submit" value="Register">
</form>
<?php
}
?>
</div>
</body>
</html>
