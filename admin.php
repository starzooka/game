<?php
session_start();
include "./shared/database/connect.php";

if((!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) || !isset($_SESSION['username'])){
    header("location: register.php");
   
    
    
}else{
    $username = $_SESSION['username'];
    
    $sqlQuery = "SELECT * FROM `user` where `username` = '$username'";
    $resultForUsername = mysqli_query($conn, $sqlQuery);
    $row = mysqli_fetch_assoc($resultForUsername);
    $admin_user_id = $row['user_id'];
    $is_admin = $row['is_admin'];
    // echo $is_admin;

    if($is_admin != 1){
        header("location: index.php");
    }
    if($_SERVER['REQUEST_METHOD'] == "POST"){
        $toDeleteUserId = $_POST['delete_id'];
        // $toDeleteUserName = $_POST[''];
        $multiLineSQLQuery = "
        DELETE FROM `market` WHERE `user_id` = '$toDeleteUserId';
        DELETE FROM `items` WHERE `user_id` = '$toDeleteUserId';
        DELETE FROM `user` WHERE `user_id` = '$toDeleteUserId';
        ";
        $result = mysqli_multi_query($conn, $multiLineSQLQuery);
        if($result){
            echo "deleted";
            mysqli_close($conn);
            exit;
        }else{
            echo "not deleted";
        }
    }
}
?>
<body>
    <form action="./admin.php" method="POST">
        <input type="text" placeholder="Enter username to delete" autocomplete="organization" name="delete_id" list="user_id"/>
        <datalist id="user_id">
            <?php
            $sqlQuery = "SELECT * FROM `user`";
            $resultForUsername = mysqli_query($conn, $sqlQuery);
            while($row = mysqli_fetch_assoc($resultForUsername))
        echo '<option value="' . $row['user_id'] . '"> '. $row['user_id'] .'</option>';
            ?>
        </datalist>
        <input type="submit" value="delete the user" name="delete" />
    </form>
</body>