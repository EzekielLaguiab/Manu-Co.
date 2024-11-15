<?php
session_start();
include '../server/connection.php';

if(!isset($_SESSION['admin_logged_in'])){
    header('location: admin_login.php');
    exit;
}

if(isset($_GET['product_id'])){

    $product_id = $_GET['product_id'];

    $result = $conn->prepare("DELETE from products WHERE product_id=?");
    $result->bind_param('i', $product_id);

    if($result->execute()){
        
        header('location: products.php?product_delete=Product deleted successfully!');
        exit();

    }
    else{
        
        header('location: products.php?error==Error occurred, try again');
        exit();
    }

}else {
    header('location: index.php');
    exit();
}
