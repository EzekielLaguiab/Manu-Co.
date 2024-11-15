<?php 
session_start();

include '../server/connection.php';


if(isset($_GET['order_id'])){
    
    $order_id = $_GET['order_id'];

    // Prepare and execute the query
    $result = $conn->prepare("SELECT * FROM orders WHERE order_id = ?");
    $result->bind_param('i', $order_id);
    $result->execute();
    $orders = $result->get_result();

    // Check if the order exists
    if($orders->num_rows == 0){
        // If no orders found, redirect
        header('location: orders.php?error=Order not found');
        exit();
    }
}
else if(isset($_POST['update_orders'])){

    $order_status = $_POST['order_status'];
    $order_id = $_POST['order_id'];

    $result = $conn->prepare("UPDATE orders SET order_status = ? WHERE order_id = ?");
    $result->bind_param('si', $order_status, $order_id);

    if($result->execute()){
        header('location: orders.php?order_updated=Order has been updated successfully!');
    }
    else{
        header('location: orders.php?error=Error occurred, try again');
    }

} else {
    header('location: index.php');
    exit();
}

?>
<?php include('header.php') ?>

<section>
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Edit Orders</h4>
                    </div>

                    <div class="card-body">

                        <form action="edit_orders.php" method="post">

                            <?php foreach($orders as $row) { ?>

                                <div class="form-group mb-3">
                                    <b>User ID</b>
                                    <p class="form-control my-2"><?php echo $row['user_id']; ?></p>
                                </div>
                                <div class="form-group mb-3">
                                    <b>User Phone</b>
                                    <p class="form-control my-2"><?php echo $row['user_phone']; ?></p>
                                </div>
                                <div class="form-group mb-3">
                                    <b>Order Cost</b>
                                    <p class="form-control my-2"><?php echo $row['order_cost']; ?></p>

                                    <input type="hidden" name="order_id" value="<?php echo $row['order_id']; ?>">
                                </div>
                                <div class="form-group mb-3">
                                    <b>Order Status</b>
                                    <select class="form-select my-2" required name="order_status">
                                    <option value="not verified" <?php if($row['order_status'] == 'not verified'){echo "selected";} ?> >Not verified</option>
                                        <option value="not paid" <?php if($row['order_status'] == 'not paid'){echo "selected";} ?> >Not Paid</option>
                                        <option value="processing" <?php if($row['order_status'] == 'processing'){echo "selected";} ?> >Processing</option>
                                        <option value="paid" <?php if($row['order_status'] == 'paid'){echo "selected";} ?>>Paid</option>
                                        <option value="shipped" <?php if($row['order_status'] == 'shipped'){echo "selected";} ?>>Shipped</option>
                                        <option value="delivered" <?php if($row['order_status'] == 'delivered'){echo "selected";} ?>>Delivered</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <a href="orders.php" class="btn btn-secondary" name="back" value="Back">Back</a>
                                    <input type="submit" class="btn btn-primary" name="update_orders" value="Update"/>
                                </div>

                            <?php } ?>

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include('footer.php') ?>
