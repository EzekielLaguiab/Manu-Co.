<?php

session_start();
require 'server/connection.php';

if (!isset($_SESSION['logged_in'])) {
    header('location: cart.php?msg=error');
    exit;

}

if(!empty($_SESSION['cart'])){

}else{
    
    header('location: index.php');

}

if(isset($_SESSION['logged_in'])){

    $user_id = $_SESSION['user_id'];

    $result = $conn->prepare("SELECT * FROM users WHERE user_id = ?");
    $result->bind_param('i', $user_id );
    $result->execute();
}

?>
    <!-- Nav bar -->
    <?php require ('header.php') ?>
    
     <!-- animate to show the content from the bottom -->
    <div style="display: none;" id="myDiv" class="animate-bottom"> 

    <!-- checkout -->
    <section class="my-4 py-5">
        <div class="container text-center mt-4 py-4">
            <div>
                <h2 class="form-weight-bold">Check Out</h2>
                <hr class="mx-auto">
            </div>

            <div class="mx-auto container">
                <form id="checkout-form" method="post" action="place_order.php">
                    <p>Note: If you want to change or update go back to account settings, thanks!</p>
                        
                    <div class="form-group checkout-small-element">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="checkout-name" name="name" readonly value="<?php if(isset($_SESSION['first_name'])){ echo $_SESSION['first_name']; } ?> <?php if(isset($_SESSION['last_name'])){ echo $_SESSION['last_name']; } ?>" placeholder="" required>
                    </div>
                    <div class="form-group checkout-small-element">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="checkout-email" name="email" readonly value="<?php if(isset($_SESSION['user_email'])){ echo $_SESSION['user_email']; } ?>" placeholder="" required>
                    </div>
                    <div class="form-group checkout-small-element">
                        <label for="phone">Phone Number</label>
                        <input type="tel" class="form-control" id="checkout-phone" name="phone" readonly value="<?php if(isset($_SESSION['user_phone'])){ echo $_SESSION['user_phone']; } ?>" placeholder="" required>
                    </div>
                    <div class="form-group checkout-small-element">
                        <label for="address">Complete Address</label>
                        <input type="text" class="form-control" id="checkout-address" name="address" readonly value="<?php if(isset($_SESSION['user_address'])){ echo $_SESSION['user_address']; } ?>" placeholder="" required>
                    </div>
                    <div class="form-group checkout-btn-container">
                        <p>Total amount: P <?php echo $_SESSION['cart_total']; ?></p>
                        <input type="submit" class="btn" id="checkout-btn" name="place-order" value="Place order"/>
                    </div>

                </form>

            </div>
        </div>

     </section>


    <!-- footer -->
    <?php include('footer.php'); ?>
        
