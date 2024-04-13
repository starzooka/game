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
            <h2>Market</h2>
            <p>This page displays the market.</p>
            <table>
                <thead>
                    <tr>
                        <th>Item</th>
                        <th>Quantity</th>
                        <th>Price</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <?php
                        $sql = "SELECT * FROM market";
                        $result = mysqli_query($conn, $sql);
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                if($row['status'] != "sold"){
                                    echo '<tr>';
                                    echo "<td>" . $row['item_name'] . "</td>";
                                    echo "<td>" . $row['quantity'] . "</td>";
                                    echo '<td>' . $row['price'] . '<a type="button" href="./buy_proccess.php?item_name='.$row['item_name'].'&item_id='.$row['item_id'].'&user_id='. $row['user_id'].'&quantity='. $row['quantity'].'" class="btn btn-primary">Buy</a></td>';
                                    echo '</tr>';
                                }else{
                                    echo '<tr>';
                                    echo "<td>" . $row['item_name'] . "</td>";
                                    echo "<td>" . $row['quantity'] . "</td>";
                                    echo '<td>' . $row['price'] . '<a type="button" class="btn btn-light">Sold</a></td>';
                                    echo '</tr>';
                                }
                            }
                        }
                        ?>
                    </tr>
                </tbody>
            </table>
    </section>
    </div>