<?php
session_start();

if (isset($_SESSION["user_id"])) {
    $mysqli = require __DIR__ . "/../database.php";
    
    $sql = "SELECT * FROM users
            WHERE id = {$_SESSION["user_id"]}";
            
    $result = $mysqli->query($sql);
    $user = $result->fetch_assoc();
}

if (isset($_SESSION["user_id"])) {
    // Preluăm user_id din sesiune
    $user_id = $_SESSION["user_id"];

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // Preluăm subiectul și mesajul
        $subject = $_POST["subject"];
        $message = $_POST["message"];

        // Validăm datele
        if (empty($subject) || empty($message)) {
            $error_message = "Te rugăm să completezi toate câmpurile.";
        } else {
            // Inserăm mesajul în baza de date
            $stmt = $mysqli->prepare("INSERT INTO contact_form (user_id, subject, message) VALUES (?, ?, ?)");
            $stmt->bind_param("iss", $user_id, $subject, $message);

            if ($stmt->execute()) {
                $_SESSION['success_message'] = "Mulțumim pentru feedback! Vom răspunde în cel mai scurt timp.";
            } else {
                $_SESSION['error_message'] = "A apărut o eroare la trimiterea mesajului.";
            }

            $stmt->close();
        }
    }
} else {
    $error_message = "Te rugăm să te autentifici pentru a trimite un mesaj.";
}
?>
<?php include '../components/header.php'; ?>
<?php include '../components/navbar.php'; ?>   


<div class="container my-5">
    <div class="row justify-content-center">
    <div class="col-12 px-5 col-sm-10"> 
        <h1 class="text-center mb-3" >Informatii de contact</h1>
     <!-- Rând cu 3 coloane pentru informații de contact -->
    <div class="row">
        <div class="col-lg-4 col-md-6 col-12 mb-3">
            <div class="card contact-box" style="height: 200px;">
                <div class="card-body text-center">
                    <i class="fas fa-map-marker-alt fa-2x mb-2"></i>
                    <h5 class="card-title">Locația</h5>
                    <a href=https://www.google.com/maps/dir/44.9310597,26.0201254/Strada+Bob%C3%A2lna+52,+Ploie%C8%99ti/" class="custom-link">Strada Bobalna, Nr.10, Ploiesti, Romania
                    </a>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 col-12 mb-3">
            <div class="card contact-box" style="height: 200px;">
                <div class="card-body text-center">
                    <i class="fas fa-phone-alt fa-2x mb-2"></i>
                    <h5 class="card-title">Număr de Telefon</h5>
                    <a href="tel:+40123456789" class="custom-link">+40123456789</a>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 col-12 mb-3">
            <div class="card contact-box" style="height: 200px;">
                <div class="card-body text-center">
                    <i class="fas fa-envelope fa-2x mb-2"></i>
                    <h5 class="card-title">Adresă de Email</h5>
                    <a href="mailto:contact@exemplu.com" class="custom-link">contact@exemplu.com</a>
                </div>
            </div>
        </div>
    </div>
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

    <H4 class="mb-3">Dacă ai întrebări, te rugăm să completezi formularul de mai jos:</H4>

    <form action="contact.php" method="post">
        <div class="mb-3">
            <label for="subject" class="form-label">Subiect</label>
            <input type="text" class="form-control" id="subject" name="subject" required>
        </div>
        <div class="mb-3">
            <label for="message" class="form-label">Mesaj</label>
            <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
        </div>
        <button type="submit" class="btn btn-custom">Trimite</button>
    </form>
</div>
</div> 
</div>
<?php include '../components/footer.php'; ?>