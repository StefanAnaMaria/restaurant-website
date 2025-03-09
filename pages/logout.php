<?php

session_start();

// Clear user-related session variables
unset($_SESSION['user_id']);
unset($_SESSION['user_name']);

// Optionally, keep the cart intact
// unset($_SESSION['cart']); // Uncomment this line if you want to clear the cart on logout

// Redirect to the referring page or default to login.php if not available
$redirectUrl = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'login.php';
header("Location: home.php");
exit;
?> 
