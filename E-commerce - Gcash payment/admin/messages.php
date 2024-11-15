<?php 

session_start();
include '../server/connection.php';

// Define the number of results per page
$results_per_page = 5; 
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; 
$start = ($page - 1) * $results_per_page;

// Fetch messages with pagination
$result = $conn->prepare("SELECT * FROM messages LIMIT ?, ?");
$result->bind_param('ii', $start, $results_per_page);
$result->execute();
$messages = $result->get_result();

// Get the total number of messages for pagination
$count_query = $conn->prepare("SELECT COUNT(*) AS total FROM messages");
$count_query->execute();
$count_result = $count_query->get_result();
$row = $count_result->fetch_assoc();
$total_messages = $row['total'];
$total_pages = ceil($total_messages / $results_per_page);
?>

<?php include('header.php') ?>


<section>
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Messages</h4>
                    </div>

                    <div class="card-body">

                        <!--Messages Table -->
                         <div class="table-responsive ">
                            <table class="table table-sm table-bordered table-hover ">
                                <thead>
                                    <tr width="1%" style="white-space: nowrap">
                                        <!-- <th>User Name</th> -->
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Subject</th>
                                        <th>Messages</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($messages as $row ) { ?>
                                    <tr width="1%" style="white-space: nowrap">
                                        <td><?php echo $row['name'];?> </td>
                                        <td><?php echo $row['email'];?> </td>
                                        <td><?php echo $row['subject'];?> </td>
                                        <td><textarea cols="40" rows="4" readonly><?php echo $row['message'];?></textarea> </td>

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
