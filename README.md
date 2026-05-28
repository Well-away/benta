Generate the database with this code:

Step 1: Go to phpmyadmin

Step 2: Click on SQL found in the upper left side of the screen

Step 3: click raw here in github before you Copy and Paste this code:

-- Create the database
CREATE DATABASE IF NOT EXISTS dbbenta;
USE dbbenta;

-- Create the 'users' table
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` text,
  `password` text,
  `fullname` text,
  `contact` text,
  `address` text,
  `role` text,
  PRIMARY KEY (`id`)
);

-- Insert the admin account
INSERT INTO `users` (`username`, `password`, `fullname`, `contact`, `address`, `role`) 
VALUES ('admin', 'admin', 'Administrator', 'N/A', 'N/A', 'admin');

-- Create the 'categories' table
CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text,
  PRIMARY KEY (`id`)
);

-- Create the 'items' table
CREATE TABLE IF NOT EXISTS `items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text,
  `description` text,
  `price` int(11),
  `quantity` int(11),
  `image` text,
  `category` text,
  PRIMARY KEY (`id`)
);

-- Create the 'cart' table
CREATE TABLE IF NOT EXISTS `cart` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` text,
  `item_id` int(11),
  `quantity` int(11),
  PRIMARY KEY (`id`)
);

-- Create the 'transactions' table
CREATE TABLE IF NOT EXISTS `transactions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` text,
  `client_name` text,
  `total_amount` int(11),
  `delivery_address` text,
  `contact_detail` text,
  `order_date` text,
  `status` text,
  PRIMARY KEY (`id`)
);

-- Create the 'transaction_details' table
CREATE TABLE IF NOT EXISTS `transaction_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `transaction_id` int(11),
  `item_name` text,
  `item_price` int(11),
  `item_quantity` int(11),
  `subtotal` int(11),
  PRIMARY KEY (`id`)
);
