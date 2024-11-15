<?php

session_start();

include ('server/connection.php');


// if user not log in
if(!isset($_SESSION['logged_in'])){

    header('location: checkout.php');
    exit;
    
    // if user is log in
    }else{

        if(isset($_POST['place-order'])) {

            // get user info and stire it in database
            $name = $_POST['name'];
            $email = $_POST['email'];
            $phone = $_POST['phone'];
            $address = $_POST['address'];
            $order_cost = $_SESSION['cart_total'];
            $order_status = "not paid";
            $user_id = $_SESSION['user_id'];
            $order_date = date(format: 'y-m-d');

            $result = $conn->prepare("INSERT INTO orders (order_cost, order_status, user_id, user_phone, user_address, order_date)
                    VALUES (?, ?, ?, ?, ?, ?);  ");

            $result->bind_param('ssisss', $order_cost, $order_status, $user_id, $phone, $address, $order_date);

            
            $result_status = $result->execute();
            

            if(!$result_status){
                
                header('location: index.php');
                exit;
            }
            $_SESSION['address'] = $address;

            // issue new order and store order info in database
            $order_id = $result->insert_id;
        
            // get products from cart from $_SESSION
            foreach($_SESSION['cart'] as $key => $value){

                $product = $_SESSION['cart'][$key];

                $product_id = $product['product_id'];
                $product_name = $product['product_name'];
                $product_image = $product['product_image'];
                $product_price = $product['product_price'];
                $wrist_size = $product['wrist_size'];
                $product_quantity = $product['product_quantity'];

                // store each single items in order_items database
                $result = $conn->prepare("INSERT INTO order_items (order_id, product_id, product_name, product_image, product_price, wrist_size, product_quantity,  user_id, order_date)
                                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?) ");
                $result->bind_param('iissssiis', $order_id, $product_id, $product_name, $product_image, $product_price, $wrist_size, $product_quantity, $user_id, $order_date  );

                $result->execute();
            }

            $_SESSION['order_id'] = $order_id;

            
            // Set a new session variable for order total
            $_SESSION['order_cart_total'] = $_SESSION['cart_total'];

            // Clear the cart after successful order placement
            unset($_SESSION['cart']);
            unset($_SESSION['cart_total']);
            unset($_SESSION['total_quantity']);


            // inform user that whether evrything is fine or there is a problem
            header('location: payment.php?message=Order placed successfully');
            exit();
        }

}
