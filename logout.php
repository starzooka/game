<?php
// Session initialization and login state check
if(!isset($_SESSION)){
    session_start();
}

session_unset();
session_destroy();
header('location: index.php');



?>