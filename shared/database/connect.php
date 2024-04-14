<?php
// Variables for connecting to MySQL database
$servername = 'localhost'; // Server name or IP address
$username = 'root'; // MySQL username
$password = ''; // MySQL password
$database = 'dashboard'; // Name of the database to connect to

// Create a connection to MySQL database
$conn = mysqli_connect($servername, $username, $password, $database);

// Check if connection is successful
if (!$conn) {
    // If connection fails, display an error message and terminate the script
    die("Unable to connect to the server \n Error:" . mysqli_connect_error());
} else {
    // If connection is successful, continue with the script
    // You can place your code logic here
}
?>