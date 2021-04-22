<?php
// Basic configuration for database connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "dims_db";
$port=3307;
// Create connection
// Enter $port after database if any problem occured
$connection = mysqli_connect($servername, $username, $password,$database);

// To check weather connection id done or not
if($connection==false){
    die("Connection Failed:".$connection->connect_error);
}

?>