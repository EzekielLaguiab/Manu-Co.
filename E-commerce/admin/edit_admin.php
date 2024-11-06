<?php 
session_start();

include '../server/connection.php';

if(isset($_GET['admin_id']) && !isset($_POST['update_admin'])){ // Fetch user data if admin_id is set and form is not submitted for update
    $admin_id = $_GET['admin_id'];

    // Prepare and execute the query
    $result = $conn->prepare("SELECT * FROM admins WHERE admin_id = ?");
    $result->bind_param('i', $admin_id);
    $result->execute();
    $admin_result = $result->get_result();

    // Check if the user exists
    if($admin_result->num_rows == 0){
        // If no admin found, redirect
        header('location: admin.php?error=User not found');
        exit();
    }
}
else if(isset($_POST['update_admin'])){ // Update user details if form is submitted

    $admin_id = $_POST['admin_id'];
    $admin_name = $_POST['admin_name'];

    $result = $conn->prepare("UPDATE admins SET admin_name = ? WHERE admin_id = ?");
    $result->bind_param('si', $admin_name, $admin_id);

    if($result->execute()){
        header('Location: admin.php?message=Admin updated successfully!');
        exit();
    } else {
        header('Location: admin.php?error=Failed to update user! User ID: ' . $admin_id);
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

                        <form action="edit_admin.php?admin_id=<?php echo $admin_id; ?>" method="POST">

                            <?php while($row = $admin_result->fetch_assoc()){ ?>

                                <div class="form-group mb-3">
                                    <b>Admin Name</b>
                                    <input type="hidden" name="admin_id" value="<?php echo $row['admin_id']; ?>">
                                    <input type="text" class="form-control" id="admin_name" value="<?php echo $row['admin_name'] ?>" name="admin_name" required>
                                </div>
                                <div class="form-group mb-3">
                                    <b>Password</b>
                                    <p class="form-control my-2"><?php echo $row['admin_password']; ?></p>
                                </div>
                                <div class="form-group">
                                    <a href="admin.php" class="btn btn-secondary" name="back" value="Back">Back</a>
                                    <input type="submit" class="btn btn-primary" name="update_admin" value="Update"/>
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
