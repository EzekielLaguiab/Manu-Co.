# Manu & Co. E-commerce Website

**Manu & Co.** is a custom stone bracelet e-commerce platform that allows customers to create personalized bracelets by selecting their preferred stones and sizes. Each stone carries unique qualities, making the product both aesthetically pleasing and meaningful. Built using PHP, HTML, CSS, Bootstrap, JavaScript, and MySQL, this website offers a smooth shopping experience and customization options for users.

## Features

- **Customizable Bracelets**: Choose bracelet size and stones (Amethyst, Rose Quartz, Lapis Lazuli, and more).
- **Product Descriptions**: Each stone has detailed descriptions of its properties.
- **Responsive Design**: Accessible on various devices (mobile, tablet, desktop).
- **Shopping Cart**: Add and view selected items.
- **User Authentication**: Secure login and signup functionalities.
- **Search and Filter**: Easily browse through products and filter by stone type.

## Product Descriptions

(Stone descriptions here...)

## Tech Stack

- **Frontend**: HTML, CSS (Bootstrap), JavaScript
- **Backend**: PHP
- **Database**: MySQL

## Database Schema

The database consists of three main tables:

## 'Database'
This table stores the individual items in each order.

### `order_items`
```sql
CREATE TABLE IF NOT EXISTS `order_items` (
  `item_id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `product_id` varchar(255) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_image` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `order_date` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`item_id`)
) ENGINE=InnoDB CHARSET=latin1;

### `users`
```sql
CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(108) NOT NULL,
  `user_email` varchar(100) NOT NULL,
  `user_password` varchar(100) NOT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `UX_Constraint` (`user_email`)
) ENGINE=InnoDB CHARSET=latin1;

### `orders`
```sql
CREATE TABLE IF NOT EXISTS `orders` (
  `order_id` int(11) NOT NULL AUTO_INCREMENT,
  `order_cost` decimal(6,2) NOT NULL,
  `order_status` varchar(100) NOT NULL DEFAULT 'on_hold',
  `user_id` int(11) NOT NULL,
  `user_phone` int(11) NOT NULL,
  `user_city` varchar(255) NOT NULL,
  `user_address` varchar(255) NOT NULL,
  `order_date` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`order_id`)
) ENGINE=InnoDB CHARSET=latin1;

## Clone the repository

git clone https://github.com/EzekielLaguiab/Projects/E-commerce.git
