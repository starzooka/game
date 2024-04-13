<?php



include "./shared/database/connect.php";
$exists = false;
$showAlert = false;
$showError = false;
$showpassWordError = false;
session_start();

if(isset($_SESSION['loggedin']) || $_SESSION['loggedin'] == true){
    header("location: index.php");
}

if($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM user where username='$username'";
    $result = mysqli_query($conn, $sql);
    $num = mysqli_num_rows($result);
    if($num == 1){
        while($row=mysqli_fetch_assoc($result)){
            if(password_verify($password, $row['password'])){
                $showAlert = true;
                session_start();
                $_SESSION['loggedin'] = true;
                $_SESSION['username'] = $username;
                $_SESSION['user_id'] = $row['user_id'];
            }
        }
        

        header("location: index.php");
        exit;
    }else{
        $showError = true;
    }
}
?>
<?php 
include("./shared/components/head/head.php");
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
    <title>Login Form</title>
</head>
<body>
    <div class="container">
    <?php
        if($showAlert){
            echo '<div class="alert alert-success" role="alert">You have successfully Login.</div>';
        }
        if($showError){
            echo '<div class="alert alert-danger" role="alert">Something went wrong.</div>';
        }
        if($showpassWordError){
            echo '<div class="alert alert-danger" role="alert">Invalid credentials.</div>';
        }
        ?>
        <h1>Login Form</h1>
        <form method="POST" action="login.php">
            <label for="username">Username:</label><br>
            <input type="text" id="username" name="username"><br>
            <label for="password">Password:</label><br>
            <input type="password" id="password" name="password"><br>
            <input type="submit" value="Submit">
        </form>
    </div>
</body>
</html>
</body>

