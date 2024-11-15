
<?php 
session_start(); // Ensure session is started

include '../server/connection.php';


// log out
if (isset($_GET['logout'])){
    // Check if the user is logged in
    if(isset($_SESSION['admin_logged_in'])){
        // Unset session variables for logged-in status
        unset($_SESSION['admin_logged_in']);
        unset($_SESSION['admin_email']);
        unset($_SESSION['admin_password']);
    }
    // Redirect to login page regardless of whether the session was set or not
    
    header('location: admin_login.php');

    exit;
}

// count of products
$sql = "SELECT COUNT(*) as total_products FROM products";
$products = $conn->query($sql);
if (!$products) {
    echo "Error: " . $conn->error;
}

// count of users
$sql = "SELECT COUNT(*) as total_users FROM users";
$users = $conn->query($sql);
if (!$users) {
    echo "Error: " . $conn->error;
}

// count of orders
$sql = "SELECT COUNT(*) as total_orders FROM orders";
$orders = $conn->query($sql);
if (!$orders) {
    echo "Error: " . $conn->error;
}

$sql = "SELECT COUNT(*) as total_messages FROM messages";
$messages = $conn->query($sql);
if (!$messages) {
    echo "Error: " . $conn->error;
}

?>

<?php include('header.php') ?>
    <!-- Dashboard Content -->
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <div class="card text-white bg-primary mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Total Users</h5>
                        <?php while($row = $users->fetch_assoc()) { ?>
                            <p class="card-text"><?php echo $row['total_users']?></p>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-success mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Total Orders</h5>
                        <?php while($row = $orders->fetch_assoc()) { ?>
                            <p class="card-text"><?php echo $row['total_orders']?></p>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-warning mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Total Products</h5>
                        <?php while($row = $products->fetch_assoc()) { ?>
                            <p class="card-text"><?php echo $row['total_products']?></p>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-danger mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Total Messages</h5>
                        <?php while($row = $messages->fetch_assoc()) { ?>
                            <p class="card-text"><?php echo $row['total_messages']?></p>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>


<?php include('footer.php') ?>
