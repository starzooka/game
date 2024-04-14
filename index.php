<?php
// including connect.php to connect to the database
include "./shared/database/connect.php";
session_start();

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true){
    header("location: register.php");
}
?>
<?php 
// including head.php
include("./shared/components/head/head.php");
?>
<body>
    
<?php
// including navbar.php
include("./shared/components/sidebar/navbar.php");
?>
    <div class="content">
        <section id="inventory">
            <h2>Inventory</h2>
            <p>This section displays the inventory.</p>
            
            <table>
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Quantity</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Get the user id from the session
                    $user_id = $_SESSION['user_id'];
                    // Create a sql query
                    $sqlQuery = "SELECT * FROM items WHERE user_id=$user_id";
                    // Execute the sql query
                    $result = mysqli_query($conn, $sqlQuery);
                    // Check if there are any rows returned by the sql query
                    if(mysqli_num_rows($result) > 0){
                        while($row = mysqli_fetch_assoc($result)){
                            $i = 0;
                            // Access column values using associative array keys
                            echo '<tr>';
                            echo '<td> '. $row['item_name'] .'</td>';
                            echo '<td> '. $row['quantity'] .' kg</td>';
                            echo "</tr>";
                            // Break the loop after 5 iterations
                            if($i < 5){
                                break;
                            }else{
                                $i = $i + 1;
                            }
                        }
                    }
                    ?>
                </tbody>
            </table>
        </section>
        <!-- <section id="employees">
            <h2>Employees</h2>
            <p>This section displays the list of employees.</p>
            <ul>
                <li>John Doe</li>
                <li>Jane Smith</li>
                <li>Michael Johnson</li>
                
            </ul>
        </section> -->
    </div>
</body>
</html>
