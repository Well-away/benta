<?php
session_start();
if(!isset($_SESSION["username"]) || $_SESSION["role"] != "client") {
    echo "<script>window.location = 'login.php'; </script>";
    exit();
}
$con = mysqli_connect("localhost", "root", "", "dbbenta");
$username = $_SESSION["username"];

// Fetch User Delivery Details
$q_user = mysqli_query($con, "select * from users where username='$username'");
$user = mysqli_fetch_array($q_user);

// Calculate Totals Before Display
$q_cart = mysqli_query($con, "select * from cart where username='$username'");
if(mysqli_num_rows($q_cart) == 0) {
    echo "<script>window.location = 'index.php'; </script>";
    exit();
}

$subtotal = 0;
while($c = mysqli_fetch_array($q_cart)) {
    $item_id = $c["item_id"];
    $q_item = mysqli_query($con, "select * from items where id=$item_id");
    $item = mysqli_fetch_array($q_item);
    $subtotal += ($item["price"] * $c["quantity"]);
}

$shipping_fee = 100;
$total_amount = $subtotal + $shipping_fee;

// Process Checkout Submission
if(isset($_POST["btnproceed"])) {
    $client_name = $user["fullname"];
    $contact = $user["contact"];
    $delivery_address = $user["address"];
    $order_date = date("Y-m-d h:i A"); 
    
    // 1. Insert Parent Transaction
    mysqli_query($con, "insert into transactions (username, client_name, contact_detail, delivery_address, total_amount, order_date, status) values('$username', '$client_name', '$contact', '$delivery_address', $total_amount, '$order_date', 'Pending')");
    
    // Get the ID of the transaction we just inserted (using LIMIT 1 sorted descending)
    $q_trans = mysqli_query($con, "select * from transactions where username='$username' order by id desc limit 1");
    $trans = mysqli_fetch_array($q_trans);
    $trans_id = $trans["id"];
    
    // 2. Loop Cart again to insert details and update items
    $q_cart_items = mysqli_query($con, "select * from cart where username='$username'");
    while($ci = mysqli_fetch_array($q_cart_items)) {
        $ci_item_id = $ci["item_id"];
        $ci_qty = $ci["quantity"];
        
        $q_item_details = mysqli_query($con, "select * from items where id=$ci_item_id");
        $i_details = mysqli_fetch_array($q_item_details);
        
        $item_name = $i_details["name"];
        $item_price = $i_details["price"];
        $item_subtotal = $item_price * $ci_qty;
        
        // Insert to transaction_details
        mysqli_query($con, "insert into transaction_details (transaction_id, item_name, item_price, item_quantity, subtotal) values($trans_id, '$item_name', $item_price, $ci_qty, $item_subtotal)");
        
        // 3. Update remaining item stock
        $new_stock = $i_details["quantity"] - $ci_qty;
        mysqli_query($con, "update items set quantity=$new_stock where id=$ci_item_id");
    }
    
    // 4. Clear the user's cart
    mysqli_query($con, "delete from cart where username='$username'");
    
    echo "<script>alert('Order Placed Successfully! Your items are pending approval.'); window.location='transactions.php'; </script>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - BENTA.PH</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="bg-primary text-white p-3 mb-4">
        <div class="container d-flex justify-content-between">
            <h4>BENTA.PH</h4>
            <div>
                <a href="index.php" class="text-white me-3">Shop</a>
                <a href="cart.php" class="text-white me-3">Cart</a>
                <a href="account.php" class="text-white me-3">My Account</a>
                <a href="about.php" class="text-white me-3">About Us</a>
                <a href="logout.php" class="text-white">Logout</a>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-md-7">
                <div class="card mb-4">
                    <div class="card-header bg-dark text-white">Delivery Information</div>
                    <div class="card-body">
                        <p><strong>Full Name:</strong> <?php echo $user["fullname"]; ?></p>
                        <p><strong>Contact Details:</strong> <?php echo $user["contact"]; ?></p>
                        <p><strong>Delivery Address:</strong> <?php echo $user["address"]; ?></p>
                        <hr>
                        <small class="text-muted">To update these details, please visit your Account page before checking out.</small>
                    </div>
                </div>
            </div>
            
            <div class="col-md-5">
                <div class="card">
                    <div class="card-header bg-success text-white">Order Summary</div>
                    <div class="card-body">
                        <h5 class="d-flex justify-content-between">
                            <span>Subtotal:</span> 
                            <span>PHP <?php echo number_format($subtotal, 2); ?></span>
                        </h5>
                        <h5 class="d-flex justify-content-between text-muted">
                            <span>Shipping Fee:</span> 
                            <span>PHP <?php echo number_format($shipping_fee, 2); ?></span>
                        </h5>
                        <hr>
                        <h3 class="d-flex justify-content-between text-success">
                            <span>Total Amount:</span> 
                            <span>PHP <?php echo number_format($total_amount, 2); ?></span>
                        </h3>
                        
                        <form method="POST" class="mt-4">
                            <input type="submit" name="btnproceed" class="btn btn-primary w-100 btn-lg" value="Place Order">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>