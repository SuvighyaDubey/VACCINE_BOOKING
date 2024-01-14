<?php
$servername = "sql307.epizy.com";
$username = "epiz_30675281";
$password = "lsTVEKddTnnn";
$dbname = "epiz_30675281_bookvaccine";
$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("Connection failed" . mysqli_connect_error());
} 
error_reporting(0);
?>