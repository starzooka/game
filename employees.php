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
        <section id="employees">
            <h2>Employees</h2>
            <p>This page displays the list of employees in a table.</p>
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Position</th>
                        <th>Department</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>John Doe</td>
                        <td>Manager</td>
                        <td>Sales</td>
                    </tr>
                    <tr>
                        <td>Jane Smith</td>
                        <td>Accountant</td>
                        <td>Finance</td>
                    </tr>
                    <tr>
                        <td>Michael Johnson</td>
                        <td>Developer</td>
                        <td>IT</td>
                    </tr>
                    <tr>
                        <td>Emily Wang</td>
                        <td>HR Specialist</td>
                        <td>Human Resources</td>
                    </tr>
                    <tr>
                        <td>David Lee</td>
                        <td>Customer Service Representative</td>
                        <td>Customer Service</td>
                    </tr>
                    <!-- Add more employees as needed -->
                </tbody>
            </table>
        </section>
    </div>

    <script src="js/scripts.js"></script>
</body>
</html>
