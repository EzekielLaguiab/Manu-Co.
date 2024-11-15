<?php

session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Include PHPMailer autoload
include('server/connection.php');


if (isset($_POST['forgot-password'])) {

    $email = $_POST['enter-email'];

    // Check if the email exists in the users table
    $query = "SELECT * FROM users WHERE user_email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Generate a reset code
        $reset_code = mt_rand(100000, 999999); // Six-digit code

        // Update the verification_code in the users table
        $update_query = "UPDATE users SET verification_code = ? WHERE user_email = ?";
        $update_stmt = $conn->prepare($update_query);
        $update_stmt->bind_param("ss", $reset_code, $email);
        $update_stmt->execute();

        $_SESSION['user_email'] = $email;

        // Send email using PHPMailer
        $mail = new PHPMailer(true);
        try {
        // SMTP settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // SMTP server
        $mail->SMTPAuth = true;
        $mail->Username = 'ezekiel.laguiab1998@gmail.com'; // SMTP username
        $mail->Password = 'ofihcgqchlkktowo'; // SMTP password
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        // Email content
        $mail->setFrom('ezekiel.laguiab1998@gmail.com', 'Manu\'s Craft Shop');
        $mail->addAddress($email);
        
        $mail->isHTML(true);
        $mail->Subject = 'Password Reset Request';
        $mail->Body = "Your password reset code is <b>$reset_code</b>.";

        $mail->send();
        header("Location: verify_code.php?email=" . urlencode($email));
        exit();
        
        } catch (Exception $e) {
            header('location: forgot_password.php?error=Message could not be sent');
            exit();
        }
        
    } else {
        header('location: forgot_password.php?error=emailnotfound');
        exit();
    
    }
}   

?>



<!-- Nav bar -->
<?php require 'header.php'; ?>
<?php if (isset($_GET['error']) && $_GET['error'] == 'Email not provided'): ?>
    <script src="assets/sweetalert2@11.js"></script>
    <script>
        Swal.fire({
            
            icon: "error",
            title: "Oops...",
            text: "Email not provided!",
            showConfirmButton: false,
            timer: 2000
        });
    </script>
<?php endif; ?>
<?php if (isset($_GET['error']) && $_GET['error'] == 'emailnotfound'): ?>
    <script src="assets/sweetalert2@11.js"></script>
    <script>
        Swal.fire({
            
            icon: "error",
            title: "Oops...",
            text: "Email not found!",
            showConfirmButton: false,
            timer: 2000
        });
    </script>
<?php endif; ?>
<?php if (isset($_GET['error']) && $_GET['error'] == 'Message could not be sent'): ?>
    <script src="assets/sweetalert2@11.js"></script>
    <script>
        Swal.fire({
            
            icon: "error",
            title: "Oops...",
            text: "Message could not be sent.",
            showConfirmButton: false,
            timer: 2000
        });
    </script>
<?php endif; ?>
<?php if (isset($_GET['error']) && $_GET['error'] == 'Session expired. Please request again'): ?>
    <script src="assets/sweetalert2@11.js"></script>
    <script>
        Swal.fire({
            
            icon: "info",
            title: "Session expired. Please request again!",
            showConfirmButton: false,
            timer: 2000
        });
    </script>
<?php endif; ?>
<!-- animate to show the content from the bottom -->
<div style="display: none;" id="myDiv" class="animate-bottom">

<section id="forgotpass" class="my-4 py-4">
        <div class="container text-center mt-4 py-4">
            <div>
                <h2 class="form-weight-bold">Find Your Account</h2>
                <hr class="mx-auto">
            </div>

            <div class="mx-auto container mb-5">
                <form id="fotgotpass-form" action="forgot_password.php" method="POST">                
                    <div class="form-group mb-3">
                        <label for="enter-email">Enter your email</label>
                        <input type="email" class="form-control" id="enter-email" name="enter-email" placeholder="" required>
                    </div>
                    <div class="form-group">
                        <a id="cancel-buttons" id="Cancel" href="login.php" class="btn btn-secondary">Cancel</a>
                        <button id="buttons" class="btn" name="forgot-password" type="submit">Send Code</button>
                    </div>

                </form>

            </div>
        </div>

</section>


<!-- footer -->
<?php require 'footer.php'; ?>