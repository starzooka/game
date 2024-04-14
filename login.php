<?php
/**
 * Connect to the database using the provided configuration file.
 */
include "./shared/database/connect.php";

/**
 * Initialize variables to track login status and error messages.
 */
$exists = false;
$showAlert = false;
$showError = false;
$showpassWordError = false;

/**
 * Start a new session.
 */
session_start();

/**
 * Redirect the user to the index page if they are already logged in.
 */
if(isset($_SESSION['loggedin']) || $_SESSION['loggedin'] == true){
    header("location: index.php");
}

/**
 * Process the login form submission if the request method is POST.
 */
if($_SERVER["REQUEST_METHOD"] == "POST") {

    /**
     * Retrieve the username and password from the form submission.
     */
    $username = $_POST['username'];
    $password = $_POST['password'];

    /**
     * Query the database for a user with the provided username.
     */
    $sql = "SELECT * FROM user where username='$username'";
    
    /**
     * Execute the database query.
     */
    $result = mysqli_query($conn, $sql);
    
    /**
     * Check if a user with the provided username exists.
     */
    $num = mysqli_num_rows($result);
    if($num == 1){
        /**
         * Loop through the query results and verify the password.
         */
        while($row=mysqli_fetch_assoc($result)){
            if(password_verify($password, $row['password'])){
                $showAlert = true;
                session_start();
                $_SESSION['loggedin'] = true;
                $_SESSION['username'] = $username;
                $_SESSION['user_id'] = $row['user_id'];
            }
        }
        
        /**
         * Redirect the user to the index page.
         */
        header("location: index.php");
        exit;
    }else{
        /**
         * Set the error flag if no user with the provided username exists.
         */
        $showError = true;
    }
}
?>

<?php 
/**
 * Include the head component.
 */
include("./shared/components/head/head.php");
?>

<style>
    /**
     * Style the container element.
     */
   .container {
        width: 300px;
        padding: 16px;
        background-color: white;
        margin: 0 auto;
        margin-top: 100px;
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }

    /**
     * Style the container heading.
     */
   .container h1 {
        text-align: center;
        margin-bottom: 20px;
    }

    /**
     * Style the container labels.
     */
   .container label {
        display: block;
        margin-bottom: 5px;
    }

    /**
     * Style the container input elements.
     */
   .container input[type="email"],
   .container input[type="password"] {
        width: 100%;
        padding: 10px;
        margin-bottom: 10px;
    }

    /**
     * Style the container submit button.
     */
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
/**
 * Include the sidebar navigation component.
 */
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
        /**
         * Display success or error messages based on the login status.
         */
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