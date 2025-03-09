<?php
session_start();

// Conexiunea la baza de date
$mysqli = require __DIR__ . "/../database.php";

// Preluare restaurante din baza de date
$sql = "SELECT * FROM restaurants";
$result = $mysqli->query($sql);
$restaurants = $result->fetch_all(MYSQLI_ASSOC);

// Separare restaurante după tip
$regular_restaurants = array_slice($restaurants, 0, 3);
$event_restaurants = array_slice($restaurants, 3);
?>

<?php include '../components/header.php'; ?>   
<?php include '../components/navbar.php'; ?>   

<body onload="initMap()">

<div class="container mt-5">
<?php if (isset($_SESSION['success_message']) || isset($_SESSION['error_message'])): ?>
        <div id="messageDiv" class="alert <?php echo isset($_SESSION['success_message']) ? 'alert-success' : 'alert-danger'; ?>">
            <?php echo isset($_SESSION['success_message']) ? $_SESSION['success_message'] : $_SESSION['error_message']; ?>
        </div>

        <script>
            // Afișează mesajul și ascunde-l după 10 secunde
            setTimeout(function() {
                var messageDiv = document.getElementById("messageDiv");
                messageDiv.style.display = "none";
            }, 10000); // 10 secunde
        </script>

        <?php 
            // Elimină mesajul după ce a fost afișat
            unset($_SESSION['success_message']);
            unset($_SESSION['error_message']);
        ?>
    <?php endif; ?>
    <!-- Restaurante Generale -->
    <div class="section-divider mb-5">
        <div class="text-center mb-5">
            <h1>Restaurantele Noastre</h1>
            <p class="lead">Găsiți restaurantul perfect pentru o masă memorabilă</p>
        </div>

        <div class="row">
            <?php foreach ($restaurants as $restaurant): ?>
                <div class="col-12 col-md-6 col-lg-4 mb-4">
                    <div class="card h-100">
                        <img src="<?php echo htmlspecialchars($restaurant['image_path']); ?>" 
                             class="card-img-top" 
                             alt="<?php echo htmlspecialchars($restaurant['name']); ?>"
                             style="height: 200px; object-fit: cover;">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title mb-4"><?php echo htmlspecialchars($restaurant['name']); ?></h5>
                            <p class="card-text">
                                <span class="d-block mb-3"><i class="bi bi-geo-alt"></i> <?php echo htmlspecialchars($restaurant['address']); ?></span>
                                <span class="d-block mb-3"><i class="bi bi-telephone"></i> <?php echo htmlspecialchars($restaurant['phone']); ?></span>
                                <span class="d-block mb-3"><i class="bi bi-envelope"></i> <?php echo htmlspecialchars($restaurant['email']); ?></span>
                                <span class="d-block mb-3"><i class="bi bi-clock"></i> <?php echo htmlspecialchars($restaurant['opening_hours']); ?></span>
                            </p>
                            <div class="mt-auto d-flex flex-wrap gap-3">
                                <div class="d-flex flex-grow-1">
                                    <button class="btn btn-custom w-100" onclick="window.location.href='reservation.php?id=<?php echo $restaurant['id']; ?>'">
                                        Rezervă masă
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<?php include '../components/footer.php'; ?>