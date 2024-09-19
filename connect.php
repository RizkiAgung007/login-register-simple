<?php
$dbHost = "localhost";
$dbUser = "root";
$dbPass = "";
$dbName = "login_register";

$conn = mysqli_connect($dbHost, $dbUser, $dbPass, $dbName);
if(!$conn) {
    die ("Something went wrong");
}
?>