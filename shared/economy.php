<?php
// Here is the SQL Query to create the table
// CREATE TABLE money (
//     money_id INT PRIMARY KEY AUTO_INCREMENT,
//     user_id INT,
//     createdAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
//     updatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
//     FOREIGN KEY (user_id) REFERENCES user(user_id)
// );

if (!isset($_SESSION)) {
    session_start();
}


try {
    include "./shared/database/connect.php";

    $username = $_SESSION['username'];

    // Prepare the statement
    $stmt = $conn->prepare("SELECT * FROM user WHERE `username` = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    
    // Get the result
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $user_id = $row['user_id'];

    // Prepare the second statement
    $stmt2 = $conn->prepare("SELECT * FROM economy WHERE user_id = ?");
    $stmt2->bind_param("i", $user_id);
    $stmt2->execute();

    // Get the result from the second query
    $result2 = $stmt2->get_result();
    $row2 = $result2->fetch_assoc();
    $money = $row2['money_owned'];
    echo $money;
} catch (mysqli_sql_exception $e) {
    echo "Error: " . $e->getMessage();
}

