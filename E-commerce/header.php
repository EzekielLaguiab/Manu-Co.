
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

    </style>
</head>
<body onload="myFuntion()" style="margin: 0;"> 
    
    <!-- Nav bar -->
    <nav class="navbar navbar-expand-lg bg-body-tertiary fixed-top py-2">
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