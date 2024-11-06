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
    $user_address = $_POST['user_address'];

    // Prepare and execute the query to update user information
    $result = $conn->prepare("UPDATE users SET first_name = ?, last_name = ?, user_phone = ?, user_address = ? WHERE user_email = ?");
    $result->bind_param('sssss', $first_name, $last_name, $user_phone, $user_address, $user_email);

    if ($result->execute()) {
        // Update session values for the updated info
        $_SESSION['first_name'] = $first_name;
        $_SESSION['last_name'] = $last_name;
        $_SESSION['user_phone'] = $user_phone;
        $_SESSION['user_address'] = $user_address;

        header('location: update_account.php?message=accountupdate');
        exit();
    } else {
        header('location: update_account.php?error=Could not update account information');
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
        header('location: account.php?error=User not logged in');
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
        header('location: update_account.php?error=Old password is incorrect');
        exit();
    }

    // If new passwords don't match
    if ($newPassword !== $confirmPassword) {
        header('location: update_account.php?error=New passwords don\'t match, please try again');
        exit();

    // Check password length (minimum 6 characters)
    } else if (strlen($newPassword) < 6) {
        header('location: update_account.php?error=Password must be at least 6 characters');
        exit();

    // Update password if all checks pass
    } else {
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        $updatePassword = $conn->prepare("UPDATE users SET user_password = ? WHERE user_email = ?");
        $updatePassword->bind_param('ss', $hashedPassword, $user_email);

        if ($updatePassword->execute()) {
            header('location: update_account.php?message=Password has been updated successfully');
            exit();
        } else {
            header('location: update_account.php?error=Could not update password');
            exit();
        }
    }
}
?>

<!-- Nav bar -->
<?php require 'header.php'; ?>
<!-- info update-->
<?php if (isset($_GET['message']) && $_GET['message'] == 'accountupdate'): ?>
    <script src="assets/sweetalert2@11.js"></script>
    <script>
        Swal.fire({
            
            icon: "success",
            title: "Info Updated!",
            showConfirmButton: false,
            timer: 1500
        });
    </script>
<?php endif; ?>
<?php if (isset($_GET['message']) && $_GET['message'] == 'Password has been updated successfully'): ?>
    <script src="assets/sweetalert2@11.js"></script>
    <script>
        Swal.fire({
            
            icon: "success",
            title: "Password has been updated successfully!",
            showConfirmButton: false,
            timer: 1500
        });
    </script>
<?php endif; ?>

<?php if (isset($_GET['error']) && $_GET['error'] == 'Could not update account information'): ?>
    <script src="assets/sweetalert2@11.js"></script>
    <script>
        Swal.fire({
            
            icon: "error",
            title: "Could not update account information!",
            showConfirmButton: false,
            timer: 1500
        });
    </script>
<?php endif; ?>

<?php if (isset($_GET['error']) && $_GET['error'] == 'Old password is incorrect'): ?>
    <script src="assets/sweetalert2@11.js"></script>
    <script>
        Swal.fire({
            
            icon: "error",
            title: "Old password is incorrect!",
            showConfirmButton: false,
            timer: 1500
        });
    </script>
<?php endif; ?>

<?php if (isset($_GET['error']) && $_GET['error'] == 'New passwords don\'t match, please try again'): ?>
    <script src="assets/sweetalert2@11.js"></script>
    <script>
        Swal.fire({
            
            icon: "error",
            title: "New passwords don't match, please try again!",
            showConfirmButton: false,
            timer: 1500
        });
    </script>
<?php endif; ?>

<?php if (isset($_GET['error']) && $_GET['error'] == 'Password must be at least 6 characters'): ?>
    <script src="assets/sweetalert2@11.js"></script>
    <script>
        Swal.fire({
            
            icon: "error",
            title: "Password must be at least 6 characters!",
            showConfirmButton: false,
            timer: 1500
        });
    </script>
<?php endif; ?>

<?php if (isset($_GET['error']) && $_GET['error'] == 'Could not update password'): ?>
    <script src="assets/sweetalert2@11.js"></script>
    <script>
        Swal.fire({
            
            icon: "error",
            title: "Could not update password!",
            showConfirmButton: false,
            timer: 1500
        });
    </script>
<?php endif; ?>

<!-- animate to show the content from the bottom -->
<div style="display: none;" id="myDiv" class="animate-bottom"> 

<!-- account info -->
<section id="update_account" class="my-4 py-4">
    <div class="row container mx-auto">

        <div class="text-center mt-3 pt-5 col-lg-6 col-md-12 col-12">
            
            <h2 class="font-weight-bold">Edit Account Info</h2>
            <hr class="mx-auto">

            <form action="update_account.php" method="POST">
                <div class="account-info">
                    <div class="form-group">
                        <label for="first_name">First Name</label>
                        <input type="text" name="first_name" class="form-control" value="<?php if(isset($_SESSION['first_name'])){ echo $_SESSION['first_name']; } ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="last_name">Last Name</label>
                        <input type="text" name="last_name" class="form-control" value="<?php if(isset($_SESSION['last_name'])){ echo $_SESSION['last_name']; } ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="user_phone">Phone</label>
                        <input type="text" name="user_phone" class="form-control" value="<?php if(isset($_SESSION['user_phone'])){ echo $_SESSION['user_phone']; } ?>" pattern="^(\+63|0)\d{10}$" maxlength="13" placeholder="e.g., 09123456789" required>
                    </div>

                    <div class="form-group">
                        <label for="user_address">Address</label>
                        <input type="text" name="user_address" class="form-control" value="<?php if(isset($_SESSION['user_address'])){ echo $_SESSION['user_address']; } ?>" placeholder="e.g., 123 purok 7 Barangay maligaya, Manila City, NCR" required>
                    </div>
                    
                    <div class="form-group mt-2">
                        <button id="buttons" type="submit" name="updateAccount" class="btn btn-primary">Update Info</button>
                    </div>
                </div>
            </form>

        </div>


        <div class="col-lg-6 col-md-12 col-12">
            <form action="update_account.php" method="POST" id="account-form">
                
                <h3>Change Password</h3>
                <hr class="mx-auto">
                
                <!-- Old Password -->
                <div class="form-group">
                    <label for="old_password">Old Password</label>
                    <div class="input-group">
                        <input type="password" class="form-control" id="old_password" name="old_password" required>
                        <div class="input-group-append">
                            <span id="eye" class="input-group-text mt-2">
                                <i id="old-eye-icon" class="fa fa-eye-slash" onclick="togglePassword('old_password', 'old-eye-icon')" style="cursor: pointer;"></i>
                            </span>
                        </div>
                    </div>
                </div>

                <!-- New Password -->
                <div class="form-group">
                    <label for="password">New Password</label>
                    <div class="input-group">
                        <input type="password" class="form-control" id="password" name="password" required>
                        <div class="input-group-append">
                            <span id="eye" class="input-group-text mt-2">
                                <i id="new-eye-icon" class="fa fa-eye-slash" onclick="togglePassword('password', 'new-eye-icon')" style="cursor: pointer;"></i>
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Confirm New Password -->
                <div class="form-group">
                    <label for="confirmPassword">Confirm New Password</label>
                    <div class="input-group">
                        <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" required>
                        <div class="input-group-append">
                            <span id="eye" class="input-group-text mt-2">
                                <i id="confirm-eye-icon" class="fa fa-eye-slash" onclick="togglePassword('confirmPassword', 'confirm-eye-icon')" style="cursor: pointer;"></i>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <input id="buttons" type="submit" class="btn btn-primary" name="changePassword" value="Change Password">
                </div>
            </form>
        </div>
</section>

<!-- footer -->
<?php require 'footer.php'; ?>

<!-- Include Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

<!-- JavaScript to Toggle Password Visibility -->
<script>
    function togglePassword(fieldId, iconId) {
        const passwordField = document.getElementById(fieldId);
        const icon = document.getElementById(iconId);
        if (passwordField.type === "password") {
            passwordField.type = "text";
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        } else {
            passwordField.type = "password";
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        }
    }
</script>