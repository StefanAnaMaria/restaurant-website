<?php
session_start();
require __DIR__ . '/../database.php'; // Conectarea la baza de date

// Mesaje de eroare sau succes
$success_message = $error_message = "";

if (!isset($_SESSION['user_id'])) {
   //var_dump($_SESSION); // Debugging
    echo "<div style='color: red; font-size: 18px; text-align: center;'>Please login to continue.</div>";
    exit();
}
//var_dump($_SESSION); // Debugging
$user_id = $_SESSION['user_id'];
if (isset($_GET['id'])) {
    $restaurant_id = $_GET['id'];
} else {
    $error_message = "Restaurantul nu a fost selectat.";
    echo $error_message;  // Arată mesajul de eroare
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Preluarea datelor din formular
    //$restaurant_id = $_GET[$restaurant['id']];
    $reservation_name = $_POST['name'];
    $phone = $_POST['phone'];
    $time = $_POST['reservation_date'];
    $number_of_people = $_POST['people_count'];
    $status = 'pending'; // Poți seta un status implicit, ex. "pending"

    // Validarea datelor
    if (empty($reservation_name) || empty($phone) || empty($time) || empty($number_of_people)) {
        $error_message = "Te rugăm să completezi toate câmpurile.";
    } elseif (!is_numeric($number_of_people) || $number_of_people < 1) {
        $error_message = "Numărul de persoane trebuie să fie un număr valid.";
    } else {
        // Inserarea datelor în baza de date
        $stmt = $mysqli->prepare("INSERT INTO reservations (reservation_name, phone, time , user_id, restaurant_id, number_of_people, status) VALUES (?, ?, ?, ?, ?, ?, ?)");
        
        // Legăm parametrii
        $stmt->bind_param("sssiiis", $reservation_name, $phone, $time, $user_id, $restaurant_id, $number_of_people, $status);
        if ($stmt->execute()) {
            $success_message = "Rezervarea a fost înregistrată cu succes!";
            $_SESSION['success_message'] = "Rezervarea a fost înregistrată cu succes! Veți primi un e-mail pentru confirmare.";
            header("Location: restaurante.php"); // Redirecționare după succes
            exit();
        } else {
            $error_message = "A apărut o eroare la salvarea rezervării.";
        }

        $stmt->close();
    }
}
?>

<?php include '../components/header.php'; ?>   
<?php include '../components/navbar.php'; ?>
<div class="container mt-5">
    <h2 class="text-center">Rezervă o masă</h2>
    <form action="" method="POST" class="my-4">
        <div class="mb-3">
            <label for="name" class="form-label">Nume</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="mb-3">
            <label for="phone" class="form-label">Telefon</label>
            <input type="text" class="form-control" id="phone" name="phone" required>
        </div>

        <div class="mb-3">
            <label for="reservation_date" class="form-label">Data și ora rezervării</label>
            <input type="datetime-local" class="form-control" id="reservation_date" name="reservation_date" required>
        </div>

        <div class="mb-3">
            <label for="people_count" class="form-label">Număr de persoane</label>
            <input type="number" class="form-control" id="people_count" name="people_count" min="1" required>
        </div>

        <button type="submit" class="btn btn-custom">Trimite rezervarea</button>
    </form>
</div> 
</div>
<?php include '../components/footer.php'; ?> 
