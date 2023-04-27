<?php
	ob_start();
	session_start(); // Start The Session
    include 'connect.php';
    session_unset(); // Unset The Data
	session_destroy(); // Destory The Session
	header('Location: ./index.php');
	exit();
	ob_end_flush();
?>