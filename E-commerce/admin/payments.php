<?php 

session_start();
include '../server/connection.php';

// Define the number of results per page
$results_per_page = 5; 
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; 
$start = ($page - 1) * $results_per_page;

// Fetch payments with pagination
$result = $conn->prepare("SELECT * FROM payments LIMIT ?, ?");
$result->bind_param('ii', $start, $results_per_page);
$result->execute();
$payments = $result->get_result();

// Get the total number of payments for pagination
$count_query = $conn->prepare("SELECT COUNT(*) AS total FROM payments");
$count_query->execute();
$count_result = $count_query->get_result();
$row = $count_result->fetch_assoc();
$total_payment = $row['total'];
$total_pages = ceil($total_payment / $results_per_page);
?>

<?php include('header.php') ?>


<section>
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h4> Payments</h4>
                    </div>

                    <div class="card-body">

                        <!-- payments Table -->
                         <div class="table-responsive ">
                            <table class="table table-sm table-bordered table-hover ">
                                <thead>
                                    <tr>
                                        <!-- <th>User Name</th> -->
                                        <th>Payment ID</th>
                                        <th>User ID</th>
                                        <th>Transaction ID</th>
                                        <th>Payment Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($payments as $row ) { ?>
                                    <tr>
                                        <!-- <td><?php echo $row['first_name'];?> <?php echo $row['last_name']; ?></td> -->
                                        <td><?php echo $row['payment_id']; ?></td>
                                        <td><?php echo $row['user_id']; ?></td>
                                        <td><?php echo $row['transaction_id']; ?></td>
                                        <td><?php echo $row['payment_date']; ?></td>

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

<?php include('footer.php') ?>
