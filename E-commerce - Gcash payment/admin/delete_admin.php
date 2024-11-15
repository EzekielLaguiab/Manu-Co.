<?php
session_start();
include '../server/connection.php';

if(!isset($_SESSION['admin_logged_in'])){
    header('location: admin_login.php');
    exit;
}

// delete admin account with sweetalert
if(isset($_GET['admin_id'])){

    $admin_id = $_GET['admin_id'];

    $result = $conn->prepare("DELETE from admins WHERE admin_id=?");
    $result->bind_param('i', $admin_id);

    if($result->execute()){
        
        header('location: admin.php?admin_edit=Admin successfully removed!');
        exit();

    }
    else{
        header('location: admin.php?error==Error occurred, try again');
        exit();

    }

}else {
    header('location: index.php');
    exit();
}
