<?php
$dsn = 'mysql:host=localhost;dbname=edumate';
$user = 'root';
$pass = '';
$option = array(
    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8', //for arabic language
);
try {
    $con = new PDO($dsn, $user, $pass, $option);
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //throw exception
} catch (PDOException $e) {
    echo 'Failed To Connect' . $e->getMessage();
}
