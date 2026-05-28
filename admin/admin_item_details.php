<?php
session_start();
if(!isset($_SESSION["username"]) || $_SESSION["role"] != "admin") {
    echo "<script>window.location = '../client/login.php'; </script>";
    exit();
}

$con = mysqli_connect("localhost", "root", "", "dbbenta");

if(!isset($_GET["id"])) {
    echo "<script>window.location = 'admin_items.php'; </script>";
    exit();
}

$id = $_GET["id"];
$q = mysqli_query($con, "select * from items where id = $id");
$item = mysqli_fetch_array($q);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Item Details - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../style.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container p-4">
        <div class="card" style="width: 40rem; margin: auto;">
            <div class="card-header bg-info text-dark">Item Details</div>
            <div class="card-body">
                <div class="text-center mb-3">
                    <img src="<?php echo $item["image"]; ?>" style="width: 150px; border: 1px solid #ccc;">
                </div>
                <form method="POST">
                    <div class="mb-2">
                        <label class="form-label">Item Name</label>
                        <input type="text" class="form-control" name="name" value="<?php echo $item["name"]; ?>" required>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Category</label>
                        <select class="form-control" name="category" required>
                            <option value="<?php echo $item["category"]; ?>"><?php echo $item["category"]; ?></option>
                            </select>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Description</label>
                        <input type="text" class="form-control" name="description" value="<?php echo $item["description"]; ?>" required>
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Price</label>
                        <input type="number" class="form-control" name="price" value="<?php echo $item["price"]; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Quantity</label>
                        <input type="number" class="form-control" name="quantity" value="<?php echo $item["quantity"]; ?>" required>
                    </div>
                    
                    <input type="submit" name="btnupdate" class="btn btn-primary" value="Update Record">
                    <input type="submit" name="btndelete" class="btn btn-danger" value="Delete Record">
                    
                    <?php
                    if(isset($_POST["btnupdate"])){
                        $name = $_POST["name"];
                        $description = $_POST["description"];
                        $price = $_POST["price"];
                        $quantity = $_POST["quantity"];
                        
                        mysqli_query($con, "update items set name='$name', description='$description', price=$price, quantity=$quantity where id=$id");
                        echo "<script>window.location = 'admin_items.php'; </script>";
                    }
                    if(isset($_POST["btndelete"])){
                        mysqli_query($con, "delete from items where id=$id");
                        echo "<script>window.location = 'admin_items.php';</script>";
                    }
                    ?>
                </form>
                <br/>
                <a href="admin_items.php" class="btn btn-secondary">Back to Items</a>
            </div>
        </div>
    </div>
</body>
</html>