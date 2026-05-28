<?php
session_start();
// Security Check: Kick out if not logged in OR if not an admin
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
    <title>Category Management - Admin</title>
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
                    <div class="card-header bg-primary text-white">New Category</div>
                    <div class="card-body">
                        <form method="POST">
                            <div class="mb-3">
                                <label class="form-label">Category Name:</label>
                                <input type="text" class="form-control" name="name" required>
                            </div>
                            <input type="submit" name="btnsubmit" class="btn btn-primary" value="Save Category">
                        </form>
                        <?php
                        if(isset($_POST["btnsubmit"])){
                            $name = $_POST["name"];
                            mysqli_query($con, "insert into categories (name) values('$name')");
                            echo "<script>window.location = 'admin_categories.php'; </script>";
                        }
                        ?>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <table class="table table-bordered table-striped bg-white">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Category Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $q = mysqli_query($con, "select * from categories");
                        while($r = mysqli_fetch_array($q)) {
                        ?>
                        <tr>
                            <td><?php echo $r["id"]; ?></td>
                            <td><?php echo $r["name"]; ?></td>
                            <td><a href="admin_category_details.php?id=<?php echo $r["id"]; ?>" class="btn btn-sm btn-info">View Details</a></td>
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