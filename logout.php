<?php

// Start of the PHP code block

// Session initialization and login state check
if(!isset($_SESSION)){
    session_start();
}

// Unset and destroy the session variables
session_unset();
session_destroy();

// Redirect to the index.php page
header('location: index.php');

?>