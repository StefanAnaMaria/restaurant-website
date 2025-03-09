<?php
$is_invalid = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Include your database connection logic here
    $mysqli = require __DIR__ . "/../database.php";

    // Prepare and bind
    $stmt = $mysqli->prepare("INSERT INTO users (name, email, password_hash) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $_POST["name"], $_POST["email"], password_hash($_POST["password"], PASSWORD_DEFAULT));

    // Execute the statement
    if ($stmt->execute()) {
        // Redirect to login page or another page after successful registration
        header("Location: login.php");
        exit;
    } else {
        $is_invalid = true; // Handle error
    }
}

?>

<?php include '../components/header.php'; ?>   
<?php include '../components/navbar.php'; ?>   

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-12 px-5 col-sm-8 col-lg-6">
            <div class="card">
                <div class="card-body  px-md-3">
                    <h2 class="card-title text-center mb-4">Înregistrează-te</h2>

                    <?php if ($is_invalid): ?>
                        <div class="alert alert-danger">
                            A apărut o eroare la înregistrare. Te rugăm să încerci din nou.
                        </div>
                    <?php endif; ?>

                    <form method="post">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nume</label>
                            <input type="text" 
                                   class="form-control" 
                                   name="name" 
                                   id="name" 
                                   required>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" 
                                   class="form-control" 
                                   name="email" 
                                   id="email" 
                                   required>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Parolă</label>
                            <input type="password" 
                                   class="form-control" 
                                   name="password" 
                                   id="password" 
                                   required>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-outline-success btn-custom">Înregistrează-te</button>
                        </div>
                    </form>

                    <div class="mt-3 text-center">
                        <p>Ai deja un cont? <a href="login.php" class="custom-link">Conectează-te</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../components/footer.php'; ?> 