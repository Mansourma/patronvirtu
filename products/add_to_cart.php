<?php

if (!isset($_SESSION)) {
    session_start();
}
// Function to add a product to the cart
function addToCart($productId) {
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = array();
    }

    // Add the product to the cart
    $_SESSION['cart'][] = $productId;

    // Return the updated cart count
    return count($_SESSION['cart']);
}

// Handle the request to add a product to the cart
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
    $productId = $_POST['product_id'];
    $cartCount = addToCart($productId);
    echo $cartCount;
}
?>
