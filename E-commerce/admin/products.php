<?php 
session_start();
include '../server/connection.php';

// Define the number of results per page
$results_per_page = 5; 
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; 
$start = ($page - 1) * $results_per_page;

// Fetch products with pagination
$result = $conn->prepare("SELECT * FROM products LIMIT ?, ?");
$result->bind_param('ii', $start, $results_per_page);
$result->execute();
$products = $result->get_result();

// Get the total number of products for pagination
$count_query = $conn->prepare("SELECT COUNT(*) AS total FROM products");
$count_query->execute();
$count_result = $count_query->get_result();
$row = $count_result->fetch_assoc();
$total_products = $row['total'];
$total_pages = ceil($total_products / $results_per_page);
?>

<?php include('header.php') ?>


<section>
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
            <P style="color:green" class="text-center"><?php if(isset($_GET['product_add'])) {echo $_GET['product_add']; }  ?></P>
            <P style="color:green" class="text-center"><?php if(isset($_GET['product_delete'])) {echo $_GET['product_delete']; }  ?></P>
            <P style="color:red" class="text-center"><?php if(isset($_GET['error'])) {echo $_GET['error']; }  ?></P>
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h4>List of products</h4>
                        <span><a type="button" class="btn btn-primary float-right" href="add_products.php">Add product</a></span>
                        
                    </div>

                    <div class="card-body">

                        <!-- products Table -->
                         <div class="table-responsive">
                            <table class="table table-sm table-bordered table-hover ">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Image</th>
                                        <th >Description</th>
                                        <th>Price</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php foreach($products as $row ) { ?>
                                    <tr >
                                        
                                        <td width=1% style="white-space: nowrap"><?php echo $row['product_name']; ?></td>
                                        <td width=1% style="white-space: nowrap"><img src="<?php echo "../assets/IMAGES/". $row ['product_image']; ?>" style="width: 70px; height: 70px;"></td>
                                        <td width=1% style="white-space: nowrap"><textarea cols="50" rows="4" readonly><?php echo $row['product_description']; ?></textarea></td>
                                        <td width=1% style="white-space: nowrap"><?php echo $row['product_price']; ?></td>

                                        <td width=1% style="white-space: nowrap">
                                                <div class="btn-group">
                                                    <a type="button" class="btn btn-sm btn-outline-success " href="edit_product.php?product_id=<?php echo $row['product_id']; ?>" title="Edit">
                                                    Edit    
                                                    <i class="fa fa-edit"></i>
                                                    </a>
                                                    <a type="button" class="btn btn-sm btn-outline-danger"  title="Delete" 
                                                    onclick="confirmDelete(<?php echo $row['product_id']; ?>)">
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
    function confirmDelete(product_id){
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
                window.location.href = 'delete_products.php?product_id=' + product_id;
            }
        });
    }
</script>

<?php include('footer.php') ?>
