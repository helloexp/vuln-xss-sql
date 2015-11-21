<?php

include 'global.php';

$action = $_GET['action'];

if ($action == "signup") {

    $acc_username = trim($_POST['username']);
    $acc_password = $_POST['password'];
    $acc_password_confirm = $_POST['password_confirm'];

    if (strlen($acc_username) <= 0) {
        toHome("Please enter a username.");
    } elseif (strlen($acc_password) <= 0) {
        toHome("Please enter a password.");
    } elseif (strlen($acc_password) < 5) {
        toHome("Your password must be at least five characters long.");
    } elseif ($acc_password != $acc_password_confirm) {
        toHome("The passwords you typed do not match.");
    } else {

        include 'connect.php';

        $sql = "SELECT * FROM users WHERE user_name='" . $acc_username . "';";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            toHome("This username is already taken.");
        } else {
            $sql = "INSERT INTO users (user_name, user_pass) VALUES ('" . $acc_username . "','" . md5($acc_password) . "');";
            if (mysqli_query($conn, $sql)) {
                session_start();
                $_SESSION['login_username'] = $acc_username;
                toHome("Account created. You have been logged in.");
            } else {
                toHome("Error encountered: ".mysqli_error($conn));
            }
        }

        mysqli_close($conn);

    }

} elseif ($action == "login") {

    session_start();

    if(isset($_SESSION['login_username'])){
        echo "You are already logged in.";
    } else {

        include 'connect.php';

        $login_username = trim($_POST['username']);
        $login_password = $_POST['password'];

        $sql = "SELECT * FROM users WHERE user_name='".$login_username."' AND user_pass='".md5($login_password)."';";
        $result = mysqli_query($conn, $sql);

        if (!$result) {
            echo "An unexpected database error occurred while logging in. Please try again later. <br><br>";
            echo "Message from SQL: ".mysqli_error($conn);
        } elseif (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $_SESSION['login_username'] = $row['user_name'];
            toHome("Logged in as ".$login_username);
        } else {
            toHome("Invalid login");
        }
    }

} elseif ($action == "logout") {
    session_start();
    session_destroy();

    toHome("You've been logged out");
} elseif ($action == "post") {

    session_start();
    include 'connect.php';

    $postcontent = mysqli_real_escape_string($conn,$_POST['content']);
    $postcontent = $_POST['content'];

    if(strlen($postcontent) == 0){
        toHome("You must type a message to post.");
    }

    $sql = "INSERT INTO shouts (shout_author, shout_content) VALUES ('".$_SESSION["login_username"]."', '".$postcontent."');";
    echo "<script>window.location.href='index.html?message='".$_SESSION["login_username"]."</script>";

    if(mysqli_query($conn, $sql)) {
        toHome("Post made!");
    }
    else {
        echo "Post failed. Try again later.";
        echo mysqli_error($conn);
    }
}

?>
