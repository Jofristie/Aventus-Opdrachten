<?php
include 'db_connect1.php';
session_start();
if (!isset($_SESSION['gebruiker_id']) || $_SESSION['usertype'] != 1) {
    die("Geen toegang");
}

$stmt = $conn->prepare("
INSERT INTO producten 
(naam, beschrijving, prijs, voorraad, afbeelding, aangemaakt_op) 
VALUES (?, ?, ?, ?, ?, NOW())
");
$stmt->bind_param("ssdis",
    $_POST['naam'],
    $_POST['beschrijving'],
    $_POST['prijs'],
    $_POST['voorraad'],
    $_POST['afbeelding'],
);

$stmt->execute();

header("Location: productBeheer.php");