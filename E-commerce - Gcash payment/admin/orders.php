<?php 
session_start();
include '../server/connection.php';

// Define the number of results per page
$results_per_page = 10; 
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; 
$start = ($page - 1) * $results_per_page;

// Fetch orders with pagination
$result = $conn->prepare("SELECT * FROM orders JOIN users ON orders.user_id = users.user_id  LIMIT ?, ?");
$result->bind_param('ii', $start, $results_per_page);
$result->execute();
$orders = $result->get_result();

// Get the total number of orders for pagination
$count_query = $conn->prepare("SELECT COUNT(*) AS total FROM orders");
$count_query->execute();
$count_result = $count_query->get_result();
$row = $count_result->fetch_assoc();
$total_orders = $row['total'];
$total_pages = ceil($total_orders / $results_per_page);

// Update order status after form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['order_id'])) {
    $order_id = $_POST['order_id'];
    $order_status = $_POST['order_status'];

    $update_query = $conn->prepare("UPDATE orders SET order_status = ? WHERE order_id = ?");
    $update_query->bind_param('si', $order_status, $order_id);
    $update_query->execute();
    
    header("Location: orders.php?order_updated=Order status updated successfully");
    exit();
}

?>

<?php include('header.php') ?>

<section>
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <P style="color:green" class="text-center"><?php if(isset($_GET['order_updated'])) {echo $_GET['order_updated']; }  ?></P>
                <P style="color:green" class="text-center"><?php if(isset($_GET['order_delete'])) {echo $_GET['order_delete']; }  ?></P>
                <P style="color:red" class="text-center"><?php if(isset($_GET['error'])) {echo $_GET['error']; }  ?></P>
                <div class="card">
                    <div class="card-header">
                        <h4> Orders</h4>
                    </div>

                    <div class="card-body">

                        <!-- Orders Table -->
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered table-hover ">
                                <thead>
                                    <tr width="1%" style="white-space: nowrap">
                                        <th class="d-none">User ID</th>
                                        <th>User Name</th>
                                        <th>User Phone</th>
                                        <th>User Address</th>
                                        <th>Order Cost</th>
                                        <th>Order Date</th>
                                        <th>Order Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($orders as $row ) { ?>
                                    <tr width="1%" style="white-space: nowrap">
                                        <td class="d-none"><?php echo $row['user_id']; ?></td>
                                        <td><?php echo $row['first_name'];?> <?php echo $row['last_name']; ?></td>
                                        <td><?php echo $row['user_phone']; ?></td>
                                        <td><?php echo $row['user_address']; ?></td>
                                        <td><?php echo $row['order_cost']; ?></td>
                                        <td><?php echo $row['order_date']; ?></td>
                                        <td>
                                            <!-- Editable Order Status -->
                                            <form method="POST" action="">
                                                <input type="hidden" name="order_id" value="<?php echo $row['order_id']; ?>">
                                                <div class="form-group mb-3" >
                                                    <select class="form-select my-2" required name="order_status">
                                                        <option value="not verified" <?php if($row['order_status'] == 'not verified'){echo "selected";} ?>>Not verified</option>
                                                        <option value="not paid" <?php if($row['order_status'] == 'not paid'){echo "selected";} ?>>Not Paid</option>
                                                        <option value="processing" <?php if($row['order_status'] == 'processing'){echo "selected";} ?>>Processing</option>
                                                        <option value="paid" <?php if($row['order_status'] == 'paid'){echo "selected";} ?>>Paid</option>
                                                        <option value="shipped" <?php if($row['order_status'] == 'shipped'){echo "selected";} ?>>Shipped</option>
                                                        <option value="delivered" <?php if($row['order_status'] == 'delivered'){echo "selected";} ?>>Delivered</option>
                                                    </select>
                                                </div>
                                                <button type="submit" class="btn btn-sm btn-outline-primary" title="Save">Save</button>
                                            </form>
                                        </td>

                                        <td width=1% style="white-space: nowrap">
                                            <div class="btn-group">
                                                <a type="button" class="btn btn-sm btn-outline-danger"  title="Delete" 
                                                onclick="confirmDelete(<?php echo $row['order_id']; ?>)">
                                                Delete
                                                <i class="fa fa-trash-alt"></i>
                                                </a>
                                            </div>
                                        </td>  
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>

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

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    // sweetalert for delete admin
    function confirmDelete(order_id){
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (result.isConfirmed){
                window.location.href = 'delete_orders.php?order_id=' + order_id;
            }
        });
    }
</script>

<?php include('footer.php') ?>
