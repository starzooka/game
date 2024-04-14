<?php
// Including database connection file
include "./shared/database/connect.php";
// Starting session
session_start();

// Retrieving session variables
$selling_item_name = $_SESSION['sell_item_name'];
$selling_item_id = $_SESSION['sell_item_id'];
$user_id = $_SESSION['user_id'];

// Retrieving item quantity and price from GET request
$selling_item_quantity = $_GET['quantity'];
$selling_item_price = $_GET['price'];

// SQL query to select items belonging to the user
$sql = "SELECT * FROM items WHERE `user_id` = $user_id";
$result = mysqli_query($conn, $sql);

// Checking if items are found
if (mysqli_num_rows($result) > 0) {
    // Looping through each item
    while ($row = mysqli_fetch_assoc($result)) {
        $available_quantity = $row['quantity'];
        // Checking if the available quantity is sufficient for selling
        if ($available_quantity > 0 && $available_quantity >= $selling_item_quantity) {
            // SQL query to insert item into the market table
            $sqlQuery = "INSERT INTO `market` (`user_id`, `item_id`, `item_name`, `quantity`, `price`) VALUES ('$user_id', '$selling_item_id', '$selling_item_name', '$selling_item_quantity', '$selling_item_price')";
            $result_insert = mysqli_query($conn, $sqlQuery);
            // Checking if item insertion was successful
            if (!$result_insert) {
                die("failed to list your item.");
            } else {
                // SQL query to update quantity in inventory after selling
                $sqlQueryForDeletingItemFromInventory = "UPDATE `items` SET `quantity` = `quantity` - $selling_item_quantity WHERE `user_id` = '$user_id' AND `item_id` = '$selling_item_id'";
                $result_delete = mysqli_query($conn, $sqlQueryForDeletingItemFromInventory);
                // Checking if update was successful
                if (!$result_delete) {
                    echo "failed to delete item from inventory.";
                } else {
                    // Resetting session variables and redirecting to index.php
                    $_SESSION['sell_item_name'] = null;
                    $_SESSION['sell_item_id'] = null;
                    header('location: index.php');
                }
            }
        } else {
            // Alerting user if they don't have enough items to sell
            echo '<script>alert("You Dont have enough items to sell!")</script>';
            exit;
        }
    }
} else {
    // Alerting if no items are found for the user
    echo "No items found.";
}
