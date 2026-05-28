<?php
session_start();
if(!isset($_SESSION["username"]) || $_SESSION["role"] != "admin") {
    echo "<script>window.location = '../client/login.php'; </script>";
    exit();
}

$con = mysqli_connect("localhost", "root", "", "dbbenta");

if(!isset($_GET["id"])) {
    echo "<script>window.location = 'admin_categories.php'; </script>";
    exit();
}

$id = $_GET["id"];
$q = mysqli_query($con, "select * from categories where id = $id");
$cat = mysqli_fetch_array($q);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Category Details - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../style.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container p-4">
        <div class="card" style="width: 35rem; margin: auto;">
            <div class="card-header bg-info text-dark">Category Details</div>
            <div class="card-body">
                <form method="POST">
                    <div class="mb-3">
                        <label class="form-label">Category Name:</label>
                        <input type="text" class="form-control" name="name" value="<?php echo $cat["name"]; ?>" required>
                    </div>
                    
                    <input type="submit" name="btnupdate" class="btn btn-primary" value="Update Record">
                    <input type="submit" name="btndelete" class="btn btn-danger" value="Delete Record">
                    
                    <?php
                    if(isset($_POST["btnupdate"])){
                        $name = $_POST["name"];
                        mysqli_query($con, "update categories set name='$name' where id=$id");
                        echo "<script>window.location = 'admin_categories.php'; </script>";
                    }
                    if(isset($_POST["btndelete"])){
                        mysqli_query($con, "delete from categories where id=$id");
                        echo "<script>window.location = 'admin_categories.php';</script>";
                    }
                    ?>
                </form>
                <br/>
                <a href="admin_categories.php" class="btn btn-secondary">Back to Categories</a>
            </div>
        </div>
    </div>
</body>
</html>