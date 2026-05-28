<?php
session_start();
if(!isset($_SESSION["username"]) || $_SESSION["role"] != "client") {
    echo "<script>window.location = 'login.php'; </script>";
    exit();
}

if(!isset($_GET["id"])) {
    echo "<script>window.location = 'index.php'; </script>";
    exit();
}

$con = mysqli_connect("localhost", "root", "", "dbbenta");
$id = $_GET["id"];
$q = mysqli_query($con, "select * from items where id = $id");
$item = mysqli_fetch_array($q);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $item["name"]; ?> - BENTA.PH</title>
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

    <div class="container p-4">
        <div class="card" style="width: 50rem; margin: auto;">
            <div class="row g-0">
                <div class="col-md-5">
                    <img src="<?php echo $item["image"]; ?>" class="img-fluid rounded-start" style="height: 100%; object-fit: cover;">
                </div>
                <div class="col-md-7">
                    <div class="card-body">
                        <h3 class="card-title"><?php echo $item["name"]; ?></h3>
                        <p class="badge bg-secondary"><?php echo $item["category"]; ?></p>
                        <h4 class="text-success mt-2 mb-3">PHP <?php echo number_format($item["price"], 2); ?></h4>
                        <p class="card-text"><?php echo $item["description"]; ?></p>
                        <p class="card-text"><small class="text-muted">Available Quantity: <?php echo $item["quantity"]; ?></small></p>

                        <hr>

                        <form method="POST">
                            <div class="mb-3">
                                <label class="form-label">Order Quantity</label>
                                <input type="number" name="order_qty" class="form-control" value="1" min="1" max="<?php echo $item["quantity"]; ?>" required style="width: 100px;">
                            </div>
                            <input type="submit" name="btnaddtocart" class="btn btn-primary" value="Add to Cart">
                            <a href="index.php" class="btn btn-secondary">Back to Shop</a>
                        </form>

                        <?php
                        if(isset($_POST["btnaddtocart"])){
                            $username = $_SESSION["username"];
                            $order_qty = $_POST["order_qty"];
                            
                            mysqli_query($con, "insert into cart (username, item_id, quantity) values('$username', $id, $order_qty)");
                            
                            echo "<script>alert('Item successfully added to your cart!'); window.location='index.php'; </script>";
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>