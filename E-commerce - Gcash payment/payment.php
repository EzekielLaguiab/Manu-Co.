<?php 
session_start(); // Start session

$order_status = ''; // Initialize order_status

// Check if the form was submitted and order_pay was set
if (isset($_POST['order_pay'])) {
    $order_status = $_POST['order_status'];
}

$amount = 0;
$order_id = null;
?>

<style>
    #paypal-button-container {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 50%;
        margin: 0 auto;
        padding: 20px;
        background-color: #f5f5f5; /* Optional: add a background color */
        border-radius: 8px; /* Optional: add rounded corners */
        text-align: center;
    }

    .container-paypal {
        display: flex;
        justify-content: center;
    }

    @media only screen and (max-width: 576px) {
        #paypal-button-container {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 80%;
        margin: 0 auto;
        padding: 20px;
        background-color: #f5f5f5; /* Optional: add a background color */
        border-radius: 8px; /* Optional: add rounded corners */
        text-align: center;
    }
}
</style>

<!-- Nav bar -->
<?php include('header.php') ?>

<?php if (isset($_GET['message']) && $_GET['message'] == 'Order placed successfully'): ?>
    <script src="assets/sweetalert2@11.js"></script>
    <script>
        Swal.fire({
            icon: "success",
            title: "Order placed successfully!",
            showConfirmButton: false,
            timer: 2000
        });
    </script>
<?php endif; ?>

<!-- animate to show the content from the bottom -->
<div style="display: none;" id="myDiv" class="animate-bottom">

<!--payment-->
<section id="payment" class="my-3 py-5 text-center container mx-auto">
    <div class="container mt-3 pt-3">
        <h2 class="font-weight-bold" style="color:green;">Transaction Payment</h2>
        <hr class="mx-auto">
    </div>
    <div class="container mx-auto">

        <!-- First check: If order_status is "not paid" -->
        <?php if ($order_status === "not paid") { ?>

            <?php $order_id = $_POST['order_id']; ?>
            <!-- GCash QR Code Image -->
            <div class="gcash-qrcode mb-3">
                <h4 style="color:green;">G-cash payment</h4>
                <img src="GCASH-QR - COPY.jpg" alt="GCash QR Code" style="width: 270px; height: 360px;">
            </div>

            <form action="complete_payment.php" method="GET">
                <div class="form-group">
                    <?php $amount = $_SESSION['order_total']; ?>
                    <p>Total payment: <b>P <?php echo $_SESSION['order_total']; ?></b></p>
                    <label for="transaction_id">Enter GCash Transaction ID:</label>

                    <!-- Centering the input field using Bootstrap's grid system -->
                    <div class="row justify-content-center">
                        <div class="col-6">
                            <input type="text" class="form-control" id="transaction_id" name="transaction_id" required>
                        </div>
                    </div>
                    <input type="hidden" name="amount" value="<?php echo $amount; ?>">
                    <input type="hidden" name="order_id" value="<?php echo $order_id; ?>">
                </div>
                
                <div class="form-group mt-2 text-center">
                    <button  type="submit" name="updateAccount" class="btn btn-primary">Confirm</button>
                </div>
            </form>
            <a href="account.php">
                <input id="buttons" class="btn mt-3" value="Visit account" type="submit">
            </a>

        <!-- Second check: If cart_total exists and is not 0 -->
        <?php } elseif (isset($_SESSION['order_cart_total']) && $_SESSION['order_cart_total'] != 0) { ?>

            <?php $order_id = $_SESSION['order_id']; ?>
            <!-- GCash QR Code Image -->
            <div class="gcash-qrcode">
                <h4 style="color:green;">G-cash payment</h4>
                <img src="GCASH-QR - COPY.jpg" alt="GCash QR Code" style="width: 270px; height: 360px;">
            </div>

            <form action="complete_payment.php" method="GET">
                <div class="form-group">
                <?php $amount = $_SESSION['order_cart_total']; ?>
                    <p class="mt-3">Total payment: <b>P <?php echo $_SESSION['order_cart_total']; ?></b></p>
                    <label for="transaction_id">Enter GCash Transaction ID:</label>

                    <!-- Centering the input field using Bootstrap's grid system -->
                    <div class="row justify-content-center">
                        <div class="col-6">
                            <input type="text" class="form-control" id="transaction_id" name="transaction_id" required>
                        </div>
                    </div>
                    <input type="hidden" name="amount" value="<?php echo $amount; ?>">
                    <input type="hidden" name="order_id" value="<?php echo $order_id; ?>">
                </div>
                
                <div class="form-group mt-2 text-center">
                    <button type="submit" name="updateAccount" class="btn btn-primary">Confirm</button>
                </div>
            </form>
            <a href="account.php">
                <input id="buttons" class="btn mt-3" value="Visit account" type="submit">
            </a>
        
        <!-- Else: No pending payments -->
        <?php } else { ?>
            <p class="text-center" style="color:red">No pending payments</p>
        <?php } ?>

    </div>
</section>

<!-- footer -->
<?php include('footer.php'); ?>
