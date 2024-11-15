<?php 

session_start();
include '../server/connection.php';

if(isset($_GET['product_id'])){
    $product_id = $_GET['product_id'];

    // Fetch product details
    $result = $conn->prepare("SELECT * FROM products WHERE product_id = ?");
    $result->bind_param('i', $product_id);
    $result->execute();
    $products = $result->get_result();
}
else{
    header('Location: products.php');
    exit();
}

if(isset($_POST['update'])){
    $product_name = $_POST['product_name'];
    $product_description = $_POST['product_description'];
    $product_image = $_POST['product_image']; // Image name as text
    $product_price = $_POST['product_price'];

    // Update the product with the provided image name, not file upload
    $result = $conn->prepare("UPDATE products SET product_name = ?, product_description = ?, product_image = ?, product_price = ? WHERE product_id = ?");
    $result->bind_param('ssssi', $product_name, $product_description, $product_image, $product_price, $product_id);

    if($result->execute()){
        header('Location: products.php?message=Product successfully updated!');
        exit();
    } else {
        header('Location: edit_product.php?error=Failed to update product!' . $product_id);
        exit();
    }
}
?>

<?php include('header.php') ?>

<section>
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Edit Product</h4>
                    </div>
                    <div class="card-body">
                        <form action="edit_product.php?product_id=<?php echo $product_id; ?>" method="post">
                            <?php foreach($products as $row ) { ?>
                                <div class="form-group mb-3">
                                    <label for="product_image">Product Image</label>
                                    <input type="hidden" name="product_id" value="<?php echo $row['product_id']; ?>">
                                    <input type="text" class="form-control" id="product_image" value="<?php echo $row['product_image']; ?>" name="product_image" required>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="product_name">Product Name</label>
                                    <input type="text" class="form-control" id="product_name" value="<?php echo $row['product_name']; ?>" name="product_name" >
                                </div>

                                <div class="form-group mb-3">                                
                                    <label for="product_description">Product Description</label>
                                    <textarea class="form-control" cols="30" rows="5"  id="product_description" name="product_description" ><?php echo $row['product_description']; ?></textarea>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="product_price">Product Price</label>
                                    <input type="number" step="0.01" min="0" class="form-control" id="product_price" value="<?php echo $row['product_price']; ?>" name="product_price" >
                                </div>

                                <div class="form-group">
                                    <a href="products.php" class="btn btn-secondary">Back</a>
                                    <input type="submit" class="btn btn-primary" name="update" value="Update">
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
