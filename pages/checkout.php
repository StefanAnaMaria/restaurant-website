<?php
session_start();
include '../components/header.php';
include '../components/navbar.php';
require '../database.php'; // Ensure you include your database connection

// Verifică dacă utilizatorul este logat
if (!isset($_SESSION['user_id'])) {
    echo "<div style='color: red; font-size: 18px; text-align: center;'>Please login to continue.</div>";
    //header("Location: login.php");
    exit; // Asigură-te că ieși din script după redirecționare
}

// Check if the cart is empty
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    exit;
}

// Calculate the total price
$totalPrice = array_sum(array_column($_SESSION['cart'], 'price'));

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get the form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $termsAccepted = isset($_POST['terms']);
    $emailUsageAccepted = isset($_POST['email_usage']);

    // Insert the order into the orders table
    $stmt = $mysqli->prepare("INSERT INTO orders (user_id, total_amount, status) VALUES (?, ?, ?)");
    $userId = $_SESSION['user_id'] ?? null; // Assuming you have user_id in session
    $status = 'pending'; // Set the initial status
    $stmt->bind_param("ids", $userId, $totalPrice, $status);
    $stmt->execute();
    $orderId = $stmt->insert_id; // Get the last inserted order ID

    // Insert each item into the order_items table
    //var_dump($_SESSION['cart']); // Verifică conținutul coșului
    foreach ($_SESSION['cart'] as $item) {
        // Verifică dacă ID-ul produsului este setat
        if (!isset($item['quantity'], $item['price'], $item['id']) || !is_numeric($item['id']) || !is_numeric($item['quantity']) || !is_numeric($item['price'])) {
            echo "Produs invalid: " . htmlspecialchars($item['name'] ?? 'necunoscut') . "<br>";
            continue;
        }
    
        // Pregătește și execută query-ul pentru inserare
        $stmt = $mysqli->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
        if (!$stmt) {
            echo "Eroare la pregătirea query-ului: " . $mysqli->error . "<br>";
            continue;
        }
    
        // Folosește ID-ul din $item
        $stmt->bind_param("iiid", $orderId, $item['id'], $item['quantity'], $item['price']);
        if (!$stmt->execute()) {
            echo "Error inserting order item: " . $stmt->error . " with product_id: " . $item['id'];
        }
    }

    // Clear the cart
    unset($_SESSION['cart']);

    // Redirect to the confirmation page
    header("Location: order_confirmation.php");
    exit;
}
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
    <h2 class="text-center mb-3">Finalizare Comandă</h2>
    <div class="row justify-content-center">
    <div class="col-12 px-3 col-sm-10">
        <h4>Informații de livrare:</h4>
        <form method="post" action=""> 
            <div class="mb-3">
                <label for="name" class="form-label">Nume</label>
                <input type="text" class="form-control" name="name" id="name" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" name="email" id="email" required>
            </div>
            <div class="mb-3">
                <label for="address" class="form-label">Adresă de livrare</label>
                <input type="text" class="form-control" name="address" id="address" required>
            </div>
            <!-- Agreement Checkboxes -->
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="terms" id="terms" required>
                <label class="form-check-label" for="terms">
                    Sunt de acord cu <a href="terms.php" target="_blank">Termeni şi condiţii</a> şi <a href="privacy.php" target="_blank">Politica de confidenţialitate</a>
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="email_usage" id="email_usage">
                <label class="form-check-label" for="email_usage">
                    Sunt de acord ca adresa mea de e-mail să fie folosită pentru comunicări comerciale viitoare
                </label>
            </div>

            <div class="text-left m-3">
                <button type="submit" class="btn btn-custom">Confirmă Comanda</button>
            </div>
        </form>
    </div>   </div> 
    </div>
</div>
<?php include '../components/footer.php'; ?>