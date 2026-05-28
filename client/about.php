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
<body>
    <div class="bg-primary text-white p-3 mb-5">
        <div class="container d-flex justify-content-between align-items-center">
            <h4>BENTA.PH</h4>
            <div>
                <a href="index.php" class="text-white me-3">Shop</a>
                <a href="cart.php" class="text-white me-3">Cart</a>
                <a href="account.php" class="text-white me-3">My Account</a>
                <a href="about.php" class="text-white me-3" style="color: var(--primary-dark) !important; font-weight: 700;">About Us</a>
                <a href="logout.php" class="text-white">Logout</a>
            </div>
        </div>
    </div>

    <div class="container mb-5" style="max-width: 900px;">
        
        <div class="text-center mb-5 mt-4">
            <h1 style="font-weight: 800; font-size: 3rem; letter-spacing: -1px; color: var(--primary-dark);">Your Ultimate Online Shopping Destination.</h1>
            <p class="lead mt-3" style="color: var(--text-muted); font-size: 1.2rem;">At Benta.ph, we believe that everyone deserves access to quality products without breaking the bank.</p>
        </div>

        <div class="card p-5 mb-5" style="border-radius: var(--radius-heavy);">
            <h3 class="mb-3" style="font-weight: 700; color: var(--primary-dark);">Our Mission & Goal</h3>
            <p style="font-size: 1.1rem; line-height: 1.8; color: var(--text-main);">
                Our mission is to bring you a diverse range of affordable items that cater to your everyday needs and special occasions alike. Whether you're shopping for the latest fashion trends, home essentials, electronics, or unique gifts, Benta.ph is your go-to online store.
            </p>
            <p style="font-size: 1.1rem; line-height: 1.8; color: var(--text-main);">
                Benta.ph is committed to offering the best prices on the market without compromising on quality. We understand the importance of value for money, and our goal is to make shopping a delightful experience by providing high-quality products at prices you can afford. By sourcing directly from manufacturers and trusted suppliers, we ensure that our customers get the best deals available.
            </p>
        </div>

        <h3 class="mb-4 text-center" style="font-weight: 700; color: var(--primary-dark);">Why Shop with Benta.ph?</h3>
        <div class="row g-4 mb-5">
            <div class="col-md-6">
                <div class="card h-100 p-4">
                    <h5 style="font-weight: 700; color: var(--primary-dark);">Wide Selection</h5>
                    <p style="color: var(--text-muted); margin: 0; line-height: 1.6;">From trendy apparel and accessories to household gadgets and tech innovations, our extensive catalog has something for everyone.</p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card h-100 p-4">
                    <h5 style="font-weight: 700; color: var(--primary-dark);">Customer Satisfaction</h5>
                    <p style="color: var(--text-muted); margin: 0; line-height: 1.6;">Your satisfaction is our top priority. We strive to provide excellent customer service, fast shipping, and a hassle-free return policy.</p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card h-100 p-4">
                    <h5 style="font-weight: 700; color: var(--primary-dark);">Secure Shopping</h5>
                    <p style="color: var(--text-muted); margin: 0; line-height: 1.6;">Shop with confidence knowing that your transactions are safe and secure with our advanced encryption technology.</p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card h-100 p-4">
                    <h5 style="font-weight: 700; color: var(--primary-dark);">Community Focus</h5>
                    <p style="color: var(--text-muted); margin: 0; line-height: 1.6;">We are proud to support local businesses and artisans by featuring their products on our platform, promoting sustainable and ethical shopping practices.</p>
                </div>
            </div>
        </div>

        <div class="text-center mt-5 mb-5">
            <h4 class="mb-4" style="font-weight: 700; color: var(--primary-dark);">Join the Benta.ph family today!</h4>
            <a href="index.php" class="btn btn-primary btn-lg px-5 py-3" style="font-size: 1.1rem;">Experience Great Deals</a>
        </div>
        
    </div>
</body>
</html>