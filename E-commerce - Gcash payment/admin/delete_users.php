<?php
session_start();
include '../server/connection.php';

if(!isset($_SESSION['admin_logged_in'])){
    header('location: admin_login.php');
    exit;
}

if(isset($_GET['user_id'])){

    $user_id = $_GET['user_id'];

    $result = $conn->prepare("DELETE from users WHERE user_id=?");
    $result->bind_param('i', $user_id);

    if($result->execute()){
        header('location: users.php?user_delete=User deleted successfully!');
        exit();

    }
    else{
        
        header('location: users.php?error==Error occurred, try again');
        exit();
    }

}else {
    header('location: index.php');
    exit();
}
