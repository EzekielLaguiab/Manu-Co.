<?php 

session_start();

if(isset($_POST['add-to-cart'])){

    //if user already added the product to cart
    if(isset($_SESSION['cart'])){

        $products_array_ids = array_column( $_SESSION['cart'],"product_id" );

        //if product has alrady been added to cart or not
        if(!in_array(needle: $_POST['product_id'], haystack: $products_array_ids)){

            $product_id = $_POST['product_id'];
            
            $product_array = array(
                'product_id' => $_POST['product_id'],
                'product_name' => $_POST['product_name'],
                'product_image' => $_POST['product_image'],
                'product_price' => $_POST['product_price'],
                'wrist_size' => $_POST['wrist_size'],
                'product_quantity' => $_POST['product_quantity'],
            );
            
            $_SESSION['cart'][$product_id] = $product_array;

            //product has already been added
        }else{
            header("location: cart.php?message=success");
        }
         //if this is the first product
        }else{
            $product_id = $_POST['product_id'];
            $product_name = $_POST['product_name'];
            $product_image = $_POST['product_image'];
            $product_price = $_POST['product_price'];
            $wrist_size = $_POST['wrist_size'];
            $product_quantity = $_POST['product_quantity'];
            

            $product_array = array(
                'product_id' => $product_id,
                'product_name' => $product_name,
                'product_image' => $product_image,
                'product_price' => $product_price,
                'wrist_size' => $wrist_size,
                'product_quantity' => $product_quantity

                

            );
            $_SESSION['cart'][$product_id] = $product_array;

        }

    $_SESSION['add-to-cart']  =  $_POST['add-to-cart'];
    //calculate total
    calculateTotalCart();
    

}else if(isset($_POST['remove_product'])){

    $product_id = $_POST['product_id'];
    unset($_SESSION['cart'][$product_id]); 

    if (isset($_POST['remove_product'])) {
        header("location: cart.php?message=remove");
    }

    calculateTotalCart();
          
}else if(isset($_POST['edit_quantity'])){

    //we get id and quantity from the form
    $product_id = $_POST['product_id'];
    $product_quantity = $_POST['product_quantity'];

    //get the product array form the session
    $product_array = $_SESSION['cart'][$product_id];

    // update product quantity
    $product_array['product_quantity'] = $product_quantity;

    // retun array back to its place
    $_SESSION['cart'][$product_id] = $product_array;


    calculateTotalCart();


}


//calculate the total cart
function calculateTotalCart(){

    $total = 0;
    $total_quantity = 0;
    
    foreach($_SESSION['cart'] as $key => $value){
        
        $product = $_SESSION['cart'][$key];

        $price = $product["product_price"];
        $quantity = $product["product_quantity"];

        $total = $total + ($price * $quantity);

        $total_quantity = $total_quantity + $quantity;

    }

    $_SESSION['cart_total'] = $total;
    $_SESSION['total_quantity'] = $total_quantity;

}

?>

<!-- Nav bar -->
<?php include('header.php') ?>
        <!-- already added to cart -->
        <?php if (isset($_GET['message']) && $_GET['message'] == 'success'): ?>
            <script src="assets/sweetalert2@11.js"></script>
            <script>
                Swal.fire({
                    
                    icon: "info",
                    title: "Product was already added to cart",
                    confirmButtonColor: '#28a745'
                });
            </script>
        <?php endif; ?>
        <!-- log in first error -->
        <?php if (isset($_GET['msg']) && $_GET['msg'] == 'error'): ?>
            <script src="assets/sweetalert2@11.js"></script>
            <script>
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: "Log in or register first to check out!",
                    confirmButtonColor: '#28a745'
                });
            </script>
        <?php endif; ?>
        <!-- remove product-->
        <?php if (isset($_GET['message']) && $_GET['message'] == 'remove'): ?>
            <script src="assets/sweetalert2@11.js"></script>
            <script>
                Swal.fire({
                    
                    icon: "success",
                    title: "Removed Successfully!",
                    confirmButtonColor: '#28a745'
                    
                });
            </script>
        <?php endif; ?>

<!-- animate to show the content from the bottom -->
<div style="display: none;" id="myDiv" class="animate-bottom"> 

    <!-- already added  -->
     <section class="cart container my-4 py-5">
        
        <div class="mt-4">
            <h2 class="font-weight-bold">Your cart</h2>
            <hr>
        </div>

        <table class="mt-3 pt-3 mx-auto" >
            <tr>
                <th>Product</th>
                <th class="text-center">Action</th>
                <th class="text-center">Size</th>
                <th class="text-center">Quantity</th>
                <th class="text-center">Subtotal</th>
            </tr>

        <?php if(isset($_SESSION['cart']) && !empty($_SESSION['cart'])) { ?>
            <?php foreach($_SESSION['cart'] as $key => $value) { ?>
                <tr>
                    <td>
                        <div class="product-info">
                            <img src="assets/IMAGES/<?php echo $value['product_image']; ?>" alt="">
                            <div class="products-list">
                                <p><?php echo $value['product_name']; ?></p>
                                <small><span>$</span><?php echo $value['product_price']; ?></small>
                                <br>
                            </div>
                        </div>
                    </td>
                    <td class="text-center">
                        <form method="POST" action="cart.php">
                            <input type="hidden" name="product_id" value="<?php echo $value['product_id'] ?>"/>
                            <input type="submit" name="remove_product" class="remove-btn" value="Remove"/>
                        </form>
                    </td>

                    <td class="text-center">
                            <input type="hidden" name="product_id" value="<?php echo $value['product_id'] ?>" />
                            <span class=""><?php echo $value['wrist_size']?></span>
                    </td>
                    <td class="text-center">
                        <form action="cart.php" method="POST">
                            <input type="hidden" name="product_id" value="<?php echo $value['product_id'] ?>" />
                            <input type="number" name="product_quantity" min="1" value="<?php echo $value['product_quantity']; ?>"/>
                            <input type="submit" class="edit-btn" type="text" value="Edit" name="edit_quantity" />
                        </form>

                    </td>

                    <td class="text-center">
                        <span>$</span>
                        <span class="price"><?php echo $value['product_quantity'] * $value['product_price']?></span>
                    </td>
                </tr>
            <?php } ?>
        <?php } else { ?>
            <p class="text-center" >Your cart is empty! </p>
        <?php } ?>

        </table>

        <div  class="cart-total py-4 mx-auto" >
            <table>
                <tr>
                    <td class="text-center">Total amount</td>
                    <?php if(isset($_SESSION['cart_total'])) { ?>
                    <td class="text-center">$ <?php echo $_SESSION['cart_total']; ?></td>
                    <?php }?>
                </tr>
            </table>
            
        </div>

        <div class="checkout-container">
            <form method="post" action="checkout.php">
                 <input type="submit" class="btn checkout-btn" value="Checkout" name="checkout">
            </form>
            
        </div>

     </section>

      
    <!-- footer -->
    <?php include('footer.php'); ?>

