<?php

session_start();

include 'server/connection.php';
$statusMessage = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    // Capture and sanitize form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $statusMessage = "Invalid email format. Please enter a valid email.";
    } else {
        // If email is valid, proceed to store the data in the database
        $sql = "INSERT INTO messages (name, email, subject, message) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $name, $email, $subject, $message);

        if ($stmt->execute()) {
            $statusMessage = "Thank you for reaching out! We will get back to you shortly.";
        } else {
            $statusMessage = "Sorry, there was an error. Please try again.";
        }

        $stmt->close();
    }
}

$conn->close();


?>

    <!-- Nav bar -->
    <?php include('header.php') ?>
    <!-- animate to show the content from the bottom -->
    <div style="display: none;" id="myDiv" class="animate-bottom">

    <section id="contacts" class="my-5 py-5">
        
        <div class="container text-center">
            <h2 class="form-weight-bold">Connect with Us</h2>
            <p>Feel free to reach out for any questions or inquiries!</p>
            <hr class="mx-auto">

            <div class="mx-auto container mb-5">
                <form  id="contact-form" action="contact.php" method="POST">

                <?php if (isset($statusMessage)) { echo "<p>$statusMessage</p>"; } ?>

                    <div class="form-group mb-3">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="subject">Subject</label>
                        <input type="text" class="form-control" id="subject" name="subject" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="message">Message</label>
                        <textarea id="message" name="message" class="form-control" rows="5"required></textarea>
                        
                    </div>
                    <div class="form-group mb-3 ">
                        <button  type="submit" id="contact-btn" name="submit">Send Message</button>
                    </div>
                    
                </form>
            </div>

            
        </div>
    </section>

    <!-- footer -->
    <?php include('footer.php'); ?>
        
