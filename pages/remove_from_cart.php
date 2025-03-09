<?php
session_start(); // Start the session

// Check if the request is a POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the input data
    $data = json_decode(file_get_contents('php://input'), true);
    
    // Validate the data
    if (isset($data['id'])) {
        $productId = $data['id'];

        // Check if the cart exists in the session
        if (isset($_SESSION['cart']) && isset($_SESSION['cart'][$productId])) {
            // Remove the product from the cart
            unset($_SESSION['cart'][$productId]);

            // Calculate the new cart count
            $cartCount = isset($_SESSION['cart']) ? array_sum(array_column($_SESSION['cart'], 'quantity')) : 0;

            // Respond with success and the new cart count
            echo json_encode(['success' => true, 'cartCount' => $cartCount]);
        } else {
            // Product not found in the cart
            echo json_encode(['success' => false, 'message' => 'Product not found in cart.']);
        }
    } else {
        // Invalid data
        echo json_encode(['success' => false, 'message' => 'Invalid data.']);
    }
} else {
    // Invalid request method
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
?> 