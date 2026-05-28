<?php 
$con = mysqli_connect("localhost", "root", "", "dbbenta"); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - BENTA.PH</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body class="bg-light">
    <div class="container p-4">
        <div class="card" style="width: 35rem; margin: auto;">
            <div class="card-header bg-primary text-white">Create an Account</div>
            <div class="card-body">
                <form method="POST">
                    <div class="mb-3">
                        <label class="form-label">Full Name</label>
                        <input type="text" class="form-control" name="fullname" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Contact Details</label>
                        <input type="text" class="form-control" name="contact" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Delivery Address</label>
                        <input type="text" class="form-control" name="address" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <input type="text" class="form-control" name="username" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" class="form-control" name="password" required>
                    </div>
                    
                    <input type="submit" name="btnregister" class="btn btn-primary" value="Register">
                    <a href="login.php" class="btn btn-secondary">Go to Login</a>
                </form>

                <?php
                if(isset($_POST["btnregister"])){
                    $fullname = $_POST["fullname"];
                    $contact = $_POST["contact"];
                    $address = $_POST["address"];
                    $username = $_POST["username"];
                    $password = $_POST["password"];

                    mysqli_query($con, "insert into users (fullname, contact, address, username, password, role) values('$fullname', '$contact', '$address', '$username', '$password', 'client')");
                    
                    echo "<script>window.location = 'login.php'; </script>";
                }
                ?>
            </div>
        </div>
    </div>
</body>
</html>