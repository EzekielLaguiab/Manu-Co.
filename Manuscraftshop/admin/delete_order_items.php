<?php
session_start();
include '../server/connection.php';

if(!isset($_SESSION['admin_logged_in'])){
    header('location: admin_login.php');
    exit;
}

if(isset($_GET['item_id'])){

    $item_id = $_GET['item_id'];

    $result = $conn->prepare("DELETE from order_items WHERE item_id=?");
    $result->bind_param('i', $item_id);

    if($result->execute()){
        
        header('location: order_items.php?order_items_delete=Order items deleted successfully!');
        exit();

    }
    else{
        
        header('location:  order_items.php?error==Error occurred, try again');
        exit();
    }

}else {
    header('location: index.php');
    exit();
}
