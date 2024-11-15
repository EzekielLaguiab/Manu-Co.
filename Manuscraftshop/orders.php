<?php
session_start();

require 'server/connection.php';

// Ensure the user is logged in
if (!isset($_SESSION['logged_in'])) {
    header('location: login.php');
    exit;
}


// get orders
if(isset($_SESSION['logged_in'])){

    $user_id = $_SESSION['user_id'];

    $result = $conn->prepare("SELECT * FROM orders WHERE user_id = ?");
    $result->bind_param('i', $user_id );
    $result->execute();

    $orders = $result->get_result();
}


?>

<!-- Nav bar -->
<?php require 'header.php'; ?>

 <!-- animate to show the content from the bottom -->
<div style="display: none;" id="myDiv" class="animate-bottom"> 

<!-- orders section -->
<section id="orders" class="orders container my-5 py-5">
    <div class="container mt-3">
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
                        <input type="hidden" value="<?php echo $row['order_status']; ?>" name="order_status">
                        <input type="hidden" value="<?php echo $row['order_id']; ?>" name="order_id">
                        <input class="btn btn-outline-success" type="submit" name="order-info" value="details">
                    </form>
                </td>
            </tr>

        <?php } ?>

    </table>
</section>

<!-- footer -->
<?php require 'footer.php'; ?>
