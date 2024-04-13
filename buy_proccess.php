<?php

include "./shared/database/connect.php";
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
    header("location: register.php");
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $item_id = $_GET['item_id'];
    $item_name = $_GET['item_name'];
    $quantity = $_GET['quantity'];
    $user_id = $_SESSION['user_id'];


    $sqlQueryForBuying = "UPDATE `items` SET `quantity`  = `quantity` + $quantity WHERE `user_id` = $user_id AND `item_id` = $item_id";
    $resultForBuying = mysqli_query($conn, $sqlQueryForBuying);

    if (!$resultForBuying) {
        die("Something went wrong.");
    } else {
        echo "Item transfering... <br/>";
        $sqlQueryForDeletingFromMarket = "UPDATE `market` SET `status` = 'sold' WHERE `item_id` = '$item_id'";
        $resultForDeletingFromMarket = mysqli_query($conn, $sqlQueryForDeletingFromMarket);
        if (!$resultForDeletingFromMarket) {
            die("Something went wrong.");
        } else {
            echo "Item bought successfully.";
        }
    }
}
