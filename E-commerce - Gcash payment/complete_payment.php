<?php
session_start();
require 'server/connection.php';

// Check if transaction_id and order_id are set in the URL
if (isset($_GET['transaction_id']) && isset($_GET['order_id']) && isset($_GET['amount'])) {

    $amount = $_GET['amount'];
    $order_id = $_GET['order_id'];
    $transaction_id = $_GET['transaction_id'];
    $user_id = $_SESSION['user_id'];
    $payment_date = date('Y-m-d');  // Date format corrected

    // Validate if the order exists in the database
    $order_check = $conn->prepare("SELECT * FROM orders WHERE order_id = ? AND user_id = ?");
    $order_check->bind_param('ii', $order_id, $user_id);
    $order_check->execute();
    $order_check_result = $order_check->get_result();

    if ($order_check_result->num_rows > 0) {
        // Set order status to "processing"
        $order_status = 'processing';
        $result = $conn->prepare("UPDATE orders SET order_status = ? WHERE order_id = ?");
        $result->bind_param('si', $order_status, $order_id);
        $result->execute();

        // Insert payment information with the transaction ID
        $result1 = $conn->prepare("INSERT INTO payments (order_id, user_id, transaction_id, payment_date, amount)
                                   VALUES (?, ?, ?, ?, ?);");
        $result1->bind_param('iisss', $order_id, $user_id, $transaction_id, $payment_date, $amount);
        $result1->execute();

        // Redirect to account page with payment status message
        header('Location: account.php?payment_status=processing');
        exit();
    } else {
        // Handle invalid order (e.g., show an error message or redirect)
        header('Location: index.php');
        exit();
    }

} else {
    // If transaction_id or order_id are not set, redirect to the index page
    header('Location: index.php');
    exit();
}
?>
