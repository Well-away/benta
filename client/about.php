<?php
session_start();
if(!isset($_SESSION["username"]) || $_SESSION["role"] != "client") {
    echo "<script>window.location = 'login.php'; </script>";
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - BENTA.PH</title>
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
                <a href="about.php" class="text-white me-3 fw-bold">About Us</a>
                <a href="logout.php" class="text-white">Logout</a>
            </div>
        </div>
    </div>

    <div class="container mb-5">
        <div class="card shadow-sm p-4">
            <h2 class="text-primary mb-4 text-center">Welcome to Benta.ph - Your Ultimate Online Shopping Destination!</h2>
            
            <p class="fs-5">At Benta.ph, we believe that everyone deserves access to quality products without breaking the bank. Our mission is to bring you a diverse range of affordable items that cater to your everyday needs and special occasions alike. Whether you're shopping for the latest fashion trends, home essentials, electronics, or unique gifts, Benta.ph is your go-to online store.</p>
            
            <h4 class="mt-4 text-dark">Our Goal: Affordability Meets Quality</h4>
            <p>Benta.ph is committed to offering the best prices on the market without compromising on quality. We understand the importance of value for money, and our goal is to make shopping a delightful experience by providing high-quality products at prices you can afford. By sourcing directly from manufacturers and trusted suppliers, we ensure that our customers get the best deals available.</p>
            
            <h4 class="mt-4 text-dark">Why Shop with Benta.ph?</h4>
            <ul class="list-group list-group-flush mb-4">
                <li class="list-group-item bg-transparent"><strong>Wide Selection:</strong> From trendy apparel and accessories to household gadgets and tech innovations, our extensive catalog has something for everyone.</li>
                <li class="list-group-item bg-transparent"><strong>Customer Satisfaction:</strong> Your satisfaction is our top priority. We strive to provide excellent customer service, fast shipping, and a hassle-free return policy.</li>
                <li class="list-group-item bg-transparent"><strong>Secure Shopping:</strong> Shop with confidence knowing that your transactions are safe and secure with our advanced encryption technology.</li>
                <li class="list-group-item bg-transparent"><strong>Community Focus:</strong> We are proud to support local businesses and artisans by featuring their products on our platform, promoting sustainable and ethical shopping practices.</li>
            </ul>
            
            <div class="alert alert-primary text-center fw-bold fs-5" role="alert">
                Join the Benta.ph family today and experience the joy of finding great deals on the products you love. Happy shopping!
            </div>
        </div>
    </div>
</body>
</html>