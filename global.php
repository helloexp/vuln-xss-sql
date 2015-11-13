<?php

include 'global.html';

function toHome($message) {
    session_start();
    $_SESSION['message'] = strval($message);
    echo "<script>window.location.href = '/';</script>";
    echo strval($message);
}

?>
