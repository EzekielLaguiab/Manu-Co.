<?php
session_start();
include '../server/connection.php';

if(!isset($_SESSION['admin_logged_in'])){
    header('location: admin_login.php');
    exit;
}

if(isset($_GET['order_id'])){

    $order_id = $_GET['order_id'];

    $result = $conn->prepare("DELETE from orders WHERE order_id=?");
    $result->bind_param('i', $order_id);

    if($result->execute()){
        
        header('location: orders.php?order_delete=Order deleted successfully!');
        exit();

    }
    else{
        
        header('location: orders.php?error==Error occurred, try again');
        exit();
    }

}else {
    header('location: index.php');
    exit();
}
