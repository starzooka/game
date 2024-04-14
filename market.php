<?php

// Start of the PHP code block

// Include the database connection file
include "./shared/database/connect.php";

// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect to the login page
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin']!= true) {
    header("location: register.php");
}

// Include the head component file
include("./shared/components/head/head.php");

?>

<body>
    <?php

    // Include the sidebar navigation bar component file
    include("./shared/components/sidebar/navbar.php");

    // Start of the content div
   ?>

    <div class="content">

    <?php

    // Start of the inventory section
   ?>

    <section id="inventory">

        <?php

        // Display the market page title and description
       ?>

        <h2>Market</h2>
        <p>This page displays the market.</p>

        <?php

        // Initialize the table for displaying market items
       ?>

        <table>

            <?php

            // Initialize the table head
           ?>

            <thead>
                <tr>
                    <th>Item</th>
                    <th>Quantity</th>
                    <th>Price</th>
                </tr>
            </thead>

            <?php

            // Initialize the table body
           ?>

            <tbody>

                <?php

                // Query the market table in the database
                $sql = "SELECT * FROM market";

                // Execute the query
                $result = mysqli_query($conn, $sql);

                // Check if there are any rows returned
                if (mysqli_num_rows($result) > 0) {

                    // Loop through each row
                    while ($row = mysqli_fetch_assoc($result)) {

                        // Check if the item is not sold
                        if ($row['status']!= "sold") {

                            // Display the item details
                            echo '<tr>';
                            echo "<td>". $row['item_name']. "</td>";
                            echo "<td>". $row['quantity']. "</td>";
                            echo '<td>'. $row['price']. '<a type="button" href="./buy_proccess.php?item_name='. $row['item_name']. '&item_id='. $row['item_id']. '&user_id='. $row['user_id']. '&quantity='. $row['quantity']. '" class="btn btn-primary">Buy</a></td>';
                            echo '</tr>';
                        } else {

                            // Display the item details if it is sold
                            echo '<tr>';
                            echo "<td>". $row['item_name']. "</td>";
                            echo "<td>". $row['quantity']. "</td>";
                            echo '<td>'. $row['price']. '<a type="button" class="btn btn-light">Sold</a></td>';
                            echo '</tr>';
                        }
                    }
                }
               ?>

            </tbody>

        </table>

    </section>

    <?php

    // End of the content div
   ?>

    </div>

    <?php

    // Include the footer component file
    include("./shared/components/footer/footer.php");

   ?>
</body>

</html>