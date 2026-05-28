<?php
session_start();
if(!isset($_SESSION["username"]) || $_SESSION["role"] != "client") {
    echo "<script>window.location = 'login.php'; </script>";
    exit();
}
$con = mysqli_connect("localhost", "root", "", "dbbenta");
$username = $_SESSION["username"];

if(isset($_GET["remove_id"])){
    $remove_id = $_GET["remove_id"];
    mysqli_query($con, "delete from cart where id = $remove_id");
    echo "<script>window.location = 'cart.php';</script>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Cart - BENTA.PH</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../style.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="bg-primary text-white p-3 mb-4">
        <div class="container d-flex justify-content-between">
            <h4>BENTA.PH</h4>
            <div>
                <a href="index.php" class="text-white me-3">Shop</a>
                <a href="cart.php" class="text-white me-3 fw-bold">Cart</a>
                <a href="account.php" class="text-white me-3">My Account</a>
                <a href="about.php" class="text-white me-3">About Us</a>
                <a href="logout.php" class="text-white">Logout</a>
            </div>
        </div>
    </div>

    <div class="container">
        <h2 class="mb-4">Shopping Cart</h2>
        <div class="card">
            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>Image</th>
                            <th>Item Name</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Subtotal</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $q_cart = mysqli_query($con, "select * from cart where username='$username'");
                        $cart_count = mysqli_num_rows($q_cart);
                        $overall_subtotal = 0;

                        if($cart_count > 0) {
                            while($c = mysqli_fetch_array($q_cart)) {
                                $item_id = $c["item_id"];
                                
                                // Nested query to get item details based on the cart's item_id
                                $q_item = mysqli_query($con, "select * from items where id=$item_id");
                                $item = mysqli_fetch_array($q_item);
                                
                                $row_subtotal = $item["price"] * $c["quantity"];
                                $overall_subtotal += $row_subtotal;
                        ?>
                        <tr>
                            <td><img src="<?php echo $item["image"]; ?>" style="width: 50px;"></td>
                            <td><?php echo $item["name"]; ?></td>
                            <td>PHP <?php echo number_format($item["price"], 2); ?></td>
                            <td><?php echo $c["quantity"]; ?></td>
                            <td class="fw-bold">PHP <?php echo number_format($row_subtotal, 2); ?></td>
                            <td><a href="cart.php?remove_id=<?php echo $c["id"]; ?>" class="btn btn-sm btn-danger">Remove</a></td>
                        </tr>
                        <?php
                            }
                        } else {
                            echo "<tr><td colspan='6' class='text-center'>Your cart is empty.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
                
                <?php if($cart_count > 0) { ?>
                <div class="text-end mt-3">
                    <h4>Total Items Subtotal: <span class="text-success">PHP <?php echo number_format($overall_subtotal, 2); ?></span></h4>
                    <a href="checkout.php" class="btn btn-success btn-lg mt-2">Proceed to Checkout</a>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
</body>
</html>