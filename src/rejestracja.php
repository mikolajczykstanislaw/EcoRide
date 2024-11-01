<?php 
session_start(); // Rozpocznij sesję

$conn = new mysqli("localhost", "root", "", "ecoride");

if ($conn->connect_error) {
    die("Połączenie nie powiodło się: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $imie = $_POST['imie'];
    $email = $_POST['email'];
    $haslo = $_POST['haslo'];
    $powtorzhaslo = $_POST['powtorzhaslo'];

    // Sprawdzenie, czy hasła są zgodne
    if ($haslo !== $powtorzhaslo) {
        header("Location: ../index.html?error=Hasła nie pasują do siebie!");
        exit();
    }

    // Sprawdzenie, czy e-mail jest już używany
    $stmt = $conn->prepare("SELECT id FROM uzytkownicy WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        header("Location: ../index.html?error=Ten adres e-mail jest już używany!");
        exit();
    }

    // Haszowanie hasła
    $hashedPassword = password_hash($haslo, PASSWORD_DEFAULT);

    // Przygotowanie zapytania SQL do wstawienia nowego użytkownika
    $stmt = $conn->prepare("INSERT INTO uzytkownicy (imie, email, haslo) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $imie, $email, $hashedPassword); 

    // Wykonanie zapytania
    if ($stmt->execute()) {
        header("Location: ../index.html?success=Rejestracja powiodła się! Możesz się teraz zalogować.");
        exit();
    } else {
        header("Location: ../index.html?error=Błąd: " . $stmt->error);
        exit();
    }

}
// Zamknięcie przygotowanego zapytania
$stmt->close();

// Zamknięcie połączenia z bazą danych
$conn->close();
?>
