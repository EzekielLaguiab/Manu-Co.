<?php
session_start();
include('../server/connection.php');

if(isset($_SESSION['admin_logged_in'])){
    header('location: index.php');
    exit;
}

if(isset($_POST['login'])){

    $name = $_POST['admin_name'];
    $password = md5($_POST['password']); 

    $result = $conn->prepare(query: "SELECT admin_id, admin_name, admin_password FROM admins WHERE admin_name = ? AND admin_password = ?  LIMIT 1");
    
    $result->bind_param('ss', $name, $password);
    
    if($result->execute()){
        $result->bind_result($admin_id, $admin_name, $admin_password);
        $result->store_result();

        if($result->num_rows() == 1){
            $result->fetch();

            $_SESSION['admin_id'] = $admin_id;
            $_SESSION['admin_name'] = $admin_name;
            $_SESSION['admin_logged_in'] = true;

            header('location: index.php?message=Welcome!' . " " . $admin_name);
            exit();

        } else {
            header('location: admin_login.php?error=Wrong email and password');
            exit();
        }

    } else {
        // Error handling for failed SQL query
        header('location: admin_login.php?error=Something went wrong, please try again later');
        exit();
    }
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
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous"/>
    <!-- Bootsrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <style>
        * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Poppins, San Serif';

        }
        body{
            overflow-x: hidden;
        }

        /* login form */
        #login-form{
        width: 50%;
        margin: 5px auto;
        padding: 20px;
        border-top: 1px solid #2E7D32;
        }

        #login-form input{
            width: 50%;
            margin: 5px auto;
        }

        hr{
            width: 50px;
            height: 3px !important;
            opacity: 1 !important;
            background-color:  #2E7D32;
        }

        #login-form #login-btn{
        background-color:  #2E7D32;
        color: #fff;
        }

        #login-form #login-btn:hover{
            background-color: #4CAF50;
            color: white;
        }

        @media only screen and (max-width: 576px) {

            #login-form{
            width: 80%;
            margin: 5px auto;
            padding: 20px;
            border-top: 1px solid #2E7D32;
            }

            #login-form input{
                width: 80%;
                margin: 5px auto;
            }
        }

        @media only screen and (min-width: 577px) and (max-width: 768px) {

            #login-form{
            width: 70%;
            margin: 5px auto;
            padding: 20px;
            border-top: 1px solid #2E7D32;
            }

            #login-form input{
                width: 70%;
                margin: 5px auto;
            }
        }

        @media only screen and (min-width: 769px) and (max-width: 992px) {

            #login-form{
            width: 60%;
            margin: 5px auto;
            padding: 20px;
            border-top: 1px solid #2E7D32;
            }

            #login-form input{
                width: 60%;
                margin: 5px auto;
            }
        }

    </style>

</head>

<body style="background-color:#E8F5E9;">

    <section class="my-4 py-4">
        <div class="container text-center mt-4 py-4">
            <div>
                <h2 class="form-weight-bold">Admin</h2>
                <hr class="mx-auto">
            </div>

            <div class="mx-auto container mb-5">
                <form id="login-form" action="admin_login.php" method="post">
                    <P style="color:red"><?php if(isset($_GET['error'])) {echo $_GET['error']; }  ?></P>
                    <div class="form-group mb-3">
                        <label for="admin_name">Admin Name</label>
                        <input type="text" class="form-control" id="admin_name" name="admin_name" placeholder="" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="" required>
                    </div>
                    <div class="form-group">
                        <input id="login-btn" type="submit" class="btn" name="login" value="Login"/>
                    </div>
                </form>
            </div>
        </div>
    </section>

</body>