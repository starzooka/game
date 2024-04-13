<?php
// include "./shared/database/connect.php";
// session_start();

// $selling_item_name = $_SESSION['sell_item_name'];
// $selling_item_id = $_SESSION['sell_item_id'];
// // $selling_item_id = "123";
// $user_id = $_SESSION['user_id'];

// $selling_item_quantity = $_GET['quantity'];
// $selling_item_price = $_GET['price'];
// $sql = " SELECT * FROM items WHERE `user_id` = $user_id";
// $result = mysqli_query($conn, $sql);
// $row = mysqli_fetch_assoc($result);

// if (mysqli_num_rows($result) > 0) {
//     while ($row = mysqli_fetch_assoc($result)) {
//         $available_quantity = $row['quantity'];
//         if ($available_quantity > 0 && $available_quantity > $selling_item_quantity) {
//             $sqlQuery = "INSERT INTO `market` (`user_id`, `item_id`, `item_name`, `quantity`, `price`) VALUES ('$user_id', '$selling_item_id', '$selling_item_name', '$selling_item_quantity', '$selling_item_price')";
//             $result = mysqli_query($conn, $sqlQuery);
//             echo $result;
//             if (!$result) {
//                 die("failed to list your item.");
//             } else {
//                 echo "successfully listed your item.";

//                 $sqlQueryForDeletingItemFromInventory = "UPDATE `inventory` SET `quantity` = `quantity` - $selling_item_quantity WHERE `user_id` = '$user_id' AND `item_id` = '$selling_item_id'";
//                 $result = mysqli_query($conn, $sqlQueryForDeletingItemFromInventory);
//                 if (!$result) {
//                     echo "failed to delete item from inventory.";
//                 } else {
//                     $_SESSION['sell_item_name'] = null;
//                     $_SESSION['sell_item_id'] = null;
//                     header('location: index.php');
//                 }
//             }
//         }else{
//             echo'<script>alert("You Dont have enough items to sell!")</script>';
//             // header('location: inventory.php');
//             exit;
//         }
//     }
// }


include "./shared/database/connect.php";
session_start();

$selling_item_name = $_SESSION['sell_item_name'];
$selling_item_id = $_SESSION['sell_item_id'];
// $selling_item_id = "123";
$user_id = $_SESSION['user_id'];

$selling_item_quantity = $_GET['quantity'];
$selling_item_price = $_GET['price'];
$sql = "SELECT * FROM items WHERE `user_id` = $user_id";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $available_quantity = $row['quantity'];
        if ($available_quantity > 0 && $available_quantity >= $selling_item_quantity) {
            $sqlQuery = "INSERT INTO `market` (`user_id`, `item_id`, `item_name`, `quantity`, `price`) VALUES ('$user_id', '$selling_item_id', '$selling_item_name', '$selling_item_quantity', '$selling_item_price')";
            $result_insert = mysqli_query($conn, $sqlQuery);
            if (!$result_insert) {
                die("failed to list your item.");
            } else {
                $sqlQueryForDeletingItemFromInventory = "UPDATE `items` SET `quantity` = `quantity` - $selling_item_quantity WHERE `user_id` = '$user_id' AND `item_id` = '$selling_item_id'";
                $result_delete = mysqli_query($conn, $sqlQueryForDeletingItemFromInventory);
                if (!$result_delete) {
                    echo "failed to delete item from inventory.";
                } else {
                    $_SESSION['sell_item_name'] = null;
                    $_SESSION['sell_item_id'] = null;
                    header('location: index.php');
                }
            }
        } else {
            echo '<script>alert("You Dont have enough items to sell!")</script>';
            exit;
        }
    }
} else {
    echo "No items found.";
}
