Generate the database with this code:

Step 1: Go to phpmyadmin

Step 2: Click on SQL found in the upper left side of the screen

Step 3: Copy and Paste this code:

-- 1. Create the database
CREATE DATABASE IF NOT EXISTS dbbenta;
USE dbbenta;

-- 2. Create the 'users' table
-- Used in login.php, register.php, account.php, and admin_dashboard.php
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    fullname VARCHAR(255) NOT NULL,
    contact VARCHAR(100) NOT NULL,
    address TEXT NOT NULL,
    username VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role VARCHAR(50) NOT NULL DEFAULT 'client'
);

-- Insert a default Admin account (Username: admin, Password: password123)
INSERT INTO users (fullname, contact, address, username, password, role) 
VALUES ('System Administrator', 'N/A', 'N/A', 'admin', 'password123', 'admin');

-- 3. Create the 'categories' table
-- Used in admin_categories.php
CREATE TABLE IF NOT EXISTS categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL
);

-- 4. Create the 'items' table
-- Used in admin_items.php, index.php, item_details.php
CREATE TABLE IF NOT EXISTS items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    quantity INT NOT NULL,
    image VARCHAR(255) NOT NULL,
    category VARCHAR(100) NOT NULL
);

-- 5. Create the 'cart' table
-- Used in cart.php and checkout.php
CREATE TABLE IF NOT EXISTS cart (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL,
    item_id INT NOT NULL,
    quantity INT NOT NULL
);

-- 6. Create the 'transactions' table
-- Used in checkout.php, transactions.php, admin_transactions.php
CREATE TABLE IF NOT EXISTS transactions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL,
    client_name VARCHAR(255) NOT NULL,
    contact_detail VARCHAR(100) NOT NULL,
    delivery_address TEXT NOT NULL,
    total_amount DECIMAL(10,2) NOT NULL,
    order_date VARCHAR(100) NOT NULL, -- Stored as a string in PHP via date("Y-m-d h:i A")
    status VARCHAR(50) NOT NULL DEFAULT 'Pending'
);

-- 7. Create the 'transaction_details' table
-- Used in checkout.php and transaction_details.php to store individual items per order
CREATE TABLE IF NOT EXISTS transaction_details (
    id INT AUTO_INCREMENT PRIMARY KEY,
    transaction_id INT NOT NULL,
    item_name VARCHAR(255) NOT NULL,
    item_price DECIMAL(10,2) NOT NULL,
    item_quantity INT NOT NULL,
    subtotal DECIMAL(10,2) NOT NULL
);
