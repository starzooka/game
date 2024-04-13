<?php
// variables for connecting to Mysql database
$servername = 'localhost';
$username = 'root';
$password = '';
$database = 'dashboard';
// Create a connection to mySQL database
$conn = mysqli_connect($servername, $username, $password, $database);

if(!$conn) {
    die("Unable to connect to the server \n Error:". mysqli_connect_error());
}else

?>
