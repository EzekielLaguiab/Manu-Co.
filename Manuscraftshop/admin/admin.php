<?php 
session_start();
include '../server/connection.php';

// Define the number of results per page
$results_per_page = 5; 
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; 
$start = ($page - 1) * $results_per_page;

// Fetch admins with pagination
$result = $conn->prepare("SELECT * FROM admins LIMIT ?, ?");
$result->bind_param('ii', $start, $results_per_page);
$result->execute();
$admins = $result->get_result();

// Get the total number of admins for pagination
$count_query = $conn->prepare("SELECT COUNT(*) AS total FROM admins");
$count_query->execute();
$count_result = $count_query->get_result();
$row = $count_result->fetch_assoc();
$total_admins = $row['total'];
$total_pages = ceil($total_admins / $results_per_page);



?>

<?php include('header.php') ?>

<section>
    <div class="container">
        <div class="row">
            <div class="col-sm-12">

            <P style="color:green" class="text-center"><?php if(isset($_GET['admin_edit'])) {echo $_GET['admin_edit']; }  ?></P>
            <P style="color:red" class="text-center"><?php if(isset($_GET['error'])) {echo $_GET['error']; }  ?></P>
                <div class="card">
                    <div class="card-header">
                        <h4> Admins account</h4>
                    </div>

                    <div class="card-body">

                        <!-- admins Table -->
                         <div class="table-responsive">
                            <table class="table table-sm table-bordered table-hover ">
                                <thead>
                                    <tr width="1%" style="white-space: nowrap">
                                        <th>Admin Name</th>
                                        <th>Admin Password</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($admins as $row ) { ?>
                                    <tr width="1%" style="white-space: nowrap">
                                        
                                        <td><?php echo $row['admin_name']; ?></td>
                                        <td>Confidential</td>

                                        <td width=1% style="white-space: nowrap">

                                                <div class="btn-group">
                                                   <a type="button" class="btn btn-sm btn-outline-success " href="edit_admin.php?admin_id=<?php echo $row['admin_id']; ?>" title="Edit">
                                                        Edit
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                    <a type="button" class="btn btn-sm btn-outline-danger"  title="Delete" 
                                                    onclick="confirmDelete(<?php echo $row['admin_id']; ?>)">
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
    function confirmDelete(admin_id) {
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (result.isConfirmed) {
                // Pass the correct admin_id in the URL
                window.location.href = 'delete_admin.php?admin_id=' + admin_id;
            }
        });
    }
</script>


<?php include('footer.php') ?>
