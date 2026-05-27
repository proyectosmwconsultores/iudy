<?php
session_start();

$_session= array();
session_unset();
session_destroy();
unset($_SESSION['IdUsua']);
header("Location: ../index.php");
?>
