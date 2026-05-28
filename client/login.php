<?php
session_start();
$con = mysqli_connect("localhost", "root", "", "dbbenta");

if(!isset($_SESSION["username"])) {
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - BENTA.PH</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body class="bg-light">
    <div class="container p-4">
        <div class="card" style="width: 25rem; margin: auto;">
            <div class="card-header bg-primary text-white">Authentication</div>
            <div class="card-body">
                <form method="POST">
                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <input type="text" class="form-control" name="username" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" class="form-control" name="password" required>
                    </div>
                    <input type="submit" name="btnlogin" class="btn btn-primary" value="Login">
                    <a href="register.php" class="btn btn-secondary">Register</a>
                </form>

                <?php
                if(isset($_POST["btnlogin"])){
                    $username = $_POST["username"];
                    $password = $_POST["password"];

                    $q = mysqli_query($con, "select * from users where username='$username' and password='$password'");
                    $count = mysqli_num_rows($q);

                    if (!$q) {
                        die("<div class='alert alert-danger mt-3'><strong>Database Error:</strong> " . mysqli_error($con) . "</div>");
                    }


                    if($count > 0){
                        $r = mysqli_fetch_array($q);
                        
                        $_SESSION["username"] = $r["username"];
                        $_SESSION["role"] = $r["role"];

                        if($r["role"] == "admin"){
                            echo "<script>window.location = '../admin/admin_dashboard.php'; </script>";
                        } else {
                            echo "<script>window.location = 'index.php'; </script>"; 
                        }
                    } else {
                        echo "<p class='text-danger mt-2'>Invalid username or password.</p>"; 
                    }
                }
                ?>
            </div>
        </div>
    </div>
</body>
</html>
<?php
} else {
    if($_SESSION["role"] == "admin"){
        echo "<script>window.location = '../admin/admin_dashboard.php'; </script>";
    } else {
        echo "<script>window.location = 'index.php'; </script>";
    }
}
?>