<?php
session_start();
require 'server/connection.php';

if (!isset($_SESSION['logged_in'])) {
    header('location: login.php');
    exit;
}
// Handle logout
if (isset($_GET['logout'])){
    if(isset($_SESSION['logged_in'])){
        unset($_SESSION['logged_in']);
        unset($_SESSION['user_email']);
        unset($_SESSION['first_name']);
        unset($_SESSION['last_name']);
        header('location: login.php');
        exit;
    }
}

// if(isset($_SESSION['logged_in'])){
//     $user_id = $_SESSION['user_id'];

//     $result = $conn->prepare("SELECT * FROM users WHERE user_id = ?");
//     $result->bind_param('i', $user_id,);
//     $result->execute();
//     $addresses = $result->get_result();

//     if($addresses->num_rows == 0){
        
//         header('location: acc.php?error=addresses not found');
//         exit();
//     }
// }
?>

<style>
    #acc {
        display: flex;
        background-color: #f9f9f9;
        border-radius: 10px;
        box-shadow: 0 4px 8px var(--main-color);
        padding: 10px;
        flex-wrap: wrap;
    }

    aside {
        
        width: 150px;
        padding: 10px;
        height: auto;
        border-right: 1px solid #2E7D32;
    }

    aside a {
        display: block;
        color: #333;
        text-decoration: none;
        padding: 10px 0;
        cursor: pointer;
    }

    aside a:hover {
        background-color: #4CAF50;
        color: white;
    }

    .content {
        flex: 1;
        padding: 20px;
    }

    /* Responsive styles */
    @media (max-width: 768px) {
        #acc {
            flex-direction: column;
        }

        aside {
            width: 100%;
            border-right: none;
            display: flex;
            justify-content: center;
            gap: 10px;
        }

        aside a {
            width: 100%;
            text-align: center;
            padding: 10px;
            background-color: #f9f9f9;
            border: 1px solid #2E7D32;
            border-radius: 5px;
        }
    }
</style>

<!-- Nav bar/ header-->
<?php include('header.php') ?>



<!-- animate to show the content from the bottom -->
<div style="display: none;" id="myDiv" class="animate-bottom">

<!-- orders details -->
<section id="Address" class="container my-5 py-5">


    <div id="acc" class="container">
    <aside>
        <a href="acc.php?param=value#Dashboard">Dashboard</a>
        <a href="acc.php?param=value#Account">Account</a>
        <a href="acc.php?param=value#Orders">Orders</a>
        <a href="acc.php?param=value#Address">Address</a>
        <a href="acc.php?logout=1" onclick="confirmLogout(event)" id="logout-btn">Logout</a>
    </aside> 

    <div class="content">

        <h2 class="font-weight-bold">Update Address</h2>
        <hr>
                    <form action="update_account.php" method="POST">
                        

                            <!-- Province / State Dropdown -->
                            <div class="form-group mt-2">
                                <label for="province">State / Province <span style="color: red;">*</span></label>
                                <select id="province" name="province" class="form-control" required onchange="populateCities()">
                                    <option value="">Select Province</option>
                                </select>
                            </div>

                            <!-- City / Municipality Dropdown -->
                            <div class="form-group mt-2">
                                <label for="city">Town / City <span style="color: red;">*</span></label>
                                <select id="city" name="city" class="form-control" required onchange="populateBarangays()">
                                    <option value="">Select Town / City</option>
                                </select>
                            </div>

                            <!-- Barangay Dropdown -->
                            <div class="form-group mt-2">
                                <label for="Barangay">Barangay <span style="color: red;">*</span></label>
                                <select id="Barangay" name="barangay" class="form-control" required>
                                    <option value="">Select Barangay</option>
                                </select>
                            </div>


                            <div class="form-group mt-2">
                                <label for="street">Street address <span style="color: red;">*</span></label>
                                <input type="text" id="street" name="street" class="form-control" required placeholder="Steet address">
                            </div>
                            
                            <div class="form-group mt-2">
                                <label for="apartment">Apartment, suite, unit, etc. (optional)</label>
                                <input type="text" id="apartment" class="form-control" name="apartment" placeholder="Apartment, suite, unit, etc.">
                            </div>

                            <div class="form-group mt-2">
                                <label for="postcode">Postcode / ZIP <span style="color: red;">*</span></label>
                                <input type="text" id="postcode" class="form-control" name="postcode" required placeholder="Postcode or ZIP">
                            </div>
                            
                            <button type="submit" name="update_address" class="btn btn-success mt-2">Update</button>
                        
                    </form>


     </div>            
     
</section>

<script src="assets/script.js"></script>
<!-- footer -->
<?php include('footer.php'); ?>

<script src="assets/sweetalert2@11.js"></script>

<script>
    // sweetalert for delete admin
    function confirmLogout(event){
        event.preventDefault();

        Swal.fire({
            title: "Are you sure?",
            text: "You will be logged out!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, log out!"
        }).then((result) => {
            if (result.isConfirmed){
                window.location.href = 'acc.php?logout=1';
            }
        });
    }
</script>

