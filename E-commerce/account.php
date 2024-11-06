<?php
session_start();

require 'server/connection.php';

// Ensure the user is logged in
if (!isset($_SESSION['logged_in'])) {
    header('location: login.php');
    exit;
}

// Handle logout
if (isset($_GET['logout'])){
    if(isset($_SESSION['logged_in'])){
        unset($_SESSION['logged_in']);
        unset($_SESSION['user_email']);
        unset($_SESSION['first_name']);
        unset($_SESSION['last_name']);
        header('location: login.php');
        exit;
    }
}

// get orders
if(isset($_SESSION['logged_in'])){

    $user_id = $_SESSION['user_id'];

    $results_per_page = 5; 
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1; 
    $start = ($page - 1) * $results_per_page;

    // Fetch users with pagination
    $result = $conn->prepare("SELECT * FROM orders WHERE user_id = ? LIMIT ?, ?");
    $result->bind_param('iii', $user_id, $start, $results_per_page);
    $result->execute();
    $orders = $result->get_result();

    // Get the total number of users for pagination
    $count_query = $conn->prepare("SELECT COUNT(*) AS total FROM orders");
    $count_query->execute();
    $count_result = $count_query->get_result();
    $row = $count_result->fetch_assoc();
    $total_orders = $row['total'];
    $total_pages = ceil($total_orders / $results_per_page);

}


// Handle password change
if (isset($_POST['changePassword'])) {

    $password = $_POST['password'];
    $confirmpassword = $_POST['confirmPassword'];
    $user_email = $_SESSION['user_email'];

    // Ensure user email is set
    if (!$user_email) {
        header('location: account.php?error=User not logged in');
        exit();
    }

    // If passwords don't match
    if ($password !== $confirmpassword) {
        header('location: account.php?error=Passwords don\'t match, please try again.');
        exit();

    // Password must be at least 6 characters
    } else if (strlen($password) < 6) {
        header('location: account.php?error=Password must be at least 6 characters.');
        exit();

    // If there is no error
    } else {
        // Hash the password before storing it
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $result = $conn->prepare("UPDATE users SET user_password = ? WHERE user_email = ?");
        $result->bind_param('ss', $hashedPassword, $user_email);

        if ($result->execute()) {
            header('location: account.php?message_update=Password has been updated successfully');
            exit();
        } else {
            header('location: account.php?error=Could not update password.');
            exit();
        }
    }
}
?>

<!-- Nav bar -->
<?php require 'header.php'; ?>

       <!-- payment message -->
       <?php if (isset($_GET['payment_status']) && $_GET['payment_status'] == 'success'): ?>
            <script src="assets/sweetalert2@11.js"></script>
            <script>
                Swal.fire({
                    icon: "success",
                    title: "Paid successfully, thanks for shopping with us",
                    confirmButtonColor: '#28a745'
                });
            </script>
        <?php endif; ?>

        <!-- log in message -->
        <?php if (isset($_GET['message']) && $_GET['message'] == 'success'): ?>
            <script src="assets/sweetalert2@11.js"></script>
            <script>
                Swal.fire({
                    icon: "success",
                    title: "Welcome Shoppers!",
                    showConfirmButton: false,
                    timer: 1500
                });
            </script>
        <?php endif; ?>

        <!-- register success message -->
        <?php if (isset($_GET['msg']) && $_GET['msg'] == 'register'): ?>
            <script src="assets/sweetalert2@11.js"></script>
            <script>
                Swal.fire({
                    icon: "success",
                    title: "Welcome Shoppers!",
                    showConfirmButton: false,
                    timer: 1500
                });
            </script>
        <?php endif; ?>

        <!-- register success message -->
        <?php if (isset($_GET['msg']) && $_GET['msg'] == 'register'): ?>
            <script src="assets/sweetalert2@11.js"></script>
            <script>
                Swal.fire({
                    icon: "success",
                    title: "Welcome Shoppers!",
                    showConfirmButton: false,
                    timer: 1500
                });
            </script>
        <?php endif; ?>

        <?php if (isset($_GET['message']) && $_GET['message'] == 'Email already verified'): ?>
            <script src="assets/sweetalert2@11.js"></script>
            <script>
                Swal.fire({
                    icon: "info",
                    title: "Email already verified!",
                    showConfirmButton: false,
                    timer: 2000
                });
            </script>
        <?php endif; ?>


 <!-- animate to show the content from the bottom -->
<div style="display: none;" id="myDiv" class="animate-bottom"> 

<!-- account info -->
<section class="my-5 py-5">
    <div class="row container mx-auto">
        <div class="col-lg-6 col-md-12 col-12">
            
            
            <h2 class="font-weight-bold">Account info</h2>
            <hr class="">
            <div class="account-info">
                <p>Name: <span><?php if(isset($_SESSION['first_name'])){ echo $_SESSION['first_name']; } ?> <?php if(isset($_SESSION['last_name'])){ echo $_SESSION['last_name']; } ?></span></p>
                <p>Email: <span><?php if(isset($_SESSION['user_email'])){ echo $_SESSION['user_email']; } ?></span></p>
                <p>Phone: <span><?php if(isset($_SESSION['user_phone'])){ echo $_SESSION['user_phone']; } ?></span></p>
                <p>Address: <span><?php if(isset($_SESSION['user_address'])){ echo $_SESSION['user_address']; } ?></span></p>
                 
                <p><a href="update_account.php" id="order-btn">Setings</a></p>
                <p><a href="account.php?logout=1" id="logout-btn">Logout</a></p>
            </div>
        </div>

        <div class="col-lg-6 col-md-12 col-12">
            <section id="orders" class="orders container ">
                <div class="container">
                    <h2 class="font-weight-bold text-center">Your Orders</h2>
                    <hr class="mx-auto">
                </div>
                
                <table class="mt-3 pt-5">
                    <tr>
                        <th style="display: none;">Order ID</th>
                        <th>Order Cost</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Order info</th>
                    </tr>

                    <?php while($row = $orders->fetch_assoc())  {?>

                        <tr>
                            <td style="display: none;">
                                <span><?php echo $row['order_id'] ?></span>
                            </td>
                            <td>
                                <span>$ <?php echo $row['order_cost'] ?></span>
                            </td>
                            <td>
                                <span class="text-uppercase"><?php echo $row['order_status'] ?></span>
                            </td>
                            <td>
                                <span id="orders-date"><?php echo $row['order_date'] ?> </span>
                            </td>
                            <td>
                            <form action="order_details.php" method="POST">
                                    <input type="hidden" value="<?php echo $row['order_status']; ?>" name="order_status">
                                    <input type="hidden" value="<?php echo $row['order_id']; ?>" name="order_id">
                                    <input id="buttons" class="btn btn-outline-success" type="submit" name="order-info" value="details">
                                </form>
                            </td>
                        </tr>

                    <?php } ?>

                </table>
                
                    <!-- Pagination -->
                    <nav>
                        <ul class="pagination justify-content-end mx-5">
                            <?php if ($page > 1): ?>
                                <li class="page-item"><a class="page-link" href="?page=<?php echo $page - 1; ?>">Previous</a></li>
                            <?php endif; ?>

                            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                                <li class="page-item <?php if ($i == $page) echo 'active'; ?>"><a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                            <?php endfor; ?>

                            <?php if ($page < $total_pages): ?>
                                <li class="page-item"><a class="page-link" href="?page=<?php echo $page + 1; ?>">Next</a></li>
                            <?php endif; ?>
                        </ul>
                    </nav>
                    
            </section>
        </div>
    </div>
</section>

<!-- footer -->
<?php require 'footer.php'; ?>
