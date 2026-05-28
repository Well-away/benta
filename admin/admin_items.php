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
    <title>Item Management - Admin</title>
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
                <a href="../client/logout.php" class="text-white">Logout</a>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">Add New Item</div>
                    <div class="card-body">
                        <form method="POST" enctype="multipart/form-data">
                            <div class="mb-2">
                                <label class="form-label">Item Name</label>
                                <input type="text" class="form-control" name="name" required>
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Category</label>
                                <select class="form-control" name="category" required>
                                    <option value="" disabled selected>Select Category</option>
                                    <?php
                                    $cat_query = mysqli_query($con, "select * from categories");
                                    while($cat = mysqli_fetch_array($cat_query)){
                                        echo "<option>".$cat["name"]."</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Description</label>
                                <input type="text" class="form-control" name="description" required>
                            </div>
                            <div class="mb-2">
                                <label class="form-label">Price</label>
                                <input type="number" class="form-control" name="price" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Quantity</label>
                                <input type="number" class="form-control" name="quantity" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Image</label>
                                <input type="file" class="form-control" name="image" required>
                            </div>
                            <input type="submit" name="btnsubmit" class="btn btn-primary w-100" value="Add Item">
                        </form>

                        <?php
                        if(isset($_POST["btnsubmit"])){
                            $name = $_POST["name"];
                            $category = $_POST["category"];
                            $description = $_POST["description"];
                            $price = $_POST["price"];
                            $quantity = $_POST["quantity"];
                            
                            // Image upload logic pointing to your media folder
                            $image = "../media/".basename($_FILES["image"]["name"]);
                            
                            if (move_uploaded_file($_FILES["image"]["tmp_name"], $image)) {
                                mysqli_query($con, "insert into items (name, description, price, quantity, image, category) values('$name', '$description', $price, $quantity, '$image', '$category')");
                                echo "<script>window.location='admin_items.php'; </script>";
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <table class="table table-bordered table-striped bg-white">
                    <thead class="table-dark">
                        <tr>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Qty</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $q = mysqli_query($con, "select * from items");
                        while($r = mysqli_fetch_array($q)) {
                        ?>
                        <tr>
                            <td><img src="<?php echo $r["image"]; ?>" style="width: 50px;"></td>
                            <td><?php echo $r["name"]; ?></td>
                            <td><?php echo $r["category"]; ?></td>
                            <td>PHP <?php echo number_format($r["price"], 2); ?></td>
                            <td><?php echo $r["quantity"]; ?></td>
                            <td><a href="admin_item_details.php?id=<?php echo $r["id"]; ?>" class="btn btn-sm btn-info">View Details</a></td>
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