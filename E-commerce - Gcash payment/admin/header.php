<?php 
if(!isset($_SESSION['admin_logged_in'])){
    header('location: admin_login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manu's Craft Shop Admin</title>
    <link rel="icon" href="../assets/imgs/image-logo2.jpg">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwVChigm" crossorigin="anonymous"/>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins, San Serif';
        }
        body {
            display: flex;
            height: 100vh;
            flex-direction: column;
        }
        .navbar {
            background-color: #4CAF50;
        }
        .navbar-nav .nav-link {
            color: white !important;
        }
        .navbar-nav .nav-link:hover {
            color: #2E7D32 !important;
        }
        .content {
            flex-grow: 1;
            padding: 20px;
            background-color: #E8F5E9;
        }
        .logo {
            width: 50px;
            height: 50px;
            border-radius: 50%;
        }
        hr{
            width: 100%;
            height: 2px !important;
            opacity: 1 !important;
            background-color:  #4CAF50;
        }
    </style>
</head>
<body>

<!-- Navbar -->
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="../assets/imgs/image-logo2.jpg" class="logo" alt="Company logo">
                Manu's Craft Shop
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link" href="index.php"><i class="fas fa-table"></i> Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="orders.php"><i class="fas fa-shopping-cart"></i> Orders</a></li>
                    <li class="nav-item"><a class="nav-link" href="order_items.php"><i class="fas fa-list"></i> Order Items</a></li>
                    <li class="nav-item"><a class="nav-link" href="payments.php"><i class="fas fa-credit-card"></i> Payments</a></li>
                    <li class="nav-item"><a class="nav-link" href="products.php"><i class="fas fa-shopping-basket"></i> Products</a></li>
                    <li class="nav-item"><a class="nav-link" href="users.php"><i class="fas fa-users"></i> Users</a></li>
                    <li class="nav-item"><a class="nav-link" href="messages.php"><i class="fas fa-envelope"></i> Messages</a></li>
                    <li class="nav-item"><a class="nav-link" href="admin.php"><i class="fas fa-user"></i> Admin</a></li>
                </ul>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="index.php?logout=1"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

     <!-- Content -->
<div class="content mt-5" >
    
    <hr class="mt-5">
    <p style="color:green" class="text-center"><?php if(isset($_GET['message'])) {echo $_GET['message']; } ?></p>
