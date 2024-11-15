<?php 
session_start(); // Start session

include('server/connection.php');

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


// Check if form was submitted and order_id was provided
if (isset($_POST['order-info']) && isset($_POST['order_id']) && isset($_POST['order_status'])) {
    
    $user_phone = $_POST['user_phone'];
    $email = $_POST['email'];
    $province = $_POST['province'];
    $city = $_POST['city'];
    $barangay = $_POST['barangay'];
    $street = $_POST['street'];
    $apartment = $_POST['apartment'];
    $postcode = $_POST['postcode'];
    $name = $_POST['name'];
    $order_id = $_POST['order_id'];
    $order_status = $_POST['order_status'];

    // Prepare SQL query to get order details
    $result = $conn->prepare("SELECT * FROM order_items WHERE order_id = ?");
    $result->bind_param('i', $order_id);
    $result->execute();
    $order_details = $result->get_result(); // Get result set

    calculateTotalOrder($order_details);

} else {
    header('location: acc.php');
    exit;
}

// Function to calculate total order amount
function calculateTotalOrder($order_details) {
    $total = 0;

    // Iterate through result set using fetch_assoc()
    foreach($order_details as $row) { 
        $product_price = $row['product_price'];
        $product_quantity = $row['product_quantity'];
        $total += ($product_price * $product_quantity); // Calculate total price
    }

    // Store the total in session
    $_SESSION['order_total'] = $total;
}
?>

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
</style>

<!-- Nav bar/ header-->
<?php include('header.php') ?>

<!-- animate to show the content from the bottom -->
<div style="display: none;" id="myDiv" class="animate-bottom">

<!-- orders details -->
<section id="orders" class="container my-5 py-5">


    <div id="acc" class="container">
    <aside>
        <a href="acc.php?param=value#Dashboard">Dashboard</a>
        <a href="acc.php?param=value#Account">Account</a>
        <a href="acc.php?param=value#Orders">Orders</a>
        <a href="acc.php?param=value#Address">Address</a>
        <a href="acc.php?logout=1" onclick="confirmLogout(event)" id="logout-btn">Logout</a>
    </aside> 

    <div class="content">

        <h2 style="color: green;">Order details</h2>
        <hr>

        <div class="table-responsive">
            <table class="table">
                <tr>
                    <th>Product</th>
                    <th class="text-center">Price</th>
                </tr>

                <?php foreach($order_details as $row) { ?>
                    <tr>
                        <td>
                            <div class="order-info">
                                <img style="width: 70px; height: 70px;" src="assets/IMAGES/<?php echo $row['product_image']; ?>" >
                                
                            </div>
                            <br>
                            <b style="color: green;"><?php echo $row['product_name']; ?> x <?php echo $row['product_quantity']; ?></b>
                            <br>
                            <span ><?php echo $row['wrist_size']; ?></span>
                        </td>
                        
                        <td class="text-center">
                            <span>P <?php echo $row['product_price']; ?></span>
                        </td>
                        
                    </tr>
                <?php } ?>
            </table>
        </div>

        <div class="container mb-3">
            <h2>Shipping Address</h2>
            <span><?php echo $name; ?></span><br>
            <span><?php echo $apartment; ?></span><br>
            <span><?php echo $street; ?></span><br>
            <span><?php echo $barangay; ?></span><br>
            <span><?php echo $city; ?></span><br>
            <span><?php echo $province; ?></span><br>
            <span><?php echo $postcode; ?></span><br>
            <span><?php echo $user_phone; ?></span><br>
            <span><?php echo $email; ?></span>
            
        </div>

        

        <a href="acc.php?param=value#Orders" style="float: right; padding-left: 5px;">
            <input class="btn btn-secondary" value="back" type="submit" >
        </a>  

        <?php if ($order_status == "not paid") { ?>
            <form style="float: right" action="payment.php" method="POST">
                <input type="hidden" name="order_id" value="<?php echo $order_id; ?>">
                <input type="hidden" name="order_total" value="<?php echo $_SESSION['order_total']; ?>">
                <input type="hidden" name="order_status" value="<?php echo $order_status; ?>">
                <input id="buttons" class="btn btn-primary" type="submit" name="order_pay" value="Pay Now">
            </form>
        <?php } ?>

    </div>
</div>


</section>

<!-- footer -->
<?php include('footer.php'); ?>

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

