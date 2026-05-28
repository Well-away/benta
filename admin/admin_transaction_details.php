<?php
session_start();
if(!isset($_SESSION["username"]) || $_SESSION["role"] != "admin") {
    echo "<script>window.location = '../client/login.php'; </script>";
    exit();
}

if(!isset($_GET["id"])) {
    echo "<script>window.location = 'admin_transactions.php'; </script>";
    exit();
}

$con = mysqli_connect("localhost", "root", "", "dbbenta");
$id = $_GET["id"];

$q_trans = mysqli_query($con, "select * from transactions where id=$id");
$trans = mysqli_fetch_array($q_trans);

if(isset($_POST["btnapprove"])) {
    mysqli_query($con, "update transactions set status='Approved' where id=$id");
    echo "<script>alert('Transaction Approved!'); window.location='admin_transaction_details.php?id=$id'; </script>";
}
if(isset($_POST["btncomplete"])) {
    mysqli_query($con, "update transactions set status='Completed' where id=$id");
    echo "<script>alert('Transaction Completed!'); window.location='admin_transaction_details.php?id=$id'; </script>";
}
if(isset($_POST["btncancel"])) {
    mysqli_query($con, "update transactions set status='Cancelled' where id=$id");
    echo "<script>alert('Transaction Cancelled.'); window.location='admin_transaction_details.php?id=$id'; </script>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Order #<?php echo $id; ?> - Admin</title>
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
                <a href="admin_transactions.php" class="text-white me-3">Transactions</a>
                <a href="../client/logout.php" class="text-white">Logout</a>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Manage Order #<?php echo $id; ?></h2>
            <a href="admin_transactions.php" class="btn btn-secondary">Back to List</a>
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
                    <div class="card-header bg-info text-dark">Status & Actions</div>
                    <div class="card-body text-center">
                        <h5 class="mb-3">Current Status: <br>
                            <?php 
                                if($trans["status"] == "Pending") echo "<span class='badge bg-warning text-dark mt-2 fs-5'>Pending</span>";
                                else if($trans["status"] == "Approved") echo "<span class='badge bg-primary mt-2 fs-5'>Approved</span>";
                                else if($trans["status"] == "Completed") echo "<span class='badge bg-success mt-2 fs-5'>Completed</span>";
                                else echo "<span class='badge bg-danger mt-2 fs-5'>Cancelled</span>";
                            ?>
                        </h5>
                        <h3 class="text-success mb-4">Total: PHP <?php echo number_format($trans["total_amount"], 2); ?></h3>

                        <form method="POST">
                            <?php if($trans["status"] == "Pending") { ?>
                                <input type="submit" name="btnapprove" class="btn btn-primary w-100 mb-2" value="Approve Transaction">
                                <input type="submit" name="btncancel" class="btn btn-danger w-100" value="Cancel Transaction" onclick="return confirm('Are you sure you want to cancel this order?');">
                            <?php } ?>

                            <?php if($trans["status"] == "Approved") { ?>
                                <input type="submit" name="btncomplete" class="btn btn-success w-100 mb-2" value="Complete Transaction">
                                <input type="submit" name="btncancel" class="btn btn-danger w-100" value="Cancel Transaction" onclick="return confirm('Are you sure you want to cancel this order?');">
                            <?php } ?>

                            <?php if($trans["status"] == "Completed" || $trans["status"] == "Cancelled") { ?>
                                <div class="alert alert-secondary">No further actions can be taken on this order.</div>
                            <?php } ?>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>