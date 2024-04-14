<?php
// Include the database connection file
include "./shared/database/connect.php";

// Initialize variables to track if email and username already exist, and to control alert messages
$emailExists = false;
$usernameExists = false;
$showAlert = false;
$showError = false;
$showpassWordError = false;
$showLoaded = false;

// Check if the form has been submitted
if($_SERVER["REQUEST_METHOD"] == "POST") {

    // Assign form data to variables
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm-password'];

    // Check if the email already exists in the database
    $existsEmailSQL = "SELECT * FROM user WHERE email='$email'";
    $emailResult = mysqli_query($conn, $existsEmailSQL);
    $numEmailRowsOfEmail = mysqli_num_rows($emailResult);
    if($numEmailRowsOfEmail > 0){
        $emailExists = true;
    }

    // Check if the username already exists in the database
    $existsSQL = "SELECT * FROM user WHERE username='$username'";
    $result = mysqli_query($conn, $existsSQL);
    $numExistRowsofUsername = mysqli_num_rows($result);
    if($numExistRowsofUsername > 0){
        $usernameExists = true;
    }

    if(($usernameExists == false && $username != "") && ($emailExists == false && $email != "")){
        if($password!= $confirm_password){
            $showpassWordError = true;
        }else{
            // Hash the password before storing it in the database
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Insert the new user into the database
            $sql = "INSERT INTO `user` (`username`, `email`, `password`, `createdAt`, `updatedAt`) VALUES ('$username', '$email', '$hashedPassword', current_timestamp(), current_timestamp());";
            $result = mysqli_query($conn, $sql);

            // If the user was successfully inserted, add some default items to their inventory
            if($result){
                $showAlert = true;

                // Find the user_id of the new user
                $sqlQureyForFindingUser_id = "SELECT * FROM user where username = '$username' ";
                $resultForFindingUser_id = mysqli_query($conn, $sqlQureyForFindingUser_id);
                if (mysqli_num_rows($resultForFindingUser_id) > 0) {
                    while ($row = mysqli_fetch_assoc($resultForFindingUser_id)) {
                        $user_id = $row['user_id'];
                    }
                }

                // Insert the default items into the database
                $sql = "
                INSERT INTO `items` (`user_id`, `item_id`, `item_name`) VALUES ('$user_id', 1, 'Stone');
                INSERT INTO `items` (`user_id`, `item_id`, `item_name`) VALUES ('$user_id', 2, 'Iron');
                INSERT INTO `items` (`user_id`, `item_id`, `item_name`) VALUES ('$user_id', 3, 'Copper');
                INSERT INTO `items` (`user_id`, `item_id`, `item_name`) VALUES ('$user_id', 4, 'Silver');
                INSERT INTO `items` (`user_id`, `item_id`, `item_name`) VALUES ('$user_id', 5, 'Gold');
                INSERT INTO `items` (`user_id`, `item_id`, `item_name`) VALUES ('$user_id', 6, 'Platinum');
                INSERT INTO `items` (`user_id`, `item_id`, `item_name`) VALUES ('$user_id', 7, 'Platinum');
                INSERT INTO `items` (`user_id`, `item_id`, `item_name`) VALUES ('$user_id', 8, 'Diamond');
                INSERT INTO `items` (`user_id`, `item_id`, `item_name`) VALUES ('$user_id', 9, 'Mercury');
                INSERT INTO `items` (`user_id`, `item_id`, `item_name`) VALUES ('$user_id', 10, 'Urenium');

                INSERT INTO `items` (`user_id`, `item_id`, `item_name`) VALUES ('$user_id' 11, 'Wheat');
                INSERT INTO `items` (`user_id`, `item_id`, `item_name`) VALUES ('$user_id' 12, 'Rice');
                INSERT INTO `items` (`user_id`, `item_id`, `item_name`) VALUES ('$user_id' 13, 'Chiken');
                ";

                // Execute the SQL query to insert the default items
                $result = mysqli_multi_query($conn, $sql);

                // If the items were successfully inserted, display a successmessage
                if($result){
                    $showLoaded = true;
                }
            }
        }
    }

}

// Include the header file
include "./shared/components/head/head.php";
?>
<style>
    .container {
    width: 300px;
    padding: 16px;
    background-color: white;
    margin: 0 auto;
    margin-top: 100px;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
}

.container h1 {
    text-align: center;
    margin-bottom: 20px;
}

.container label {
    display: block;
    margin-bottom: 5px;
}

.container input[type="email"],
.container input[type="password"] {
    width: 100%;
    padding: 10px;
    margin-bottom: 10px;
}

.container input[type="submit"] {
    width: 100%;
    padding: 10px;
    background-color: blue;
    color: white;
    border: none;
}
</style>
</head>
<body>

<?php
include("./shared/components/sidebar/navbar.php");
?>
<body>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="styles.css">
    <title>Registration Form</title>
</head>
<body>
    <div class="container">
    <?php
        if($showAlert){
            echo '<div class="alert alert-success" role="alert">You have successfully registered.</div>';
        }
        if($showError){
            echo '<div class="alert alert-danger" role="alert">Something went wrong.</div>';
        }
        if($showpassWordError){
            echo '<div class="alert alert-danger" role="alert">Passwords do not match.</div>';
        }
        if($emailExists){
            echo '<div class="alert alert-danger" role="alert">Email already exists.</div>';
        }
        if($usernameExists){
            echo '<div class="alert alert-danger" role="alert">Username already exists.</div>';
        }
        if($showLoaded) {
            echo '<div class="alert alert-success" role="alert">Loaded</div>';
        }
        ?>
        <h1>Registration Form</h1>
        <form method="POST" action="register.php">
            <label for="email">Email Address:</label><br>
            <input type="email" id="email" name="email"><br>
            <label for="username">Username:</label><br>
            <input type="text" id="username" name="username"><br>
            <label for="password">Password:</label><br>
            <input type="password" id="password" name="password"><br>
            <label for="confirm-password" >Confirm Password</label><br>
            <input type="password" id="confirm-password" name="confirm-password"><br>
            <input type="submit" value="Submit">
            <a href="login.php">Already have account? Click Here</a>
        </form>
    </div>
</body>
</html>
</body>

