<?php include '_header.mandatory.php';

$fmw->audit('User logged out');
$fmw->logout();
header("Location: bookSearch.php");

?>