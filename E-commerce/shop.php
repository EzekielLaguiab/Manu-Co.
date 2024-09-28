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

    <style>
        /* .image-container {
            position: relative;
            width: 70%;
            padding-top: 70%; 
            overflow: hidden;
        }
        .image-container img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center; 
        } */

        #image{
            width: auto;
            height: 200px;
            box-sizing: border-box;
            object-fit: cover;
            object-position: center;

        }
        .pagination a{
            color: black;
        }
        .pagination li:hover a{
            background-color: orange;
            color: white;
        }
    </style>

</head>
<body>
    <!-- Nav bar -->
    <?php include('header.php') ?>

        <!-- featured -->
        <section id="featured" class="my-5 pb-5 container">
        <div class="container-fluid mt-5 py-5 ">
          <h3>Products</h3>
          <hr class="">
          <p>New and latest products</p>
        </div>

        <div class="row mx-auto container-fluid">  
          
        
            <?php
                include 'assets/server/connection.php';

                $sql = "SELECT * FROM products";
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

    <!-- footer -->
    <?php include('footer.php'); ?>

</body>

<!-- main js -->
<script src="assets/script.js"></script>
<!-- bootstrap js -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</html>