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
        <h2 class="font-weight-bold">Payment</h2>
        <hr class="mx-auto">
    </div>
    <div class="container mx-auto">

        <!-- First check: If order_status is "not paid" -->
        <?php if ($order_status === "not paid") { ?>

            <?php $amount = strval($_SESSION['order_total']); ?>
            <?php $order_id = $_POST['order_id']; ?>

            <p>Total payment: $ <?php echo $_SESSION['order_total']; ?></p>

            <div class="container-paypal" id="paypal-button-container"></div>

            <a href="account.php" class="">
                <input id="buttons" class="btn mt-3" value="Visit account" type="submit">
            </a>

        <!-- Second check: If cart_total exists and is not 0 -->
        <?php } elseif (isset($_SESSION['cart_total']) && $_SESSION['cart_total'] != 0) { ?>

            <?php $amount = strval($_SESSION['cart_total']); ?>
            <?php $order_id = $_SESSION['order_id']; ?>
            <p>Total payment: $ <?php echo $_SESSION['cart_total']; ?></p>

            <div class="container-paypal" id="paypal-button-container"></div>

            <a href="account.php">
                <input id="buttons" class="btn mt-3" value="Visit account" type="submit">
            </a>
        
        <!-- Else: No pending payments -->
        <?php } else { ?>
            <p class="text-center" style="color:red">No pending payments</p>
        <?php } ?>

    </div>
</section>

<!-- project and not the official payment or paypal not live-->
<script
    src="https://www.paypal.com/sdk/js?client-id=AeUrmCfe8QxS-Zzr1oGmDjSr0pwPMvHM-D2VECusV_S_4Bi9cxvkyREXtYo_65G5awVxSNMibYdS6gFX&buyer-country=US&currency=USD&components=buttons&enable-funding=venmo,paylater,card"
    data-sdk-integration-source="developer-studio"
></script>
<script>
    paypal.Buttons({
        createOrder: function (data, actions){
            return actions.order.create({
                purchase_units: [{
                    amount: {
                        value: '<?php echo $amount; ?>' // total amount to pay
                    }
                }]
            });
        },
        onApprove: function(data, actions){
            return actions.order.capture().then(function(orderData) {
                console.log('Capture result', orderData, JSON.stringify(orderData, null, 2));
                var transaction = orderData.purchase_units[0].payments.captures[0];
                alert('transaction' + transaction.status + ': ' + transaction.id + '\n\n');

                window.location.href = "server/complete_payment.php?transaction_id=" + transaction.id + "&order_id=" + <?php echo $order_id; ?> + "&amount=" + <?php echo $amount; ?>;
            });
        }
    }).render('#paypal-button-container');
</script>

<!-- footer -->
<?php include('footer.php'); ?>
