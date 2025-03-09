<?php
session_start();

//Check if the request is a POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    // Validate the data
    if (
        isset($data['id'], $data['name'], $data['price']) &&
        is_numeric($data['id']) &&
        is_string($data['name']) &&
        is_numeric($data['price'])
    ) {
        $productId = (int)$data['id'];
        $productName = $data['name'];
        $productPrice = (float)$data['price'];

        // Default quantity (can be overridden if provided)
        $productQuantity = isset($data['quantity']) && is_numeric($data['quantity']) && $data['quantity'] > 0 
            ? (int)$data['quantity'] 
            : 1;

        // Initialize the cart if it doesn't exist
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
        else{
            $_SESSION['cart_count'] = array_sum($_SESSION['cart']);
        }

        // Add the product to the cart
        if (isset($_SESSION['cart'][$productId])) {
            $_SESSION['cart'][$productId]['quantity'] += $productQuantity; // Increase quantity
        } else {
            $_SESSION['cart'][$productId] = [
                'name' => $productName,
                'price' => $productPrice,
                'quantity' => $productQuantity,
                'id' => $productId
            ];
        }

        // Respond with success and the number of products in the cart
        //$cartCount = array_sum(array_column($_SESSION['cart'], 'quantity'));
        $_SESSION['cart_count'] = array_sum(array_column($_SESSION['cart'], 'quantity'));

        // Respond with success and the number of products in the cart
        $cartCount = $_SESSION['cart_count'];
        echo json_encode(['success' => true, 'cartCount' => $cartCount]);
    } else {
        // Invalid data
        echo json_encode(['success' => false, 'message' => 'Invalid input data']);
    }
} else {
    // Invalid request method
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}

?>
