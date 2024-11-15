<?php 
session_start();

require "server/connection.php";


$sql = "SELECT * FROM products WHERE product_id IN (5,6,7,8)";
$results2 = $conn->query(query: $sql);


$sql = "SELECT * FROM products WHERE product_id IN (9,10,11,12)";
$results1 = $conn->query(query: $sql);

?>

<!-- header -->
<?php include 'header.php'; ?>

    <div style="display: none;" id="myDiv" class="animate-bottom"> 

      <!-- home section -->
      <section id="home" class="container mt-5 pt-5 text-center text-md-start ">
          <div class="container">
          <div class="row align-items-center  ">
              
              <!-- Text Section -->
              <div id="home-text-section" class="col-md-6 mb-4 mb-md-0">
                  <h4 class="fw-bold">WELCOME TO MANU'S CRAFT SHOP!</h4>
                  <hr class="w-25 mx-auto mx-md-0 mb-4">
                  <h1 class="display-5"><span>Best Prices</span> on Beautiful Bracelets</h1>
                  <p class="lead">
                      Discover our curated collection of stone and crystal bracelets, designed for elegance and balance.
                      Each piece showcases the natural beauty and unique energy of carefully selected stones.
                  </p>
                  <p>
                      Perfect for any occasion, our bracelets are crafted with quality and intention to inspire and uplift. Find the one that speaks to you today.
                  </p>
                  <a href="shop.php" class="btn mt-3" id="buttons2">Shop Now</a>
              </div>
              
              <!-- Image Section -->
              <div id="home-section" class="col-md-6 d-flex justify-content-center">
                  <img src="assets/IMAGES/p1.jpg" alt="Beautiful stone bracelets displayed" class="img-fluid rounded shadow">
              </div>
          </div>
          </div>
      </section>

      <!-- featured -->
      <section id="featured" class="my-5 pb-5 container">

          <div class="container">

            <div class="text-center mt-5 py-5 ">
              <h3>Our Featured Products</h3>
              <hr class="mx-auto">
              <p>You can check out our new featured products</p>
            </div>

            <div class="row d-flex justify-content-center"> 
                <?php while($row = $results2->fetch_assoc()) { ?>
                    <div class="product text-center col-lg-3 col-md-3 col-5 mb-5">
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

      <!-- banner -->
      <section id="banner" class="my-5 py-5 text-center">
      <div class="container">
        <h4>CHRISTMAS SEASON'S SALE</h4>
        <h2>Collect <br> Up to 10% OFF</h2>
        <a href="shop.php"> <button>Shop now</button></a>
      </div>
      </section>

      <!-- custom bracelets -->
      <section id="featured" class="my-5 pb-5 container">

          <div class="container">

            <div class="text-center mt-5 py-5 ">
              <h3>Hot and Latest Products</h3>
              <hr class="mx-auto">
              <p>You can check it out now!</p>
            </div>

            <div class="row d-flex justify-content-center"> 
                <?php while($row = $results1->fetch_assoc()) { ?>
                    <div class="product text-center col-lg-3 col-md-3 col-5 mb-5 mx-1">
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

