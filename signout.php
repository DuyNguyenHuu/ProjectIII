<?php
require_once "session.php";
unset($_SESSION['email']);
header("Location: index.php");
?>