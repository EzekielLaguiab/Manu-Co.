<?php 
session_start();
include '../server/connection.php';

// Define the number of results per page
$results_per_page = 10; 
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; 
$start = ($page - 1) * $results_per_page;

// Fetch users with pagination
$result = $conn->prepare("SELECT * FROM users LIMIT ?, ?");
$result->bind_param('ii', $start, $results_per_page);
$result->execute();
$users = $result->get_result();

// Get the total number of users for pagination
$count_query = $conn->prepare("SELECT COUNT(*) AS total FROM users");
$count_query->execute();
$count_result = $count_query->get_result();
$row = $count_result->fetch_assoc();
$total_users = $row['total'];
$total_pages = ceil($total_users / $results_per_page);
?>

<?php include('header.php') ?>


<section>
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
            <P style="color:green" class="text-center"><?php if(isset($_GET['user_message'])) {echo $_GET['user_message']; }  ?></P>
            <P style="color:green" class="text-center"><?php if(isset($_GET['user_delete'])) {echo $_GET['user_delete']; }  ?></P>
            <P style="color:red" class="text-center"><?php if(isset($_GET['error'])) {echo $_GET['error']; }  ?></P>
                <div class="card">
                    <div class="card-header">
                        <h4>Users account</h4>
                    </div>

                    <div class="card-body">

                        <!-- users Table -->
                         <div class="table-responsive">
                            <table class="table table-sm table-bordered table-hover ">
                                <thead>
                                    <tr width="1%" style="white-space: nowrap">
                                        <th>User Name</th>
                                        <th>User Email</th>
                                        <th>Phone</th>
                                        <th>Address</th>
                                        <th>User Password</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($users as $row ) { ?>
                                    <tr width="1%" style="white-space: nowrap">
                                        
                                        <td><?php echo $row['first_name'];?> <?php echo $row['last_name']; ?></td>
                                        <td><?php echo $row['user_email']; ?></td>
                                        <td><?php echo $row['user_phone']; ?></td>
                                        <td><?php echo $row['user_address']; ?></td>
                                        <td>Confidential</td>

                                        <td width=1% style="white-space: nowrap">

                                                <div class="btn-group">
                                                     <a type="button" class="btn btn-sm btn-outline-success " href="edit_users.php?user_id=<?php echo $row['user_id']; ?>" title="Edit">
                                                        Edit
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                    <a type="button" class="btn btn-sm btn-outline-danger"  title="Delete" 
                                                    onclick="confirmDelete(<?php echo $row['user_id']; ?>)">
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
    function confirmDelete(user_id){
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
                window.location.href = 'delete_users.php?user_id=' + user_id;
            }
        });
    }
</script>

<?php include('footer.php') ?>
