<?php 
session_start(); // Rozpocznij sesję

$conn = new mysqli("localhost", "root", "", "ecoride");

if ($conn->connect_error) {
    die("Połączenie nie powiodło się: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = $_POST['email'];
    $haslo = $_POST['haslo'];

    // Przygotowanie zapytania SQL do pobrania użytkownika
    $stmt = $conn->prepare("SELECT id, imie, haslo FROM uzytkownicy WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    // Sprawdzenie, czy użytkownik istnieje
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $imie, $hashedPassword);
        $stmt->fetch();

        // Weryfikacja hasła
        if (password_verify($haslo, $hashedPassword)) {
            // Zalogowano pomyślnie - zapisz dane w sesji
            $_SESSION['user_id'] = $id;
            $_SESSION['user_imie'] = $imie; // Zapisz imię użytkownika w sesji
            header("Location: panel.php?success-login=Zalogowano pomyślnie!");
            exit();
        } else {
            // Błędne hasło
            header("Location: ../index.html?error-login=Błędne hasło!");
            exit();
        }
    } else {
        // Użytkownik nie istnieje
        header("Location: ../index.html?error-login=Nie znaleziono użytkownika z tym adresem e-mail!");
        exit();
    }

    $stmt->close();
}

// Zamknięcie połączenia z bazą danych
$conn->close();
?>
