<?php
session_start(); // Start the session to access session variables
include "./shared/database/connect.php"; // Include the database connection file

// Check if user is not logged in or username is not set in session, redirect to register page
if((!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) || !isset($_SESSION['username'])){
    header("location: register.php");
} else {
    $username = $_SESSION['username']; // Get the username from session

    // SQL query to select user details based on username
    $sqlQuery = "SELECT * FROM `user` where `username` = '$username'";
    $resultForUsername = mysqli_query($conn, $sqlQuery);
    $row = mysqli_fetch_assoc($resultForUsername);
    $admin_user_id = $row['user_id'];
    $is_admin = $row['is_admin'];

    if($is_admin != 1){ // If user is not an admin, redirect to index page
        header("location: index.php");
    }

    // If request method is POST
    if($_SERVER['REQUEST_METHOD'] == "POST"){
        $toDeleteUserId = $_POST['delete_id']; // Get the user id to delete
        
        // Multi-line SQL query to delete user data from multiple tables
        $multiLineSQLQuery = "
        DELETE FROM `market` WHERE `user_id` = '$toDeleteUserId';
        DELETE FROM `items` WHERE `user_id` = '$toDeleteUserId';
        DELETE FROM `user` WHERE `user_id` = '$toDeleteUserId';
        ";

        // Execute the multi-query
        $result = mysqli_multi_query($conn, $multiLineSQLQuery);
        
        if($result){ // If deletion successful, echo "deleted"
            echo "deleted";
            mysqli_close($conn); // Close the database connection
            exit;
        }else{
            echo "not deleted"; // If deletion fails, echo "not deleted"
        }
    }
}
?>

<!-- HTML form to delete a user -->
<body>
    <form action="./admin.php" method="POST">
        <input type="text" placeholder="Enter username to delete" autocomplete="organization" name="delete_id" list="user_id"/>
        <datalist id="user_id">
            <?php
            // Retrieve user ids from the database and display as options in the datalist
            $sqlQuery = "SELECT * FROM `user`";
            $resultForUsername = mysqli_query($conn, $sqlQuery);
            while($row = mysqli_fetch_assoc($resultForUsername))
                echo '<option value="' . $row['user_id'] . '"> '. $row['user_id'] .'</option>';
            ?>
        </datalist>
        <input type="submit" value="delete the user" name="delete" />
    </form>
</body>
