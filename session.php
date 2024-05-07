<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if(session_id() == '' || !isset($_SESSION["email"]) || session_status() === PHP_SESSION_NONE) {
    // session isn't started
    header('Location: index.php');
}
?>