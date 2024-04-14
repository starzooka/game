<div class="sidebar">
        <h2>Admin Dashboard</h2>
        <?php
        // Session initialization and login state check
        if(!isset($_SESSION)) {
            session_start();
            $_SESSION['loggedin'] = null;
        }
        if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] ==  true){
            echo '<a type="button" href="/game/logout.php" class="btn btn-light">Logout</a>';
        }else{
            echo '<a type="button" href="/game/register.php" class="btn btn-light">Register</a> 
                <a type="button" href="/game/login.php" class="btn btn-light">Login</a>';
        }
        ?>
        <ul>
            
            <li><a href="index.php"><i class="fas fa-home"></i> Dashboard</a></li>
            <li><a href="inventory.php"><i class="fas fa-boxes"></i> Inventory</a></li>
            <li><a href="employees.php"><i class="fas fa-users"></i> Employees</a></li>
            <li><a href="market.php"><i class="fas fa-users"></i> market</a></li>

        </ul>
    </div>