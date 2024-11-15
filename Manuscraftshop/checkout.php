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
    $checkout = $result->get_result();
}

?>
    <!-- Nav bar -->
    <?php require ('header.php') ?>
    
     <!-- animate to show the content from the bottom -->
    <div style="display: none;" id="myDiv" class="animate-bottom"> 

    <!-- checkout -->
    <section id="checkout" class="my-4 py-5">
        <div class="container text-center mt-4 py-4">
            <div> 
                <h2 class="form-weight-bold">Checkout</h2>
                <hr class="mx-auto">
            </div>

            <div class="mx-auto container">
                <form id="checkout-form" method="post" action="place_order.php">
                    <!-- <p>Note: If you want to change or update go back to address settings, thanks!</p> -->
                    
                    <div class="row">
                        <div class="col-lg-6">
                            <h5>Information</h5>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <?php foreach($checkout as $row) {?>
                                <input type="email" class="form-control" id="checkout-email" name="email" readonly value="<?php echo $row['user_email']; ?>" placeholder="" required>
                                <?php }?>
                            </div>
                            <div class="form-group mt-2">
                                <label for="f-name">First Name <span style="color: red;">*</span></label>
                                <input type="text" class="form-control" name="f-name"  placeholder="" required>
                            </div>
                            <div class="form-group mt-2">
                                <label for="l-name">Last Name <span style="color: red;">*</span></label>
                                <input type="text" class="form-control" name="l-name"  placeholder="" required>
                            </div>
                            
                            <div class="form-group mt-2 mb-5">
                                <label for="phone">Phone Number <span style="color: red;">*</span></label>
                                <input type="tel" class="form-control" id="checkout-phone" name="phone" placeholder="" required>
                            </div>
                            
                            
                        </div>

                        <div class="col-lg-6">
                            <h5>Address</h5>
                            <!-- Province / State Dropdown -->
                            <div class="form-group mt-2">
                                <label for="province">State / Province <span style="color: red;">*</span></label>
                                <select id="province" name="province" class="form-control" required onchange="populateCities()">
                                    <option value="">Select Province</option>
                                </select>
                            </div>

                            <!-- City / Municipality Dropdown -->
                            <div class="form-group mt-2">
                                <label for="city">Town / City <span style="color: red;">*</span></label>
                                <select id="city" name="city" class="form-control" required onchange="populateBarangays()">
                                    <option value="">Select Town / City</option>
                                </select>
                            </div>

                            <!-- Barangay Dropdown -->
                            <div class="form-group mt-2">
                                <label for="Barangay">Barangay <span style="color: red;">*</span></label>
                                <select id="Barangay" name="barangay" class="form-control" required>
                                    <option value="">Select Barangay</option>
                                </select>
                            </div>


                            <div class="form-group mt-2">
                                <label for="street">Street address <span style="color: red;">*</span></label>
                                <input type="text" id="street" name="street" class="form-control" required placeholder="Steet address">
                            </div>
                            
                            <div class="form-group mt-2">
                                <label for="apartment">Apartment, suite, unit, etc. (optional)</label>
                                <input type="text" id="apartment" class="form-control" name="apartment" placeholder="Apartment, suite, unit, etc.">
                            </div>

                            <div class="form-group mt-2">
                                <label for="postcode">Postcode / ZIP <span style="color: red;">*</span></label>
                                <input type="text" id="postcode" class="form-control" name="postcode" required placeholder="Postcode or ZIP">
                            </div>
                        </div>
                        <div class="form-group checkout-btn-container mt-3">
                                <p>Total amount: P <?php echo $_SESSION['cart_total']; ?></p>
                                <input style="width: 30%;" type="submit" class="btn" id="checkout-btn" name="place-order" value="Place order"/>
                        </div>
                    </div>

                </form>

            </div>
        </div>

     </section>


    <!-- footer -->
    <?php include('footer.php'); ?>
    <script src="assets/script.js"></script>
        
