<?php

// Include the database connection file
include "./shared/database/connect.php";

// Start the session
session_start();

// Check if user is not logged in, redirect to register page
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
    header("location: register.php");
}

// Check if the request method is GET
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Retrieve item information from GET parameters
    $item_id = $_GET['item_id'];
    $item_name = $_GET['item_name'];
    $quantity = $_GET['quantity'];
    $user_id = $_SESSION['user_id'];

    // SQL query to update item quantity in user's inventory
    $sqlQueryForBuying = "UPDATE `items` SET `quantity`  = `quantity` + $quantity WHERE `user_id` = $user_id AND `item_id` = $item_id";

    // Execute the update query
    $resultForBuying = mysqli_query($conn, $sqlQueryForBuying);

    // Check if update was successful
    if (!$resultForBuying) {
        die("Something went wrong."); // If not, terminate the script with an error message
    } else {
        echo "Item transferring... <br/>"; // If successful, notify the user

        // SQL query to mark item as sold in the market
        $sqlQueryForDeletingFromMarket = "UPDATE `market` SET `status` = 'sold' WHERE `item_id` = '$item_id'";
        
        // Execute the query to mark the item as sold
        $resultForDeletingFromMarket = mysqli_query($conn, $sqlQueryForDeletingFromMarket);

        // Check if update was successful
        if (!$resultForDeletingFromMarket) {
            die("Something went wrong."); // If not, terminate the script with an error message
        } else {
            echo "Item bought successfully."; // If successful, notify the user
        }
    }
}
