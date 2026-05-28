<?php
session_start();
if(!isset($_SESSION["username"]) || $_SESSION["role"] != "client") {
    echo "<script>window.location = 'login.php'; </script>";
    exit();
}
$con = mysqli_connect("localhost", "root", "", "dbbenta");
$username = $_SESSION["username"];

$q = mysqli_query($con, "select * from users where username='$username'");
$user = mysqli_fetch_array($q);


if(isset($_POST["btnupdate"])) {
    $contact = $_POST["contact"];
    $address = $_POST["address"];
    $password = $_POST["password"];
    
    mysqli_query($con, "update users set contact='$contact', address='$address', password='$password' where username='$username'");
    echo "<script>alert('Account details successfully updated!'); window.location='account.php'; </script>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Account - BENTA.PH</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../style.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="bg-primary text-white p-3 mb-4">
        <div class="container d-flex justify-content-between">
            <h4>BENTA.PH</h4>
            <div>
                <a href="index.php" class="text-white me-3">Shop</a>
                <a href="cart.php" class="text-white me-3">Cart</a>
                <a href="account.php" class="text-white me-3 fw-bold">My Account</a>
                <a href="about.php" class="text-white me-3">About Us</a>
                <a href="logout.php" class="text-white">Logout</a>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <div class="card mb-4">
                    <div class="card-header bg-dark text-white">Account Settings</div>
                    <div class="card-body">
                        <form method="POST">
                            <div class="mb-3">
                                <label class="form-label text-muted">Full Name (Read-Only)</label>
                                <input type="text" class="form-control" value="<?php echo $user["fullname"]; ?>" disabled>
                            </div>
                            <div class="mb-3">
                                <label class="form-label text-muted">Username (Read-Only)</label>
                                <input type="text" class="form-control" value="<?php echo $user["username"]; ?>" disabled>
                            </div>
                            <hr>
                            <div class="mb-3">
                                <label class="form-label">Contact Details</label>
                                <input type="text" class="form-control" name="contact" value="<?php echo $user["contact"]; ?>" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Delivery Address</label>
                                <input type="text" class="form-control" name="address" value="<?php echo $user["address"]; ?>" required>
                            </div>
                            <div class="mb-4">
                                <label class="form-label">Password</label>
                                <input type="text" class="form-control" name="password" value="<?php echo $user["password"]; ?>" required>
                            </div>
                            <input type="submit" name="btnupdate" class="btn btn-primary w-100" value="Update Information">
                        </form>
                    </div>
                </div>
                
                <div class="card border-primary">
                    <div class="card-body text-center">
                        <h5>Looking for your order history?</h5>
                        <p class="text-muted">View your pending, approved, and past orders.</p>
                        <a href="transactions.php" class="btn btn-outline-primary">View My Transactions</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>