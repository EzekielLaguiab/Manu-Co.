<?php
session_start();
require 'vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;

include('server/connection.php');

if (isset($_SESSION['logged_in'])) {
    header('location: account.php');
    exit;
}

if (isset($_POST['register'])) {

    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $password = $_POST['password'];
    $confirmpassword = $_POST['confirmPassword'];

    // Check if password matches and is at least 6 characters
    if ($password !== $confirmpassword) {
        header('location: register.php?error=Passwords don\'t match, please try again.');
        exit;
    } elseif (strlen($password) < 6) {
        header('location: register.php?error=Passwords must be at least 6 characters.');
        exit;
    }

    // Check if a user with this email already exists
    $result1 = $conn->prepare("SELECT count(*) FROM users WHERE user_email=?");
    $result1->bind_param('s', $email);
    $result1->execute();
    $result1->bind_result($num_rows);
    $result1->fetch();
    $result1->close();

    if ($num_rows != 0) {
        header('location: register.php?message=Email already exists');
        exit;
    }

    // If no user with this email, proceed with registration
    $verification_code = rand(100000, 999999);
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Start transaction
    $conn->begin_transaction();
    try {
        $result = $conn->prepare("INSERT INTO users (first_name, last_name, user_email, user_phone, user_address, user_password, verification_code, is_verified) 
                                   VALUES (?, ?, ?, ?, ?, ?, ?, 0)");
        $result->bind_param('sssssss', $first_name, $last_name, $email, $phone, $address, $hashed_password, $verification_code);

        if ($result->execute()) {
            if (sendVerificationEmail($email, "$first_name $last_name", $verification_code)) {
                $conn->commit(); // Commit the transaction if email is sent successfully
                $_SESSION['user_email'] = $email; // store email in session for verification
                header('location: verify_register.php');
                exit;
            } else {
                header('location: register.php?error=Failed to send verification email');
                exit;
            }
        } else {
            header('location: register.php?error=Could not create an account at the moment');
                exit;
        }
    } catch (Exception $e) {
        $conn->rollback(); // Roll back the transaction if any error occurs
        header("location: register.php?error=" . urlencode($e->getMessage()));
    } finally {
        $result->close();
    }
}

function sendVerificationEmail($recipient_email, $recipient_name, $verification_code) {
    $mail = new PHPMailer(true);
    try {
        // Configure PHPMailer with Gmail SMTP
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'ezekiel.laguiab1998@gmail.com';
        $mail->Password = 'ofihcgqchlkktowo'; // Use App Password if 2FA enabled
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Recipients
        $mail->setFrom('ezekiel.laguiab1998@gmail.com', 'Manu\'s Craft Shop');
        $mail->addAddress($recipient_email, $recipient_name);

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Email Verification Code';
        $mail->Body    = "Hello $recipient_name,<br>Your verification code is: <b>$verification_code</b>";

        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}
?>
<!-- Nav bar -->
<?php include('header.php') ?>

<?php if (isset($_GET['error']) && $_GET['error'] == 'Passwords don\'t match, please try again.'): ?>
    <script src="assets/sweetalert2@11.js"></script>
    <script>
        Swal.fire({
            
            icon: "info",
            title: "Passwords don't match, please try again.",
            showConfirmButton: false,
            timer: 2000
        });
    </script>
<?php endif; ?>

<?php if (isset($_GET['error']) && $_GET['error'] == 'Passwords must be at least 6 characters.'): ?>
    <script src="assets/sweetalert2@11.js"></script>
    <script>
        Swal.fire({
            
            icon: "info",
            title: "Passwords must be at least 6 characters.",
            showConfirmButton: false,
            timer: 2000
        });
    </script>
<?php endif; ?>


<?php if (isset($_GET['error']) && $_GET['error'] == 'Email already exists'): ?>
    <script src="assets/sweetalert2@11.js"></script>
    <script>
        Swal.fire({
            
            icon: "info",
            title: "Email already exists!",
            showConfirmButton: false,
            timer: 2000
        });
    </script>
<?php endif; ?>

<?php if (isset($_GET['error']) && $_GET['error'] == 'Failed to send verification email'): ?>
    <script src="assets/sweetalert2@11.js"></script>
    <script>
        Swal.fire({
            
            icon: "error",
            title: "Failed to send verification email!",
            showConfirmButton: false,
            timer: 2000
        });
    </script>
<?php endif; ?>

<?php if (isset($_GET['error']) && $_GET['error'] == 'Could not create an account at the moment'): ?>
    <script src="assets/sweetalert2@11.js"></script>
    <script>
        Swal.fire({
            
            icon: "info",
            title: "Could not create an account at the moment!",
            showConfirmButton: false,
            timer: 2000
        });
    </script>
<?php endif; ?>

    <!-- animate to show the content from the bottom -->
    <div style="display: none;" id="myDiv" class="animate-bottom">


    <!-- sign up -->
    <section class="my-4 py-4">
        <div class="container text-center mt-4 py-4">
            <div>
                <h2 class="form-weight-bold">Register</h2>
                <hr class="mx-auto">
            </div>

            <div class="mx-auto container">
                <form id="register-form" action="register.php" method="post">
                    <p>Note! Please make sure the information provided is correct</p>
                    <div class="form-group">
                        <label for="name">First name</label>
                        <input type="text" class="form-control" id="register-fname" name="first_name" placeholder="First name" required>
                    </div>
                    <div class="form-group">
                        <label for="name">Last name</label>
                        <input type="text" class="form-control" id="register-lname" name="last_name" placeholder="Last name" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="register-email" name="email" placeholder="Email" required>
                    </div>
                    <div class="form-group ">
                        <label for="phone">Phone Number</label>
                        <input type="tel" class="form-control" id="checkout-phone" name="phone" pattern="^(\+63|0)\d{10}$" maxlength="13" placeholder="e.g., 09123456789" required>
                    </div>
                    <div class="form-group ">
                        <label for="address">Complete Address</label>
                        <input type="text" class="form-control" id="checkout-address" name="address" placeholder="e.g., 123 purok 7 Barangay maligaya, Manila City, NCR" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="register-password" name="password" placeholder="Password" required>
                    </div>
                    <div class="form-group">
                        <label for="confirm-password">Confirm password</label>
                        <input type="password" class="form-control" id="register-confirm-password" name="confirmPassword" placeholder="Confirm password" required>
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn" id="register-btn" name="register" value="Register"/>
                    </div>
                    <div class="form-group">
                        <a id="login-url" href="login.php" class="btn">Already have an account? Log in</a>
                    </div>

                </form>

            </div>
        </div>

     </section>


    <!-- footer -->
    <?php include('footer.php'); ?>
