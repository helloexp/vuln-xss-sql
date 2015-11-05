<html>
<head>
<title>Hello</title>
</head>
<body>
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
You are logged in as <font color="green"><b><?php echo $_SESSION['login_username']; ?>.</b></font><br>
<a href="logout.php">Log out</a><br><br>

<?php
}
?>
<h2>Public shouts:</h2>
<br>
<?php
$servername = "localhost";
$username = "shoutbox";
$password = "redacted";
$dbname = "shoutbox";
// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
$sql = "SELECT shout_id, shout_author, shout_content, submission_date FROM shouts ORDER BY shout_id desc";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0){
	while($row = mysqli_fetch_assoc($result)){
		echo "<hr>";		
		echo "<b>".$row["shout_author"]."</b> posted on ".$row["submission_date"].":<br>";
		echo $row["shout_content"];
		echo "<hr>";
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
<form name="postshout" action="post.php" method="post">
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
</body>
</html>
