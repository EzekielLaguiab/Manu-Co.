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

      <?php include('header.php') ?>

      <!-- hom section -->
      <section id="home" class="pb-5">
          <div class="container">
              <h4>WELCOME!</h4>
              <h1><span>Best prices</span> for Bracelets</h1>
              <p>Manu & Co. offers the best <br>products for the most affordable price</p>
              <button>Shop now</button>
          </div>

      </section>

       <!-- brand -->
      <!-- <section id="brand" class="container my-5 pb-5 ">
            <div class="container-fluid text-center mt-5 py-5">
              <h3>Our Partners</h3>
              <hr class="mx-auto">
              <p>Most trusted partners of all time</p>
            </div>

            <div class="row ">
            <?php
            include 'assets/server/connection.php';

            $sql = "SELECT * FROM brands limit 4";
            $result = $conn->query(query: $sql);
            ?>

            <?php while($row = $result->fetch_assoc()) { ?>
                <img class=" col-lg-2 col-md-3 col-3" src="assets/imgs/brand/<?php echo $row ['image_url']; ?>">
                <?php } ?>
            </div>
      </section> -->

      <!-- New Section -->
      <section id="new-section" class="w-100 container mb-2">
      <div class="container-fluid text-center mt-4 py-4 ">
          <h3>On sales Products</h3>
          <hr class="mx-auto">
          <p>You can check out our sales products</p>
        </div>
      <div class="row p-2 m-2">
          <!-- one -->
          <div class="one text-center col-lg-4 col-md-4 col-6 mb-5">
            <div class="image-container">
                <img class="img-fluid mb-3" src="assets/imgs/brand/brand3.png" alt="">
                <div class="details">
                  <h3>50% OFF crystals</h3>
                  <button class="text-uppercase">shop now</button>
                </div>
            </div> 
        </div>
          <!-- two -->
          <div class="one text-center col-lg-4 col-md-4 col-6  mb-5">
            <div class="image-container">
                <img class="img-fluid mb-3" src="assets/imgs/brand/brand3.png" alt="">
                <div class="details">
                  <h3>50% OFF crystals</h3>
                  <button class="text-uppercase">shop now</button>
                </div>
            </div> 
        </div>
          <!-- three -->
          <div class="one text-center col-lg-4 col-md-4 col-6  mb-5">
            <div class="image-container">
                <img class="img-fluid mb-2" src="assets/imgs/brand/brand3.png" alt="">
                <div class="details">
                  <h3>50% OFF crystals</h3>
                  <button class="text-uppercase">shop now</button>
                </div>
            </div> 
        </div>
        </div> 

      </section>

      <!-- featured -->
      <section id="featured" class="my-5 pb-5 container">
        <div class="container-fluid text-center mt-5 py-5 ">
          <h3>Our Featured Products</h3>
          <hr class="mx-auto">
          <p>You can check out our new featured products</p>
        </div>

        <div class="row mx-auto container-fluid">  
          
        
        <?php
            include 'assets/server/connection.php';

            $sql = "SELECT * FROM products WHERE product_id IN (1,2,3,4)";
            $result = $conn->query(query: $sql);

         ?>

        <?php while($row = $result->fetch_assoc()) { ?>
                
                <div  class="product text-center col-lg-3 col-md-4 col-6">
                    <div class="image-container container">
                        
                        <img style="width: auto; height: 200px; box-sizing: border-box; object-fit: cover;" 
                        id="image" class="img-fluid  mb-3" src="assets/IMAGES/<?php echo $row ['product_image']; ?>" alt="">
                        <a href="<?php echo "single_product.php?product_id=" . $row['product_id'];?>">  
                            <button class="buy-btn">Buy now</button>
                        </a>
                    </div>
                    <div class="star">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <h5 class="p-name"><?php echo $row ['product_name']; ?></h5>
                    <h4 class="p-price">P<?php echo $row ['product_price']; ?></h4>
                    
                </div>

            <?php } ?>
        </div>

      </section>

      <!-- banner -->
      <section id="banner" class="my-5 py-5">
      <div class="container">
        <h4>CHRISTMAS SEASON'S SALE</h4>
        <h2>Collect <br> Up to 30% OFF</h2>
        <button class="text-uppercase">Shop now</button>
      </div>
      </section>

      <!-- custom bracelets -->
      <section id="featured" class="my-5 pb-5 container">
      <div class="container text-center mt-5 py-5 ">
        <h3>Custom Bracelets</h3>
        <hr class="mx-auto">
        <p>You can check out our new crystals products</p>
      </div>

      <div class="row mx-auto container-fluid">

           <?php
            include 'assets/server/connection.php';

            $sql = "SELECT * FROM products where product_id IN (5,6,7,8)" ;
            $result = $conn->query(query: $sql);

            ?>

          <?php while($row = $result->fetch_assoc()) { ?>
            <div class="product text-center col-lg-3 col-md-4 col-6">
                  <div class="image-container container">
                      <img id="image" class="img-fluid  mb-3" src="assets/IMAGES/<?php echo $row ['product_image']; ?>" alt="">
                      <a href="<?php echo "single_product.php?product_id=" . $row['product_id'];?>">  
                          <button class="buy-btn">Buy now</button>
                      </a>
                  </div>
                  <div class="star">
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                  </div>
                  <h5 class="p-name"><?php echo $row ['product_name']; ?></h5>
                  <h4 class="p-price">P<?php echo $row ['product_price']; ?></h4>
            </div>
          <?php } ?>

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