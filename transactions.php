<?php
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
            <p>This page displays transactions of the business.</p>
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
                        <td>$250.00</td>
                    </tr>
                    <tr>
                        <td>2024-04-02</td>
                        <td>Purchase of Raw Materials</td>
                        <td>-$150.00</td>
                    </tr>
                    <tr>
                        <td>2024-04-03</td>
                        <td>Payment for Utilities</td>
                        <td>-$80.00</td>
                    </tr>
                    <tr>
                        <td>2024-04-04</td>
                        <td>Sale of Services</td>
                        <td>$500.00</td>
                    </tr>
                    <tr>
                        <td>2024-04-05</td>
                        <td>Vendor Payment</td>
                        <td>-$200.00</td>
                    </tr>
                    <!-- Add more transactions as needed -->
                </tbody>
            </table>
        </section>
    </div>

</body>
</html>
