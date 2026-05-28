<?php
session_start();
if(!isset($_SESSION["username"]) || $_SESSION["role"] != "client") {
    echo "<script>window.location = 'login.php'; </script>";
    exit();
}
$con = mysqli_connect("localhost", "root", "", "dbbenta");
$username = $_SESSION["username"];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Transactions - BENTA.PH</title>
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
        <h2 class="mb-4">Transaction History</h2>
        <div class="card">
            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>Order ID</th>
                            <th>Order Date</th>
                            <th>Delivery Address</th>
                            <th>Contact</th>
                            <th>Total Amount</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Fetch user's transactions, sorted latest first
                        $q = mysqli_query($con, "select * from transactions where username='$username' order by id desc");
                        
                        if(mysqli_num_rows($q) > 0) {
                            while($r = mysqli_fetch_array($q)) {
                        ?>
                        <tr>
                            <td>#<?php echo $r["id"]; ?></td>
                            <td><?php echo $r["order_date"]; ?></td>
                            <td><?php echo $r["delivery_address"]; ?></td>
                            <td><?php echo $r["contact_detail"]; ?></td>
                            <td class="fw-bold text-success">PHP <?php echo number_format($r["total_amount"], 2); ?></td>
                            <td>
                                <?php 
                                    if($r["status"] == "Pending") echo "<span class='badge bg-warning text-dark'>Pending</span>";
                                    else if($r["status"] == "Approved") echo "<span class='badge bg-primary'>Approved</span>";
                                    else if($r["status"] == "Completed") echo "<span class='badge bg-success'>Completed</span>";
                                    else echo "<span class='badge bg-danger'>Cancelled</span>";
                                ?>
                            </td>
                            <td><a href="transaction_details.php?id=<?php echo $r["id"]; ?>" class="btn btn-sm btn-info">View Details</a></td>
                        </tr>
                        <?php
                            }
                        } else {
                            echo "<tr><td colspan='7' class='text-center'>You have no transactions yet.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>