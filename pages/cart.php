<?php
session_start();
include '../components/header.php';
include '../components/navbar.php';
// Funcție de inițializare a coșului, adăugare produs, etc.
// function initCart() {
//     if (!isset($_SESSION['cart'])) {
//         $_SESSION['cart'] = []; // Inițializează un coș gol
//     }

//     // Actualizează numărul total de produse în coș
//     $_SESSION['cart_count'] = array_sum($_SESSION['cart']);
// }

// function addToCart($product_id, $quantity) {
//     // Verifică dacă produsul există deja în coș
//     if (isset($_SESSION['cart'][$product_id])) {
//         $_SESSION['cart'][$product_id] += $quantity; // Actualizează cantitatea
//     } else {
//         $_SESSION['cart'][$product_id] = $quantity; // Adaugă produsul în coș
//     }

//     // Actualizează contorul total al produselor din coș
//     $_SESSION['cart_count'] = array_sum($_SESSION['cart']);
// }

// function getCartCount() {
//     // Returnează numărul de produse din coș
//     return isset($_SESSION['cart_count']) ? $_SESSION['cart_count'] : 0;
// }

// // Apelează funcția pentru a inițializa coșul pe fiecare pagină
// initCart();

?>

<div class="container my-5">
    <div class="d-flex justify-content-center mb-4">
        <a href="cart.php" class="me-3">
            <i class="fas fa-arrow-left fa-lg" style="color: gray;"></i>
        </a>
        <a href="checkout.php" class="ms-3">
            <i class="fas fa-arrow-right fa-lg" style="color: gray;"></i>
        </a>
    </div>
    <div class="row justify-content-center">
    <div class="col-12 px-3 col-sm-10">
    <h2 class="text-center">Coșul meu de cumpărături</h2>
    <div id="cart-items" class="mt-4">
        <?php if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])): ?>
            <div class="table-responsive mb-3">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Produs</th>
                            <th>Preț</th>
                            <th>Cantitate</th>
                            <th>Total</th>
                            <th>Acțiuni</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($_SESSION['cart'] as $id => $item): ?>
                            <tr>
                                <td><?= htmlspecialchars($item['name']) ?></td>
                                <td class="price-<?= $id ?>"><?= htmlspecialchars($item['price']) ?> Lei</td>
                                <td>
                                    <div class="d-flex align-items-center justify-content-center">
                                        <button class="btn btn-sm btn-secondary me-1 fixed-width-button" onclick="updateQuantity('<?= $id ?>', -1)">-</button>
                                        <span id="quantity-<?= $id ?>" class="mx-2"><?= htmlspecialchars($item['quantity']) ?></span>
                                        <button class="btn btn-sm btn-secondary ms-1 fixed-width-button" onclick="updateQuantity('<?= $id ?>', 1)">+</button>
                                    </div>
                                </td>
                                <td class="total-<?= $id ?>"><?= htmlspecialchars($item['price'] * $item['quantity']) ?> Lei</td>
                                <td>
                                    <button class="btn btn-danger btn-sm" onclick="removeFromCart('<?= $id ?>')">Șterge</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <h4>Total: <span id="overall-total"><?= htmlspecialchars(array_sum(array_column($_SESSION['cart'], 'price')) ) ?> Lei</span></h4>
            <div class="d-flex flex-wrap justify-content-start mt-3">
                <a href="meniu.php" class="btn btn-custom me-3 mt-2">Continuă Cumpărăturile</a>
                <a href="checkout.php" class="btn btn-custom mt-2">Finalizează Comanda</a>
            </div>
        <?php else: ?>
            <p>Coșul este gol.</p>
        <?php endif; ?>
    </div></div></div>
</div>

<script src="../js/cart.js"></script>
<?php include '../components/footer.php'; ?> 