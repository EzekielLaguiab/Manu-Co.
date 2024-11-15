<?php 
session_start();

include '../server/connection.php';

if(isset($_GET['user_id']) && !isset($_POST['update_users'])){ // Fetch user data if user_id is set and form is not submitted for update
    $user_id = $_GET['user_id'];

    // Prepare and execute the query
    $result = $conn->prepare("SELECT * FROM users WHERE user_id = ?");
    $result->bind_param('i', $user_id);
    $result->execute();
    $users_result = $result->get_result();

    // Check if the user exists
    if($users_result->num_rows == 0){
        // If no users found, redirect
        header('location: users.php?error=User not found');
        exit();
    }
}
else if(isset($_POST['update_users'])){ // Update user details if form is submitted

    $user_id = $_POST['user_id'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $user_phone = $_POST['user_phone'];
    $user_address = $_POST['user_address'];

    // Update the user details in the database
    $result = $conn->prepare("UPDATE users SET first_name = ?, last_name = ?, user_phone = ?, user_address = ? WHERE user_id = ?");
    $result->bind_param('ssssi', $first_name, $last_name, $user_phone, $user_address, $user_id);

    if($result->execute()){
        header('Location: users.php?user_message=User updated successfully!');
        exit();
    } else {
        header('Location: users.php?error=Failed to update user! User ID: ' . $user_id);
        exit();
    }
}
?>

<?php include('header.php'); ?>

<section>
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Edit User</h4>
                    </div>

                    <div class="card-body">

                        <form action="edit_users.php?user_id=<?php echo $user_id; ?>" method="POST">

                            <?php while($row = $users_result->fetch_assoc()){ ?>

                                <div class="form-group mb-3">
                                    <b>First Name</b>
                                    <input type="hidden" name="user_id" value="<?php echo $row['user_id']; ?>">
                                    <input type="text" class="form-control" id="first_name" value="<?php echo $row['first_name'] ?>" name="first_name" required>
                                </div>
                                <div class="form-group mb-3">
                                    <b>Last Name</b>
                                    <input type="text" class="form-control" id="last_name" value="<?php echo $row['last_name']; ?>" name="last_name" required>
                                </div>
                                <div class="form-group mb-3">
                                    <b>User Email</b>
                                    <p class="form-control my-2"><?php echo $row['user_email']; ?></p>
                                </div>
                                <div class="form-group mb-3">
                                    <b>User Phone</b>
                                    <input type="text" class="form-control" id="user_phone" value="<?php echo $row['user_phone']; ?>" name="user_phone" required>
                                </div>
                                <div class="form-group mb-3">
                                    <b>Address</b>
                                    <input type="text" class="form-control" id="user_address" value="<?php echo $row['user_address']; ?>" name="user_address" required>
                                </div>
                                <div class="form-group">
                                    <a href="users.php" class="btn btn-secondary" name="back" value="Back">Back</a>
                                    <input type="submit" class="btn btn-primary" name="update_users" value="Update"/>
                                </div>

                            <?php } ?>

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include('footer.php'); ?>
