<?php 
session_start(); // Start session

include('server/connection.php');

// Check if form was submitted and order_id was provided
if (isset($_POST['order-info']) && isset($_POST['order_id']) && isset($_POST['order_status'])) {

    $order_id = $_POST['order_id'];
    $order_status = $_POST['order_status'];

    // Prepare SQL query to get order details
    $result = $conn->prepare("SELECT * FROM order_items WHERE order_id = ?");
    $result->bind_param('i', $order_id);
    $result->execute();
    $order_details = $result->get_result(); // Get result set

    calculateTotalOrder($order_details);

} else {
    header('location: account.php');
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

<!-- Nav bar/ header-->
<?php include('header.php') ?>

<!-- animate to show the content from the bottom -->
<div style="display: none;" id="myDiv" class="animate-bottom">

<!-- orders details -->
<section id="orders" class="orders container my-5 py-3">
    <div class="container mt-5">
        <h2 class="font-weight-bold text-center">Order details</h2>
        <hr class="mx-auto">
    </div>

    <table class="mt-5 pt-5">
        <tr>
            <th>Product</th>
            <th class="text-center">Price</th>
            <th class="text-center">Wrist size</th>
            <th class="text-center">Quantity</th>
        </tr>

        <?php foreach($order_details as $row) { ?>
            <tr>
                <td>
                    <div class="order-info">
                        <img src="assets/IMAGES/<?php echo $row['product_image']; ?>" >
                        <div>
                            <p class="mt-4"><?php echo $row['product_name']; ?></p>
                        </div>
                    </div>
                </td>
                <td class="text-center">
                    <span>P <?php echo $row['product_price']; ?></span>
                </td>
                <td class="text-center">
                    <span><?php echo $row['wrist_size']; ?></span>
                </td>
                <td class="text-center">
                    <span><?php echo $row['product_quantity']; ?></span>
                </td>
            </tr>
        <?php } ?>

    </table>

    <a href="account.php" style="float: right; padding-left: 5px;">
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
</section>

<!-- footer -->
<?php include('footer.php'); ?>
