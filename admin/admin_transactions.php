<?php
session_start();
if(!isset($_SESSION["username"]) || $_SESSION["role"] != "admin") {
    echo "<script>window.location = '../client/login.php'; </script>";
    exit();
}
$con = mysqli_connect("localhost", "root", "", "dbbenta");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction Management - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="bg-dark text-white p-3 mb-4">
        <div class="container d-flex justify-content-between">
            <h4>BENTA.PH Admin</h4>
            <div>
                <a href="admin_dashboard.php" class="text-white me-3">Dashboard</a>
                <a href="admin_categories.php" class="text-white me-3">Categories</a>
                <a href="admin_items.php" class="text-white me-3">Items</a>
                <a href="admin_transactions.php" class="text-white me-3 fw-bold">Transactions</a>
                <a href="../client/logout.php" class="text-white">Logout</a>
            </div>
        </div>
    </div>

    <div class="container-fluid px-4">
        <h2 class="mb-4">Master Transaction List</h2>
        <div class="card">
            <div class="card-body">
                <table class="table table-bordered table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>Order ID</th>
                            <th>Date</th>
                            <th>Client Name</th>
                            <th>Contact</th>
                            <th>Delivery Address</th>
                            <th>Total Amount</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $q = mysqli_query($con, "select * from transactions order by id desc");
                        while($r = mysqli_fetch_array($q)) {
                        ?>
                        <tr>
                            <td>#<?php echo $r["id"]; ?></td>
                            <td><?php echo $r["order_date"]; ?></td>
                            <td><?php echo $r["client_name"]; ?></td>
                            <td><?php echo $r["contact_detail"]; ?></td>
                            <td><?php echo $r["delivery_address"]; ?></td>
                            <td class="fw-bold text-success">PHP <?php echo number_format($r["total_amount"], 2); ?></td>
                            <td>
                                <?php 
                                    if($r["status"] == "Pending") echo "<span class='badge bg-warning text-dark'>Pending</span>";
                                    else if($r["status"] == "Approved") echo "<span class='badge bg-primary'>Approved</span>";
                                    else if($r["status"] == "Completed") echo "<span class='badge bg-success'>Completed</span>";
                                    else echo "<span class='badge bg-danger'>Cancelled</span>";
                                ?>
                            </td>
                            <td><a href="admin_transaction_details.php?id=<?php echo $r["id"]; ?>" class="btn btn-sm btn-info">Manage</a></td>
                        </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>