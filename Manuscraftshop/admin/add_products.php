<?php 
session_start();
include '../server/connection.php';

if(isset($_POST['add_product'])) {
    // Get form data
    
    $product_image = $_POST['product_image'];
    $product_name = $_POST['product_name'];
    $product_description = $_POST['product_description'];
    $product_price = $_POST['product_price'];

    // Prepare SQL query to get order details
    $result = $conn->prepare("INSERT INTO products (product_name, product_description, product_image, product_price )
                                        VALUES (?, ?, ?, ?)");
    $result->bind_param('ssss', $product_name, $product_description, $product_image, $product_price); 
    $result->execute();
    
    header('location: products.php?product_add=Add product successfully!');

}

?>

<?php include('header.php') ?>

<section>
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Add products</h4>
                    </div>
                    <div class="card-body">
                        <form action="add_products.php" method="post">
                            <div class="form-group mb-3">
                                <label for="product_image">Image Name</label>
                                <input type="text" class="form-control" id="image" name="product_image" placeholder="e.g., name.jpeg" required>
                            </div>

                            <div class="form-group mb-3">
                                <label for="product_name">Product Name</label>
                                <input type="text" class="form-control" id="product_name" name="product_name" >
                            </div>
                            <div class="form-group mb-3">
                                
                                <label for="product_description">Product Description</label>
                                <textarea class="form-control" cols="30" rows="5"  id="product_description" name="product_description" ></textarea>
                                
                            </div>
                            <div class="form-group mb-3">
                                <label for="product_price">Product Price</label>
                                <input type="number" step="0.01" min="0" class="form-control" id="product_price" name="product_price" >
                            </div>
                            <div class="form-group">
                                <a href="products.php" type="button" class="btn btn-secondary" name="back" value="Back">Back</a>
                                <input type="submit" class="btn btn-primary" name="add_product" value="Add product" />
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include('footer.php') ?>
