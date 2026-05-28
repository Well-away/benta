<?php
session_start();
// Security Check: Must be logged in as a client
if(!isset($_SESSION["username"]) || $_SESSION["role"] != "client") {
    echo "<script>window.location = 'login.php'; </script>";
    exit();
}
$con = mysqli_connect("localhost", "root", "", "dbbenta"); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop - BENTA.PH</title>
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
                <a href="account.php" class="text-white me-3">My Account</a>
                <a href="about.php" class="text-white me-3">About Us</a>
                <a href="logout.php" class="text-white">Logout</a>
            </div>
        </div>
    </div>

    <div class="container">
        <h2 class="mb-4">All Items</h2>
        <div class="row">
            <?php
            // Fetch items alphabetically as requested in the scope
            $q = mysqli_query($con, "select * from items order by name asc");
            while($r = mysqli_fetch_array($q)) {
            ?>
            <div class="col-md-3 mb-4">
                <div class="card h-100">
                    <img src="<?php echo $r["image"]; ?>" class="card-img-top" style="height: 200px; object-fit: cover;" alt="Item Image">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $r["name"]; ?></h5>
                        <p class="text-success fw-bold">PHP <?php echo number_format($r["price"], 2); ?></p>
                        
                        <?php if($r["quantity"] > 0) { ?>
                            <p class="text-muted">Available: <?php echo $r["quantity"]; ?></p>
                            <a href="item_details.php?id=<?php echo $r["id"]; ?>" class="btn btn-outline-primary w-100">View Details</a>
                        <?php } else { ?>
                            <p class="text-danger fw-bold">Sold Out</p>
                            <button class="btn btn-secondary w-100" disabled>Sold Out</button>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <?php
            }
            ?>
        </div>
    </div>
</body>
</html>