<?php

include "./shared/database/connect.php";
session_start();

// Check if the user is logged in, if not then redirect him to login page

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
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
        <section id="inventory">
            <h2>Inventory</h2>
            <p>This page displays the inventory.</p>

            <table>
                <thead>
                    <tr>
                        <th>Item</th>
                        <th>Quantity</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // take user_id from session storage
                    $user_id = $_SESSION['user_id'];
                    // query database
                    $sqlQuery = "SELECT * FROM items WHERE user_id=$user_id";
                    // execute query
                    $result = mysqli_query($conn, $sqlQuery);
                    // check if query was successful
                    if (mysqli_num_rows($result) > 0) {
                        // output data of each row
                        while ($row = mysqli_fetch_assoc($result)) {
                            // Access column values using associative array keys
                            $i = 0;
                            echo '<tr>';
                            echo '<td> ' . $row['item_name'] . '</td>';
                            echo '<td> ' . $row['quantity'] . ' kg <a type="button" href="/game/sell_p.php?item_name='. $row['item_name'].'&item_id='. $row['item_id'] .'" class="btn btn-primary">Sell</a> <a type="button" class="btn btn-primary">Buy</a></td>';
                            echo "</tr>";
                            
                        }
                    }


                    ?>
                </tbody>
            </table>
        </section>
    </div>

</body>

</html>