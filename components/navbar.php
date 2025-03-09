<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['cart']) || !is_array($_SESSION['cart'])) {
    $_SESSION['cart'] = [];  // Inițializează coșul de cumpărături dacă nu există
}
$_SESSION['cart_count'] = array_sum(array_column($_SESSION['cart'], 'quantity'));

// Respond with success and the number of products in the cart
$cartCount = $_SESSION['cart_count'];
?>
<nav class="navbar navbar-expand-lg navbar-custom sticky-top">
        <div class="container-fluid mx-3">
            <!-- Logo Tag -->
            <a class="navbar-brand ms-4" href="<?php echo BASE_URL; ?>/pages/home.php">
                <img src="../assets/logo2.png" alt="Logo" height="80">
            </a>

            <!-- Cart Icon -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
            <div class="d-flex flex-column flex-lg-row w-100 ">
                <ul class="navbar-nav text-start flex-grow-1 d-flex justify-content-lg-start mb-0">
                    <li class="nav-item">
                        <a class="nav-link me-2" href="<?php echo BASE_URL; ?>/pages/home.php">Acasa</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link me-2" href="<?php echo BASE_URL; ?>/pages/meniu.php">Meniu</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link me-2" href="<?php echo BASE_URL; ?>/pages/restaurante.php">Restaurante</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link me-2" href="<?php echo BASE_URL; ?>/pages/evenimente.php">Evenimente</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link me-2" href="<?php echo BASE_URL; ?>/pages/contact.php">Contact</a>
                    </li>
                </ul>
                <!-- Login/Logout and Cart Buttons -->
                <div class="d-flex align-items-center mr-3">
                    <?php if (isset($_SESSION["user_id"])): ?>
                        <span class="me-1">Bine ai venit, <?= htmlspecialchars($_SESSION["user_name"]) ?>!</span>
                        <a class="btn btn-outline-danger mx-2 rounded-pill" href="<?php echo BASE_URL; ?>/pages/logout.php">Logout</a>
                    <?php else: ?>
                        <a class="btn btn-custom me-2" href="<?php echo BASE_URL; ?>/pages/login.php">Login</a>
                    <?php endif; ?>
                    <!-- Cart Icon -->
                    <div class="position-relative">
                        <a class="btn btn-custom" href="<?php echo BASE_URL; ?>/pages/cart.php">
                            <i class="bi bi-cart"></i>
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-success cart-badge"><?php echo $cartCount; ?></span>
                        </a>
                        <!-- Notification Element -->
                        <div id="cartNotification" class="notification" style="display: none; position: absolute; top: -10px; right: 0; background-color: #28a745; color: white; padding: 5px 10px; border-radius: 5px; z-index: 1050;min-width: 130px">
                            Produs adăugat în coș!
                        </div> 
                    </div>
                </div>
            </div>
            </div>
        </div>
    </nav>