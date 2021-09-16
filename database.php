<?php


$server = "localhost";
$username = "root";
$password = "";
$database = "exam";
$port = "3306";


// Create connection
$conn = new mysqli($server, $username, $password,$database,$port);

// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

?>