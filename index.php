<html>
<head>
    <title>Shoutbox!</title>
    <?php include 'global.php'; ?>
    <link rel="stylesheet" type="text/css" href="index.css">
</head>

<body>

<div id="wrap">

    <?php

    session_start();
    $message = $_SESSION['message'];
    if (isset($message)) {
        echo "<div id='alert'>".$message."</div>";
        unset($_SESSION['message']);
    }

    ?>

    <div id="intro">
        <h1>Shoutbox!</h1>
        <p>This site is meant to be demonstration of XSS and SQL Injection vulnerabilities, for educational purposes only. All posts are cleared every five minutes.</p>
    </div>

    <?php

    session_start();

    include 'connect.php';

    $sql = "SELECT * FROM shouts ORDER BY id DESC";
    $result = mysqli_query($conn, $sql);

    echo "<div id='shouts'>";
    echo "<h2>Posted shouts</h2>";

    if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            echo "
                <div class='shout'>
                    <span class='title'>".$row["author"].":</span>
                    <div class='content'>".$row["content"]."</div>
                </div>
            ";
        }
    } else {
        echo "<div id='noShouts'>No shouts have been posted yet :(</div>";
    }
    mysqli_close($conn);

    echo "</div>";

    if(isset($_SESSION['login_username'])){
        echo "
            <div id='loggedIn'>

                <h2>Post a shout</h2>
        
                <p>Posting as ".$_SESSION["login_username"]."</p>

                <button id='logOut'>Log out</button>

                <div id='postShout'>
                    <form name='shout' action='action.php?action=post' method='post'>
                        <label for='content'>Speak your heart:</label>
                        <textarea name='content'></textarea>
                        <input type='submit' method='Post' value='Post'>
                    </form>
                </div>

            </div>
        ";

    } else {

        echo "
    <div id='notLoggedIn'>

        <h2>You are not logged in. You must log in to post.</h2>

        <h4>Log in</h4>
        <div id='logIn'>
            <form name='signup' action='action.php?action=login' method='post'>
                <label for='username'>Username:</label>
                <input type='text' name='username'>
                <label for='password'>Password:</label>
                <input type='password' name='password'>
                <input type='submit' value='Log in'>
            </form>
        </div>

        <h4>Sign up</h4>
        <div id='signUp'>
            <form name='signUp' action='action.php?action=signup' method='post'>
                <label for='username'>Create a username:</label>
                <input type='text' name='username'>
                <label for='password'>Create a password</label>
                <input type='password' name='password'>
                <label for='password_confirm'>Confirm Password:</label>
                <input type='password' name='password_confirm'>
                <input type='submit' value='Sign up'>
            </form>
        </div>

    </div>
    ";
    }

    ?>
</div>



<script type="text/javascript" src="index.js"></script>


</body>
</html>
