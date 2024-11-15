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

    // Fetch users with pagination
    $result = $conn->prepare("SELECT * FROM orders WHERE user_id = ?");
    $result->bind_param('i', $user_id);
    $result->execute();
    $orders = $result->get_result();

    if($orders->num_rows == 0){
        // If no orders found, redirect
        header('location: acc.php?error=orders not found');
        exit();
    }
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

if(isset($_SESSION['logged_in'])){
    $user_id = $_SESSION['user_id'];

    $result = $conn->prepare("SELECT * FROM users WHERE user_id = ?");
    $result->bind_param('i', $user_id,);
    $result->execute();
    $addresses = $result->get_result();

    if($addresses->num_rows == 0){
        // If no addresses found, redirect
        header('location: acc.php?error=addresses not found');
        exit();
    }
}

?>

<!-- Nav bar -->
<?php require 'header.php'; ?>

<style>
    #acc {
        display: flex;
        background-color: #f9f9f9;
        border-radius: 10px;
        box-shadow: 0 4px 8px var(--main-color);
        padding: 10px;
        flex-wrap: wrap;
    }

    aside {
        
        width: 150px;
        padding: 10px;
        height: auto;
        border-right: 1px solid #2E7D32;
    }

    aside a {
        display: block;
        color: #333;
        text-decoration: none;
        padding: 10px 0;
        cursor: pointer;
    }

    aside a:hover {
        background-color: #4CAF50;
        color: white;
    }

    .content {
        flex: 1;
        padding: 20px;
    }

    .section {
        display: none;
    }

    .section.active {
        display: block;
    }

    /* Responsive styles */
    @media (max-width: 768px) {
        #acc {
            flex-direction: column;
        }

        aside {
            width: 100%;
            border-right: none;
            display: flex;
            justify-content: center;
            gap: 10px;
        }

        aside a {
            width: 100%;
            text-align: center;
            padding: 10px;
            background-color: #f9f9f9;
            border: 1px solid #2E7D32;
            border-radius: 5px;
        }
    }
    #hr{
    width: 100%;
    height: 3px !important;
    opacity: 1 !important;
    background-color:  var(--main-color);

    }
</style>

<?php if (isset($_GET['message']) && $_GET['message'] == 'accountupdate'): ?>
    <script src="assets/sweetalert2@11.js"></script>
    <script>
        Swal.fire({
            
            icon: "success",
            title: "Info Updated!",
            showConfirmButton: false,
            timer: 1500
        });
    </script>
<?php endif; ?>
<?php if (isset($_GET['message']) && $_GET['message'] == 'Password has been updated successfully'): ?>
    <script src="assets/sweetalert2@11.js"></script>
    <script>
        Swal.fire({
            
            icon: "success",
            title: "Password has been updated successfully!",
            showConfirmButton: false,
            timer: 1500
        });
    </script>
<?php endif; ?>

<?php if (isset($_GET['error']) && $_GET['error'] == 'Could not update account information'): ?>
    <script src="assets/sweetalert2@11.js"></script>
    <script>
        Swal.fire({
            
            icon: "error",
            title: "Could not update account information!",
            showConfirmButton: false,
            timer: 1500
        });
    </script>
<?php endif; ?>

<?php if (isset($_GET['error']) && $_GET['error'] == 'Old password is incorrect'): ?>
    <script src="assets/sweetalert2@11.js"></script>
    <script>
        Swal.fire({
            
            icon: "error",
            title: "Old password is incorrect!",
            showConfirmButton: false,
            timer: 1500
        });
    </script>
<?php endif; ?>

<?php if (isset($_GET['error']) && $_GET['error'] == 'New passwords don\'t match, please try again'): ?>
    <script src="assets/sweetalert2@11.js"></script>
    <script>
        Swal.fire({
            
            icon: "error",
            title: "New passwords don't match, please try again!",
            showConfirmButton: false,
            timer: 1500
        });
    </script>
<?php endif; ?>

<?php if (isset($_GET['error']) && $_GET['error'] == 'Password must be at least 6 characters'): ?>
    <script src="assets/sweetalert2@11.js"></script>
    <script>
        Swal.fire({
            
            icon: "error",
            title: "Password must be at least 6 characters!",
            showConfirmButton: false,
            timer: 1500
        });
    </script>
<?php endif; ?>

<?php if (isset($_GET['error']) && $_GET['error'] == 'Could not update password'): ?>
    <script src="assets/sweetalert2@11.js"></script>
    <script>
        Swal.fire({
            
            icon: "error",
            title: "Could not update password!",
            showConfirmButton: false,
            timer: 1500
        });
    </script>
<?php endif; ?>


       <!-- payment message -->
       <?php if (isset($_GET['payment_status']) && $_GET['payment_status'] == 'processing'): ?>
            <script src="assets/sweetalert2@11.js"></script>
            <script>
                Swal.fire({
                    icon: "success",
                    title: "Thanks for shopping with us",
                    text: 'Wait for a moment to verify the transaction',
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

        <?php if (isset($_GET['message']) && $_GET['message'] == 'addressupdate'): ?>
            <script src="assets/sweetalert2@11.js"></script>
            <script>
                Swal.fire({
                    icon: "success",
                    title: "Address updated!",
                    showConfirmButton: false,
                    timer: 1500
                });
            </script>
        <?php endif; ?>




<!-- animate to show the content from the bottom -->
<div style="display: none;" id="myDiv" class="animate-bottom"> 

    <section class="container my-5 py-5">
        <div id="acc" class="container">
            
            <aside>
                <a onclick="showSection('Dashboard')">Dashboard</a>
                <a onclick="showSection('Account')">Account</a>
                <a onclick="showSection('Orders')">Orders</a>
                <a onclick="showSection('Address')">Address</a>
                <a href="acc.php?logout=1" onclick="confirmLogout(event)" id="logout-btn">Logout</a>
            </aside> 

            <div class="content">
                <div id="Dashboard" class="section active">
                    <h2 style="color:green;">Dashboard</h2>
                    <p>Hello <?php if(isset($_SESSION['first_name'])){ echo $_SESSION['first_name']; } ?> <?php if(isset($_SESSION['last_name'])){ echo $_SESSION['last_name']; } ?> (not <?php if(isset($_SESSION['first_name'])){ echo $_SESSION['first_name']; } ?> <?php if(isset($_SESSION['last_name'])){ echo $_SESSION['last_name']; } ?>?
                    <a style="text-decoration: none; color: green;" href="acc.php?logout=1" onclick="confirmLogout(event)" id="logout-btn">Logout)</a>
                    </p>
                    <br>
                    <p>From your account dashboard you can view your recent orders, manage your shipping and billing addresses, and edit your password and account details.
                    </p>    
                </div>
                <div id="Account" class="section">
                    <h2 style="color:green;">Account Details</h2>

                    <form action="update_account.php" method="POST">
                        <?php foreach($addresses as $row) { ?>
                        <div class="account-info">
                            <div class="form-group mt-2">
                                <label for="first_name">First Name <span style="color: red;">*</span></label>
                                <input type="text" name="first_name" class="form-control" value="<?php echo $row['first_name']; ?>" required>
                                
                            </div>
                            
                            <div class="form-group mt-2">
                                <label for="last_name">Last Name <span style="color: red;">*</span></label>
                                <input type="text" name="last_name" class="form-control" value="<?php echo $row['last_name']; ?>" required>
                                
                            </div>
                            <div class="form-group mt-2">
                                <label for="email">Email</label>
                                <input type="email" name="email" class="form-control" readonly value="<?php echo $row['user_email']; ?>" required>
                                
                            </div>

                            <div class="form-group mt-2">
                                <label for="user_phone">Phone <span style="color: red;">*</span></label>
                                <input type="tel" name="user_phone" class="form-control" value="<?php echo $row['user_phone']; ?>" required>
                                
                            </div>
                            <div class="form-group mt-2">
                                <button type="submit" name="updateAccount" class="btn btn-success">Update Info</button>
                            </div>
                        </div>
                        <?php }?>
                    </form>

                    <hr id="hr">
                    <form action="update_account.php" method="POST">
                        
                        <h3 style="color:green;">Password change</h3>
                        
                        <div class="form-group position-relative mt-2">
                            <label for="old_password">Current Password (leave blank to leave unchanged)</label>
                            <input type="password" class="form-control" id="old_password" name="old_password" required>
                            <i id="old-eye-icon" class="fa fa-eye-slash" onclick="togglePassword('old_password', 'old-eye-icon')" style="cursor: pointer; position: absolute; right: 10px; top: 67%; transform: translateY(-50%);"></i>
                        </div>

                        <div class="form-group position-relative mt-2">
                            <label for="password">New Password (leave blank to leave unchanged)</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                            <i id="new-eye-icon" class="fa fa-eye-slash" onclick="togglePassword('password', 'new-eye-icon')" style="cursor: pointer; position: absolute; right: 10px; top: 67%; transform: translateY(-50%);"></i>
                        </div>

                        <!-- Confirm New Password -->
                        <div class="form-group position-relative mt-2">
                            <label for="confirmPassword">Confirm New Password</label>
                            <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" required>
                            <i id="confirm-eye-icon" class="fa fa-eye-slash" onclick="togglePassword('confirmPassword', 'confirm-eye-icon')" style="cursor: pointer; position: absolute; right: 10px; top: 67%; transform: translateY(-50%);"></i>
                        </div>

                        <div class="form-group mt-2">
                            <input  type="submit" class="btn btn-success" name="changePassword" value="Change Password">
                        </div>
                    </form>

                </div>
                <div id="Orders" class="section">
                    <h2 style="color:green;">Orders</h2>
                    <hr>
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered table-hover ">
                            <tr width="1%" style="white-space: nowrap">
                                <th style="display: none;">Order ID</th>
                                <th>Order Cost</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th></th>
                            </tr>

                            <?php foreach($orders as $row)  {?>

                                <tr >
                                    <td style="display: none;">
                                        <span><?php echo $row['order_id'] ?></span>
                                    </td>
                                    <td>
                                        <span>P <?php echo $row['order_cost'] ?></span>
                                    </td>
                                    <td>
                                        <span class="text-uppercase"><?php echo $row['order_status'] ?></span>
                                    </td>
                                    <td>
                                        <span id="orders-date"><?php echo $row['order_date'] ?> </span>
                                    </td>
                                    <td>
                                    <form action="order_details.php" method="POST">
                                            <input type="hidden" value="<?php echo $row['first_name'] . " " . $row['last_name'] ?>" name="name">
                                            <input type="hidden" value="<?php echo $row['email']; ?>" name="email">
                                            <input type="hidden" value="<?php echo $row['province']; ?>" name="province">
                                            <input type="hidden" value="<?php echo $row['city']; ?>" name="city">
                                            <input type="hidden" value="<?php echo $row['barangay']; ?>" name="barangay">
                                            <input type="hidden" value="<?php echo $row['street']; ?>" name="street">
                                            <input type="hidden" value="<?php echo $row['apartment']; ?>" name="apartment">
                                            <input type="hidden" value="<?php echo $row['postcode']; ?>" name="postcode">
                                            <input type="hidden" value="<?php echo $row['user_phone']; ?>" name="user_phone">
                                            <input type="hidden" value="<?php echo $row['order_status']; ?>" name="order_status">
                                            <input type="hidden" value="<?php echo $row['order_id']; ?>" name="order_id">
                                            <button type="submit" name="order-info" class="btn btn-outline-success" title="Info">
                                                Details
                                                <i class="fa fa-info-circle"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>

                            <?php } ?>

                        </table>
                            
                    </div>

                </div>
                <div id="Address" class="section">
                    
                    
                    <div class="row">
                        <div id="one-address" class="col-lg-6 col-md-6 col-12 mb-3">
                            <h2 style="color:green;">Billing Address</h2>
                            <a href="edit_address.php" style="float:right;" class="btn btn-success">
                                Edit
                                <i class="fa fa-edit"></i>
                            </a>
                            <?php foreach($addresses as $row) { ?>
                                    <span><?php echo $row['first_name'] . " " . $row['last_name']; ?></span><br>
                                    <span><?php echo $row['apartment']; ?></span><br>
                                    <span><?php echo $row['street']; ?></span><br>
                                    <span><?php echo $row['barangay']; ?></span><br>
                                    <span><?php echo $row['city']; ?></span><br>
                                    <span><?php echo $row['province']; ?></span><br>
                                    <span><?php echo $row['postcode']; ?></span><br>
                                    <span><?php echo $row['user_phone']; ?></span><br>
                                    <span><?php echo $row['user_email']; ?></span>
                            <?php } ?>
                        </div>
                        <div class="col-lg-6 col-md-6 col-12">
                           
                        </div>
                    </div>
                        
                            
                            
                            
                </div>
            </div>

        </div>

    </section>


<script src="assets/script.js"></script>
<?php require 'footer.php'; ?>
<script src="assets/sweetalert2@11.js"></script>

<script>
    // sweetalert for delete admin
    function confirmLogout(event){
        event.preventDefault();

        Swal.fire({
            title: "Are you sure?",
            text: "You will be logged out!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, log out!"
        }).then((result) => {
            if (result.isConfirmed){
                window.location.href = 'acc.php?logout=1';
            }
        });
    }
</script>



