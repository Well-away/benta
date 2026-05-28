<?php
session_start();
if(!isset($_SESSION["username"]) || $_SESSION["role"] != "admin") {
    echo "<script>window.location = '../client/login.php'; </script>";
    exit();
}
$con = mysqli_connect("localhost", "root", "", "dbbenta");

// Fetch the number of Pending Transactions
$q_pending = mysqli_query($con, "select * from transactions where status='Pending'");
$pending_count = mysqli_num_rows($q_pending);

// Fetch the number of Approved Transactions
$q_approved = mysqli_query($con, "select * from transactions where status='Approved'");
$approved_count = mysqli_num_rows($q_approved);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Admin</title>
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
        <h2 class="mb-4">Welcome to BENTA.PH Dashboard</h2>

        <div class="row mb-4">
            <div class="col-md-6">
                <div class="card bg-warning text-dark mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Pending Transactions</h5>
                        <h1 class="display-4"><?php echo $pending_count; ?></h1>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card bg-success text-white mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Approved Transactions</h5>
                        <h1 class="display-4"><?php echo $approved_count; ?></h1>
                    </div>
                </div>
            </div>
        </div>

        <div class="card" style="width: 30rem;">
            <div class="card-header bg-primary text-white">My Account</div>
            <div class="card-body">
                <form method="POST">
                    <div class="mb-3">
                        <label class="form-label">New Password</label>
                        <input type="password" class="form-control" name="new_password" required>
                    </div>
                    <input type="submit" name="btnupdatepass" class="btn btn-primary" value="Update Password">
                </form>
                
                <?php
                if(isset($_POST["btnupdatepass"])){
                    $new_password = $_POST["new_password"];
                    $admin_user = $_SESSION["username"];
                    
                    mysqli_query($con, "update users set password='$new_password' where username='$admin_user'");
                    echo "<script>alert('Password successfully updated!'); window.location='admin_dashboard.php'; </script>";
                }
                ?>
            </div>
        </div>
    </div>
</body>
</html>