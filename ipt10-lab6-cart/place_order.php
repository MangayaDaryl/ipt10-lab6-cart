<?php
session_start();
require 'products.php'; 


if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    echo "Your cart is empty!";
    exit();
}


function generateRandomString($length = 8) {
    return substr(str_shuffle(str_repeat($x = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)))), 1, $length);
}


$order_code = generateRandomString();


$order_date = date('Y-m-d H:i:s');


$order_items = '';
$total_price = 0;

foreach ($_SESSION['cart'] as $product_id => $item) {
    $product = array_filter($products, function($p) use ($product_id) {
        return $p['id'] == $product_id;
    });
    $product = reset($product); 

    
    $order_items .= "Product ID: {$product['id']}, Product Name: {$product['name']}, Price: {$product['price']} PHP, Quantity: {$item['quantity']}\n";
    $total_price += $product['price'] * $item['quantity'];
}


$order_content = "Order Code: $order_code\n";
$order_content .= "Date and Time: $order_date\n";
$order_content .= "Order Items:\n";
$order_content .= $order_items;
$order_content .= "Total Price: $total_price PHP\n";

$file_name = "orders-$order_code.txt";
file_put_contents($file_name, $order_content);


$_SESSION['cart'] = [];


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Order Confirmation</title>
</head>
<body>
    <h1>Order Confirmation</h1>
    <p>Thank you for your order! Your order code is: <strong><?php echo $order_code; ?></strong></p>
    <p>Date and Time: <?php echo $order_date; ?></p>
    <h2>Order Summary:</h2>
    <pre><?php echo $order_items; ?></pre>
    <h3>Total Price: <?php echo $total_price; ?> PHP</h3>
</body>
</html>
