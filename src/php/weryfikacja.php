NIE DZIALA
<?php
$conn = new mysqli("localhost", "root", "", "ecoride");

if ($conn->connect_error) {
    die("Połączenie nie powiodło się: " . $conn->connect_error);
}

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Sprawdzenie tokenu w bazie danych
    $stmt = $conn->prepare("SELECT id FROM uzytkownicy_rejestracja WHERE verification_token = ?");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Token istnieje, aktualizacja stanu weryfikacji
        $stmt->close();
        $stmt = $conn->prepare("UPDATE uzytkownicy_rejestracja SET email_verified = TRUE, verification_token = NULL WHERE verification_token = ?");
        $stmt->bind_param("s", $token);
        $stmt->execute();

        echo "Adres e-mail został zweryfikowany!";
    } else {
        echo "Nieprawidłowy token!";
    }
    $stmt->close();
} else {
    echo "Brak tokenu!";
}

$conn->close();
?>

ALTER TABLE uzytkownicy_rejestracja ADD COLUMN verification_token VARCHAR(255);
ALTER TABLE uzytkownicy_rejestracja ADD COLUMN email_verified BOOLEAN DEFAULT FALSE;


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

    if ($haslo !== $powtorzhaslo) {
        header("Location: ../index.html?error=Hasła nie pasują do siebie!");
        exit();
    }

    // Sprawdzenie, czy e-mail jest już używany
    $stmt = $conn->prepare("SELECT id FROM uzytkownicy_rejestracja WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        header("Location: ../index.html?error=Ten adres e-mail jest już używany!");
        exit();
    }

    // Haszowanie hasła
    $hashedPassword = password_hash($haslo, PASSWORD_DEFAULT);
    
    // Generowanie tokenu
    $token = bin2hex(random_bytes(16));

    // Przygotowanie zapytania SQL do wstawienia nowego użytkownika
    $stmt = $conn->prepare("INSERT INTO uzytkownicy_rejestracja (imie, email, haslo, verification_token) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $imie, $email, $hashedPassword, $token); 

    // Wykonanie zapytania
    if ($stmt->execute()) {
        // Wysyłanie e-maila z linkiem weryfikacyjnym
        $subject = "Weryfikacja adresu e-mail";
        $verification_link = "http://yourwebsite.com/weryfikacja.php?token=" . $token;
        $message = "Kliknij w ten link, aby zweryfikować swój adres e-mail: " . $verification_link;
        $headers = "From: no-reply@yourwebsite.com\r\n";

        mail($email, $subject, $message, $headers);

        header("Location: ../index.html?success=Rejestracja powiodła się! Zweryfikuj Swój Email wchodząc na pocztę!");
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
