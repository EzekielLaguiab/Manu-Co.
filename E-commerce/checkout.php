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

    <!-- checkout -->
    <section class="my-5 py-5">
        <div class="container text-center mt-4 py-4">
            <div>
                <h2 class="form-weight-bold">Check Out</h2>
                <hr class="mx-auto">
            </div>

            <div class="mx-auto container">
                <form id="checkout-form" action="">
                    <div class="form-group checkout-small-element">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="checkout-name" name="name" placeholder="Name" required>
                    </div>
                    <div class="form-group checkout-small-element">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="checkout-email" name="email" placeholder="Email" required>
                    </div>
                    <div class="form-group checkout-small-element">
                        <label for="phone">Phone</label>
                        <input type="tel" class="form-control" id="checkout-phone" name="phone" placeholder="Phone" required>
                    </div>
                    <div class="form-group checkout-small-element">
                        <label for="address">Complete Address</label>
                        <input type="text" class="form-control" id="checkout-address" name="address" placeholder="Complete Address" required>
                    </div>
                    <div class="form-group checkout-btn-container">
                        <input type="submit" class="btn" id="checkout-btn" value="Checkout"/>
                    </div>

                </form>

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