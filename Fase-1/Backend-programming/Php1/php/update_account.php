<?php
session_start();
include 'db_connect1.php';
if (!isset($_SESSION['gebruiker_id'])) {
    header("Location: inlog.php");
    exit();
}

$gebruiker_id = $_SESSION['gebruiker_id'];
$naam = trim($_POST['naam']);
$email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
$nieuw_wachtwoord = $_POST['wachtwoord'];

if (!empty($nieuw_wachtwoord)) {
    // Wachtwoord aanpassen
    $hashed_wachtwoord = password_hash($nieuw_wachtwoord, PASSWORD_DEFAULT);
    $sql = "UPDATE gebruikers SET gebruikersnaam = ?, email = ?, wachtwoord = ? WHERE gebruiker_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "sssi", $naam, $email, $hashed_wachtwoord, $gebruiker_id);
} else {
    // Wachtwoord NIET aanpassen
    $sql = "UPDATE gebruikers SET gebruikersnaam = ?, email = ? WHERE gebruiker_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssi", $naam, $email, $gebruiker_id);
}

if (mysqli_stmt_execute($stmt)) {
    header("Location: account.php?success=1");
    exit();
} else {
    echo "Er is een fout opgetreden: " . mysqli_error($conn);
}
?>