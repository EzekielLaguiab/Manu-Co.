<?php 
session_start();

require "server/connection.php";


$sql = "SELECT * FROM products WHERE product_id IN (5,6,7,8)";
$results2 = $conn->query(query: $sql);


$sql = "SELECT * FROM products WHERE product_id IN (9,10,11,12)";
$results1 = $conn->query(query: $sql);

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manu's Craft Shop</title>
    <link rel="icon" href="assets/imgs/image-logo.jpg">
    <!-- main css -->
    <link rel="stylesheet" href="assets/style.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous"/>
    <!-- Bootsrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <style>
    .procuct #image{
        width: 50%; 
        height: 50%; 
        box-sizing: border-box;
        object-fit: cover;
    }


</style>

</head>
<body onload="myFuntion()" style="margin: 0;"> 

<!-- animate to show the content from the bottom -->
<div style="display: none;" id="myDiv" class="animate-bottom"> 
    
    <!-- Nav bar -->
    <nav class="navbar navbar-expand-lg bg-body-tertiary fixed-top py-2 mb-5">
        <div class="container">

          <img src="assets/imgs/image-logo.jpg" class="logo" alt="Company logo">
          <h2 class="brand">Manu's Craft Shop</h2>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="true" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>

          
          <div class="collapse navbar-collapse nav-buttons" id="navbarSupportedContent">
            <div>
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0">

                  <li class="nav-item">
                    <a class="nav-link " href="index.php">Home</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="shop.php">Shop</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="about.php">About</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="contact.php">Contact</a>
                  </li>
                </ul>
            </div>

            <div>

            <ul class="navbar-nav mx-auto  mb-2 mb-lg-0">
                <li class="nav-item ">
                <a href="cart.php"><i class="fas fa-shopping-cart" title="Cart">
                <?php if(isset($_SESSION['total_quantity']) && $_SESSION['total_quantity'] != 0  ) { ?>
                      <span class="cart-quantity"><?php echo $_SESSION['total_quantity']; ?></span>
                      <?php } ?>
                </i></a>
                <a href="login.php"><i class="fas fa-user" title="Profile"></i></a>
              </li>
            </ul>
            </div>


          </div>
        </div>
      </nav>

      <!-- hom section -->
       
      <section id="home" class="container my-5 py-5 text-center text-md-start ">
          <div class="container">
            <div class="row align-items-center mt-5 ">
                
                <!-- Text Section -->
                <div id="home-text-section" class="col-md-6 mb-4 mb-md-0">
                    <h4 class="fw-bold">WELCOME TO MANU'S CRAFT SHOP!</h4>
                    <hr class="w-25 mx-auto mx-md-0 mb-4">
                    <h1 class="display-5"><span>Best Prices</span> on Beautiful Bracelets</h1>
                    <p class="lead">
                        Discover our curated collection of stone and crystal bracelets, designed for elegance and balance.
                        Each piece showcases the natural beauty and unique energy of carefully selected stones.
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
                            <h4 class="p-price">$<?php echo $row ['product_price']; ?></h4>

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
                            <h4 class="p-price">$<?php echo $row ['product_price']; ?></h4>

                            <a href="<?php echo "single_product.php?product_id=" . $row['product_id'];?>">  
                                    <button class="buy-btn">Buy now</button>
                            </a>
                    </div>
                <?php } ?>
            </div>

          </div>

    </section>

    <footer class="mt-5 py-4">
        <div class="row container mx-auto">
          <div class="footer-two col-lg-4 col-md-6 col-md-12 mb-2">
            <h5 class="pb-2" id="Contact">Contact Us</h5>
            <div>
              <h6 class="text-uppercase">Address</h6>
              <p>Quezon City</p>
            </div>
            <div>
              <h6 class="text-uppercase">Phone</h6>
              <p>+63123456789</p>
            </div>
            <div>
              <h6 class="text-uppercase">Email</h6>
              <p>manuscraftshop@gmail.com</p>
            </div>
          </div>

          <div class="footer-two col-lg-4 col-md-6 col-md-12 mb-2">
            <h5 class="pb-2">Facebook</h5>
            <div class="row">
              <!-- Facebook img -->
              <img class="img-fluid w-25 h-100 m-2" src="assets/IMAGES/p1.jpg">
              <img class="img-fluid w-25 h-100 m-2" src="assets/IMAGES/p2.jpg">
              <img class="img-fluid w-25 h-100 m-2" src="assets/IMAGES/p3.jpg">
              <img class="img-fluid w-25 h-100 m-2" src="assets/IMAGES/p4.jpg">
              <img class="img-fluid w-25 h-100 m-2" src="assets/IMAGES/p5.png">
            </div>
          </div>

          <div class="footer-three col-lg-4 col-md-6 col-md-12">
            <h5 class="pb-2">Socials</h5>
            <a href="#">
                <i class="fab fa-facebook"></i>
              </a>
              <a href="#">
                <i class="fab fa-instagram"></i>
              </a>
              <a href="#">
                <i class="fab fa-twitter"></i>
              </a>
            
          </div>
        </div>

        <div class="container copyright mt-5 d-flex justify-content-center">
            <p>Manu's Craft Shop @ 2024 All Right Reserved</p>
        </div>

</footer>

</div>

    
</body>
<script>
  var myVar;
  function myFuntion(){
    myVar =setTimeout(showPage, 0);
  }
  function showPage() {
    document.getElementById("myDiv").style.display = "block";
  }
</script>
<!-- bootstrap js -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</html>
</div>

    
</body>
<script>
  var myVar;
  function myFuntion(){
    myVar =setTimeout(showPage, 0);
  }
  function showPage() {
    document.getElementById("myDiv").style.display = "block";
  }
</script>
<!-- bootstrap js -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</html>
</div>

</body>

<script>
  var myVar;
  function myFuntion(){
    myVar =setTimeout(showPage, 0);
  }
  function showPage() {
    document.getElementById("myDiv").style.display = "block";
  }
</script>

<!-- bootstrap js -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</html>