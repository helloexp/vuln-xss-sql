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
		
		echo "Post created successfully. Click <a href='/'>here</a> to return home.";
	}
	else{
		echo "Post failed. Try again later.";
		echo mysqli_error($conn);
	}
}
mysqli_close($conn);
?>
