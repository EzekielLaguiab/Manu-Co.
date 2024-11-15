<?php
session_start(); // Start session

include('server/connection.php');


if(isset($_GET['product_id'])){


    $product_id = $_GET['product_id'];

    $result = $conn->prepare("SELECT * FROM products where product_id = ?");
    $result->bind_param("i", $product_id);

    $result->execute();
    $products = $result->get_result();


// no product id
}else {
    header('location: index.php');
}

?>

        <!-- Nav bar -->
        <?php include('header.php') ?>


        <!-- animate to show the content from the bottom -->
         <div style="display: none;" id="myDiv" class="animate-bottom">

        <section class="single-product my-5 pt-5 mx-auto  container">
            <div class="row mt-5 container mx-auto">
                
            <?php while($row = $products->fetch_assoc()) { ?>
                
                <div class="main_image col-lg-4 col-md-4 col-6 ">
                    <img class="mainImg img-fluid w-100 pb-1" src="assets/IMAGES/<?php echo $row['product_image']; ?>"  >
                </div>

                <div class="single col-lg-4 col-md-4 col-6 mb-5">
                    <h3 class="py-2"><?php echo $row['product_name']; ?></h3>
                    <h2>P <?php echo $row['product_price']; ?></h2>

                    <form action="cart.php" method="POST">
                        <input type="hidden" name="product_id" value="<?php echo $row['product_id']; ?>"/>
                        <input type="hidden" name="product_image" value="<?php echo $row['product_image']; ?>"/>
                        <input type="hidden" name="product_name" value="<?php echo $row['product_name']; ?>"/>
                        <input type="hidden" name="product_price" value="<?php echo $row['product_price']; ?>"/>
                        <label for="wrist_size">Wrist size</label>
                        <select id="wrist" class="form-select my-2 w-70" required name="wrist_size">
                            <option value="14cm">14cm</option>
                            <option value="15cm">15cm</option>
                            <option value="16cm">16cm</option>
                            <option value="17cm">17cm</option>
                            <option value="18cm">18cm</option>
                            <option value="19cm">19cm</option>
                        </select>
                        <input type="number" name="product_quantity" min="1" value="1"/>
                        <button class="add-to-cart-btn" type="submit" name="add-to-cart">Add to cart</button>
                    </form> 
                </div>
                <div class="col-lg-4 col-md-12 col-12">
                    <h4 class="text-center">Product details</h4>
                    <span class="product-details mx-auto text-center">
                        <?php echo $row['product_description']; ?>
                    </span>
                </div>


                

                <?php } ?>
            </div>
        </section>

        <!-- Related -->
        <section id="featured" class="my-5 pb-5 container">
       
            <div class="container">
                <div class="container-fluid text-center mt-5 py-5 ">
                    <h3>Related Products</h3>
                    <hr class="mx-auto">
                    <p>You can check out our related products</p>
                </div>

                    <?php
                        include 'server/connection.php';

                        $sql = "SELECT * FROM products WHERE product_id ORDER BY RAND() LIMIT 4";
                        $result = $conn->query(query: $sql);

                    ?>

                        <div class="row d-flex justify-content-center"> 
                            <?php while($row = $result->fetch_assoc()) { ?>
                                <div class="product text-center col-lg-3 col-md-4 col-6 mb-5">
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
            </div>
        </section>
        <!-- footer -->
        <?php include('footer.php'); ?>
