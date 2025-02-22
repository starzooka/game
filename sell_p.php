<?php
// Include the database connection file
include "./shared/database/connect.php";

// Start the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin']!= true) {
    header("location: register.php");
}

// If the request method is GET
if($_SERVER["REQUEST_METHOD"] = "GET"){
    
    // Get the item name and item ID from the GET request
    $item_name = $_GET['item_name'];
    $item_id = $_GET['item_id'];
    
    // Store the item name and item ID in the session
    $_SESSION['sell_item_name'] = $item_name;
    $_SESSION['sell_item_id'] = $item_id;

}
?>

<?php
// Include the head component
include("./shared/components/head/head.php");
?>

<body>
    <?php
    // Include the sidebar and navbar component
    include("./shared/components/sidebar/navbar.php");
   ?>

    <div class="content">
        <section id="inventory">
            <h2>Sell Confirmation</h2>
            <p>Sell your item.</p>
            <form method="GET" action="./sell_proccess.php">
                <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon1">₹</span>
                    <input type="text" name="price" class="form-control" placeholder="Price" aria-label="Username" aria-describedby="basic-addon1">
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon1">₹</span>
                    <input type="text" name="quantity" class="form-control" placeholder="Quantity" aria-label="Username" aria-describedby="basic-addon1">
                </div>
                <button type="submit" class="btn primary" ">List</button>
            </form>
        </section>
    </div>
</body>