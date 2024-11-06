<?php
session_start();
include ('connection.php');

// change order status to paid
if (isset($_GET['transaction_id']) && isset($_GET['order_id'])) {

    $order_id = $_GET['order_id'];
    $order_status = 'paid';
    $transaction_id = $_GET['transaction_id'];
    $user_id = $_SESSION['user_id'];
    $payment_date = date('y-m-d');

    // change the order status to paid
    $result = $conn->prepare("UPDATE orders SET order_status = ? WHERE order_id = ?");
    $result->bind_param('si', $order_status, $order_id);
    $result->execute();

    // store payment info (typo fixed)
    $result1 = $conn->prepare("INSERT INTO payments (order_id, user_id, transaction_id, payment_date)
                               VALUES (?, ?, ?, ?);");
    $result1->bind_param('iiss', $order_id, $user_id, $transaction_id, $payment_date);
    $result1->execute();

    header('location: ../account.php?payment_status=success');

} else {
    header('location: ../index.php');
    exit();
}
