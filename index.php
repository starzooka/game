<?php
include "./shared/database/connect.php";
session_start();

// Check if the user is logged in, if not then redirect him to login page

if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true){
    header("location: register.php");
}

?>

<?php 
include("./shared/components/head/head.php");
?>
<body>
<?php
include("./shared/components/sidebar/navbar.php");
?>

    <div class="content">
        <section id="transactions">
            <h2>Transactions</h2>
            <p>This section displays transactions of the business.</p>
            <!-- You can add transaction data here -->
            <table>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Description</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>2024-04-01</td>
                        <td>Sale of Product A</td>
                        <td>$100.00</td>
                    </tr>
                    <tr>
                        <td>2024-04-02</td>
                        <td>Purchase of Supplies</td>
                        <td>-$50.00</td>
                    </tr>
                    <!-- Add more transactions as needed -->
                </tbody>
            </table>
        </section>

        <section id="inventory">
            <h2>Inventory</h2>
            <p>This section displays the inventory.</p>
            <!-- You can add inventory data here -->
            <table>
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Quantity</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $user_id = $_SESSION['user_id'];
                    $sqlQuery = "SELECT * FROM items WHERE user_id=$user_id";
                    $result = mysqli_query($conn, $sqlQuery);
        
                    if(mysqli_num_rows($result) > 0){
                        while($row = mysqli_fetch_assoc($result)){
                            $i = 0;
                            // Access column values using associative array keys
                            echo '<tr>';
                            echo '<td> '. $row['item_name'] .'</td>';
                            echo '<td> '. $row['quantity'] .' kg</td>';
                            echo "</tr>";
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

        <section id="employees">
            <h2>Employees</h2>
            <p>This section displays the list of employees.</p>
            <!-- You can add employee data here -->
            <ul>
                <li>John Doe</li>
                <li>Jane Smith</li>
                <li>Michael Johnson</li>
    <?php
    include('./shared/database/connect.php');
    
    ?>
                <!-- Add more employee names as needed -->
            </ul>
        </section>
    </div>

    <script src="js/scripts.js"></script>
</body>
</html>
