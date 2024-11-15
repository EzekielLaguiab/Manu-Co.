<?php

session_start();
include('server/connection.php');

if(isset($_SESSION['logged_in'])){
    header('location: account.php');
    exit;
}

if(isset($_POST['login'])){
    $email = $_POST['email'];
    $password = $_POST['password']; // Plain password from form input

    // Query to get the user's hashed password and verification status
    $result = $conn->prepare("SELECT user_id, first_name, last_name, user_email, user_phone, user_address, user_password, is_verified FROM users WHERE user_email = ? LIMIT 1");
    $result->bind_param('s', $email);
    
    if($result->execute()){
        $result->bind_result($user_id, $first_name, $last_name, $user_email, $user_phone, $user_address,  $user_password, $is_verified); // Bind is_verified too
        $result->store_result();

        if($result->num_rows() == 1){
            $result->fetch();

            // Verify the password using password_verify()
            if(password_verify($password, $user_password)){
                if($is_verified == 1){ // Check if the account is verified
                    $_SESSION['user_id'] = $user_id;
                    $_SESSION['first_name'] = $first_name;
                    $_SESSION['last_name'] = $last_name;
                    $_SESSION['user_email'] = $user_email;
                    $_SESSION['user_phone'] = $user_phone;
                    $_SESSION['user_address'] = $user_address;
                    $_SESSION['logged_in'] = true;
                    header('location: account.php?message=success');
                } else {
                    header('location: login.php?message=verify');
                    exit();
                }
            } else {
                header('location: login.php?error=invalid');
                exit();
            }
        } else {
            header('location: login.php?error=notfound');
            exit();
        }

    } else {
        // Error handling for failed SQL query
        header('location: login.php?error=wentwrong');
        exit();
    }
}
?>

    <!-- Nav bar -->
    <?php include('header.php') ?>
    
                <!-- email not found -->
                <?php if (isset($_GET['error']) && $_GET['error'] == 'notfound'): ?>
                    <script src="assets/sweetalert2@11.js"></script>
                    <script>
                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: "Email not found, please register first!",
                            showConfirmButton: false,
                            timer: 2000
                        });
                    </script>
                <?php endif; ?>

                <!-- invalid email or password -->
                <?php if (isset($_GET['error']) && $_GET['error'] == 'invalid'): ?>
                    <script src="assets/sweetalert2@11.js"></script>
                    <script>
                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: "Wrong Email or Password!",
                            showConfirmButton: false,
                            timer: 2000
                        });
                    </script>
                <?php endif; ?>
                
                <!-- verify -->
                <?php if (isset($_GET['message']) && $_GET['message'] == 'verify'): ?>
                    <script src="assets/sweetalert2@11.js"></script>
                    <script>
                        Swal.fire({
                            icon: "info",
                            title: "Please verify your email before logging in",
                            html: 'Click <a href="verify_register.php" target="_blank" style="color:green; text-decoration: underline;">here</a> to proceed.',
                            showConfirmButton: true,
                            showConfirmButtonText: 'Ok',
                            confirmButtonColor: '#28a745'
                        });
                    </script>
                    <a href="verify_register.php" type="button">Click here to verify account</a>
                <?php endif; ?>
                
                <!-- went wrong -->
                <?php if (isset($_GET['error']) && $_GET['error'] == 'wentwrong'): ?>
                    <script src="assets/sweetalert2@11.js"></script>
                    <script>
                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: "Something went wrong, please try again later",
                            showConfirmButton: false,
                            timer: 2000
                        });
                    </script>
                <?php endif; ?>
                
                <!-- forgot updated password -->
                <?php if (isset($_GET['message_update']) && $_GET['message_update'] == 'passwordUpdate'): ?>
                    <script src="assets/sweetalert2@11.js"></script>
                    <script>
                        Swal.fire({
                            icon: "success",
                            title: "Password reset successfully!",
                            showConfirmButton: false,
                            timer: 2000
                        });
                    </script>
                <?php endif; ?>

                <?php if (isset($_GET['error']) && $_GET['error'] == 'sessionexpired'): ?>
                    <script src="assets/sweetalert2@11.js"></script>
                    <script>
                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: "Session expired. Please request again!",
                            showConfirmButton: false,
                            timer: 2000
                        });
                    </script>
                <?php endif; ?>
    
     <!-- animate to show the content from the bottom -->
     <div style="display: none;" id="myDiv" class="animate-bottom">

    <!-- login -->
     <section id="login" class="my-4 py-4">
        <div class="container text-center mt-4 py-4">
            <div>
                <h2 class="form-weight-bold">Log in</h2>
                <hr class="mx-auto">
            </div>

            <div class="mx-auto container mb-5">
                <form id="login-form" action="login.php" method="POST">
                    <div class="form-group mb-3">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="login-email" name="email" placeholder="Email" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="login-password" name="password" placeholder="Password" required>
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn" id="login-btn" name="login" value="Login"/>
                    </div>
                    <div class="form-group">
                        <a id="register-url" href="register.php" class="btn">Don't have an account? Register</a>
                    </div>
                    <div class="form-group">
                        <a id="forgot-pass-url" href="forgot_password.php" class="btn">Forgot password?</a>
                    </div>

                </form>

            </div>
        </div>

     </section>


    <!-- footer -->
    <?php include('footer.php'); ?>
        
