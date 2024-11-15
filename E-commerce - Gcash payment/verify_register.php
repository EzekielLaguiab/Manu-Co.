<?php
session_start();
require 'server/connection.php';

// Redirect if session email is not set
if (!isset($_SESSION['user_email'])) {
    header('location: forgot_password.php?error=Session expired. Please request again');
    exit;
}

if (isset($_POST['verify'])) {
    $email = $_SESSION['user_email'];
    $input_code = $_POST['verification_code'];

    // Prepare and execute a query to fetch verification code and status
    $stmt = $conn->prepare("SELECT verification_code, is_verified FROM users WHERE user_email = ?");
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $stmt->bind_result($stored_code, $is_verified);
    $stmt->fetch();
    $stmt->close();

    // Check if user is already verified
    if ($is_verified == 1) {
        header('location: account.php?message=Email already verified');
        exit();
    }

    // Verify if entered code matches the stored code
    if ($input_code === $stored_code) {
        // Update user's verification status
        $stmt = $conn->prepare("UPDATE users SET is_verified = 1 WHERE user_email = ?");
        $stmt->bind_param('s', $email);
        if ($stmt->execute()) {
            $stmt->close();

            // Log the user in by setting session variables
            $stmt = $conn->prepare("SELECT user_id, first_name, last_name, user_phone, user_address FROM users WHERE user_email = ?");
            $stmt->bind_param('s', $email);
            $stmt->execute();
            $stmt->bind_result($user_id, $first_name, $last_name, $phone, $address);
            $stmt->fetch();

            $_SESSION['user_id'] = $user_id;
            $_SESSION['first_name'] = $first_name;
            $_SESSION['last_name'] = $last_name;
            $_SESSION['user_email'] = $email;
            $_SESSION['user_phone'] = $phone;
            $_SESSION['user_address'] = $address;
            $_SESSION['logged_in'] = true;

            header('location: account.php?msg=register');
            exit();
        } else {
            header('location: verify_register.php?error=Verification update failed. Please try again.');
            exit();
        }
    } else {
        header('location: verify_register.php?error=Invalid verification code');
        exit();
    }
}
?>

<!-- Rest of your HTML for verification form -->


    <!-- Nav bar -->
<?php include('header.php') ?>
    
<?php if (isset($_GET['error']) && $_GET['error'] == 'Verification update failed. Please try again.'): ?>
    <script src="assets/sweetalert2@11.js"></script>
    <script>
        Swal.fire({
            
            icon: "error",
            title: "Verification update failed. Please try again.",
            showConfirmButton: false,
            timer: 2000
        });
    </script>
<?php endif; ?>

<?php if (isset($_GET['error']) && $_GET['error'] == 'Invalid verification code'): ?>
    <script src="assets/sweetalert2@11.js"></script>
    <script>
        Swal.fire({
            icon: "error",
            title: "Invalid verification code",
            showConfirmButton: false,
            timer: 2000
        });
    </script>
<?php endif; ?>

    <!-- animate to show the content from the bottom -->
    <div style="display: none;" id="myDiv" class="animate-bottom">

    <section class="my-4 py-4">
        <div class="container text-center mt-4 py-4">
            <div>
                <h2 class="form-weight-bold">Verify Email</h2>
                <hr class="mx-auto">
            </div>

            <div class="mx-auto container">
                <form id="register-form" action="verify_register.php" method="POST">

                    <div class="form-group">
                        <label for="verification_code">Enter Verification Code send to your email: <?php echo $_SESSION['user_email']  ?></label>
                        <input type="text" class="form-control" maxlength="6" name="verification_code" required>
                    </div>

                    <div class="form-group">
                        <input type="submit" name="verify" value="Verify">
                    </div>

                </form>

            </div>
        </div>

     </section>



    <!-- footer -->
    <?php include('footer.php'); ?>
