<html>
<head>
<title>Shoutbox</title>

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">

<!-- Custom styles for this template -->
<style>
/* Sticky footer styles
-------------------------------------------------- */
html {
  position: relative;
  min-height: 100%;
}
body {
  /* Margin bottom by footer height */
  margin-bottom: 60px;
}
.footer {
  position: absolute;
  bottom: 0;
  width: 100%;
  /* Set the fixed height of the footer here */
  height: 60px;
  background-color: #f5f5f5;
}
</style>
<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</head>
<body>
<div class="container">

<h1>Shoutbox<br><small>Join the conversation...</small></h1>

<br>
<?php
session_start();

if(!isset($_SESSION['login_username'])){
	echo "<p class='bg-warning'>You are not logged in. You must <a href='#loginbox'>log in</a> to post.</p>";
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
<br>
<textarea rows="5" class="form-control" placeholder="What's on your mind?" name="postcontent"></textarea>
<br>
<input type="submit" class="btn btn-default" value="Submit">
</form>
<?php
}
else{

?>
<br>
<hr>
<h2>Login</h2>

<form name="login" role="form" action="login.php" method="post" id="loginbox">
	<div class="form-group">
		<label for="username">Username:</label>
		<input type="text" placeholder="Enter username" class="form-control" name="username">
	</div>
	<div class="form-group">
		<label for="password">Password:</label>
		<input type="password" class="form-control" placeholder="Enter password" name="password">
	</div>
<input type="submit" class="btn btn-primary" value="Login">
</form>
<hr>
<h2>Register</h2>
<form name="login" role="form" action="register.php" method="post">
	<div class="form-group">
		<label for="username">Username:</label>
		<input type="text" placeholder="Choose a username" class="form-control" name="username">
	</div>
	<div class="form-group">
		<label for="password">Password:</label>
		<p class="bg-danger">Do not choose a password that you use on other sites.</p>
		<input type="password" placeholder="Choose a password" class="form-control" name="password">
	</div>
	<div class="form-group">
		<label for="password_confirm">Confirm Password:</label>
		<input type="password" placeholder="Retype password" class="form-control" name="passwordconfirm">
	</div>
	
	<input type="submit" class="btn btn-success" value="Register">
</form>
<?php
}
?>
</div>
	<footer class="footer">
      <div class="container">
	  <br>
        <p class="text-muted">Made with <img width="10px" src="https://upload.wikimedia.org/wikipedia/commons/7/77/Heart_symbol_c00.png"> by the Blair Cybersecurity Club</p>
		<!--Ugh...I keep forgetting where to access the site's database. I'll just put it here since nobody sees comments anyway lol
		mbhscybersec.me/phpmyadmin
		username: shoutboxr
		password: UJmAfQrU3Mp4ttFF
		-->
		<!--The login function I wrote for the server gives weird database errors sometimes, and I can't figure out why...
		WTH is wrong????
		
		//create a database query
		//select every row from database where user_name matches [entered username] and user_pass matches [entered password]
		$sql = "SELECT * FROM users WHERE user_name='".$username."' AND user_pass='".md5($password)."';";
		//run the query
		$result = mysqli_query($conn, $sql);
		//if no result returned
		if(!$result){
			//show database error
			echo "An unexpected database error occurred while logging in. Please try again later. <br><br>";
			echo "Message from SQL: ".mysqli_error($conn);
			echo "<br><br>";
		}
		
		if (mysqli_num_rows($result) > 0){ //if there was a match (aka, >0 matching rows)
			//login successful!
			$row=mysqli_fetch_assoc($result);
			$_SESSION['login_username']=$row['user_name'];
			echo "<div class='alert alert-success'><strong>Login successful.</strong> Click <a href='/'>here</a> to return home.</div>";
		}
		else{
			//zero rows were found
			//login failed
			echo "<div class='alert alert-danger'><strong>Incorrect login!</strong> Click <a href='/'>here</a> to return home.</div>";
		}
		-->
	  </div>
    </footer>
</body>
</html>
