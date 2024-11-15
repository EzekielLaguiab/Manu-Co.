
<?php

session_start(); // Start session

include 'server/connection.php';

// Define the number of results per page
$results_per_page = 12; 
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

<!-- Nav bar -->
<?php include('header.php') ?>

 <!-- animate to show the content from the bottom -->
<div style="display: none;" id="myDiv" class="animate-bottom"> 

<style>
    h3{
        color: #2E7D32;
    }
</style>

    <!-- featured -->
<section id="featured" class="my-4 py-5 container-fluid">
        
    <div class="container">

        <div class="mt-4">
            <h3>Products</h3>
            <hr>
            <p>Hot and latest products</p>
        </div>

        <div class="row d-flex justify-content-center"> 
                <?php while($row = $products->fetch_assoc()) { ?>
                    <div class="product text-center col-lg-3 col-md-4 col-6 mb-5 ">
                            <div class="image-container">
                                <img id="image" class="img-fluid  mb-3" src="assets/IMAGES/<?php echo $row ['product_image']; ?>" alt="">
                            </div>
                            <h5 class="p-name"><?php echo $row ['product_name']; ?></h5>
                            <h4 class="p-price">P <?php echo $row ['product_price']; ?></h4>

                            <a href="<?php echo "single_product.php?product_id=" . $row['product_id'];?>">  
                                    <button class="buy-btn">Buy now</button>
                            </a>
                    </div>
                <?php } ?>
            </div>

            <!-- Pagination -->
            <nav>
                <ul class="pagination justify-content-start mx-5">
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
</section>




    <!-- footer -->
    <?php include('footer.php'); ?>
