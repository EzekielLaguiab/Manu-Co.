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

    <!-- account info -->
     <section class="my-5 py-5">
        <div class="row container mx-auto">
            <div class="text-center mt-3 pt-5 col-lg-6 col-md-12 col-12">
                <h2 class="font-weight-bold">Account info</h2>
                <hr class="mx-auto">
                <div class="account-info">
                    <p>Name: <span>Zekie</span></p>
                    <p>Email: <span>123@gmail.com</span></p>
                    <p><a href="#" id="order-btn">Your orders</a></p>
                    <p><a href="#" id="logout-btn">Logout</a></p>
                </div>
            </div>
            <div class="col-lg-6 col-md-12 col-12">
                <form action="" id="account-form">
                    <h3>Change Password</h3>
                    <hr class="mx-auto">
                    <div class="form-group">
                        <label for="">Password</label>
                        <input type="password" class="form-control" id="account-password" name="password" placeholder="Password" required>
                    </div>
                    <div class="form-group">
                        <label for="">Confirm Password</label>
                        <input type="password" class="form-control" id="account-password-confirm" name="confirmPassword" placeholder="Password" required>
                    </div>
                    <div class="form-group">
                        <input type="submit" name="" class="btn" id="change-pass-btn" value="Change Password">
                    </div>
                </form>
            </div>
        </div>

     </section>


     <!-- orders section -->
     <section class="orders container my-5 py-3">
        <div class="container mt-2">
            <h2 class="font-weight-bold text-center">Your Orders</h2>
            <hr class="mx-auto">
        </div>

        <table class="mt-5 pt-5">
            <tr>
                <th>Product</th>
                <th>Date</th>
            </tr>
            <tr>
                <td>
                    <div class="product-info">
                        <img src="assets/imgs/brand3.png" alt="">
                        <p class="mt-3">Stone</p>
                    </div>
                </td>
                <td>
                    <p class="" id="orders-date">2024-9-25</p>
                </td>
                
            </tr>

        </table>

     </section>

    <!-- footer -->
    <?php include('footer.php'); ?>
        
        
</body>
<!-- main js -->
<script src="assets/script.js"></script>
<!-- bootstrap js -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</html>