<?php

$server = "localhost";
$user = "root";
$pass = "RomyTou@123";
$database = "shop";


$conn = mysqli_connect($server, $user, $pass, $database);

if (!$conn) {
    die("<script>alert('Connection Failed.')</script>");
}

?>% 