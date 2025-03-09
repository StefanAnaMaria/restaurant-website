<?php
session_start();

$mysqli = require __DIR__ . "/../database.php";

// Obține produsele din baza de date
$sql = "SELECT products.*, categories.name AS category_name FROM products
        JOIN categories ON products.category_id = categories.id";
$result = $mysqli->query($sql);

$products = [];
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
} 

$category_id = isset($_GET['category']) ? $_GET['category'] : null;

// Interogare pentru a obține produsele din categoria specificată
$sql = "SELECT * FROM products WHERE category_id = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("i", $category_id);
$stmt->execute();
$result = $stmt->get_result();

$sql_categories = "SELECT * FROM categories";
$categories_result = $mysqli->query($sql_categories);
$categories = $categories_result->fetch_all(MYSQLI_ASSOC);
?>

<?php include '../components/header.php'; ?>   
<?php include '../components/navbar.php'; ?>   

<div class="container mt-5">
    <!-- Menu Header -->
    <div class="text-center mb-5">
        <h1>Meniul Nostru</h1>
        <p class="lead">Descoperiți preparatele noastre delicioase</p>
    </div>
    <div class="container my-5">
        <ul class="nav nav-tabs">
            <?php foreach ($categories as $category): ?>
                <li class="nav-item">
                    <a class="nav-link text-dark <?= $category['id'] == $category_id ? 'active' : '' ?>" 
                    href="meniu.php?category=<?= $category['id'] ?>">
                    <?= htmlspecialchars($category['name']) ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
    <div class="tab-content mt-3">
        <div class="tab-pane fade show active" id="category-<?= $category_id ?>">
            <div class="row">
                <?php while ($product = $result->fetch_assoc()): ?>
                    <div class="col-12 col-ms-6 col-md-6 col-lg-4 mb-4">
                        <div class="card h-100">
                            <img src="<?= htmlspecialchars($product['image_url']) ?>" 
                                 class="card-img-top menu-image" 
                                 alt="<?= htmlspecialchars($product['name']) ?>"
                                 onerror="this.onerror=null; this.src='../assets/imgcrop.jpg';">
                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($product['name']) ?></h5>
                                <p class="card-text"><?= htmlspecialchars($product['description']) ?></p>
                                <p class="card-text"><strong>Preț: <?= htmlspecialchars($product['price']) ?> Lei</strong></p>
                                <button class="btn btn-custom" 
                                        data-id="<?= $product['id'] ?>"
                                        data-name="<?= htmlspecialchars($product['name']) ?>"
                                        data-price="<?= $product['price'] ?>"
                                        onclick="addToCart(<?= $product['id'] ?>, '<?= htmlspecialchars($product['name']) ?>', <?= $product['price'] ?>)">
                                    Adaugă în coș
                                </button>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
    </div>
</div>


<?php include '../components/footer.php'; ?>
<script src="../js/cart.js"></script>
