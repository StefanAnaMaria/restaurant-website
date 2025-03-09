<?php

session_start();

$is_invalid = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    $mysqli = require __DIR__ . "/../database.php";
    
    $sql = sprintf("SELECT * FROM users
                    WHERE email = '%s'",
                   $mysqli->real_escape_string($_POST["email"]));
    
    $result = $mysqli->query($sql);
    
    $user = $result->fetch_assoc();
    
    if ($user && password_verify($_POST["password"], $user["password_hash"])) {
        $_SESSION["user_id"] = $user["id"];
        $_SESSION["user_name"] = $user["name"];

        header("Location: home.php");
        exit;
    } else {
        $is_invalid = true;
    }
}

?>

<?php include '../components/header.php'; ?>   
<?php include '../components/navbar.php'; ?>   

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-12 px-5 col-sm-8 col-lg-6">
            <div class="card">
                <div class="card-body px-md-3">
                    <h2 class="card-title text-center mb-4">Conectează-te</h2>

                    <?php if ($is_invalid): ?>
                        <div class="alert alert-danger">
                            Invalid login
                        </div>
                    <?php endif; ?>

                    <form method="post">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" 
                                   class="form-control" 
                                   name="email" 
                                   id="email"
                                   value="<?= htmlspecialchars($_POST["email"] ?? "") ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Parolă</label>
                            <input type="password" 
                                   class="form-control" 
                                   name="password" 
                                   id="password" required>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-outline-success btn-custom">Conectează-te</button>
                        </div>
                    </form>

                    <div class="mt-3 text-center">
                        <p>Nu ai cont? <a href="signup.php" class="custom-link">Înregistrează-te</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../components/footer.php'; ?> 