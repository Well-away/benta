<?php
session_start();
if(!isset($_SESSION["username"]) || $_SESSION["role"] != "client") {
    echo "<script>window.location = 'login.php'; </script>";
    exit();
}

// Trap missing ID
if(!isset($_GET["id"])) {
    echo "<script>window.location = 'transactions.php'; </script>";
    exit();
}

$con = mysqli_connect("localhost", "root", "", "dbbenta");
$id = $_GET["id"];
$username = $_SESSION["username"];

// Fetch Parent Transaction (And ensure it belongs to the logged-in user for security)
$q_trans = mysqli_query($con, "select * from transactions where id=$id and username='$username'");
if(mysqli_num_rows($q_trans) == 0) {
    echo "<script>window.location = 'transactions.php'; </script>";
    exit();
}
$trans = mysqli_fetch_array($q_trans);

// Process Cancellation
if(isset($_POST["btncancel"])) {
    mysqli_query($con, "update transactions set status='Cancelled' where id=$id");
    echo "<script>alert('Your transaction has been cancelled.'); window.location='transactions.php'; </script>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Details #<?php echo $id; ?> - BENTA.PH</title>
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
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Order Details #<?php echo $id; ?></h2>
            <a href="transactions.php" class="btn btn-secondary">Back to Transactions</a>
        </div>

        <div class="row">
            <div class="col-md-8">
                <div class="card mb-4">
                    <div class="card-header bg-dark text-white">Purchased Items</div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th>Item Name</th>
                                    <th>Price</th>
                                    <th>Qty</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $q_items = mysqli_query($con, "select * from transaction_details where transaction_id=$id");
                                while($item = mysqli_fetch_array($q_items)) {
                                ?>
                                <tr>
                                    <td><?php echo $item["item_name"]; ?></td>
                                    <td>PHP <?php echo number_format($item["item_price"], 2); ?></td>
                                    <td><?php echo $item["item_quantity"]; ?></td>
                                    <td class="fw-bold">PHP <?php echo number_format($item["subtotal"], 2); ?></td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-header bg-info text-dark">Order Summary</div>
                    <div class="card-body">
                        <p><strong>Status:</strong> <?php echo $trans["status"]; ?></p>
                        <p><strong>Date:</strong> <?php echo $trans["order_date"]; ?></p>
                        <hr>
                        <p><strong>Deliver To:</strong><br> <?php echo $trans["client_name"]; ?><br> <?php echo $trans["contact_detail"]; ?><br> <?php echo $trans["delivery_address"]; ?></p>
                        <hr>
                        <h4 class="text-success">Total: PHP <?php echo number_format($trans["total_amount"], 2); ?></h4>
                        
                        <?php if($trans["status"] == "Pending" || $trans["status"] == "Approved") { ?>
                        <form method="POST" class="mt-3">
                            <input type="submit" name="btncancel" class="btn btn-danger w-100" value="Cancel Transaction" onclick="return confirm('Are you sure you want to cancel this order?');">
                        </form>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>