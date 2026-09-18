<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bestelling bevestigd</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600&family=DM+Sans:wght@400;500&display=swap" rel="stylesheet">
    <style>
        body { background:#f4f1ec; font-family:'DM Sans',sans-serif; min-height:100vh; display:flex; align-items:center; justify-content:center; }
        .confirm-card { border:none; border-radius:20px; box-shadow:0 8px 40px rgba(0,0,0,.10); max-width:460px; width:100%; }
        .icon-circle { width:72px; height:72px; border-radius:50%; background:#d1fae5; display:flex; align-items:center; justify-content:center; font-size:2rem; margin:0 auto; }
        .page-title { font-family:'Playfair Display',serif; }
    </style>
</head>
<body>
<?php
session_start();
include 'db_connect1.php';

if (!isset($_SESSION['gebruiker_id'])) {
    die("Je moet ingelogd zijn om een bestelling te plaatsen!");
}

$gebruikers_id = $_SESSION['gebruiker_id'];
$totaalPrijs = 0.0;

foreach ($_POST as $key => $value) {
    if (strpos($key, 'product_') === 0 && (int)$value > 0) {
        $product_id = (int) str_replace('product_', '', $key);
        $aantal = (int) $value;
        $stmt = $conn->prepare("SELECT prijs FROM producten WHERE product_id = ?");
        $stmt->bind_param("i", $product_id);
        $stmt->execute();
        $stmt->bind_result($prijs);
        if ($stmt->fetch()) { $totaalPrijs += $prijs * $aantal; }
        $stmt->close();
    }
}

$stmt = $conn->prepare("INSERT INTO bestellingen (gebruiker_id, totaal_prijs) VALUES (?, ?)");
$stmt->bind_param("id", $gebruikers_id, $totaalPrijs);
$stmt->execute();
$bestelling_id = $conn->insert_id;
$stmt->close();

foreach ($_POST as $key => $value) {
    if (strpos($key, 'product_') === 0 && (int)$value > 0) {
        $product_id = (int) str_replace('product_', '', $key);
        $aantal = (int) $value;
        $stmt = $conn->prepare("INSERT INTO bestelling_producten (bestelling_id, product_id, aantal) VALUES (?, ?, ?)");
        $stmt->bind_param("iii", $bestelling_id, $product_id, $aantal);
        $stmt->execute(); $stmt->close();
        $stmt = $conn->prepare("UPDATE producten SET voorraad = voorraad - ? WHERE product_id = ?");
        $stmt->bind_param("ii", $aantal, $product_id);
        $stmt->execute(); $stmt->close();
    }
}
$conn->close();
?>

<div class="confirm-card card p-5 text-center mx-auto">
    <h2 class="page-title mb-2">Bestelling geplaatst!</h2>
    <p class="text-muted mb-1">Bedankt voor je aankoop.</p>
    <p class="fw-bold mb-4" style="font-size:1.1rem;">Bestelnummer: #<?php echo $bestelling_id; ?></p>
    <p class="text-muted mb-4" style="font-size:.9rem;">Totaalbedrag: <strong>€<?php echo number_format($totaalPrijs, 2); ?></strong></p>
    <div class="d-flex gap-2 justify-content-center">
        <a href="winkel.php" class="btn btn-dark px-4" style="border-radius:10px;">← Terug naar winkel</a>
        <a href="winkelwagen.php" class="btn btn-outline-secondary px-4" style="border-radius:10px;">Mijn bestellingen</a>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>