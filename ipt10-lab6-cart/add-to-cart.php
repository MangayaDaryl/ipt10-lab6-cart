<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['product_id'])) {
    $product_id = $_POST['product_id'];

    
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }


    if (!isset($_SESSION['cart'][$product_id])) {
       
        $_SESSION['cart'][$product_id] = [
            'quantity' => 1
        ];
    } else {
       
        $_SESSION['cart'][$product_id]['quantity']++;
    }
}


header('Location: cart.php');
exit(); 
