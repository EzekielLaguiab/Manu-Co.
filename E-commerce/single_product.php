<?php

include('assets/server/connection.php');

if(isset($_GET['product_id'])){


    $product_id = $_GET['product_id'];

    $stmt = $conn->prepare("SELECT * FROM products where product_id = ?");
    $stmt->bind_param("i", $product_id);

    $stmt->execute();
    $products = $stmt->get_result();


// no product id
}else {
    header('location: index.php');
}

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Commerce</title>
    <!-- main css -->
    <link rel="stylesheet" href="assets/style.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous"/>
    <!-- Bootsrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

</head>
<body>
        <!-- Nav bar -->
        <?php include('header.php') ?>

        <section class="single-product my-5 pt-3 container">
            <div class="row mt-5 container mx-auto">

            <?php while($row = $products->fetch_assoc()) { ?>
                <div class="col-lg-4 col-md-6 col-6 ">
                    <img class="mainImg img-fluid w-100 pb-1" src="assets/IMAGES/<?php echo $row['product_image']; ?>"  >
                    <div class="small-img-group">

                        <!-- different variant -->
                        <div class="small-img-col">
                            <img src="assets/IMAGES/<?php echo $row['product_image']; ?>" width="100%" class="small-image" >
                        </div>
                        <div class="small-img-col">
                            <img src="assets/IMAGES/<?php echo $row['product_image2']; ?>" width="100%" class="small-image" >
                        </div>
                        <div class="small-img-col">
                            <img src="assets/IMAGES/<?php echo $row['product_image3']; ?>" width="100%" class="small-image" >
                        </div>
                        <div class="small-img-col">
                            <img src="assets/IMAGES/<?php echo $row['product_image4']; ?>" width="100%" class="small-image" >
                        </div>
                    </div>
                </div>


                <div class="single col-lg-6 col-md-6 col-6">
                    <h3 class="py-2"><?php echo $row['product_name']; ?></h3>
                    <h2>P<?php echo $row['product_price']; ?></h2>
                    <input type="number" value="1">
                    <button class="add-to-cart-btn">Add to cart</button>
                    <h4 class="mt-3 mb-3">Product details</h4>
                    <span class="prodct-details"><?php echo $row['product_description']; ?>
                    </span>
                </div>
                
                <?php } ?>
            </div>
        </section>

        <!-- Related -->
        <section id="featured" class="my-5 pb-5 container">
        <div class="container text-center mt-5 py-5 ">
            <h3>Related products</h3>
            <hr class="mx-auto">
            <p>You can check out our related products</p>
        </div>

        <div class="row mx-auto container-fluid">
            <div  class="product text-center col-lg-3 col-md-4 col-6">
            <div class="image-container">
                <img onclick="window.location.href='#'" class="img-fluid mb-3" src="assets/imgs/brand/brand3.png" alt="">
                <button class="buy-btn">Buy now</button>
            </div>
            <div class="star">
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
            </div>
            <h5 class="p-name">Stones</h5>
            <h4 class="p-price">$13.99</h4>
        </div>
        
        <div  class="product text-center col-lg-3 col-md-4 col-6">
            <div class="image-container">
                <img onclick="window.location.href='#'" class="img-fluid mb-3" src="assets/imgs/brand/brand3.png" alt="">
                <button class="buy-btn">Buy now</button>
            </div>
            <div class="star">
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
            </div>
            <h5 class="p-name">Stones</h5>
            <h4 class="p-price">$13.99</h4>
        </div>

        <div  class="product text-center col-lg-3 col-md-4 col-6">
            <div class="image-container">
                <img onclick="window.location.href='#'" class="img-fluid mb-3" src="assets/imgs/brand/brand3.png" alt="">
                <button class="buy-btn">Buy now</button>
            </div>
            <div class="star">
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
            </div>
            <h5 class="p-name">Stones</h5>
            <h4 class="p-price">$13.99</h4>
        </div>

        <div  class="product text-center col-lg-3 col-md-4 col-6">
            <div class="image-container">
                <img onclick="window.location.href='#'" class="img-fluid mb-3" src="assets/imgs/brand/brand3.png" alt="">
                <button class="buy-btn">Buy now</button>
            </div>
            <div class="star">
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
            </div>
            <h5 class="p-name">Stones</h5>
            <h4 class="p-price">$13.99</h4>
        </div>
        </div>
        </section>

        <!-- footer -->
        <?php include('footer.php'); ?>


</body>
<!-- main js -->
<script src="assets/script.js"></script>
<!-- bootstrap js -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</html>