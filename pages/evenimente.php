<?php
// Include the database connection
session_start();
include '../database.php'; // Adjust the path as necessary

$result = $mysqli->query("SELECT * FROM events");
?>
<?php include '../components/header.php'; ?>   
<?php include '../components/navbar.php'; ?>   

<div class="container mt-5">
    <div class="section-divider mb-5">
        <div class="text-center mb-5">
            <h1>Evenimentele Noastre</h1>
            <p class="lead">Găsiți restaurantul perfect pentru o masă memorabilă</p>
        </div>

        <div class="row">
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="col-lg-4 col-md-6 col-12 mb-4">
                    <div class="card h-100">
                        <img src="<?php echo htmlspecialchars($row['image']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($row['title']); ?>">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title"><?php echo htmlspecialchars($row['title']); ?></h5>
                            <p class="card-text">
                                <i class="bi bi-calendar-event"></i> <?php echo htmlspecialchars(date("d M Y", strtotime($row['date']))); ?><br>
                                <i class="bi bi-clock"></i> <?php echo htmlspecialchars($row['time']); ?><br>
                                <i class="bi bi-geo-alt"></i> <?php echo htmlspecialchars($row['location']); ?>
                            </p>
                            <p class="card-text"><?php echo htmlspecialchars($row['description']); ?></p>
                            <p class="card-text"><strong>Preț: <?php echo htmlspecialchars($row['price']); ?> Lei/persoană</strong></p>
                            <div class="d-flex flex-grow-1"
                                ><button class="btn btn-custom mt-auto">Suna acum</button>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div> 
    </div>
</div> 
<?php include '../components/footer.php'; ?>

