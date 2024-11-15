<?php
session_start();
require 'server/connection.php';

// Ensure the user is logged in
if (!isset($_SESSION['logged_in'])) {
    header('location: login.php');
    exit;
}

$user_email = $_SESSION['user_email'];

// Handle account info update
if (isset($_POST['updateAccount'])) {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $user_phone = $_POST['user_phone'];
    

    // Prepare and execute the query to update user information
    $result = $conn->prepare("UPDATE users SET first_name = ?, last_name = ?, user_phone = ? WHERE user_email = ?");
    $result->bind_param('ssss', $first_name, $last_name, $user_phone,  $user_email);

    if ($result->execute()) {
        // Update session values for the updated info
        $_SESSION['first_name'] = $first_name;
        $_SESSION['last_name'] = $last_name;
        $_SESSION['user_phone'] = $user_phone;
       

        header('location: acc.php?message=accountupdate#Account');
        exit();
    } else {
        header('location: acc.php?error=Could not update account information#Account');
        exit();
    }
}

// Handle password change
if (isset($_POST['changePassword'])) {
    $oldPassword = $_POST['old_password'];
    $newPassword = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];

    // Ensure user email is set
    if (!$user_email) {
        header('location: acc.php?error=User not logged in#Account');
        exit();
    }

    // Fetch the current hashed password from the database
    $result = $conn->prepare("SELECT user_password FROM users WHERE user_email = ?");
    $result->bind_param('s', $user_email);
    $result->execute();
    $result->bind_result($storedPassword);
    $result->fetch();
    $result->close();

    // Verify the old password matches the stored password
    if (!password_verify($oldPassword, $storedPassword)) {
        header('location: acc.php?error=Old password is incorrect#Account');
        exit();
    }

    // If new passwords don't match
    if ($newPassword !== $confirmPassword) {
        header('location: acc.php?error=New passwords don\'t match, please try again#Account');
        exit();

    // Check password length (minimum 6 characters)
    } else if (strlen($newPassword) < 6) {
        header('location: acc.php?error=Password must be at least 6 characters#Account');
        exit();

    // Update password if all checks pass
    } else {
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        $updatePassword = $conn->prepare("UPDATE users SET user_password = ? WHERE user_email = ?");
        $updatePassword->bind_param('ss', $hashedPassword, $user_email);

        if ($updatePassword->execute()) {
            header('location: acc.php?message=Password has been updated successfully#Account');
            exit();
        } else {
            header('location: acc.php?error=Could not update password#Account');
            exit();
        }
    }
}

if (isset($_POST['update_address'])) {
    
   
    $province = $_POST['province'];
    $city = $_POST['city'];
    $barangay = $_POST['barangay'];
    $street = $_POST['street'];
    $apartment = $_POST['apartment'];
    $postcode = $_POST['postcode'];
    
    // Prepare and execute the query to update user information
    $result = $conn->prepare("UPDATE users SET province = ?, city = ? , barangay = ? , street = ?, apartment = ? , postcode = ? WHERE user_email = ?");
    $result->bind_param('sssssis', $province, $city, $barangay, $street, $apartment, $postcode, $user_email);

    if ($result->execute()) {
        // Update session values for the updated info
       
        $_SESSION['province'] = $province;
        $_SESSION['city'] = $city;
        $_SESSION['barangay'] = $barangay;
        $_SESSION['street'] = $street;
        $_SESSION['apartment'] = $apartment;
        $_SESSION['postcode'] = $postcode;
        
        header('location: acc.php?message=addressupdate#Address');
        exit();
    } else {
        header('location: acc.php?error=Could not update address information#Address');
        exit();
    }
}