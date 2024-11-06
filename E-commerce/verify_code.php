<?php
session_start();
require 'server/connection.php';

if (!isset($_SESSION['user_email'])) {
    header('location: login.php?error=sessionexpired');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $entered_code = $_POST['reset_code'];

    // Check the reset code in the users table
    $query = "SELECT * FROM users WHERE user_email = ? AND verification_code = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $email, $entered_code);
    $stmt->execute();
    $result = $stmt->get_result();

    

    if ($result->num_rows > 0) {
        header("Location: reset_password.php?email=" . urlencode($email));

        exit();
    } else {
        header("Location: verify_code.php?error=invalid");
        exit();
    }
}

?>



<!-- Nav bar -->
<?php include('header.php') ?>
<!-- invalid code message -->
<?php if (isset($_GET['error']) && $_GET['error'] == 'invalid'): ?>
    <script src="assets/sweetalert2@11.js"></script>
    <script>
        Swal.fire({
            
            icon: "error",
            title: "Invalid or expired code.",
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
                <h2 class="form-weight-bold">Find Your Account</h2>
                <hr class="mx-auto">
            </div>

            <div class="mx-auto container mb-5">

                <!-- HTML form for verifying the reset code -->
                <form id="login-form" action="verify_code.php" method="POST">
                    <div class="form-group mb-3">
                        <!-- Check if the email parameter exists before trying to display it -->
                        <input type="hidden" name="email" value="<?php if(isset($_GET['email'])) {echo $_GET['email'];} ?>">
                        <label for="reset_code">Enter the reset code sent to your email: <?php  if(isset($_GET['email'])) {echo $_GET['email'];} ?></label>
                        <input class="form-control" type="text" max="6" id="reset_code" name="reset_code" required>
                    </div>
                    <div class="form-group">
                        <a id="cancel-buttons" href="login.php" class="btn btn-secondary">Cancel</a>
                        <button id="buttons" class="btn btn-primary" type="submit">Verify Code</button>
                    </div>
                </form>


            </div>
        </div>

     </section>


<!-- footer -->
<?php include('footer.php'); ?>