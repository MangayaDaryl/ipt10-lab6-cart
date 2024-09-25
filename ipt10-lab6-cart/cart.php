<?php
session_start();
require 'products.php'; 


if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    echo "Your cart is empty!";
    echo '<a href="index.php">Go back to shopping</a>'; 
    exit();
}

$cart = $_SESSION['cart'];
$total = 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Shopping Cart</title>
</head>
<body>
    <h1>Your Cart</h1>
    <ul>
        <?php foreach ($cart as $product_id => $item): ?>
            <?php
        
            $product = array_filter($products, function($p) use ($product_id) {
                return $p['id'] == $product_id;
            });
            $product = reset($product); 

        
            if ($product === false) {
                echo "<li>Product not found!</li>";
                continue; 
            }
            ?>
            <li>
                <?php echo $product['name']; ?> - <?php echo $product['price']; ?> PHP (Quantity: <?php echo $item['quantity']; ?>)
            </li>
            <?php
          
            $total += $product['price'] * $item['quantity'];
            ?>
        <?php endforeach; ?>
    </ul>

    <h2>Total: <?php echo $total; ?> PHP</h2>

    <a href="reset-cart.php">Clear my cart</a>
    <a href="place_order.php">Place the order</a>
</body>
</html>
