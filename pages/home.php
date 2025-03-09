<?php
session_start();

if (isset($_SESSION["user_id"])) {
    $mysqli = require __DIR__ . "/../database.php";
    
    $sql = "SELECT * FROM users
            WHERE id = {$_SESSION["user_id"]}";
            
    $result = $mysqli->query($sql);
    $user = $result->fetch_assoc();
}
// Conectare la baza de date
$mysqli = require __DIR__ . "/../database.php";

// Interogare pentru a obține produsele cu ID-urile 1, 9 și 13
$sql = "SELECT * FROM products WHERE id IN (1, 9, 13)";
$result = $mysqli->query($sql);

?>


<?php include '../components/header.php'; ?>   
<?php include '../components/navbar.php'; ?>   

<!-- Hero Section with Carousel -->
<div id="heroCarousel" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-indicators">
        <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active"></button>
        <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1"></button>
        <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="2"></button>
    </div>
    
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="https://images.pexels.com/photos/67468/pexels-photo-67468.jpeg" class="d-block w-100" alt="Restaurant Interior">
            <div class="carousel-caption">
                <h1>Bine ați venit la Restaurantul Nostru</h1>
                <?php if (isset($user)): ?>
                    <p class="lead">Bună, <?= htmlspecialchars($user["name"]) ?>! Ne bucurăm să vă revedem.</p>
                <?php else: ?>
                    <p class="lead">Descoperiți gusturile autentice și atmosfera primitoare</p>
                <?php endif; ?>
            </div>
        </div>
        <div class="carousel-item">
            <img src="https://images.pexels.com/photos/262978/pexels-photo-262978.jpeg" class="d-block w-100" alt="Fine Dining">
            <div class="carousel-caption">
                <h2>Bucătărie Rafinată</h2>
                <p>Preparate delicioase create cu pasiune</p>
            </div>
        </div>
        <div class="carousel-item">
            <img src="https://images.pexels.com/photos/260922/pexels-photo-260922.jpeg" class="d-block w-100" alt="Restaurant Atmosphere">
            <div class="carousel-caption">
                <h2>Atmosferă Unică</h2>
                <p>O experiență culinară de neuitat</p>
            </div>
        </div>
    </div>
    
    <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>

<div class="bg-white py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 col-md-12">
                <img src="https://images.pexels.com/photos/2544829/pexels-photo-2544829.jpeg" alt="Restaurant Interior" class="img-fluid rounded shadow-lg about-image">
            </div>
            <div class="col-lg-6 col-md-12">
                <div class="ps-md-4">
                    <h2 class="display-4 mt-4 mb-2 text-lg-start text-center">Povestea Noastră</h2>
                    <p class="lead mb-5 text-lg-start text-center">O tradiție de excelență culinară din 2003</p>
                    <p class="mb-4">Cu o istorie bogată de peste 20 de ani în arta gastronomiei, restaurantul nostru s-a remarcat constant prin calitatea excepțională a preparatelor și serviciilor oferite. Într-un ambient elegant și primitor, bucătarii noștri cu experiență internațională combină tehnici tradiționale cu inovația culinară modernă pentru a crea experiențe gastronomice memorabile.</p>
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <ul class="list-unstyled">
                                <li class="mb-2">
                                    <i class="bi bi-check-circle-fill text-success me-2"></i>
                                    Ingrediente premium
                                </li>
                                <li class="mb-2">
                                    <i class="bi bi-check-circle-fill text-success me-2"></i>
                                    Bucătari premiați
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <ul class="list-unstyled">
                                <li class="mb-2">
                                    <i class="bi bi-check-circle-fill text-success me-2"></i>
                                    Atmosferă elegantă
                                </li>
                                <li class="mb-2">
                                    <i class="bi bi-check-circle-fill text-success me-2"></i>
                                    Service impecabil
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<!-- Discover Section - Updated Title -->
<div class="bg-beige py-5">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center mb-4">
                <h2 class="display-4">Descoperă</h2>
                <p class="lead mb-5">Explorează lumea noastră culinară</p>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card h-100 shadow-sm hover-card">
                    <img src="https://images.pexels.com/photos/1267320/pexels-photo-1267320.jpeg" class="card-img-top" alt="Meniul Zilei">
                    <div class="card-body text-center">
                        <h5 class="card-title fw-bold">Meniul Zilei</h5>
                        <p class="card-text">Specialități pregătite cu ingrediente proaspete și pasiune.</p>
                        <a href="<?php echo BASE_URL; ?>/pages/meniu.php" class="btn btn-outline-primary btn-custom">Vezi Meniul</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card h-100 shadow-sm hover-card">
                    <img src="../assets/imgR.jpeg" class="card-img-top" alt="Evenimente Speciale" style="height: 200px; object-fit: cover;">
                    <div class="card-body text-center">
                        <h5 class="card-title fw-bold">Evenimente Speciale</h5>
                        <p class="card-text">Organizăm evenimente memorabile într-un cadru elegant și primitor.</p>
                        <a href="<?php echo BASE_URL; ?>/pages/evenimente.php" class="btn btn-outline-primary btn-custom">Vezi Evenimente</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card h-100 shadow-sm hover-card">
                    <img src="https://images.pexels.com/photos/6267/menu-restaurant-vintage-table.jpg" class="card-img-top" alt="Locații" style="height: 200px; object-fit: cover;">
                    <div class="card-body text-center">
                        <h5 class="card-title fw-bold">Locații</h5>
                        <p class="card-text">Descoperă restaurantele noastre în cele mai frumoase zone ale orașului.</p>
                        <a href="<?php echo BASE_URL; ?>/pages/restaurante.php" class="btn btn-outline-primary btn-custom">Vezi Locații</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chef's Recommendation Section -->
<div class="bg-dark text-white py-5">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center mb-4">
                <h2 class="display-4">Recomandările Șefului</h2>
                <p class="lead">Preparate speciale create cu măiestrie</p>
            </div>
        </div>
        <div class="row">
                <?php if ($result->num_rows > 0): ?>
                <?php while ($product = $result->fetch_assoc()): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card bg-dark text-white border-light">
                            <a href="meniu.php?category=<?= htmlspecialchars($product['category_id']) ?>" class="text-decoration-none text-white"> <!-- Link către categoria din meniu -->
                                <img src="<?= htmlspecialchars($product['image_url']) ?>" class="card-img-top" alt="<?= htmlspecialchars($product['name']) ?>">
                                <div class="card-body text-center">
                                    <h5 class="card-title"><?= htmlspecialchars($product['name']) ?></h5>
                                    <p class="card-text"><?= htmlspecialchars($product['description']) ?></p>
                                </div>
                            </a>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>Nu sunt produse recomandate în acest moment.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Mission Statement Section -->
<div class="bg-white py-5">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <h2 class="display-4 mb-4">Valorile Noastre</h2>
                <p class="lead mb-4">Să oferim clienților noștri o experiență culinară autentică și memorabilă</p>
                <div class="row justify-content-center">
                    <div class="col-md-4 mb-4">
                        <div class="text-center">
                            <i class="bi bi-heart-fill text-danger fs-1"></i>
                            <h4 class="mt-3">Pasiune</h4>
                            <p>Gătim cu dragoste și dedicare</p>
                        </div>
                    </div>
                    <div class="col-md-4 mb-4">
                        <div class="text-center">
                            <i class="bi bi-award-fill text-warning fs-1"></i>
                            <h4 class="mt-3">Calitate</h4>
                            <p>Folosim doar ingrediente premium</p>
                        </div>
                    </div>
                    <div class="col-md-4 mb-4">
                        <div class="text-center">
                            <i class="bi bi-people-fill text-primary fs-1"></i>
                            <h4 class="mt-3">Comunitate</h4>
                            <p>Creăm legături prin mâncare bună</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

             
<!-- Testimonials Section -->
<div class="bg-white py-5">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center mb-4">
                <h2 class="display-4">Ce Spun Clienții Noștri</h2>
                <p class="lead">Experiențe autentice ale oaspețiilor noștri</p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow">
                    <div class="card-body">
                        <div class="text-warning mb-3">
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                        </div>
                        <p class="card-text">"O experiență culinară deosebită! Mâncarea este excelentă, iar serviciile sunt impecabile."</p>
                        <footer class="blockquote-footer">Maria P.</footer>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow">
                    <div class="card-body">
                        <div class="text-warning mb-3">
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                        </div>
                        <p class="card-text">"Cel mai bun restaurant din oraș! Recomand cu încredere pentru orice ocazie specială."</p>
                        <footer class="blockquote-footer">Alexandru M.</footer>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow">
                    <div class="card-body">
                        <div class="text-warning mb-3">
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                        </div>
                        <p class="card-text">"Atmosferă minunată, mâncare delicioasă și personal foarte amabil. Vom reveni cu siguranță!"</p>
                        <footer class="blockquote-footer">Elena D.</footer>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php include '../components/footer.php'; ?> 