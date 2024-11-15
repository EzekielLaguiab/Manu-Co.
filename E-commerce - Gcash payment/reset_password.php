<?php
session_start();
require 'server/connection.php';

if (!isset($_SESSION['user_email'])) {
    header('location: login.php?error=sessionexpired');
    exit;
}

if (isset($_POST['reset_pass'])) {
    // Email should be set from the GET parameters
    $email = isset($_POST['email']) ? $_POST['email'] : null;
    $new_password = $_POST['new_password'];
    
    if (!$email) {
        header('location: forgot_password.php?error=Email not provided');
        exit();
    }

    $hashedPassword = password_hash($new_password, PASSWORD_DEFAULT);

    // Update the password in the users table and clear the verification code
    $stmt = $conn->prepare("UPDATE users SET user_password = ?, verification_code = NULL WHERE user_email = ?");
    $stmt->bind_param("ss", $hashedPassword, $email);

    if ($stmt->execute()) {
        header('location: login.php?message_update=passwordUpdate');
        exit();
    } else {
        header('location: reset_password.php?error=notreset');
        exit();
    }
}
?>



<!-- Nav bar -->
<?php include('header.php') ?>

<!-- not reset -->
<?php if (isset($_GET['error']) && $_GET['error'] == 'notreset'): ?>
    <script src="assets/sweetalert2@11.js"></script>
    <script>
        Swal.fire({
            
            icon: "error",
            title: "Could not reset password.",
            showConfirmButton: false,
            timer: 2000
        });
    </script>
<?php endif; ?>
<?php if (isset($_GET['error']) && $_GET['error'] == 'Email not provided'): ?>
    <script src="assets/sweetalert2@11.js"></script>
    <script>
        Swal.fire({
            
            icon: "error",
            title: "Email not provided!",
            showConfirmButton: false,
            timer: 2000
        });
    </script>
<?php endif; ?>

<div style="display: none;" id="myDiv" class="animate-bottom">

    <section class="my-4 py-4">
        <div class="container text-center mt-4 py-4">
            <div>
                <h2 class="form-weight-bold">Find Your Account</h2>
                <hr class="mx-auto">
            </div>

            <div class="mx-auto container mb-5">
                <form id="login-form" action="reset_password.php" method="POST">
                    <p style="color:green;">Code verified!</p>
                    <div class="form-group mb-3">
                        <input type="hidden" name="email"  value="<?php if(isset($_GET['email'])) {echo $_GET['email']; } ?>">
                        <label for="new_password">New Password:</label>
                        <input class="form-control" type="password" id="new_password" name="new_password" required>
                    </div>
                    <div class="form-group">
                        <a id="Cancel" href="login.php" class="btn btn-secondary">Cancel</a>
                        <button id="buttons" class="btn" name="reset_pass" type="submit">Confirm</button>
                    </div>

                </form>

            </div>
        </div>

     </sect>


<!-- footer -->
<?php include('footer.php'); ?>