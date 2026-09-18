<?php
include 'db_connect1.php';

$naam = $_POST['naam'];
$email = $_POST['email'];
$admin = isset($_POST['admin_account']) ? 1 : 0;
$wachtwoord = password_hash($_POST['wachtwoord'], PASSWORD_DEFAULT);

$sql = "INSERT INTO gebruikers (gebruikersnaam, email, usertype, wachtwoord) VALUES ('$naam', '$email', '$admin', '$wachtwoord')";

if ($conn->query($sql) === TRUE) {
    echo "Registratie succesvol!";
    header('Location: inlog.php'); // Doorverwijzen naar inlogpagina
} else {
    echo "Fout: " . $sql . "<br>" . $conn->error;
}
$conn->close();
?>