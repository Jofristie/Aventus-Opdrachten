<?php
session_start();
include 'db_connect1.php';

// 1. Controleer of de gegevens uit het inlogformulier komen
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $wachtwoord = trim($_POST['wachtwoord']);

    // 2. Gebruik Prepared Statements om SQL-injectie te voorkomen
    $stmt = $conn->prepare("SELECT * FROM gebruikers WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();


if ($row = $result->fetch_assoc()) {
    if (password_verify($wachtwoord, $row['wachtwoord'])) {

        $_SESSION['gebruiker_id'] = $row['gebruiker_id'];
        $_SESSION['usertype'] = $row['usertype'];

        // Check voor admin account
        if ($row['usertype'] == 1) {
            header('Location: productBeheer.php');
        } else {
            header('Location: winkel.php');
        }
        exit;

    } else {
        header("Location: inlog.php?error=1");
        exit();
    }
} else {
    echo "Gebruiker niet gevonden.";
}
    
    $stmt->close();
}
$conn->close();
?>