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
    $price = $_GET['price'];
    $market_id = $_GET['m_id'];
    $seller_user_id = $_GET['user_id'];
    //  Retrieve item information from SESSION
    $buyer_user_id = $_SESSION['user_id'];

    $sqlForFetchingBuyerId = "SELECT * FROM economy WHERE `user_id` = $buyer_user_id ";
    $resultForFetchingBuyerId = mysqli_query($conn, $sqlForFetchingBuyerId);
    // Check if there are any rows returned
    if (mysqli_num_rows($resultForFetchingBuyerId) > 0) {
        // Fetch the data from the database
        $row = mysqli_fetch_assoc($resultForFetchingBuyerId);
        // Store the data in variables
        $buyer_avaliable_money = $row["money_owned"];
        // Check if the user has enough money to buy the item
        if ($buyer_avaliable_money < $price) {
            echo "You don't have enough money to buy this item.";
            exit;
        } else {
            // SQL query to update money in buyer's and seller's accounts
            $sqlQueryForMoneyTransaction = "
            UPDATE `economy` SET `money_owned` = `money_owned` - $price WHERE `user_id` = $buyer_user_id;
            UPDATE `economy` SET `money_owned` = `money_owned` + $price WHERE `user_id` = $seller_user_id;";
            $resultForMoneyTransaction = mysqli_multi_query($conn, $sqlQueryForMoneyTransaction);
            if (!$resultForMoneyTransaction) {
                die("Transaction failed.");
                // Consume the results of the previous queries
            
            } else {
                while(mysqli_next_result($conn)) {
                    if (!mysqli_more_results($conn)) {
                        break;
                    }
                }
                // SQL query to update item quantity in user's inventory
                $sqlQueryForBuying = "UPDATE `items` SET `quantity` = `quantity` + $quantity WHERE  `user_id` = $buyer_user_id AND `item_id` = $item_id";
                $resultForBuying = mysqli_query($conn, $sqlQueryForBuying);

                // Check if update was successful
                if (!$resultForBuying) {
                    die("Something went wrong."); // If not, terminate the script with an error message
                } else {
                    echo "Item transferring... <br/>"; // If successful, notify the user

                    // SQL query to mark item as sold in the market
                    $sqlQueryForDeletingFromMarket = "UPDATE `market` SET `status` = 'sold' WHERE `item_id` = '$item_id' AND `market_id` = '$market_id'";

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
            // Execute the update query

        }
    }

}
